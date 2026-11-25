<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Product;

class StoreController extends Controller
{
    public function home()
    {
        $categories = Category::where('is_active', true)->get();
        $products = Product::where('is_active', true)->latest()->take(10)->get();

        return view('shop.home', compact('categories', 'products'));
    }

    public function products(Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->string('brand'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($products) use ($search) {
                $products->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->sort === 'low') {
            $query->orderBy('price');
        } elseif ($request->sort === 'high') {
            $query->orderByDesc('price');
        } else {
            $query->orderBy('id');
        }

        $categories = Category::where('is_active', true)->get();
        $brands = Product::where('is_active', true)
            ->whereNotNull('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');
        $products = $query->paginate(10)->withQueryString();

        return view('shop.products', compact('categories', 'brands', 'products'));
    }

    public function product(string $sku)
    {
        $product = Product::where('sku', $sku)
            ->where('is_active', true)
            ->first();

        if (!$product) {
            $product = Product::where('slug', $sku)
                ->where('is_active', true)
                ->firstOrFail();
        }

        return view('shop.product', compact('product'));
    }

    public function cart(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $cart = is_array($cart) ? $cart : [];
        $products = Product::where('is_active', true)
            ->whereIn('slug', array_keys($cart))
            ->get()
            ->keyBy('slug');
        $cartItems = [];

        foreach ($cart as $slug => $quantity) {
            $product = $products->get($slug);

            if (!$product) {
                unset($cart[$slug]);
                continue;
            }

            $quantity = min(99, max(1, (int) $quantity));
            $cart[$slug] = $quantity;
            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'lineTotal' => round((float) $product->price * $quantity, 2),
            ];
        }

        if ($cart !== $request->session()->get('cart', [])) {
            $request->session()->put('cart', $cart);
        }

        $itemCount = array_sum(array_column($cartItems, 'quantity'));
        $subtotal = array_sum(array_column($cartItems, 'lineTotal'));
        $hasStockIssues = collect($cartItems)->contains(
            fn ($item) => $item['product']->stock_quantity !== null && $item['quantity'] > $item['product']->stock_quantity
        );

        return view('shop.cart', compact('cartItems', 'itemCount', 'subtotal', 'hasStockIssues'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'exists:products,slug'],
            'quantity' => ['sometimes', 'integer', 'min:1', 'max:99'],
        ]);
        $product = Product::where('slug', $data['slug'])
            ->where('is_active', true)
            ->firstOrFail();
        $cart = $request->session()->get('cart', []);
        $cart = is_array($cart) ? $cart : [];
        $quantity = (int) ($cart[$product->slug] ?? 0);
        $requestedQuantity = min(99, $quantity + (int) ($data['quantity'] ?? 1));

        if ($product->stock_quantity !== null && $requestedQuantity > $product->stock_quantity) {
            return redirect()->route('cart.index')->withErrors([
                'quantity' => 'Only '.$product->stock_quantity.' unit(s) of '.$product->name.' are currently in stock.',
            ]);
        }

        $cart[$product->slug] = $requestedQuantity;
        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', $product->name.' added to your cart.');
    }

    public function updateCartItem(Request $request, string $slug)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        $cart = $request->session()->get('cart', []);
        $cart = is_array($cart) ? $cart : [];
        abort_unless(array_key_exists($product->slug, $cart), 404);

        if ($product->stock_quantity !== null && (int) $data['quantity'] > $product->stock_quantity) {
            return back()->withErrors([
                'quantity' => 'Only '.$product->stock_quantity.' unit(s) of '.$product->name.' are currently in stock.',
            ]);
        }

        $cart[$product->slug] = (int) $data['quantity'];
        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Cart quantity updated.');
    }

    public function removeCartItem(Request $request, string $slug)
    {
        $cart = $request->session()->get('cart', []);
        $cart = is_array($cart) ? $cart : [];
        unset($cart[$slug]);
        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Item removed from your cart.');
    }

    public function page(Request $request, string $page)
    {
        $allowedPages = ['about', 'services', 'institutional', 'contact', 'faq', 'quote'];

        if (!in_array($page, $allowedPages, true)) {
            abort(404);
        }

        $quoteDetails = '';

        if ($page === 'quote' && $request->boolean('from_cart')) {
            $cart = $request->session()->get('cart', []);
            $cart = is_array($cart) ? $cart : [];
            $products = Product::where('is_active', true)
                ->whereIn('slug', array_keys($cart))
                ->get()
                ->keyBy('slug');
            $lines = [];

            foreach ($cart as $slug => $quantity) {
                $product = $products->get($slug);

                if ($product) {
                    $lines[] = $product->name.' × '.max(1, (int) $quantity).' — ₹'.number_format((float) $product->price, 0).' each';
                }
            }

            if ($lines) {
                $quoteDetails = "Please provide a quote for these cart items:\n".implode("\n", $lines);
            }
        }

        return view("shop.{$page}", compact('quoteDetails'));
    }

    public function submitEnquiry(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        Enquiry::create($data);

        return back()->with('success', 'Thank you. We received your enquiry.');
    }
}
