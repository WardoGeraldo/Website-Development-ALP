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
            --accent-color: #6366f1;
            --accent-hover: #4f46e5;
            --accent-light: rgba(99, 102, 241, 0.1);
            --input-bg: #fff;
            --input-border: #e1e5e9;
            --input-focus-border: #6366f1;
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            --gradient-secondary: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(79, 70, 229, 0.1) 100%);
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
            --accent-color: #818cf8;
            --accent-hover: #6366f1;
            --accent-light: rgba(129, 140, 248, 0.2);
            --input-bg: #2a2a2a;
            --input-border: rgba(255, 255, 255, 0.1);
            --input-focus-border: #818cf8;
            --gradient-primary: linear-gradient(135deg, #818cf8 0%, #6366f1 100%);
            --gradient-secondary: linear-gradient(135deg, rgba(129, 140, 248, 0.2) 0%, rgba(99, 102, 241, 0.2) 100%);
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
                radial-gradient(circle at 20% 80%, rgba(99, 102, 241, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(79, 70, 229, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(99, 102, 241, 0.06) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
            transition: all 0.5s ease;
        }

        body.dark-mode::before {
            background:
                radial-gradient(circle at 20% 80%, rgba(129, 140, 248, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(129, 140, 248, 0.08) 0%, transparent 50%);
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
            background: var(--gradient-primary);
            border-radius: 10px;
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

        /* Product Form Container */
        .product-form {
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

        .product-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            z-index: 1;
        }

        body.dark-mode .product-form {
            background: rgba(30, 30, 30, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.3),
                0 1px 0 rgba(255, 255, 255, 0.1) inset;
        }

        .product-form:hover {
            transform: translateY(-8px);
            box-shadow:
                0 32px 64px rgba(99, 102, 241, 0.2),
                0 1px 0 rgba(255, 255, 255, 0.5) inset;
        }

        body.dark-mode .product-form:hover {
            box-shadow:
                0 32px 64px rgba(129, 140, 248, 0.3),
                0 1px 0 rgba(255, 255, 255, 0.1) inset;
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
                0 8px 32px rgba(99, 102, 241, 0.15);
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

        /* Image Grid */
        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 2rem 0;
        }

        .image-card {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 20px;
            position: relative;
        }

        .image-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--card-hover-shadow);
            border-color: var(--accent-color);
        }

        .image-card img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .image-card:hover img {
            transform: scale(1.05);
        }

        .replace-btn {
            background: var(--gradient-primary);
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .replace-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .replace-btn:hover::before {
            left: 100%;
        }

        .replace-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
        }

        /* Stock Grid */
        .stock-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 2rem 0;
        }

        .stock-grid div {
            display: flex;
            flex-direction: column;
        }

        .stock-grid label {
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stock-grid label::before {
            content: '';
            width: 3px;
            height: 12px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        .stock-grid input {
            padding: 12px 16px;
            border-radius: 10px;
            border: 2px solid var(--input-border);
            background-color: var(--input-bg);
            color: var(--text-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Poppins', sans-serif;
        }

        .stock-grid input:focus {
            border-color: var(--input-focus-border);
            outline: none;
            box-shadow: 0 0 0 3px var(--accent-light);
            transform: translateY(-2px);
        }

        /* Buttons */
        .btn-save {
            background: var(--gradient-primary);
            color: #fff;
            border: none;
            padding: 16px 32px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.3);
            width: 100%;
            margin-top: 2rem;
        }

        .btn-save::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-save:hover::before {
            left: 100%;
        }

        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(99, 102, 241, 0.4);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 2rem;
            padding: 12px 24px;
            color: var(--accent-color);
            font-weight: 600;
            text-decoration: none;
            border: 2px solid var(--accent-color);
            border-radius: 25px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: transparent;
        }

        .back-link:hover {
            background: var(--accent-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
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

            .product-form {
                padding: 2rem 1.5rem;
                border-radius: 20px;
            }

            .form-section {
                padding: 1rem;
            }

            .stock-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .store-header h1 {
                font-size: 1.8rem;
            }

            .product-form {
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
            <h1>Edit Product</h1>
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

        <div class="product-form" data-aos="fade-up">

            <!-- Current Images Section -->
            <div class="form-section" data-aos="fade-right" data-aos-delay="200">
                <div class="form-section-title">
                    <i class="bi bi-images"></i>
                    Current Product Images
                </div>

                <div class="image-grid">
                    @foreach ($product['images'] as $image)
                        <div class="image-card" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 + 300 }}">
                            <img src="{{ asset($image['url']) }}" alt="Product Image">
                            <form
                                action="{{ route('admin.product.image.replace', ['id' => $product['id'], 'image_id' => $image['product_image_id']]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="file" name="new_image" accept="image/*" style="display: none;"
                                    onchange="this.form.submit()">
                                <button type="button" class="replace-btn" onclick="this.previousElementSibling.click()">
                                    <i class="bi bi-arrow-repeat"></i> Replace Image
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Product Information Form -->
            <form action="{{ route('admin.product.update', ['id' => $product['id']]) }}" method="POST"
                enctype="multipart/form-data" id="editProductForm">
                @csrf
                @method('PUT')

                <!-- Basic Information Section -->
                <div class="form-section" data-aos="fade-left" data-aos-delay="400">
                    <div class="form-section-title">
                        <i class="bi bi-box"></i>
                        Basic Information
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-tag"></i>
                            Product Name
                        </label>
                        <div class="input-group">
                            <input type="text" id="name" name="name" class="form-control with-icon"
                                value="{{ $product['name'] }}" placeholder="Enter product name..." required>
                            <i class="bi bi-tag input-icon"></i>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-currency-dollar"></i>
                                    Price
                                </label>
                                <div class="input-group">
                                    <input type="number" id="price" name="price" class="form-control with-icon"
                                        value="{{ $product['price'] }}" placeholder="Enter price..." required>
                                    <span class="input-icon"
                                        style="font-weight: bold; color: #555; font-size: 1rem;">Rp</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-list-ul"></i>
                                    Category
                                </label>
                                <select id="category_id" name="category_id" class="form-select" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->category_id }}"
                                            {{ $category->category_id == $product['category_id'] ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-card-text"></i>
                            Description
                        </label>
                        <textarea id="description" name="description" class="form-control" placeholder="Enter product description..."
                            rows="4">{{ $product['description'] ?? '' }}</textarea>
                    </div>
                </div>

                <!-- Stock Management Section -->
                <div class="form-section" data-aos="fade-right" data-aos-delay="600">
                    <div class="form-section-title">
                        <i class="bi bi-boxes"></i>
                        Stock Management
                    </div>

                    <div class="stock-grid">
                        @php
                            $sizes = ['one_size', 'xs', 's', 'm', 'l', 'xxl'];
                        @endphp
                        @foreach ($sizes as $size)
                            <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 + 700 }}">
                                <label for="stock_{{ $size }}">
                                    <i class="bi bi-box"></i>
                                    {{ strtoupper(str_replace('_', ' ', $size)) }}
                                </label>
                                <input type="number" id="stock_{{ $size }}" name="stock[{{ $size }}]"
                                    min="0" value="{{ $product['stock'][$size] ?? 0 }}" required>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn-save" data-aos="zoom-in" data-aos-delay="900">
                    <i class="bi bi-check-circle"></i> Save Changes
                </button>
            </form>

            <a href="{{ route('admin.dashboard') }}" class="back-link" data-aos="fade-up" data-aos-delay="1000">
                <i class="bi bi-arrow-left"></i> Back to Product List
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true
        });

        document.addEventListener('DOMContentLoaded', function() {
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

            // Form submission with loading animation
            document.getElementById('editProductForm').addEventListener('submit', function() {
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
        });

        // Image preview functionality for the existing script
        document.getElementById('images')?.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const currentImage = document.getElementById('currentImage');
            if (file && currentImage) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    currentImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('image')?.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            if (file && preview) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else if (preview) {
                preview.style.display = 'none';
                preview.src = '#';
            }
        });
    </script>

    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                background: 'var(--card-bg)',
                color: 'var(--text-color)'
            });

            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            }).then(function() {
                @if (session('redirect'))
                    window.location.href = "{{ route('admin.dashboard') }}";
                @else
                    window.location.reload();
                @endif
            });
        </script>
    @endif
@endsection
