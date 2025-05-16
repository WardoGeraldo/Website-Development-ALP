@extends('base.base')

@section('content')
<style>
    body {
        background: linear-gradient(to right);
    }

    .signup-box {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
        margin: auto;
        transition: all 0.3s ease-in-out;
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
    <div class="signup-box">
        <h3 class="text-center mb-4">Sign Up</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="#">
            @csrf

            <div class="form-floating mb-3">
                <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    name="name"
                    placeholder="Full Name"
                    value="{{ old('name') }}"
                    required
                >
                <label for="name">Full Name</label>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    placeholder="name@example.com"
                    value="{{ old('email') }}"
                    required
                >
                <label for="email">Email</label>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    placeholder="Password"
                    required
                >
                <label for="password">Password</label>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input
                    type="password"
                    class="form-control"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Confirm Password"
                    required
                >
                <label for="password_confirmation">Confirm Password</label>
            </div>

            <button type="submit" class="btn btn-custom w-100">Sign Up</button>

            <div class="extra-actions mt-3">
                <a href="{{ route('login.show') }}">Already have an account?</a>
            </div>
        </form>
    </div>
</div>
@endsection
