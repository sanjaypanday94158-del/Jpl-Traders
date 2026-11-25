<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_items_can_be_added_updated_and_removed(): void
    {
        $product = $this->createProduct();

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('Your cart is waiting');

        $this->post(route('cart.items.store'), ['slug' => $product->slug])
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas('cart.'.$product->slug, 1);

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee('₹2,500');

        $this->patch(route('cart.items.update', $product->slug), ['quantity' => 3])
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas('cart.'.$product->slug, 3);

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('3 items')
            ->assertSee('₹7,500');

        $this->get(route('shop.page', ['page' => 'quote', 'from_cart' => 1]))
            ->assertOk()
            ->assertSee('Quote for shopping cart')
            ->assertSee($product->name);

        $this->delete(route('cart.items.destroy', $product->slug))
            ->assertRedirect(route('cart.index'))
            ->assertSessionMissing('cart.'.$product->slug);
    }

    public function test_inactive_products_cannot_be_added_to_cart(): void
    {
        $product = $this->createProduct(['is_active' => false]);

        $this->post(route('cart.items.store'), ['slug' => $product->slug])
            ->assertNotFound()
            ->assertSessionMissing('cart.'.$product->slug);
    }

    public function test_cart_rejects_quantities_above_available_stock(): void
    {
        $product = $this->createProduct(['stock_quantity' => 2]);

        $this->post(route('cart.items.store'), ['slug' => $product->slug, 'quantity' => 3])
            ->assertRedirect(route('cart.index'))
            ->assertSessionHasErrors('quantity')
            ->assertSessionMissing('cart.'.$product->slug);

        $this->post(route('cart.items.store'), ['slug' => $product->slug, 'quantity' => 2])
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas('cart.'.$product->slug, 2);

        $this->patch(route('cart.items.update', $product->slug), ['quantity' => 3])
            ->assertRedirect(route('cart.index'))
            ->assertSessionHasErrors('quantity')
            ->assertSessionHas('cart.'.$product->slug, 2);
    }

    private function createProduct(array $overrides = []): Product
    {
        return Product::create(array_merge([
            'name' => 'Professional Laptop',
            'slug' => 'professional-laptop',
            'category' => 'Laptops',
            'brand' => 'JPL',
            'price' => 2500,
            'image' => '/images/professional-laptop.jpg',
            'is_active' => true,
        ], $overrides));
    }
}
