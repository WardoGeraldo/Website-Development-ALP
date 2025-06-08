@extends('base.base')

@section('content')
    <div class="dashboard-container">
        <!-- Header Section -->
        <div class="dashboard-header">
            <h1>Invoice #{{ $order->order_id }}</h1>
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

        <!-- Customer and Payment Details -->
        <div class="row">
            <!-- Customer Details Card -->
            <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="data-card">
                    <div class="data-header">
                        <h2>Customer Details</h2>
                    </div>
                    <div class="data-body">
                        <div class="customer-info">
                            <p><strong>Name:</strong> {{ $order->user->name }}</p>
                            <p><strong>Address:</strong> {{ $order->user->address }}</p>
                            <p><strong>Phone:</strong> {{ $order->user->phone_number }}</p>
                            <p><strong>Email:</strong> {{ $order->user->email }}</p>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Details Card -->
            <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="data-card">
                    <div class="data-header">
                        <h2>Payment Details</h2>
                    </div>
                    <div class="data-body">
                        <div class="payment-info">
                            <p><strong>Payment Method:</strong> {{ $order->payment->payment_method }}</p>
                            <p><strong>Status:</strong>
                                <span
                                    class="status-badge {{ $order->payment->payment_status == 'Paid' ? 'status-paid' : 'status-unpaid' }}">
                                    {{ $order->payment->payment_status }}
                                </span>
                            </p>
                            <p><strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($order->payment->payment_date)->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Items Table -->
        <div class="data-card" data-aos="fade-up" data-aos-delay="300">
            <div class="data-header">
                <h2>Invoice Items</h2>
            </div>
            <div class="data-body">
                <table class="luxury-table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Size</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $i)
                            <tr>
                                <td>{{ $i->product_id }}</td>
                                <td>{{ $i->product->name }}</td>
                                <td>{{ $i->product->description }}</td>
                                <td>{{ $i->product_size }}</td>
                                <td>{{ $i->quantity }}</td>
                                <td>Rp{{ number_format($i->price, 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($i->price * $i->quantity, 0, ',', '.') }}</td>
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

    <script>
        // Initialize AOS
        AOS.init();

        // Set current date
        document.addEventListener('DOMContentLoaded', function() {
            const dateDisplay = document.getElementById('current-date');
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            dateDisplay.textContent = now.toLocaleDateString('en-US', options);
        });

        // Theme management
        const themeToggleBtn = document.getElementById('theme-toggle');

        // Check for saved theme preference or use system preference
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const initialTheme = savedTheme || (prefersDark ? 'dark' : 'light');

        // Set initial theme
        if (initialTheme === 'dark') {
            document.body.classList.add('dark-theme');
        }

        // Toggle theme
        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', () => {
                document.body.classList.toggle('dark-theme');
                const isDark = document.body.classList.contains('dark-theme');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            });
        }
    </script>

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
            --table-bg: #fff;
            --table-row-hover: rgba(0, 0, 0, 0.02);
            --success-color: #28a745;
            --danger-color: #dc3545;
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
            --table-bg: #1e1e1e;
            --table-row-hover: rgba(255, 255, 255, 0.05);
            --success-color: #5cb85c;
            --danger-color: #d9534f;
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

        /* Cards & Containers */
        .data-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            height: 100%;
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

        /* Customer & Payment Info */
        .customer-info p,
        .payment-info p {
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            color: var(--text-color);
        }

        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-paid {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .status-unpaid {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }

        /* Table Styles */
        .luxury-table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--table-bg);
            border-radius: 8px;
            overflow: hidden;
        }

        .luxury-table thead tr {
            background-color: var(--table-header-bg);
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

        .luxury-table tbody tr:hover {
            background-color: var(--table-row-hover);
        }

        .luxury-table tbody tr:last-child td {
            border-bottom: none;
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
@endsection
