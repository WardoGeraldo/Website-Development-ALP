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

        body.dark-mode .store-header h1 {
            color: #f5f5f5;
        }

        /* Users Table */
        .user-table {
            width: 100%;
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        body.dark-mode .user-table {
            background-color: #222;
            box-shadow: 0 4px 12px rgba(0,0,0,0.6);
        }

        .user-table th,
        .user-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            transition: color 0.3s ease, border-color 0.3s ease;
        }

        .user-table th {
            font-weight: 600;
            color: #444;
        }

        .user-table td {
            color: #777;
        }

        .user-table tr:hover {
            background-color: #f7f7f7;
            transition: background-color 0.3s ease;
        }

        body.dark-mode .user-table th {
            color: #ccc;
        }

        body.dark-mode .user-table td {
            color: #bbb;
        }

        body.dark-mode .user-table tr:hover {
            background-color: #333;
        }

        /* Button Styling */
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
    </style>

    <div class="container">
        <div class="store-header">
            <h1>Admin - Users List</h1>
            <p>View and manage users of your store.</p>
        </div>

        <!-- Users Table -->
        <table class="user-table" data-aos="fade-up">
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
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['address'] }}</td>
                        <td>{{ $user['phone'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td><a href="{{ route('admin.user.details', ['id' => $user['id']]) }}" class="btn-view">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        AOS.init();

        // Toggle Dark Mode with persistence
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');

            // Save preference
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
            } else {
                localStorage.removeItem('darkMode');
            }
        }

        // Load saved preference on page load
        window.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.body.classList.add('dark-mode');
            }
        });
    </script>
@endsection
