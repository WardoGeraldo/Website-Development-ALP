@extends('base.base')

@section('content')
    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

        /* Default Dark Theme to match product list */
        :root {
            --bg: #121212;
            --card: #1e1e1e;
            --text: #f3f4f6;
            --text-light: #9ca3af;
            --border: #2d2d2d;
            --accent: #818cf8;
            --accent-hover: #6366f1;
            --hover-bg: rgba(255, 255, 255, 0.05);
        }

        /* Light Mode Variables (if needed) */
        body.light-mode {
            --bg: #f8f9fa;
            --card: #ffffff;
            --text: #212529;
            --text-light: #6c757d;
            --border: #dee2e6;
            --accent: #6366f1;
            --accent-hover: #4f46e5;
            --hover-bg: rgba(0, 0, 0, 0.05);
        }

        /* Set body background to match */
        body {
            background-color: var(--bg) !important;
            color: var(--text) !important;
            margin: 0;
            font-family: 'Inter', sans-serif;
        }

        /* Container Styles */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--bg);
            color: var(--text);
            transition: background-color 0.3s ease, color 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        /* Header Styles */
        .store-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .store-header h1 {
            font-size: 2rem;
            font-weight: 600;
            color: var(--text);
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

        /* Form Container */
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background: var(--card);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            font-size: 1rem;
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
        }

        body.dark-mode .form-container {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        body.light-mode .form-container {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 8px;
            transition: color 0.3s ease;
        }

        .form-group input,
        .form-group textarea {
            padding: 12px 16px;
            font-size: 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
            background-color: var(--card);
            color: var(--text);
            font-family: 'Inter', sans-serif;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: var(--text-light);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-control {
            background-color: var(--card) !important;
            color: var(--text) !important;
            border-color: var(--border) !important;
        }

        .form-control:focus {
            background-color: var(--card) !important;
            color: var(--text) !important;
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
        }

        body.dark-mode .form-control {
            background-color: var(--card) !important;
            color: var(--text) !important;
            border-color: var(--border) !important;
        }

        body.dark-mode .form-control:focus {
            background-color: var(--card) !important;
            color: var(--text) !important;
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.1) !important;
        }

        body.light-mode .form-control {
            background-color: var(--card) !important;
            color: var(--text) !important;
            border-color: var(--border) !important;
        }

        body.light-mode .form-control:focus {
            background-color: var(--card) !important;
            color: var(--text) !important;
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
        }

        .image-preview {
            max-width: 100%;
            max-height: 200px;
            object-fit: cover;
            margin-top: 15px;
            border-radius: 8px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        body.dark-mode .image-preview {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        body.light-mode .image-preview {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-submit {
            padding: 12px 24px;
            background-color: var(--accent);
            color: white;
            font-weight: 500;
            border-radius: 8px;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-family: 'Inter', sans-serif;
        }

        .btn-submit:hover {
            background-color: var(--accent-hover);
            transform: translateY(-1px);
        }

        /* Alert Styles */
        .alert {
            padding: 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background-color: var(--card);
            color: var(--text);
        }

        .alert-success {
            background-color: #d1fae5;
            border-color: #10b981;
            color: #065f46;
        }

        body.dark-mode .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border-color: #10b981;
            color: #6ee7b7;
        }

        body.light-mode .alert-success {
            background-color: #d1fae5;
            border-color: #10b981;
            color: #065f46;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .store-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .form-container {
                padding: 20px;
                margin: 0 1rem;
            }

            .store-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>

    <div class="container">
        <div class="store-header">
            <h1>Add New Product</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            <script>
                alert('{{ session('success') }}');
                setTimeout(function() {
                    window.location.href = "{{ route('admin.dashboard') }}";
                }, 1500);
            </script>
        @endif

        <div class="form-container">
            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" id="price" class="form-control" placeholder="" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" name="category" id="category" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                    <img id="imagePreview" class="image-preview" src="#" alt="Image Preview" style="display: none;">
                </div>

                <button type="submit" class="btn-submit">Add Product</button>
            </form>
        </div>
    </div>

    <script>
        AOS.init();

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
    </script>
@endsection