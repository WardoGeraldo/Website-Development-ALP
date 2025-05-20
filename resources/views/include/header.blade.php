<style>
    :root {
        --nav-bg: #ffffff;
        --nav-text: #1f2937;
        --nav-hover: #4f46e5;
    }

    body.dark-mode {
        --nav-bg: #1e1e1e;
        --nav-text: #f3f4f6;
        --nav-hover: #a5b4fc;
    }

    .navbar,
    .secondary-nav {
        background-color: var(--nav-bg) !important;
        color: var(--nav-text);
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .navbar-brand,
    .nav-link,
    .secondary-nav a {
        color: var(--nav-text) !important;
        transition: color 0.3s ease;
    }

    .navbar-brand:hover,
    .nav-link:hover,
    .secondary-nav a:hover {
        color: var(--nav-hover) !important;
    }

    .form-control::placeholder {
        color: #999;
    }

    body.dark-mode .form-control {
        background-color: #2a2a2a;
        color: #f5f5f5;
        border-color: #444;
    }
    .dark-mode .size-chart-container {
    background-color: #121212;
    color: #f0f0f0;
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.05);
    }

    .dark-mode table {
        background-color: #1e1e1e;
        color: #eee;
    }

    .dark-mode table thead {
        background-color: #2a2a2a;
    }

    .dark-mode table th,
    .dark-mode table td {
        border-bottom: 1px solid #444;
    }

    .dark-mode table th {
        color: #ccc;
    }

    .dark-mode .back-button {
        color: #fff;
        background-color: #2a2a2a;
    }

    .dark-mode .back-button:hover {
        background-color: #3a3a3a;
    }


    body.dark-mode .form-control::placeholder {
        color: #aaa;
    }

    .secondary-nav {
        border-bottom: 1px solid #ddd;
    }

    body.dark-mode .secondary-nav {
        border-color: #333;
    }
</style>

<nav class="navbar navbar-expand-lg border-bottom shadow-sm py-3">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold fs-3" href="#">VERAVIA</a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            @if(session('role') == 'user')
                <form class="d-flex mx-auto w-50" onsubmit="filterProductsBySearch(event)">
                    <input id="searchInput" class="form-control rounded-pill ps-3" type="search"
                        placeholder="Cari produk, tren, dan merek." aria-label="Search">
                    <button class="btn position-absolute end-0 me-2 mt-1" type="submit">
                        {{-- <i class="fas fa-search"></i> --}}
                    </button>
                </form>
            @endif

            <!-- Right Icons -->
            <ul class="navbar-nav ms-auto align-items-center">
                @if(session('user'))
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">
                            <i class="fas fa-user me-1"></i> {{ session('user') }}
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                @else
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('login.show') }}">
                            <i class="fas fa-user me-1"></i> Masuk / Daftar
                        </a>
                    </li>
                @endif

                @if(session('role') == 'user')
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('wishlist.show') }}"><i class="far fa-heart"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}"><i class="fas fa-shopping-bag"></i></a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@if(session('role') == 'user')
    <nav class="secondary-nav py-2">
        <div class="container d-flex gap-4 fw-semibold small">
            <a href="{{ route('home') }}" class="text-decoration-none">Home</a>
            <a href="{{ route('store.show') }}" class="text-decoration-none">Store</a>
            <a href="{{ route('size.chart') }}" class="text-decoration-none">Size Chart</a>
            <a href="{{ route('order.history') }}" class="text-decoration-none">My Orders</a>
            <a href="{{ route('contact.show') }}" class="text-decoration-none">Contact</a>
            <a href="{{ route('support.show') }}" class="text-decoration-none">Support</a>
        </div>
    </nav>
@elseif(session('role') == 'admin')
    <nav class="secondary-nav py-2">
        <div class="container d-flex gap-4 fw-semibold small">
            <a href="{{ route('admin.dash') }}" class="text-decoration-none">Dashboard</a>
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Products List</a>
            <a href="{{ route('admin.userlist') }}" class="text-decoration-none">Users List</a>
            <a href="{{ route('admin.sales.index') }}" class="text-decoration-none">Sales List</a>
            <a href="{{ route('admin.promo.list') }}" class="text-decoration-none">Promo List</a>
        </div>
    </nav>
@endif

<script>
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
    }
</script>
