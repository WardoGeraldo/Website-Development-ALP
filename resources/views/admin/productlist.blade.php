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

        /* Badges */
        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 9px;
            margin-right: 5px;
            border-radius: 12px;
            user-select: none;
            text-transform: capitalize;
        }

        .badge-pending {
            background-color: #fbbf24;
            color: #78350f;
        }

        .badge-active {
            background-color: #4ade80;
            color: #166534;
        }

        .badge-inactive {
            background-color: #cbd5e1;
            color: #475569;
        }

        .badge-create {
            background-color: #60a5fa;
            color: white;
        }

        .badge-read {
            background-color: #93c5fd;
            color: #1e40af;
        }

        .badge-edit {
            background-color: #f87171;
            color: white;
        }

        .badge-delete {
            background-color: #ef4444;
            color: white;
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
                <input type="search" placeholder="Search" />
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" /></th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Permissions</th>
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
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="statusSwitch{{ $product['id'] }}"
                                    @if (isset($product['status']) && $product['status']) checked @endif>
                            </div>
                        </td>
                        <td>
                            @if (isset($product['permissions']))
                                @foreach ($product['permissions'] as $perm)
                                    @php
                                        $permClass = match (strtolower($perm)) {
                                            'pending' => 'badge-pending',
                                            'active' => 'badge-active',
                                            'inactive' => 'badge-inactive',
                                            'create' => 'badge-create',
                                            'read' => 'badge-read',
                                            'edit' => 'badge-edit',
                                            'delete' => 'badge-delete',
                                            default => 'badge-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $permClass }}">{{ $perm }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <i class="bi bi-pencil action-icon" title="Edit"
                                onclick="location.href='{{ route('admin.product.edit', ['id' => $product['id']]) }}'"></i>
                            <i class="bi bi-trash action-icon" title="Delete"
                                onclick="if(confirm('Are you sure you want to delete?')) location.href='{{ route('admin.product.delete', ['id' => $product['id']]) }}'"></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="table-footer">
            <div>Showing {{ count($products) }} entries</div>
            <div>
                <!-- Pagination placeholder -->
                <button class="btn btn-sm btn-light">1</button>
                <button class="btn btn-sm btn-light">2</button>
                <button class="btn btn-sm btn-light">3</button>
                <button class="btn btn-sm btn-light">4</button>
                <button class="btn btn-sm btn-light">11</button>
                <button class="btn btn-sm btn-light">12</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if (session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif

    <script>
        AOS.init();

        document.addEventListener('DOMContentLoaded', () => {
            const toggleButton = document.querySelector('.dark-mode-toggle');
            if (!toggleButton) return; // Safety check

            // Load saved dark mode preference
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.body.classList.add('dark-mode');
                toggleButton.textContent = '☀️'; // Sun icon
            }

            toggleButton.addEventListener('click', () => {
                document.body.classList.toggle('dark-mode');

                if (document.body.classList.contains('dark-mode')) {
                    localStorage.setItem('darkMode', 'enabled');
                    toggleButton.textContent = '☀️'; // Sun icon for dark mode
                } else {
                    localStorage.setItem('darkMode', 'disabled');
                    toggleButton.textContent = '🌙'; // Moon icon for light mode
                }
            });
        });
    </script>
@endsection
