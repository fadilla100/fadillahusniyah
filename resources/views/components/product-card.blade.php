<div class="mt-auto">
    @if($product->has_discount)
        <p class="fw-bold text-danger mb-0">{{ $product->formatted_price }}</p>
        <small class="text-decoration-line-through text-muted">{{ $product->formatted_original_price }}</small>
    @else
        <p class="fw-bold text-primary mb-0">{{ $product->formatted_price }}</p>
    @endif

   @auth
<button
    type="button"
    class="btn btn-outline-danger btn-sm w-100 mt-2 wishlist-btn"
    data-product-id="{{ $product->id }}">
    🤍 Wishlist
</button>
@else
<a href="{{ route('login') }}" class="btn btn-outline-danger btn-sm w-100 mt-2">
    Login untuk Wishlist
</a>
@endauth

</div>
