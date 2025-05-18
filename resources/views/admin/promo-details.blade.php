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
    .promo-details-container {
        max-width: 600px;
        margin: 80px auto 40px auto;
        padding: 2rem;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    body.dark-mode .promo-details-container {
        background: #1c1c1c;
        color: #eee;
        box-shadow: 0 10px 25px rgba(255,255,255,0.1);
    }
    h2 {
        margin-bottom: 1rem;
        font-weight: 700;
        font-size: 2rem;
        text-align: center;
    }
    .promo-info {
        margin-bottom: 1rem;
        font-size: 1.1rem;
        line-height: 1.5;
    }
    .promo-info strong {
        color: #111;
    }
    body.dark-mode .promo-info strong {
        color: #ddd;
    }
    .btn-back {
        display: block;
        margin: 2rem auto 0 auto;
        padding: 0.75rem 2rem;
        background: #111;
        color: white;
        font-weight: 600;
        border-radius: 50px;
        text-align: center;
        text-decoration: none;
        width: fit-content;
        transition: background-color 0.3s;
    }
    .btn-back:hover {
        background-color: #e76767;
    }
</style>

<button class="dark-mode-toggle" onclick="toggleDarkMode()">🌙</button>

<div class="promo-details-container" data-aos="fade-up">
    <h2>Promo Details</h2>
    <div class="promo-info"><strong>Promo Code:</strong> {{ $promo['promo_code'] }}</div>
    <div class="promo-info"><strong>Description:</strong> {{ $promo['description'] }}</div>
    <div class="promo-info"><strong>Discount:</strong> {{ $promo['discount'] }}</div>
    <div class="promo-info"><strong>Start Date:</strong> {{ $promo['start_date'] }}</div>
    <div class="promo-info"><strong>End Date:</strong> {{ $promo['end_date'] }}</div>

    <a href="{{ route('admin.promo.list') }}" class="btn-back">← Back to Promo List</a>
</div>

<script>
    AOS.init();

    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
    }
</script>
@endsection
