@extends('base.base')

@section('content')
<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<style>
    .product-details {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: flex-start;
        gap: 40px;
        padding: 50px;
    }

    .product-image img {
        max-width: 400px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .product-info {
        max-width: 500px;
    }

    .product-info h1 {
        font-size: 2.5rem;
        font-weight: bold;
    }

    .product-info .description {
        font-size: 1.1rem;
        margin-top: 10px;
        color: #555;
    }

    .product-info .price {
        font-size: 1.8rem;
        font-weight: 600;
        color: #222;
        margin-top: 15px;
    }

    .product-info select,
    .product-info input[type="number"] {
        margin-top: 15px;
        padding: 10px;
        width: 100%;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .product-info button {
        margin-top: 20px;
        padding: 12px 20px;
        background-color: black;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .product-info button:hover {
        background-color: #333;
    }

    .wishlist-button {
        display: inline-block;
        margin-top: 15px;
        color: #666;
        cursor: pointer;
        text-decoration: underline;
    }
</style>

<div class="product-details" data-aos="fade-up">
    <div class="product-image">
        <img src="{{ $product['image'] }}" 
             alt="{{ $product['name'] }}" 
             class="img-fluid"
             onerror="this.onerror=null; this.src='{{ asset('images/default.png') }}';">
    </div>

    <div class="product-info">
        <h1>{{ $product['name'] }}</h1>
        <p class="description">{{ $product['description'] }}</p>
        <p class="price">Rp{{ number_format($product['price'], 0, ',', '.') }}</p>

        <!-- Size and Color Selection -->
        <select>
            <option value="size">Select Size</option>
            <option value="s">Small</option>
            <option value="m">Medium</option>
            <option value="l">Large</option>
        </select>

        <select>
            <option value="color">Select Color</option>
            <option value="black">Black</option>
            <option value="white">White</option>
            <option value="red">Red</option>
        </select>

        <input
        type="number"
        id="quantity"
        name="quantity"
        min="1"
        max="100"
        step="1"
        placeholder="Quantity"
        oninput="this.value = Math.min(this.value, 100)"
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black"
        />

        <!-- Add to Cart Button -->
        <button onclick="alert('Added to cart: {{ $product['name'] }}')">Add to Cart</button>

        <!-- Add to Wishlist -->
        <span class="wishlist-button" onclick="alert('Added to wishlist')"> Add to Wishlist <i class="far fa-heart"></i></span>
    </div>
</div>

<script>
    AOS.init();
</script>
@endsection
