@extends('base.base')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

    :root {
        --bg: #f8fafc;
        --card-bg: #ffffff;
        --text: #1f2937;
        --text-muted: #6b7280;
        --header-bg: #111827;
        --hover: #f1f5f9;
        --badge-complete: #22c55e;
        --badge-pending: #facc15;
        --btn: #4f46e5;
        --btn-hover: #4338ca;
    }

    body.dark-mode {
        --bg: #121212;
        --card-bg: #1e1e1e;
        --text: #f3f4f6;
        --text-muted: #d1d5db;
        --header-bg: #2d2d2d;
        --hover: #2a2a2a;
        --badge-complete: #22c55e;
        --badge-pending: #facc15;
        --btn: #6366f1;
        --btn-hover: #818cf8;
    }

    body {
        background-color: var(--bg);
        color: var(--text);
        font-family: 'Inter', sans-serif;
    }

    .page-header {
        text-align: center;
        margin: 2rem 0 1rem;
    }

    .page-header h3 {
        font-size: 2rem;
        font-weight: 600;
        color: var(--text);
    }

    .page-header p {
        font-size: 1rem;
        color: var(--text-muted);
    }

    .card-table {
        background-color: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        padding: 2rem;
        transition: background 0.3s ease;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background-color: var(--header-bg);
    }

    thead th {
        color: #ffffff;
        padding: 1rem;
        text-align: center;
        font-weight: 500;
    }

    tbody td {
        padding: 1rem;
        text-align: center;
        color: var(--text);
        vertical-align: middle;
    }

    tbody tr:nth-child(odd) {
        background-color: transparent;
    }

    tbody tr:hover {
        background-color: var(--hover);
        transition: 0.3s ease;
    }

    .badge {
        padding: 0.4em 0.8em;
        font-size: 0.85rem;
        border-radius: 999px;
        font-weight: 600;
        display: inline-block;
    }

    .badge.completed {
        background-color: var(--badge-complete);
        color: white;
    }

    .badge.pending {
        background-color: var(--badge-pending);
        color: #1f2937;
    }

    .btn-view {
        background-color: var(--btn);
        color: #fff;
        border: none;
        padding: 0.5rem 1.2rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .btn-view:hover {
        background-color: var(--btn-hover);
        color: white;
    }

    @media (max-width: 768px) {
        .btn-view {
            width: 100%;
            margin-top: 0.5rem;
        }
    }
</style>

<div class="container py-4">
    <div class="page-header" data-aos="fade-up">
        <h3>Sales List</h3>
        <p>Monitor all your transactions at a glance</p>
    </div>

    <div class="card-table" data-aos="fade-up" data-aos-delay="100">
        <table>
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sales as $s)
                    <tr>
                        <td>{{ $s['id'] }}</td>
                        <td>{{ $s['transaction_date'] }}</td>
                        <td>Rp{{ number_format($s['total_price'], 0, ',', '.') }}</td>
                        <td>
                            @php
                                $statusClass = match($s['status']) {
                                    'completed' => 'badge completed',
                                    'pending' => 'badge pending',
                                    default => 'badge bg-secondary text-white'
                                };
                            @endphp
                            <span class="{{ $statusClass }}">{{ ucfirst($s['status']) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.invoice.index', ['sales_id' => $s['id']]) }}" class="btn-view">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted text-center py-4">No sales data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script>
    AOS.init();
</script>
@endsection
