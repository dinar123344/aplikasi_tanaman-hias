@extends('layouts.app')

@section('title', 'Beranda - Toko Tanaman Hias')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-start fade-in-up">
                <span class="hero-badge">🌿 Hijaukan Ruangan Anda</span>
                <h1 class="hero-title">Bawa Keindahan Alam ke Dalam Genggaman</h1>
                <p class="hero-text">Temukan berbagai koleksi tanaman hias premium, mulai dari kaktus estetik hingga monstera eksotis. Lengkapi dekorasi rumah Anda dengan sentuhan hijau dan suasana yang lebih sejuk.</p>

                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="#katalog" class="btn btn-primary-custom btn-lg">Belanja Sekarang</a>
                    <a href="#fitur" class="btn btn-outline-custom btn-lg">Pelajari Perawatan</a>
                </div>

                <div class="row g-3 mt-5 hero-stats">
                    <div class="col-4">
                        <div class="stat-card">
                            <h4>250+</h4>
                            <p>Produk</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-card">
                            <h4>4.9</h4>
                            <p>Rating</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-card">
                            <h4>100%</h4>
                            <p>Pengiriman Aman</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0 fade-in-up">
                <div class="hero-visual position-relative">
                    <div class="hero-visual-bg"></div>
                    <div class="hero-visual-card p-4 shadow-sm rounded-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <span class="text-success fw-semibold small">Best Seller</span>
                                <h5 class="fw-bold mb-1">Monstera Deliciosa</h5>
                                <p class="text-muted small mb-0">Tanaman hijau elegan untuk sudut ruang tamu.</p>
                            </div>
                            <div class="badge bg-success text-white py-2 px-3 rounded-pill">Rp 225.000</div>
                        </div>
                        <div class="hero-visual-image rounded-4 overflow-hidden mb-4">
                            <img src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=900&q=80" alt="Tanaman kaktus" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="d-flex gap-3 align-items-center">
                            <div class="icon-box bg-success text-white rounded-4">
                                <i class="bi bi-leaf fs-4"></i>
                            </div>
                            <div>
                                <p class="mb-1 fw-semibold">Perawatan Mudah</p>
                                <p class="text-muted small mb-0">Cocok untuk pemula.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Feature Section -->
<section class="py-5" id="fitur">
    <div class="container">
        <div class="section-header text-center mb-5">
            <p class="section-label">Kenapa Pilih Kami</p>
            <h2 class="fw-bold">Layanan Tanaman Hias yang Membuat Hidup Lebih Segar</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card p-4 rounded-4 shadow-sm h-100">
                    <i class="bi bi-award-fill feature-icon"></i>
                    <h5 class="fw-bold mt-3">Tanaman Berkualitas</h5>
                    <p class="text-muted small">Setiap tanaman dipilih dengan cermat dan dirawat sebelum dikirim.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card p-4 rounded-4 shadow-sm h-100">
                    <i class="bi bi-truck feature-icon"></i>
                    <h5 class="fw-bold mt-3">Pengiriman Cepat</h5>
                    <p class="text-muted small">Kemasan aman dan pengiriman cepat sampai depan rumah.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card p-4 rounded-4 shadow-sm h-100">
                    <i class="bi bi-chat-dots feature-icon"></i>
                    <h5 class="fw-bold mt-3">Layanan Konsultasi</h5>
                    <p class="text-muted small">Bantuan perawatan tanaman tersedia setiap saat.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kategori Pilihan -->
<section class="py-5 bg-light" id="katalog">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-end mb-4 gap-3">
            <div>
                <p class="section-label">Koleksi Kami</p>
                <h2 class="fw-bold mb-0">Katalog Tanaman Hias</h2>
            </div>
            <a href="#" class="text-success text-decoration-none fw-semibold">Lihat Semua Kategori <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="product-card h-100 position-relative">
                    <div class="img-wrapper">
                        @php
                            $productImage = $product->image ? (preg_match('/^https?:\/\//', $product->image) ? $product->image : asset('storage/' . $product->image)) : 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?auto=format&fit=crop&q=80&w=600&h=600';
                        @endphp
                        <img src="{{ $productImage }}" alt="{{ $product->name }}">
                        <div class="position-absolute top-0 end-0 p-3">
                            <span class="badge-category shadow-sm">{{ $product->category->name }}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h5 class="fw-bold mb-2 text-dark">{{ $product->name }}</h5>
                        <p class="text-muted small mb-3 text-truncate">{{ $product->description }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @auth
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-light rounded-circle text-success shadow-sm" style="width:40px; height:40px;" title="Tambah ke keranjang">
                                    <i class="bi bi-cart-plus fs-5"></i>
                                </button>
                            </form>
                            @else
                            <a href="{{ route('login') }}" class="btn btn-light rounded-circle text-success shadow-sm" style="width:40px; height:40px;" title="Login untuk belanja">
                                <i class="bi bi-cart-plus fs-5"></i>
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 bg-white rounded-4 shadow-sm">
                    <i class="bi bi-flower2 display-1 text-muted mb-3 d-block"></i>
                    <h4 class="text-muted">Katalog masih kosong</h4>
                    <p class="text-muted">Admin belum menambahkan produk tanaman hias.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- USP Section -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-4 rounded-4 feature-card h-100">
                    <i class="bi bi-shield-check text-success display-4 mb-3 d-block"></i>
                    <h5 class="fw-bold">Kualitas Terjamin</h5>
                    <p class="text-muted small mb-0">Tanaman dirawat oleh ahli dan dikirim dalam kondisi segar.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-4 feature-card h-100">
                    <i class="bi bi-truck text-success display-4 mb-3 d-block"></i>
                    <h5 class="fw-bold">Pengiriman Aman</h5>
                    <p class="text-muted small mb-0">Packaging khusus tanaman untuk mencegah kerusakan di jalan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-4 feature-card h-100">
                    <i class="bi bi-chat-heart text-success display-4 mb-3 d-block"></i>
                    <h5 class="fw-bold">Konsultasi Gratis</h5>
                    <p class="text-muted small mb-0">Tanya jawab seputar perawatan tanaman dengan tim kami.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
