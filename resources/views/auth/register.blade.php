@extends('base.base')
@section('hide_header_footer', true)
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

        .signup-wrapper {
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

        .signup-container {
            position: relative;
            width: 90%;
            max-width: 550px;
            background: rgba(12, 12, 12, 0.4);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6), 0 2px 4px rgba(255, 255, 255, 0.03), 0 0 1px rgba(255, 255, 255, 0.1), 0 0 100px rgba(212, 175, 122, 0.05);
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

        .signup-container::before {
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

        .signup-form {
            display: flex;
            flex-direction: column;
            padding: 3rem;
            position: relative;
            overflow: hidden;
            z-index: 2;
        }

        .signup-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(18, 18, 18, 0.4), rgba(12, 12, 12, 0.8));
            z-index: -1;
        }

        .signup-header {
            margin-bottom: 2rem;
            text-align: center;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease forwards 1.4s;
        }

        .signup-header h2 {
            font-family: 'Cormorant', serif;
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 0.8rem;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
        }

        .signup-header p {
            font-weight: 300;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.6;
            letter-spacing: 0.5px;
        }

        .veravia-logo-small {
            font-family: 'Cormorant', serif;
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 4px;
            color: transparent;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            background-clip: text;
            margin-bottom: 1.2rem;
            text-align: center;
            opacity: 0;
            animation: fadeInDown 1s ease forwards 1.2s;
        }

        .form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.8rem;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.8rem;
            opacity: 0;
            transform: translateY(30px);
            flex: 1;
        }

        .form-group:nth-child(1) {
            animation: fadeInUp 1s ease forwards 1.6s;
        }

        .form-group:nth-child(2) {
            animation: fadeInUp 1s ease forwards 1.7s;
        }

        .form-group:nth-child(3) {
            animation: fadeInUp 1s ease forwards 1.8s;
        }

        .form-group:nth-child(4) {
            animation: fadeInUp 1s ease forwards 1.9s;
        }

        .form-group:nth-child(5) {
            animation: fadeInUp 1s ease forwards 2.0s;
        }

        .form-group:nth-child(6) {
            animation: fadeInUp 1s ease forwards 2.1s;
        }

        .form-group label {
            display: block;
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            font-size: 0.85rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.65);
            pointer-events: none;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #ffffff;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.95rem;
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
            font-size: 0.75rem;
            background: rgba(12, 12, 12, 0.9);
            border-radius: 4px;
            color: var(--light-gold);
        }

        .btn {
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 0.95rem;
            letter-spacing: 0.8px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
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

        .btn-signup {
            background: var(--gradient-gold);
            color: var(--text-dark);
            opacity: 0;
            animation: fadeInUp 1s ease forwards 2.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(212, 175, 122, 0.1);
            background: var(--gradient-gold-hover);
        }

        .btn:active {
            transform: translateY(-1px);
        }

        .login-link {
            margin-top: 1.5rem;
            text-align: center;
            opacity: 0;
            animation: fadeIn 1s ease forwards 2.4s;
        }

        .login-link a {
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            position: relative;
            letter-spacing: 0.5px;
            font-weight: 300;
        }

        .login-link a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--gradient-gold);
            transition: width 0.4s ease;
        }

        .login-link a:hover {
            color: var(--light-gold);
        }

        .login-link a:hover::after {
            width: 100%;
        }

        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
            opacity: 0;
            animation: fadeIn 1s ease forwards 1.6s;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #ff6b6b;
        }

        .alert ul {
            margin: 0;
            padding-left: 1rem;
        }

        .alert li {
            margin-bottom: 0.3rem;
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

        @media (max-width: 768px) {
            .signup-container {
                width: 95%;
                max-width: 480px;
            }

            .signup-form {
                padding: 2.5rem 2rem;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .signup-header h2 {
                font-size: 1.8rem;
            }

            .brand-watermark {
                font-size: 18vw;
            }
        }

        @media (max-width: 480px) {
            .signup-form {
                padding: 2rem 1.5rem;
            }

            .signup-header h2 {
                font-size: 1.6rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }
        }
    </style>

    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="preloader-logo">VERAVIA</div>
    </div>

    <div class="signup-wrapper">
        <div class="background-effect">
            <div class="luxury-ambience"></div>
            <div class="floating-particles" id="particles"></div>
            <div class="brand-watermark">VERAVIA</div>
        </div>

        <div class="signup-container" id="signupContainer">
            <div class="signup-form">
                <div class="veravia-logo-small">VERAVIA</div>

                <div class="signup-header">
                    <h2>Create Account</h2>
                    <p>Join our exclusive community</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf
                    <div class="form-group">
                        <input type="text" id="name" name="name"
                            class="form-input @error('name') is-invalid @enderror" placeholder=" "
                            value="{{ old('name') }}" required autofocus>
                        <label for="name">Full Name</label>
                    </div>

                    <div class="form-group">
                        <input type="email" id="email" name="email"
                            class="form-input @error('email') is-invalid @enderror" placeholder=" "
                            value="{{ old('email') }}" required>
                        <label for="email">Email Address</label>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <input type="password" id="password" name="password"
                                class="form-input @error('password') is-invalid @enderror" placeholder=" " required>
                            <label for="password">Password</label>
                        </div>

                        <div class="form-group">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-input" placeholder=" " required>
                            <label for="password_confirmation">Confirm Password</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" id="phone_number" name="phone_number"
                            class="form-input @error('phone_number') is-invalid @enderror" placeholder=" "
                            value="{{ old('phone_number') }}">
                        <label for="phone_number">Phone Number (Optional)</label>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <input type="date" id="birthdate" name="birthdate"
                                class="form-input @error('birthdate') is-invalid @enderror" placeholder=" "
                                value="{{ old('birthdate') }}">
                            <label for="birthdate">Birth Date (Optional)</label>
                        </div>

                        <div class="form-group">
                            <input type="text" id="address" name="address"
                                class="form-input @error('address') is-invalid @enderror" placeholder=" "
                                value="{{ old('address') }}">
                            <label for="address">Address (Optional)</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-signup">Create Account</button>
                </form>

                <div class="login-link">
                    <a href="{{ route('login') }}">Already have an account? Sign In</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Preloader
            const preloader = document.getElementById('preloader');
            if (preloader) {
                setTimeout(function() {
                    preloader.classList.add('hidden');
                    setTimeout(function() {
                        preloader.style.display = 'none';
                    }, 1000);
                }, 1500);
            }

            // Floating particles effect
            const particlesContainer = document.getElementById('particles');

            function createParticle() {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                const size = Math.random() * 6 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;

                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;

                particle.style.opacity = Math.random() * 0.1 + 0.05;

                particlesContainer.appendChild(particle);

                setTimeout(() => {
                    particle.style.opacity = '0';
                    setTimeout(() => {
                        particle.remove();
                    }, 500);
                }, 5000);
            }

            setInterval(createParticle, 500);

            for (let i = 0; i < 20; i++) {
                setTimeout(createParticle, i * 200);
            }

            // 3D tilt effect
            const signupContainer = document.getElementById('signupContainer');

            document.addEventListener('mousemove', function(e) {
                const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
                const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
                signupContainer.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
            });

            document.addEventListener('mouseleave', function() {
                signupContainer.style.transform = 'rotateY(0deg) rotateX(0deg)';
            });

            // Form handling
            const registerForm = document.getElementById('registerForm');

            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    const password = document.getElementById('password').value;
                    const passwordConfirmation = document.getElementById('password_confirmation').value;
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const registerForm = document.getElementById('registerForm');

            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    const password = document.getElementById('password').value;
                    const passwordConfirmation = document.getElementById('password_confirmation').value;

                    if (password !== passwordConfirmation) {
                        e.preventDefault(); // stop form submit
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Passwords do not match!',
                            confirmButtonColor: '#d4af7a', // gold button
                            background: '#0c0c0c',
                            color: '#fff'
                        });
                        return false;
                    }
                });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                position: 'top-end',
                toast: true
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#d4af7a',
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif


@endsection
