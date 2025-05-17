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

        /* Users Table */
        .user-table {
            width: 100%;
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .user-table th,
        .user-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
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

    <!-- Dark Mode Button -->
    <button class="dark-mode-toggle" onclick="toggleDarkMode()">🌙</button>

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

        // Toggle Dark Mode
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>
@endsection
