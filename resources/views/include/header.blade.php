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

    .secondary-nav {
        border-bottom: 1px solid #ddd;
    }

    body.dark-mode .secondary-nav {
        border-color: #333;
    }

    @media (max-width: 768px) {
        .search-wrapper {
            width: 100%;
        }

        .navbar-collapse {
            flex-direction: column;
            align-items: stretch;
        }
    }

    .navbar-nav {
        width: 100%;
        margin-top: 1rem;
    }

    .navbar-nav li {
        text-align: center;
    }

    form {
        width: 100%;
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler-icon {
        background-image: var(--toggler-icon);
    }

    body.dark-mode {
        --toggler-icon: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='white' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    body:not(.dark-mode) {
        --toggler-icon: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='black' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }
</style>

@php
    $user = session('user'); // Ambil dari session
@endphp

<nav class="navbar navbar-expand-lg border-bottom shadow-sm py-3">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold fs-3" href="#">VERAVIA</a>

        <!-- Dark Mode Toggle -->
        <button class="btn btn-sm rounded-circle ms-auto me-2 d-lg-none" onclick="toggleDarkMode()"
            aria-label="Toggle dark mode">
            ☀️
        </button>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible Content -->
        <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarMain">
            <!-- Search Bar -->
            @if (session('user_role') === 'customer')
                <form class="d-flex w-100 my-2 my-lg-0 search-wrapper" onsubmit="filterProductsBySearch(event)">
                    <input id="searchInput" class="form-control rounded-pill ps-3 me-2" type="search"
                        placeholder="Cari produk, tren, dan merek." aria-label="Search">
                    <button class="btn btn-outline-secondary rounded-circle" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            @endif

            <!-- Right Side Icons -->
            <ul class="navbar-nav ms-auto align-items-center mt-3 mt-lg-0">
                @if (session()->has('user_id'))
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">
                            <i class="fas fa-user me-1"></i>
                            {{ $user->name ?? $user->email }}
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                @else
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-user me-1"></i> Masuk / Daftar
                        </a>
                    </li>
                @endif

                @if (session()->has('user_id') && session('user_role') === 'customer')
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('wishlist.show') }}">
                            <i class="far fa-heart"></i>
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-bag"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@if (session('user_role') === 'customer')
    <nav class="secondary-nav py-2">
        <div class="container d-flex flex-wrap gap-3 fw-semibold small">
            <a href="{{ route('home') }}" class="text-decoration-none">Home</a>
            <a href="{{ route('store.show') }}" class="text-decoration-none">Store</a>
            <a href="{{ route('size.chart') }}" class="text-decoration-none">Size Chart</a>
            <a href="{{ route('order.history') }}" class="text-decoration-none">My Orders</a>
            <a href="{{ route('contact.index') }}" class="text-decoration-none">Contact</a>
            <a href="{{ route('support.show') }}" class="text-decoration-none">Support</a>
        </div>
    </nav>
@elseif (session('user_role') === 'admin')
    <nav class="secondary-nav py-2">
        <div class="container d-flex flex-wrap gap-3 fw-semibold small">
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
