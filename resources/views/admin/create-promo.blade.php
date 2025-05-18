@extends('base.base')

@section('content')
<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
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

    /* Form Container */
    .form-container {
        max-width: 600px;
        margin: 0 auto 50px auto;
        padding: 30px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #444;
    }

    .form-group input, 
    .form-group textarea {
        padding: 10px 15px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: border-color 0.3s;
    }

    .form-group input:focus, 
    .form-group textarea:focus {
        border-color: #e76767;
        outline: none;
    }

    .btn-submit {
        background-color: #111;
        color: white;
        font-weight: 700;
        border: none;
        border-radius: 50px;
        padding: 1rem 0;
        font-size: 1.1rem;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
    }
    .btn-submit:hover {
        background-color: #e76767;
    }

    /* Validation Errors */
    .error-message {
        color: #cc4c4c;
        font-size: 0.875rem;
        margin-top: 4px;
    }
</style>

<!-- Dark Mode Button -->
<button class="dark-mode-toggle" onclick="toggleDarkMode()">🌙</button>

<div class="container">
    <div class="store-header">
        <h1>Add New Promo</h1>
        <p>Create a new promo code to boost your sales.</p>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.promo.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="promo_code">Promo Code <span style="color:#e76767">*</span></label>
                <input type="text" name="promo_code" id="promo_code" value="{{ old('promo_code') }}" required maxlength="20" placeholder="Enter promo code">
                @error('promo_code')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description <span style="color:#e76767">*</span></label>
                <textarea name="description" id="description" rows="3" required placeholder="Describe the promo">{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="discount">Discount (%) <span style="color:#e76767">*</span></label>
                <input type="number" name="discount" id="discount" value="{{ old('discount') }}" required min="1" max="100" placeholder="e.g. 20">
                @error('discount')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_date">Start Date <span style="color:#e76767">*</span></label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') ?? date('Y-m-d') }}" required>
                @error('start_date')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_date">End Date <span style="color:#e76767">*</span></label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') ?? date('Y-m-d', strtotime('+1 month')) }}" required>
                @error('end_date')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Create Promo</button>
        </form>
    </div>
</div>

<script>
    AOS.init();

    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
    }
</script>

@if(session('success'))
<script>
    alert('{{ session('success') }}');
    window.location.href = "{{ route('admin.promo.list') }}"; // Redirect to promo list after success
</script>
@endif

@endsection
