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

        .dark-mode-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 50px;
            cursor: pointer;
            z-index: 999;
            font-size: 1.2rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 32px rgba(137, 108, 255, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark-mode-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(137, 108, 255, 0.4);
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .store-header {
            text-align: center;
            margin-top: 60px;
            margin-bottom: 3rem;
            position: relative;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient-primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 32px rgba(137, 108, 255, 0.3);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .store-header h1 {
            font-weight: 700;
            font-size: 2.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            position: relative;
        }

        .store-header h1::after {
            content: "";
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--gradient-primary);
            border-radius: 10px;
        }

        .user-details {
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

        .user-details::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            z-index: 1;
        }

        body.dark-mode .user-details {
            background: rgba(30, 30, 30, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.3),
                0 1px 0 rgba(255, 255, 255, 0.1) inset;
        }

        .user-details:hover {
            transform: translateY(-8px);
            box-shadow:
                0 32px 64px rgba(137, 108, 255, 0.2),
                0 1px 0 rgba(255, 255, 255, 0.5) inset;
        }

        body.dark-mode .user-details:hover {
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

        .btn-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            z-index: 1;
        }

        .btn-back {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
            padding: 16px 32px;
            border: 2px solid rgba(239, 68, 68, 0.2);
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            backdrop-filter: blur(10px);
            cursor: pointer;
        }

        .btn-back:hover {
            background: var(--danger-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(239, 68, 68, 0.3);
            border-color: var(--danger-color);
        }

        body.dark-mode .btn-back {
            background: rgba(239, 68, 68, 0.15);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
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
                margin-top: 40px;
                margin-bottom: 2rem;
            }

            .header-content {
                flex-direction: column;
            }

            .header-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }

            .store-header h1 {
                font-size: 2rem;
            }

            .user-details {
                padding: 2rem 1.5rem;
                border-radius: 20px;
            }

            .button-group {
                flex-direction: column-reverse;
                gap: 1rem;
            }

            .btn-primary,
            .btn-back {
                width: 100%;
                justify-content: center;
            }

            .form-section {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .store-header h1 {
                font-size: 1.8rem;
            }

            .user-details {
                padding: 1.5rem 1rem;
            }

            .header-icon {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }
        }

        /* Smooth Theme Transitions */
        * {
            transition: background-color 0.5s ease, color 0.5s ease, border-color 0.5s ease;
        }
    </style>

    <!-- Dark Mode Toggle -->
    <button class="dark-mode-toggle" id="darkModeToggle">🌙</button>

    <div class="container">
        <div class="store-header" data-aos="fade-down">
            <div class="header-content">
                <div class="header-icon">
                    <i class="bi bi-person-gear"></i>
                </div>
                <h1>Edit User</h1>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner"></div>
        </div>

        <form action="{{ route('admin.user.update', ['id' => $user->user_id]) }}" method="POST" class="user-details"
            data-aos="fade-up" id="editUserForm">
            @csrf

            <!-- Personal Information Section -->
            <div class="form-section" data-aos="fade-right" data-aos-delay="200">
                <div class="form-section-title">
                    <i class="bi bi-person"></i>
                    Personal Information
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-person-badge"></i>
                        Full Name
                    </label>
                    <div class="input-group">
                        <input type="text" name="name" class="form-control with-icon" value="{{ $user->name }}"
                            placeholder="Enter full name..." required>
                        <i class="bi bi-person input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-envelope"></i>
                        Email Address
                    </label>
                    <div class="input-group">
                        <input type="email" name="email" class="form-control with-icon" value="{{ $user->email }}"
                            placeholder="Enter email address...">
                        <i class="bi bi-envelope input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-telephone"></i>
                        Phone Number
                    </label>
                    <div class="input-group">
                        <input type="text" name="phone" class="form-control with-icon"
                            value="{{ $user->phone_number }}" placeholder="Enter phone number...">
                        <i class="bi bi-telephone input-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Personal Details Section -->
            <div class="form-section" data-aos="fade-left" data-aos-delay="400">
                <div class="form-section-title">
                    <i class="bi bi-info-circle"></i>
                    Personal Details
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-geo-alt"></i>
                        Address
                    </label>
                    <div class="input-group">
                        <input type="text" name="address" class="form-control with-icon" value="{{ $user->address }}"
                            placeholder="Enter address...">
                        <i class="bi bi-geo-alt input-icon"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-gender-ambiguous"></i>
                                Gender
                            </label>
                            <select name="gender" class="form-select">
                                <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-calendar-date"></i>
                                Date of Birth
                            </label>
                            <input type="date" name="dob" class="form-control" value="{{ $user->birthdate }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Settings Section -->
            <div class="form-section" data-aos="fade-up" data-aos-delay="600">
                <div class="form-section-title">
                    <i class="bi bi-gear"></i>
                    Account Settings
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-shield-check"></i>
                        User Role
                    </label>
                    <select name="role" class="form-select">
                        <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
            </div>

            <div class="button-group" data-aos="zoom-in" data-aos-delay="800">
                <button type="button" onclick="window.history.back()" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i>
                    Back
                </button>
                <button type="submit" class="btn btn-primary">
                    <span class="btn-content">
                        <i class="bi bi-check-circle"></i>
                        Update User
                    </span>
                </button>
            </div>
        </form>
    </div>

    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true
        });

        document.addEventListener('DOMContentLoaded', function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            const body = document.body;
            const toggle = document.getElementById('darkModeToggle');

            if (isDarkMode) {
                body.classList.add('dark-mode');
                toggle.textContent = '☀️';
            }

            toggle.addEventListener('click', () => {
                body.classList.toggle('dark-mode');
                const isDark = body.classList.contains('dark-mode');
                localStorage.setItem('darkMode', isDark);
                toggle.textContent = isDark ? '☀️' : '🌙';
            });

            // Form submission with loading animation
            document.getElementById('editUserForm').addEventListener('submit', function() {
                document.getElementById('loadingOverlay').style.display = 'flex';
            });

            // Enhanced form validation feedback
            const inputs = document.querySelectorAll('.form-control, .form-select');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.checkValidity()) {
                        this.style.borderColor = 'var(--success-color)';
                    } else {
                        this.style.borderColor = 'var(--danger-color)';
                    }
                });

                input.addEventListener('focus', function() {
                    this.style.borderColor = 'var(--input-focus-border)';
                });
            });

            // Phone number formatting
            const phoneInput = document.querySelector('input[name="phone"]');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        value = value.replace(/(\d{4})(\d{4})(\d{4})/, '$1-$2-$3');
                    }
                    e.target.value = value;
                });
            }
        });
    </script>
@endsection
