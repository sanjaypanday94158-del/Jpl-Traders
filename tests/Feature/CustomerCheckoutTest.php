<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_place_and_track_a_cash_on_delivery_order(): void
    {
        $product = $this->createProduct();
        $admin = AdminUser::create(['username' => 'order-admin', 'password' => 'admin-password']);
        $adminSession = ['admin_id' => $admin->id];

        $this->post(route('cart.items.store'), ['slug' => $product->slug, 'quantity' => 2])
            ->assertRedirect(route('cart.index'));

        $this->get(route('checkout'))
            ->assertOk()
            ->assertSee('Cash on Delivery')
            ->assertSee('Guest checkout is also available');

        $response = $this->post(route('checkout.store'), $this->checkoutDetails());
        $order = Order::with(['items', 'events'])->firstOrFail();

        $response->assertRedirect(route('orders.track', [
            'orderNumber' => $order->order_number,
            'token' => substr($response->headers->get('Location'), strrpos($response->headers->get('Location'), '/') + 1),
        ]));

        $this->assertSame('pending', $order->status);
        $this->assertSame('pending', $order->payment_status);
        $this->assertSame('cash_on_delivery', $order->payment_method);
        $this->assertSame('5001.00', $order->total_amount);
        $this->assertSame('JPL-TEST-100', $order->items->first()->sku);
        $this->assertSame(2, $order->items->first()->quantity);
        $this->assertCount(1, $order->events);
        $this->assertNull($order->user_id);
        $response->assertSessionMissing('cart');

        $this->get($response->headers->get('Location'))
            ->assertOk()
            ->assertSee($order->order_number)
            ->assertSee('Cash on Delivery')
            ->assertSee('JPL-TEST-100');

        $this->post(route('orders.track-lookup.submit'), [
            'order_number' => $order->order_number,
            'customer_email' => 'wrong@example.com',
        ])->assertSessionHasErrors('order_number');

        $this->post(route('orders.track-lookup.submit'), [
            'order_number' => $order->order_number,
            'customer_email' => 'buyer@example.com',
        ])->assertOk()->assertSee($order->order_number);

        $this->withSession($adminSession)
            ->post(route('admin.orders.collect-cod', $order->order_number))
            ->assertSessionHasErrors('payment');

        $this->withSession($adminSession)
            ->patch(route('admin.orders.status', $order->order_number), [
            'status' => 'delivered',
            'notes' => 'Delivered to the customer.',
        ])->assertSessionHas('success');

        $this->withSession($adminSession)
            ->post(route('admin.orders.collect-cod', $order->order_number))
            ->assertSessionHas('success');

        $order->refresh();
        $this->assertSame('collected', $order->payment_status);
        $this->assertNotNull($order->cod_collected_at);
        $this->assertCount(3, $order->events()->get());

        $this->withSession($adminSession)
            ->get(route('admin.orders'))
            ->assertOk()
            ->assertSee($order->order_number)
            ->assertSee('Collected');
        $this->withSession($adminSession)
            ->get(route('admin.orders.show', $order->order_number))
            ->assertOk()
            ->assertSee('Guest Buyer')
            ->assertSee('buyer@example.com')
            ->assertSee('Delivered to the customer.');
        $this->withSession($adminSession)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('₹5,001.00');
    }

    public function test_order_reduces_finite_stock_after_successful_checkout(): void
    {
        $product = $this->createProduct(['stock_quantity' => 3]);

        $this->post(route('cart.items.store'), ['slug' => $product->slug, 'quantity' => 2])
            ->assertRedirect(route('cart.index'));

        $response = $this->post(route('checkout.store'), $this->checkoutDetails());
        $response->assertRedirect();

        $this->assertSame(1, $product->fresh()->stock_quantity);
        $this->assertSame(1, Order::count());
        $this->assertTrue(Order::firstOrFail()->items->first()->stock_tracked);
        $response->assertSessionMissing('cart');

        $order = Order::firstOrFail();
        $this->withSession(['admin_id' => 1])
            ->patch(route('admin.orders.status', $order->order_number), ['status' => 'cancelled'])
            ->assertSessionHas('success');

        $this->assertSame(3, $product->fresh()->stock_quantity);
    }

    public function test_checkout_rejects_stock_that_changed_after_adding_to_cart(): void
    {
        $product = $this->createProduct(['stock_quantity' => 1]);
        $this->post(route('cart.items.store'), ['slug' => $product->slug])
            ->assertRedirect(route('cart.index'));
        $product->update(['stock_quantity' => 0]);

        $this->post(route('checkout.store'), $this->checkoutDetails())
            ->assertSessionHasErrors('cart')
            ->assertSessionHas('cart.'.$product->slug, 1);

        $this->assertSame(0, Order::count());
        $this->assertSame(0, $product->fresh()->stock_quantity);
    }

    public function test_customer_can_register_sign_in_and_view_their_account(): void
    {
        $this->post(route('customer.register.submit'), [
            'name' => 'Jamie Customer',
            'email' => 'jamie@example.com',
            'phone' => '9876543210',
            'password' => 'SecurePassword123',
            'password_confirmation' => 'SecurePassword123',
        ])->assertRedirect(route('account.index'));

        $customer = User::where('email', 'jamie@example.com')->firstOrFail();
        $this->assertAuthenticatedAs($customer);
        $this->assertNotSame('SecurePassword123', $customer->password);

        $this->get(route('account.index'))
            ->assertOk()
            ->assertSee('Hello, Jamie Customer')
            ->assertSee('No orders yet');

        $this->withSession(['admin_id' => 1])
            ->get(route('admin.customers'))
            ->assertOk()
            ->assertSee('jamie@example.com');

        $this->post(route('customer.logout'))->assertRedirect(route('home'));
        $this->assertGuest();

        $this->post(route('customer.login.submit'), [
            'email' => 'jamie@example.com',
            'password' => 'SecurePassword123',
            'next' => 'checkout',
        ])->assertRedirect(route('checkout'));

        $this->assertAuthenticatedAs($customer);
    }

    public function test_customer_account_routes_require_a_customer_login(): void
    {
        $this->get(route('account.index'))
            ->assertRedirect(route('login'));
    }

    public function test_customer_can_cancel_their_own_unshipped_order_with_a_reason(): void
    {
        $customer = User::create([
            'name' => 'Jamie Customer',
            'email' => 'jamie@example.com',
            'password' => 'SecurePassword123',
        ]);
        $product = $this->createProduct(['stock_quantity' => 3]);
        $this->actingAs($customer)
            ->post(route('cart.items.store'), ['slug' => $product->slug, 'quantity' => 2])
            ->assertRedirect(route('cart.index'));

        $this->post(route('checkout.store'), $this->checkoutDetails())->assertRedirect();
        $order = Order::firstOrFail();
        $this->assertSame(1, $product->fresh()->stock_quantity);

        $orderPage = route('account.orders.show', $order->order_number);
        $this->get($orderPage)->assertOk()->assertSee('Reason for cancellation');

        $this->from($orderPage)
            ->post(route('account.orders.cancel', $order->order_number), [])
            ->assertSessionHasErrors('reason');

        $otherCustomer = User::create([
            'name' => 'Other Customer',
            'email' => 'other@example.com',
            'password' => 'SecurePassword123',
        ]);
        $this->actingAs($otherCustomer)
            ->post(route('account.orders.cancel', $order->order_number), ['reason' => 'Wrong order'])
            ->assertNotFound();

        $this->actingAs($customer)
            ->post(route('account.orders.cancel', $order->order_number), ['reason' => 'Ordered the wrong item'])
            ->assertRedirect($orderPage)
            ->assertSessionHas('success');

        $this->assertSame('cancelled', $order->fresh()->status);
        $this->assertSame(3, $product->fresh()->stock_quantity);
        $this->assertSame('Ordered the wrong item', $order->events()->reorder('id', 'desc')->value('notes'));

        $this->from($orderPage)
            ->post(route('account.orders.cancel', $order->order_number), ['reason' => 'Retry'])
            ->assertSessionHasErrors('cancellation');
        $this->assertSame(3, $product->fresh()->stock_quantity);
        $this->get($orderPage)->assertDontSee('Cancel order');
    }

    public function test_customer_cannot_cancel_an_order_after_it_has_shipped(): void
    {
        $customer = User::create([
            'name' => 'Jamie Customer',
            'email' => 'jamie@example.com',
            'password' => 'SecurePassword123',
        ]);
        $product = $this->createProduct(['stock_quantity' => 3]);
        $this->actingAs($customer)
            ->post(route('cart.items.store'), ['slug' => $product->slug])
            ->assertRedirect(route('cart.index'));
        $this->post(route('checkout.store'), $this->checkoutDetails())->assertRedirect();
        $order = Order::firstOrFail();

        $this->withSession(['admin_id' => 1])
            ->patch(route('admin.orders.status', $order->order_number), ['status' => 'shipped'])
            ->assertSessionHas('success');

        $this->from(route('account.orders.show', $order->order_number))
            ->post(route('account.orders.cancel', $order->order_number), ['reason' => 'Changed my mind'])
            ->assertSessionHasErrors('cancellation');

        $this->assertSame('shipped', $order->fresh()->status);
        $this->assertSame(2, $product->fresh()->stock_quantity);
    }

    public function test_guest_can_cancel_an_unshipped_order_from_its_secure_tracking_link(): void
    {
        $product = $this->createProduct(['stock_quantity' => 2]);
        $this->post(route('cart.items.store'), ['slug' => $product->slug])
            ->assertRedirect(route('cart.index'));
        $checkout = $this->post(route('checkout.store'), $this->checkoutDetails())->assertRedirect();
        $order = Order::firstOrFail();
        $trackingPath = parse_url($checkout->headers->get('Location'), PHP_URL_PATH);
        $segments = explode('/', trim((string) $trackingPath, '/'));
        $token = end($segments);

        $this->get($checkout->headers->get('Location'))
            ->assertOk()
            ->assertSee('Reason for cancellation');

        $this->post(route('orders.cancel-tracked', [
            'orderNumber' => $order->order_number,
            'token' => 'incorrect-token',
        ]), ['reason' => 'No longer needed'])->assertNotFound();

        $this->post(route('orders.cancel-tracked', [
            'orderNumber' => $order->order_number,
            'token' => $token,
        ]), ['reason' => 'No longer needed'])
            ->assertRedirect(route('orders.track', [
                'orderNumber' => $order->order_number,
                'token' => $token,
            ]))
            ->assertSessionHas('success');

        $this->assertSame('cancelled', $order->fresh()->status);
        $this->assertSame(2, $product->fresh()->stock_quantity);
        $this->assertSame('No longer needed', $order->events()->reorder('id', 'desc')->value('notes'));
    }

    private function createProduct(array $overrides = []): Product
    {
        return Product::create(array_merge([
            'name' => 'Test Laptop',
            'slug' => 'test-laptop',
            'sku' => 'JPL-TEST-100',
            'category' => 'Laptops',
            'brand' => 'Test Brand',
            'price' => '2500.50',
            'image' => '/images/test-laptop.jpg',
            'is_active' => true,
        ], $overrides));
    }

    private function checkoutDetails(): array
    {
        return [
            'customer_name' => 'Guest Buyer',
            'customer_email' => 'buyer@example.com',
            'customer_phone' => '9876543210',
            'shipping_address_line_1' => '10 Market Road',
            'shipping_address_line_2' => 'Near Main Square',
            'shipping_city' => 'Azamgarh',
            'shipping_state' => 'Uttar Pradesh',
            'shipping_postal_code' => '276001',
            'customer_note' => 'Call on arrival.',
        ];
    }
}
