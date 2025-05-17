@extends('base.base')

@section('content')
<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<style>
    /* Copy your existing styles from the store page here for consistency */
    body {
        background-color: #fff;
        font-family: 'Inter', sans-serif;
        transition: background 0.3s ease, color 0.3s ease;
    }
    body.dark-mode {
        background-color: #121212;
        color: #f5f5f5;
    }
    .store-header {
        text-align: center;
        padding: 3rem 1rem 1rem;
    }
    .store-header h1 {
        font-size: 2.5rem;
        letter-spacing: 2px;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .store-header p {
        font-size: 1rem;
        color: #777;
        max-width: 480px;
        margin: 0 auto 2rem auto;
    }
    .btn-add-product {
        display: block;
        margin: 0 auto 2rem auto;
        padding: 0.75rem 1.5rem;
        background-color: #000;
        color: white;
        font-weight: 600;
        border-radius: 25px;
        cursor: pointer;
        border: none;
        font-size: 1rem;
        transition: background 0.3s;
    }
    .btn-add-product:hover {
        background-color: #e76767;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        padding: 1rem 1.5rem 4rem;
        max-width: 1200px;
        margin: auto;
    }
    .product-card {
        background: #fff;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        transition: 0.3s;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .product-card:hover {
        transform: translateY(-4px);
    }
    body.dark-mode .product-card {
        background: #1c1c1c;
        color: #fff;
    }
    .product-card img {
        width: 100%;
        height: auto;
        display: block;
    }
    .product-info {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        height: 130px;
    }
    .product-info h4 {
        margin-bottom: 0.25rem;
        font-size: 1rem;
        font-weight: 500;
        text-align: center;
    }
    .product-price-cart {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        width: 100%;
        margin-top: auto;
    }
    .product-info span {
        font-size: 0.95rem;
        font-weight: 500;
        color: #444;
    }
    body.dark-mode .product-info span {
        color: #ddd;
    }
    .btn-cart, .btn-edit {
        padding: 0.5rem 1rem;
        background: black;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.9rem;
        white-space: nowrap;
        transition: background 0.2s;
    }
    .btn-cart:hover, .btn-edit:hover {
        background: #e76767;
    }
    .btn-edit {
        background-color: #555;
    }
    .btn-edit:hover {
        background-color: #cc4c4c;
    }
    .dark-mode-toggle {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #000;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        cursor: pointer;
        z-index: 999;
        transition: 0.3s;
    }
</style>

<!-- Dark Mode Button -->
<button class="dark-mode-toggle" onclick="toggleDarkMode()">🌙</button>

<!-- Header -->
<div class="store-header">
    <h1>Admin Dashboard</h1>
    <p>Manage your products here.</p>
</div>

<!-- Add New Product Button -->
<button class="btn-add-product" onclick="alert('Feature to add new product coming soon!')">+ Add New Product</button>

<!-- Product Grid -->
<div class="product-grid" id="productGrid">
    @foreach($products as $product)
        <div class="product-card" data-category="{{ $product['category'] }}" data-aos="fade-up">
            <a href="{{ route('product.show', ['id' => $product['id']]) }}">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
            </a>
            <div class="product-info">
                <h4>{{ $product['name'] }}</h4>
                <div class="product-price-cart">
                    <span>Rp{{ number_format($product['price'], 0, ',', '.') }}</span>
                    <button class="btn-edit" onclick="location.href='{{ route('admin.product.edit', ['id' => $product['id']]) }}'">Edit</button>                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
    AOS.init();

    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
    }
</script>
@endsection