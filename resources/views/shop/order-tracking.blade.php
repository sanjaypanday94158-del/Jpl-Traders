@extends('layouts.app')
@section('title', 'Order '.$order->order_number.' | JPL TRADERS')
@section('content')
@php
    $statusLabel = \App\Models\Order::STATUSES[$order->status] ?? ucfirst($order->status);
    $events = $order->events;
@endphp
<section class="shell page-container order-tracking-page">
    <header class="order-confirmation-banner">
        <span class="order-confirmation-mark">✓</span>
        <p class="cart-eyebrow">ORDER RECEIVED</p>
        <h1>Thank you for your order.</h1>
        <p>Your order <strong>{{ $order->order_number }}</strong> is saved. You can return to this page or look it up later with your order number and checkout email.</p>
    </header>
    @if(session('success'))<div class="order-action-feedback order-action-success" role="status">{{ session('success') }}</div>@endif
    @if($errors->has('cancellation'))<div class="order-action-feedback order-action-error" role="alert">{{ $errors->first('cancellation') }}</div>@endif
    <div class="order-tracking-grid">
        <section class="order-tracking-card">
            <div class="order-tracking-card-heading">
                <div><p class="cart-eyebrow">LIVE ORDER STATUS</p><h2>{{ $statusLabel }}</h2></div>
                <span class="order-status-pill status-{{ $order->status }}">{{ $statusLabel }}</span>
            </div>
            <p class="tracking-order-meta">Placed {{ $order->created_at->format('d M Y, h:i A') }} · Cash on Delivery</p>
            <ol class="order-timeline">
                @foreach($events as $event)
                    <li class="order-timeline-event {{ $loop->last ? 'current' : 'complete' }}">
                        <span class="order-timeline-dot"></span>
                        <div><strong>{{ $event->title }}</strong><small>{{ $event->created_at->format('d M Y, h:i A') }} · {{ $event->actor }}</small>
                            @if($event->notes)<p>{{ $event->notes }}</p>@endif
                        </div>
                    </li>
                @endforeach
            </ol>
        </section>
        <aside class="order-summary-card">
            <p class="cart-eyebrow">ORDER SUMMARY</p>
            <h2>{{ $order->items->count() }} {{ $order->items->count() === 1 ? 'item' : 'items' }}</h2>
            @foreach($order->items as $item)
                <div class="order-summary-item"><div><strong>{{ $item->product_name }}</strong><small>SKU {{ $item->sku }} · Qty {{ $item->quantity }}</small></div><b>₹{{ number_format($item->line_total, 2) }}</b></div>
            @endforeach
            <div class="checkout-summary-row"><span>Order total</span><strong>₹{{ number_format($order->total_amount, 2) }}</strong></div>
            <div class="order-payment-note"><span>Payment</span><strong>Cash on Delivery</strong><small>{{ $order->payment_status === 'collected' ? 'Payment collected' : 'Pay on delivery' }}</small></div>
            <div class="order-shipping-note"><strong>Delivering to</strong><span>{{ $order->customer_name }}</span><span>{{ $order->shipping_address_line_1 }}{{ $order->shipping_address_line_2 ? ', '.$order->shipping_address_line_2 : '' }}</span><span>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</span></div>
        </aside>
    </div>
    @if(isset($cancellationToken))
        @include('partials.customer-order-cancellation', [
            'order' => $order,
            'action' => route('orders.cancel-tracked', [$order->order_number, $cancellationToken]),
        ])
    @endif
    <div class="order-tracking-actions">
        @auth
            @if($order->user_id === auth()->id())<a href="{{ route('account.index') }}" class="secondary">My account and orders</a>@endif
        @else
            <a href="{{ route('customer.register') }}" class="secondary">Create an account</a>
        @endauth
        <a href="{{ route('products') }}" class="order-continue-link">Continue shopping</a>
    </div>
</section>
@endsection
