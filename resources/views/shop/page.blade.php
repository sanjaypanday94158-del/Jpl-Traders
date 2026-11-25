@extends('layouts.app')

@section('title', 'JPL TRADERS')

@section('content')
<section class="shell page-container">
    <div class="page-panel">
        <h1>{{ $title ?? 'JPL TRADERS' }}</h1>
        @yield('page-content')
    </div>
</section>
@endsection
