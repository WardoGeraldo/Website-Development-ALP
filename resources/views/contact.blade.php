@extends('base.base')
@section('content')

<!-- Required CSS Libraries -->
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.css" />

<!-- Custom styles -->
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

    body, html {
        background-color: var(--primary);
        color: var(--text-primary);
        font-family: 'Montserrat', sans-serif;
        overflow-x: hidden;
        cursor: default;
    }

    /* Cursor Effects */
    .cursor-follower {
        position: fixed;
        width: 30px;
        height: 30px;
        background: rgba(212, 175, 55, 0.2);
        border-radius: 50%;
        pointer-events: none;
        z-index: 9999;
        transition: transform .1s, width .3s, height .3s;
        transform: translate(-50%, -50%);
        mix-blend-mode: difference;
    }

    .cursor {
        position: fixed;
        width: 8px;
        height: 8px;
        background: var(--accent);
        border-radius: 50%;
        pointer-events: none;
        z-index: 9999;
        transform: translate(-50%, -50%);
    }

    /* Preloader */
    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--primary);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .preloader-text {
        font-family: 'Cormorant Garamond', serif;
        font-size: 6vw;
        font-weight: 700;
        color: var(--secondary);
        overflow: hidden;
        white-space: nowrap;
        letter-spacing: 8px;
        position: relative;
    }

    .preloader-text::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: var(--primary);
        animation: reveal 2s var(--transition) forwards;
    }

    .preloader-text .accent {
        color: var(--accent);
    }

    @keyframes reveal {
        0% { width: 100%; }
        100% { width: 0%; }
    }

    /* Main content */
    .landing-wrapper {
        position: relative;
        padding: 0;
        min-height: 100vh;
    }

    .pattern-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 1;
        opacity: 1;
    }

    /* Hero Section */
    .hero-section {
        height: 50vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        background: linear-gradient(to right, rgba(0,0,0,0.8), rgba(0,0,0,0.6)), url('/api/placeholder/1600/900') center/cover no-repeat;
    }

    .hero-bg-lines {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .hero-line {
        position: absolute;
        height: 100%;
        width: 1px;
        background: linear-gradient(to bottom, transparent, rgba(212,175,55,0.2), transparent);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        padding: 0 20px;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s var(--transition) forwards;
        animation-delay: 2.2s;
    }

    .hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        letter-spacing: 2px;
        color: var(--primary);
        text-shadow: 0 0 20px rgba(0,0,0,0.5);
    }

    .hero-subtitle {
        font-size: 1.2rem;
        font-weight: 300;
        color: var(--accent-light);
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    /* Main Content Section */
    .content-section {
        padding: 3rem 0; /* ↓ from 7rem */
        position: relative;
        z-index: 2;
        background-color: var(--primary);
    }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.5rem;
        margin-bottom: 1.25rem; /* tighter */
        position: relative;
        display: inline-block;
        color: var(--secondary);
        padding-bottom: 0.5rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 2px;
        background: var(--accent);
    }

    .section-subtitle {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.9rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 0.5rem; /* tighter */
    }

    /* Contact Info Boxes */
    .contact-info-wrapper {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s var(--transition) forwards;
        animation-delay: 2.4s;
        gap:1.5rem 0; /* reduce vertical gap */
    }

    .contact-info-box {
        background-color: var(--light-gray);
        border-radius: 5px;
        padding: 2rem; /* ↓ slightly */
        height: 100%;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
    }
    
    .contact-info-box:hover {
        transform: translateY(-5px);
        border-bottom: 3px solid var(--accent);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .contact-info-box::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(212,175,55,0.1) 0%, rgba(212,175,55,0) 70%);
        border-radius: 50%;
    }
    
    .info-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .info-icon svg {
        width: 24px;
        height: 24px;
        color: var(--accent);
    }
    
    .info-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }
    
    .info-text {
        color: var(--text-secondary);
        font-size: 1rem;
        line-height: 1.6;
    }
    
    .info-link {
        color: var(--accent-dark);
        text-decoration: none;
        transition: all 0.3s;
        position: relative;
    }
    
    .info-link::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 1px;
        background-color: var(--accent);
        transition: all 0.3s ease;
    }
    
    .info-link:hover {
        color: var(--accent);
    }
    
    .info-link:hover::after {
        width: 100%;
    }
    
    /* Contact Form */
    .form-container {
        background-color: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid var(--medium-gray);
        border-radius: 8px;
        padding: 3rem;
        position: relative;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s var(--transition) forwards;
        animation-delay: 2.6s;
        margin-top: 1rem;
    }
    
    .form-container::before {
        content: '';
        position: absolute;
        top: 20px;
        right: 20px;
        bottom: 20px;
        left: 20px;
        border: 1px solid var(--accent-light);
        opacity: 0.5;
        pointer-events: none;
    }
    
    .form-group {
        margin-bottom: 2.5rem;
        position: relative;
    }
    
    .form-label {
        position: absolute;
        top: 10px;
        left: 0;
        font-size: 1rem;
        color: var(--text-secondary);
        transition: all 0.3s;
        pointer-events: none;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 0;
        background-color: transparent;
        border: none;
        border-bottom: 1px solid var(--medium-gray);
        color: var(--text-primary);
        font-size: 1rem;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        outline: none;
        box-shadow: none;
        border-bottom: 2px solid var(--accent);
    }
    
    .form-control:focus + .form-label,
    .form-control:not(:placeholder-shown) + .form-label {
        top: -20px;
        font-size: 0.8rem;
        color: var(--accent-dark);
        font-weight: 600;
    }
    
    .form-textarea {
        resize: none;
        min-height: 100px;
    }
    
    .btn-submit {
        background-color: var(--secondary);
        color: var(--primary);
        border: none;
        padding: 12px 35px;
        font-size: 0.9rem;
        font-weight: 500;
        letter-spacing: 2px;
        text-transform: uppercase;
        transition: all 0.4s;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        z-index: 1;
        border-radius: 0;
    }
    
    .btn-submit::before {
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
    
    .btn-submit:hover {
        color: var(--secondary);
    }
    
    .btn-submit:hover::before {
        left: 0;
    }
    
    /* Map Section */
    .map-container {
        height: 530px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: 1px solid var(--medium-gray);
        position: relative;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s var(--transition) forwards;
        animation-delay: 2.8s;
    }
    
    .map-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
        transition: all 0.3s;
    }
    
    .map-overlay-text {
        background-color: white;
        color: var(--text-primary);
        padding: 1rem 2rem;
        border-radius: 4px;
        font-size: 0.9rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .map-overlay-text:hover {
        background-color: var(--accent);
        color: white;
    }
    
    .map-overlay.hidden {
        opacity: 0;
        pointer-events: none;
    }
    
    /* Success Popup */
    .success-popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.5s;
    }
    
    .success-popup.active {
        opacity: 1;
        visibility: visible;
    }
    
    .success-content {
        background-color: white;
        padding: 3rem 4rem;
        border-radius: 5px;
        text-align: center;
        position: relative;
        max-width: 90%;
        width: 500px;
        transform: translateY(30px);
        opacity: 0;
        transition: all 0.5s var(--transition) 0.2s;
    }
    
    .success-popup.active .success-content {
        transform: translateY(0);
        opacity: 1;
    }
    
    .success-icon {
        width: 80px;
        height: 80px;
        background-color: rgba(212,175,55,0.1);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 1.5rem;
    }
    
    .checkmark {
        width: 40px;
        height: 40px;
        position: relative;
    }
    
    .checkmark-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        stroke-width: 2;
        stroke: var(--accent);
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    
    .checkmark-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke-width: 3;
        stroke: var(--accent);
        fill: none;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }
    
    @keyframes stroke {
        100% { stroke-dashoffset: 0; }
    }
    
    .success-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        color: var(--secondary);
        margin-bottom: 1rem;
    }
    
    .success-message {
        color: var(--text-secondary);
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    .btn-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: transparent;
        border: none;
        width: 30px;
        height: 30px;
        font-size: 1.5rem;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.3s;
        padding: 0;
    }
    
    .btn-close:hover {
        color: var(--accent);
        transform: rotate(90deg);
    }
    
    .btn-close::before,
    .btn-close::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 2px;
        background-color: currentColor;
    }
    
    .btn-close::before {
        transform: rotate(45deg);
    }
    
    .btn-close::after {
        transform: rotate(-45deg);
    }
    
    /* Animated elements */
    .gold-accent {
        position: absolute;
        width: 30%;
        height: 30%;
        background: linear-gradient(45deg, rgba(212,175,55,0.1), rgba(212,175,55,0.02));
        filter: blur(20px);
        border-radius: 50%;
        z-index: -1;
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
    
    /* Animations */
    @keyframes float {
        0% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(10px, 15px) rotate(3deg); }
        100% { transform: translate(-10px, 5px) rotate(-3deg); }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive styles */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 4rem;
        }
        
        .section-title {
            font-size: 2.2rem;
        }
        
        .form-container {
            padding: 2.5rem;
        }
        
        .contact-info-box {
            margin-bottom: 2rem;
        }
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 3rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .map-container {
            margin-top: 3rem;
        }
    }
    
    @media (max-width: 576px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-subtitle {
            font-size: 0.9rem;
        }
        
        .section-title {
            font-size: 1.8rem;
        }
        
        .preloader-text {
            font-size: 10vw;
        }
        
        .form-container {
            padding: 1.5rem;
        }
        
        .success-content {
            padding: 2rem;
        }
    }
</style>

<!-- ►►► fixed-header spacing ◄◄◄ -->
<style>
    :root{ --header-h:72px; }
    @media (max-width:575.98px){ :root{ --header-h:56px; } }
    .hero-section{ padding-top: calc(var(--header-h) + 40px); }
</style>
<!-- end fixed-header spacing -->


<!-- Preloader -->
<div class="preloader">
    <div class="preloader-text">VERA<span class="accent">VIA</span></div>
</div>

<!-- Success Popup -->
<div class="success-popup" id="successPopup">
    <div class="success-content">
        <div class="success-icon">
            <svg class="checkmark" viewBox="0 0 52 52">
                <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
        </div>
        <h3 class="success-title">Terima Kasih</h3>
        <p class="success-message">Pesan Anda telah berhasil dikirim. Tim kami akan segera menghubungi Anda dalam 24 jam kerja.</p>
        <button class="btn-close" id="closePopup"></button>
    </div>
</div>

<!-- Custom cursor -->
<div class="cursor"></div>
<div class="cursor-follower"></div>

<div class="landing-wrapper" data-scroll-container>
    <div class="pattern-overlay"></div>

    <div class="gold-accent gold-accent-1"></div>
    <div class="gold-accent gold-accent-2"></div>

    <!-- Main Content -->
    <section class="content-section" data-scroll-section>
        <div class="container">
            <!-- Contact Info Section -->
            <div class="row g-4 contact-info-wrapper">
                <div class="col-md-4">
                    <div class="contact-info-box">
                        <div class="info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <h3 class="info-title">Alamat Kami</h3>
                        <p class="info-text">
                            PJ7J+CRV, CitraLand CBD Boulevard<br>
                            Made, Sambikerep, Surabaya<br>
                            East Java 60219
                            Indonesia

                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="contact-info-box">
                        <div class="info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <h3 class="info-title">Kontak Kami</h3>
                        <p class="info-text">
                            Telepon: +6285103177002<br>
                            WhatsApp: +6285179830007<br>
                            <a href="mailto:veravia.id@gmail.com" class="info-link">veravia.id@gmail.com</a>
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="contact-info-box">
                        <div class="info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <h3 class="info-title">Jam Operasional</h3>
                        <p class="info-text">
                            Senin - Jumat: 09:00 - 17:00<br>
                            Sabtu - Minggu: 09:00 - 13:00<br>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-lg-7">
                    <p class="section-subtitle">Sampaikan Pesan Anda</p>
                    <h2 class="section-title">Pesan atau Pertanyaan</h2>
                    
                    <form class="form-container" id="contactForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" placeholder=" " required>
                                    <label for="name" class="form-label">Nama</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" placeholder=" " required>
                                    <label for="email" class="form-label">Alamat Email</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <input type="tel" class="form-control" id="phone" placeholder=" ">
                            <label for="phone" class="form-label">Nomor Telepon&nbsp;(opsional)</label>
                        </div>

                        <div class="form-group">
                            <textarea class="form-control form-textarea" id="message" rows="2" placeholder=" " required></textarea>
                            <label for="message" class="form-label">Pesan</label>
                        </div>

                        <button type="submit" class="btn-submit">Kirim Pesan</button>
                    </form>
                </div>

                <div class="col-lg-5">
                    <div class="map-container position-relative">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.598861580384!2d112.62947457518293!3d-7.28639789272097!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fdfddb10d7c3%3A0x10c33792cd684f92!2sUC%20Ventures!5e0!3m2!1sen!2sid!4v1747620752577!5m2!1sen!2sid"
                            width="130%" height="170%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>

                        <div class="map-overlay" id="mapOverlay">
                            <span class="map-overlay-text">Klik untuk mengaktifkan peta</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- JS Libraries -->
<script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<script>
    /* Custom cursor */
    const cursor = document.querySelector('.cursor');
    const follower = document.querySelector('.cursor-follower');

    document.addEventListener('mousemove', (e) => {
        const { clientX: x, clientY: y } = e;
        cursor.style.transform = `translate(${x}px, ${y}px)`;
        follower.style.transform = `translate(${x}px, ${y}px)`;
    });

    /* Locomotive Scroll */
    const scroll = new LocomotiveScroll({
        el: document.querySelector('[data-scroll-container]'),
        smooth: true
    });

    /* Preloader */
    window.addEventListener('load', () => {
        document.querySelector('.preloader').classList.add('d-none');
    });

    /* Contact Form */
    const contactForm = document.getElementById('contactForm');
    const successPopup = document.getElementById('successPopup');
    const closePopup = document.getElementById('closePopup');

    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        // TODO: replace with actual AJAX
        setTimeout(() => {
            successPopup.classList.add('active');
            contactForm.reset();
        }, 400);
    });

    closePopup.addEventListener('click', () => {
        successPopup.classList.remove('active');
    });

    /* Map Overlay */
    const mapOverlay = document.getElementById('mapOverlay');
    mapOverlay.addEventListener('click', () => {
        mapOverlay.classList.add('hidden');
    });
</script>
@endsection
                            