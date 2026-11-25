@extends('admin.layout')
@section('title', 'Dashboard | JPL TRADERS')
@section('content')
<section class="admin-welcome">
    <div>
        <p class="admin-eyebrow">YOUR STORE AT A GLANCE</p>
        <h1>Good to see you.</h1>
        <p>Manage your JPL catalog and keep your store information up to date.</p>
    </div>
    <a class="admin-button admin-button-primary" href="{{ route('admin.products') }}#productModal">Add a product <span aria-hidden="true">+</span></a>
</section>
<section class="stats-grid" aria-label="Store overview">
    <article class="stat-card">
        <span class="stat-icon stat-icon-blue">PR</span>
        <span class="stat-label">Total products</span>
        <strong>{{ number_format($productCount) }}</strong>
        <span class="stat-footnote">In your catalog</span>
    </article>
    <article class="stat-card">
        <span class="stat-icon stat-icon-orange">CA</span>
        <span class="stat-label">Categories</span>
        <strong>{{ number_format($categoryCount) }}</strong>
        <span class="stat-footnote">Catalog groups</span>
    </article>
    <article class="stat-card">
        <span class="stat-icon stat-icon-violet">BR</span>
        <span class="stat-label">Brands</span>
        <strong>{{ number_format($brandCount) }}</strong>
        <span class="stat-footnote">Available brands</span>
    </article>
    <article class="stat-card">
        <span class="stat-icon stat-icon-green">OR</span>
        <span class="stat-label">Orders</span>
        <strong>{{ number_format($orderCount) }}</strong>
        <span class="stat-footnote">{{ number_format($ordersToday) }} placed today</span>
    </article>
    <article class="stat-card">
        <span class="stat-icon stat-icon-orange">₹</span>
        <span class="stat-label">Order value</span>
        <strong>₹{{ number_format($orderedAmount, 2) }}</strong>
        <span class="stat-footnote">Excludes cancelled orders</span>
    </article>
    <article class="stat-card">
        <span class="stat-icon stat-icon-violet">COD</span>
        <span class="stat-label">COD collected</span>
        <strong>₹{{ number_format($codCollectedAmount, 2) }}</strong>
        <span class="stat-footnote">Confirmed collections</span>
    </article>
    <article class="stat-card">
        <span class="stat-icon stat-icon-orange">DUE</span>
        <span class="stat-label">COD awaiting</span>
        <strong>₹{{ number_format($codPendingAmount, 2) }}</strong>
        <span class="stat-footnote">Pending collection</span>
    </article>
    <article class="stat-card">
        <span class="stat-icon stat-icon-blue">CU</span>
        <span class="stat-label">Customer accounts</span>
        <strong>{{ number_format($customerCount) }}</strong>
        <span class="stat-footnote">Registered customers</span>
    </article>
    <article class="stat-card">
        <span class="stat-icon stat-icon-green">EN</span>
        <span class="stat-label">New enquiries</span>
        <strong>{{ number_format($newEnquiries) }}</strong>
        <span class="stat-footnote">{{ number_format($enquiryCount) }} total received</span>
    </article>
</section>
<section class="admin-section">
    <div class="admin-section-heading">
        <div>
            <p class="admin-eyebrow">QUICK ACCESS</p>
            <h2>Manage your catalog</h2>
        </div>
        <span>Keep products organized and easy to discover.</span>
    </div>
    <div class="admin-shortcuts">
        <a href="{{ route('admin.products') }}">
            <span class="shortcut-icon shortcut-blue">PR</span>
            <span><strong>Products</strong><small>Add items and assign a brand and category.</small></span>
            <b aria-hidden="true">→</b>
        </a>
        <a href="{{ route('admin.categories') }}">
            <span class="shortcut-icon shortcut-orange">CA</span>
            <span><strong>Categories</strong><small>Organize products into clear groups.</small></span>
            <b aria-hidden="true">→</b>
        </a>
        <a href="{{ route('admin.brands') }}">
            <span class="shortcut-icon shortcut-violet">BR</span>
            <span><strong>Brands</strong><small>Maintain a consistent brand directory.</small></span>
            <b aria-hidden="true">→</b>
        </a>
        <a href="{{ route('admin.orders') }}">
            <span class="shortcut-icon shortcut-blue">OR</span>
            <span><strong>Orders</strong><small>Update delivery progress and COD collection.</small></span>
            <b aria-hidden="true">→</b>
        </a>
        <a href="{{ route('admin.customers') }}">
            <span class="shortcut-icon shortcut-orange">CU</span>
            <span><strong>Customers</strong><small>Review registered customer accounts and order history.</small></span>
            <b aria-hidden="true">→</b>
        </a>
    </div>
</section>
@endsection
