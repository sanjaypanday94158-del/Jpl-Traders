@extends('layouts.app')

@section('title', $product->name.' | JPL TRADERS')

@section('content')
@php
    $discount = $product->old_price
        ? round((1 - ($product->price / $product->old_price)) * 100)
        : 0;
@endphp
<section class="shell page-container product-detail-page">
    <nav class="product-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ url('/') }}">Home</a><span>/</span>
        <a href="{{ route('products') }}">Products</a><span>/</span>
        <strong>{{ $product->name }}</strong>
    </nav>
    <div class="detail-layout">
        <div class="detail-visual">
            @if($discount > 0)
                <span class="detail-discount">{{ $discount }}% OFF</span>
            @endif
            <div class="detail-image-viewport" data-product-zoom>
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" data-product-zoom-image>
            </div>
            <div class="detail-zoom-controls" role="group" aria-label="Product image zoom controls">
                <button type="button" data-product-zoom-out aria-label="Zoom out" title="Zoom out">−</button>
                <output data-product-zoom-level aria-live="polite">100%</output>
                <button type="button" data-product-zoom-in aria-label="Zoom in" title="Zoom in">+</button>
                <button type="button" class="detail-zoom-reset" data-product-zoom-reset aria-label="Reset zoom" title="Reset zoom">Reset</button>
            </div>
            <span class="detail-image-label">JPL TRADERS · PRODUCT DETAILS</span>
        </div>
        <div class="detail-copy">
            <div class="detail-meta">
                <span class="detail-brand">{{ $product->brand }}</span>
                <span class="detail-category">{{ $product->category }}</span>
                @include('partials.product-rating', ['product' => $product])
            </div>
            <p class="detail-eyebrow">PRODUCT INFORMATION</p>
            <h1>{{ $product->name }}</h1>
            <div class="detail-prices">
                <strong class="price">₹{{ number_format($product->price, 0) }}</strong>
                @if($product->old_price)
                    <del>₹{{ number_format($product->old_price, 0) }}</del>
                @endif
                @if($discount > 0)
                    <span class="detail-saving">{{ $discount }}% savings</span>
                @endif
            </div>
            <p class="detail-description">{{ $product->description }}</p>
            <section class="detail-facts" aria-labelledby="detailFactsHeading">
                <h2 id="detailFactsHeading">Product details</h2>
                <dl>
                    <div>
                        <dt>Product code</dt>
                        <dd>{{ $product->sku ?: 'JPL-'.$product->id }}</dd>
                    </div>
                    <div>
                        <dt>Availability</dt>
                        <dd class="detail-availability {{ $product->stock_quantity === 0 ? 'product-out-of-stock' : ($product->stock_quantity === null ? 'detail-availability-unknown' : '') }}">
                            @if($product->stock_quantity === null)
                                Confirm with store
                            @elseif($product->stock_quantity === 0)
                                Out of stock
                            @else
                                {{ $product->stock_quantity }} {{ $product->stock_quantity === 1 ? 'unit' : 'units' }} in stock
                            @endif
                        </dd>
                    </div>
                </dl>
            </section>
            <div class="detail-actions">
                <form action="{{ route('cart.items.store') }}" method="POST" class="detail-cart-form">
                    @csrf
                    <input type="hidden" name="slug" value="{{ $product->slug }}">
                    <button type="submit" class="secondary detail-cart-button" @disabled($product->stock_quantity === 0)>
                        @include('partials.icon',['name'=>'cart','size'=>17])
                        {{ $product->stock_quantity === 0 ? 'Out of stock' : 'Add to Cart' }}
                    </button>
                </form>
                <a href="{{ url('/quote') }}" class="primary detail-enquiry-button">
                    Buy / Enquire
                    @include('partials.icon',['name'=>'arrow-right','size'=>16])
                </a>
            </div>
            <p class="detail-note">Our team can confirm availability and warranty details for this product.</p>
        </div>
    </div>
</section>
@endsection
