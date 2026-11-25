@extends('layouts.app')
@section('title', 'Create customer account | JPL TRADERS')
@section('content')
<section class="shell page-container customer-auth-page">
    <div class="customer-auth-card">
        <p class="cart-eyebrow">CUSTOMER ACCOUNT</p>
        <h1>Create your account</h1>
        <p class="customer-auth-intro">Save time on future orders and keep your delivery history in one place.</p>
        @if($errors->any())<div class="checkout-error" role="alert"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form action="{{ route('customer.register.submit') }}" method="POST" class="customer-auth-form">
            @csrf
            <input type="hidden" name="next" value="{{ request('next') === 'checkout' ? 'checkout' : '' }}">
            <label>Full name<input name="name" value="{{ old('name') }}" autocomplete="name" maxlength="120" required></label>
            <label>Email address<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" maxlength="150" required></label>
            <label>Phone number <span class="checkout-optional">Optional</span><input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" maxlength="30"></label>
            <label>Password<input type="password" name="password" autocomplete="new-password" minlength="8" required></label>
            <label>Confirm password<input type="password" name="password_confirmation" autocomplete="new-password" minlength="8" required></label>
            <button type="submit" class="checkout-submit">Create account <span aria-hidden="true">→</span></button>
        </form>
        <p class="customer-auth-switch">Already registered? <a href="{{ route('customer.login', ['next' => request('next')]) }}">Sign in</a></p>
        <a href="{{ route('checkout') }}" class="customer-guest-link">Continue as guest</a>
    </div>
</section>
@endsection
