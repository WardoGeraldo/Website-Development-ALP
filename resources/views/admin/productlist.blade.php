@extends('base.base')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

    :root {
        --bg: #f8f9fa;
        --card: #ffffff;
        --text: #1f2937;
        --text-light: #6b7280;
        --border: #e5e7eb;
        --accent: #4f46e5;
        --accent-hover: #4338ca;
    }

    body.dark-mode {
        --bg: #121212;
        --card: #1e1e1e;
        --text: #f3f4f6;
        --text-light: #9ca3af;
        --border: #2d2d2d;
        --accent: #818cf8;
        --accent-hover: #6366f1;
    }

    body {
        background-color: var(--bg);
        color: var(--text);
        font-family: 'Inter', sans-serif;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .product-list-container {
        max-width: 1100px;
        margin: 40px auto;
        background: var(--card);
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    }

    .btn-add {
        background-color: var(--accent);
        color: white;
        font-weight: 500;
        border-radius: 8px;
        padding: 8px 16px;
        transition: background-color 0.3s ease;
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
}

tbody td {
    background-color: var(--card);
    color: var(--text);
    padding: 16px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
    word-wrap: break-word;
}

tbody tr:hover td {
    background-color: var(--hover);
}


    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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

    @media (max-width: 768px) {
        .top-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-container {
            width: 100%;
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
                    <td><img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="product-image" loading="lazy" /></td>
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
                        <form action="{{ route('admin.product.delete', ['id' => $product['id']]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-link p-0 m-0">
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('productSearch');
    const table = document.querySelector('.product-list-container table tbody');
    const rows = table ? table.querySelectorAll('tr') : [];

    if (!searchInput || !table) return;

    const emptyRow = document.createElement('tr');
    emptyRow.innerHTML = `<td colspan="6" class="text-center py-4 text-muted">No products found.</td>`;
    emptyRow.style.display = 'none';
    table.appendChild(emptyRow);

    searchInput.addEventListener('input', function () {
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
</script>
@endsection
