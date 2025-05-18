@extends('base.base')

@section('content')
    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <style>
        /* Base body styles */
        body {
            background-color: #fff;
            font-family: 'Inter', sans-serif;
            color: #333;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* Dark Mode base */
        body.dark-mode {
            background-color: #121212;
            color: #f5f5f5;
        }

        /* Dark Mode Toggle */
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

        /* Header styles */
        .container {
            margin-top: 50px;
        }

        .sales-list-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .sales-list-header h3 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
        }

        .sales-list-header p {
            color: #777;
            font-size: 1.1rem;
        }

        /* Table Styles */
        .sales-list-table {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-top: 20px;
        }

        .sales-list-table th {
            background-color: #1f1f1f;
            color: #fff;
            text-align: center;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
        }

        .sales-list-table td {
            text-align: center;
            font-size: 1rem;
            color: #555;
            padding: 15px;
        }

        .sales-list-table tbody tr {
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .sales-list-table tbody tr:hover {
            background-color: #f4f4f4;
            transform: scale(1.02);
        }

        .sales-list-table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .sales-list-table tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        .btn-primary {
            padding: 0.6rem 2rem;
            background-color: #000;
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #e76767;
        }

        /* Dark Mode Styling */
        body.dark-mode .sales-list-table {
            background-color: #333;
            color: #f5f5f5;
        }

        body.dark-mode .sales-list-table th {
            background-color: #444;
        }

        body.dark-mode .sales-list-table tbody tr:hover {
            background-color: #555;
        }

        body.dark-mode .btn-primary {
            background-color: #444;
        }

        body.dark-mode .btn-primary:hover {
            background-color: #e76767;
        }

    </style>

    <div class="container">
        <div class="sales-list-header">
            <h3>Sales List</h3>
            <p>Manage and track your sales transactions easily.</p>
        </div>

        <div class="sales-list-table">
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $s)
                        <tr>
                            <td>{{ $s['id'] }}</td>
                            <td>{{ $s['transaction_date'] }}</td>
                            <td>Rp{{ number_format($s['total_price'], 0, ',', '.') }}</td>
                            <td>{{ $s['status'] }}</td>
                            <td>
                                <a href="{{ route('admin.invoice.index', ['sales_id' => $s['id']]) }}"
                                    class="btn btn-primary">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>

    <script>
        AOS.init();

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>
@endsection
