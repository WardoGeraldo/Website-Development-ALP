@extends('base.base')

@section('content')
    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <style>
        body {
            background-color: #fff;
            font-family: 'Inter', sans-serif;
            transition: background 0.3s ease, color 0.3s ease;
        }

        body.dark-mode {
            background-color: #121212;
            color: #f5f5f5;
        }

        .dark-mode-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #000;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            cursor: pointer;
            z-index: 999;
            transition: 0.3s;
        }
    </style>
    <!-- Dark Mode Button -->
    <button class="dark-mode-toggle" onclick="toggleDarkMode()">🌙</button>
    <div class="container">
        <h3 class="my-2">SALES LIST</h3>
        <div class="border">
            <table class="table table-stripped table-hover">
                <thead>
                    <th>ID</th>
                    <th>DATE</th>
                    <th>TOTAL</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </thead>
                <tbody>
                    @foreach ($sales as $s)
                        <tr>
                            <td>{{ $s['id'] }}</td>
                            <td>{{ $s['transaction_date'] }}</td>
                            <td>{{ $s['total_price'] }}</td>
                            <td>{{ $s['status'] }}</td>
                            <td><a href="{{ route('admin.invoice.index', ['sales_id' => $s['id']]) }}" class="btn btn-primary">DETAIL</a></td>
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
