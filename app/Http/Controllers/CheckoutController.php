<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\Product;
use App\Services\OrderCancellationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $cartItems = $this->currentCartItems($request);

        if ($cartItems === []) {
            return redirect()->route('cart.index')->with('error', 'Add an available product before checkout.');
        }

        foreach ($cartItems as $item) {
            $product = $item['product'];
            if ($product->stock_quantity !== null && $item['quantity'] > $product->stock_quantity) {
                return redirect()->route('cart.index')->with(
                    'error',
                    'Only '.$product->stock_quantity.' unit(s) of '.$product->name.' are currently in stock. Update your cart to continue.'
                );
            }
        }

        $subtotalCents = array_sum(array_column($cartItems, 'lineTotalCents'));

        return view('shop.checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotalCents / 100,
            'customer' => $request->user(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_email' => ['required', 'email', 'max:150'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'shipping_address_line_1' => ['required', 'string', 'max:255'],
            'shipping_address_line_2' => ['nullable', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:100'],
            'shipping_state' => ['required', 'string', 'max:100'],
            'shipping_postal_code' => ['required', 'string', 'max:20'],
            'customer_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = $this->normalizedCart($request->session()->get('cart', []));
        $request->session()->put('cart', $cart);

        if ($cart === []) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $result = DB::transaction(function () use ($cart, $data, $request): ?array {
            $products = Product::whereIn('slug', array_keys($cart))
                ->where('is_active', true)
                ->lockForUpdate()
                ->get()
                ->keyBy('slug');

            if ($products->count() !== count($cart)) {
                return null;
            }

            foreach ($cart as $slug => $quantity) {
                $product = $products->get($slug);
                if ($product->stock_quantity !== null && $quantity > $product->stock_quantity) {
                    return [
                        'error' => 'Only '.$product->stock_quantity.' unit(s) of '.$product->name.' remain in stock. Review your cart and try again.',
                    ];
                }
            }

            $subtotalCents = 0;
            $items = [];

            foreach ($cart as $slug => $quantity) {
                $product = $products->get($slug);
                $unitPriceCents = (int) round((float) $product->price * 100);
                $lineTotalCents = $unitPriceCents * $quantity;
                $subtotalCents += $lineTotalCents;
                $items[] = [
                    'product_id' => $product->id,
                    'sku' => $product->sku ?: 'JPL-'.str_pad((string) $product->id, 6, '0', STR_PAD_LEFT),
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'unit_price' => number_format($unitPriceCents / 100, 2, '.', ''),
                    'line_total' => number_format($lineTotalCents / 100, 2, '.', ''),
                    'stock_tracked' => $product->stock_quantity !== null,
                ];
            }

            $trackingToken = Str::random(64);
            $order = Order::create([
                'order_number' => $this->newOrderNumber(),
                'tracking_token_hash' => hash('sha256', $trackingToken),
                'user_id' => $request->user()?->id,
                'customer_name' => $data['customer_name'],
                'customer_email' => strtolower($data['customer_email']),
                'customer_phone' => $data['customer_phone'],
                'shipping_address_line_1' => $data['shipping_address_line_1'],
                'shipping_address_line_2' => $data['shipping_address_line_2'] ?? null,
                'shipping_city' => $data['shipping_city'],
                'shipping_state' => $data['shipping_state'],
                'shipping_postal_code' => $data['shipping_postal_code'],
                'customer_note' => $data['customer_note'] ?? null,
                'subtotal' => number_format($subtotalCents / 100, 2, '.', ''),
                'delivery_fee' => '0.00',
                'total_amount' => number_format($subtotalCents / 100, 2, '.', ''),
                'payment_method' => 'cash_on_delivery',
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            $order->items()->createMany($items);
            OrderEvent::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'title' => 'Order placed',
                'notes' => 'Payment method: Cash on Delivery.',
                'actor' => $request->user()?->name ?? 'Guest customer',
            ]);

            foreach ($cart as $slug => $quantity) {
                $product = $products->get($slug);
                if ($product->stock_quantity !== null) {
                    $product->decrement('stock_quantity', $quantity);
                }
            }

            return ['order' => $order, 'token' => $trackingToken];
        });

        if ($result === null) {
            return back()->withErrors(['cart' => 'One or more items are no longer available. Review your cart and try again.']);
        }

        if (isset($result['error'])) {
            return back()->withErrors(['cart' => $result['error']]);
        }

        $request->session()->forget('cart');

        return redirect()->route('orders.track', [
            'orderNumber' => $result['order']->order_number,
            'token' => $result['token'],
        ]);
    }

    public function track(string $orderNumber, string $token)
    {
        $order = Order::with(['items', 'events'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        abort_unless(hash_equals($order->tracking_token_hash, hash('sha256', $token)), 404);

        return view('shop.order-tracking', [
            'order' => $order,
            'cancellationToken' => $token,
        ]);
    }

    public function cancelTrackedOrder(
        Request $request,
        OrderCancellationService $cancellations,
        string $orderNumber,
        string $token
    ) {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        abort_unless(hash_equals($order->tracking_token_hash, hash('sha256', $token)), 404);

        $data = $request->validate([
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        $result = $cancellations->cancelByCustomer(
            (int) $order->id,
            'Guest customer',
            $data['reason']
        );

        if ($result === 'cancelled') {
            return redirect()->route('orders.track', [
                'orderNumber' => $orderNumber,
                'token' => $token,
            ])->with('success', 'Your order has been cancelled.');
        }

        return redirect()->route('orders.track', [
            'orderNumber' => $orderNumber,
            'token' => $token,
        ])->withErrors(['cancellation' => 'This order can no longer be cancelled.']);
    }

    public function trackingLookupForm()
    {
        return view('shop.track-order');
    }

    public function trackingLookup(Request $request)
    {
        $data = $request->validate([
            'order_number' => ['required', 'string', 'max:40'],
            'customer_email' => ['required', 'email', 'max:150'],
        ]);

        $order = Order::with(['items', 'events'])
            ->where('order_number', strtoupper($data['order_number']))
            ->where('customer_email', strtolower($data['customer_email']))
            ->first();

        if (!$order) {
            return back()->withErrors(['order_number' => 'We could not find an order matching those details.']);
        }

        return view('shop.order-tracking', compact('order'));
    }

    private function currentCartItems(Request $request): array
    {
        $cart = $this->normalizedCart($request->session()->get('cart', []));
        $products = Product::whereIn('slug', array_keys($cart))
            ->where('is_active', true)
            ->get()
            ->keyBy('slug');
        $cartItems = [];
        $removedUnavailableItem = false;

        foreach ($cart as $slug => $quantity) {
            $product = $products->get($slug);

            if (!$product) {
                unset($cart[$slug]);
                $removedUnavailableItem = true;
                continue;
            }

            $unitPriceCents = (int) round((float) $product->price * 100);
            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'lineTotalCents' => $unitPriceCents * $quantity,
            ];
        }

        $request->session()->put('cart', $cart);
        if ($removedUnavailableItem) {
            $request->session()->flash('error', 'Unavailable items were removed from your cart. Review the remaining items before checkout.');
        }

        return $cartItems;
    }

    private function normalizedCart(mixed $cart): array
    {
        if (!is_array($cart)) {
            return [];
        }

        $normalized = [];
        foreach ($cart as $slug => $quantity) {
            if (is_string($slug) && is_numeric($quantity) && (int) $quantity >= 1) {
                $normalized[$slug] = min(99, (int) $quantity);
            }
        }

        return $normalized;
    }

    private function newOrderNumber(): string
    {
        do {
            $orderNumber = 'JPL-'.$this->todayStamp().'-'.Str::upper(Str::random(8));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    private function todayStamp(): string
    {
        return now()->format('Ymd');
    }
}
