@extends('base.base')

@section('content')
<!-- Required CSS Libraries -->
<link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<style>
    :root {
        --primary: #ffffff;
        --secondary: #000000;
        --accent: #D4AF37;
        --accent-light: #F8F1D5;
        --accent-dark: #9E7C1F;
        --light-gray: #f9f9f9;
        --medium-gray: #e0e0e0;
        --text-primary: #000000;
        --text-secondary: #505050;
        --text-accent: #D4AF37;
        --transition: cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* Dark mode variable overrides */
    body.dark-mode {
        --primary: #121212;
        --secondary: #f5f5f5;
        --light-gray: #1e1e1e;
        --medium-gray: #333333;
        --text-primary: #f5f5f5;
        --text-secondary: #aaaaaa;
    }

    body,
    html {
        background-color: var(--primary);
        color: var(--text-primary);
        font-family: 'Montserrat', sans-serif;
        overflow-x: hidden;
        cursor: default;
        transition: background 0.3s ease, color 0.3s ease;
    }

    /* Pattern Overlay */
    .pattern-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 0;
        opacity: 1;
    }

    /* Gold accents */
    .gold-accent {
        position: absolute;
        width: 30%;
        height: 30%;
        background: linear-gradient(45deg, rgba(212, 175, 55, 0.1), rgba(212, 175, 55, 0.02));
        filter: blur(20px);
        border-radius: 50%;
        z-index: 0;
        pointer-events: none;
    }

    .gold-accent-1 {
        top: -10%;
        right: 5%;
        animation: float 20s infinite alternate;
    }

    .gold-accent-2 {
        bottom: 10%;
        left: 5%;
        animation: float 25s infinite alternate-reverse;
    }

    @keyframes float {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }

        50% {
            transform: translate(10px, 15px) rotate(3deg);
        }

        100% {
            transform: translate(-10px, 5px) rotate(-3deg);
        }
    }

    .product-wrapper {
        position: relative;
        min-height: 100vh;
        padding: 0;
        z-index: 1;
    }

    .back-button-top {
        position: absolute;
        top: 40px;
        left: 60px;
        color: var(--text-secondary);
        cursor: pointer;
        text-decoration: none;
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        font-size: 1rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: all 0.3s var(--transition);
        z-index: 10;
        border: none;
        background: transparent;
        position: relative;
    }

    .back-button-top::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 0;
        height: 1px;
        background-color: var(--accent);
        transition: all 0.3s var(--transition);
    }

    .back-button-top:hover::after {
        width: 100%;
    }

    .back-button-top:hover {
        color: var(--accent);
    }

    .product-details {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: flex-start;
        gap: 60px;
        padding: 120px 50px 80px;
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    .product-image {
        position: relative;
        max-width: 500px;
        width: 100%;
    }

    .image-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
        overflow: hidden;
        border-radius: 0;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        transition: all 0.4s var(--transition);
        border: 1px solid var(--medium-gray);
    }

    .image-wrapper::before {
        content: '';
        position: absolute;
        top: 15px;
        right: 15px;
        bottom: 15px;
        left: 15px;
        border: 1px solid rgba(212, 175, 55, 0);
        transition: all 0.4s var(--transition);
        pointer-events: none;
        z-index: 1;
    }

    .image-wrapper:hover::before {
        border-color: rgba(212, 175, 55, 0.3);
    }

    .image-wrapper:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .image-wrapper img {
        display: block;
        width: 100%;
        height: 600px;
        object-fit: cover;
        border-radius: 0;
        transition: all 0.4s var(--transition);
    }

    .image-wrapper:hover img {
        transform: scale(1.02);
    }

    .image-buttons {
        position: absolute;
        bottom: 20px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 25px;
        z-index: 2;
    }

    .image-buttons button {
        padding: 0.6rem 1rem;
        background: var(--secondary);
        color: var(--primary);
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        transition: all 0.4s var(--transition);
        position: relative;
        overflow: hidden;
        z-index: 1;
        min-width: 50px;
    }

    .image-buttons button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: var(--accent);
        transition: all 0.4s var(--transition);
        z-index: -1;
    }

    .image-buttons button:hover::before {
        left: 0;
    }

    .image-buttons button:hover {
        color: var(--secondary);
    }

    .product-info {
        max-width: 600px;
        width: 100%;
        padding: 20px 0;
    }

    .product-info h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        letter-spacing: 2px;
        line-height: 1.2;
    }

    .product-info .description {
        font-size: 1.1rem;
        color: var(--text-secondary);
        font-family: 'Montserrat', sans-serif;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        letter-spacing: 0.5px;
    }

    .product-info .price {
        font-size: 2rem;
        font-weight: 600;
        color: var(--accent);
        margin-bottom: 2rem;
        font-family: 'Cormorant Garamond', serif;
        letter-spacing: 1px;
    }

    .product-info select,
    .product-info input[type="number"] {
        width: 100%;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid var(--medium-gray);
        background-color: var(--primary);
        color: var(--text-primary);
        font-family: 'Montserrat', sans-serif;
        font-size: 1rem;
        transition: all 0.3s var(--transition);
        border-radius: 0;
    }

    .product-info select:focus,
    .product-info input[type="number"]:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.1);
    }

    .dark-mode .product-info select,
    .dark-mode .product-info input[type="number"] {
        background-color: var(--light-gray);
        border-color: var(--medium-gray);
    }

    .btn-add-cart {
        padding: 1rem 2rem;
        background: var(--secondary);
        color: var(--primary);
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        transition: all 0.4s var(--transition);
        position: relative;
        overflow: hidden;
        z-index: 1;
        width: 100%;
        margin-bottom: 1rem;
    }

    .btn-add-cart::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: var(--accent);
        transition: all 0.4s var(--transition);
        z-index: -1;
    }

    .btn-add-cart:hover::before {
        left: 0;
    }

    .btn-add-cart:hover {
        color: var(--secondary);
    }

    .wishlist-button {
        display: inline-block;
        color: var(--text-secondary);
        cursor: pointer;
        font-size: 1rem;
        text-decoration: none;
        font-family: 'Montserrat', sans-serif;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-weight: 500;
        transition: all 0.3s var(--transition);
        border: none;
        background: transparent;
        padding: 0.5rem 0;
        position: relative;
    }

    .wishlist-button::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 1px;
        background-color: var(--accent);
        transition: all 0.3s var(--transition);
    }

    .wishlist-button:hover::after {
        width: 100%;
    }

    .wishlist-button:hover {
        color: var(--accent);
    }

    .error-message {
        color: #dc3545;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        font-family: 'Montserrat', sans-serif;
    }

    .success-message {
        color: #28a745;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        font-family: 'Montserrat', sans-serif;
    }

    /* Mobile responsiveness */
    @media (max-width: 992px) {
        .product-details {
            gap: 40px;
            padding: 100px 30px 60px;
        }
        
        .product-info h1 {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .back-button-top {
            top: 30px;
            left: 30px;
            font-size: 0.9rem;
        }
        
        .product-details {
            gap: 30px;
            padding: 80px 20px 50px;
        }
        
        .product-info h1 {
            font-size: 2rem;
        }
        
        .product-info .price {
            font-size: 1.6rem;
        }
    }

    @media (max-width: 576px) {
        .back-button-top {
            top: 20px;
            left: 20px;
            font-size: 0.8rem;
        }
        
        .product-details {
            padding: 70px 15px 40px;
        }
        
        .product-info h1 {
            font-size: 1.8rem;
        }
        
        .image-buttons {
            padding: 0 15px;
        }
        
        .image-buttons button {
            padding: 0.5rem 0.8rem;
            font-size: 0.8rem;
            min-width: 40px;
        }
    }
</style>

<div class="product-wrapper">
    <div class="pattern-overlay"></div>
    
    <div class="gold-accent gold-accent-1"></div>
    <div class="gold-accent gold-accent-2"></div>

    <!-- Back Button -->
    @php
    $previous = url()->previous();
    $current = url()->current();
    $fallback = route('store.show');
    @endphp

    <div class="back-button-top" onclick="window.location.href='{{ $previous !== $current ? $previous : $fallback }}'">
        ← Go Back
    </div>

    <div class="product-details" data-aos="fade-up" data-aos-duration="1000">
        <div class="product-image" id="product-image-slider">
            <div class="image-wrapper">
                <img id="mainImage"
                    src="{{ $product['images'][0] ?? asset('fotoBaju.jpg') }}"
                    alt="{{ $product['name'] }}"
                    class="img-fluid"
                    onerror="this.onerror=null; this.src='{{ asset('fotoBaju.jpg') }}';" />
                
                <div class="image-buttons">
                    <button onclick="changeImage(-1)">←</button>
                    <button onclick="changeImage(1)">→</button>
                </div>
            </div>
        </div>

        <div class="product-info" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <h1>{{ $product['name'] }}</h1>
            <p class="description">{{ $product['description'] }}</p>
            <p class="price">Rp{{ number_format($product['price'], 0, ',', '.') }}</p>

            <form action="{{ route('cart.add') }}" method="POST">
                @csrf

                <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">

                @if (!empty($product['sizes']))
                    <select name="product_size" required>
                        <option value="">Select Size</option>
                        @foreach ($product['sizes'] as $size)
                            @php
                                $stock = DB::table('product_stocks')
                                    ->where('product_id', $product['product_id'])
                                    ->where('size', $size)
                                    ->value('quantity');
                            @endphp
                            <option value="{{ $size }}">{{ $size }} ({{ $stock }} left)</option>
                        @endforeach
                    </select>
                @else
                    <input type="hidden" name="product_size" value="One Size">
                @endif

                <input type="number" name="product_qty" min="1" max="100" value="1" placeholder="Quantity" />
                
                @if (session('error'))
                    <div class="error-message">{{ session('error') }}</div>
                @endif

                @if (session('success'))
                    <div class="success-message">{{ session('success') }}</div>
                @endif
                
                <button class="btn-add-cart" type="submit">Add to Cart</button>
            </form>

            @if ($alreadyInWishlist)
                <div class="wishlist-button">
                    <i class="far fa-heart"></i> Already in Wishlist
                </div>
            @else
                <form action="{{ route('wishlist.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                    <button type="submit" class="wishlist-button">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: false,
        mirror: true
    });

    // Check for saved dark mode preference
    document.addEventListener('DOMContentLoaded', function() {
        const savedDarkMode = localStorage.getItem('darkMode');
        if (savedDarkMode === 'true') {
            document.body.classList.add('dark-mode');
        }
    });

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