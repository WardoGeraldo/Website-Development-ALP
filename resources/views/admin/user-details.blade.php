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

    /* User Details Section */
    .user-details {
        padding: 30px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
    }

    .user-details p {
        font-size: 1.2rem;
        margin: 10px 0;
    }

    .btn-back {
        padding: 0.75rem 1.5rem;
        background-color: #111;
        color: white;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 1rem;
        transition: background 0.3s;
        width: 100%;
        margin-top: 20px;
    }

    .btn-back:hover {
        background-color: #e76767;
    }

</style>

<!-- Dark Mode Button -->
<button class="dark-mode-toggle" onclick="toggleDarkMode()">🌙</button>

<div class="container">
    <div class="store-header">
        <h1>User Details</h1>
    </div>

    <!-- User Details Section -->
    <div class="user-details">
        <p><strong>Name:</strong> {{ $user['name'] }}</p>
        <p><strong>Address:</strong> {{ $user['address'] }}</p>
        <p><strong>Phone:</strong> {{ $user['phone'] }}</p>
        <p><strong>Email:</strong> {{ $user['email'] }}</p>
        <p><strong>Gender:</strong> {{ $user['gender'] }}</p>
        <p><strong>Date of Birth:</strong> {{ $user['dob'] }}</p>
        <p><strong>Role:</strong> {{ $user['role'] }}</p>
    </div>

    <button class="btn-back" onclick="window.history.back()">Back to Users List</button>
</div>

<script>
    AOS.init();

    // Toggle Dark Mode
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
    }
</script>

@endsection
