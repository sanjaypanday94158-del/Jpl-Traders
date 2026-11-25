@extends('admin.layout')
@section('title', 'Categories | JPL TRADERS Admin')
@section('content')
<section class="admin-page-heading">
    <div>
        <p class="admin-eyebrow">CATALOG STRUCTURE</p>
        <h1>Categories</h1>
        <p>Create clear product groups and assign them when adding products.</p>
    </div>
    <div class="admin-heading-actions">
        <span class="admin-count-pill">{{ $categories->total() }} categories</span>
        <button type="button" class="admin-button admin-button-primary" data-admin-modal-open="categoryModal">Add category <span aria-hidden="true">+</span></button>
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
        <div><span class="panel-step">01</span><div><h2>Category directory</h2><p>Product count and storefront availability.</p></div></div>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-data-table">
            <thead><tr><th>Category</th><th>Slug</th><th>Products</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($categories as $category)
                <tr>
                    <td><span class="admin-entity-mark entity-category">CA</span><strong>{{ $category->name }}</strong></td>
                    <td class="admin-muted">{{ $category->slug }}</td>
                    <td><span class="admin-product-count">{{ $category->products_count }}</span></td>
                    <td><span class="admin-status {{ $category->is_active ? 'status-active' : 'status-hidden' }}">{{ $category->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        <div class="admin-row-actions">
                            <button type="button" class="admin-row-action" data-admin-modal-open="categoryModal" data-record-id="{{ $category->id }}" data-record-name="{{ $category->name }}" data-record-icon="{{ $category->icon ?? 'cpu' }}" data-record-is-active="{{ $category->is_active ? '1' : '0' }}">Edit</button>
                            @if($category->products_count === 0)
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" data-confirm="Delete the {{ $category->name }} category?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-row-action admin-row-action-danger">Delete</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5"><div class="admin-table-empty"><strong>No categories yet</strong><span>Create your first catalog category using “Add category”.</span></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $categories->links() }}</div>
</section>
<dialog class="admin-modal" id="categoryModal" data-open-on-error="{{ $errors->any() ? 'true' : 'false' }}">
    <form action="{{ route('admin.categories.store') }}" method="POST" class="admin-modal-form" data-admin-modal-form data-create-action="{{ route('admin.categories.store') }}" data-update-base="{{ url('/admin/categories') }}" data-create-title="Add category" data-edit-title="Edit category" data-create-submit="Save category" data-edit-submit="Update category">
        @csrf
        <input type="hidden" data-method-field>
        <header class="admin-modal-heading">
            <div><p class="admin-eyebrow">CATALOG STRUCTURE</p><h2 data-modal-title>Add category</h2></div>
            <button type="button" class="admin-modal-close" data-admin-modal-close aria-label="Close dialog">&times;</button>
        </header>
        <label>Category name<input name="name" value="{{ old('name') }}" maxlength="100" placeholder="e.g. Networking" required></label>
        <label>Icon name
            <span class="category-icon-control">
                <input name="icon" data-category-icon-input list="categoryIconNames" value="{{ old('icon') }}" maxlength="30" placeholder="e.g. laptop" autocomplete="off">
                <span class="category-icon-preview" data-category-icon-preview aria-hidden="true">
                    @include('partials.icon', ['name' => old('icon', 'cpu'), 'size' => 24])
                </span>
            </span>
            <small data-category-icon-message role="status" aria-live="polite">Type an icon name to preview it.</small>
        </label>
        <datalist id="categoryIconNames">
            @foreach($iconNames as $iconName)<option value="{{ $iconName }}">@endforeach
        </datalist>
        <div class="category-icon-templates" hidden aria-hidden="true">
            @foreach($iconNames as $iconName)
                <span data-category-icon-template="{{ $iconName }}">@include('partials.icon', ['name' => $iconName, 'size' => 24])</span>
            @endforeach
        </div>
        <label class="admin-checkbox"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', '1'))> Active and available for products</label>
        <footer><button type="button" class="admin-button admin-button-quiet" data-admin-modal-close>Cancel</button><button type="submit" class="admin-button admin-button-primary"><span data-modal-submit>Save category</span><span aria-hidden="true">→</span></button></footer>
    </form>
</dialog>
@endsection
