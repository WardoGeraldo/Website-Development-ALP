@extends('base.base')

@section('content')
<style>
    body {
        background-color: #fff;
        font-family: 'Inter', sans-serif;
        color: #333;
        transition: background 0.3s ease, color 0.3s ease;
    }
    body.dark-mode {
        background-color: #121212;
        color: #f5f5f5;
    }
    .wishlist-header {
        text-align: center;
        padding: 3rem 1rem 2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;

    }
    .wishlist-header h1 {
        font-size: 2.5rem;
        letter-spacing: 2px;
        margin-bottom: 0.5rem;
    }
    .heart-icon {
        width: 36px;
        height: 46px;
        vertical-align: middle;
        margin-right: 8px;
        padding-bottom: 12px;
        transition: transform 0.3s ease;
    }

    .wishlist-header h1:hover .heart-icon {
        transform: scale(1.2);
    }
    .wishlist-header p {
        color: #777;
        max-width: 480px;
        margin: 0 auto 2rem auto;
        padding-top: 5px
    }
    .wishlist-grid {
        max-width: 1000px;
        margin: auto;
        padding: 0 1.5rem 4rem;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .wishlist-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        gap: 1rem;
        transition: 0.3s;
    }

    .wishlist-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    body.dark-mode .wishlist-card {
        background: #1c1c1c;
        color: #f5f5f5;
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.1);
    }

    .wishlist-card img {
        width: 90px;
        height: 90px;
        border-radius: 0.5rem;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid #eee;
    }

    body.dark-mode .wishlist-card img {
        border-color: #444;
    }

    .wishlist-info {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .wishlist-info h4 {
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.25rem;
    }

    .wishlist-info span {
        font-size: 0.95rem;
        font-weight: 500;
        color: #444;
    }

    .wishlist-meta {
        display: flex;
        gap: 1.5rem;
        margin-top: 0.25rem;
        font-size: 0.85rem;
        color: #777;
    }

    body.dark-mode .wishlist-info span,
    body.dark-mode .wishlist-meta {
        color: #ccc;
    }

    .wishlist-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.5rem;
    }

    .btn-add-cart {
        background: black;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-add-cart:hover {
        background: #e76767;
    }

    .btn-remove {
        background: transparent;
        border: none;
        color: #e76767;
        font-size: 1.3rem;
        cursor: pointer;
        padding: 0;
    }

    .btn-remove:hover {
        color: #b33a3a;
    }

    .back-button {
        display: block;
        margin-top: 15px;
        color: #666;
        cursor: pointer;
        text-decoration: underline;
        font-weight: 500;
        font-size: 20px;
    }

    .back-button-top {
        position: absolute;
        top: 200px;
        left: 550px;
        color: #666;
        cursor: pointer;
        text-decoration: underline;
        font-weight: 500;
        font-size: 20px;
    }
</style>

<div class="wishlist-header">
    <div class="back-button-top" onclick="window.location.href='{{ route('store.show') }}'">
        <b>← Back To Store</b>
    </div>
    <h1>
        Your Wishlist
        <img src="{{ asset('heartIcon.webp') }}" alt="heart" class="heart-icon">
    </h1>
    <p>Items you love and might want to buy soon.</p>
</div>


<div class="wishlist-grid">
    @php
        $wishlist = [
            ['id' => 1, 'name' => 'Oversized Tee', 'price' => 299000, 'image' => asset('fotoBaju.jpg')],
            ['id' => 2, 'name' => 'Minimalist Hoodie', 'price' => 499000, 'image' => asset('fotoBaju.jpg')],
            ['id' => 3, 'name' => 'Slim Fit Pants', 'price' => 399000, 'image' => asset('fotoBaju.jpg')],
            ['id' => 4, 'name' => 'Monochrome Cap', 'price' => 149000, 'image' => asset('fotoBaju.jpg')],
        ];
    @endphp

    @foreach($wishlist as $item)
    <div class="wishlist-card" data-aos="fade-up">
        <a href="{{ route('product.show', ['id' => $item['id']]) }}">
            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
        </a>

        <div class="wishlist-info">
            <a href="{{ route('product.show', ['id' => $item['id']]) }}" class="text-decoration-none text-dark">
                <h4>{{ $item['name'] }}</h4>
            </a>
            <span>Rp{{ number_format($item['price'], 0, ',', '.') }}</span>
            <div class="wishlist-meta">
                <div><strong>Size:</strong> M</div>
            </div>
        </div>

        <div class="wishlist-actions">
            <button class="btn-add-cart" onclick="alert('Added to cart: {{ $item['name'] }}')">Add to Cart</button>
            <button class="btn-remove" onclick="alert('Removed {{ $item['name'] }} from wishlist')">&times;</button>
        </div>
    </div>
    @endforeach

</div>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
</script>
@endsection