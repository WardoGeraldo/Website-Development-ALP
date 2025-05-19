@extends('base.base')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        /* Base & Dark Mode Colors */
        body {
            background-color: #fff;
            color: #333;
            font-family: 'Inter', sans-serif;
            transition: background-color 0.5s ease, color 0.5s ease;
        }

        body.dark-mode {
            background-color: #121212;
            color: #f5f5f5;
        }

        /* Dark Mode Toggle Button */
        .dark-mode-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #111;
            color: white;
            border: none;
            padding: 0.75rem 1.2rem;
            border-radius: 25px;
            cursor: pointer;
            z-index: 999;
            font-size: 1.3rem;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
            user-select: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .dark-mode-toggle:hover {
            background-color: #e76767;
            box-shadow: 0 6px 12px rgba(231, 103, 103, 0.7);
        }

        /* Container styles */
        .product-list-container {
            max-width: 1100px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            font-family: 'Inter', sans-serif;
            transition: background-color 0.5s ease, color 0.5s ease;
        }

        body.dark-mode .product-list-container {
            background: #222;
            color: #f5f5f5;
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.1);
        }

        /* Top bar */
        .top-bar {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
            margin-bottom: 15px;
        }

        /* Buttons */
        .btn-add {
            background-color: #38b000;
            color: white;
            border: none;
            padding: 7px 18px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-add:hover {
            background-color: #2f8e00;
        }

        .btn-delete {
            background-color: #d90429;
            color: white;
            border: none;
            padding: 7px 18px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #a4031f;
        }

        .btn-action {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 7px 18px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
        }

        /* Search input */
        .search-container {
            float: right;
        }

        .search-container input {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            width: 180px;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        body.dark-mode .search-container input {
            background-color: #333;
            color: #f5f5f5;
            border-color: #555;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            transition: color 0.5s ease;
        }

        thead th {
            text-align: left;
            color: #444;
            font-weight: 600;
            padding: 10px 15px;
            border-bottom: 2px solid #eee;
            transition: color 0.5s ease, border-color 0.5s ease;
        }

        body.dark-mode thead th {
            color: #ccc;
            border-color: #444;
        }

        tbody tr {
            background: #f8fafb;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgb(0 0 0 / 0.05);
            transition: background-color 0.2s ease, color 0.5s ease;
        }

        tbody tr:hover {
            background: #dbeafe;
        }

        body.dark-mode tbody tr {
            background: #333;
            color: #f5f5f5;
        }

        body.dark-mode tbody tr:hover {
            background: #444;
        }

        tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            color: #222;
            transition: color 0.5s ease;
        }

        body.dark-mode tbody td {
            color: #ddd;
        }

        /* Image thumbnails */
        .product-image {
            width: 70px;
            height: 70px;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            transition: filter 0.3s ease;
        }

        body.dark-mode .product-image {
            filter: brightness(0.85);
        }

        /* Switch */
        .form-check.form-switch .form-check-input {
            width: 42px;
            height: 22px;
            margin-left: 0;
            cursor: pointer;
        }

        /* Action icons */
        .action-icon {
            color: #6b7280;
            font-size: 1.3rem;
            cursor: pointer;
            margin-left: 10px;
            transition: color 0.2s ease;
        }

        .action-icon:hover {
            color: #ef4444;
        }

        /* Pagination & info */
        .table-footer {
            margin-top: 18px;
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: #555;
            font-weight: 600;
            transition: color 0.5s ease;
        }

        body.dark-mode .table-footer {
            color: #ccc;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .search-container {
                float: none;
                margin-top: 15px;
                text-align: left;
            }
        }
    </style>

    <div class="product-list-container">
        <div class="top-bar">
            <button class="btn-add" onclick="location.href='{{ route('admin.product.create') }}'">+ Add</button>
            <div class="search-container ms-auto">
                <input type="search" id="productSearch" placeholder="Search" />
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" /></th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Total Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td><input type="checkbox" /></td>
                        <td><img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="product-image"
                                loading="lazy" /></td>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ number_format($product['price'], 0, ',', '.') }} </td>
                        <td>
                            @php
                                $totalStock = 0;
                                if (isset($product['stock'])) {
                                    $totalStock = array_sum($product['stock']);
                                }
                            @endphp
                            {{ $totalStock }}
                        </td>
                        <td>
                            <i class="bi bi-pencil action-icon" title="Edit"
                                onclick="location.href='{{ route('admin.product.edit', ['id' => $product['id']]) }}'"></i>
                            <form action="{{ route('admin.product.delete', ['id' => $product['id']]) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete?')"
                                    class="btn btn-link p-0 m-0">
                                    <i class="bi bi-trash action-icon" title="Delete"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="table-footer">
            <div>Showing {{ count($products) }} entries</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if (session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('productSearch');
            console.log('Search input:', searchInput);

            const table = document.querySelector('.product-list-container table tbody');
            console.log('Table tbody:', table);

            if (!searchInput || !table) return;

            const rows = table.querySelectorAll('tr');
            console.log('Number of rows:', rows.length);

            searchInput.addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                console.log('Filter:', filter);

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const match = Array.from(cells).some(td => td.textContent.toLowerCase()
                        .includes(filter));
                    row.style.display = match ? '' : 'none';
                });
            });
        });
    </script>
@endsection
