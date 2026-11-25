@extends('layouts.app')
@section('title', 'Request a Quote | JPL TRADERS')
@section('content')
<section class="shell page-container">
    <div class="page-panel">
        <h1>Request a Quote</h1>
        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif
        <form action="{{ route('enquiry.submit') }}" method="POST" class="form-grid">
            @csrf
            <label>Name<input type="text" name="name" value="{{ old('name') }}" required></label>
            <label>Phone<input type="text" name="phone" value="{{ old('phone') }}" required></label>
            <label>Email<input type="email" name="email" value="{{ old('email') }}"></label>
            <label>Subject<input type="text" name="subject" value="{{ old('subject', $quoteDetails ? 'Quote for shopping cart' : 'Product or service quote') }}" required></label>
            <label class="full">Requirement<textarea name="message" required>{{ old('message', $quoteDetails) }}</textarea></label>
            <button type="submit" class="primary full">Submit Request</button>
        </form>
    </div>
</section>
@endsection
