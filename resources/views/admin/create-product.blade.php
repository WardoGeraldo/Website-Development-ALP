@extends('base.base')

@section('content')
<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<style>
    /* Body & Dark Mode */
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
        font-size: 2.5rem;
        font-weight: 600;
        color: #111;
    }

    /* Add New Product Button */
    .btn-add-product {
        display: block;
        margin: 20px auto;
        padding: 0.75rem 2rem;
        background-color: #111;
        color: white;
        font-weight: 600;
        border-radius: 50px;
        cursor: pointer;
        border: none;
        font-size: 1rem;
        transition: background 0.3s;
    }
    .btn-add-product:hover {
        background-color: #e76767;
    }

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
    }

    .form-group {
        margin-bottom: 15px;
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-size: 1rem;
        font-weight: 500;
        color: #444;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group textarea {
        padding: 0.75rem;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #007bff;
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
        transition: background-color 0.3s;
    }
    .btn-submit:hover {
        background-color: #e76767;
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
        <script>
            // Show the success alert
            alert('{{ session('success') }}');
            
            // Redirect to admin dashboard after alert
            setTimeout(function() {
                window.location.href = "{{ route('admin.dashboard') }}"; // Redirect to admin dashboard
            }, 1500); // Delay for 1.5 seconds to allow the alert to be visible
        </script>
    @endif

    <!-- Form Container -->
    <div class="form-container">
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
                <input type="text" name="price" id="price" class="form-control" placeholder="Rp 0" required>
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
</div>

<script>
    AOS.init();

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

    // Format the price input to include commas
    document.getElementById('price').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-digit characters
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Add commas for thousands
        e.target.value = `Rp ${value}`;
    });
</script>

@endsection

