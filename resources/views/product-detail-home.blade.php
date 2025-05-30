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
        font-family: 'Cormorant', serif;
    }

    .product-info .description {
        font-size: 1.1rem;
        margin-top: 10px;
        color: #555;
        font-family: 'Cormorant', serif;

    }

    .dark-mode .product-info .description {
        color: white;
    }

    .product-info .price {
        font-size: 1.8rem;
        font-weight: 600;
        color: #222;
        margin-top: 15px;
        font-family: 'Cormorant', serif;

    }

    .dark-mode .product-info .price {
        color: white;
    }

    .product-info select,
    .product-info input[type="number"] {
        margin-top: 15px;
        padding: 10px;
        width: 100%;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-family: 'Cormorant', serif;
        color: black;

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
        font-size: 16px;
        text-decoration: underline;
    }

    .dark-mode .wishlist-button {
        color: white;
    }

    .back-button {
        display: block;
        margin-top: 15px;
        color: #666;
        cursor: pointer;
        text-decoration: underline;
    }

    .back-button-top {
        position: absolute;
        top: 20px;
        left: 40px;
        color: #666;
        cursor: pointer;
        text-decoration: underline;
        font-family: 'Cormorant', serif;
        font-weight: 500;
        font-size: 20px;
    }

    .dark-mode .back-button-top {
        color: white;
    }
</style>

<div class="container py-5 position-relative">

    <!-- Back Button -->
    <div class="back-button-top" onclick="window.location.href='{{ route('home') }}'">
        ← Back To Home
    </div>

    <div class="product-details" data-aos="fade-up">
        <div class="product-image">
            <img src="{{ $product['image'] }}" 
                 alt="{{ $product['name'] }}" 
                 class="img-fluid"
                 onerror="this.onerror=null; this.src='{{ asset('fotoBaju.jpg') }}';">
        </div>

        <div class="product-info">
            <h1>{{ $product['name'] }}</h1>
            <p class="description">{{ $product['description'] }}</p>
            <p class="price">Rp{{ number_format($product['price'], 0, ',', '.') }}</p>

            <!-- Size and Color Selection -->
            <!-- Size Selection -->
            @if (!empty($product['sizes']))
                <div>
                    <select>
                        <option value="">Select Size</option>
                        @foreach ($product['sizes'] as $size)
                            <option value="{{ strtolower($size) }}">{{ $size }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <input type="number" id="quantity" name="quantity" min="1" max="100" step="1" placeholder="Quantity"
                oninput="this.value = Math.min(this.value, 100)"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black" />

            <button onclick="alert('Added to cart: {{ $product['name'] }}')">Add to Cart</button>

            <span class="wishlist-button" onclick="alert('Added to wishlist')">
                Add to Wishlist <i class="far fa-heart"></i>
            </span>
        </div>
    </div>
</div>

<script>
    AOS.init();
</script>
@endsection
