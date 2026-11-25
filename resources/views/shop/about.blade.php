@extends('layouts.app')
@section('title', 'About Us | JPL TRADERS')
@section('content')
<section class="about-page-banner" aria-label="About JPL TRADERS">
    <img src="/banners/about-banner.png" alt="About JPL TRADERS">
</section>
<section class="shell about-content-section">
    <div class="about-section-heading">
        <h2>Technology support. Made dependable.</h2>
        <span></span>
    </div>
    <div class="about-offerings">
        @foreach([
            ['laptop','Computers & accessories','Explore laptops, desktops, components and everyday computer essentials.','Explore products','products'],
            ['printer','Printers & office equipment','Find equipment for home, office and institutional requirements.','View equipment','products'],
            ['wrench','Repair & maintenance','Talk to our team about computer, printer and related support needs.','See our services','services'],
            ['building','Business & bulk enquiries','Share your organisation’s requirements and ask us about a quotation.','Discuss a requirement','quote']
        ] as $item)
            <article class="about-offering-card">
                <span class="about-offering-icon">@include('partials.icon',['name'=>$item[0],'size'=>19])</span>
                <h3>{{ $item[1] }}</h3>
                <p>{{ $item[2] }}</p>
                <a href="{{ url('/'.$item[4]) }}">{{ $item[3] }} @include('partials.icon',['name'=>'arrow-right','size'=>14])</a>
            </article>
        @endforeach
    </div>
    <div class="about-store-grid">
        <div class="about-store-image">
            <img src="/shop/jpl-store-showcase.png" alt="JPL TRADERS store">
            <div class="about-store-options">
                <div>@include('partials.icon',['name'=>'laptop','size'=>28])<b>Laptops &amp;<br>Desktops</b></div>
                <div>@include('partials.icon',['name'=>'printer','size'=>28])<b>Printers &amp;<br>Peripherals</b></div>
                <div>@include('partials.icon',['name'=>'wrench','size'=>28])<b>Repair &amp;<br>Service</b></div>
                <div>@include('partials.icon',['name'=>'building','size'=>28])<b>Government<br>Supply &amp; Tenders</b></div>
            </div>
        </div>
        <div class="about-detail-card">
            <div class="about-detail-top">ABOUT JPL TRADERS</div>
            <h2>Computer and IT solutions, <em>locally in Azamgarh.</em></h2>
            <p class="about-detail-lead">JPL TRADERS is a computer and electronics store in Sidhari, serving individuals, businesses and institutions with product guidance and practical technology support.</p>
            <div class="about-detail-stats">
                <div><b>Computers</b><span>Laptops, desktops &amp; accessories</span></div>
                <div><b>Office</b><span>Printers &amp; workplace equipment</span></div>
                <div><b>Support</b><span>Repair &amp; supply assistance</span></div>
            </div>
            <div class="about-detail-notes">
                <p>Whether you need a system for daily use, office equipment or support for an existing device, our team helps you review the available options.</p>
                <p>Stock and service availability may vary. We confirm the details with the store so you can make an informed decision.</p>
            </div>
            <a class="about-detail-action" href="{{ url('/contact') }}">Discuss your requirement <span>@include('partials.icon',['name'=>'arrow-right','size'=>16])</span></a>
            <div class="about-detail-location">@include('partials.icon',['name'=>'map-pin','size'=>14]) Sidhari, Azamgarh</div>
        </div>
    </div>
</section>
@include('partials.institutional-banner')
@endsection
