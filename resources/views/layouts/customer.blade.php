<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Akun Saya - Toko Tanaman Hias')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')

    <style>
        :root {
            --sidebar-bg: #2D6A4F;
            --sidebar-hover: rgba(255, 255, 255, 0.15);
            --sidebar-active: #1B4332;
            --sidebar-text: rgba(255, 255, 255, 0.85);
            --sidebar-text-active: #FFFFFF;
            --header-bg: rgba(255, 255, 255, 0.9);
            --content-bg: #F4F7F6;
        }

        body {
            background-color: var(--content-bg);
            color: #2D3142;
            overflow-x: hidden;
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease, visibility 0.25s ease;
            z-index: 1040;
        }

        .sidebar-overlay.open {
            opacity: 1;
            visibility: visible;
        }

        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 260px;
            background: var(--sidebar-bg);
            z-index: 1050;
            padding: 0;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .admin-sidebar.open {
            transform: translateX(0);
        }

        .sidebar-brand-wrapper {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            margin-bottom: 24px;
        }

        .sidebar-brand-wrapper a {
            color: #FFFFFF !important;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .nav-pills .nav-link {
            color: var(--sidebar-text) !important;
            border-radius: 12px;
            padding: 12px 18px;
            margin: 4px 16px;
            font-weight: 500;
            font-size: 0.92rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.25s ease;
        }

        .nav-pills .nav-link i {
            font-size: 1.1rem;
            transition: transform 0.25s ease;
        }

        .nav-pills .nav-link:hover {
            background-color: var(--sidebar-hover) !important;
            color: var(--sidebar-text-active) !important;
        }

        .nav-pills .nav-link:hover i {
            transform: translateX(3px);
        }

        .nav-pills .nav-link.active {
            background-color: var(--sidebar-active) !important;
            color: var(--sidebar-text-active) !important;
            box-shadow: 0 4px 15px rgba(27, 67, 50, 0.3);
            font-weight: 600;
        }

        .sidebar-divider {
            color: rgba(255, 255, 255, 0.4) !important;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 16px 16px 8px 32px;
            margin: 12px 0 4px;
        }

        .admin-header {
            background: var(--header-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 16px 32px;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .admin-content {
            background-color: var(--content-bg);
            min-height: 100vh;
            padding-left: 0;
            transition: padding-left 0.3s ease;
        }

        .sidebar-toggle-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: #FFFFFF;
            color: #2D3142;
        }

        .admin-sidebar .sidebar-close-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: none;
            background: rgba(255, 255, 255, 0.08);
            color: #FFFFFF;
        }

        /* Profile Dropdown Badge */
        .profile-badge {
            background: linear-gradient(135deg, #52B788, #2D6A4F);
            box-shadow: 0 2px 8px rgba(45, 106, 79, 0.15);
            font-weight: 700;
        }

        .admin-header .dropdown-toggle::after {
            display: none;
        }

        @media(min-width: 992px) {
            .admin-sidebar {
                transform: translateX(0);
            }

            .sidebar-overlay {
                display: none;
            }

            .admin-content {
                padding-left: 260px;
            }
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="admin-sidebar" id="sidebar">
    <div class="d-flex align-items-center justify-content-between px-3 pt-3">
        <div class="sidebar-brand-wrapper">
            <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-flower1 text-white fs-3"></i>
                <span>Toko Tanaman</span>
            </a>
        </div>
        <button class="sidebar-close-btn d-lg-none me-3" id="sidebarClose"><i class="bi bi-x-lg"></i></button>
    </div>

    <div>
        <ul class="nav nav-pills flex-column">
            {{-- Beranda & Katalog --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="bi bi-house-door"></i> Beranda Toko
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/#katalog') }}">
                    <i class="bi bi-flower2"></i> Katalog Tanaman
                </a>
            </li>

            <li class="sidebar-divider">Menu Akun Saya</li>
            
            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
            </li>

            {{-- Keranjang Belanja --}}
            <li class="nav-item">
                @php $cartCount = count(session('cart', [])); @endphp
                <a class="nav-link d-flex align-items-center justify-content-between {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                    <span><i class="bi bi-cart3"></i> Keranjang</span>
                    @if($cartCount > 0)
                    <span class="badge bg-danger rounded-pill" style="font-size: 0.7rem; padding: 3px 6px;">{{ $cartCount }}</span>
                    @endif
                </a>
            </li>

            {{-- Checkout --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('checkout.*') ? 'active' : '' }}" href="{{ route('checkout.index') }}">
                    <i class="bi bi-credit-card-2-front"></i> Checkout
                </a>
            </li>

            {{-- Riwayat Pesanan / Invoice --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customer.orders.*') ? 'active' : '' }}" href="{{ route('customer.orders.index') }}">
                    <i class="bi bi-receipt"></i> Riwayat & Invoice
                </a>
            </li>

            {{-- Profil Akun --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                    <i class="bi bi-person-fill"></i> Profil Akun
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="admin-content">
    <!-- Header -->
    <header class="admin-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle-btn d-lg-none" id="sidebarToggle"><i class="bi bi-list fs-5"></i></button>
            <h5 class="fw-bold mb-0">@yield('page_title', 'Dashboard Pelanggan')</h5>
        </div>
        
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle" data-bs-toggle="dropdown">
                <div class="profile-badge text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px;">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <span class="fw-semibold d-none d-md-block" style="font-size: 0.95rem; color: #2D3142;">{{ Auth::user()->name }}</span>
                <i class="bi bi-chevron-down ms-2 d-none d-md-block text-muted" style="font-size: 0.8rem;"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3 py-2" style="border-radius: 12px; min-width: 180px;">
                @if(Auth::user()->role == 'admin')
                    <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i class="bi bi-shield-check me-2 text-muted"></i>Panel Admin</a></li>
                @endif
                <li><a class="dropdown-item py-2" href="{{ route('profile') }}"><i class="bi bi-person me-2 text-muted"></i>Profil Saya</a></li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger py-2"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <!-- Content -->
    <div class="p-4 p-md-5">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 alert-dismissible fade show">
                <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var sidebar = document.getElementById('sidebar');
        var sidebarOverlay = document.getElementById('sidebarOverlay');
        var sidebarToggle = document.getElementById('sidebarToggle');
        var sidebarClose = document.getElementById('sidebarClose');

        function closeSidebar() {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('open');
        }

        function openSidebar() {
            sidebar.classList.add('open');
            sidebarOverlay.classList.add('open');
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function () {
                openSidebar();
            });
        }

        if (sidebarClose) {
            sidebarClose.addEventListener('click', function () {
                closeSidebar();
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function () {
                closeSidebar();
            });
        }
    });
</script>
</body>
</html>
