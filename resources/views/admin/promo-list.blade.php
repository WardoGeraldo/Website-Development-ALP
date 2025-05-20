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

        /* Main Content Container */
        .main-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Header */
        .store-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .store-header h1 {
            font-size: 2.5rem;
            font-weight: 600;
            color: #111; /* Always black text for header */
        }

        .store-header p {
            color: #555;
            font-size: 1.1rem;
        }

        /* Promo Table */
        .promo-table-container {
            width: 100%;
            margin: 20px 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .promo-table {
            width: 100%;
            background-color: #fff;
            border-collapse: collapse;
        }

        .promo-table th,
        .promo-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .promo-table th {
            font-weight: 600;
            color: #333;
            background-color: #f8f8f8;
        }

        .promo-table td {
            color: #555;
        }

        .promo-table tr:hover {
            background-color: #f7f7f7;
        }

        .btn-view {
            padding: 0.5rem 1.2rem;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.3s;
            display: inline-block;
            text-decoration: none;
        }

        .btn-view:hover {
            background-color: #0056b3;
        }

        /* Add Promo Button */
        .btn-add-promo {
            display: block;
            width: fit-content;
            margin: 0 auto 30px;
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

        .btn-add-promo:hover {
            background-color: #333;
        }
        
        /* Dark mode adjustments */
        body.dark-mode .store-header h1 {
            color: #f5f5f5;
        }
        
        body.dark-mode .store-header p {
            color: #ccc;
        }
        
        body.dark-mode .promo-table {
            background-color: #1e1e1e;
        }
        
        body.dark-mode .promo-table th {
            background-color: #2a2a2a;
            color: #e0e0e0;
        }
        
        body.dark-mode .promo-table td {
            color: #bbb;
            border-bottom: 1px solid #333;
        }
        
        body.dark-mode .promo-table tr:hover {
            background-color: #2c2c2c;
        }
    </style>

    <div class="main-container">
        <div class="store-header" data-aos="fade-down">
            <h1>Promo List</h1>
            <p>Manage and view all active promos for your store.</p>
        </div>

        <!-- Add New Promo Button -->
        <button class="btn-add-promo" data-aos="fade-up" onclick="location.href='{{ route('admin.promo.create') }}'">+ Add New Promo</button>

        <!-- Promo Table -->
        <div class="promo-table-container" data-aos="fade-up">
            <table class="promo-table">
                <thead>
                    <tr>
                        <th>Promo Code</th>
                        <th>Description</th>
                        <th>Discount (%)</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($promos as $promo)
                        <tr>
                            <td>{{ $promo['promo_code'] }}</td>
                            <td>{{ $promo['description'] }}</td>
                            <td>{{ $promo['discount'] }}</td>
                            <td>{{ $promo['start_date'] }}</td>
                            <td>{{ $promo['end_date'] }}</td>
                            <td><a href="{{ route('admin.promo.details', ['id' => $promo['id']]) }}" class="btn-view">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if (session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif

<script>
    AOS.init();

    // Check for saved dark mode preference
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        if (isDarkMode) {
            document.body.classList.add('dark-mode');
            document.getElementById('darkModeToggle').textContent = '☀️';
        }
    });

    // Toggle Dark Mode
    document.getElementById('darkModeToggle').addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        const isDarkMode = document.body.classList.contains('dark-mode');
        localStorage.setItem('darkMode', isDarkMode);
        this.textContent = isDarkMode ? '☀️' : '🌙';
    });
</script>

@endsection