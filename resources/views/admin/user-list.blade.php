@extends('base.base')

@section('content')
    <div class="dashboard-container">
        <!-- Header Section -->
        <div class="dashboard-header">
            <h1>Admin - Users List</h1>


            <div class="header-controls">
                <div class="date-display">
                    <span id="current-date"></span>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="data-card" data-aos="fade-up">
            <div class="data-header">
                <h2>View and manage users of your store</h2>
            </div>
            <div class="data-body">
                <table class="luxury-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ $user->email }}</td>

                                <td>
                                    <a href="{{ route('admin.user.edit', ['id' => $user->user_id]) }}" class="action-btn">
                                        <i class="bi bi-eye"></i>
                                        <span>View</span>
                                    </a>

                                    @if ($user->status_del == 0)
                                        <form action="{{ route('admin.user.delete', ['id' => $user->user_id]) }}"
                                            method="POST" style="display:inline;" class="delete-user-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn"
                                                style="background-color: #ffecec; color: #e63946;">
                                                <i class="bi bi-trash"></i>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    @endif
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

    <script>
        // Initialize AOS
        AOS.init();

        // Set current date
        document.addEventListener('DOMContentLoaded', function() {
            const dateElement = document.getElementById('current-date');
            if (dateElement) {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                dateElement.textContent = now.toLocaleDateString('en-US', options);
            }
        });
    </script>

    <style>
        /* Base Styles with Dark Mode Support */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        /* Light Mode Variables (Default) */
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

        /* Dark Mode Variables - Using same class as base template */
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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.5s ease, color 0.5s ease;
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
            transition: all 0.5s ease;
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
            transition: all 0.3s ease;
        }

        .luxury-table tbody tr:hover {
            background-color: var(--accent-light);
        }

        .luxury-table tbody tr:hover td {
            background-color: transparent;
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

        /* Alert styling for theme compatibility */
        .alert-success {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            transition: all 0.5s ease;
        }

        .btn-close {
            filter: var(--text-color)==#f1f1f1 ? invert(1): invert(0);
        }

        /* Smooth Theme Transitions */
        * {
            transition: background-color 0.5s ease, color 0.5s ease, border-color 0.5s ease;
        }

        /* Responsive Design */
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
                white-space: nowrap;
            }

            .luxury-table th,
            .luxury-table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .dashboard-container {
                padding: 1rem;
            }

            .dashboard-header h1 {
                font-size: 1.5rem;
            }

            .data-header h2 {
                font-size: 1rem;
            }

            .action-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }

            .action-btn i {
                margin-right: 0.4rem;
                font-size: 0.9rem;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                position: 'top-end',
                toast: true,
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.delete-user-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "User will be deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
