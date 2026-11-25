<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JPL TRADERS')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="theme-color" content="#082653">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="{{ request()->is('institutional') ? 'institutional-page' : (request()->is('contact') ? 'contact-page' : '') }}">
    @php $cartCount = array_sum(array_map('intval', (array) session('cart', []))); @endphp
    <header class="site-header">
        <div class="top-strip">
            <div class="shell top-strip-inner">
                <span class="top-location">
                    @include('partials.icon',['name'=>'map-pin','size'=>13])
                    <span>Sidhari, Azamgarh, Uttar Pradesh &nbsp; | &nbsp; <b class="desktop-only">Computer &amp; IT Solutions</b></span>
                </span>
                <span class="top-clock">
                    @include('partials.icon',['name'=>'clock','size'=>13])
                    <b id="indiaTime">--:--:--</b>
                    <i></i>
                    <span id="indiaDate">Loading date</span>
                </span>
                <div class="top-support">
                    <a href="{{ url('/contact') }}">Help &amp; Support</a>
                    <span aria-hidden="true">|</span>
                    @auth
                        <a href="{{ route('account.index') }}">My Account</a>
                    @else
                        <a href="{{ route('customer.login') }}">Sign in</a>
                    @endauth
                </div>
            </div>
        </div>
        <div class="main-header">
            <div class="shell header-inner">
                <a href="{{ url('/') }}" class="brand" aria-label="JPL Traders home">
                    <img src="/jpl-traders-logo.png" alt="JPL Traders">
                </a>
                <form action="{{ route('products') }}" class="header-search">
                    <span class="header-search-icon">@include('partials.icon',['name'=>'search','size'=>17])</span>
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search laptops, computers, printers, accessories...">
                    <button type="submit" aria-label="Search">
                        @include('partials.icon',['name'=>'search','size'=>17])
                    </button>
                </form>
                <a href="{{ url('/cart') }}" class="cart-button" aria-label="Shopping cart">
                    @include('partials.icon',['name'=>'cart','size'=>24])
                    <b>{{ $cartCount }}</b>
                </a>
                <a href="{{ url('/quote') }}" class="quote-button">Get a Quote</a>
                <button type="button" class="menu-button" id="menuButton" aria-expanded="false" aria-controls="mobileMenu"><span></span><span></span><span></span></button>
            </div>
        </div>
        <nav class="desktop-nav" aria-label="Main navigation">
            <div class="shell nav-inner">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
                <span class="nav-pipe" aria-hidden="true"></span>
                <a href="{{ route('products') }}" class="{{ request()->is('products*') ? 'active' : '' }}">Products</a>
                <span class="nav-pipe" aria-hidden="true"></span>
                <a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a>
                <span class="nav-pipe" aria-hidden="true"></span>
                <a href="{{ url('/services') }}" class="{{ request()->is('services') ? 'active' : '' }}">Services</a>
                <span class="nav-pipe" aria-hidden="true"></span>
                <a href="{{ url('/institutional') }}" class="{{ request()->is('institutional') ? 'active' : '' }}">Government Tenders</a>
                <span class="nav-pipe" aria-hidden="true"></span>
                <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a>
            </div>
        </nav>
        <div class="mobile-overlay" id="mobileOverlay"></div>
        <nav class="mobile-menu" id="mobileMenu" aria-label="Mobile navigation">
            @foreach([
                '/' => 'Home',
                '/products' => 'Products',
                '/about' => 'About',
                '/services' => 'Services',
                '/institutional' => 'Government Tenders',
                '/contact' => 'Contact'
            ] as $url => $label)
                <a href="{{ url($url) }}">{{ $label }}</a>
            @endforeach
        </nav>
    </header>

    <main>@yield('content')</main>

    <footer class="site-footer">
        <div class="footer-decoration" aria-hidden="true"></div>
        <div class="shell footer-grid">
            <div>
                <a href="{{ url('/') }}" class="footer-brand"><img src="/jpl-traders-logo.png" alt="JPL Traders"></a>
                <p>Computer sales, office equipment, accessories, repairing and institutional IT solutions.</p>
                <p class="footer-address">@include('partials.icon',['name'=>'map-pin','size'=>15]) <span>Sidhari, Azamgarh, UP</span></p>
                <h3 class="footer-social-heading">Follow us</h3>
                <div class="footer-socials" aria-label="Social media">
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" aria-label="Instagram" title="Instagram" class="instagram">
                        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="17.4" cy="6.6" r="1" fill="currentColor"/></svg>
                    </a>
                    <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" aria-label="Facebook" title="Facebook" class="facebook">
                        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M13.7 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.5 1.6-1.5H17V3.9c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3V10H7.6v3h2.7v8h3.4Z" fill="currentColor"/></svg>
                    </a>
                    <a href="https://www.youtube.com/" target="_blank" rel="noopener noreferrer" aria-label="YouTube" title="YouTube" class="youtube">
                        <svg viewBox="0 0 24 24" width="21" height="21" aria-hidden="true"><path d="M21.2 7.1a2.7 2.7 0 0 0-1.9-1.9C17.6 4.8 12 4.8 12 4.8s-5.6 0-7.3.4a2.7 2.7 0 0 0-1.9 1.9A28 28 0 0 0 2.4 12a28 28 0 0 0 .4 4.9 2.7 2.7 0 0 0 1.9 1.9c1.7.4 7.3.4 7.3.4s5.6 0 7.3-.4a2.7 2.7 0 0 0 1.9-1.9A28 28 0 0 0 21.6 12a28 28 0 0 0-.4-4.9ZM10 15.5v-7l6 3.5-6 3.5Z" fill="currentColor"/></svg>
                    </a>
                </div>
            </div>
            <div>
                <h3>Quick Links</h3>
                <a class="footer-link" href="{{ route('products') }}">@include('partials.icon',['name'=>'cpu','size'=>15]) <span>Products</span></a>
                <a class="footer-link" href="{{ url('/services') }}">@include('partials.icon',['name'=>'wrench','size'=>15]) <span>Services</span></a>
                <a class="footer-link" href="{{ url('/about') }}">@include('partials.icon',['name'=>'building','size'=>15]) <span>About</span></a>
                <a class="footer-link" href="{{ url('/contact') }}">@include('partials.icon',['name'=>'phone','size'=>15]) <span>Contact</span></a>
            </div>
            <div>
                <h3>Customer Care</h3>
                <a class="footer-link" href="{{ url('/faq') }}">@include('partials.icon',['name'=>'headphone','size'=>15]) <span>FAQ</span></a>
                <a class="footer-link" href="{{ url('/payment') }}">@include('partials.icon',['name'=>'shield','size'=>15]) <span>Payment</span></a>
                <a class="footer-link" href="{{ url('/quote') }}">@include('partials.icon',['name'=>'message','size'=>15]) <span>Quote</span></a>
                @auth
                    <a class="footer-link" href="{{ route('account.index') }}">@include('partials.icon',['name'=>'cart','size'=>15]) <span>My orders</span></a>
                @else
                    <a class="footer-link" href="{{ route('orders.track-lookup') }}">@include('partials.icon',['name'=>'cart','size'=>15]) <span>Track an order</span></a>
                @endauth
            </div>
            <div>
                <h3>Visit our shop</h3>
                <p>Sidhari, Azamgarh, Uttar Pradesh</p>
                <p class="footer-note">Phone, email and operating hours should be confirmed before publishing.</p>
            </div>
        </div>
        <div class="copyright">&copy; {{ date('Y') }} JPL TRADERS</div>
    </footer>

    <aside class="floating-actions" aria-label="Quick contact and social links">
        <div class="social-cluster">
        <div class="social-actions" id="socialActions">
            <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="instagram" title="Instagram">
                <svg viewBox="0 0 24 24" width="21" height="21" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="17.4" cy="6.6" r="1" fill="currentColor"/></svg>
            </a>
            <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="facebook" title="Facebook">
                <svg viewBox="0 0 24 24" width="21" height="21" aria-hidden="true"><path d="M13.7 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.5 1.6-1.5H17V3.9c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3V10H7.6v3h2.7v8h3.4Z" fill="currentColor"/></svg>
            </a>
            <a href="https://www.youtube.com/" target="_blank" rel="noopener noreferrer" aria-label="YouTube" class="youtube" title="YouTube">
                <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path d="M21.2 7.1a2.7 2.7 0 0 0-1.9-1.9C17.6 4.8 12 4.8 12 4.8s-5.6 0-7.3.4a2.7 2.7 0 0 0-1.9 1.9A28 28 0 0 0 2.4 12a28 28 0 0 0 .4 4.9 2.7 2.7 0 0 0 1.9 1.9c1.7.4 7.3.4 7.3.4s5.6 0 7.3-.4a2.7 2.7 0 0 0 1.9-1.9A28 28 0 0 0 21.6 12a28 28 0 0 0-.4-4.9ZM10 15.5v-7l6 3.5-6 3.5Z" fill="currentColor"/></svg>
            </a>
        </div>
        <button type="button" class="social-toggle" id="socialToggle" aria-expanded="false" aria-controls="socialActions" aria-label="Show social links" title="Social links">
            <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><circle cx="18" cy="5" r="2.5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="6" cy="12" r="2.5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="18" cy="19" r="2.5" fill="none" stroke="currentColor" stroke-width="2"/><path d="m8.3 10.8 7.4-4.4M8.3 13.2l7.4 4.4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <span>Social Media</span>
        </button>
        </div>
        <a href="https://wa.me/?text=Hello%20JPL%20TRADERS" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp" title="Chat on WhatsApp" class="whatsapp">
            <svg viewBox="0 0 32 32" width="29" height="29" aria-hidden="true">
                <path d="M27.3 4.7A15.7 15.7 0 0 0 16 0C7.7 0 1 6.7 1 15c0 2.6.7 5.2 2 7.5L.7 32l9.8-2.6A15 15 0 0 0 16 30.7C24.3 30.7 31 24 31 15.7c0-4.2-1.3-8.1-3.7-11ZM16 28.2c-1.9 0-3.8-.5-5.4-1.4l-.4-.2-5.8 1.5 1.5-5.7-.3-.5A12.8 12.8 0 0 1 3.3 15c0-7 5.7-12.7 12.7-12.7 3.4 0 6.6 1.3 9 3.7a12.6 12.6 0 0 1 3.7 9c0 7-5.7 13.2-12.7 13.2Zm7-9.5c-.4-.2-2.3-1.1-2.7-1.3-.4-.1-.7-.2-.9.2-.3.4-1 1.3-1.3 1.5-.2.3-.5.3-.9.1-.4-.2-1.7-.6-3.2-2-1.2-1-2-2.3-2.2-2.7-.2-.4 0-.6.2-.8l.6-.7c.2-.2.3-.4.4-.7.1-.2 0-.5 0-.7-.1-.2-.9-2.1-1.2-2.9-.3-.8-.7-.7-.9-.7h-.8c-.3 0-.7.1-1.1.5-.4.4-1.4 1.3-1.4 3.2s1.4 3.7 1.6 4c.2.3 2.8 4.3 6.8 6 .9.4 1.7.7 2.3.9 1 .3 1.8.3 2.5.2.8-.1 2.3-.9 2.6-1.8.3-.9.3-1.7.2-1.8-.1-.2-.4-.3-.8-.5Z" fill="currentColor"/>
            </svg>
        </a>
    </aside>
    @include('partials.global-loader')
</body>
</html>
