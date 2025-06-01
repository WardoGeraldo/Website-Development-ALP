@extends('base.base')
@section('content')
    <div class="dashboard-container">
        <!-- Header Section -->
        <div class="dashboard-header">
            <h1>Sales List</h1>
            <div class="header-controls">
            </div>
        </div>

        <!-- Sales Table -->
        <div class="data-card" data-aos="fade-up">
            <div class="data-header">
                <h2>Monitor all your transactions at a glance</h2>
            </div>
            <div class="data-body">
                <table class="luxury-table">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sales as $s)
                            <tr>
                                <td>{{ $s->order_id }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->order_date)->format('d M Y H:i') }}</td>
                                <td>Rp{{ number_format($s->total_price, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $statusClass = match ($s->order_status) {
                                            'shipped' => 'status-badge completed',
                                            'pending' => 'status-badge pending',
                                            default => 'status-badge default',
                                        };
                                    @endphp
                                    <span class="{{ $statusClass }}">{{ ucfirst($s->order_status) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.invoice.index', ['sales_id' => $s->order_id]) }}"
                                        class="action-btn">
                                        <i class="bi bi-eye"></i>
                                        <span>View</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-message">No sales data available.</td>
                            </tr>
                        @endforelse
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

        // Simple initialization for dark mode
        document.addEventListener('DOMContentLoaded', function() {
            const isDarkModeEnabled = localStorage.getItem('darkMode') === 'enabled' || document.body.classList
                .contains('dark-mode');

            if (isDarkModeEnabled) {
                document.body.classList.add('dark-mode');
            }
        });
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
            --status-completed: #22c55e;
            --status-pending: #facc15;
            --status-default: #9ca3af;
        }

        body.dark-mode {
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
            --status-completed: #22c55e;
            --status-pending: #facc15;
            --status-default: #9ca3af;
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
            background-color: transparent;
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
            background-color: var(--table-header-bg);
        }

        .luxury-table td {
            padding: 1rem;
            font-size: 0.95rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-color);
            background-color: transparent;
        }

        .luxury-table tbody tr {
            background-color: transparent;
        }

        .luxury-table tbody tr:hover {
            background-color: var(--table-header-bg);
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.4em 0.8em;
            font-size: 0.85rem;
            border-radius: 999px;
            font-weight: 600;
        }

        .status-badge.completed {
            background-color: var(--status-completed);
            color: white;
        }

        .status-badge.pending {
            background-color: var(--status-pending);
            color: #1f2937;
        }

        .status-badge.default {
            background-color: var(--status-default);
            color: white;
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
        }

        .action-btn:hover {
            background: var(--accent-color);
            color: #fff;
            transform: translateY(-3px);
            text-decoration: none;
        }

        .action-btn i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        /* Empty Table Message */
        .empty-message {
            text-align: center;
            color: var(--text-secondary);
            padding: 2rem 0 !important;
            font-style: italic;
        }

        /* Smooth Theme Transitions */
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
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

            .dashboard-container {
                padding: 1rem;
            }
        }
    </style>
@endsection
