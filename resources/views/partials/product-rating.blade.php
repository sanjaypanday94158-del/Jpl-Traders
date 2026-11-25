@if($product->rating !== null)
    <span class="product-rating" aria-label="Rating {{ number_format($product->rating, 1) }} out of 5">
        @include('partials.icon', ['name' => 'star', 'size' => 13])
        {{ number_format($product->rating, 1) }} / 5
    </span>
@endif
