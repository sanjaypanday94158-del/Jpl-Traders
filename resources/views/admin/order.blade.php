@extends('admin.layout')
@section('title', $order->order_number.' | Admin')
@section('content')
@php $statusLabel = \App\Models\Order::STATUSES[$order->status] ?? ucfirst($order->status); @endphp
<nav class="admin-breadcrumb"><a href="{{ route('admin.orders') }}">Orders</a><span>/</span><strong>{{ $order->order_number }}</strong></nav>
<section class="admin-page-heading admin-order-page-heading">
    <div><p class="admin-eyebrow">ORDER DETAILS</p><h1>{{ $order->order_number }}</h1><p>Placed {{ $order->created_at->format('d M Y, h:i A') }} · {{ $order->items->sum('quantity') }} item(s)</p></div>
    <span class="admin-status {{ $order->status === 'delivered' ? 'status-active' : 'status-hidden' }}">{{ $statusLabel }}</span>
</section>
@if(session('success'))<div class="admin-alert admin-alert-success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="admin-alert admin-alert-error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="admin-order-layout">
    <div class="admin-order-main">
        <section class="admin-panel">
            <div class="admin-panel-heading"><div><span class="panel-step">@include('admin.partials.icon', ['name' => 'product'])</span><div><h2>Items ordered</h2><p>SKU and price are saved as order-time snapshots.</p></div></div></div>
            <div class="admin-table-wrap">
                <table class="admin-data-table">
                    <thead><tr><th>Product</th><th>SKU</th><th>Unit price</th><th>Qty</th><th>Line total</th></tr></thead>
                    <tbody>
                    @foreach($order->items as $item)
                        <tr><td><strong>{{ $item->product_name }}</strong></td><td class="admin-muted">{{ $item->sku }}</td><td>₹{{ number_format($item->unit_price, 2) }}</td><td>{{ $item->quantity }}</td><td class="admin-price">₹{{ number_format($item->line_total, 2) }}</td></tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="admin-order-total"><span>Order total</span><strong>₹{{ number_format($order->total_amount, 2) }}</strong></div>
        </section>
        <section class="admin-panel">
            <div class="admin-panel-heading"><div><span class="panel-step">↗</span><div><h2>Delivery timeline</h2><p>Every status change and COD action is recorded.</p></div></div></div>
            <ol class="admin-order-timeline">
                @foreach($order->events as $event)
                    <li><span class="admin-event-dot"></span><div><strong>{{ $event->title }}</strong><small>{{ $event->created_at->format('d M Y, h:i A') }} · {{ $event->actor }}</small>@if($event->notes)<p>{{ $event->notes }}</p>@endif</div></li>
                @endforeach
            </ol>
        </section>
    </div>
    <aside class="admin-order-side">
        <section class="admin-panel admin-order-action-panel">
            <div class="admin-panel-heading"><div><span class="panel-step">01</span><div><h2>Update delivery</h2><p>Changes will show in customer tracking.</p></div></div></div>
            <form action="{{ route('admin.orders.status', $order->order_number) }}" method="POST" class="admin-order-form">
                @csrf
                @method('PATCH')
                <label>New status<select name="status" required>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $order->status) === $value)>{{ $label }}</option>
                    @endforeach
                </select></label>
                <label>Tracking note <span class="checkout-optional">Optional</span><textarea name="notes" rows="3" maxlength="1000" placeholder="Add a short customer-facing update">{{ old('notes') }}</textarea></label>
                <button type="submit" class="admin-button admin-button-primary">Save status update <span aria-hidden="true">→</span></button>
            </form>
        </section>
        <section class="admin-panel admin-cod-panel">
            <div class="admin-panel-heading"><div><span class="panel-step">COD</span><div><h2>Cash on Delivery</h2><p>Payment is recorded only after delivery.</p></div></div></div>
            <div class="admin-cod-details"><span>Amount due</span><strong>₹{{ number_format($order->total_amount, 2) }}</strong><span>Payment status</span><b class="admin-status {{ $order->payment_status === 'collected' ? 'status-active' : 'status-hidden' }}">{{ $order->payment_status === 'collected' ? 'Collected' : 'Pending' }}</b></div>
            @if($order->payment_status === 'collected')
                <p class="admin-cod-collected">Collected {{ $order->cod_collected_at?->format('d M Y, h:i A') }}{{ $order->codCollector ? ' by '.$order->codCollector->username : '' }}</p>
            @else
                <form action="{{ route('admin.orders.collect-cod', $order->order_number) }}" method="POST" class="admin-cod-form">
                    @csrf
                    <button type="submit" class="admin-button admin-button-primary" @disabled($order->status !== 'delivered')>Mark COD collected</button>
                    @if($order->status !== 'delivered')<small>Enable after marking the order delivered.</small>@endif
                </form>
            @endif
        </section>
        <section class="admin-panel admin-customer-detail">
            <div class="admin-panel-heading"><div><span class="panel-step">@include('admin.partials.icon', ['name' => 'customers'])</span><div><h2>Customer</h2><p>{{ $order->user_id ? 'Registered account' : 'Guest checkout' }}</p></div></div></div>
            <dl>
                <dt>Name</dt><dd>{{ $order->customer_name }}</dd>
                <dt>Email</dt><dd><a href="mailto:{{ $order->customer_email }}">{{ $order->customer_email }}</a></dd>
                <dt>Phone</dt><dd><a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a></dd>
                <dt>Address</dt><dd>{{ $order->shipping_address_line_1 }}{{ $order->shipping_address_line_2 ? ', '.$order->shipping_address_line_2 : '' }}<br>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</dd>
                @if($order->customer_note)<dt>Delivery note</dt><dd>{{ $order->customer_note }}</dd>@endif
            </dl>
            @if($order->customer)<a class="admin-customer-link" href="{{ route('admin.customers.show', $order->customer->id) }}">View customer account →</a>@endif
        </section>
    </aside>
</div>
@endsection
