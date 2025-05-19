@extends('base.base')

@section('content')
    <div class="container py-5">
        <h1 class="fw-bold mb-4">Admin Dashboard</h1>

        <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam fs-2 text-primary"></i>
                        <div class="fw-semibold small text-muted">Products</div>
                        <div class="fs-4 fw-bold">{{ $totalProducts }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-people fs-2 text-success"></i>
                        <div class="fw-semibold small text-muted">Users</div>
                        <div class="fs-4 fw-bold">{{ $totalUsers }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-currency-dollar fs-2 text-warning"></i>
                        <div class="fw-semibold small text-muted">Total Sales</div>
                        <div class="fs-4 fw-bold">{{ $totalSales }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-cash-coin fs-2 text-dark"></i>
                        <div class="fw-semibold small text-muted">Today Revenue</div>
                        <div class="fs-5 fw-bold">Rp {{ number_format($todayRevenue) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-week fs-2 text-info"></i>
                        <div class="fw-semibold small text-muted">This Week</div>
                        <div class="fs-5 fw-bold">Rp {{ number_format($weekRevenue) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header fw-semibold">Sales Trend (Monthly)</div>
                    <div class="card-body">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header fw-semibold">Product Category Distribution</div>
                    <div class="card-body">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Best Selling Products -->
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold">Top Selling Products</div>
            <div class="card-body">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Sold</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topProducts as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product['name'] }}</td>
                                <td>{{ $product['sold'] }}</td>
                                <td>{{ array_sum($product['stock']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Customers -->
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold">Top Customers</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach ($topCustomers as $customer)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $customer['name'] }}</span>
                            <span class="fw-bold">Rp {{ number_format($customer['totalSpent']) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-5">
            <h5 class="mb-3 fw-semibold">Quick Actions</h5>
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('admin.product.create') }}" class="btn btn-outline-dark rounded-pill">
                    <i class="bi bi-plus-circle me-1"></i> Add Product
                </a>
                <a href="{{ route('admin.userlist') }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="bi bi-person-lines-fill me-1"></i> Manage Users
                </a>
                <a href="{{ route('admin.sales.index') }}" class="btn btn-outline-primary rounded-pill">
                    <i class="bi bi-bar-chart-line me-1"></i> Sales Report
                </a>
                <a href="{{ route('admin.promo.list') }}" class="btn btn-outline-danger rounded-pill">
                    <i class="bi bi-tags me-1"></i> Promo Settings
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const salesChart = new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($salesMonths) !!},
                datasets: [{
                    label: 'Sales',
                    data: {!! json_encode($salesData) !!},
                    fill: true,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        const categoryChart = new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($categoryLabels) !!},
                datasets: [{
                    label: 'Categories',
                    data: {!! json_encode($categoryData) !!},
                    backgroundColor: ['#60a5fa', '#f87171', '#34d399', '#fbbf24', '#a78bfa'],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#666' }
                    }
                }
            }
        });
    </script>
@endsection
