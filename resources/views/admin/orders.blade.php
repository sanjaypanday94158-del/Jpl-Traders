@extends('admin.layout')
@section('title', 'Orders | JPL TRADERS Admin')
@section('content')
<section class="admin-page-heading">
    <div><p class="admin-eyebrow">SALES &amp; FULFILMENT</p><h1>Orders</h1><p>Review customer details, COD amounts and the latest delivery status.</p></div>
    <span class="admin-count-pill">{{ $orders->total() }} total orders</span>
</section>
<section class="admin-panel admin-list-panel">
    <div class="admin-panel-heading">
        <div><span class="panel-step">@include('admin.partials.icon', ['name' => 'orders'])</span><div><h2>Order register</h2><p>Open any order to update its delivery timeline.</p></div></div>
        <span class="order-cod-key">COD only · No online payments</span>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-data-table">
            <thead><tr><th>Order</th><th>Customer</th><th>Items</th><th>Order total</th><th>COD payment</th><th>Status</th><th>Placed</th><th></th></tr></thead>
            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong><small>{{ $order->payment_method === 'cash_on_delivery' ? 'Cash on delivery' : $order->payment_method }}</small></td>
                    <td><strong>{{ $order->customer_name }}</strong><small>{{ $order->customer_phone }}</small></td>
                    <td>{{ $order->items_count }}</td>
                    <td class="admin-price">₹{{ number_format($order->total_amount, 2) }}</td>
                    <td><span class="admin-status {{ $order->payment_status === 'collected' ? 'status-active' : 'status-hidden' }}">{{ $order->payment_status === 'collected' ? 'Collected' : 'Due on delivery' }}</span></td>
                    <td><span class="admin-status {{ in_array($order->status, ['delivered', 'confirmed'], true) ? 'status-active' : 'status-hidden' }}">{{ \App\Models\Order::STATUSES[$order->status] ?? ucfirst($order->status) }}</span></td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td><a class="admin-row-action" href="{{ route('admin.orders.show', $order->order_number) }}">Details <span aria-hidden="true">→</span></a></td>
                </tr>
            @empty
                <tr><td colspan="8"><div class="admin-table-empty"><strong>No orders yet</strong><span>Customer orders placed through checkout will appear here.</span></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $orders->links() }}</div>
</section>
@endsection
