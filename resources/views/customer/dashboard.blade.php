@extends('layouts.customer')

@section('title', 'Dashboard Pelanggan - Toko Tanaman Hias')
@section('page_title', 'Dashboard Saya')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="dashboard-hero position-relative rounded-4 overflow-hidden mb-4">
            <div class="dashboard-hero__bg"></div>
            <div class="dashboard-hero__content p-4 p-md-5 d-flex flex-column flex-md-row align-items-start justify-content-between gap-4">
                <div class="hero-copy">
                    <span class="badge bg-light text-success rounded-pill py-2 px-3 mb-3">Selamat Datang</span>
                    <h2 class="fw-bold mb-3">Halo, {{ Auth::user()->name }}!</h2>
                    <p class="mb-4 text-muted">Semua informasi pesanan dan profil Anda tersedia di sini. Ayo lihat status pesanan terbaru atau lanjut belanja tanaman favorit Anda.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('customer.orders.index') }}" class="btn btn-success btn-lg rounded-pill">Lihat Pesanan</a>
                        <a href="{{ url('/#katalog') }}" class="btn btn-outline-light btn-lg rounded-pill border-white text-white">Belanja Sekarang</a>
                    </div>
                </div>
                <div class="hero-meta p-4 rounded-4 bg-white shadow-sm" style="min-width: 260px;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <p class="text-muted mb-1">Tanggal</p>
                            <h6 class="fw-bold mb-0">{{ now()->translatedFormat('l, d F Y') }}</h6>
                        </div>
                        <div class="rounded-4 bg-success bg-opacity-10 text-success p-3">
                            <i class="bi bi-calendar3 fs-4"></i>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <div>
                            <p class="text-muted mb-1">Status Akun</p>
                            <h5 class="fw-bold mb-0 text-success">Aktif</h5>
                        </div>
                        <div class="rounded-4 bg-success bg-opacity-10 text-success p-3">
                            <i class="bi bi-person-check fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="dashboard-card shadow-sm border-0 p-4">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <p class="text-uppercase text-muted small mb-1">Total Belanja</p>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h3>
                </div>
                <div class="badge bg-success bg-opacity-10 text-success p-3 rounded-4">
                    <i class="bi bi-wallet2 fs-4"></i>
                </div>
            </div>
            <p class="text-muted small mb-0">Nominal pembelian lunas yang sudah berhasil.</p>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="dashboard-card shadow-sm border-0 p-4">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <p class="text-uppercase text-muted small mb-1">Pesanan</p>
                    <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
                </div>
                <div class="badge bg-primary bg-opacity-10 text-primary p-3 rounded-4">
                    <i class="bi bi-bag-check fs-4"></i>
                </div>
            </div>
            <p class="text-muted small mb-0">Jumlah pesanan yang sudah dibuat oleh Anda.</p>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="dashboard-card shadow-sm border-0 p-4">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <p class="text-uppercase text-muted small mb-1">Keranjang</p>
                    <h3 class="fw-bold mb-0">{{ $cartCount }} Produk</h3>
                </div>
                <div class="badge bg-warning bg-opacity-10 text-warning p-3 rounded-4">
                    <i class="bi bi-cart3 fs-4"></i>
                </div>
            </div>
            <p class="text-muted small mb-0">Item di keranjang yang siap di-checkout.</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="dashboard-card shadow-sm border-0">
            <div class="dashboard-card__header px-4 py-4">
                <div>
                    <h6 class="dashboard-card__title mb-2">Pesanan Terbaru</h6>
                    <p class="dashboard-card__subtitle mb-0">Ringkasan 5 pesanan terakhir Anda.</p>
                </div>
                <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-success btn-sm rounded-pill">Lihat Semua</a>
            </div>
            <div class="dashboard-card__body p-0">
                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 dashboard-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td class="fw-bold">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="text-muted">{{ $order->order_date->format('d M Y') }}</td>
                                    <td class="text-success fw-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill py-2 px-3">Pending</span>
                                        @elseif($order->status == 'paid')
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill py-2 px-3">Lunas</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill py-2 px-3">Batal</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-sm btn-light border rounded-pill">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state p-5 text-center">
                        <div class="mb-4">
                            <i class="bi bi-cart-x display-4 text-success"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Belum ada pesanan</h5>
                        <p class="text-muted mb-4">Kamu belum membuat pesanan. Mulai belanja tanaman sekarang untuk melihat order di sini.</p>
                        <a href="{{ url('/#katalog') }}" class="btn btn-success rounded-pill px-4">Belanja Sekarang</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="dashboard-card shadow-sm border-0 px-4 py-4">
            <h6 class="dashboard-card__title mb-3">Menu Cepat</h6>
            <div class="list-group list-group-flush">
                <a href="{{ route('cart.index') }}" class="list-group-item list-group-item-action rounded-4 mb-2 d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-cart3 me-2"></i> Keranjang</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="{{ route('checkout.index') }}" class="list-group-item list-group-item-action rounded-4 mb-2 d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-credit-card-2-front me-2"></i> Checkout</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="{{ route('customer.orders.index') }}" class="list-group-item list-group-item-action rounded-4 mb-2 d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-receipt me-2"></i> Riwayat Pesanan</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="{{ route('profile') }}" class="list-group-item list-group-item-action rounded-4 d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-person-fill me-2"></i> Profil Akun</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
        <div class="dashboard-card shadow-sm border-0 mt-4 p-4">
            <h6 class="dashboard-card__title mb-3">Tips Perawatan</h6>
            <p class="text-muted small">Pastikan tanaman Anda mendapatkan cahaya tidak langsung dan disirami 1-2 kali seminggu untuk kondisi ideal.</p>
            <a href="#" class="text-success fw-semibold">Selengkapnya <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.dashboard-hero {
    background: linear-gradient(135deg, rgba(45, 106, 79, 0.92), rgba(82, 183, 136, 0.82));
    color: white;
}
.dashboard-hero__bg {
    position: absolute;
    inset: 0;
    background: url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
    opacity: 0.18;
}
.dashboard-hero__content {
    position: relative;
    z-index: 1;
}
.dashboard-hero h2 {
    font-size: clamp(2rem, 2.5vw, 3rem);
}
.dashboard-card {
    background: white;
    border-radius: 24px;
}
.dashboard-card__header {
    padding: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    border-bottom: 1px solid #ebedf0;
}
.dashboard-card__title {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 0.35rem;
}
.dashboard-card__subtitle {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0;
}
.dashboard-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.dashboard-table thead th {
    background: #f8faf9;
    font-weight: 700;
    color: #6c757d;
    border: none;
    padding: 20px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-size: 0.78rem;
}
.dashboard-table tbody td {
    padding: 16px 24px;
    border-top: 1px solid #f1f3f5;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: middle;
    font-size: 0.9rem;
}
.dashboard-table tbody tr:last-child td {
    border-bottom: none;
}
.dashboard-table tbody tr:hover {
    background-color: rgba(82, 183, 136, 0.03);
}
.empty-state {
    background: #f8faf9;
    border-radius: 24px;
}
.divider {
    height: 1px;
    background: #e9ecef;
    margin: 1rem 0;
}
.list-group-item {
    border: 1px solid #ebedf0;
    transition: transform 0.2s ease, background 0.2s ease;
}
.list-group-item:hover {
    transform: translateY(-2px);
    background: #f8faf9;
}
.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 30px;
    font-size: 0.78rem;
    font-weight: 600;
    border: 1px solid transparent;
}
.badge-status--warning {
    background: #FFF9E6;
    color: #D97706;
    border-color: #FDE68A;
}
.badge-status--success {
    background: #ECFDF5;
    color: #059669;
    border-color: #A7F3D0;
}
.badge-status--danger {
    background: #FEF2F2;
    color: #DC2626;
    border-color: #FCA5A5;
}
.pulse-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}
.fade-in-up {
    animation: fadeInUp 0.5s ease backwards;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
@media (max-width: 767.98px) {
    .dashboard-card__header,
    .dashboard-card__body,
    .dashboard-hero__content {
        padding-left: 18px;
        padding-right: 18px;
    }
}
</style>
@endpush
