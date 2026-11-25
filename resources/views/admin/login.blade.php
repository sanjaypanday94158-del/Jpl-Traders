<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | JPL TRADERS</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="theme-color" content="#082653">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-login">
    <main class="login-shell">
        <aside class="login-brand-panel">
            <a class="login-brand-logo" href="{{ url('/') }}" aria-label="JPL TRADERS home">
                <img src="/jpl-traders-logo.png" alt="JPL TRADERS">
            </a>
            <p class="login-brand-kicker">JPL TRADERS <span>ADMIN PORTAL</span></p>
            <h2>Your store,<br>in your hands.</h2>
            <p class="login-brand-description">Sign in to manage products and stay on top of customer enquiries.</p>
            <div class="login-brand-note">
                <span>@include('partials.icon',['name'=>'shield','size'=>18])</span>
                <p>Store management made simple.</p>
            </div>
            <a class="login-store-link" href="{{ url('/') }}">Back to storefront @include('partials.icon',['name'=>'arrow-right','size'=>15])</a>
        </aside>
        <form action="{{ route('admin.login.submit') }}" method="POST" class="login-form-panel">
            @csrf
            <div class="login-form-heading">
                <span>WELCOME BACK</span>
                <h1>Admin Login</h1>
                <p>Enter your credentials to continue to the dashboard.</p>
            </div>
            @if($errors->any())
                <div class="error-box" role="alert">{{ $errors->first() }}</div>
            @endif
            <label for="adminUsername">Username
                <input id="adminUsername" type="text" name="username" value="{{ old('username') }}" autocomplete="username" placeholder="Enter your username" required>
            </label>
            <label for="adminPassword">Password
                <input id="adminPassword" type="password" name="password" autocomplete="current-password" placeholder="Enter your password" required>
            </label>
            <button type="submit">Sign in to dashboard @include('partials.icon',['name'=>'arrow-right','size'=>16])</button>
        </form>
    </main>
    @include('partials.global-loader')
</body>
</html>
