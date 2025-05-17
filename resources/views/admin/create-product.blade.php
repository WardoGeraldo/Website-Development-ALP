@extends('base.base')

@section('content')
<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<style>
    body {
        background-color: #fff;
        font-family: 'Inter', sans-serif;
        color: #333;
        transition: background 0.3s ease, color 0.3s ease;
    }

    body.dark-mode {
        background-color: #121212;
        color: #f5f5f5;
    }

    /* Dark Mode Button */
    .dark-mode-toggle {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #111;
        color: white;
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 25px;
        cursor: pointer;
        z-index: 999;
        font-size: 1.2rem;
        transition: background-color 0.3s;
    }

    /* Header */
    .store-header {
        text-align: center;
        margin-top: 60px;
        margin-bottom: 30px;
    }

    .store-header h1 {
        font-size: 3rem;
        font-weight: 700;
        color: #111;
    }

    /* Form Styling */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
    }

    .form-control {
        border-radius: 10px;
        padding: 0.75rem;
        width: 100%;
        border: 1px solid #ccc;
    }

    .form-control:focus {
        outline: none;
        border-color: #007bff;
    }

    /* Button Styling */
    .btn-submit {
        display: block;
        width: 100%;
        background-color: #111;
        color: white;
        padding: 1rem;
        border-radius: 25px;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: #e76767;
    }

    /* Image Preview */
    .image-preview {
        width: 100%;
        height: auto;
        border-radius: 10px;
        margin-top: 10px;
        max-width: 100%; /* Make sure image fits within container */
        object-fit: cover;
    }

    /* Success Message Styling */
    .alert {
        margin-top: 20px;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .store-header h1 {
            font-size: 2.5rem;
        }

        .form-group {
            margin-bottom: 15px;
        }
    }

    @media (max-width: 480px) {
        .form-control {
            padding: 0.5rem;
        }

        .btn-submit {
            padding: 1rem;
            font-size: 1rem;
        }
    }

</style>

<!-- Dark Mode Button -->
<button class="dark-mode-toggle" onclick="toggleDarkMode()">🌙</button>

<div class="container">
    <div class="store-header">
        <h1>Add New Product</h1>
    </div>

    <!-- Display Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Product Name -->
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <!-- Price -->
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" required>
        </div>

        <!-- Category -->
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" name="category" id="category" class="form-control" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <!-- Product Image -->
        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
            <img id="imagePreview" class="image-preview" src="#" alt="Image Preview" style="display: none;">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit">Add Product</button>
    </form>
</div>

<!-- Success Alert -->
@if(session('success'))
    <script>
        alert('Successfully created the product!');
        window.location.href = "{{ route('admin.dashboard') }}";
    </script>
@endif

<script>
    // Toggle Dark Mode
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
    }

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
</script>

@endsection
