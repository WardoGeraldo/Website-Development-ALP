@extends('base.base')
@section('content')

<!-- Luxury Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@300;400;500;600;700&family=Montserrat:wght@200;300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<style>
    :root {
        --primary-gold: #d4af7a;
        --secondary-gold: #bf9b56;
        --light-gold: #e7c8a0;
        --very-light-gold: #f0dfc0;
        --text-dark: #101010;
        --bg-light: #ffffff;
        --bg-cream: #faf9f7;
        --gradient-gold: linear-gradient(135deg, #e7c8a0, #d4af7a, #bf9b56);
        --gradient-gold-hover: linear-gradient(135deg, #f0dfc0, #e7c8a0, #d4af7a);
    }

    body {
        font-family: 'Montserrat', sans-serif;
        background-color: var(--bg-light);
        color: var(--text-dark);
        overflow-x: hidden;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    body.dark-mode {
        background-color: #121212;
        color: #f5f5f5;
    }

    /* === PRELOADER === */
    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--bg-light);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        opacity: 1;
        transition: opacity 0.8s ease-out, visibility 0.8s ease-out;
    }

    .preloader.hidden {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    .preloader-logo {
        font-family: 'Cormorant', serif;
        font-weight: 700;
        font-size: 2.2rem;
        letter-spacing: 6px;
        color: transparent;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        background-clip: text;
        position: relative;
        overflow: hidden;
    }

    .preloader-logo::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 0;
        background: rgba(255, 255, 255, 0.2);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
            width: 0;
        }
        50% {
            width: 100%;
        }
        100% {
            transform: translateX(100%);
            width: 0;
        }
    }

    /* === ANIMASI === */
    @keyframes slideInRight { from { opacity: 0; transform: translateX(150px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes slideOutRight { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(150px); } }
    @keyframes slideInLeft { from { opacity: 0; transform: translateX(-150px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes slideOutLeft { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(-150px); } }
    @keyframes zoomInOut { from { transform: scale(1); } 50% { transform: scale(1.05); } to { transform: scale(1); } }
    @keyframes floatAnimation { 0% { transform: translateY(0); } 50% { transform: translateY(-10px); } 100% { transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

    .fade-in {
        animation: fadeIn 1.2s ease forwards;
    }

    .fade-in-up {
        animation: fadeInUp 1.2s ease forwards;
    }

    .fade-in-right {
        animation: slideInRight 1.2s ease-in forwards;
    }

    .fade-in-left {
        animation: slideInLeft 1.2s ease-in forwards;
    }

    .floating {
        animation: floatAnimation 8s ease-in-out infinite;
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
        background: #fff;
        color: var(--text-dark);
    }

    .hero-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
        filter: brightness(0.9);
        animation: zoomInOut 15s infinite linear;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.3);
        z-index: 1;
    }

    .hero-grain {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 250 250' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        opacity: 0.05;
        z-index: 2;
        pointer-events: none;
    }

    .hero-text {
        z-index: 3;
        max-width: 700px;
        position: relative;
    }

    .hero-badge {
        display: inline-block;
        padding: 5px 15px;
        background: var(--gradient-gold);
        color: #fff;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        border-radius: 50px;
        margin-bottom: 1.5rem;
        font-weight: 500;
        box-shadow: 0 5px 15px rgba(212, 175, 122, 0.3);
    }

    .hero-text h1 {
        font-family: 'Cormorant', serif;
        font-size: 5rem;
        font-weight: 700;
        letter-spacing: 5px;
        text-transform: uppercase;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-text p {
        font-size: 1.2rem;
        margin-top: 1rem;
        font-weight: 300;
        line-height: 1.6;
        color: rgba(16, 16, 16, 0.8);
    }

    .hero-text .btn {
        margin-top: 2.5rem;
        padding: 1rem 3rem;
        font-weight: 500;
        border-radius: 50px;
        background: var(--gradient-gold);
        color: #fff;
        transition: all 0.3s ease-in-out;
        text-transform: uppercase;
        letter-spacing: 2px;
        border: none;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .hero-text .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: transform 0.5s ease;
        z-index: -1;
    }

    .hero-text .btn:hover::before {
        transform: translateX(100%);
    }

    .hero-text .btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .luxury-accent {
        position: absolute;
        width: 150px;
        height: 150px;
        border: 1px solid var(--light-gold);
        opacity: 0.2;
        z-index: 1;
    }

    .accent-1 {
        top: -50px;
        left: -50px;
    }

    .accent-2 {
        bottom: -50px;
        right: -50px;
    }

    /* === FEATURED PRODUCTS === */
    .section-spacing {
        padding: 120px 0;
    }

    .section-heading {
        text-align: center;
        margin-bottom: 60px;
        position: relative;
    }

    .section-heading::after {
        content: '';
        display: block;
        width: 80px;
        height: 2px;
        background: var(--gradient-gold);
        margin: 15px auto 0;
    }

    .heading-badge {
        display: inline-block;
        padding: 5px 15px;
        background-color: rgba(212, 175, 122, 0.1);
        color: var(--primary-gold);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        border-radius: 50px;
        margin-bottom: 1rem;
        font-weight: 500;
    }

    .section-title {
        font-family: 'Cormorant', serif;
        font-size: 3rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-dark);
    }

    .dark-mode .section-title {
        color: white;
    }

    .section-subtitle {
        font-size: 1.1rem;
        color: rgba(16, 16, 16, 0.6);
        max-width: 600px;
        margin: 0 auto;
        font-weight: 300;
    }

    /* === PRODUCT CARDS === */
    .product-card {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        background: #fff;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .product-image {
        position: relative;
        overflow: hidden;
        padding-top: 125%; /* 4:5 aspect ratio */
    }

    .product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .product-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--gradient-gold);
        color: white;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 500;
        letter-spacing: 1px;
        text-transform: uppercase;
        z-index: 2;
    }

    .product-details {
        padding: 20px;
        position: relative;
    }

    .product-title {
        font-family: 'Cormorant', serif;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 50px;
        color: var(--text-dark);
    }

    .dark-mode .product-title{
        color: black;
    }

    .product-price {
        font-size: 1.1rem;
        color: var(--primary-gold);
        font-weight: 500;
        margin-bottom: 15px;
    }

    .product-btn {
        display: inline-block;
        padding: 8px 20px;
        background: transparent;
        color: var(--text-dark);
        border: 1px solid var(--text-dark);
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .product-btn:hover {
        background: var(--gradient-gold);
        color: white;
        border-color: transparent;
    }

    /* Serif heading for elegant title */
    h2.product-title {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Elegant badges */
    .badge-tag {
        background-color: #E0C8A0; /* soft beige */
        color: #3B3B3B;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }

    /* Card styling */
    .card {
        background-color: #121212;
        color: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.35);
    }

    .card-img-top {
        border-bottom: 1px solid rgba(255,255,255,0.05);
        object-fit: cover;
        height: 350px;
        width: 100%;
    }

    /* Text styling */
    .card-title {
        font-weight: 500;
        font-size: 16px;
        margin-bottom: 0.25rem;
    }

    .product-price {
        font-weight: 500;
        color: #f3c17c; /* soft gold */
        font-size: 15px;
    }

    /* Button styling */
    .btn-outline-light {
        border: 1px solid #ccc;
        color: #fff;
        padding: 6px 18px;
        font-size: 13px;
        border-radius: 50px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-outline-light:hover {
        background-color: #f3c17c;
        color: #000;
        border-color: #f3c17c;
    }


    /* === ABOUT SECTION === */
    .about-section {
        background-color: var(--bg-cream);
        position: relative;
        overflow: hidden;
    }

    .about-accent {
        position: absolute;
        width: 300px;
        height: 300px;
        border: 1px solid var(--light-gold);
        opacity: 0.1;
        transform: rotate(45deg);
    }

    .about-accent-1 {
        top: -150px;
        left: -150px;
    }

    .about-accent-2 {
        bottom: -150px;
        right: -150px;
    }

    .about-image {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .about-image::before {
        content: '';
        position: absolute;
        inset: 0;
        border: 1px solid rgba(212, 175, 122, 0.3);
        z-index: 1;
        margin: 15px;
        pointer-events: none;
    }

    .about-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
        transition: transform 1s ease;
    }

    .about-image:hover img {
        transform: scale(1.05);
    }

    .about-content h3 {
        font-family: 'Cormorant', serif;
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }

    .about-content h3::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 60px;
        height: 2px;
        background: var(--gradient-gold);
    }

    .about-content p {
        font-size: 1rem;
        line-height: 1.8;
        color: rgba(16, 16, 16, 0.7);
        margin-bottom: 2rem;
        font-weight: 300;
    }

    .about-btn {
        display: inline-block;
        padding: 12px 30px;
        background: transparent;
        color: var(--text-dark);
        border: 1px solid var(--text-dark);
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .about-btn:hover {
        background: var(--gradient-gold);
        color: white;
        border-color: transparent;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* === PROMO BANNER === */
    .promo-banner {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        margin: 80px 0;
    }

    .promo-banner img {
        width: 100%;
        height: auto;
        object-fit: cover;
        transition: transform 1s ease;
    }

    .promo-banner:hover img {
        transform: scale(1.05);
    }

    .promo-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.2));
        display: flex;
        align-items: center;
    }

    .promo-content {
        padding: 0 60px;
        width: 50%;
        color: white;
    }

    .promo-title {
        font-family: 'Cormorant', serif;
        font-size: 3rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
    }

    .promo-text {
        font-size: 1.1rem;
        margin-bottom: 2rem;
        font-weight: 300;
        line-height: 1.6;
    }

    .promo-btn {
        display: inline-block;
        padding: 12px 35px;
        background: white;
        color: var(--text-dark);
        border: none;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .promo-btn:hover {
        background: var(--gradient-gold);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* === LOGO MARQUEE === */
    .logo-marquee {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #fff;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: 15px 0;
        overflow: hidden;
        z-index: 100;
    }

    .logo-container {
        display: flex;
        animation: scroll-left 20s linear infinite;
    }

    .logo-item {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 30px;
    }

    .logo-item img {
        height: 40px;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .logo-item:hover img {
        opacity: 1;
    }

    @keyframes scroll-left {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    /* Dark mode compatibility (preserved from original) */
    body.dark-mode {
        background-color: #121212;
        color: #f5f5f5;
    }

    body.dark-mode .hero-section {
        background: #111;
    }

    body.dark-mode .hero-overlay {
        background: rgba(0, 0, 0, 0.5);
    }

    body.dark-mode .hero-text p {
        color: rgba(245, 245, 245, 0.8);
    }

    body.dark-mode .section-subtitle {
        color: #aaa;
    }

    body.dark-mode .product-card {
        background: #1e1e1e;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    body.dark-mode .product-title {
        color: #f5f5f5;
    }

    body.dark-mode .product-btn {
        color: #f5f5f5;
        border-color: #f5f5f5;
    }

    body.dark-mode .about-section {
        background-color: #111;
    }

    body.dark-mode .about-content p {
        color: rgba(245, 245, 245, 0.7);
    }

    body.dark-mode .about-btn {
        color: #f5f5f5;
        border-color: #f5f5f5;
    }

    body.dark-mode .logo-marquee {
        background-color: #121212;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Custom AOS animations for staggered effects */
    [data-aos="luxury-fade-up"] {
        opacity: 0;
        transform: translateY(30px);
        transition-property: opacity, transform;
    }

    [data-aos="luxury-fade-up"].aos-animate {
        opacity: 1;
        transform: translateY(0);
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .hero-text h1 {
            font-size: 4rem;
        }
        
        .section-title {
            font-size: 2.5rem;
        }
        
        .promo-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 992px) {
        .hero-text h1 {
            font-size: 3.5rem;
        }
        
        .section-spacing {
            padding: 80px 0;
        }
        
        .promo-content {
            width: 70%;
        }
    }

    @media (max-width: 768px) {
        .hero-text h1 {
            font-size: 3rem;
        }
        
        .hero-text p {
            font-size: 1rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .promo-content {
            width: 100%;
            padding: 0 30px;
        }
        
        .promo-title {
            font-size: 2rem;
        }
        
        .about-content h3 {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .hero-text h1 {
            font-size: 2.5rem;
        }
        
        .hero-badge {
            font-size: 0.8rem;
        }
        
        .section-spacing {
            padding: 60px 0;
        }
        
        .section-title {
            font-size: 1.8rem;
        }
        
        .promo-title {
            font-size: 1.8rem;
        }
    }
</style>

<!-- Preloader -->
<div class="preloader" id="preloader">
    <div class="preloader-logo">VERAVIA</div>
</div>

<!-- Hero Section -->
<div class="hero-section">
    <video autoplay muted loop playsinline class="hero-video">
        <source src="{{ asset('videoBgWeb.mp4') }}" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-grain"></div>
    <div class="hero-text">
        {{-- <div class="luxury-accent accent-1"></div>
        <div class="luxury-accent accent-2"></div> --}}
        <span class="hero-badge fade-in">Premium Collection</span>
        <h1 class="fade-in-left">VERAVIA</h1>
        <p class="fade-in-right">Elevate Your Everyday Look</p>
        <a href="{{ route('store.show') }}" class="btn floating">Belanja Sekarang</a>
    </div>
</div>

<div class="container py-5">
    <h5 class="text-center text-uppercase text-[13px] text-[#C7A17A] tracking-wide mb-2">Collection</h5>
    <h2 class="product-title text-center font-serif text-4xl mb-1">Best Seller</h2>
    <p class=" text-center font-serif text-gray-300 mb-4">Temukan pilihan terbaik untuk setiap kesempatan.</p>
    <div class="row justify-content-center">
        @foreach ($bestSellers as $product)
            <div class="col-md-3 mb-4">
                <div class="card bg-dark text-white rounded-3 shadow-lg h-100 border-0">
                    <div class="position-relative">
                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2 px-3 py-1 rounded-pill">BEST SELLER</span>
                        <img src="{{ $product['image'] }}" class="card-img-top rounded-top" alt="{{ $product['name'] }}">
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title">{{ $product['name'] }}</h5>
                        <p class="product-price mb-2">Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                        <a href="{{ route('detail.bestSeller', $product['id']) }}" class="btn btn-outline-light mt-auto rounded-pill">LIHAT DETAIL</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- About Veravia -->
<div class="about-section section-spacing">
    <div class="about-accent about-accent-1"></div>
    <div class="about-accent about-accent-2"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-duration="1200">
                <div id="about-image" class="about-image">
                    <img src="fotoBaju.jpg" alt="About Veravia">
                </div>
            </div>
            <div id="about-veravia" class="col-lg-5 offset-lg-1" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="200">
                <div class="about-content">
                    <h3>Tentang Veravia</h3>
                    <p>Veravia hadir untuk wanita modern yang mengutamakan kenyamanan tanpa mengorbankan gaya. Setiap koleksi kami dirancang dengan cermat untuk memperkuat rasa percaya diri, tampil berkelas, dan tetap minimalis dalam setiap kesempatan.</p>
                    <p>Kami percaya bahwa pakaian berkualitas adalah investasi untuk tampil elegan di setiap momen penting dalam hidup.</p>
                    <a href="{{ route('support.show') }}" class="about-btn">Butuh Bantuan?</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Banner -->
<div class="container" data-aos="zoom-in" data-aos-duration="1200">
    <div class="promo-banner">
        <img src="fotoBaju.jpg" alt="Promo Veravia">
        <div class="promo-overlay">
            <div class="promo-content">
                <h2 class="promo-title">Diskon Spesial Musim Ini</h2>
                <p class="promo-text">Potongan hingga 50% untuk koleksi tertentu.</p>
                <a href="{{ route('store.show') }}" class="promo-btn">Lihat Koleksi</a>
            </div>
        </div>
    </div>
</div>

<!-- Logo Marquee -->
<div class="logo-marquee">
    <div class="logo-container">
        <div class="logo-item"><img src="fotoBaju.jpg" alt="Logo 1"></div>
        <div class="logo-item"><img src="fotoBaju.jpg" alt="Logo 2"></div>
        <div class="logo-item"><img src="fotoBaju.jpg" alt="Logo 3"></div>
        <div class="logo-item"><img src="fotoBaju.jpg" alt="Logo 4"></div>
        <div class="logo-item"><img src="fotoBaju.jpg" alt="Logo 5"></div>
        <div class="logo-item"><img src="fotoBaju.jpg" alt="Logo 1"></div>
        <div class="logo-item"><img src="fotoBaju.jpg" alt="Logo 2"></div>
        <div class="logo-item"><img src="fotoBaju.jpg" alt="Logo 3"></div>
        <div class="logo-item"><img src="fotoBaju.jpg" alt="Logo 4"></div>
        <div class="logo-item"><img src="fotoBaju.jpg" alt="Logo 5"></div>
    </div>
</div>

<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    // Initialize AOS animations
    AOS.init({
        duration: 1500,
        once: true,
        offset: 100,
    });

    // Preloader functionality and dark mode activation
    document.addEventListener('DOMContentLoaded', function() {
        // Tambahkan class dark-mode ke body saat halaman dimuat
        document.body.classList.add('dark-mode');
        
        setTimeout(function() {
            document.getElementById('preloader').classList.add('hidden');
        }, 1500);
    });
</script>

@endsection