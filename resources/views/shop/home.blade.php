@extends('layouts.app')

@section('title', 'JPL TRADERS | Computers, Electronics & IT Services')

@section('content')
<div class="welcome-modal" id="welcomeModal" role="dialog" aria-modal="true" aria-labelledby="welcomeModalTitle" aria-hidden="true" data-open-immediately="{{ session()->has('newsletter_status') || $errors->newsletter->any() ? 'true' : 'false' }}">
    <button type="button" class="welcome-modal-backdrop" id="welcomeModalBackdrop" aria-label="Close welcome popup"></button>
    <div class="welcome-modal-card">
        <div class="welcome-modal-corners" aria-hidden="true">
            <span></span><span></span><span></span><span></span>
        </div>
        <aside class="welcome-newsletter-promo">
            <div class="welcome-logo-frame">
                <img class="welcome-modal-logo" src="/shop/jpl-cart-mark.png" alt="JPL Traders cart logo">
            </div>
            <div class="welcome-newsletter-promo-copy">
                <p class="welcome-newsletter-brand">JPL TRADERS <span>NEWSLETTER</span></p>
                <h3>Good tech. Local advice.</h3>
                <p class="welcome-newsletter-promo-text">Get updates on new products, useful offers, and IT tips from JPL Traders.</p>
            </div>
            <div class="welcome-newsletter-location">
                @include('partials.icon',['name'=>'map-pin','size'=>14])
                <span>Sidhari, Azamgarh</span>
            </div>
        </aside>
        <section class="welcome-newsletter-content">
            <button type="button" class="welcome-modal-close" id="welcomeModalClose" aria-label="Close popup">
                <svg viewBox="0 0 24 24" width="19" height="19" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            </button>
            <p class="welcome-newsletter-eyebrow">NEWSLETTER SUBSCRIPTION</p>
            <h2 id="welcomeModalTitle">Stay in the loop.</h2>
            <p class="welcome-newsletter-intro">Enter your email and sign up to receive updates from the JPL team.</p>

            @if(session('newsletter_status'))
                <p class="welcome-newsletter-status" role="status">{{ session('newsletter_status') }}</p>
            @endif

            <form class="welcome-newsletter-form" method="POST" action="{{ route('newsletter.subscribe') }}">
                @csrf
                <label for="newsletterEmail">Email address</label>
                <div class="welcome-newsletter-field">
                    <input id="newsletterEmail" type="email" name="email" value="{{ old('email') }}" maxlength="254" autocomplete="email" placeholder="you@example.com" required aria-describedby="{{ $errors->newsletter->has('email') ? 'newsletterEmailError' : '' }}">
                    <button class="welcome-modal-primary" type="submit">Subscribe</button>
                </div>
                @error('email', 'newsletter')
                    <p class="welcome-newsletter-error" id="newsletterEmailError">{{ $message }}</p>
                @enderror
                <label class="welcome-newsletter-consent" for="newsletterConsent">
                    <input id="newsletterConsent" type="checkbox" name="consent" value="1" required aria-describedby="{{ $errors->newsletter->has('consent') ? 'newsletterConsentError' : '' }}" {{ old('consent') ? 'checked' : '' }}>
                    <span>I agree to receive JPL product updates, offers, and IT tips by email.</span>
                </label>
                @error('consent', 'newsletter')
                    <p class="welcome-newsletter-error" id="newsletterConsentError">{{ $message }}</p>
                @enderror
                <p class="welcome-newsletter-privacy">Your email will only be used for JPL newsletter updates.</p>
            </form>
            <a class="welcome-modal-secondary" href="{{ route('products') }}">Explore products</a>
        </section>
    </div>
</div>
<section class="hero" data-carousel>
    @foreach(['/banners/jpl-promo-1.webp','/banners/jpl-promo-2.webp','/banners/jpl-promo-3.webp'] as $index => $image)
        <img src="{{ $image }}" alt="JPL TRADERS featured offer" class="hero-slide {{ $index === 0 ? 'active' : '' }}" data-slide>
    @endforeach
    <button type="button" class="carousel-arrow prev" data-carousel-prev aria-label="Previous banner">&#8249;</button>
    <button type="button" class="carousel-arrow next" data-carousel-next aria-label="Next banner">&#8250;</button>
    <div class="carousel-controls">
        @foreach([0,1,2] as $index)
            <button type="button" class="carousel-dot {{ $index === 0 ? 'active' : '' }}" data-carousel-dot aria-label="Show banner {{ $index + 1 }}"></button>
        @endforeach
    </div>
</section>

<section class="promo-marquee" aria-label="JPL Traders products and services">
    <div class="promo-track">
        @foreach([0,1] as $copy)
            <div class="promo-group">
                @foreach(['Computers, Laptops & Accessories','Printer & Photocopier Sales','Repair & Servicing','Office Equipment & IT Solutions','Government & Institutional Supply'] as $item)
                    <span class="promo-item"><i class="promo-dot"></i>{{ $item }}</span>
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<section class="shell category-section">
    <div class="trust-grid">
        @foreach([
            ['Your local IT store','Visit JPL Traders in Sidhari, Azamgarh.','map-pin','01'],
            ['Office-ready solutions','Computers, printers, photocopiers and more.','building','02'],
            ['Service that stays','Repair, maintenance and on-site support.','wrench','03'],
            ['Made for your needs','Talk to our team about business and bulk orders.','headphone','04']
        ] as $item)
            <article class="trust-card">
                <div class="trust-icon">@include('partials.icon',['name'=>$item[2],'size'=>23])</div>
                <span class="trust-accent" aria-hidden="true"></span>
                <h2>{{ $item[0] }}</h2>
                <p>{{ $item[1] }}</p>
            </article>
        @endforeach
    </div>

    <div class="section-heading category-heading">
        <div>
            <h2>Shop by Category</h2>
            <div class="heading-line"></div>
        </div>
    </div>
    <div class="category-grid">
        @foreach($categories as $category)
            <a href="{{ route('products', ['category' => $category->name]) }}" class="category-card">
                @php
                    $icons = ['laptop','monitor','monitor','printer','copy','headphones','wifi','cpu'];
                    $categoryIcon = $category->icon ?: ($icons[$loop->index] ?? 'cpu');
                @endphp
                <span>@include('partials.icon',['name'=>$categoryIcon,'size'=>27])</span>
                {{ $category->name }}
            </a>
        @endforeach
    </div>
</section>

        <section class="shell store-banner-grid">
            <a href="{{ url('/services') }}" class="store-banner">
                <img src="/banners/repair.jpg" alt="Computer repair and upgrade services">
                <div class="store-banner-content">
                    <span class="banner-icon">@include('partials.icon',['name'=>'wrench','size'=>23])</span>
                    <p>EXPERT CARE FOR YOUR TECH</p>
                    <h3>Computer Repair &amp;<br>Upgrade Services</h3>
                    <div>Hardware · Software · Data Recovery · AMC</div>
                    <span class="primary">Book a Service</span>
                </div>
            </a>
            <a href="{{ url('/institutional') }}" class="store-banner">
                <img src="/banners/institutional.jpg" alt="Bulk and institutional solutions">
                <div class="store-banner-content">
                    <span class="banner-icon">@include('partials.icon',['name'=>'building','size'=>23])</span>
                    <p>SOLUTIONS THAT SCALE WITH YOU</p>
                    <h3>Bulk Supply &amp;<br>Institutional Solutions</h3>
                    <div>Computers · Printers · Office Equipment</div>
                    <span class="primary">Get a Quote</span>
                </div>
            </a>
        </section>

<section class="shell products-section">
    <div class="section-heading">
        <div>
            <h2>Featured Products</h2>
            <div class="heading-line"></div>
        </div>
        <a href="{{ route('products') }}" class="secondary section-view-button">
            <span class="section-view-text">View all products</span>
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
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
            <div class="featured-empty-state" role="status">
                <span class="featured-empty-icon">@include('partials.icon',['name'=>'laptop','size'=>27])</span>
                <div class="featured-empty-copy">
                    <p class="featured-empty-kicker">JPL TRADERS · FEATURED COLLECTION</p>
                    <h3>No featured products at the moment</h3>
                    <p>Looking for something specific? Contact our team to check availability and find the right option.</p>
                </div>
                <div class="featured-empty-actions">
                    <a href="{{ route('products') }}" class="featured-empty-browse">
                        Browse all products
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</section>

<section class="shell store-showcase" data-scroll-reveal>
    <div class="store-showcase-image">
        <img src="/shop/jpl-store-showcase.png" alt="JPL TRADERS store interior">
    </div>
    <div class="store-showcase-copy">
        <p class="store-showcase-kicker"><span></span> Visit us in Sidhari</p>
        <h2>Find the right tech, in person.</h2>
        <p class="store-showcase-description">Browse computers, printers and office equipment at JPL TRADERS. Our team can help you compare options and choose what works for you.</p>
        <p class="store-location">
            @include('partials.icon',['name'=>'map-pin','size'=>17])
            <span>Sidhari, Azamgarh, Uttar Pradesh</span>
        </p>
        <div class="store-showcase-actions">
            <a href="{{ url('/about') }}" class="primary">
                <span>About JPL TRADERS</span>
                @include('partials.icon',['name'=>'arrow-right','size'=>16])
            </a>
            <a href="{{ url('/contact') }}" class="store-contact-link">
                <span>Contact our team</span>
                @include('partials.icon',['name'=>'arrow-right','size'=>15])
            </a>
        </div>
    </div>
</section>

<section class="shell bulk-banner revealed" data-scroll-reveal>
    <div>
        <p style="color:#fed7aa;font-size:11px;font-weight:bold;letter-spacing:.16em;text-transform:uppercase">Business &amp; institutional supply</p>
        <h2>Need computers or office equipment in bulk?</h2>
        <p>Tell us what you need and request a customised quotation for your business or institution.</p>
    </div>
    <a href="{{ url('/quote') }}" class="primary bulk-quote-button">
        <span>Request a Quote</span>
        @include('partials.icon',['name'=>'arrow-right','size'=>16])
    </a>
</section>
@endsection
