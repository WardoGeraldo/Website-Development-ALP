@extends('base.base')
@section('content')

<!-- AOS CSS -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
    body {
        background-color: #fff;
        color: #000;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    body.dark-mode {
        background-color: #121212;
        color: #f5f5f5;
    }


    /* === ANIMASI === */
    @keyframes slideInRight { from { opacity: 0; transform: translateX(150px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes slideOutRight { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(150px); } }
    @keyframes slideInLeft { from { opacity: 0; transform: translateX(-150px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes slideOutLeft { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(-150px); } }
    @keyframes zoomInOut { from { transform: scale(1); } 50% { transform: scale(1.1); } to { transform: scale(1); } }

    .fade-in-out {
        animation: slideOutRight 0.8s ease-out, slideInRight 1.2s ease-in forwards;
    }

    .fade-in-left {
        animation: slideOutLeft 0.8s ease-out, slideInLeft 1.2s ease-in forwards;
    }

    /* === HERO SECTION === */
    .hero-section {
        position: relative;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        overflow: hidden;
        background: #000;
        color: #fff;
    }

    body.dark-mode .hero-section {
        background: #111;
    }

    .hero-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
        filter: brightness(0.5);
        animation: zoomInOut 15s infinite linear;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }

    .hero-text {
        z-index: 2;
        max-width: 700px;
    }

    .hero-text h1 {
        font-size: 5rem;
        font-weight: 900;
        letter-spacing: 5px;
        text-transform: uppercase;
        line-height: 1.1;
        animation: fade-in-out 1s ease-in-out forwards;
    }

    .hero-text p {
        font-size: 1.5rem;
        margin-top: 1.5rem;
        font-weight: 400;
    }

    .hero-text .btn {
        margin-top: 2rem;
        padding: 1rem 3rem;
        font-weight: bold;
        border-radius: 50px;
        background-color: white;
        color: #000;
        transition: all 0.3s ease-in-out;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .hero-text .btn:hover {
        background-color: #000;
        color: #fff;
        transform: scale(1.1);
    }

    body.dark-mode .hero-text .btn {
        background-color: #f5f5f5;
        color: #121212;
    }

    body.dark-mode .hero-text .btn:hover {
        background-color: #e76767;
        color: #fff;
    }

    /* === CARD === */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #fff;
        color: #000;
        border-radius: 1rem;
    }

    .card:hover {
        transform: translateY(-15px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
    }

    body.dark-mode .card {
        background: #1e1e1e;
        color: #f5f5f5;
        box-shadow: 0 30px 60px rgba(255, 255, 255, 0.1);
    }

    .card-body {
        animation: fade-in-out 1s ease-in-out;
    }

    body.dark-mode .text-muted {
        color: #ccc !important;
    }

    /* === SECTION TITLE === */
    .section-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        letter-spacing: 2px;
    }

    .section-subtitle {
        font-size: 1.1rem;
        color: #666;
    }

    body.dark-mode .section-subtitle {
        color: #aaa;
    }

    body.dark-mode .text-muted {
        color: #aaa;
    }

    body.dark-mode .bg-light {
    background-color: #000 !important;
    color: #fff !important;
    }

    body.dark-mode .bg-light .text-muted {
        color: #ccc !important;
    }

    body.dark-mode .bg-light h3,
    body.dark-mode .bg-light p {
        color: #fff !important;
    }


    /* === PROMO BANNER === */
    .promo-banner {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        animation: fade-in-out 1.2s ease-in-out;
    }

    .promo-banner img {
        transition: transform 0.6s ease, filter 0.3s ease;
    }

    .promo-banner:hover img {
        transform: scale(1.1);
        filter: brightness(0.6);
    }

    .promo-text {
        position: absolute;
        top: 50%;
        left: 10%;
        transform: translateY(-50%);
        color: white;
        max-width: 500px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .promo-text h2 {
        font-size: 3rem;
        font-weight: 900;
    }

    .promo-text p {
        font-size: 1.25rem;
        margin-top: 1rem;
        font-weight: 300;
    }

    .promo-text .btn {
        margin-top: 2rem;
        padding: 1rem 2.5rem;
        background-color: #f7b800;
        border-radius: 30px;
        text-transform: uppercase;
    }

    /* === IMAGE HOVER === */
    .card-img-top {
        transition: transform 0.3s ease;
    }

    .card-img-top:hover {
        transform: scale(1.05);
    }

    /* === LOGO MARQUEE === */
    .logo-marquee {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #000;
        padding: 10px 0;
        overflow: hidden;
        z-index: 9999;
    }

    .logo-container {
        display: flex;
        animation: scroll-left 20s linear infinite;
    }

    .logo-container img {
        height: 50px;
        margin-right: 50px;
    }

    @keyframes scroll-left {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }
</style>


<!-- Hero Section -->
<div class="hero-section">
    <video autoplay muted loop playsinline class="hero-video">
        <source src="{{ asset('videoBgWeb.mp4') }}" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-text">
        <h1 class="fade-in-left">VERAVIA</h1>
        <p class="fade-in-right">Elevate Your Everyday Look – Gaya elegan & minimalis yang mencerminkan keanggunan wanita masa kini.</p>
        <a href="{{ route('store.show') }}" class="btn">Belanja Sekarang</a>
    </div>
</div>

<!-- Featured Products -->
<div class="container py-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="section-title">Best Seller</h2>
        <p class="section-subtitle">Temukan pilihan terbaik untuk setiap kesempatan.</p>
    </div>
    <div class="row g-4">
        @php $products = [
            ['title' => 'Oversized Tee', 'price' => 'Rp 299.000'],
            ['title' => 'Minimalist Hoodie', 'price' => 'Rp 499.000'],
            ['title' => 'Slim Fit Pants', 'price' => 'Rp 399.000'],
            ['title' => 'Monochrome Cap', 'price' => 'Rp 149.000'],
        ]; @endphp

        @foreach ($products as $index => $product)
        <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="{{ 100 * $index }}">
            <div class="card border-0 shadow-sm h-100">
                <img src="fotoBaju.jpg" class="card-img-top" alt="{{ $product['title'] }}">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product['title'] }}</h5>
                    <p class="text-muted">{{ $product['price'] }}</p>
                    <a href="{{ route('product.show', ['id' => 1]) }}" class="btn btn-outline-dark rounded-pill btn-sm">Lihat Detail</a>
                {{-- jangan lupa ganti id nya karna semua button hanya connect ke 1 product-detail --}}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Running Logos Marquee -->
<div class="logo-marquee">
    <div class="logo-container">
        <img src="fotoBaju.jpg" alt="Logo 1">
        <img src="fotoBaju.jpg" alt="Logo 2">
        <img src="fotoBaju.jpg" alt="Logo 3">
        <img src="fotoBaju.jpg" alt="Logo 4">
        <img src="fotoBaju.jpg" alt="Logo 5">
        <!-- Add more logos as needed -->
    </div>
</div>

<!-- About Veravia -->
<div class="bg-light py-5">
    <div class="container" data-aos="fade-right">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="fotoBaju.jpg" class="img-fluid rounded shadow" alt="About Veravia">
            </div>
            <div class="col-md-6">
                <h3 class="fw-bold">Tentang Veravia</h3>
                <p class="text-muted">Veravia hadir untuk wanita modern yang mengutamakan kenyamanan tanpa mengorbankan gaya. Setiap koleksi kami dirancang dengan cermat untuk memperkuat rasa percaya diri, tampil berkelas, dan tetap minimalis dalam setiap kesempatan.</p>
                <a href="{{ route('support.show') }}" class="btn btn-dark rounded-pill mt-2">Butuh Bantuan?</a>
            </div>
        </div>
    </div>
</div>

<!-- CTA Banner -->
<div class="promo-banner my-5" data-aos="zoom-in">
    <img src="fotoBaju.jpg" class="w-100" alt="Promo Veravia">
    <div class="promo-text">
        <h2 class="fw-bold">Diskon Spesial Musim Ini</h2>
        <p class="lead">Potongan hingga 50% untuk koleksi tertentu.</p>
        <a href="{{ route('store.show') }}" class="btn btn-light rounded-pill mt-3">Lihat Koleksi</a>
    </div>
</div>

<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1500,
        once: true,
        offset: 100,
    });
</script>

@endsection