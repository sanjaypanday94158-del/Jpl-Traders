@extends('layouts.app')
@section('title', 'Government Tenders | JPL TRADERS')
@section('content')
<section class="institutional-hero-banner" aria-labelledby="institutional-hero-title">
    <img src="/banners/institutional-banner.png" alt="JPL Traders government tenders and IT procurement banner">
    <h1 class="institutional-hero-title" id="institutional-hero-title">Government Tenders and Bulk Supply</h1>
</section>
<section class="shell institutional-info-section">
    <div class="institutional-info-copy">
        <h2>IT supply for offices &amp; institutions</h2>
        <p>Enquire about bulk computers, laptops, office printers, photocopiers, networking equipment, setup and technical services. Government tender participation and credentials must be verified before publishing specific claims.</p>
        <ul class="institutional-info-list">
            @foreach([
                'Bulk desktop & laptop requirements',
                'Office equipment and peripherals',
                'Networking and installation',
                'Customised institutional quotations'
            ] as $item)
                <li><span aria-hidden="true">✓</span>{{ $item }}</li>
            @endforeach
        </ul>
        <a class="institutional-info-cta" href="{{ url('/quote') }}">
            Request Institutional Quote
            @include('partials.icon',['name'=>'arrow-right','size'=>16])
        </a>
    </div>
    <div class="institutional-info-visual">
        <img src="/banners/institutional.jpg" alt="Computers, networking equipment and office technology for institutions">
    </div>
</section>
@include('partials.institutional-banner')
@endsection
