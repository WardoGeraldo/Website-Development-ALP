@extends('base.base')

@section('content')
<style>
    body {
        background: linear-gradient(to right);
    }

    .login-box {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 450px;
        margin: auto;
        transition: all 0.3s ease-in-out;
    }

    .fade-in {
        opacity: 0;
        max-height: 0;
        overflow: hidden;
        transition: all 0.4s ease;
    }

    .fade-in.show {
        opacity: 1;
        max-height: 500px;
        margin-top: 1rem;
    }

    .btn-custom {
        background-color: black;
        color: white;
        border: none;
    }

    .btn-custom:hover {
        background-color: #e76767;
    }

    .extra-actions {
        margin-top: 1rem;
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
    }

    .extra-actions a {
        text-decoration: none;
        color: #555;
    }

    .extra-actions a:hover {
        text-decoration: underline;
        color: #e76767;
    }
</style>

<div class="container py-5">
    <div class="login-box">
        <h3 class="text-center mb-4">Login</h3>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login.auth') }}" id="loginForm">
            @csrf

            {{-- Step 1: Email --}}
            <div class="form-floating mb-3">
                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="emailInput"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="name@example.com"
                    required
                >
                <label for="emailInput">Email</label>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="button" id="nextBtn" class="btn btn-custom w-100 mb-2">Next</button>

            {{-- Step 2: Password --}}
            <div class="fade-in" id="passwordContainer">
                <div class="form-floating mb-3">
                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        id="passwordInput"
                        placeholder="Password"
                        required
                    >
                    <label for="passwordInput">Password</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-custom w-100">Login</button>
            </div>

            {{-- Always-visible extra actions --}}
            <div class="extra-actions mt-3">
                <a href="{{ route('register') }}">Sign Up</a>
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
        </form>
    </div>
</div>

<script>
    const nextBtn = document.getElementById('nextBtn');
    const emailInput = document.getElementById('emailInput');
    const passwordContainer = document.getElementById('passwordContainer');
    
    // Fungsi untuk cek email dan menampilkan password input jika valid
    nextBtn.addEventListener('click', function () {
        const email = emailInput.value.trim();
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        
        if (email && emailPattern.test(email)) {
            passwordContainer.classList.add('show');
            nextBtn.style.display = 'none'; // Menyembunyikan tombol Next
        } else {
            alert('Please enter a valid email address.');
        }
    });
</script>
@endsection
