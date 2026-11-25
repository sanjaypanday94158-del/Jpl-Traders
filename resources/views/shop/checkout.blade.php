@extends('layouts.app')
@section('title', 'Checkout | JPL TRADERS')
@section('content')
<section class="shell page-container checkout-page">
    <nav class="cart-breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><a href="{{ route('cart.index') }}">Cart</a><span aria-hidden="true">/</span><strong>Checkout</strong></nav>
    <header class="checkout-heading">
        <p class="cart-eyebrow">CASH ON DELIVERY</p>
        <h1>Delivery details</h1>
        <p>Place your order now and pay when it is delivered.</p>
    </header>
    @if(session('success'))<p class="cart-notice" role="status">{{ session('success') }}</p>@endif
    @if(session('error'))<p class="checkout-error" role="alert">{{ session('error') }}</p>@endif
    @error('cart')<p class="checkout-error" role="alert">{{ $message }}</p>@enderror
    <div class="checkout-layout">
        <form action="{{ route('checkout.store') }}" method="POST" class="checkout-form-panel">
            @csrf
            <section class="checkout-form-section">
                <div class="checkout-section-heading"><span>01</span><div><h2>Contact information</h2><p>We will use these details for order updates.</p></div></div>
                @guest
                    <p class="checkout-account-note">Have an account? <a href="{{ route('customer.login', ['next' => 'checkout']) }}">Sign in</a> or <a href="{{ route('customer.register', ['next' => 'checkout']) }}">create one</a>. Guest checkout is also available.</p>
                @endguest
                <div class="checkout-fields">
                    <label>Full name<input name="customer_name" value="{{ old('customer_name', $customer?->name) }}" autocomplete="name" maxlength="120" required>@error('customer_name')<small>{{ $message }}</small>@enderror</label>
                    <label>Email address<input name="customer_email" type="email" value="{{ old('customer_email', $customer?->email) }}" autocomplete="email" maxlength="150" required>@error('customer_email')<small>{{ $message }}</small>@enderror</label>
                    <label class="checkout-wide">Phone number<input name="customer_phone" type="tel" value="{{ old('customer_phone', $customer?->phone) }}" autocomplete="tel" maxlength="30" required>@error('customer_phone')<small>{{ $message }}</small>@enderror</label>
                </div>
            </section>
            <section class="checkout-form-section">
                <div class="checkout-section-heading"><span>02</span><div><h2>Shipping address</h2><p>Where should we deliver your order?</p></div></div>
                <div class="checkout-fields">
                    <label class="checkout-wide">Address line 1<input name="shipping_address_line_1" value="{{ old('shipping_address_line_1') }}" autocomplete="address-line1" maxlength="255" required>@error('shipping_address_line_1')<small>{{ $message }}</small>@enderror</label>
                    <label class="checkout-wide">Address line 2 <span class="checkout-optional">Optional</span><input name="shipping_address_line_2" value="{{ old('shipping_address_line_2') }}" autocomplete="address-line2" maxlength="255"></label>
                    <label>City<input name="shipping_city" value="{{ old('shipping_city') }}" autocomplete="address-level2" maxlength="100" required>@error('shipping_city')<small>{{ $message }}</small>@enderror</label>
                    <label>State<input name="shipping_state" value="{{ old('shipping_state') }}" autocomplete="address-level1" maxlength="100" required>@error('shipping_state')<small>{{ $message }}</small>@enderror</label>
                    <label>Postal code<input name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" autocomplete="postal-code" maxlength="20" required>@error('shipping_postal_code')<small>{{ $message }}</small>@enderror</label>
                    <label class="checkout-wide">Delivery note <span class="checkout-optional">Optional</span><textarea name="customer_note" maxlength="1000" rows="3" placeholder="Landmark or delivery instructions">{{ old('customer_note') }}</textarea></label>
                </div>
            </section>
            <section class="checkout-cod-panel">
                <span class="checkout-cod-mark">COD</span>
                <div><h2>Cash on Delivery</h2><p>No online payment is collected. Pay the delivery amount when your order arrives.</p></div>
                <strong>₹{{ number_format($subtotal, 2) }}</strong>
            </section>
            <button type="submit" class="checkout-submit">Place order <span aria-hidden="true">→</span></button>
            <p class="checkout-terms-note">By placing your order, you confirm that the delivery and contact details are correct.</p>
        </form>
        <aside class="checkout-summary">
            <h2>Order summary <span>{{ count($cartItems) }} {{ count($cartItems) === 1 ? 'item' : 'items' }}</span></h2>
            <div class="checkout-summary-items">
                @foreach($cartItems as $item)
                    <div class="checkout-summary-item">
                        <div><strong>{{ $item['product']->name }}</strong><small>SKU {{ $item['product']->sku ?: 'JPL-'.$item['product']->id }} · Qty {{ $item['quantity'] }}</small></div>
                        <b>₹{{ number_format($item['lineTotalCents'] / 100, 2) }}</b>
                    </div>
                @endforeach
            </div>
            <div class="checkout-summary-row"><span>Subtotal</span><strong>₹{{ number_format($subtotal, 2) }}</strong></div>
            <div class="checkout-summary-row"><span>Delivery</span><strong>₹0.00</strong></div>
            <div class="checkout-summary-total"><span>Total due on delivery</span><strong>₹{{ number_format($subtotal, 2) }}</strong></div>
            <a href="{{ route('cart.index') }}" class="checkout-back-link">← Return to cart</a>
        </aside>
    </div>
</section>
@endsection
