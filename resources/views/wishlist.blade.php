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
    }
    .wishlist-header h1 {
        font-size: 2.5rem;
        letter-spacing: 2px;
        margin-bottom: 0.5rem;
    }
    .wishlist-header p {
        color: #777;
        max-width: 480px;
        margin: 0 auto 2rem auto;
    }
    .wishlist-grid {
        max-width: 1200px;
        margin: auto;
        padding: 0 1.5rem 4rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.75rem;
    }
    .wishlist-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden;
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
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-bottom: 1px solid #eee;
        transition: filter 0.3s;
    }
    body.dark-mode .wishlist-card img {
        border-color: #444;
    }
    .wishlist-info {
        padding: 1rem 1.2rem;
        text-align: center;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .wishlist-info h4 {
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    .wishlist-info span {
        font-size: 1rem;
        font-weight: 500;
        color: #444;
    }
    body.dark-mode .wishlist-info span {
        color: #ccc;
    }
    .wishlist-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1.2rem 1rem;
        gap: 0.75rem;
    }
    .btn-add-cart {
        background: black;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        cursor: pointer;
        flex-grow: 1;
        transition: background 0.2s ease;
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
        padding: 0 0.25rem;
        transition: color 0.2s ease;
    }
    .btn-remove:hover {
        color: #b33a3a;
    }
</style>

<div class="wishlist-header">
    <h1>Your Wishlist</h1>
    <p>Items you love and might want to buy soon.</p>
</div>

<div class="wishlist-grid">
    @php
        $wishlist = [
            ['name' => 'Oversized Tee', 'price' => 299000, 'image' => asset('fotoBaju.jpg')],
            ['name' => 'Minimalist Hoodie', 'price' => 499000, 'image' => asset('fotoBaju.jpg')],
            ['name' => 'Slim Fit Pants', 'price' => 399000, 'image' => asset('fotoBaju.jpg')],
            ['name' => 'Monochrome Cap', 'price' => 149000, 'image' => asset('fotoBaju.jpg')],
        ];
    @endphp

    @foreach($wishlist as $item)
    <div class="wishlist-card" data-aos="fade-up">
        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
        <div class="wishlist-info">
            <h4>{{ $item['name'] }}</h4>
            <span>Rp{{ number_format($item['price'], 0, ',', '.') }}</span>
        </div>
        <div class="wishlist-actions">
            <button class="btn-add-cart" onclick="alert('Added to cart: {{ $item['name'] }}')">Add to Cart</button>
            <button class="btn-remove" title="Remove from wishlist" onclick="alert('Removed {{ $item['name'] }} from wishlist')">&times;</button>
        </div>
    </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
</script>
@endsection