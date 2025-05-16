@extends('base.base')

@section('content')
<style>
    body {
        background: linear-gradient(135deg);
        margin: 0;
        padding: 0;
    }

    .auth-wrapper {
        display: flex;
        justify-content: center;
        padding: 40px 15px; /* Smaller top/bottom padding */
    }

    .auth-box {
        background-color: #fff;
        padding: 1.25rem 1rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        width: 100%;
        max-width: 360px;
    }

    .auth-box h4 {
        font-weight: 600;
        font-size: 1.15rem;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .auth-box p {
        font-size: 0.85rem;
        color: #666;
        text-align: center;
        margin-bottom: 1rem;
    }

    .btn-custom {
        background-color: #000;
        color: #fff;
        transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #e76767;
    }

    .extra-links {
        text-align: center;
        margin-top: 0.75rem;
        font-size: 0.85rem;
    }

    .extra-links a {
        color: #555;
        text-decoration: none;
    }

    .extra-links a:hover {
        color: #e76767;
        text-decoration: underline;
    }
</style>

<div class="auth-wrapper">
    <div class="auth-box">
        <h4>Forgot Password</h4>
        <p>We'll send you a link to reset your password.</p>

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email.custom') }}">
            @csrf

            <div class="form-floating mb-3">
                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Email address"
                    required
                    autofocus
                >
                <label for="email">Email address</label>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-custom w-100">Send Reset Link</button>
        </form>

        <div class="extra-links">
            <a href="{{ route('login.show') }}">← Back to Login</a>
        </div>
    </div>
</div>
@endsection