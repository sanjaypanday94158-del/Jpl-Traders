@extends('layouts.app')
@section('title', $order->order_number.' | My account')
@section('content')
@php $statusLabel = \App\Models\Order::STATUSES[$order->status] ?? ucfirst($order->status); @endphp
<section class="shell page-container order-tracking-page">
    <nav class="cart-breadcrumb" aria-label="Breadcrumb"><a href="{{ route('account.index') }}">My account</a><span aria-hidden="true">/</span><strong>{{ $order->order_number }}</strong></nav>
    <header class="checkout-heading"><p class="cart-eyebrow">ORDER DETAILS</p><h1>{{ $order->order_number }}</h1><p>Placed {{ $order->created_at->format('d M Y, h:i A') }} · {{ $statusLabel }}</p></header>
    @if(session('success'))<div class="order-action-feedback order-action-success" role="status">{{ session('success') }}</div>@endif
    @if($errors->has('cancellation'))<div class="order-action-feedback order-action-error" role="alert">{{ $errors->first('cancellation') }}</div>@endif
    <div class="order-tracking-grid">
        <section class="order-tracking-card">
            <div class="order-tracking-card-heading"><div><p class="cart-eyebrow">DELIVERY TIMELINE</p><h2>{{ $statusLabel }}</h2></div><span class="order-status-pill status-{{ $order->status }}">{{ $statusLabel }}</span></div>
            <ol class="order-timeline">
                @foreach($order->events as $event)
                    <li class="order-timeline-event {{ $loop->last ? 'current' : 'complete' }}"><span class="order-timeline-dot"></span><div><strong>{{ $event->title }}</strong><small>{{ $event->created_at->format('d M Y, h:i A') }}</small>@if($event->notes)<p>{{ $event->notes }}</p>@endif</div></li>
                @endforeach
            </ol>
        </section>
        <aside class="order-summary-card">
            <p class="cart-eyebrow">ITEMS &amp; PAYMENT</p>
            @foreach($order->items as $item)
                <div class="order-summary-item"><div><strong>{{ $item->product_name }}</strong><small>SKU {{ $item->sku }} · Qty {{ $item->quantity }}</small></div><b>₹{{ number_format($item->line_total, 2) }}</b></div>
            @endforeach
            <div class="checkout-summary-total"><span>Total</span><strong>₹{{ number_format($order->total_amount, 2) }}</strong></div>
            <div class="order-payment-note"><span>Cash on Delivery</span><strong>{{ $order->payment_status === 'collected' ? 'Collected' : 'Due on delivery' }}</strong></div>
            <div class="order-shipping-note"><strong>Delivery address</strong><span>{{ $order->shipping_address_line_1 }}{{ $order->shipping_address_line_2 ? ', '.$order->shipping_address_line_2 : '' }}</span><span>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</span></div>
        </aside>
    </div>
    @include('partials.customer-order-cancellation', [
        'order' => $order,
        'action' => route('account.orders.cancel', $order->order_number),
    ])
</section>
@endsection
