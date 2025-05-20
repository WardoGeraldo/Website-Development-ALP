@extends('base.base')
@section('content')
<div class="dashboard-container">
    <!-- Header Section -->
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <div class="header-controls">
            <div class="date-display">
                <i class="bi bi-calendar3"></i>
                <span id="current-date"></span>
            </div>
        </div>
    </div>
<!-- Stats Cards Section -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            🛒
        </div>
        <div class="stat-content">
            <h3>{{ $totalProducts }}</h3>
            <p>Products</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            👤
        </div>
        <div class="stat-content">
            <h3>{{ $totalUsers }}</h3>
            <p>Users</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            💰
        </div>
        <div class="stat-content">
            <h3>Rp {{ number_format($totalSales) }}</h3>
            <p>Total Sales</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            📈
        </div>
        <div class="stat-content">
            <h3>Rp {{ number_format($todayRevenue) }}</h3>
            <p>Today's Revenue</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            💵
        </div>
        <div class="stat-content">
            <h3>Rp {{ number_format($weekRevenue) }}</h3>
            <p>This Week</p>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="charts-container">
    <div class="chart-card">
        <div class="chart-header">
            <h2>Sales Trend</h2>
            <div class="chart-legend">
                <span class="legend-indicator"></span>
                <span>Monthly</span>
            </div>
        </div>
        <div class="chart-body">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
    
    <div class="chart-card">
        <div class="chart-header">
            <h2>Product Categories</h2>
            <div class="chart-legend">
                <span>Distribution</span>
            </div>
        </div>
        <div class="chart-body">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</div>

<!-- Top Products Section -->
<div class="data-card">
    <div class="data-header">
        <h2>Top 5 Selling Products</h2>
        {{-- <span class="view-all">View All</span> --}}
    </div>
    <div class="data-body">
        <table class="luxury-table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Product</th>
                    <th>Sold</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topProducts as $index => $product)
                <tr>
                    <td><span class="rank-badge">{{ $index + 1 }}</span></td>
                    <td>{{ $product['name'] }}</td>
                    <td><span class="highlight">{{ $product['sold'] }}</span></td>
                    <td>{{ array_sum($product['stock']) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Top Customers Section -->
<div class="data-card">
    <div class="data-header">
        <h2>Top Customers</h2>
        {{-- <span class="view-all">View All</span> --}}
    </div>
    <div class="data-body">
        <ul class="customer-list">
            @foreach ($topCustomers as $index => $customer)
            <li class="customer-item">
                <div class="customer-info">
                    <span class="customer-rank">{{ $index + 1 }}</span>
                    <span class="customer-name">{{ $customer['name'] }}</span>
                </div>
                <span class="customer-spent">Rp {{ number_format($customer['totalSpent']) }}</span>
            </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Quick Actions Section -->
<div class="actions-container">
    <h2>Quick Actions</h2>
    <div class="action-buttons">
        <a href="{{ route('admin.product.create') }}" class="action-btn">
            <i class="bi bi-plus-circle"></i>
            <span>Add Product</span>
        </a>
        <a href="{{ route('admin.userlist') }}" class="action-btn">
            <i class="bi bi-person-lines-fill"></i>
            <span>Manage Users</span>
        </a>
        <a href="{{ route('admin.sales.index') }}" class="action-btn">
            <i class="bi bi-bar-chart-line"></i>
            <span>Sales Report</span>
        </a>
        <a href="{{ route('admin.promo.list') }}" class="action-btn">
            <i class="bi bi-tags"></i>
            <span>Promo Settings</span>
        </a>
    </div>
</div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Set current date
    document.getElementById('current-date').textContent = new Date().toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
// Function to update theme colors for charts based on the base.blade.php dark mode state
function updateChartTheme() {
    const isDark = document.body.classList.contains('dark-mode');
    return {
        gridColor: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(200, 200, 200, 0.1)',
        textColor: isDark ? '#c5c5c5' : '#666',
        pointBorderColor: isDark ? '#1e1e1e' : '#fff'
    };
}

// Get theme colors
const themeColors = updateChartTheme();

// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesData = {
    labels: {!! json_encode($salesMonths) !!},
    datasets: [{
        label: 'Sales',
        data: {!! json_encode($salesData) !!},
        fill: true,
        borderColor: '#896CFF',
        backgroundColor: 'rgba(137, 108, 255, 0.1)',
        tension: 0.4,
        pointRadius: 6,
        pointBackgroundColor: '#896CFF',
        pointBorderColor: themeColors.pointBorderColor,
        pointBorderWidth: 2
    }]
};

const salesChart = new Chart(salesCtx, {
    type: 'line',
    data: salesData,
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: themeColors.gridColor
                },
                ticks: {
                    color: themeColors.textColor,
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString();
                    }
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: themeColors.textColor
                }
            }
        }
    }
});

// Category Chart
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
const categoryData = {
    labels: {!! json_encode($categoryLabels) !!},
    datasets: [{
        label: 'Categories',
        data: {!! json_encode($categoryData) !!},
        backgroundColor: ['#896CFF', '#52B69A', '#FFC94D', '#FF7373', '#76B7C7'],
        borderWidth: 0,
        borderRadius: 5,
        spacing: 10,
        hoverOffset: 15
    }]
};

const categoryChart = new Chart(categoryCtx, {
    type: 'doughnut',
    data: categoryData,
    options: {
        responsive: true,
        cutout: '70%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 12,
                    padding: 15,
                    color: themeColors.textColor
                }
            }
        }
    }
});

// Listen for dark mode changes from base.blade.php
const darkModeObserver = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
            // Update chart colors when dark mode changes
            const updatedColors = updateChartTheme();
            
            // Update sales chart
            salesChart.options.scales.y.grid.color = updatedColors.gridColor;
            salesChart.options.scales.y.ticks.color = updatedColors.textColor;
            salesChart.options.scales.x.ticks.color = updatedColors.textColor;
            salesChart.data.datasets[0].pointBorderColor = updatedColors.pointBorderColor;
            salesChart.update();
            
            // Update category chart
            categoryChart.options.plugins.legend.labels.color = updatedColors.textColor;
            categoryChart.update();
        }
    });
});

// Start observing the document body for class changes
darkModeObserver.observe(document.body, { attributes: true });
</script>
<style>
    /* Base Styles with Dark Mode Support */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Basic layout styles */
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* Header Styles */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    body.dark-mode .dashboard-header {
        border-bottom-color: rgba(255,255,255,0.1);
    }

    .dashboard-header h1 {
        font-size: 2rem;
        font-weight: 600;
        position: relative;
        color: #333;
    }

    body.dark-mode .dashboard-header h1 {
        color: #f5f5f5;
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
        color: #777;
        gap: 0.5rem;
    }

    body.dark-mode .date-display {
        color: #c5c5c5;
    }

    /* Cards & Containers */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card, .chart-card, .data-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    body.dark-mode .stat-card,
    body.dark-mode .chart-card,
    body.dark-mode .data-card {
        background: #1e1e1e;
        border-color: rgba(255,255,255,0.1);
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }

    .stat-card:hover, .chart-card:hover, .data-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        border-color: rgba(137, 108, 255, 0.2);
    }

    body.dark-mode .stat-card:hover,
    body.dark-mode .chart-card:hover,
    body.dark-mode .data-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }

    .stat-card {
        display: flex;
        align-items: center;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(137, 108, 255, 0.1);
        margin-right: 1rem;
    }

    body.dark-mode .stat-icon {
        background: rgba(137, 108, 255, 0.2);
    }

    .stat-content h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.2rem;
        color: #333;
    }

    body.dark-mode .stat-content h3 {
        color: #f1f1f1;
    }

    .stat-content p {
        font-size: 0.85rem;
        color: #777;
        margin: 0;
    }

    body.dark-mode .stat-content p {
        color: #c5c5c5;
    }

    /* Charts Container */
    .charts-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .chart-header, .data-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .chart-header h2, .data-header h2, .actions-container h2 {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
    }

    body.dark-mode .chart-header h2,
    body.dark-mode .data-header h2,
    body.dark-mode .actions-container h2 {
        color: #f1f1f1;
    }

    .chart-legend {
        display: flex;
        align-items: center;
        font-size: 0.85rem;
        color: #777;
    }

    body.dark-mode .chart-legend {
        color: #c5c5c5;
    }

    .legend-indicator {
        display: inline-block;
        width: 10px;
        height: 10px;
        background: #896CFF;
        margin-right: 0.5rem;
        border-radius: 50%;
    }

    .chart-body {
        height: 300px;
        position: relative;
    }

    .view-all {
        font-size: 0.85rem;
        color: #896CFF;
        cursor: pointer;
    }

    body.dark-mode .view-all {
        color: #a58bff;
    }

    .view-all:hover {
        opacity: 0.8;
        text-decoration: underline;
    }

    /* Table Styles */
    .luxury-table {
        width: 100%;
        border-collapse: collapse;
    }

    .luxury-table thead tr {
        background-color: rgba(0,0,0,0.02);
        border-radius: 8px;
    }

    body.dark-mode .luxury-table thead tr {
        background-color: rgba(255,255,255,0.05);
    }

    .luxury-table th {
        text-align: left;
        padding: 1rem;
        font-size: 0.9rem;
        font-weight: 500;
        color: #777;
    }

    body.dark-mode .luxury-table th {
        color: #c5c5c5;
    }

    .luxury-table td {
        padding: 1rem;
        font-size: 0.95rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        color: #333;
    }

    body.dark-mode .luxury-table td {
        color: #f1f1f1;
        border-bottom-color: rgba(255,255,255,0.1);
    }

    .rank-badge, .customer-rank {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(137, 108, 255, 0.1);
        color: #896CFF;
        font-weight: 600;
        font-size: 0.85rem;
    }

    body.dark-mode .rank-badge,
    body.dark-mode .customer-rank {
        background: rgba(137, 108, 255, 0.2);
        color: #a58bff;
    }

    .highlight {
        font-weight: 600;
        color: #333;
    }

    body.dark-mode .highlight {
        color: #f1f1f1;
    }

    /* Customer List */
    .customer-list {
        list-style: none;
        padding: 0;
    }

    .customer-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    body.dark-mode .customer-item {
        border-bottom-color: rgba(255,255,255,0.1);
    }

    .customer-info {
        display: flex;
        align-items: center;
    }

    .customer-rank {
        margin-right: 1rem;
    }

    .customer-name {
        font-weight: 500;
        color: #333;
    }

    body.dark-mode .customer-name {
        color: #f1f1f1;
    }

    .customer-spent {
        font-weight: 600;
        color: #896CFF;
    }

    body.dark-mode .customer-spent {
        color: #a58bff;
    }

    /* Action Buttons */
    .actions-container {
        margin-top: 2rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .action-btn {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid rgba(0,0,0,0.05);
        padding: 0.8rem 1.2rem;
        border-radius: 50px;
        color: #333;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    body.dark-mode .action-btn {
        background: #1e1e1e;
        border-color: rgba(255,255,255,0.1);
        color: #f1f1f1;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .action-btn:hover {
        background: #896CFF;
        color: #fff;
        transform: translateY(-3px);
    }

    .action-btn i {
        margin-right: 0.5rem;
        font-size: 1.1rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 1200px) {
        .charts-container {
            grid-template-columns: 1fr;
        }
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
        
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }
        
        .stat-card {
            flex-direction: column;
            text-align: center;
        }
        
        .stat-icon {
            margin-right: 0;
            margin-bottom: 1rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .action-btn {
            width: 100%;
        }
    }
</style>
@endsection