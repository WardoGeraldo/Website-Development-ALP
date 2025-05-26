@extends('base.base')

@section('content')
    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        /* Light Mode Variables (Default) - matching users list page */
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
        }

        /* Dark Mode Variables - matching users list page */
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

        /* Container Styles - matching users list page */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            background-color: transparent;
            color: var(--text-color);
            transition: all 0.5s ease;
            position: relative;
            z-index: 1;
        }

        /* Header Styles - Enhanced with gradient and icons */
        .store-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
            padding: 2rem 0;
            border-bottom: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }

        .store-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-secondary);
            opacity: 0.5;
            border-radius: 16px;
            z-index: -1;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 2;
            position: relative;
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
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .store-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-color);
            position: relative;
            margin: 0;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .store-header h1::after {
            content: "";
            position: absolute;
            bottom: -12px;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--gradient-primary);
            border-radius: 10px;
        }

        /* Form Container - Enhanced with glassmorphism effect */
        .form-container {
            max-width: 700px;
            margin: 0 auto;
            padding: 3rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 1px 0 rgba(255, 255, 255, 0.5) inset;
            font-size: 1rem;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        body.dark-mode .form-container {
            background: rgba(30, 30, 30, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.3),
                0 1px 0 rgba(255, 255, 255, 0.1) inset;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            z-index: 1;
        }

        .form-container:hover {
            transform: translateY(-8px);
            box-shadow: 
                0 32px 64px rgba(137, 108, 255, 0.2),
                0 1px 0 rgba(255, 255, 255, 0.5) inset;
        }

        body.dark-mode .form-container:hover {
            box-shadow: 
                0 32px 64px rgba(165, 139, 255, 0.3),
                0 1px 0 rgba(255, 255, 255, 0.1) inset;
        }

        .form-group {
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .form-group label {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 12px;
            transition: all 0.5s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group label::before {
            content: '';
            width: 4px;
            height: 16px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-group input,
        .form-group textarea {
            padding: 16px 20px;
            font-size: 1rem;
            border: 2px solid var(--input-border);
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: var(--input-bg);
            color: var(--text-color);
            font-family: 'Poppins', sans-serif;
            width: 100%;
            position: relative;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--input-focus-border);
            outline: none;
            box-shadow: 
                0 0 0 4px var(--accent-light),
                0 8px 32px rgba(137, 108, 255, 0.15);
            transform: translateY(-2px);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }

        .form-group input:focus::placeholder,
        .form-group textarea:focus::placeholder {
            transform: translateX(8px);
            opacity: 0.8;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 140px;
        }

        /* Bootstrap form control overrides - ensuring visibility */
        .form-control {
            background-color: var(--input-bg) !important;
            color: var(--text-color) !important;
            border: 2px solid var(--input-border) !important;
            border-radius: 12px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            padding: 16px 20px !important;
        }

        .form-control:focus {
            background-color: var(--input-bg) !important;
            color: var(--text-color) !important;
            border-color: var(--input-focus-border) !important;
            box-shadow: 
                0 0 0 4px var(--accent-light),
                0 8px 32px rgba(137, 108, 255, 0.15) !important;
            transform: translateY(-2px) !important;
        }

        .form-control::placeholder {
            color: var(--text-secondary) !important;
        }

        /* File input special styling */
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            border: 2px dashed var(--input-border);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            background: var(--gradient-secondary);
        }

        .file-input-wrapper:hover {
            border-color: var(--accent-color);
            background: var(--accent-light);
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            left: -9999px;
            opacity: 0;
        }

        .file-input-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            cursor: pointer;
            color: var(--text-color);
            font-weight: 500;
        }

        .file-input-icon {
            width: 48px;
            height: 48px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .image-preview {
            max-width: 100%;
            max-height: 250px;
            object-fit: cover;
            margin-top: 20px;
            border-radius: 16px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.1);
            border: 3px solid var(--accent-color);
            transition: all 0.3s ease;
        }

        .image-preview:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 50px rgba(137, 108, 255, 0.2);
        }

        .btn-submit {
            padding: 16px 32px;
            background: var(--gradient-primary);
            color: white;
            font-weight: 600;
            border-radius: 50px;
            border: none;
            font-size: 1.1rem;
            cursor: pointer;
            width: 100%;
            margin-top: 2rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(137, 108, 255, 0.3);
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(137, 108, 255, 0.4);
        }

        .btn-submit:active {
            transform: translateY(-1px);
        }

        .btn-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            z-index: 1;
        }

        /* Alert Styles - Enhanced with better visual feedback */
        .alert {
            padding: 20px 24px;
            margin-bottom: 2rem;
            border-radius: 12px;
            border: none;
            background: rgba(16, 185, 129, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #10b981;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #065f46;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        body.dark-mode .alert-success {
            background: rgba(16, 185, 129, 0.15);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Smooth Theme Transitions */
        * {
            transition: background-color 0.5s ease, color 0.5s ease, border-color 0.5s ease;
        }

        /* Enhanced Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .store-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                padding: 1.5rem 0;
            }

            .header-content {
                width: 100%;
                justify-content: center;
            }

            .header-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }

            .form-container {
                padding: 2rem 1.5rem;
                margin: 0 0.5rem;
                border-radius: 20px;
            }

            .store-header h1 {
                font-size: 2rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-group input,
            .form-group textarea {
                padding: 14px 16px;
            }

            .file-input-wrapper {
                padding: 1.5rem;
            }

            .btn-submit {
                padding: 14px 28px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .store-header h1 {
                font-size: 1.8rem;
            }

            .form-container {
                padding: 1.5rem 1rem;
            }

            .header-icon {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }
        }
    </style>

    <div class="container" data-aos="fade-up">
        <div class="store-header" data-aos="fade-down">
            <div class="header-content">
                <div class="header-icon">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <h1>Add New Product</h1>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" data-aos="zoom-in">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
            <script>
                alert('{{ session('success') }}');
                setTimeout(function() {
                    window.location.href = "{{ route('admin.dashboard') }}";
                }, 1500);
            </script>
        @endif

        <div class="form-container" data-aos="fade-up" data-aos-delay="200">
            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf

                <div class="form-group" data-aos="fade-right" data-aos-delay="300">
                    <label for="name">
                        <i class="bi bi-tag"></i>
                        Product Name
                    </label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name..." required>
                    </div>
                </div>

                <div class="form-group" data-aos="fade-left" data-aos-delay="400">
                    <label for="price">
                        <i class="bi bi-currency-dollar"></i>
                        Price
                    </label>
                    <div class="input-wrapper">
                        <input type="text" name="price" id="price" class="form-control" placeholder="Enter price..." required>
                    </div>
                </div>

                <div class="form-group" data-aos="fade-right" data-aos-delay="500">
                    <label for="category">
                        <i class="bi bi-grid"></i>
                        Category
                    </label>
                    <div class="input-wrapper">
                        <input type="text" name="category" id="category" class="form-control" placeholder="Enter category..." required>
                    </div>
                </div>

                <div class="form-group" data-aos="fade-left" data-aos-delay="600">
                    <label for="description">
                        <i class="bi bi-text-paragraph"></i>
                        Description
                    </label>
                    <div class="input-wrapper">
                        <textarea name="description" id="description" class="form-control" placeholder="Enter product description..."></textarea>
                    </div>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="700">
                    <label for="image">
                        <i class="bi bi-image"></i>
                        Product Image
                    </label>
                    <div class="file-input-wrapper">
                        <input type="file" name="image" id="image" accept="image/*" required>
                        <label for="image" class="file-input-label">
                            <div class="file-input-icon">
                                <i class="bi bi-cloud-upload"></i>
                            </div>
                            <span>Click to upload image or drag and drop</span>
                            <small>PNG, JPG, GIF up to 10MB</small>
                        </label>
                    </div>
                    <img id="imagePreview" class="image-preview" src="#" alt="Image Preview" style="display: none;">
                </div>

                <button type="submit" class="btn-submit" data-aos="zoom-in" data-aos-delay="800">
                    <span class="btn-content">
                        <i class="bi bi-plus-circle"></i>
                        Add Product
                    </span>
                </button>
            </form>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true
        });

        // Image Preview Script
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Format price input with commas
        document.getElementById('price').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            e.target.value = `Rp ${value}`;
        });

        // Form submission with loading animation
        document.getElementById('productForm').addEventListener('submit', function() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        });

        // Enhanced file drop functionality
        const fileWrapper = document.querySelector('.file-input-wrapper');
        const fileInput = document.getElementById('image');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileWrapper.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            fileWrapper.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileWrapper.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            fileWrapper.style.borderColor = 'var(--accent-color)';
            fileWrapper.style.background = 'var(--accent-light)';
        }

        function unhighlight(e) {
            fileWrapper.style.borderColor = 'var(--input-border)';
            fileWrapper.style.background = 'var(--gradient-secondary)';
        }

        fileWrapper.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            
            // Trigger change event
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }
    </script>
@endsection