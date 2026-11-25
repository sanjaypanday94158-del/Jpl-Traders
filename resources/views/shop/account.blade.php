@extends('layouts.app')
@section('title', 'My account | JPL TRADERS')
@section('content')
<section class="shell page-container customer-account-page">
    <header class="customer-account-heading">
        <div><p class="cart-eyebrow">CUSTOMER ACCOUNT</p><h1>Hello, {{ auth()->user()->name }}</h1><p>View your past orders and track delivery progress.</p></div>
        <form action="{{ route('customer.logout') }}" method="POST">@csrf<button type="submit" class="customer-logout-button">Sign out</button></form>
    </header>
    <section class="account-orders-card">
        <div class="account-orders-heading"><div><h2>Your orders</h2><p>Order status and cash-on-delivery payment progress.</p></div><span>{{ $orders->total() }} total</span></div>
        @forelse($orders as $order)
            <a class="account-order-row" href="{{ route('account.orders.show', $order->order_number) }}">
                <span class="account-order-icon">@include('partials.icon',['name'=>'cart','size'=>18])</span>
                <span class="account-order-main"><strong>{{ $order->order_number }}</strong><small>{{ $order->created_at->format('d M Y') }} · {{ $order->items->count() }} {{ $order->items->count() === 1 ? 'item' : 'items' }}</small></span>
                <span class="order-status-pill status-{{ $order->status }}">{{ \App\Models\Order::STATUSES[$order->status] ?? ucfirst($order->status) }}</span>
                <strong class="account-order-total">₹{{ number_format($order->total_amount, 2) }}</strong>
                <span class="account-order-arrow" aria-hidden="true">→</span>
            </a>
        @empty
            <div class="account-empty"><span>@include('partials.icon',['name'=>'cart','size'=>23])</span><strong>No orders yet</strong><p>Your orders and tracking updates will appear here.</p><a href="{{ route('products') }}">Browse products</a></div>
        @endforelse
        <div class="admin-pagination">{{ $orders->links() }}</div>
    </section>
</section>
@endsection
