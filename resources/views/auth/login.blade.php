
@extends('base.base')

@section('content')
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant:wght@300;400;500;600;700&family=Montserrat:wght@200;300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-gold: #d4af7a;
            --secondary-gold: #bf9b56;
            --light-gold: #e7c8a0;
            --very-light-gold: #f0dfc0;
            --text-dark: #101010;
            --bg-dark: #0c0c0c;
            --bg-darker: #070707;
            --gradient-gold: linear-gradient(135deg, #e7c8a0, #d4af7a, #bf9b56);
            --gradient-gold-hover: linear-gradient(135deg, #f0dfc0, #e7c8a0, #d4af7a);
            --gradient-dark: linear-gradient(to bottom, rgba(12, 12, 12, 0.95), rgba(7, 7, 7, 0.98));
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-dark);
            color: #ffffff;
            overflow-x: hidden;
            min-height: 100vh;
            background: radial-gradient(ellipse at top right, #1a1a1a, #0c0c0c 60%);
        }


        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-darker);
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

        /* Ensure all animations complete */
        .animate__animated {
            --animate-duration: 1s;
        }

        .login-wrapper {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem 0;
            perspective: 1200px;
        }

        .background-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .luxury-ambience {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 80vw;
            height: 80vh;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            background: radial-gradient(circle at center, rgba(212, 175, 122, 0.06) 0%, rgba(212, 175, 122, 0) 70%);
            filter: blur(40px);
            pointer-events: none;
            opacity: 0;
            animation: pulse 8s ease-in-out infinite alternate, fadeIn 2s ease forwards 0.5s;
        }

        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.5;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 0.7;
            }
        }

        .floating-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: var(--gradient-gold);
            border-radius: 50%;
            opacity: 0;
            filter: blur(3px);
            transition: all 0.5s ease;
        }

        .brand-watermark {
            position: absolute;
            font-family: 'Cormorant', serif;
            font-size: 20vw;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.012);
            z-index: 0;
            pointer-events: none;
            text-transform: uppercase;
            letter-spacing: 3vw;
            width: 100%;
            text-align: center;
            transition: all 0.5s ease;
            opacity: 0;
            animation: fadeIn 2s ease forwards 1s;
        }

        .login-container {
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 90%;
            max-width: 1200px;
            height: 650px;
            background: rgba(12, 12, 12, 0.4);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6),
                0 2px 4px rgba(255, 255, 255, 0.03),
                0 0 1px rgba(255, 255, 255, 0.1),
                0 0 100px rgba(212, 175, 122, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transform-style: preserve-3d;
            transform: translateZ(0) rotateX(0) rotateY(0);
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            z-index: 10;
            opacity: 0;
            animation: containerReveal 1.2s cubic-bezier(0.23, 1, 0.32, 1) forwards 0.5s;
        }

        @keyframes containerReveal {
            0% {
                opacity: 0;
                transform: translateZ(0) perspective(1200px) rotateX(5deg) translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateZ(0) perspective(1200px) rotateX(0) translateY(0);
            }
        }

        .login-container::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 24px;
            padding: 1px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0), rgba(212, 175, 122, 0.15), rgba(255, 255, 255, 0));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
            z-index: 11;
        }

        .login-image {
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg,
                    rgba(0, 0, 0, 0.3),
                    rgba(0, 0, 0, 0.1));
            z-index: 1;
        }

        .image-grain {
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

        .login-image .image-carousel {
            position: absolute;
            width: 100%;
            height: 100%;
            transform: scale(1.05);
        }

        .carousel-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1.8s ease-in-out, transform 6s ease-in-out;
            transform: scale(1.05);
        }

        .carousel-image.active {
            opacity: 0;
            transform: scale(1);
        }

        .veravia-logo {
            position: absolute;
            top: 40px;
            left: 40px;
            z-index: 5;
            font-family: 'Cormorant', serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--text-light);
            letter-spacing: 4px;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            padding: 10px;
            opacity: 0;
            animation: fadeInDown 1s ease forwards 1.2s;
        }

        .login-quote {
            position: absolute;
            bottom: 50px;
            left: 0;
            width: 100%;
            padding: 0 50px;
            z-index: 5;
            text-align: center;
            opacity: 0;
            animation: fadeIn 1.2s ease forwards 1.5s;
            transform: translateY(20px);
        }

        .login-quote q {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-weight: 400;
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.6;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .login-quote cite {
            display: block;
            margin-top: 12px;
            font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: 300;
            font-size: 0.85rem;
            color: var(--light-gold);
            letter-spacing: 1.5px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
            position: relative;
            overflow: hidden;
            z-index: 2;
        }

        .login-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(18, 18, 18, 0.4), rgba(12, 12, 12, 0.8));
            z-index: -1;
        }

        .login-welcome {
            margin-bottom: 3.5rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease forwards 1.4s;
        }

        .login-welcome h2 {
            font-family: 'Cormorant', serif;
            font-weight: 600;
            font-size: 2.5rem;
            margin-bottom: 1.2rem;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
        }

        .login-welcome p {
            font-weight: 300;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.6;
            letter-spacing: 0.5px;
        }

        .form-group {
            position: relative;
            margin-bottom: 2.2rem;
            opacity: 0;
            transform: translateY(30px);
        }

        .form-group.email-group {
            animation: fadeInUp 1s ease forwards 1.6s;
        }

        .form-group.password-group {
            animation: fadeInUp 1s ease forwards 1.8s;
            max-height: 0;
            margin: 0;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .form-group.password-group.show {
            max-height: 100px;
            margin-bottom: 2.2rem;
        }

        .form-group label {
            display: block;
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            font-size: 0.95rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.65);
            pointer-events: none;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 16px;
            padding-left: 16px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 122, 0.15);
            background: rgba(255, 255, 255, 0.07);
        }

        .form-input:focus+label,
        .form-input:not(:placeholder-shown)+label {
            top: 0;
            left: 12px;
            transform: translateY(-50%);
            padding: 0 6px;
            font-size: 0.8rem;
            background: rgba(12, 12, 12, 0.9);
            border-radius: 4px;
            color: var(--light-gold);
        }

        .btn {
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 1rem;
            letter-spacing: 0.8px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            opacity: 0;
            transform: translateY(20px);
            overflow: hidden;
            position: relative;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: transform 0.5s ease;
        }

        .btn:hover::before {
            transform: translateX(100%);
        }

        .btn-next {
            background: var(--gradient-gold);
            color: var(--text-dark);
            animation: fadeInUp 1s ease forwards 2s;
        }

        .btn-login {
            background: var(--gradient-gold);
            color: var(--text-dark);
            opacity: 1; /* Changed from 0 */
            display: block; /* Changed from none */
            animation: fadeInUp 1s ease forwards 0.4s;
            z-index: 100; /* Added z-index */
            position: relative; /* Added position */
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(212, 175, 122, 0.1);
            background: var(--gradient-gold-hover);
        }

        .btn:active {
            transform: translateY(-1px);
        }

        .extra-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 2.5rem;
            font-size: 0.9rem;
            opacity: 0;
            animation: fadeIn 1s ease forwards 2.2s;
        }

        .extra-actions a {
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            letter-spacing: 0.5px;
            font-weight: 300;
        }

        .extra-actions a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--gradient-gold);
            transition: width 0.4s ease;
        }

        .extra-actions a:hover {
            color: var(--light-gold);
        }

        .extra-actions a:hover::after {
            width: 100%;
        }

        .alert {
            padding: 1.2rem;
            border-radius: 12px;
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #ff6b6b;
            margin-bottom: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        .alert-dismissible .btn-close {
            background: transparent;
            border: none;
            color: #ff6b6b;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .loader {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            z-index: 100;
        }

        .loader::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            box-sizing: border-box;
            border: 3px solid transparent;
            border-top-color: var(--primary-gold);
            border-bottom-color: var(--light-gold);
            animation: spinLoader 1.2s ease-in-out infinite;
        }

        .loader::after {
            content: '';
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            box-sizing: border-box;
            border: 3px solid transparent;
            border-left-color: var(--secondary-gold);
            border-right-color: var(--very-light-gold);
            animation: spinLoader 0.8s linear infinite reverse;
        }

        @keyframes spinLoader {
            to {
                transform: rotate(360deg);
            }
        }

        .form-validation-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            display: none;
        }

        .form-validation-icon.valid {
            display: block;
            color: #4caf50;
        }

        .form-validation-icon.invalid {
            display: block;
            color: #f44336;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
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

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatAnimation {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0);
            }
        }

        @keyframes glimmer {
            0% {
                opacity: 0.3;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 0.3;
            }
        }

        @media (max-width: 1024px) {
            .login-container {
                width: 92%;
                height: 600px;
            }

            .login-form {
                padding: 3rem;
            }

            .login-welcome h2 {
                font-size: 2.2rem;
            }

            .veravia-logo {
                font-size: 1.6rem;
                top: 30px;
                left: 30px;
            }

            .login-quote {
                padding: 0 40px;
                bottom: 40px;
            }

            .login-quote q {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
                height: auto;
                max-width: 520px;
            }

            .login-image {
                display: none;
            }

            .login-form {
                padding: 3rem 2.5rem;
            }

            .login-welcome {
                margin-bottom: 2.5rem;
            }

            .login-welcome h2 {
                font-size: 2.2rem;
                text-align: center;
            }

            .login-welcome p {
                text-align: center;
            }

            .btn {
                padding: 14px;
            }

            .brand-watermark {
                font-size: 18vw;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                width: 95%;
            }

            .login-form {
                padding: 2.5rem 1.8rem;
            }

            .login-welcome h2 {
                font-size: 1.8rem;
            }

            .login-welcome p {
                font-size: 0.9rem;
            }

            .form-group {
                margin-bottom: 1.8rem;
            }

            .extra-actions {
                font-size: 0.8rem;
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }
        }
    </style>

        <!-- Preloader -->
        <div class="preloader" id="preloader">
            <div class="preloader-logo">VERAVIA</div>
        </div>

        <div class="login-wrapper">
            <div class="background-effect">
                <div class="luxury-ambience"></div>
                <div class="floating-particles" id="particles"></div>
                <div class="brand-watermark">VERAVIA</div>
            </div>

            <div class="login-container" id="loginContainer">
                <div class="login-image">
                    <div class="image-overlay"></div>
                    <div class="image-grain"></div>
                    <div class="veravia-logo">VERAVIA</div>
                    <div class="image-carousel">
                        <img src="/api/placeholder/800/600" alt="Luxury Fashion Collection" class="carousel-image active">
                        <img src="/api/placeholder/800/600" alt="Premium Fashion" class="carousel-image">
                        <img src="/api/placeholder/800/600" alt="Exclusive Designer Wear" class="carousel-image">
                    </div>
                    <div class="login-quote">
                        <q>Elegance is not standing out, but being remembered.</q>
                        <cite>— Giorgio Armani</cite>
                    </div>
                </div>

                <div class="login-form">
                <div class="login-welcome">
                    <h2>Welcome Back</h2>
                    <p>Sign in to experience exclusive fashion collections</p>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
                        <span id="errorMessage">{{ session('error') }}</span>
                        <button type="button" class="btn-close" aria-label="Close"
                            onclick="document.getElementById('errorAlert').style.display='none';">×</button>
                    </div>
                @endif

                <!-- CRITICAL CHANGE: Simplified direct form that will work -->
                <form id="loginForm" method="POST" action="{{ route('login.auth') }}">
                    @csrf
                    <div class="form-group email-group">
                        <input type="email" id="emailInput" name="email"
                            class="form-input @error('email') is-invalid @enderror" placeholder=" "
                            value="{{ old('email') }}" required>
                        <label for="emailInput">Email Address</label>
                        <div class="form-validation-icon valid" id="emailValidIcon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <div class="form-validation-icon invalid" id="emailInvalidIcon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="button" id="nextBtn" class="btn btn-next">Continue</button>

                    <div class="form-group password-group" id="passwordContainer">
                        <input type="password" id="passwordInput" name="password"
                            class="form-input @error('password') is-invalid @enderror" placeholder=" " required>
                        {{-- <label for="passwordInput">Password</label> --}}
                        <div class="form-validation-icon valid" id="passwordValidIcon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <div class="form-validation-icon invalid" id="passwordInvalidIcon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fixed login button - proper type and styling -->
                    <button type="submit" id="loginBtn" class="btn btn-login">Log In</button>                    <div class="extra-actions">
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                        <a href="{{ route('register') }}">Create Account</a>
                    </div>
                </form>

                <div class="loader" id="spinner"></div>
            </div>
        </div>
    </div>

 <script>
// Replace the JavaScript portion with this fixed version
document.addEventListener("DOMContentLoaded", function() {
    // Preloader - fix to ensure it disappears
    const preloader = document.getElementById('preloader');
    if (preloader) {
        setTimeout(function() {
            preloader.classList.add('hidden');
            // Force removal after animation completes
            setTimeout(function() {
                preloader.style.display = 'none';
            }, 1000);
        }, 1500);
    }

    // Image carousel
    const images = document.querySelectorAll('.carousel-image');
    let currentIndex = 0;

    function nextImage() {
        images[currentIndex].classList.remove('active');
        currentIndex = (currentIndex + 1) % images.length;
        images[currentIndex].classList.add('active');
    }

    setInterval(nextImage, 5000);

    // Floating particles effect
    const particlesContainer = document.getElementById('particles');
    
    function createParticle() {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        
        // Random size between 2-8px
        const size = Math.random() * 6 + 2;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        
        // Random position
        const posX = Math.random() * 100;
        const posY = Math.random() * 100;
        particle.style.left = `${posX}%`;
        particle.style.top = `${posY}%`;
        
        // Random opacity
        particle.style.opacity = Math.random() * 0.1 + 0.05;
        
        particlesContainer.appendChild(particle);
        
        // Animate and remove
        setTimeout(() => {
            particle.style.opacity = '0';
            setTimeout(() => {
                particle.remove();
            }, 500);
        }, 5000);
    }
    
    // Create particles at intervals
    setInterval(createParticle, 500);
    
    // Initial particles
    for (let i = 0; i < 20; i++) {
        setTimeout(createParticle, i * 200);
    }

    // Form interaction
    const loginContainer = document.getElementById('loginContainer');
    const emailInput = document.getElementById('emailInput');
    const passwordContainer = document.getElementById('passwordContainer');
    const passwordInput = document.getElementById('passwordInput');
    const nextBtn = document.getElementById('nextBtn');
    const loginBtn = document.getElementById('loginBtn');
    const spinner = document.getElementById('spinner');
    const emailValidIcon = document.getElementById('emailValidIcon');
    const emailInvalidIcon = document.getElementById('emailInvalidIcon');
    const passwordValidIcon = document.getElementById('passwordValidIcon');
    const passwordInvalidIcon = document.getElementById('passwordInvalidIcon');
    const loginForm = document.getElementById('loginForm');

    // Make sure login button is properly initialized
    if (loginBtn) {
        loginBtn.style.display = 'none'; // Initially hidden
        loginBtn.style.opacity = '1';
        loginBtn.disabled = false; // Ensure it's not disabled by default
    }

    // 3D tilt effect
    document.addEventListener('mousemove', function(e) {
        const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
        const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
        loginContainer.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
    });

    // Reset transform when mouse leaves
    document.addEventListener('mouseleave', function() {
        loginContainer.style.transform = 'rotateY(0deg) rotateX(0deg)';
    });

    // Email validation
    emailInput.addEventListener('input', function() {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const isValid = emailPattern.test(emailInput.value);
        
        if (emailInput.value.length > 0) {
            if (isValid) {
                emailValidIcon.style.display = 'block';
                emailInvalidIcon.style.display = 'none';
                nextBtn.disabled = false;
            } else {
                emailValidIcon.style.display = 'none';
                emailInvalidIcon.style.display = 'block';
                nextBtn.disabled = true;
            }
        } else {
            emailValidIcon.style.display = 'none';
            emailInvalidIcon.style.display = 'none';
            nextBtn.disabled = true;
        }
    });

    // FIX: Password validation - simplified logic to just check length
    passwordInput.addEventListener('input', function() {
        // Consider any password valid if it has at least 1 character
        if (passwordInput.value.length > 0) {
            passwordValidIcon.style.display = 'block';
            passwordInvalidIcon.style.display = 'none';
            if (loginBtn) loginBtn.disabled = false;
        } else {
            passwordValidIcon.style.display = 'none';
            passwordInvalidIcon.style.display = 'block';
            if (loginBtn) loginBtn.disabled = true;
        }
    });

    // Next button click
    if(nextBtn) {
        nextBtn.addEventListener('click', function() {
            if (emailInput.value) {
                nextBtn.style.display = 'none';
                passwordContainer.classList.add('show');
                // Ensure login button is visible and enabled
                if(loginBtn) {
                    loginBtn.style.display = 'block';
                    loginBtn.disabled = false;
                }
                // Focus the password field
                passwordInput.focus();
            }
        });
    }

    // FIX: Ensure the form can be submitted either by button or Enter key
    if(loginForm) {
        loginForm.addEventListener('submit', function(e) {
            // Only submit if both fields have values
            if(emailInput.value && passwordInput.value) {
                spinner.style.display = 'block';
                return true;
            } else {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // FIX: Direct click handler for the login button
    if (loginBtn) {
        loginBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default to control submission
            if(emailInput.value && passwordInput.value) {
                spinner.style.display = 'block';
                loginForm.submit();
            }
        });
    }
});    
</script>
@endsection 