@extends('base.base')

@section('content')
<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<style>
    /* Body & Dark Mode */
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

    /* Dark Mode Button */
    .dark-mode-toggle {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #111;
        color: white;
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 25px;
        cursor: pointer;
        z-index: 999;
        font-size: 1.2rem;
        transition: background-color 0.3s;
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
        color: #111;
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
        transition: background 0.3s;
    }
    .btn-add-product:hover {
        background-color: #e76767;
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); /* Auto fit for all screen sizes */
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
        transition: 0.3s;
        text-align: center;
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
    }

    body.dark-mode .product-card {
        background: #1c1c1c;
        color: #fff;
    }

    .product-card img {
        width: 100%;
        height: auto;
        border-radius: 1rem;
        object-fit: cover;
    }

    .product-info {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .product-info h4 {
        font-size: 1.1rem;
        font-weight: 500;
        color: #444;
        margin-bottom: 1rem;
    }

    body.dark-mode .product-info h4 {
        color: #ddd;
    }

    .product-price-cart {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        width: 100%;
    }

    /* Edit and View Buttons */
    .btn-edit, .btn-view {
        padding: 0.5rem 1rem;
        background: #111;
        color: white;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 0.9rem;
        width: 45%;  /* Shrinking the buttons */
        transition: background 0.3s;
    }

    .btn-edit:hover, .btn-view:hover {
        background: #e76767;
    }

    .btn-view {
        background-color: #007bff;
    }

    /* Dark Mode Styling */
    body.dark-mode .product-card {
        background-color: #333;
        color: #f5f5f5;x
    }

    /* Responsive for smaller screens */
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        }
        .store-header h1 {
            font-size: 2rem;
        }
        .btn-edit, .btn-view {
            font-size: 0.8rem;
            padding: 0.5rem 1rem;
        }
    }

    /* Responsive for mobile screens */
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
<button class="dark-mode-toggle" onclick="toggleDarkMode()">🌙</button>

<div class="container">
    <div class="store-header">
        <h1>Admin Dashboard</h1>
        <p>Manage your products here.</p>
    </div>

    <!-- Add New Product Button -->
    <button class="btn-add-product" onclick="location.href='{{ route('admin.product.create') }}'">+ Add New Product</button>

    <!-- Product Grid -->
    <div class="product-grid">
        @foreach($products as $product)
            <div class="product-card" data-aos="fade-up">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                <div class="product-info">
                    <h4>{{ $product['name'] }}</h4>
                    <div class="product-price-cart">
                        <span>Rp{{ number_format($product['price'], 0, ',', '.') }}</span>
                        <button class="btn-edit" onclick="location.href='{{ route('admin.product.edit', ['id' => $product['id']]) }}'">Edit</button>
                        <button class="btn-view" onclick="location.href='{{ route('product.show', ['id' => $product['id']]) }}'">View</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    AOS.init();

    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
    }
</script>

@endsection
