@extends('layouts.app')
@section('title', 'Contact Us | JPL TRADERS')
@section('content')
<section class="contact-page-banner" aria-labelledby="contact-banner-title">
    <img src="/banners/contact-banner.png" alt="Contact JPL TRADERS for product enquiries, service support and tenders">
    <h1 class="page-banner-title" id="contact-banner-title">Contact JPL TRADERS</h1>
</section>
<section class="contact-content-section">
    <div class="shell">
        <div class="contact-layout">
            <aside class="contact-info-card">
                <span class="contact-eyebrow">Visit or contact us</span>
                <h2>How can we help?</h2>
                <p class="contact-info-intro">Talk to JPL TRADERS about products, service support or a quotation for your requirements.</p>
                <div class="contact-info-row">
                    <span class="contact-info-icon">@include('partials.icon',['name'=>'map-pin','size'=>19])</span>
                    <div><b>Address</b><p>Sidhari, Azamgarh, Uttar Pradesh</p></div>
                </div>
                <div class="contact-info-row">
                    <span class="contact-info-icon">@include('partials.icon',['name'=>'phone','size'=>19])</span>
                    <div><b>Phone</b><p>Contact number to be confirmed</p></div>
                </div>
                <div class="contact-info-row">
                    <span class="contact-info-icon">@include('partials.icon',['name'=>'mail','size'=>19])</span>
                    <div><b>Email</b><p>Email address to be confirmed</p></div>
                </div>
                <div class="contact-info-row">
                    <span class="contact-info-icon">@include('partials.icon',['name'=>'headphone','size'=>19])</span>
                    <div><b>Customer support</b><p>Product, service and quotation enquiries</p></div>
                </div>
                <a href="{{ url('/quote') }}" class="secondary contact-quote-button">
                    Request a Quote
                    @include('partials.icon',['name'=>'arrow-right','size'=>16])
                </a>
            </aside>
            <div class="contact-form-card">
                <div class="contact-form-heading">
                    <span class="contact-eyebrow">Send an enquiry</span>
                    <h2>Tell us what you need</h2>
                    <p>Share a few details and our team can help with your product or service enquiry.</p>
                </div>
                @if(session('success'))
                    <div class="success-message">{{ session('success') }}</div>
                @endif
                <form action="{{ route('enquiry.submit') }}" method="POST" class="form-grid">
                    @csrf
                    <label>Name<input type="text" name="name" value="{{ old('name') }}" required></label>
                    <label>Phone<input type="text" name="phone" value="{{ old('phone') }}" required></label>
                    <label>Email<input type="email" name="email" value="{{ old('email') }}"></label>
                    <label>Subject<input type="text" name="subject" value="{{ old('subject') }}" required></label>
                    <label class="full">Message<textarea name="message" required>{{ old('message') }}</textarea></label>
                    <button type="submit" class="primary full">Send Enquiry @include('partials.icon',['name'=>'arrow-right','size'=>16])</button>
                </form>
            </div>
        </div>
        <section class="contact-map-card" aria-labelledby="contact-map-title">
            <div class="contact-map-heading">
                <div>
                    <span class="contact-eyebrow">Find us in Azamgarh</span>
                    <h2 id="contact-map-title">Visit JPL TRADERS</h2>
                    <p>Sidhari, Azamgarh, Uttar Pradesh</p>
                </div>
                <a href="https://www.google.com/maps/search/?api=1&amp;query=Sidhari%2C%20Azamgarh%2C%20Uttar%20Pradesh" target="_blank" rel="noopener noreferrer" class="contact-map-link">
                    Open in Google Maps
                    @include('partials.icon',['name'=>'arrow-right','size'=>15])
                </a>
            </div>
            <div class="contact-map-frame">
                <iframe
                    title="Map showing Sidhari, Azamgarh, Uttar Pradesh"
                    src="https://maps.google.com/maps?q=Sidhari%2C%20Azamgarh%2C%20Uttar%20Pradesh&amp;z=14&amp;output=embed"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen>
                </iframe>
            </div>
            <p class="contact-map-note">Map shows the Sidhari area. Please confirm the exact store location with our team before visiting.</p>
        </section>
    </div>
</section>
@include('partials.institutional-banner')
@endsection
