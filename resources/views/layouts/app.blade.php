<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Tanaman Hias')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        :root {
            --sidebar-bg: #ffffff;
            --sidebar-border: rgba(16, 185, 129, 0.15);
            --sidebar-text: #0f172a;
            --sidebar-muted: #6b7280;
            --sidebar-active: #16a34a;
            --content-bg: #f8faf7;
            --link-hover: rgba(22, 163, 74, 0.08);
        }

        body {
            background: var(--content-bg);
            color: #1f2937;
            overflow-x: hidden;
        }

        .app-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            z-index: 1050;
            padding-top: 24px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 0 24px;
            margin-bottom: 30px;
        }

        .sidebar-brand a {
            color: var(--sidebar-active);
            font-weight: 700;
            font-size: 1.25rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 0 24px 24px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 16px;
            color: var(--sidebar-text);
            border-radius: 14px;
            font-weight: 600;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .sidebar-nav .nav-link:hover {
            background: var(--link-hover);
            color: var(--sidebar-active);
        }

        .sidebar-nav .nav-link.active {
            background: rgba(22, 163, 74, 0.12);
            color: var(--sidebar-active);
        }

        .sidebar-divider {
            margin: 22px 0 10px 0;
            padding-left: 0;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--sidebar-muted);
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .app-main {
            margin-left: 260px;
            min-height: 100vh;
            padding: 24px 24px 48px;
        }

        .topbar-mobile {
            display: none;
        }

        .sidebar-toggle {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            border: 1px solid rgba(16, 185, 129, 0.18);
            background: #ffffff;
            color: var(--sidebar-active);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 991.98px) {
            .app-sidebar {
                position: fixed;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .app-sidebar.open {
                transform: translateX(0);
            }

            .app-main {
                margin-left: 0;
                padding: 16px 16px 32px;
            }

            .topbar-mobile {
                display: block;
                position: sticky;
                top: 0;
                z-index: 1030;
                background: #ffffff;
                border-bottom: 1px solid rgba(16, 185, 129, 0.09);
                padding: 10px 16px;
            }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.42);
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.25s ease, visibility 0.25s ease;
                z-index: 1040;
            }

            .sidebar-overlay.open {
                opacity: 1;
                visibility: visible;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="app-sidebar" id="appSidebar">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">
                <i class="bi bi-flower1 text-success fs-3"></i>
                <span>Toko Tanaman</span>
            </a>
        </div>
        <div class="sidebar-nav">
            <a class="nav-link {{ request()->url() == url('/') ? 'active' : '' }}" href="{{ url('/') }}">
                <i class="bi bi-house-door"></i>
                Beranda
            </a>
            <a class="nav-link {{ request()->is('*#katalog') ? 'active' : '' }}" href="{{ url('/#katalog') }}">
                <i class="bi bi-flower2"></i>
                Katalog Tanaman
            </a>
            @auth
                <div class="sidebar-divider">Akun Saya</div>
                <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                    <i class="bi bi-cart3"></i>
                    Keranjang Belanja
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="badge bg-danger rounded-pill ms-auto" style="font-size: 0.72rem; padding: 0.35rem 0.7rem;">{{ $cartCount }}</span>
                    @endif
                </a>
                <a class="nav-link {{ request()->routeIs('checkout.*') ? 'active' : '' }}" href="{{ route('checkout.index') }}">
                    <i class="bi bi-credit-card-2-front"></i>
                    Checkout
                </a>
                <a class="nav-link {{ request()->routeIs('customer.orders.*') ? 'active' : '' }}" href="{{ route('customer.orders.index') }}">
                    <i class="bi bi-receipt"></i>
                    Riwayat Pesanan
                </a>
                <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                    <i class="bi bi-person-fill"></i>
                    Profil Akun
                </a>
                @if(Auth::user()->role == 'admin')
                    <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-shield-check"></i>
                        Panel Admin
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="mt-3 px-3">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 rounded-pill">Keluar</button>
                </form>
            @else
                <div class="sidebar-divider">Masuk / Daftar</div>
                <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Login
                </a>
                <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                    <i class="bi bi-pencil-square"></i>
                    Daftar
                </a>
            @endauth
        </div>
    </aside>

    <div class="app-main">
        <div class="topbar-mobile d-lg-none d-flex align-items-center justify-content-between">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <i class="bi bi-flower1 text-success fs-3"></i>
                <span>Toko Tanaman</span>
            </a>
            <button class="sidebar-toggle" id="mobileSidebarToggle"><i class="bi bi-list fs-5"></i></button>
        </div>

        <main>
            @if(session('success'))
                <div class="container mt-3">
                    <div class="alert alert-success border-0 shadow-sm rounded-3 alert-dismissible fade show">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="container mt-3">
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 alert-dismissible fade show">
                        <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-5 mt-5 border-top" style="margin-left: 260px;">
        <div class="container text-center">
            <i class="bi bi-flower1 text-success fs-1 mb-3 d-block"></i>
            <h5 class="fw-bold mb-3">Toko Tanaman Hias</h5>
            <p class="text-muted mb-4">Menghadirkan keindahan alam ke dalam ruangan Anda.</p>
            <div class="d-flex justify-content-center gap-3 mb-4">
                <a href="#" class="text-muted fs-4 hover-primary"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-muted fs-4 hover-primary"><i class="bi bi-whatsapp"></i></a>
                <a href="#" class="text-muted fs-4 hover-primary"><i class="bi bi-facebook"></i></a>
            </div>
            <p class="text-muted small mb-0">&copy; {{ date('Y') }} Toko Tanaman Hias. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sidebar = document.getElementById('appSidebar');
            var overlay = document.getElementById('sidebarOverlay');
            var toggle = document.getElementById('mobileSidebarToggle');

            function openSidebar() {
                sidebar.classList.add('open');
                overlay.classList.add('open');
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
            }

            if (toggle) {
                toggle.addEventListener('click', function () {
                    openSidebar();
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function () {
                    closeSidebar();
                });
            }
        });
    </script>
</body>
</html>
