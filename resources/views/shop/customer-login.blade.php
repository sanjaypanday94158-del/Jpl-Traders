@extends('layouts.app')
@section('title', 'Customer sign in | JPL TRADERS')
@section('content')
<section class="shell page-container customer-auth-page">
    <div class="customer-auth-card">
        <p class="cart-eyebrow">CUSTOMER ACCOUNT</p>
        <h1>Welcome back</h1>
        <p class="customer-auth-intro">Sign in to view your orders and delivery updates. You can also continue as a guest at checkout.</p>
        @if($errors->any())<div class="checkout-error" role="alert">{{ $errors->first() }}</div>@endif
        <form action="{{ route('customer.login.submit') }}" method="POST" class="customer-auth-form">
            @csrf
            <input type="hidden" name="next" value="{{ request('next') === 'checkout' ? 'checkout' : '' }}">
            <label>Email address<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required></label>
            <label>Password<input type="password" name="password" autocomplete="current-password" required></label>
            <label class="customer-remember"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
            <button type="submit" class="checkout-submit">Sign in <span aria-hidden="true">→</span></button>
        </form>
        <p class="customer-auth-switch">New to JPL? <a href="{{ route('customer.register', ['next' => request('next')]) }}">Create a customer account</a></p>
        <a href="{{ route('checkout') }}" class="customer-guest-link">Continue as guest</a>
    </div>
</section>
@endsection
