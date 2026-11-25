@extends('admin.layout')
@section('title', 'Enquiries | Admin')
@section('content')
<section class="admin-page-heading">
    <div>
        <p class="admin-eyebrow">CUSTOMER MESSAGES</p>
        <h1>Enquiries</h1>
        <p>Review and follow up on messages sent through your storefront.</p>
    </div>
    <span class="admin-count-pill">{{ $enquiries->total() }} total</span>
</section>
<section class="admin-panel admin-list-panel">
    <div class="admin-panel-heading">
        <div><span class="panel-step">IN</span><div><h2>Enquiry inbox</h2><p>Most recent messages first.</p></div></div>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-data-table">
            <thead><tr><th>Customer</th><th>Phone</th><th>Subject</th><th>Status</th><th>Date received</th></tr></thead>
            <tbody>
            @forelse($enquiries as $enquiry)
                <tr>
                    <td><strong>{{ $enquiry->name }}</strong><small>{{ $enquiry->email ?: 'No email provided' }}</small></td>
                    <td>{{ $enquiry->phone }}</td>
                    <td>{{ $enquiry->subject }}</td>
                    <td><span class="admin-status {{ $enquiry->status === 'New' ? 'status-active' : 'status-hidden' }}">{{ $enquiry->status }}</span></td>
                    <td>{{ $enquiry->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="5"><div class="admin-table-empty"><strong>No enquiries yet</strong><span>New storefront messages will appear here.</span></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $enquiries->links() }}</div>
</section>
@endsection
