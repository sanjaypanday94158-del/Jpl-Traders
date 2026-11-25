<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin | JPL TRADERS')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="theme-color" content="#082653">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a class="admin-brand" href="{{ route('admin.dashboard') }}">
            <img src="/jpl-traders-logo.png" alt="JPL Traders">
            <span>STORE ADMIN</span>
        </a>
        <p class="admin-nav-label">WORKSPACE</p>
        <nav class="admin-nav" aria-label="Admin navigation">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="admin-nav-icon">@include('admin.partials.icon', ['name' => 'dashboard'])</span><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <span class="admin-nav-icon">@include('admin.partials.icon', ['name' => 'category'])</span><span>Categories</span>
            </a>
            <a href="{{ route('admin.brands') }}" class="{{ request()->routeIs('admin.brands*') ? 'active' : '' }}">
                <span class="admin-nav-icon">@include('admin.partials.icon', ['name' => 'brand'])</span><span>Brands</span>
            </a>
            <a href="{{ route('admin.products') }}" class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <span class="admin-nav-icon">@include('admin.partials.icon', ['name' => 'product'])</span><span>Products</span>
            </a>
            <p class="admin-nav-label admin-nav-label-spaced">SALES &amp; CUSTOMERS</p>
            <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <span class="admin-nav-icon">@include('admin.partials.icon', ['name' => 'orders'])</span><span>Orders</span>
            </a>
            <a href="{{ route('admin.customers') }}" class="{{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                <span class="admin-nav-icon">@include('admin.partials.icon', ['name' => 'customers'])</span><span>Customers</span>
            </a>
            <a href="{{ route('admin.enquiries') }}" class="{{ request()->routeIs('admin.enquiries*') ? 'active' : '' }}">
                <span class="admin-nav-icon">@include('admin.partials.icon', ['name' => 'enquiries'])</span><span>Enquiries</span>
            </a>
        </nav>
        <div class="admin-sidebar-footer">
            <a class="admin-store-link" href="{{ url('/') }}"><span class="admin-nav-icon">@include('admin.partials.icon', ['name' => 'store'])</span> View storefront</a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"><span class="admin-nav-icon">@include('admin.partials.icon', ['name' => 'logout'])</span> Sign out</button>
            </form>
        </div>
    </aside>
    <main class="admin-main">
        <header class="admin-topbar">
            <span>JPL TRADERS <i>/</i> ADMINISTRATION</span>
            <span class="admin-topbar-status"><i></i> Store management</span>
        </header>
        <div class="admin-content">@yield('content')</div>
    </main>
</div>
@include('partials.global-loader')
</body>
</html>
