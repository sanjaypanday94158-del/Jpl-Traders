@extends('admin.layout')
@section('title', 'Brands | JPL TRADERS Admin')
@section('content')
<section class="admin-page-heading">
    <div>
        <p class="admin-eyebrow">CATALOG STRUCTURE</p>
        <h1>Brands</h1>
        <p>Keep brand names consistent across all your products.</p>
    </div>
    <div class="admin-heading-actions">
        <span class="admin-count-pill">{{ $brands->total() }} brands</span>
        <button type="button" class="admin-button admin-button-primary" data-admin-modal-open="brandModal">Add brand <span aria-hidden="true">+</span></button>
    </div>
</section>
@if(session('success'))<div class="admin-alert admin-alert-success">{{ session('success') }}</div>@endif
@if($errors->any())
    <div class="admin-alert admin-alert-error">
        <strong>Please review the form:</strong>
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif
<section class="admin-panel admin-list-panel">
    <div class="admin-panel-heading admin-list-heading">
        <div><span class="panel-step">01</span><div><h2>Brand directory</h2><p>Product count and catalog availability.</p></div></div>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-data-table">
            <thead><tr><th>Brand</th><th>Slug</th><th>Products</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($brands as $brand)
                <tr>
                    <td><span class="admin-entity-mark entity-brand">BR</span><strong>{{ $brand->name }}</strong></td>
                    <td class="admin-muted">{{ $brand->slug }}</td>
                    <td><span class="admin-product-count">{{ $brand->products_count }}</span></td>
                    <td><span class="admin-status {{ $brand->is_active ? 'status-active' : 'status-hidden' }}">{{ $brand->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td><button type="button" class="admin-row-action" data-admin-modal-open="brandModal" data-record-id="{{ $brand->id }}" data-record-name="{{ $brand->name }}" data-record-is-active="{{ $brand->is_active ? '1' : '0' }}">Edit</button></td>
                </tr>
            @empty
                <tr><td colspan="5"><div class="admin-table-empty"><strong>No brands yet</strong><span>Create your first brand using “Add brand”.</span></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $brands->links() }}</div>
</section>
<dialog class="admin-modal" id="brandModal" data-open-on-error="{{ $errors->any() ? 'true' : 'false' }}">
    <form action="{{ route('admin.brands.store') }}" method="POST" class="admin-modal-form" data-admin-modal-form data-create-action="{{ route('admin.brands.store') }}" data-update-base="{{ url('/admin/brands') }}" data-create-title="Add brand" data-edit-title="Edit brand" data-create-submit="Save brand" data-edit-submit="Update brand">
        @csrf
        <input type="hidden" data-method-field>
        <header class="admin-modal-heading">
            <div><p class="admin-eyebrow">CATALOG STRUCTURE</p><h2 data-modal-title>Add brand</h2></div>
            <button type="button" class="admin-modal-close" data-admin-modal-close aria-label="Close dialog">&times;</button>
        </header>
        <label>Brand name<input name="name" value="{{ old('name') }}" maxlength="100" placeholder="e.g. Lenovo" required></label>
        <label class="admin-checkbox"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', '1'))> Active and available for products</label>
        <footer><button type="button" class="admin-button admin-button-quiet" data-admin-modal-close>Cancel</button><button type="submit" class="admin-button admin-button-primary"><span data-modal-submit>Save brand</span><span aria-hidden="true">→</span></button></footer>
    </form>
</dialog>
@endsection
