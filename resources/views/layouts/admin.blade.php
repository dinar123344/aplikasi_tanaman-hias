<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Toko Tanaman Hias')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')

    <style>
        :root {
            --sidebar-bg: #1B4332; /* Deep Forest Green */
            --sidebar-hover: rgba(82, 183, 136, 0.15);
            --sidebar-active: #2D6A4F;
            --sidebar-text: rgba(255, 255, 255, 0.7);
            --sidebar-text-active: #FFFFFF;
            --header-bg: rgba(255, 255, 255, 0.9);
            --content-bg: #F4F7F6;
        }

        body {
            background-color: var(--content-bg);
            color: #2D3142;
        }

        .admin-sidebar {
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 0;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
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
            box-shadow: 0 4px 15px rgba(27, 67, 50, 0.4);
            font-weight: 600;
        }

        .sidebar-divider {
            color: rgba(255, 255, 255, 0.3) !important;
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
        }

        /* Profile Dropdown Badge */
        .profile-badge {
            background: linear-gradient(135deg, #40916C, #2D6A4F);
            box-shadow: 0 2px 8px rgba(45, 106, 79, 0.2);
            font-weight: 700;
        }

        .admin-header .dropdown-toggle::after {
            display: none;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- Sidebar -->
        <div class="col-md-2 admin-sidebar d-none d-md-block">
            <div class="sidebar-brand-wrapper text-center">
                <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-flower1 text-success fs-3"></i>
                    <span>Tanaman Hias</span>
                </a>
            </div>
            
            <div>
                <ul class="nav nav-pills flex-column">
                    {{-- Dashboard --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid-1x2-fill"></i> Dashboard
                        </a>
                    </li>

                    {{-- Master Data (Collapsible) --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center justify-content-between {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                           data-bs-toggle="collapse" href="#masterDataMenu" role="button" aria-expanded="{{ request()->routeIs('admin.categories.*') ? 'true' : 'false' }}">
                            <span><i class="bi bi-folder-fill me-2"></i> Master Data</span>
                            <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.categories.*') ? 'show' : '' }}" id="masterDataMenu">
                            <ul class="nav flex-column ps-4">
                                <li class="nav-item">
                                    <a class="nav-link py-1.5 {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                                        <i class="bi bi-tags-fill"></i> Kategori
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- Produk --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                            <i class="bi bi-box-seam-fill"></i> Produk
                        </a>
                    </li>

                    {{-- Transaksi --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                            <i class="bi bi-cart-check-fill"></i> Transaksi
                        </a>
                    </li>

                    {{-- Laporan --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}">
                            <i class="bi bi-journal-check"></i> Laporan
                        </a>
                    </li>

                    {{-- Pengaturan --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                            <i class="bi bi-gear-fill"></i> Pengaturan
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-10 admin-content">
            <!-- Header -->
            <header class="admin-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-light d-md-none"><i class="bi bi-list fs-5"></i></button>
                    <h5 class="fw-bold mb-0">@yield('page_title', 'Admin Panel')</h5>
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
                        <li><a class="dropdown-item py-2" href="{{ url('/') }}"><i class="bi bi-house me-2 text-muted"></i>Lihat Toko</a></li>
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
                
                @yield('content')
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
