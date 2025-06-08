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

        /* Fixed Header Styles - Now matches product list */
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
                0 32px 64px rgba(137, 108, 255, 0.2),
                0 1px 0 rgba(255, 255, 255, 0.5) inset;
        }

        body.dark-mode .product-form:hover {
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

        .form-control.with-icon:focus + .input-icon {
            color: var(--accent-color);
        }

        /* File Upload Styling */
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            border: 2px dashed var(--input-border);
            padding: 40px 20px;
            text-align: center;
            border-radius: 16px;
            background: var(--gradient-secondary);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .file-input-wrapper:hover {
            border-color: var(--accent-color);
            background: var(--accent-light);
            transform: translateY(-2px);
        }

        .file-input-wrapper input[type="file"] {
            opacity: 0;
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            cursor: pointer;
        }

        .file-upload-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .file-upload-icon {
            width: 48px;
            height: 48px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 16px rgba(137, 108, 255, 0.3);
        }

        .file-upload-text {
            font-weight: 600;
            color: var(--text-color);
            font-size: 1.1rem;
        }

        .file-upload-subtext {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        #imagePreviewContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px;
            margin-top: 20px;
            padding: 20px;
            background: var(--gradient-secondary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
        }

        #imagePreviewContainer img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 3px solid var(--card-bg);
        }

        #imagePreviewContainer img:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 32px rgba(137, 108, 255, 0.2);
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
            width: 100%;
            margin-top: 2rem;
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

            #imagePreviewContainer img {
                width: 100px;
                height: 100px;
            }
        }

        @media (max-width: 480px) {
            .store-header h1 {
                font-size: 1.8rem;
            }

            .product-form {
                padding: 1.5rem 1rem;
            }

            #imagePreviewContainer img {
                width: 80px;
                height: 80px;
            }
        }

        /* Smooth Theme Transitions */
        * {
            transition: background-color 0.5s ease, color 0.5s ease, border-color 0.5s ease;
        }
    </style>

    <div class="container">
        <div class="store-header" data-aos="fade-down">
            <h1>Add New Product</h1>
            <div class="header-controls">
                <div class="date-display">
                    <span id="current-date"></span>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner"></div>
        </div>

        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" class="product-form"
            data-aos="fade-up" id="productForm">
            @csrf
            
            <!-- Basic Information Section -->
            <div class="form-section" data-aos="fade-right" data-aos-delay="200">
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
                        <input type="text" name="name" id="name" class="form-control with-icon" 
                            placeholder="Enter product name..." required>
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
                                <input type="number" name="price" id="price" class="form-control with-icon" 
                                    placeholder="Enter price..." required>
                                <i class="bi bi-currency-dollar input-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="bi bi-list-ul"></i>
                                Category
                            </label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="" disabled selected>-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->name }}</option>
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
                    <textarea name="description" id="description" class="form-control" 
                        placeholder="Enter product description..." rows="4"></textarea>
                </div>
            </div>

            <!-- Product Images Section -->
            <div class="form-section" data-aos="fade-left" data-aos-delay="400">
                <div class="form-section-title">
                    <i class="bi bi-images"></i>
                    Product Images
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-camera"></i>
                        Upload Images (Max 4)
                    </label>
                    <div class="file-input-wrapper">
                        <div class="file-upload-content">
                            <div class="file-upload-icon">
                                <i class="bi bi-cloud-upload"></i>
                            </div>
                            <div class="file-upload-text">Click here to upload images</div>
                            <div class="file-upload-subtext">PNG, JPG, JPEG • Maximum 4 images</div>
                        </div>
                        <input type="file" name="images[]" id="images" accept="image/*" multiple required>
                    </div>
                    <div id="imagePreviewContainer"></div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" data-aos="zoom-in" data-aos-delay="600">
                <span class="btn-content">
                    <i class="bi bi-plus-circle"></i>
                    Add Product
                </span>
            </button>
        </form>
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
            document.getElementById('productForm').addEventListener('submit', function() {
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

        const fileInput = document.getElementById('images');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const fileInputWrapper = document.querySelector('.file-input-wrapper');
        const maxFiles = 4;

        function showPreviews(files) {
            previewContainer.innerHTML = '';

            if (files.length > maxFiles) {
                Swal.fire({
                    icon: 'error',
                    title: 'Too Many Files!',
                    text: `You can only upload up to ${maxFiles} images.`,
                    confirmButtonColor: '#5a3fd9',
                    background: 'var(--card-bg)',
                    color: 'var(--text-color)'
                });
                fileInput.value = '';
                return;
            }

            if (files.length > 0) {
                previewContainer.style.display = 'flex';
            }

            Array.from(files).forEach(file => {
                if (!file.type.startsWith('image/')) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }

        fileInput.addEventListener('change', function(event) {
            showPreviews(event.target.files);
        });

        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileInputWrapper.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        fileInputWrapper.addEventListener('dragenter', () => {
            fileInputWrapper.style.borderColor = 'var(--accent-color)';
            fileInputWrapper.style.background = 'var(--accent-light)';
            fileInputWrapper.style.transform = 'translateY(-2px)';
        });

        fileInputWrapper.addEventListener('dragleave', () => {
            fileInputWrapper.style.borderColor = 'var(--input-border)';
            fileInputWrapper.style.background = 'var(--gradient-secondary)';
            fileInputWrapper.style.transform = 'translateY(0)';
        });

        fileInputWrapper.addEventListener('dragover', () => {
            fileInputWrapper.style.borderColor = 'var(--accent-color)';
            fileInputWrapper.style.background = 'var(--accent-light)';
        });

        fileInputWrapper.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;

            fileInputWrapper.style.borderColor = 'var(--input-border)';
            fileInputWrapper.style.background = 'var(--gradient-secondary)';
            fileInputWrapper.style.transform = 'translateY(0)';

            showPreviews(files);
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
            });.
        </script>
    @endif
@endsection