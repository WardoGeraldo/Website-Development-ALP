@extends('base.base')

@section('content')
    <div class="dashboard-container">
        <!-- Header Section -->
        <div class="dashboard-header">
            <h1>Admin - Product List</h1>
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

        <!-- Original Product List Content -->
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
                            <td><img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="product-image"
                                    loading="lazy" /></td>
                            <td>{{ $product['name'] }}</td>
                            <td>Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $totalStock = isset($product['stock']) ? array_sum($product['stock']) : 0;
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
                                    <button type="submit" class="btn btn-link p-0 m-0 show-confirm">
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
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

        /* Light Mode Variables (Default) */
        :root {
            --bg: #f8f9fa;
            --card: #ffffff;
            --text: #212529;
            --text-light: #6c757d;
            --border: #dee2e6;
            --accent: #6366f1;
            --accent-hover: #4f46e5;
            --hover-bg: rgba(0, 0, 0, 0.05);
        }

        /* Dark Mode Variables */
        body.dark-mode {
            --bg: #121212;
            --card: #1e1e1e;
            --text: #f3f4f6;
            --text-light: #9ca3af;
            --border: #2d2d2d;
            --accent: #818cf8;
            --accent-hover: #6366f1;
            --hover-bg: rgba(255, 255, 255, 0.05);
        }

        /* Apply theme variables to elements */
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--bg);
            color: var(--text);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .dashboard-header h1 {
            font-size: 2rem;
            font-weight: 600;
            color: var(--text);
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
            color: var(--text-light);
            gap: 0.5rem;
        }

        /* Product List Styles */
        .product-list-container {
            max-width: 1100px;
            margin: 40px auto;
            background: var(--card);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        body.dark-mode .product-list-container {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .btn-add {
            background-color: var(--accent);
            color: white;
            font-weight: 500;
            border-radius: 8px;
            padding: 8px 16px;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-add:hover {
            background-color: var(--accent-hover);
        }

        .search-container input {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background-color: var(--card);
            color: var(--text);
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .search-container input:focus {
            outline: none;
            border-color: var(--accent);
        }

        .search-container input::placeholder {
            color: var(--text-light);
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        thead th {
            background-color: var(--card);
            color: var(--text-light);
            font-weight: 600;
            padding: 16px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        tbody td {
            background-color: var(--card);
            color: var(--text);
            padding: 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            word-wrap: break-word;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        tbody tr:hover td {
            background-color: var(--hover-bg);
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        body.dark-mode .product-image {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        .action-icon {
            color: var(--text-light);
            font-size: 1.2rem;
            margin-left: 10px;
            cursor: pointer;
            transition: color 0.3s, transform 0.2s;
        }

        .action-icon:hover {
            color: #ef4444;
            transform: scale(1.1);
        }

        .table-footer {
            margin-top: 16px;
            font-size: 0.875rem;
            color: var(--text-light);
            text-align: right;
        }

        /* Bootstrap alert styling for theme */
        .alert-success {
            background-color: var(--card);
            border-color: var(--border);
            color: var(--text);
        }

        /* Button styling for delete form */
        .btn-link {
            background: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

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

            .top-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-container {
                width: 100%;
            }

            .dashboard-container {
                padding: 1rem;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.show-confirm').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Product will be deleted permanently!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('productSearch');
            const table = document.querySelector('.product-list-container table tbody');
            const rows = table ? table.querySelectorAll('tr') : [];

            if (!searchInput || !table) return;

            const emptyRow = document.createElement('tr');
            emptyRow.innerHTML = `<td colspan="5" class="text-center py-4 text-muted">No products found.</td>`;
            emptyRow.style.display = 'none';
            table.appendChild(emptyRow);

            searchInput.addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                let visibleCount = 0;

                rows.forEach(row => {
                    const match = [...row.querySelectorAll('td')].some(td =>
                        td.textContent.toLowerCase().includes(filter)
                    );
                    row.style.display = match ? '' : 'none';
                    if (match) visibleCount++;
                });

                emptyRow.style.display = visibleCount === 0 ? '' : 'none';
            });
        });

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
@endsection
