@extends('admin.layout')
@section('title', 'Products | Admin')
@section('content')
<section class="admin-page-heading">
    <div>
        <p class="admin-eyebrow">CATALOG MANAGEMENT</p>
        <h1>Products</h1>
        <p>Manage product details, SKU codes, categories and brands.</p>
    </div>
    <div class="admin-heading-actions">
        <span class="admin-count-pill">{{ $products->total() }} total</span>
        <button type="button" class="admin-button admin-button-primary" data-admin-modal-open="productModal">Add product <span aria-hidden="true">+</span></button>
    </div>
</section>
@if(session('success'))<div class="admin-alert admin-alert-success">{{ session('success') }}</div>@endif
@if($errors->any())
    <div class="admin-alert admin-alert-error">
        <strong>Please review the form:</strong>
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif
@if($categories->isEmpty() || $brands->isEmpty())
    <div class="admin-alert admin-alert-note">
        Add at least one active
        @if($categories->isEmpty() && $brands->isEmpty())
            <a href="{{ route('admin.categories') }}">category</a> and <a href="{{ route('admin.brands') }}">brand</a>
        @elseif($categories->isEmpty())
            <a href="{{ route('admin.categories') }}">category</a>
        @else
            <a href="{{ route('admin.brands') }}">brand</a>
        @endif
        before creating a product.
    </div>
@endif
<section class="admin-panel admin-list-panel">
    <div class="admin-panel-heading admin-list-heading">
        <div><span class="panel-step">01</span><div><h2>Product list</h2><p>SKU, category, brand and storefront visibility.</p></div></div>
        <span class="admin-count-pill">{{ $products->total() }} items</span>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-data-table">
            <thead><tr><th>Product / SKU</th><th>Category</th><th>Brand</th><th>Stock</th><th>Price</th><th>Visibility</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        <div class="admin-product-cell">
                            <img class="admin-product-thumbnail" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            <div><strong>{{ $product->name }}</strong><small>SKU: {{ $product->sku ?: 'Not assigned' }}</small></div>
                        </div>
                    </td>
                    <td>{{ $product->categoryRecord?->name ?? $product->category }}</td>
                    <td>{{ $product->brandRecord?->name ?? $product->brand }}</td>
                    <td>{{ $product->stock_quantity === null ? 'Unlimited' : number_format($product->stock_quantity) }}</td>
                    <td class="admin-price">₹{{ number_format($product->price, 2) }}</td>
                    <td><span class="admin-status {{ $product->is_active ? 'status-active' : 'status-hidden' }}">{{ $product->is_active ? 'Visible' : 'Hidden' }}</span></td>
                    <td><button type="button" class="admin-row-action" data-admin-modal-open="productModal"
                        data-record-id="{{ $product->id }}"
                        data-record-sku="{{ $product->sku }}"
                        data-record-name="{{ $product->name }}"
                        data-record-category-id="{{ $product->category_id }}"
                        data-record-brand-id="{{ $product->brand_id }}"
                        data-record-stock-quantity="{{ $product->stock_quantity ?? '' }}"
                        data-record-price="{{ $product->price }}"
                        data-record-old-price="{{ $product->old_price }}"
                        data-record-rating="{{ $product->rating }}"
                        data-record-image-url="{{ $product->image_url }}"
                        data-record-description="{{ $product->description }}"
                        data-record-is-active="{{ $product->is_active ? '1' : '0' }}">Edit</button></td>
                </tr>
            @empty
                <tr><td colspan="7"><div class="admin-table-empty"><strong>No products yet</strong><span>Add your first product using “Add product”.</span></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $products->links() }}</div>
</section>
<dialog class="admin-modal admin-modal-wide" id="productModal" data-open-on-error="{{ $errors->any() ? 'true' : 'false' }}">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="admin-modal-form" data-admin-modal-form data-create-action="{{ route('admin.products.store') }}" data-update-base="{{ url('/admin/products') }}" data-create-title="Add product" data-edit-title="Edit product" data-create-submit="Save product" data-edit-submit="Update product">
        @csrf
        <input type="hidden" data-method-field>
        <header class="admin-modal-heading">
            <div><p class="admin-eyebrow">CATALOG MANAGEMENT</p><h2 data-modal-title>Add product</h2></div>
            <button type="button" class="admin-modal-close" data-admin-modal-close aria-label="Close dialog">&times;</button>
        </header>
        @if($categories->isEmpty() || $brands->isEmpty())
            <div class="admin-alert admin-alert-note">
                Add an active <a href="{{ route('admin.categories') }}">category</a> and <a href="{{ route('admin.brands') }}">brand</a> before saving a product.
            </div>
        @endif
        <div class="admin-modal-fields">
            <label>Product name<input name="name" data-product-name-input value="{{ old('name') }}" maxlength="150" placeholder="e.g. Business Laptop 15" required></label>
            <label>SKU (automatically generated)<input name="sku" data-product-sku-input value="{{ old('sku') }}" maxlength="80" placeholder="Type a product name first" readonly required></label>
            <label>Category
                <select name="category_id" required @disabled($categories->isEmpty())>
                    <option value="">Select category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </label>
            <label>Brand
                <select name="brand_id" required @disabled($brands->isEmpty())>
                    <option value="">Select brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </label>
            <label>Quantity in stock<input name="stock_quantity" data-product-stock-input type="number" min="0" max="4294967295" value="{{ old('stock_quantity', '0') }}" placeholder="0 = out of stock" required><small data-product-stock-message>Existing blank quantities mean unlimited stock; new products start at 0.</small></label>
            <label>Selling price (₹)<input name="price" type="number" min="0" step="0.01" value="{{ old('price') }}" placeholder="0.00" required></label>
            <label>Previous price (₹)<input name="old_price" type="number" min="0" step="0.01" value="{{ old('old_price') }}" placeholder="Optional"></label>
            <label>Rating<input name="rating" type="number" min="0" max="5" step="0.1" value="{{ old('rating') }}" placeholder="0 to 5"></label>
            <label class="admin-modal-wide-field">Product image
                <input type="file" name="image" data-product-image-input accept="image/jpeg,image/png,image/webp" required>
                <img class="product-image-preview" data-product-image-preview alt="Product image preview" hidden>
                <small data-product-image-status>Upload a JPG, PNG, or WebP image (max 5 MB).</small>
            </label>
            <label class="admin-modal-wide-field">Description<textarea name="description" maxlength="3000" rows="3" placeholder="Short product details">{{ old('description') }}</textarea></label>
            <label class="admin-checkbox"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', '1'))> Visible in the storefront</label>
        </div>
        <footer><button type="button" class="admin-button admin-button-quiet" data-admin-modal-close>Cancel</button><button type="submit" class="admin-button admin-button-primary" @disabled($categories->isEmpty() || $brands->isEmpty())><span data-modal-submit>Save product</span><span aria-hidden="true">→</span></button></footer>
    </form>
</dialog>
@endsection
