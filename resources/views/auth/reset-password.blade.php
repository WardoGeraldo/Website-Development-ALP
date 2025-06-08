@extends('base.base')
@section('hide_header_footer', true)
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<!-- Style nya bisa reuse dari forgot password kamu biar konsisten -->

<div class="password-reset-wrapper">
    <div class="background-effect">
        <div class="luxury-ambience"></div>
        <div class="floating-particles" id="particles"></div>
        <div class="brand-watermark">VERAVIA</div>
    </div>

    <div class="password-reset-container" id="passwordResetContainer">
        <div class="password-reset-form">
            <div class="veravia-logo-small">VERAVIA</div>
            
            <div class="password-reset-header">
                <h2>Reset Your Password</h2>
                <p>Set your new password below</p>
            </div>

            <!-- Tampilkan error -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span>{{ $errors->first() }}</span>
                    <button type="button" class="btn-close" aria-label="Close"
                        onclick="this.parentElement.style.display='none';"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Token wajib dari email link -->
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
</script>

@endsection
