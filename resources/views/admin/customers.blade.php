@extends('admin.layout')
@section('title', 'Customers | JPL TRADERS Admin')
@section('content')
<section class="admin-page-heading">
    <div><p class="admin-eyebrow">CUSTOMER DIRECTORY</p><h1>Customers</h1><p>Registered accounts and their order history. Guest buyers remain visible in order details.</p></div>
    <span class="admin-count-pill">{{ $customers->total() }} registered</span>
</section>
<section class="admin-panel admin-list-panel">
    <div class="admin-panel-heading"><div><span class="panel-step">@include('admin.partials.icon', ['name' => 'customers'])</span><div><h2>Customer accounts</h2><p>Contact details and lifetime order value.</p></div></div></div>
    <div class="admin-table-wrap">
        <table class="admin-data-table">
            <thead><tr><th>Customer</th><th>Phone</th><th>Orders</th><th>Order value</th><th>Joined</th><th></th></tr></thead>
            <tbody>
            @forelse($customers as $customer)
                <tr>
                    <td><strong>{{ $customer->name }}</strong><small>{{ $customer->email }}</small></td>
                    <td>{{ $customer->phone ?: '—' }}</td>
                    <td><span class="admin-product-count">{{ $customer->orders_count }}</span></td>
                    <td class="admin-price">₹{{ number_format((float) ($customer->order_total ?? 0), 2) }}</td>
                    <td>{{ $customer->created_at->format('d M Y') }}</td>
                    <td><a class="admin-row-action" href="{{ route('admin.customers.show', $customer->id) }}">Details <span aria-hidden="true">→</span></a></td>
                </tr>
            @empty
                <tr><td colspan="6"><div class="admin-table-empty"><strong>No registered customers yet</strong><span>Guest orders are still saved in the order register.</span></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $customers->links() }}</div>
</section>
@endsection
