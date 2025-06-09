@extends('base.base')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        /* CSS Variables for theme consistency */
        :root {
            --bg-color: #F8F9FD;
            --text-color: #333;
            --text-secondary: #777;
            --border-color: rgba(0, 0, 0, 0.05);
            --card-bg: #fff;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            --card-hover-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            --accent-color: #896CFF;
            --accent-light: rgba(137, 108, 255, 0.1);
            --input-bg: #fff;
            --input-border: #e1e5e9;
            --input-focus-border: #896CFF;
            --gradient-primary: linear-gradient(135deg, #896CFF 0%, #5A3FD9 100%);
            --gradient-secondary: linear-gradient(135deg, rgba(137, 108, 255, 0.1) 0%, rgba(90, 63, 217, 0.1) 100%);
            --success-color: #10b981;
            --danger-color: #ef4444;
        }

        body.dark-mode {
            --bg-color: #121212;
            --text-color: #f1f1f1;
            --text-secondary: #c5c5c5;
            --border-color: rgba(255, 255, 255, 0.1);
            --card-bg: #1e1e1e;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            --card-hover-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            --accent-color: #a58bff;
            --accent-light: rgba(137, 108, 255, 0.2);
            --input-bg: #2a2a2a;
            --input-border: rgba(255, 255, 255, 0.1);
            --input-focus-border: #a58bff;
            --gradient-primary: linear-gradient(135deg, #a58bff 0%, #7c6bff 100%);
            --gradient-secondary: linear-gradient(135deg, rgba(165, 139, 255, 0.2) 0%, rgba(124, 107, 255, 0.2) 100%);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
            transition: all 0.5s ease;
            min-height: 100vh;
            position: relative;
        }

        /* Animated Background Elements */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(137, 108, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(90, 63, 217, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(137, 108, 255, 0.06) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
            transition: all 0.5s ease;
        }

        body.dark-mode::before {
            background:
                radial-gradient(circle at 20% 80%, rgba(165, 139, 255, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(124, 107, 255, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(165, 139, 255, 0.08) 0%, transparent 50%);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        /* Header Styles */
        .store-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .store-header h1 {
            font-size: 2rem;
            font-weight: 600;
            color: var(--text-color);
            position: relative;
            margin: 0;
        }

        .store-header h1::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #896CFF, #5A3FD9);
            border-radius: 10px;
        }

        .store-header p {
            color: var(--text-secondary);
            margin: 0.5rem 0 0 0;
            font-size: 1rem;
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .date-display {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: var(--text-secondary);
            gap: 0.5rem;
        }

        .promo-form {
            padding: 3rem;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 1px 0 rgba(255, 255, 255, 0.5) inset;
            margin-bottom: 40px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .promo-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            z-index: 1;
        }

        body.dark-mode .promo-form {
            background: rgba(30, 30, 30, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.3),
                0 1px 0 rgba(255, 255, 255, 0.1) inset;
        }

        .promo-form:hover {
            transform: translateY(-8px);
            box-shadow:
                0 32px 64px rgba(137, 108, 255, 0.2),
                0 1px 0 rgba(255, 255, 255, 0.5) inset;
        }

        body.dark-mode .promo-form:hover {
            box-shadow:
                0 32px 64px rgba(165, 139, 255, 0.3),
                0 1px 0 rgba(255, 255, 255, 0.1) inset;
        }

        .form-group {
            margin-bottom: 2rem;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 12px;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
            transition: all 0.5s ease;
        }

        .form-label::before {
            content: '';
            width: 4px;
            height: 16px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        .required-asterisk {
            color: var(--danger-color);
            margin-left: 4px;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 16px 20px;
            border: 2px solid var(--input-border);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: var(--input-bg);
            color: var(--text-color);
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--input-focus-border);
            outline: none;
            box-shadow:
                0 0 0 4px var(--accent-light),
                0 8px 32px rgba(137, 108, 255, 0.15);
            transform: translateY(-2px);
            background-color: var(--input-bg);
            color: var(--text-color);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }

        .form-control:focus::placeholder {
            transform: translateX(8px);
            opacity: 0.8;
        }

        /* Input Icons */
        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .form-control.with-icon {
            padding-left: 48px;
        }

        .form-control.with-icon:focus+.input-icon {
            color: var(--accent-color);
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: var(--gradient-secondary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
        }

        .form-section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--accent-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Button Styling */
        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            padding: 16px 32px;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(137, 108, 255, 0.3);
            flex: 1;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            background: var(--gradient-primary);
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(137, 108, 255, 0.4);
        }

        .btn-back {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            border: none;
            padding: 16px 32px;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(107, 114, 128, 0.3);
            flex: 0 0 auto;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(239, 68, 68, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            z-index: 1;
        }

        /* Error Message Styling */
        .error-message {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 500;
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        body.dark-mode .loading-overlay {
            background: rgba(0, 0, 0, 0.9);
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid var(--accent-light);
            border-top: 4px solid var(--accent-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .store-header {
                margin-bottom: 2rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .header-controls {
                width: 100%;
                justify-content: space-between;
            }

            .store-header h1 {
                font-size: 2rem;
            }

            .promo-form {
                padding: 2rem 1.5rem;
                border-radius: 20px;
            }

            .form-section {
                padding: 1rem;
            }

            .btn-container {
                flex-direction: column-reverse;
                gap: 1rem;
            }

            .btn-primary,
            .btn-back {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .store-header h1 {
                font-size: 1.8rem;
            }

            .promo-form {
                padding: 1.5rem 1rem;
            }
        }

        /* Smooth Theme Transitions */
        * {
            transition: background-color 0.5s ease, color 0.5s ease, border-color 0.5s ease;
        }
    </style>

    <div class="container">
        <div class="store-header" data-aos="fade-down">
            <div>
                <h1>Add New Promo</h1>
                <p>Create a new promo code to boost your sales.</p>
            </div>
            <div class="header-controls">
                <div class="date-display">
                    <i class="bi bi-calendar3"></i>
                    <span id="current-date"></span>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner"></div>
        </div>

        <form action="{{ route('admin.promo.store') }}" method="POST" class="promo-form" data-aos="fade-up" id="promoForm">
            @csrf

            <!-- Promo Details Section -->
            <div class="form-section" data-aos="fade-right" data-aos-delay="200">
                <div class="form-section-title">
                    <i class="bi bi-tags"></i>
                    Promo Details
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-tag"></i>
                                Promo Code
                                <span class="required-asterisk">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" name="promo_code" class="form-control with-icon"
                                    value="{{ old('promo_code') }}" required maxlength="20"
                                    placeholder="Enter promo code...">
                                <i class="bi bi-tag input-icon"></i>
                            </div>
                            @error('promo_code')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-percent"></i>
                                Discount (%)
                                <span class="required-asterisk">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" name="discount" class="form-control with-icon"
                                    value="{{ old('discount') }}" required min="1" max="100"
                                    placeholder="e.g. 20">
                                <i class="bi bi-percent input-icon"></i>
                            </div>
                            @error('discount')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promo Schedule Section -->
            <div class="form-section" data-aos="fade-left" data-aos-delay="400">
                <div class="form-section-title">
                    <i class="bi bi-calendar-range"></i>
                    Promo Schedule
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-calendar-plus"></i>
                                Start Date
                                <span class="required-asterisk">*</span>
                            </label>
                            <div class="input-group">
                                <input type="date" name="start_date" class="form-control with-icon"
                                    value="{{ old('start_date') ?? date('Y-m-d') }}" required>
                                <i class="bi bi-calendar-plus input-icon"></i>
                            </div>
                            @error('start_date')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-calendar-x"></i>
                                End Date
                                <span class="required-asterisk">*</span>
                            </label>
                            <div class="input-group">
                                <input type="date" name="end_date" class="form-control with-icon"
                                    value="{{ old('end_date') ?? date('Y-m-d', strtotime('+1 month')) }}" required>
                                <i class="bi bi-calendar-x input-icon"></i>
                            </div>
                            @error('end_date')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn-container" data-aos="zoom-in" data-aos-delay="600">
                <button type="submit" class="btn btn-primary">
                    <span class="btn-content">
                        <i class="bi bi-plus-circle"></i>
                        Create Promo
                    </span>
                </button>
                <button type="button" onclick="window.history.back()" class="btn btn-back">
                    <span class="btn-content">
                        <i class="bi bi-arrow-left"></i>
                        Back
                    </span>
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS Animation
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true
            });

            // Set current date
            const dateElement = document.getElementById('current-date');
            if (dateElement) {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                dateElement.textContent = now.toLocaleDateString('en-US', options);
            }

            // Handle form submission with SweetAlert confirmation
            const promoForm = document.getElementById('promoForm');
            const loadingOverlay = document.getElementById('loadingOverlay');

            promoForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                Swal.fire({
                    title: 'Create Promo?',
                    text: 'Are you sure you want to create this promo?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, create it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        loadingOverlay.style.display = 'flex'; // Show loading overlay
                        promoForm.submit(); // Submit form after confirmation
                    }
                });
            });

            // Enhanced form validation feedback
            const inputs = document.querySelectorAll('.form-control, .form-select');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    this.style.borderColor = this.checkValidity() ? 'var(--success-color)' :
                        'var(--danger-color)';
                });
                input.addEventListener('focus', function() {
                    this.style.borderColor = 'var(--input-focus-border)';
                });
            });

            // Validate dates
            const startDateInput = document.querySelector('input[name="start_date"]');
            const endDateInput = document.querySelector('input[name="end_date"]');

            function validateDates() {
                if (startDateInput.value && endDateInput.value) {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);
                    if (startDate >= endDate) {
                        endDateInput.setCustomValidity('End date must be after start date');
                    } else {
                        endDateInput.setCustomValidity('');
                    }
                }
            }

            startDateInput.addEventListener('change', validateDates);
            endDateInput.addEventListener('change', validateDates);
        });
    </script>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Validation Error',
                    html: '{!! implode('<br>', $errors->all()) !!}',
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif


    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: 'var(--card-bg)',
                    color: 'var(--text-color)',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                }).then(() => {
                    window.location.href = "{{ route('admin.promo.list') }}"; // Redirect after toast
                });
            });
        </script>
    @endif
@endsection
