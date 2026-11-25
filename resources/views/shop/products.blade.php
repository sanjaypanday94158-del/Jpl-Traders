@extends('layouts.app')

@section('title', 'Shop Products | JPL TRADERS')

@section('content')
<section class="products-page-banner" aria-label="JPL TRADERS products banner">
    <img src="/banners/products-banner.png" alt="Discover a wide range of computers and IT products">
</section>
<section class="shell page-container products-catalog-section" aria-labelledby="catalogTitle">
    <nav class="catalog-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <span aria-hidden="true">/</span>
        <strong>Products</strong>
    </nav>
    <div class="catalog-heading">
        <div class="catalog-title-block">
            <p class="catalog-eyebrow">JPL TRADERS COLLECTION</p>
            <h1 id="catalogTitle">Shop <span>Products</span></h1>
            <p class="catalog-description">Explore dependable computers, printers and accessories, backed by knowledgeable local support.</p>
        </div>
        <div class="catalog-heading-aside">
            <span class="catalog-count">
                @include('partials.icon',['name'=>'cpu','size'=>17])
                <b>{{ $products->total() }}</b>
                {{ $products->total() === 1 ? 'product' : 'products' }} available
            </span>
            <span class="catalog-heading-note">Trusted brands <i></i> Local support</span>
        </div>
    </div>
    <div class="catalog-layout">
        <button type="button" class="catalog-mobile-toggle" id="catalogFilterToggle" aria-expanded="false" aria-controls="catalogFilters">
            @include('partials.icon',['name'=>'cpu','size'=>16])
            <span>Refine products</span>
            <b id="catalogFilterLabel">Show filters</b>
        </button>
        <aside class="catalog-filters" id="catalogFilters">
            <div class="catalog-filter-title">
                <h2 class="catalog-filter-heading">
                    @include('partials.icon',['name'=>'cpu','size'=>15])
                    Refine your search
                </h2>
                @if(request('category') || request('brand') || request('search'))
                    <a href="{{ route('products') }}">Clear all</a>
                @endif
            </div>
            <fieldset class="catalog-filter-fieldset">
                <legend>Category</legend>
                <a href="{{ route('products') }}" class="{{ !request('category') ? 'active' : '' }}">All categories</a>
                @foreach($categories as $category)
                    <a href="{{ route('products', ['category' => $category->name]) }}" class="{{ request('category') === $category->name ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </fieldset>
            <fieldset class="catalog-filter-fieldset catalog-brand-fieldset">
                <legend>Brand</legend>
                @foreach($brands as $brand)
                    <a href="{{ route('products', ['brand' => $brand, 'category' => request('category')]) }}" class="{{ request('brand') === $brand ? 'active' : '' }}">
                        {{ $brand }}
                    </a>
                @endforeach
            </fieldset>
        </aside>
        <div class="catalog-results">
            <form action="{{ route('products') }}" class="catalog-toolbar">
                <label class="catalog-search">
                    @include('partials.icon',['name'=>'search','size'=>17])
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search products or brands" aria-label="Search products or brands">
                </label>
                <button type="submit" class="catalog-search-button">Search</button>
                <label class="catalog-sort">
                    <span>Sort:</span>
                    <select name="sort" onchange="this.form.submit()" aria-label="Sort products">
                        <option value="">Default</option>
                        <option value="low" @selected(request('sort') === 'low')>Price: Low to High</option>
                        <option value="high" @selected(request('sort') === 'high')>Price: High to Low</option>
                    </select>
                </label>
            </form>
            <div class="catalog-results-heading">
                <h2>Available products</h2>
                <span>Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}</span>
            </div>
            <div class="product-grid">
                @forelse($products as $product)
                    @php
                        $discount = $product->old_price
                            ? round((1 - ($product->price / $product->old_price)) * 100)
                            : 0;
                    @endphp
                    <article class="product-card">
                        <a href="{{ route('product.show', $product->sku ?: $product->slug) }}" class="product-card-link">
                            <div class="product-card-media">
                                @if($discount > 0)<span class="discount-badge">{{ $discount }}% OFF</span>@endif
                                <span class="wish-button">@include('partials.icon',['name'=>'heart','size'=>16])</span>
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            </div>
                            <div class="product-meta">
                                <span class="product-brand">{{ $product->brand }}</span>
                                <span class="product-category">{{ $product->category }}</span>
                            </div>
                            @if($product->rating !== null || $product->stock_quantity !== null)
                                <div class="product-card-status">
                                    @include('partials.product-rating', ['product' => $product])
                                    @if($product->stock_quantity !== null)
                                        <span class="product-stock-label {{ $product->stock_quantity === 0 ? 'product-out-of-stock' : '' }}">
                                            {{ $product->stock_quantity === 0 ? 'Out of stock' : $product->stock_quantity.' in stock' }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <div class="product-prices">
                                <strong class="price">₹{{ number_format($product->price, 0) }}</strong>
                                @if($product->old_price)<del>₹{{ number_format($product->old_price, 0) }}</del>@endif
                            </div>
                        </a>
                        <form action="{{ route('cart.items.store') }}" method="POST" class="product-card-cart-form">
                            @csrf
                            <input type="hidden" name="slug" value="{{ $product->slug }}">
                            <button type="submit" class="add-cart" @disabled($product->stock_quantity === 0)>
                                @include('partials.icon',['name'=>'cart','size'=>14])
                                <span>{{ $product->stock_quantity === 0 ? 'Out of stock' : 'Add to Cart' }}</span>
                            </button>
                        </form>
                    </article>
                @empty
                    <div class="catalog-empty">
                        <span class="catalog-empty-icon">@include('partials.icon',['name'=>'search','size'=>22])</span>
                        <h3>No matching products</h3>
                        <p>Try changing your search or clearing the selected filters.</p>
                        <a href="{{ route('products') }}">View all products</a>
                    </div>
                @endforelse
            </div>
            <div class="pagination">{{ $products->links() }}</div>
        </div>
    </div>
</section>
@include('partials.institutional-banner')
@endsection
