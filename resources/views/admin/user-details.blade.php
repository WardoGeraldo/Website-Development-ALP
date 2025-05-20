@extends('base.base')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

    body {
        background-color: #fff;
        font-family: 'Inter', sans-serif;
        color: #333;
        transition: background-color 0.3s ease, color 0.3s ease;
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

    body.dark-mode .dark-mode-toggle {
        background: #f5f5f5;
        color: #121212;
    }

    .store-header {
        text-align: center;
        margin-top: 60px;
        margin-bottom: 30px;
    }

    .store-header h1 {
        font-weight: 600;
    }

    .user-details {
        padding: 30px;
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        margin-bottom: 40px;
    }

    body.dark-mode .user-details {
        background-color: #1e1e1e;
        color: #f5f5f5;
        box-shadow: 0 8px 24px rgba(255, 255, 255, 0.05);
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.3rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.75rem;
        border: 1px solid #ccc;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    body.dark-mode .form-control,
    body.dark-mode .form-select {
        background-color: #2b2b2b;
        border-color: #444;
        color: #f5f5f5;
    }

    .btn-primary {
        background-color: #4f46e5;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #4338ca;
    }

    .btn-back {
        background-color: #333;
        color: #fff;
        padding: 0.6rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        margin-top: 1rem;
        transition: background-color 0.3s ease;
    }

    .btn-back:hover {
        background-color: #e76767;
        color: white;
    }

    body.dark-mode .btn-back {
        background-color: #ddd;
        color: #121212;
    }

</style>

<!-- Dark Mode Toggle -->
<button class="dark-mode-toggle" id="darkModeToggle">🌙</button>

<div class="container">
    <div class="store-header">
        <h1>Edit User</h1>
    </div>

    <form action="{{ route('admin.user.update', ['id' => $user['id']]) }}" method="POST" class="user-details" data-aos="fade-up">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user['name'] }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="{{ $user['address'] }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $user['phone'] }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user['email'] }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select">
                <option value="male" {{ $user['gender'] == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $user['gender'] == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ $user['gender'] == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control" value="{{ $user['dob'] }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select">
                <option value="user" {{ $user['role'] == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user['role'] == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Update User</button>
            <button type="button" onclick="window.history.back()" class="btn btn-back">← Back</button>
        </div>
    </form>
</div>

<script>
    AOS.init();

    document.addEventListener('DOMContentLoaded', function () {
        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        const body = document.body;
        const toggle = document.getElementById('darkModeToggle');

        if (isDarkMode) {
            body.classList.add('dark-mode');
            toggle.textContent = '☀️';
        }

        toggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            const isDark = body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDark);
            toggle.textContent = isDark ? '☀️' : '🌙';
        });
    });
</script>
@endsection
