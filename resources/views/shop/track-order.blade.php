@extends('layouts.app')
@section('title', 'Track an order | JPL TRADERS')
@section('content')
<section class="shell page-container customer-auth-page">
    <div class="customer-auth-card">
        <p class="cart-eyebrow">ORDER TRACKING</p>
        <h1>Find your order</h1>
        <p class="customer-auth-intro">Enter the order number and email address used at checkout to view delivery updates.</p>
        @if($errors->any())<div class="checkout-error" role="alert">{{ $errors->first() }}</div>@endif
        <form action="{{ route('orders.track-lookup.submit') }}" method="POST" class="customer-auth-form">
            @csrf
            <label>Order number<input name="order_number" value="{{ old('order_number') }}" placeholder="JPL-20261124-XXXXXXXX" maxlength="40" required></label>
            <label>Checkout email<input type="email" name="customer_email" value="{{ old('customer_email') }}" autocomplete="email" required></label>
            <button type="submit" class="checkout-submit">Track order <span aria-hidden="true">→</span></button>
        </form>
        <p class="customer-auth-switch"><a href="{{ route('customer.login') }}">Sign in</a> to see all orders linked to your account.</p>
    </div>
</section>
@endsection
