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

        .store-wrapper {
            position: relative;
            min-height: 100vh;
            padding: 0;
            z-index: 1;
        }

        .store-header {
            text-align: center;
            padding: 5rem 1rem 2rem;
            position: relative;
        }

        .store-header h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3.5rem;
            letter-spacing: 4px;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--accent);
        }

        .store-header p {
            font-size: 1rem;
            color: var(--text-secondary);
            max-width: 480px;
            margin: 0 auto;
            letter-spacing: 1px;
        }

        .filter-bar {
            text-align: center;
            margin: 3rem 0;
            position: relative;
            z-index: 2;
        }

        .filter-bar button {
            border: none;
            padding: 0.6rem 1.5rem;
            margin: 0 0.5rem 0.5rem;
            border-radius: 0;
            background-color: transparent;
            cursor: pointer;
            transition: all 0.3s var(--transition);
            position: relative;
            font-family: 'Montserrat', sans-serif;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .filter-bar button::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 1px;
            background-color: var(--accent);
            transition: all 0.3s var(--transition);
            transform: translateX(-50%);
        }

        .filter-bar button:hover::after,
        .filter-bar button.active::after {
            width: 70%;
        }

        .filter-bar button:hover,
        .filter-bar button.active {
            color: var(--accent);
        }

        .dark-mode .filter-bar button {
            color: #ccc;
        }


        /* Updated Product Grid and Card Styles */
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            padding: 1rem 1.5rem 6rem;
            max-width: 1200px;
            margin: auto;
            position: relative;
            z-index: 2;
        }

        .product-card {
            background: var(--primary);
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.4s var(--transition);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            border: 1px solid var(--medium-gray);
            width: 230px;
            /* Fixed width for consistent card size */
            max-width: 100%;
        }

        .product-card img {
            object-fit: cover;
            height: 280px;
            /* Fixed height for consistent image size */
            width: 100%;
            background: #e8e7e3;
            transition: all 0.4s var(--transition);
        }

        .product-info {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            height: 120px;
            /* Fixed height for consistent alignment */
            justify-content: space-between;
            position: relative;
        }

        .product-info h4 {
            margin-bottom: 1rem;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.2rem;
            font-weight: 600;
            text-align: center;
            letter-spacing: 1px;
            height: 50px;
            /* Fixed height for product titles */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Limit to 2 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-price-cart {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            /* Push to bottom of container */
            width: 100%;
        }


        .product-card::before {
            content: '';
            position: absolute;
            top: 10px;
            right: 10px;
            bottom: 10px;
            left: 10px;
            border: 1px solid rgba(212, 175, 55, 0);
            transition: all 0.4s var(--transition);
            pointer-events: none;
            z-index: 1;
        }

        .product-card:hover::before {
            border-color: rgba(212, 175, 55, 0.3);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .dark-mode .product-card {
            background: #1c1c1c;
            color: #fff;
            border-color: #333;
        }

        .product-card:hover img {
            transform: scale(1.03);
        }

        .product-info span {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .dark-mode .product-info span {
            color: #ddd;
        }

        .btn-cart {
            padding: 0.5rem 0.6rem;
            background: var(--secondary);
            color: var(--primary);
            border: none;
            cursor: pointer;
            font-size: 0.5rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            white-space: nowrap;
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
            z-index: 1;
            font-weight: 500;
            min-width: 80px;
        }

        .btn-cart::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--accent);
            transition: all 0.4s;
            z-index: -1;
        }

        .btn-cart:hover {
            color: var(--secondary);
        }

        .btn-cart:hover::before {
            left: 0;
        }

        


        /* Loading indicator for product cards */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 10;
        }

        .dark-mode .loading-overlay {
            background: rgba(0, 0, 0, 0.8);
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(212, 175, 55, 0.3);
            border-radius: 50%;
            border-top-color: var(--accent);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Footer */
        .store-footer {
            background-color: var(--light-gray);
            padding: 2rem 0;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .store-footer p {
            color: var(--text-secondary);
            margin: 0;
            font-size: 0.9rem;
        }

        .store-footer .accent {
            color: var(--accent);
        }

        /* Mobile responsiveness */
        @media (max-width: 992px) {
            .store-header h1 {
                font-size: 3rem;
            }
        }

        @media (max-width: 768px) {
            .store-header h1 {
                font-size: 2.5rem;
            }

            .product-grid {
                gap: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .store-header h1 {
                font-size: 2rem;
            }

            .store-header {
                padding: 4rem 1rem 1.5rem;
            }

            .filter-bar button {
                padding: 0.5rem 1rem;
                margin: 0 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }
    </style>



    <div class="store-wrapper">
        <div class="pattern-overlay"></div>

        <div class="gold-accent gold-accent-1"></div>
        <div class="gold-accent gold-accent-2"></div>

        <!-- Header -->
        <div class="store-header" data-aos="fade-down" data-aos-duration="1000">
            <h1>EXCLUSIVE COLLECTION</h1>
            <p>Curated luxury pieces for the discerning individual who appreciates timeless elegance.</p>
        </div>

        <!-- Filter Buttons -->
        <div class="filter-bar" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
            <button onclick="filterProducts('all')" class="active">All</button>
            <button onclick="filterProducts('top')">Top</button>
            <button onclick="filterProducts('bottom')">Bottom</button>
            <button onclick="filterProducts('bag')">Bag</button>
            <button onclick="filterProducts('accessories')">Accessories</button>
        </div>

        <!-- Product Grid -->
        <div class="product-grid" id="productGrid">
            @foreach ($products as $product)
                <div class="product-card" data-category="{{ $product['category'] }}" data-aos="fade-up"
                    data-aos-duration="800" data-aos-delay="{{ $loop->index * 100 }}" data-aos-once="false">
                    <div class="loading-overlay">
                        <div class="loading-spinner"></div>
                    </div>
                    <a href="{{ route('product.show', ['id' => $product['id']]) }}">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                    </a>
                    <div class="product-info">
                        <h4>{{ $product['name'] }}</h4>
                        <div class="product-price-cart">
                            <span>Rp{{ number_format($product['price'], 0, ',', '.') }}</span>
                            <button class="btn-cart"
                                onclick="addToCart('{{ $product['id'] }}', '{{ $product['name'] }}')">Add to Cart</button>
                        </div>
                    </div>
                </div>
            @endforeach
            <div id="noProductsMessage" class="text-center text-light mt-4" style="display: none;">
                Product not found.
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
                document.querySelector('.dark-mode-toggle').innerHTML = '☀';
            }

            // Scroll to top button functionality
            const scrollTopBtn = document.getElementById('scrollTopBtn');
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollTopBtn.classList.add('visible');
                } else {
                    scrollTopBtn.classList.remove('visible');
                }
            });

            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });

        function filterProducts(category) {
            document.querySelectorAll('.filter-bar button').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            const searchValue = document.getElementById('searchInput')?.value?.toLowerCase() || '';
            const cards = document.querySelectorAll('.product-card');

            cards.forEach(card => {
                const matchesCategory = category === 'all' || card.dataset.category === category;
                const matchesSearch = card.querySelector('h4').innerText.toLowerCase().includes(searchValue);

                if (matchesCategory && matchesSearch) {
                    card.style.display = 'block';

                    // Reset AOS animation for visible cards only
                    card.classList.remove('aos-animate');
                    void card.offsetWidth;
                    card.classList.add('aos-animate');
                } else {
                    card.style.display = 'none';
                }
            });

            // Must come after all DOM changes
            AOS.refresh();
        }

        function addToCart(productId, productName) {
            // Show loading overlay for dramatic effect
            const card = event.target.closest('.product-card');
            const loadingOverlay = card.querySelector('.loading-overlay');

            loadingOverlay.style.opacity = '1';
            loadingOverlay.style.visibility = 'visible';

            // Simulate adding to cart (replace with actual cart functionality)
            setTimeout(() => {
                loadingOverlay.style.opacity = '0';
                loadingOverlay.style.visibility = 'hidden';

                // Show alert after animation completes
                setTimeout(() => {
                    alert('Added to cart: ' + productName);
                }, 300);
            }, 800);
        }
    </script>

    <script>
        function filterProductsBySearch(event) {
            event.preventDefault();

            const searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
            const productCards = document.querySelectorAll('.product-card');
            const noProductsMessage = document.getElementById('noProductsMessage');

            let hasVisibleProduct = false;

            productCards.forEach(card => {
                const productName = card.querySelector('.product-info h4').textContent.toLowerCase();
                if (productName.includes(searchValue)) {
                    card.style.display = 'block';
                    hasVisibleProduct = true;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show or hide "Product not found" message
            if (!hasVisibleProduct) {
                noProductsMessage.style.display = 'block';
            } else {
                noProductsMessage.style.display = 'none';
            }
        }

        function toggleDarkMode() {
            const body = document.body;
            const toggleBtn = document.querySelector('.dark-mode-toggle');
            const isDark = body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', isDark);
            toggleBtn.innerHTML = isDark ? '☀️' : '🌙';
        }

        // Apply saved mode on load
        document.addEventListener('DOMContentLoaded', () => {
            const saved = localStorage.getItem('darkMode') === 'true';
            if (saved) {
                document.body.classList.add('dark-mode');
                const btn = document.querySelector('.dark-mode-toggle');
                if (btn) btn.innerHTML = '☀️';
            }
        });
    </script>
@endsection
