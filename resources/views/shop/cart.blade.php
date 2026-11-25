@extends('layouts.app')

@section('title', 'Shopping Cart | JPL TRADERS')

@section('content')
<section class="shell page-container cart-page">
    <nav class="cart-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <span aria-hidden="true">/</span>
        <strong>Shopping cart</strong>
    </nav>

    <div class="cart-header">
        <div>
            <p class="cart-eyebrow">YOUR SELECTION</p>
            <h1>Shopping cart</h1>
            <p>Review your items and place a Cash on Delivery order when you are ready.</p>
        </div>
        <a href="{{ route('products') }}" class="secondary cart-continue">
            Continue shopping
            @include('partials.icon',['name'=>'arrow-right','size'=>15])
        </a>
    </div>

    @if(session('success'))
        <p class="cart-notice" role="status">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="checkout-error" role="alert">{{ session('error') }}</p>
    @endif
    @error('quantity')
        <p class="cart-notice" role="alert">{{ $message }}</p>
    @enderror

    @if(count($cartItems) === 0)
        <div class="cart-empty">
            <span class="cart-empty-icon">@include('partials.icon',['name'=>'cart','size'=>30])</span>
            <h2>Your cart is waiting</h2>
            <p>Explore our computers, printers and accessories, then add the items you are interested in.</p>
            <a href="{{ route('products') }}" class="primary">
                Explore products
                @include('partials.icon',['name'=>'arrow-right','size'=>15])
            </a>
        </div>
    @else
        <div class="cart-layout">
            <section class="cart-items-panel" aria-label="Items in your shopping cart">
                <div class="cart-items-heading">
                    <h2>Your items</h2>
                    <span>{{ $itemCount }} {{ $itemCount === 1 ? 'item' : 'items' }}</span>
                </div>

                @foreach($cartItems as $item)
                    @php $product = $item['product']; @endphp
                    <article class="cart-item">
                        <a href="{{ route('product.show', $product->sku ?: $product->slug) }}" class="cart-item-image" aria-label="View {{ $product->name }}">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        </a>
                        <div class="cart-item-main">
                            <div class="cart-item-meta">
                                <span>{{ $product->brand }}</span>
                                <span>{{ $product->category }}</span>
                                <span>SKU {{ $product->sku ?: 'JPL-'.$product->id }}</span>
                            </div>
                            @if($product->stock_quantity !== null)
                                <small class="cart-stock-note {{ $item['quantity'] > $product->stock_quantity ? 'cart-stock-error' : '' }}">
                                    {{ $product->stock_quantity }} {{ $product->stock_quantity === 1 ? 'unit' : 'units' }} in stock
                                </small>
                            @endif
                            <h3 class="cart-item-name">
                                <a href="{{ route('product.show', $product->sku ?: $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="cart-item-unit-price">₹{{ number_format($product->price, 0) }} per item</p>
                            <div class="cart-item-controls">
                                <form action="{{ route('cart.items.update', $product->slug) }}" method="POST" class="cart-quantity-form">
                                    @csrf
                                    @method('PATCH')
                                    <label for="quantity-{{ $product->slug }}">Qty</label>
                                    <input id="quantity-{{ $product->slug }}" type="number" name="quantity" min="1" max="{{ $product->stock_quantity === null ? 99 : max(1, min(99, $product->stock_quantity)) }}" value="{{ $item['quantity'] }}" @disabled($product->stock_quantity === 0)>
                                    <button type="submit" class="cart-update-button" @disabled($product->stock_quantity === 0)>Update</button>
                                </form>
                                <form action="{{ route('cart.items.destroy', $product->slug) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cart-remove-button">Remove</button>
                                </form>
                            </div>
                        </div>
                        <div class="cart-item-total">
                            <strong>₹{{ number_format($item['lineTotal'], 0) }}</strong>
                            <span>Item total</span>
                        </div>
                    </article>
                @endforeach
            </section>

            <aside class="cart-summary" aria-label="Order summary">
                <h2>Order summary</h2>
                <div class="cart-summary-row">
                    <span>Items ({{ $itemCount }})</span>
                    <strong>₹{{ number_format($subtotal, 0) }}</strong>
                </div>
                <div class="cart-summary-row">
                    <span>Delivery</span>
                    <strong>₹0.00</strong>
                </div>
                <div class="cart-summary-total">
                    <span>Total due on delivery</span>
                    <strong>₹{{ number_format($subtotal, 0) }}</strong>
                </div>
                <p class="cart-summary-note">No online payment gateway. Pay the order total when your items are delivered.</p>
                @if($hasStockIssues)
                    <button type="button" class="primary cart-quote-button cart-checkout-disabled" disabled>Update quantities to continue</button>
                @else
                    <a href="{{ route('checkout') }}" class="primary cart-quote-button">
                        Proceed to checkout
                        @include('partials.icon',['name'=>'arrow-right','size'=>16])
                    </a>
                @endif
                <a href="{{ route('shop.page', ['page' => 'quote', 'from_cart' => 1]) }}" class="cart-quote-secondary">Request a quote instead</a>
                <p class="cart-summary-footnote">Guest checkout is available; customer sign-in is optional.</p>
            </aside>
        </div>
    @endif
</section>
@endsection
