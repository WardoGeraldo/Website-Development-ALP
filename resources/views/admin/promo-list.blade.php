@extends('base.base')

@section('content')
    <div class="dashboard-container">
        <!-- Header Section -->
        <div class="dashboard-header">
            <h1>Promo List</h1>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="header-controls">
                <div class="date-display">
                    <span id="current-date"></span>
                </div>
            </div>
        </div>

        <!-- Add New Promo Button -->
        <div class="action-container" data-aos="fade-up">
            <button class="action-btn add-btn" onclick="location.href='{{ route('admin.promo.create') }}'">
                <i class="bi bi-plus-circle"></i>
                <span>Add New Promo</span>
            </button>
        </div>

        <!-- Promo Table -->
        <div class="data-card" data-aos="fade-up">
            <div class="data-header">
                <h2>Manage and view all active promos for your store</h2>
            </div>
            <div class="data-body">
                <table class="luxury-table">
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
                                <td>
                                    <a href="{{ route('admin.promo.details', ['id' => $promo['id']]) }}" class="action-btn">
                                        <i class="bi bi-eye"></i>
                                        <span>View</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <style>
        /* Base Styles with Dark Mode Support */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --bg-color: #F8F9FD;
            --text-color: #333;
            --text-secondary: #777;
            --border-color: rgba(0, 0, 0, 0.05);
            --card-bg: #fff;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            --card-hover-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            --accent-color: #896CFF;
            --accent-light: rgba(137, 108, 255, 0.1);
            --table-header-bg: rgba(0, 0, 0, 0.02);
        }

        .dark-theme {
            --bg-color: #121212;
            --text-color: #f1f1f1;
            --text-secondary: #c5c5c5;
            --border-color: rgba(255, 255, 255, 0.1);
            --card-bg: #1e1e1e;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            --card-hover-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            --accent-color: #a58bff;
            --accent-light: rgba(137, 108, 255, 0.2);
            --table-header-bg: rgba(255, 255, 255, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background 0.3s ease, color 0.3s ease;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header Styles */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .dashboard-header h1 {
            font-size: 2rem;
            font-weight: 600;
            color: var(--text-color);
            position: relative;
        }

        .dashboard-header h1::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #896CFF, #5A3FD9);
            border-radius: 10px;
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .date-display {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: var(--text-secondary);
            gap: 0.5rem;
        }

        /* Action Container */
        .action-container {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 1.5rem;
        }

        /* Cards & Containers */
        .data-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .data-card:hover {
            box-shadow: var(--card-hover-shadow);
            border-color: rgba(137, 108, 255, 0.2);
        }

        .data-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .data-header h2 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-color);
        }

        /* Table Styles */
        .luxury-table {
            width: 100%;
            border-collapse: collapse;
        }

        .luxury-table thead tr {
            background-color: var(--table-header-bg);
            border-radius: 8px;
        }

        .luxury-table th {
            text-align: left;
            padding: 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .luxury-table td {
            padding: 1rem;
            font-size: 0.95rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-color);
        }

        /* Action Button */
        .action-btn {
            display: inline-flex;
            align-items: center;
            background: var(--accent-light);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            color: var(--accent-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .action-btn:hover {
            background: var(--accent-color);
            color: #fff;
            transform: translateY(-3px);
        }

        .action-btn i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .add-btn {
            background: var(--accent-color);
            color: #fff;
        }

        .add-btn:hover {
            background: #7854e4;
            box-shadow: 0 4px 12px rgba(137, 108, 255, 0.3);
        }

        /* Glassmorphism Cards */
        .data-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark-theme .data-card {
            background: rgba(30, 30, 30, 0.2);
        }

        /* Alert Styles */
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: rgba(25, 135, 84, 0.1);
            border: 1px solid rgba(25, 135, 84, 0.2);
            color: #198754;
        }

        .alert-dismissible {
            position: relative;
        }

        .btn-close {
            position: absolute;
            top: 0;
            right: 0;
            padding: 1rem;
            background: transparent;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .header-controls {
                width: 100%;
                justify-content: space-between;
            }

            .luxury-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>

    <script>
        // Initialize AOS
        AOS.init();

        // Set current date
        document.addEventListener('DOMContentLoaded', function() {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const currentDate = new Date().toLocaleDateString(undefined, options);
            document.getElementById('current-date').textContent = currentDate;
            
            // Check for saved theme preference or use system preference
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const initialTheme = savedTheme || (prefersDark ? 'dark' : 'light');
            
            // Set initial theme
            if (initialTheme === 'dark') {
                document.body.classList.add('dark-theme');
            }
        });

        // Show success message as alert rather than using JavaScript alert
        @if (session('success'))
        setTimeout(function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.add('fade');
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500);
            }
        }, 3000);
        @endif
    </script>
@endsection