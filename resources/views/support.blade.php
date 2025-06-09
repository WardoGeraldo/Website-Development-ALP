@extends('base.base')
@section('content')
    <!-- Required CSS Libraries -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.css" />

    <!-- Custom styles -->
    <style>
        .footer-section {
            padding: 40px 0;
            background-color: var(--light-gray);
            margin-top: 40px;
        }

        .text-accent {
            color: var(--accent);
        }

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
            0% {
                width: 100%;
            }

            100% {
                width: 0%;
            }
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
            height: 70vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.6)), url('/api/placeholder/1600/900') center/cover no-repeat;
            /* padding-top is now handled in the next <style> block */
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
            background: linear-gradient(to bottom, transparent, rgba(212, 175, 55, 0.2), transparent);
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
            text-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
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
            padding: 7rem 0;
            position: relative;
            z-index: 2;
            background-color: var(--primary);
        }

        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            margin-bottom: 2rem;
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
            margin-bottom: 1.5rem;
        }

        /* FAQ Section */
        .faq-container {
            position: relative;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s var(--transition) forwards;
            animation-delay: 2.4s;
        }

        .faq-item {
            margin-bottom: 1.5rem;
            border-bottom: 1px solid rgba(128, 128, 128, 0.2);
            background-color: var(--light-gray);
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .faq-question {
            font-weight: 500;
            font-size: 1.1rem;
            padding: 1.2rem 1.5rem;
            position: relative;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s;
            color: var(--text-primary);
        }

        .faq-question:hover {
            color: var(--accent-dark);
        }

        .faq-toggle {
            width: 24px;
            height: 24px;
            position: relative;
            transition: all 0.3s;
        }

        .faq-toggle::before,
        .faq-toggle::after {
            content: '';
            position: absolute;
            background: var(--accent);
            transition: all 0.3s;
        }

        .faq-toggle::before {
            width: 100%;
            height: 2px;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
        }

        .faq-toggle::after {
            width: 2px;
            height: 100%;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .faq-item.active {
            background-color: var(--primary);
            border-left: 3px solid var(--accent);
        }

        .faq-item.active .faq-question {
            color: var(--accent-dark);
        }

        .faq-item.active .faq-toggle::after {
            transform: translateX(-50%) rotate(90deg);
            opacity: 0;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: all 0.5s var(--transition);
            padding: 0 1.5rem;
            color: var(--text-secondary);
            font-size: 1rem;
            opacity: 0;
            line-height: 1.6;
        }

        .faq-item.active .faq-answer {
            max-height: 300px;
            padding: 0 1.5rem 1.5rem;
            opacity: 1;
        }

        /* Contact Form */
        .form-container {
            background-color: var(--primary);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--medium-gray);
            border-radius: 8px;
            padding: 3rem;
            position: relative;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s var(--transition) forwards;
            animation-delay: 2.6s;
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

        .form-control:focus+.form-label,
        .form-control:not(:placeholder-shown)+.form-label {
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

        /* Success Popup */
        .success-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
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
            background-color: var(--primary);
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
            background-color: rgba(212, 175, 55, 0.1);
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
            100% {
                stroke-dashoffset: 0;
            }
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
            background: linear-gradient(45deg, rgba(212, 175, 55, 0.1), rgba(212, 175, 55, 0.02));
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
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 3rem;
            }

            .faq-question {
                font-size: 1rem;
            }

            .hero-subtitle {
                font-size: 1rem;
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
        /* Change these values if your navbar height changes */
        :root {
            --header-h: 72px;
        }

        /* desktop/tablet */
        @media (max-width:575.98px) {
            :root {
                --header-h: 56px;
            }

            /* mobile */
        }

        .hero-section {
            padding-top: calc(var(--header-h) + 40px);
        }
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
                    <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
                    <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                </svg>
            </div>
            <h3 class="success-title">Terima Kasih</h3>
            <p class="success-message">Pesan Anda telah berhasil dikirim. Tim kami akan segera menghubungi Anda dalam 24 jam
                kerja.</p>
            <button class="btn-close" id="closePopup"></button>
        </div>
    </div>

    <div class="landing-wrapper" data-scroll-container>
        <div class="pattern-overlay"></div>

        <div class="gold-accent gold-accent-1"></div>
        <div class="gold-accent gold-accent-2"></div>

        <!-- Main Content -->
        <section class="content-section" data-scroll-section>
            <div class="container">
                <div class="row g-5">
                    <!-- FAQ Section -->
                    <div class="col-lg-6">
                        <p class="section-subtitle">Jawaban Untuk Anda</p>
                        <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>

                        <div class="faq-container">
                            <div class="faq-item">
                                <div class="faq-question">
                                    <span>Bagaimana cara melacak pesanan saya?</span>
                                    <div class="faq-toggle"></div>
                                </div>
                                <div class="faq-answer">
                                    Setelah pembayaran berhasil, Anda akan menerima email dengan nomor pelacakan. Dengan
                                    nomor tersebut, Anda dapat memeriksa status pengiriman pada halaman "Lacak Pesanan" di
                                    website kami atau langsung melalui website jasa pengiriman yang kami gunakan.
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-question">
                                    <span>Apakah saya bisa mengembalikan produk?</span>
                                    <div class="faq-toggle"></div>
                                </div>
                                <div class="faq-answer">
                                    Ya, Anda dapat melakukan pengembalian dalam 7 hari setelah menerima barang. Produk harus
                                    dalam kondisi asli, belum dipakai, dan dengan kemasan yang utuh. Biaya pengiriman untuk
                                    pengembalian ditanggung oleh pembeli kecuali jika ada kesalahan dari pihak kami.
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-question">
                                    <span>Bagaimana cara menghubungi tim customer service?</span>
                                    <div class="faq-toggle"></div>
                                </div>
                                <div class="faq-answer">
                                    Anda dapat menghubungi kami melalui formulir di samping atau email ke
                                    support@veravia.id. Tim kami akan merespon dalam waktu 24 jam pada hari kerja. Untuk
                                    pertanyaan yang mendesak, Anda juga dapat menghubungi kami melalui WhatsApp di nomor
                                    yang tercantum di footer website.
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-question">
                                    <span>Berapa lama waktu pengiriman?</span>
                                    <div class="faq-toggle"></div>
                                </div>
                                <div class="faq-answer">
                                    Waktu pengiriman bergantung pada lokasi Anda. Untuk wilayah Jakarta dan sekitarnya,
                                    pengiriman membutuhkan waktu 1-2 hari kerja. Untuk kota-kota besar lainnya, 2-4 hari
                                    kerja. Untuk daerah terpencil, dapat membutuhkan waktu 5-7 hari kerja.
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-question">
                                    <span>Metode pembayaran apa saja yang tersedia?</span>
                                    <div class="faq-toggle"></div>
                                </div>
                                <div class="faq-answer">
                                    Kami menerima berbagai metode pembayaran termasuk kartu kredit/debit, transfer bank,
                                    e-wallet (GoPay, OVO, DANA), dan virtual account. Seluruh transaksi dilindungi oleh
                                    sistem keamanan tingkat tinggi untuk menjamin keamanan data Anda.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="col-lg-6">
                        <p class="section-subtitle">Sampaikan Pesan Anda</p>
                        <h2 class="section-title">Hubungi Kami</h2>

                        <form class="form-container" id="contactForm" method="POST" action="{{ route('support.store') }}">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder=" "
                                    required>
                                <label for="name" class="form-label">Nama</label>
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" class="form-control" id="email" placeholder=" "
                                    required>
                                <label for="email" class="form-label">Alamat Email</label>
                            </div>

                            <div class="form-group">
                                <input type="tel" name="phone" class="form-control" id="phone" placeholder=" ">
                                <label for="phone" class="form-label">Nomor Telepon (Opsional)</label>
                            </div>

                            <div class="form-group">
                                <textarea name="message" class="form-control form-textarea" id="message" rows="4" placeholder=" " required></textarea>
                                <label for="message" class="form-label">Pesan</label>
                            </div>

                            <button type="submit" class="btn-submit">KIRIM</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer-section" data-scroll-section>
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="mb-2">© 2025 VeraVia. All Rights Reserved.</p>
                        <p class="small text-muted">Created with <i class="text-accent">♥</i> in Surabaya</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Required JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.js"></script>
    <script>
        // Preloader
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.querySelector('.preloader').style.opacity = 0;
                setTimeout(() => {
                    document.querySelector('.preloader').style.display = 'none';
                }, 1000);
            }, 2000);
        });

        // Custom cursor
        document.addEventListener('DOMContentLoaded', () => {
            const cursor = document.querySelector('.cursor');
            const cursorFollower = document.querySelector('.cursor-follower');

            document.addEventListener('mousemove', (e) => {
                gsap.to(cursor, {
                    duration: 0.1,
                    x: e.clientX,
                    y: e.clientY
                });

                gsap.to(cursorFollower, {
                    duration: 0.3,
                    x: e.clientX,
                    y: e.clientY
                });
            });

            // Initialize smooth scroll
            const scroll = new LocomotiveScroll({
                el: document.querySelector('[data-scroll-container]'),
                smooth: true,
                smartphone: {
                    smooth: true
                },
                tablet: {
                    smooth: true
                }
            });

            // Fix for FAQ questions
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');

                question.addEventListener('click', () => {
                    // Close all other open items
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item && otherItem.classList.contains('active')) {
                            otherItem.classList.remove('active');
                        }
                    });

                    // Toggle the clicked item
                    item.classList.toggle('active');
                });
            });

            /* -------------------------------------------------
             * Contact-form submission
             * ------------------------------------------------- */
            const contactForm = document.getElementById('contactForm');
            const successPopup = document.getElementById('successPopup');
            const closePopup = document.getElementById('closePopup');

            contactForm.addEventListener('submit', (e) => {
                e.preventDefault();

                const formData = new FormData(contactForm);

                fetch('{{ route('support.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal mengirim form!');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            successPopup.classList.add('active');
                            contactForm.reset();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal mengirim pesan!');
                    });
            });


            closePopup.addEventListener('click', () => {
                successPopup.classList.remove('active');
            });

            // Close popup when clicking outside the dialog
            successPopup.addEventListener('click', (e) => {
                if (e.target === successPopup) successPopup.classList.remove('active');
            });
        });
    </script>
@endsection
