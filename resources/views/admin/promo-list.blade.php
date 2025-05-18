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

        /* Promo Table */
        .promo-table {
            width: 100%;
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .promo-table th,
        .promo-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .promo-table th {
            font-weight: 600;
            color: #444;
        }

        .promo-table td {
            color: #777;
        }

        .promo-table tr:hover {
            background-color: #f7f7f7;
        }

        .btn-view {
            padding: 0.5rem 1rem;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.3s;
        }

        .btn-view:hover {
            background-color: #e76767;
        }

        /* Add Promo Button */
        .btn-add-promo {
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

        .btn-add-promo:hover {
            background-color: #e76767;
        }
    </style>

    <!-- Dark Mode Button -->
    <button class="dark-mode-toggle" onclick="toggleDarkMode()">🌙</button>

    <div class="container">
        <div class="store-header">
            <h1>Promo List</h1>
            <p>Manage and view all active promos for your store.</p>
        </div>

        <!-- Add New Promo Button -->
        <button class="btn-add-promo" onclick="location.href='{{ route('admin.promo.create') }}'">+ Add New Promo</button>

        <!-- Promo Table -->
        <table class="promo-table" data-aos="fade-up">
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

    @if (session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif

    <script>
        AOS.init();

        // Toggle Dark Mode
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>
@endsection
