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
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: all 0.5s ease;
        }

        /* Container Styles - matching users list page */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: all 0.5s ease;
        }

        /* Header Styles - matching users list page */
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

        /* Form Container - matching users list page card style */
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
            font-size: 1rem;
            transition: all 0.5s ease;
        }

        .form-container:hover {
            box-shadow: var(--card-hover-shadow);
            border-color: rgba(137, 108, 255, 0.2);
        }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 8px;
            transition: all 0.5s ease;
        }

        .form-group input,
        .form-group textarea {
            padding: 12px 16px;
            font-size: 1rem;
            border: 2px solid var(--input-border);
            border-radius: 8px;
            transition: all 0.3s ease;
            background-color: var(--input-bg);
            color: var(--text-color);
            font-family: 'Poppins', sans-serif;
            width: 100%;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--input-focus-border);
            outline: none;
            box-shadow: 0 0 0 3px var(--accent-light);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: var(--text-secondary);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Bootstrap form control overrides - ensuring visibility */
        .form-control {
            background-color: var(--input-bg) !important;
            color: var(--text-color) !important;
            border: 2px solid var(--input-border) !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
        }

        .form-control:focus {
            background-color: var(--input-bg) !important;
            color: var(--text-color) !important;
            border-color: var(--input-focus-border) !important;
            box-shadow: 0 0 0 3px var(--accent-light) !important;
        }

        .form-control::placeholder {
            color: var(--text-secondary) !important;
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
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
        }

        .btn-submit {
            padding: 12px 24px;
            background-color: var(--accent-color);
            color: white;
            font-weight: 500;
            border-radius: 50px;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .btn-submit:hover {
            background-color: #5A3FD9;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(137, 108, 255, 0.3);
        }

        /* Alert Styles - matching users list page */
        .alert {
            padding: 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            transition: all 0.5s ease;
        }

        .alert-success {
            background-color: #d1fae5;
            border-color: #10b981;
            color: #065f46;
        }

        body.dark-mode .alert-success {
            background-color: rgba(16, 185, 129, 0.15);
            border-color: #10b981;
            color: #6ee7b7;
        }

        /* Smooth Theme Transitions */
        * {
            transition: background-color 0.5s ease, color 0.5s ease, border-color 0.5s ease;
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