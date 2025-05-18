<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm py-3">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold fs-3" href="#">VERAVIA</a>

        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <!-- Search bar (centered) -->
            <form class="d-flex mx-auto w-50" onsubmit="filterProductsBySearch(event)">
                <input id="searchInput" class="form-control rounded-pill ps-3" type="search"
                    placeholder="Cari produk, tren, dan merek." aria-label="Search">
                <button class="btn position-absolute end-0 me-2 mt-1" type="submit">
                    {{-- <i class="fas fa-search"></i> --}}
                </button>
            </form>

            <!-- Icons (right side) -->
            <ul class="navbar-nav ms-auto align-items-center">
                @if (session('user'))
                    <!-- Cek apakah ada user yang login -->
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
                <li class="nav-item me-3">
                    <a class="nav-link" href="{{ route('wishlist.show') }}"><i class="far fa-heart"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.index') }}"><i class="fas fa-shopping-bag"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@if (session('role') == 'user')
    <!-- Category Menu -->
    <nav class="bg-white border-bottom">
        <div class="container py-2 d-flex gap-4 fw-semibold small">
            <a href="{{ route('home') }}" class="text-dark text-decoration-none">Home</a>
            <a href="{{ route('store.show') }}" class="text-dark text-decoration-none">Store</a>
            {{-- <a href="#" class="text-dark text-decoration-none">T-Shirt</a>
            <a href="#" class="text-dark text-decoration-none">Shirt</a>
            <a href="#" class="text-dark text-decoration-none">Sports</a>
            <a href="#" class="text-dark text-decoration-none">Dress</a>
            <a href="#" class="text-dark text-decoration-none">Home & Lifestyle</a> --}}
            <a href="#" class="text-dark text-decoration-none">My Orders</a>
            <a href="#" class="text-dark text-decoration-none">Contact</a>
            <a href="{{ route('support.show') }}" class="text-dark text-decoration-none">Support</a>

        </div>
    </nav>

@else
<nav class="bg-white border-bottom">
        <div class="container py-2 d-flex gap-4 fw-semibold small">
            <a href="{{ route('admin.dashboard') }}" class="text-dark text-decoration-none">Products List</a>
            <a href="{{ route('admin.userlist') }}" class="text-dark text-decoration-none">Users List</a>
            <a href="{{ route('admin.sales.index') }}" class="text-dark text-decoration-none">Sales List</a>
            <a href="{{ route('admin.promo.list') }}" class="text-dark text-decoration-none">Promo List</a>
        </div>
    </nav>
@endif

