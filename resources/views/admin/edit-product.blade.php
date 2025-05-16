@extends('base.base')

@section('content')
<style>
    .edit-product-container {
        max-width: 600px;
        margin: 3rem auto;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        font-family: 'Inter', sans-serif;
        color: #333;
    }

    .edit-product-container.dark-mode {
        background-color: #1c1c1c;
        color: #f5f5f5;
        box-shadow: 0 8px 24px rgba(255, 255, 255, 0.1);
    }

    .edit-product-container h1 {
        font-weight: 600;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        font-size: 1rem;
    }

    form input[type="text"],
    form input[type="number"],
    form textarea {
        width: 100%;
        padding: 0.6rem 1rem;
        margin-bottom: 1.5rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    form input[type="text"]:focus,
    form input[type="number"]:focus,
    form textarea:focus {
        border-color: #000;
        outline: none;
    }

    form textarea {
        min-height: 100px;
        resize: vertical;
    }

    .btn-save {
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
        background-color: #000;
        color: white;
        font-weight: 700;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 1.1rem;
        transition: background-color 0.3s ease;
    }

    .btn-save:hover {
        background-color: #e76767;
    }

    .back-link {
        display: block;
        margin-top: 1.5rem;
        text-align: center;
        color: #444;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s;
    }

    .back-link:hover {
        color: #000;
    }

    /* Dark mode styles */
    body.dark-mode .edit-product-container {
        background-color: #1c1c1c;
        color: #ddd;
        box-shadow: 0 8px 24px rgba(255, 255, 255, 0.1);
    }

    body.dark-mode form input[type="text"],
    body.dark-mode form input[type="number"],
    body.dark-mode form textarea {
        background-color: #333;
        border-color: #555;
        color: #ddd;
    }

    body.dark-mode form input[type="text"]:focus,
    body.dark-mode form input[type="number"]:focus,
    body.dark-mode form textarea:focus {
        border-color: #e76767;
    }

    body.dark-mode .back-link {
        color: #bbb;
    }

    body.dark-mode .back-link:hover {
        color: #fff;
    }
</style>

<div class="edit-product-container" id="editProductContainer">
    <h1>Edit Product: {{ $product['name'] }}</h1>

   <form action="#" method="POST" id="editProductForm">
    @csrf
    <!-- your inputs -->
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="{{ $product['name'] }}" required>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" value="{{ $product['price'] }}" required>

    <label for="category">Category:</label>
    <input type="text" id="category" name="category" value="{{ $product['category'] }}" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="4">{{ $product['description'] ?? '' }}</textarea>

    <button type="submit" class="btn-save">Save Changes</button>
</form>
<a href="{{ route('admin.dashboard') }}" class="back-link">← Back to Dashboard</a>

<script>
    document.getElementById('editProductForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission
        alert('Product updated successfully!');
        // Optionally: redirect after alert, e.g.:
        // window.location.href = "{{ route('admin.dashboard') }}";
    });
</script>
@endsection