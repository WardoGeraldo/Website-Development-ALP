@extends('base.base')

@section('content')
    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <style>
        /* Removed body and dark-mode styles here, rely on base.base */

        /* Form Container */
        .form-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-size: 1rem;
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
        }

        body.dark-mode .form-container {
            background-color: #222;
            color: #f5f5f5;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
            border-color: #555;
        }

        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        body.dark-mode .form-control {
            background-color: #333 !important;
            color: #ddd !important;
            border-color: #555 !important;
        }

        body.dark-mode .form-control:focus {
            background-color: #333 !important;
            color: #ddd !important;
            border-color: #e76767 !important;
            box-shadow: none !important;
        }

        .form-group label {
            font-size: 1rem;
            font-weight: 500;
            color: #444;
            margin-bottom: 5px;
            transition: color 0.3s ease;
        }

        body.dark-mode .form-group label {
            color: #ddd;
        }

        .form-group input,
        .form-group textarea {
            padding: 0.75rem;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
            background-color: #fff;
            color: #333;
        }

        body.dark-mode .form-group input,
        body.dark-mode .form-group textarea {
            background-color: #333;
            border-color: #555;
            color: #ddd;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #007bff;
            outline: none;
            transition: border-color 0.3s ease;
        }

        body.dark-mode .form-group input:focus,
        body.dark-mode .form-group textarea:focus {
            border-color: #e76767;
            outline: none;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
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
        }

        .btn-submit {
            padding: 1rem 2rem;
            background-color: #111;
            color: white;
            font-weight: 600;
            border-radius: 50px;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #e76767;
        }

        body.dark-mode .btn-submit {
            background-color: #e76767;
            color: #fff;
        }

        body.dark-mode .btn-submit:hover {
            background-color: #b44141;
        }
    </style>

    <!-- Removed inline dark mode toggle button -->

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
