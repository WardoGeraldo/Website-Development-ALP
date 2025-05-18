@extends('base.base')

@section('content')
<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<style>
    body {
        background-color: #fff;
        font-family: 'Inter', sans-serif;
        color: #333;
        transition: background 0.3s ease, color 0.3s ease;
        padding: 0 1rem;
    }
    body.dark-mode {
        background-color: #121212;
        color: #f5f5f5;
    }
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
    .form-container {
        max-width: 600px;
        margin: 80px auto 40px auto;
        padding: 2rem 2.5rem;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    body.dark-mode .form-container {
        background: #1c1c1c;
        color: #eee;
        box-shadow: 0 10px 25px rgba(255,255,255,0.1);
    }
    h2 {
        margin-bottom: 2rem;
        font-weight: 700;
        font-size: 2rem;
        text-align: center;
        color: #111;
    }
    body.dark-mode h2 {
        color: #ddd;
    }
    .form-group {
        margin-bottom: 1.25rem;
        display: flex;
        flex-direction: column;
        color: #444;
    }
    body.dark-mode .form-group {
        color: #ccc;
    }
    label {
        font-weight: 600;
        margin-bottom: 6px;
    }
    input, textarea {
        padding: 10px 15px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: border-color 0.3s;
        color: inherit;
        background-color: inherit;
    }
    input:focus, textarea:focus {
        border-color: #e76767;
        outline: none;
        background-color: transparent;
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
    .btn-back {
        display: block;
        margin: 1.5rem auto 0 auto;
        padding: 0.75rem 2rem;
        background: #555;
        color: white;
        font-weight: 600;
        border-radius: 50px;
        text-align: center;
        text-decoration: none;
        width: fit-content;
        transition: background-color 0.3s;
    }
    .btn-back:hover {
        background-color: #cc4c4c;
    }
    .error-message {
        color: #cc4c4c;
        font-size: 0.875rem;
        margin-top: 4px;
    }
</style>

<!-- Dark Mode Button -->
<button class="dark-mode-toggle" onclick="toggleDarkMode()" aria-label="Toggle dark mode">🌙</button>

<div class="form-container" data-aos="fade-up" role="region" aria-labelledby="edit-promo-title">
    <h2 id="edit-promo-title">Edit Promo</h2>

    <form action="{{ route('admin.promo.update', ['id' => $promo['id']]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="promo_code">Promo Code <span style="color:#e76767">*</span></label>
            <input type="text" name="promo_code" id="promo_code" value="{{ old('promo_code', $promo['promo_code'] ?? $promo['code']) }}" required maxlength="20" placeholder="Enter promo code">
            @error('promo_code')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description <span style="color:#e76767">*</span></label>
            <textarea name="description" id="description" rows="3" required placeholder="Describe the promo">{{ old('description', $promo['description']) }}</textarea>
            @error('description')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="discount">Discount (%) <span style="color:#e76767">*</span></label>
            <input type="number" name="discount" id="discount" value="{{ old('discount', rtrim($promo['discount'], '%')) }}" required min="1" max="100" placeholder="e.g. 20">
            @error('discount')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="start_date">Start Date <span style="color:#e76767">*</span></label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $promo['start_date']) }}" required>
            @error('start_date')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="end_date">End Date <span style="color:#e76767">*</span></label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $promo['end_date']) }}" required>
            @error('end_date')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">Save Changes</button>
    </form>

    <a href="{{ route('admin.promo.list') }}" class="btn-back">← Back to Promo List</a>
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
</script>
@endif

@endsection
