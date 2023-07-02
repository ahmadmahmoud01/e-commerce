<div class="might-like-section">
    <div class="container">
        <h2>You might also like...</h2>
        <div class="might-like-grid">

            @forelse ($mightAlsoLike as $product)

                <a href="{{ url(route('shop.show', $product->slug)) }}" class="might-like-product">
                    <img src="{{ productImage($product->image) }}" alt="product">
                    <div class="might-like-product-name">{{ $product->name }}</div>
                    <div class="might-like-product-price">${{ number_format($product->price, 2) }}</div>
                </a>

            @empty
                <h3>....</h3>
            @endforelse



        </div>
    </div>
</div>
