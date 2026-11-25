@extends('admin.layout')
@section('title', $customer->name.' | Customer details')
@section('content')
<nav class="admin-breadcrumb"><a href="{{ route('admin.customers') }}">Customers</a><span>/</span><strong>{{ $customer->name }}</strong></nav>
<section class="admin-page-heading"><div><p class="admin-eyebrow">CUSTOMER PROFILE</p><h1>{{ $customer->name }}</h1><p>Customer since {{ $customer->created_at->format('d M Y') }}</p></div><span class="admin-count-pill">{{ $customer->orders->count() }} orders</span></section>
<section class="admin-panel admin-customer-profile">
    <dl><dt>Email</dt><dd><a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></dd><dt>Phone</dt><dd>{{ $customer->phone ?: 'Not provided' }}</dd><dt>Lifetime order value</dt><dd>₹{{ number_format((float) $customer->orders->where('status', '!=', 'cancelled')->sum('total_amount'), 2) }}</dd></dl>
</section>
<section class="admin-panel admin-list-panel">
    <div class="admin-panel-heading"><div><span class="panel-step">OR</span><div><h2>Order history</h2><p>Latest customer orders and COD progress.</p></div></div></div>
    <div class="admin-table-wrap">
        <table class="admin-data-table">
            <thead><tr><th>Order</th><th>Date</th><th>Items</th><th>Total</th><th>COD</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse($customer->orders as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong></td><td>{{ $order->created_at->format('d M Y') }}</td><td>{{ $order->items->sum('quantity') }}</td>
                    <td class="admin-price">₹{{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ $order->payment_status === 'collected' ? 'Collected' : 'Pending' }}</td>
                    <td>{{ \App\Models\Order::STATUSES[$order->status] ?? ucfirst($order->status) }}</td>
                    <td><a class="admin-row-action" href="{{ route('admin.orders.show', $order->order_number) }}">Details →</a></td>
                </tr>
            @empty
                <tr><td colspan="7"><div class="admin-table-empty"><strong>No orders on this account</strong><span>The customer can still place an order as a guest.</span></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
