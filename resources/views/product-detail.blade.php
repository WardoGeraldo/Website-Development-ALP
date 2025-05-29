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

    #product-image-slider button {
        background-color: black;
        color: white;
        padding: 8px 14px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-family: 'Cormorant', serif;
        transition: background-color 0.3s;
    }

    #product-image-slider button:hover {
        background-color: #444;
    }
</style>

<div class="container py-5 position-relative">

    <!-- Back Button -->
    <div class="back-button-top" onclick="window.location.href='{{ route('store.show') }}'">
        ← Back To Store
    </div>

    <div class="product-details" data-aos="fade-up">
        <div class="product-image" id="product-image-slider">
            <img id="mainImage"
                src="{{ $product['images'][0] ?? asset('fotoBaju.jpg') }}"
                alt="{{ $product['name'] }}"
                class="img-fluid"
                onerror="this.onerror=null; this.src='{{ asset('fotoBaju.jpg') }}';" />
            
            <div style="margin-top: 10px; text-align: center;">
                <button onclick="changeImage(-1)" style="margin-right: 10px;">← Prev</button>
                <button onclick="changeImage(1)">Next →</button>
            </div>
        </div>


        <div class="product-info">
            <h1>{{ $product['name'] }}</h1>
            <p class="description">{{ $product['description'] }}</p>
            <p class="price">Rp{{ number_format($product['price'], 0, ',', '.') }}</p>

           <form action="{{ route('cart.add') }}" method="POST">
                @csrf

                <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                <input type="hidden" name="name" value="{{ $product['name'] }}">
                <input type="hidden" name="price" value="{{ $product['price'] }}">

                @if (!empty($product['sizes']))
                    <div>
                        <select name="size" required>
                            <option value="">Select Size</option>
                            @foreach ($product['sizes'] as $size)
                                <option value="{{ $size }}">{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="size" value="One Size">
                @endif

                <input type="number" name="quantity" min="1" max="100" value="1"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black" />

                <button type="submit">Add to Cart</button>
            </form>
            <span class="wishlist-button" onclick="alert('Added to wishlist')">
                Add to Wishlist <i class="far fa-heart"></i>
            </span>
        </div>
    </div>
</div>

<script>
    AOS.init();
</script>

<script>
    AOS.init();

    const images = @json($product['images']);
    let currentImageIndex = 0;

    function changeImage(direction) {
        currentImageIndex += direction;

        if (currentImageIndex < 0) {
            currentImageIndex = images.length - 1;
        } else if (currentImageIndex >= images.length) {
            currentImageIndex = 0;
        }

        const imgElement = document.getElementById('mainImage');
        imgElement.src = images[currentImageIndex];
    }
</script>

@endsection
