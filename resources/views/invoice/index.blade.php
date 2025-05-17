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
        <h3 class="my-2">INVOICE #{{ $sales_id }}</h3>
        <hr>
        <div class="d-flex justify-content-between">
        {{-- DETAIL ADDRESS --}}
            <div>
                <h5>Customer Detail</h5>
                <p>Name: {{ $customer['name'] }}</p>
                <p>Address: {{ $customer['address'] }}</p>
                <p>Phone: {{ $customer['phone'] }}</p>
                <p>Email: {{ $customer['email'] }}</p>
            </div>
        {{-- DETAIL PAYMENT --}}
            <div>
                <h5>Payment Detail</h5>
                <p>Payment Method: {{ $payment['payment_method'] }}</p>
                <p>Status: <span class="badge {{ $payment['payment_status'] == 'Paid' ? 'text-bg-success' : 'text-bg-danger' }}">{{ $payment['payment_status'] }} </span></p>
                <p>Date: {{ $payment['payment_date'] }}</p>
            </div>
        </div>
        <hr>
        {{-- DETAIL ITEMS --}}
        <div class="border">
            <table class="table table-stripped table-hover">
                <thead>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    @foreach ($invoice as $i)
                        <tr>
                            <td>{{ $i['product_id'] }}</td>
                            <td>{{ $i['name'] }}</td>
                            <td>{{ $i['description'] }}</td>
                            <td>{{ $i['size'] }}</td>
                            <td>{{ $i['qty'] }}</td>
                            <td>{{ $i['price'] }}</td>
                            <td>{{ $i['total'] }}</td>
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
