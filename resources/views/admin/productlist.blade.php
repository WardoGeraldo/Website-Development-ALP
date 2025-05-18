@extends('base.base')

@section('content')
    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <style>
        /* Base & Dark Mode Colors */
        body {
            background-color: #fff;
            color: #333;
            font-family: 'Inter', sans-serif;
            transition: background-color 0.5s ease, color 0.5s ease;
        }

        body.dark-mode {
            background-color: #121212;
            color: #f5f5f5;
        }

        /* Dark Mode Toggle Button */
        .dark-mode-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #111;
            color: white;
            border: none;
            padding: 0.75rem 1.2rem;
            border-radius: 25px;
            cursor: pointer;
            z-index: 999;
            font-size: 1.3rem;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
            user-select: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .dark-mode-toggle:hover {
            background-color: #e76767;
            box-shadow: 0 6px 12px rgba(231, 103, 103, 0.7);
        }

        /* Header */
        .store-header {
            text-align: center;
            margin-top: 60px;
            margin-bottom: 30px;
        }

        .store-header h1 {
            font-size: 3rem;
            font-weight: 700;
            color: inherit;
            /* Inherit color from body */
            transition: color 0.5s ease;
        }

        /* Add New Product Button */
        .btn-add-product {
            display: block;
            margin: 20px auto;
            padding: 0.75rem 2rem;
            background-color: #111;
            color: white;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            border: none;
            font-size: 1rem;
            transition: background 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-add-product:hover {
            background-color: #e76767;
            box-shadow: 0 6px 12px rgba(231, 103, 103, 0.7);
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .product-card {
            background: #fff;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.5s ease, color 0.5s ease;
            text-align: center;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            color: #333;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        body.dark-mode .product-card {
            background: #222;
            color: #eee;
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.1);
        }

        .product-card img {
            width: 100%;
            height: auto;
            border-radius: 1rem;
            object-fit: cover;
            transition: filter 0.3s ease;
        }

        body.dark-mode .product-card img {
            filter: brightness(0.85);
        }

        .product-info {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            transition: color 0.5s ease;
        }

        .product-info h4 {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 1rem;
            color: #444;
        }

        body.dark-mode .product-info h4 {
            color: #ccc;
        }

        .product-price-cart {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            width: 100%;
            color: #222;
            font-weight: 600;
            font-size: 1.05rem;
            transition: color 0.5s ease;
        }

        body.dark-mode .product-price-cart {
            color: #ddd;
        }

        /* Edit Button */
        .btn-edit {
            padding: 0.5rem 1rem;
            background: #111;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 0.9rem;
            width: 45%;
            transition: background 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .btn-edit:hover {
            background: #e76767;
            box-shadow: 0 6px 12px rgba(231, 103, 103, 0.7);
        }

        body.dark-mode .btn-edit {
            background-color: #333;
            color: #f5f5f5;
            box-shadow: 0 2px 6px rgba(255, 255, 255, 0.2);
        }

        body.dark-mode .btn-edit:hover {
            background-color: #e76767;
            color: white;
            box-shadow: 0 6px 12px rgba(231, 103, 103, 0.9);
        }

        body.dark-mode .btn-add-product {
            background-color: #333;
            color: #f5f5f5;
            box-shadow: 0 2px 6px rgba(255, 255, 255, 0.2);
        }

        body.dark-mode .btn-add-product:hover {
            background-color: #e76767;
            box-shadow: 0 6px 12px rgba(231, 103, 103, 0.9);
        }

        body.dark-mode .dark-mode-toggle {
            background-color: #333;
            color: #f5f5f5;
            box-shadow: 0 2px 6px rgba(255, 255, 255, 0.2);
        }

        body.dark-mode .dark-mode-toggle:hover {
            background-color: #e76767;
            color: white;
            border-color: #e76767;
        }


        /* Responsive tweaks */
        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            }

            .store-header h1 {
                font-size: 2rem;
            }

            .btn-edit {
                font-size: 0.8rem;
                padding: 0.5rem 1rem;
            }
        }

        @media (max-width: 480px) {
            .product-card {
                padding: 10px;
            }

            .btn-add-product {
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
            }
        }
    </style>

    <!-- Dark Mode Button -->
    <button class="dark-mode-toggle" aria-label="Toggle dark mode" title="Toggle dark mode">🌙</button>

    <div class="container">
        <div class="store-header">
            <h1>Admin Dashboard</h1>
            <p>Manage your products here.</p>
        </div>

        <!-- Add New Product Button -->
        <button class="btn-add-product" onclick="location.href='{{ route('admin.product.create') }}'">+ Add New
            Product</button>

        <!-- Product Grid -->
        <div class="product-grid">
            @foreach ($products as $product)
                <div class="product-card" data-aos="fade-up">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy" />
                    <div class="product-info">
                        <h4>{{ $product['name'] }}</h4>
                        <div class="product-price-cart">
                            <span>Rp{{ number_format($product['price'], 0, ',', '.') }}</span>
                            <button class="btn-edit"
                                onclick="location.href='{{ route('admin.product.edit', ['id' => $product['id']]) }}'">Edit</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if (session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif

    <script>
        AOS.init();

        // Improved Dark Mode with persistence
        const toggleButton = document.querySelector('.dark-mode-toggle');

        // Apply saved mode on page load
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
            toggleButton.textContent = '☀️'; // Show sun icon if dark mode is on
        }

        toggleButton.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');

            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
                toggleButton.textContent = '☀️';
            } else {
                localStorage.setItem('darkMode', 'disabled');
                toggleButton.textContent = '🌙';
            }
        });
    </script>
@endsection
