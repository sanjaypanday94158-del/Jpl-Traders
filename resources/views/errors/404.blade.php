@extends('layouts.app')
@section('title', '404 | Page Not Found')
@section('content')
<section class="shell page-container">
    <div class="page-panel" style="text-align:center">
        <h1>404 - Page Not Found</h1>
        <p>The page you requested does not exist.</p>
        <a href="{{ url('/') }}" class="primary">Go to Homepage</a>
    </div>
</section>
@endsection
