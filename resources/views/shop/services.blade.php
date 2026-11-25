@extends('layouts.app')
@section('title', 'Services | JPL TRADERS')
@section('content')
<section class="services-page-banner" aria-label="JPL TRADERS services banner">
    <img src="/banners/services-banner.png" alt="Complete IT and computer solutions">
</section>
<main class="services-clone-page">
    <section class="shell services-practical-panel" data-scroll-reveal>
        <div class="services-practical-copy">
            <p><i></i> TECHNOLOGY SUPPORT, CLOSE TO HOME</p>
            <h2>Practical help for the<br>tech you rely on.</h2>
            <span>From everyday devices to workplace equipment, find the right kind of support for your requirements.</span>
            <a href="{{ url('/contact') }}">Tell us what you need @include('partials.icon',['name'=>'arrow-right','size'=>16])</a>
        </div>
        <div class="services-practical-list">
            @foreach([
                ['laptop','Home','Personal devices','services-orange'],
                ['printer','Business','Office equipment','services-blue'],
                ['building','Institution','IT supply needs','services-green']
            ] as $item)
                <a href="{{ url('/contact') }}" class="services-practical-row {{ $item[3] }}">
                    <span>@include('partials.icon',['name'=>$item[0],'size'=>20])</span>
                    <div><b>{{ $item[1] }}</b><small>{{ $item[2] }}</small></div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="shell services-clone-section">
        <div class="services-clone-heading">
            <h2>Services for your setup.</h2>
            <span></span>
        </div>
        <div class="inner-service-grid">
            @foreach([
                ['laptop','Computer & Laptop Repair','DEVICE CARE','Diagnosing computer and laptop issues, with repair options discussed around your device and requirements.','blue'],
                ['printer','Printer & Photocopier Service','OFFICE EQUIPMENT','Ask about troubleshooting and servicing for printers, photocopiers and other office equipment.','violet'],
                ['shield','AMC & Maintenance','ONGOING SUPPORT','Discuss ongoing maintenance for your computers and office equipment, with scope suited to your setup.','green'],
                ['cpu','Software Installation','SETUP','Get assistance installing and setting up software for your computer or workplace.','amber'],
                ['database','Data Recovery','DATA ASSISTANCE','Talk to the team about data access or recovery concerns and the available next steps.','cyan'],
                ['network','Network Setup','CONNECTIVITY','Plan connectivity and network equipment for your home, office or institution.','indigo'],
                ['building','Bulk IT Supply','BUSINESS & INSTITUTIONS','Share your organisation product list or quantity needs to discuss an IT supply enquiry.','orange'],
                ['wrench','On-site Support','LOCAL ASSISTANCE','Ask whether on-site support is available for your location and issue.','rose']
            ] as $service)
                <article class="inner-service-card services-clone-card {{ $service[4] }}">
                    <div class="services-card-top">
                        <span class="inner-service-icon">@include('partials.icon',['name'=>$service[0],'size'=>24])</span>
                        <p>{{ $service[2] }}</p>
                    </div>
                    <h3>{{ $service[1] }}</h3>
                    <div class="services-card-description">{{ $service[3] }}</div>
                    <a href="{{ url('/contact') }}">Ask about this service @include('partials.icon',['name'=>'arrow-right','size'=>14])</a>
                </article>
            @endforeach
        </div>
    </section>

    <section class="services-support-section">
        <div class="shell services-support-grid">
            <div class="services-support-image">
                <img src="/banners/repair.jpg" alt="Technician repairing computer hardware">
                <div class="services-support-image-overlay"></div>
                <span class="services-desk-label"><i></i> JPL service desk</span>
                <div class="services-support-image-copy">
                    <p>Local expertise</p>
                    <h2>We’ll help get your tech back on track.</h2>
                    <small>@include('partials.icon',['name'=>'map-pin','size'=>14]) Sidhari, Azamgarh</small>
                </div>
            </div>
            <div class="services-support-copy">
                <p class="services-support-kicker"><i></i> Support for every setup</p>
                <h2>Good support starts with <span>the right conversation.</span></h2>
                <p>Tell us what you’re working with and what you need. We’ll help you understand the available options, one step at a time.</p>
                <div class="services-support-types">
                    <div><span>@include('partials.icon',['name'=>'wrench','size'=>16])</span><b>Repair</b><small>Devices &amp; equipment</small></div>
                    <div><span>@include('partials.icon',['name'=>'laptop','size'=>16])</span><b>Workplace</b><small>Office IT support</small></div>
                    <div><span>@include('partials.icon',['name'=>'building','size'=>16])</span><b>Supply</b><small>Bulk enquiries</small></div>
                </div>
                <a href="{{ url('/contact') }}">Talk to our team @include('partials.icon',['name'=>'arrow-right','size'=>16])</a>
            </div>
        </div>
    </section>

    <section class="shell services-process-section">
        <div class="services-process-heading">
            <div>
                <p><i></i> HOW IT WORKS</p>
                <h2>From first question to next step.</h2>
            </div>
        </div>
        <div class="services-process-grid">
            @foreach([
                ['message','Tell us what you need','Share the device, equipment or IT setup you need help with.','orange'],
                ['network','Talk through the options','Our team discusses suitable products or support for your enquiry.','blue'],
                ['shield','Confirm the details','Check availability, service scope and pricing directly with the store.','green']
            ] as $index => $step)
                <article>
                    <div><span class="{{ $step[3] }}">@include('partials.icon',['name'=>$step[0],'size'=>19])</span></div>
                    <h3>{{ $step[1] }}</h3>
                    <p>{{ $step[2] }}</p>
                </article>
            @endforeach
        </div>
        <div class="services-process-action">
            <div><h3>Ready to discuss your requirement?</h3><p>Get in touch or share the details for a quotation.</p></div>
            <div>
                <a class="orange" href="{{ url('/contact') }}">Contact us @include('partials.icon',['name'=>'arrow-right','size'=>15])</a>
                <a class="outline" href="{{ url('/quote') }}">Request a quote @include('partials.icon',['name'=>'arrow-right','size'=>15])</a>
            </div>
        </div>
    </section>
</main>
@endsection
