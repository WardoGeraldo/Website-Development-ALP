@extends('base.base')
@section('hide_header_footer', true)
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@300;400;500;600;700&family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
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
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Montserrat', sans-serif;
        min-height: 100vh;
        overflow-x: hidden;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    /* Light mode styles */
    body:not(.dark-mode) {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        color: #333;
    }

    body:not(.dark-mode) .password-reset-container {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(0, 0, 0, 0.1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    body:not(.dark-mode) .form-input {
        background: rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.1);
        color: #333;
    }

    body:not(.dark-mode) .form-input:focus {
        background: rgba(0, 0, 0, 0.07);
        border-color: var(--primary-gold);
    }

    body:not(.dark-mode) .form-input:focus + label,
    body:not(.dark-mode) .form-input:not(:placeholder-shown) + label {
        background: rgba(255, 255, 255, 0.9);
        color: var(--secondary-gold);
    }

    body:not(.dark-mode) .form-group label {
        color: rgba(0, 0, 0, 0.65);
    }

    body:not(.dark-mode) .back-to-login a {
        color: rgba(0, 0, 0, 0.65);
    }

    body:not(.dark-mode) .alert-danger {
        background: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.3);
        color: #dc3545;
    }

    /* Dark mode styles */
    body.dark-mode {
        background: radial-gradient(ellipse at top right, #1a1a1a, var(--bg-dark) 60%);
        color: #ffffff;
    }

    body.dark-mode .password-reset-container {
        background: rgba(12, 12, 12, 0.4);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6), 0 0 100px rgba(212, 175, 122, 0.05);
    }

    body.dark-mode .form-input {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    body.dark-mode .form-input:focus {
        background: rgba(255, 255, 255, 0.07);
        border-color: var(--primary-gold);
    }

    body.dark-mode .form-input:focus + label,
    body.dark-mode .form-input:not(:placeholder-shown) + label {
        background: rgba(12, 12, 12, 0.9);
        color: var(--light-gold);
    }

    body.dark-mode .form-group label {
        color: rgba(255, 255, 255, 0.65);
    }

    body.dark-mode .back-to-login a {
        color: rgba(255, 255, 255, 0.65);
    }

    body.dark-mode .alert-danger {
        background: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.3);
        color: #ff6b6b;
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
        0% { transform: translateX(-100%); width: 0; }
        50% { width: 100%; }
        100% { transform: translateX(100%); width: 0; }
    }

    .password-reset-wrapper {
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
        0% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; }
        100% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.7; }
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
        opacity: 0;
        animation: fadeIn 2s ease forwards 1s;
    }

    .password-reset-container {
        position: relative;
        width: 90%;
        max-width: 500px;
        border-radius: 24px;
        overflow: hidden;
        transform-style: preserve-3d;
        transform: translateZ(0) rotateX(0) rotateY(0);
        transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        z-index: 10;
        opacity: 0;
        animation: containerReveal 1.2s cubic-bezier(0.23, 1, 0.32, 1) forwards 0.5s;
    }

    @keyframes containerReveal {
        0% { opacity: 0; transform: perspective(1200px) rotateX(5deg) translateY(30px); }
        100% { opacity: 1; transform: perspective(1200px) rotateX(0) translateY(0); }
    }

    .password-reset-container::before {
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

    .password-reset-form {
        display: flex;
        flex-direction: column;
        padding: 3.5rem;
        position: relative;
        overflow: hidden;
        z-index: 2;
    }

    .password-reset-header {
        margin-bottom: 2.5rem;
        text-align: center;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 1s ease forwards 1.4s;
    }

    .password-reset-header h2 {
        font-family: 'Cormorant', serif;
        font-weight: 600;
        font-size: 2.2rem;
        margin-bottom: 1rem;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: 1px;
    }

    .password-reset-header p {
        font-weight: 300;
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.75);
        line-height: 1.6;
        letter-spacing: 0.5px;
    }

    .veravia-logo-small {
        font-family: 'Cormorant', serif;
        font-weight: 700;
        font-size: 1.6rem;
        letter-spacing: 4px;
        color: transparent;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        background-clip: text;
        margin-bottom: 1.5rem;
        text-align: center;
        opacity: 0;
        animation: fadeInDown 1s ease forwards 1.2s;
    }

    .form-group {
        position: relative;
        margin-bottom: 2.2rem;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 1s ease forwards;
    }

    .form-group:nth-child(3) { animation-delay: 1.6s; }
    .form-group:nth-child(4) { animation-delay: 1.7s; }
    .form-group:nth-child(5) { animation-delay: 1.8s; }

    .form-group label {
        display: block;
        position: absolute;
        top: 50%;
        left: 16px;
        transform: translateY(-50%);
        font-size: 0.95rem;
        font-weight: 300;
        pointer-events: none;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
    }

    .form-input {
        width: 100%;
        padding: 16px;
        border-radius: 12px;
        font-family: 'Montserrat', sans-serif;
        font-size: 1rem;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
    }

    .form-input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(212, 175, 122, 0.15);
    }

    .form-input:focus + label,
    .form-input:not(:placeholder-shown) + label {
        top: 0;
        left: 12px;
        transform: translateY(-50%);
        padding: 0 6px;
        font-size: 0.8rem;
        border-radius: 4px;
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

    .btn:hover::before { transform: translateX(100%); }

    .btn-reset {
        background: var(--gradient-gold);
        color: var(--text-dark);
        opacity: 0;
        animation: fadeInUp 1s ease forwards 1.9s;
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(212, 175, 122, 0.1);
        background: var(--gradient-gold-hover);
    }

    .btn:active { transform: translateY(-1px); }

    .back-to-login {
        margin-top: 2rem;
        text-align: center;
        opacity: 0;
        animation: fadeIn 1s ease forwards 2s;
    }

    .back-to-login a {
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        position: relative;
        letter-spacing: 0.5px;
        font-weight: 300;
    }

    .back-to-login a::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 0;
        height: 1px;
        background: var(--gradient-gold);
        transition: width 0.4s ease;
    }

    .back-to-login a:hover { color: var(--light-gold); }
    .back-to-login a:hover::after { width: 100%; }

    .alert {
        padding: 1.2rem;
        border-radius: 12px;
        margin-bottom: 1.8rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.95rem;
        letter-spacing: 0.3px;
        opacity: 0;
        animation: fadeIn 1s ease forwards 1.6s;
    }

    .alert-dismissible .btn-close {
        background: transparent;
        border: none;
        color: inherit;
        font-size: 1.2rem;
        cursor: pointer;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .password-reset-container { width: 95%; max-width: 460px; }
        .password-reset-form { padding: 3rem 2.5rem; }
        .password-reset-header h2 { font-size: 2rem; }
        .brand-watermark { font-size: 18vw; }
    }

    @media (max-width: 480px) {
        .password-reset-form { padding: 2.5rem 1.8rem; }
        .password-reset-header h2 { font-size: 1.8rem; }
        .form-group { margin-bottom: 1.8rem; }
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
        cursor: grab;
        z-index: 10000;
        font-size: 1.3rem;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
        user-select: none;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        opacity: 0;
        animation: fadeIn 1s ease forwards 2.5s;
    }

    .dark-mode-toggle:hover {
        background-color: #e76767;
        box-shadow: 0 6px 12px rgba(231, 103, 103, 0.7);
    }

    @media (max-width: 768px) {
        .dark-mode-toggle {
            top: auto;
            bottom: 20px;
            right: 20px;
            padding: 0.6rem 1rem;
            font-size: 1.1rem;
        }
    }

    @media (max-width: 480px) {
        .dark-mode-toggle {
            bottom: 15px;
            right: 15px;
            font-size: 1rem;
        }
    }
</style>

<div class="preloader" id="preloader">
    <div class="preloader-logo">VERAVIA</div>
</div>

<!-- Dark Mode Toggle Button -->
<button class="dark-mode-toggle" aria-label="Toggle dark mode" title="Toggle dark mode">🌙</button>

<div class="password-reset-wrapper">
    <div class="background-effect">
        <div class="luxury-ambience"></div>
        <div class="brand-watermark">VERAVIA</div>
    </div>

    <div class="password-reset-container" id="passwordResetContainer">
        <div class="password-reset-form">
            <div class="veravia-logo-small">VERAVIA</div>
            
            <div class="password-reset-header">
                <h2>Reset Your Password</h2>
                <p>Set your new password below</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span>{{ $errors->first() }}</span>
                    <button type="button" class="btn-close" aria-label="Close"
                        onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <input type="email" id="email" name="email" 
                        class="form-input" 
                        placeholder=" " value="{{ old('email', request()->email) }}" required>
                    <label for="email">Email Address</label>
                </div>

                <div class="form-group">
                    <input type="password" id="password" name="password" 
                        class="form-input" 
                        placeholder=" " required>
                    <label for="password">New Password</label>
                </div>

                <div class="form-group">
                    <input type="password" id="password-confirm" name="password_confirmation" 
                        class="form-input" 
                        placeholder=" " required>
                    <label for="password-confirm">Confirm New Password</label>
                </div>

                <button type="submit" class="btn btn-reset">Reset Password</button>

                <div class="back-to-login">
                    <a href="{{ route('login') }}">← Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('status'))
        Swal.fire({
            icon: 'success',
            title: '{{ session('status') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: '{{ $errors->first() }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
        });
    @endif

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

        // 3D tilt effect
        const passwordResetContainer = document.getElementById('passwordResetContainer');
        document.addEventListener('mousemove', function(e) {
            const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
            passwordResetContainer.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
        });

        document.addEventListener('mouseleave', function() {
            passwordResetContainer.style.transform = 'rotateY(0deg) rotateX(0deg)';
        });
    });
</script>

@endsection