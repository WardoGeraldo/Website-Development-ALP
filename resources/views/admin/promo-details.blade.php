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

        .form-container {
            padding: 30px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
        }

        body.dark-mode .form-container {
            background-color: #1e1e1e;
            color: #f5f5f5;
            box-shadow: 0 8px 24px rgba(255, 255, 255, 0.05);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.3rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
            border: 1px solid #ccc;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        body.dark-mode .form-control {
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

        .error-message {
            color: #cc4c4c;
            font-size: 0.875rem;
            margin-top: 4px;
        }

        body.dark-mode .error-message {
            color: #ff8a8a;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }
    </style>

    <!-- Dark Mode Toggle -->
    <button class="dark-mode-toggle" id="darkModeToggle">🌙</button>

    <div class="container">
        <div class="store-header">
            <h1>Edit Promo</h1>
            <p>Update your promotion details.</p>
        </div>

        <form action="{{ route('admin.promo.update', ['id' => $promo['promo_id']]) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Promo Code <span style="color:#e76767">*</span></label>
                <input type="text" name="promo_code" class="form-control"
                    value="{{ old('promo_code', $promo['promo_code'] ?? $promo['code']) }}" required maxlength="20"
                    placeholder="Enter promo code">
                @error('promo_code')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>



            <div class="mb-3">
                <label class="form-label">Discount (%) <span style="color:#e76767">*</span></label>
                <input type="number" name="discount" class="form-control"
                    value="{{ old('discount', (float) $promo->discount_amount) }}" required min="1" max="100"
                    placeholder="e.g. 20">
                @error('discount')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>



            <div class="mb-3">
                <label class="form-label">Start Date <span style="color:#e76767">*</span></label>
                <input type="date" name="start_date" class="form-control"
                    value="{{ old('start_date', $promo['start_date'] ? $promo['start_date']->format('Y-m-d') : '') }}"required>
                @error('start_date')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">End Date <span style="color:#e76767">*</span></label>
                <input type="date" name="end_date" class="form-control"
                    value="{{ old('end_date', $promo['end_date'] ? $promo['end_date']->format('Y-m-d') : '') }}" required>
                @error('end_date')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.promo.list') }}" class="btn btn-back">← Back to Promo List</a>
            </div>
        </form>
    </div>

    <script>
        AOS.init();

        document.addEventListener('DOMContentLoaded', function() {
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        </script>
    @endif
@endsection
