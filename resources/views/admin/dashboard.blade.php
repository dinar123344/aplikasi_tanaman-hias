@extends('layouts.admin')

@section('title', 'Dashboard Admin - Toko Tanaman Hias')
@section('page_title', 'Dashboard')

@section('content')
@php
    $months = json_encode(array_column($revenueChart, 'month'));
    $revenues = json_encode(array_column($revenueChart, 'revenue'));
    
    $statusLabels = json_encode(['Pending', 'Lunas', 'Dibatalkan']);
    $statusData = json_encode([
        (int) $ordersByStatus['pending'],
        (int) $ordersByStatus['paid'],
        (int) $ordersByStatus['cancelled']
    ]);
@endphp

{{-- Welcome Banner --}}
<div class="dashboard-welcome mb-4 fade-in-up">
    <div class="welcome-content d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="welcome-text">
            <h3 class="fw-bold mb-2">Selamat Datang Kembali, {{ Auth::user()->name }}! 👋</h3>
            <p class="mb-0 opacity-90">Berikut adalah ringkasan performa toko tanaman hias Anda hari ini.</p>
        </div>
        <div class="welcome-date px-3 py-2 rounded-3 bg-white bg-opacity-10 backdrop-blur d-flex align-items-center gap-2">
            <i class="bi bi-calendar3 fs-5"></i>
            <span class="fw-medium">{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>
    <div class="welcome-bg-leaf">
        <i class="bi bi-flower1"></i>
    </div>
</div>

{{-- Stats Cards Row --}}
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6 fade-in-up" style="animation-delay: 0.05s;">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stats-card__info">
                    <span class="stats-card__label">Total Pendapatan</span>
                    <h3 class="stats-card__value mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="stats-card__icon stats-card__icon--revenue">
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
            <div class="stats-card__footer stats-card__footer--revenue">
                <i class="bi bi-graph-up-arrow me-1"></i>
                <span>Bulan ini: <strong>Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</strong></span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 fade-in-up" style="animation-delay: 0.1s;">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stats-card__info">
                    <span class="stats-card__label">Total Pesanan</span>
                    <h3 class="stats-card__value mt-1">{{ $totalOrders }}</h3>
                </div>
                <div class="stats-card__icon stats-card__icon--orders">
                    <i class="bi bi-cart-check"></i>
                </div>
            </div>
            <div class="stats-card__footer stats-card__footer--orders">
                <i class="bi bi-clock-history me-1"></i>
                <span><strong>{{ $pendingOrders }}</strong> pesanan tertunda (pending)</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 fade-in-up" style="animation-delay: 0.15s;">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stats-card__info">
                    <span class="stats-card__label">Total Produk</span>
                    <h3 class="stats-card__value mt-1">{{ $totalProducts }}</h3>
                </div>
                <div class="stats-card__icon stats-card__icon--products">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
            <div class="stats-card__footer stats-card__footer--products">
                @if($outOfStockCount > 0)
                    <i class="bi bi-exclamation-triangle-fill text-danger me-1"></i>
                    <span class="text-danger"><strong>{{ $outOfStockCount }}</strong> produk habis stok</span>
                @else
                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                    <span class="text-success">Semua produk tersedia & aman</span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 fade-in-up" style="animation-delay: 0.2s;">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stats-card__info">
                    <span class="stats-card__label">Pelanggan</span>
                    <h3 class="stats-card__value mt-1">{{ $totalCustomers }}</h3>
                </div>
                <div class="stats-card__icon stats-card__icon--customers">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="stats-card__footer stats-card__footer--customers">
                <i class="bi bi-person-badge-fill me-1"></i>
                <span>Pengguna terdaftar di aplikasi</span>
            </div>
        </div>
    </div>
</div>

{{-- Charts Row --}}
<div class="row g-4 mb-4">
    {{-- Revenue Chart --}}
    <div class="col-lg-8 fade-in-up" style="animation-delay: 0.25s;">
        <div class="dashboard-card h-100">
            <div class="dashboard-card__header">
                <div>
                    <h6 class="dashboard-card__title">Pendapatan 6 Bulan Terakhir</h6>
                    <p class="dashboard-card__subtitle">Visualisasi tren pendapatan bulanan</p>
                </div>
                <div class="dashboard-card__action-icon">
                    <i class="bi bi-activity"></i>
                </div>
            </div>
            <div class="dashboard-card__body">
                <div id="revenueChart"></div>
            </div>
        </div>
    </div>

    {{-- Order Status Distribution --}}
    <div class="col-lg-4 fade-in-up" style="animation-delay: 0.3s;">
        <div class="dashboard-card h-100">
            <div class="dashboard-card__header">
                <div>
                    <h6 class="dashboard-card__title">Status Pesanan</h6>
                    <p class="dashboard-card__subtitle">Persentase distribusi status transaksi</p>
                </div>
                <div class="dashboard-card__action-icon text-primary">
                    <i class="bi bi-pie-chart-fill"></i>
                </div>
            </div>
            <div class="dashboard-card__body d-flex flex-column align-items-center justify-content-center" style="min-height: 300px;">
                <div id="statusChart" class="w-100"></div>
            </div>
        </div>
    </div>
</div>

{{-- Bottom Row --}}
<div class="row g-4 mb-4">
    {{-- Recent Orders --}}
    <div class="col-lg-8 fade-in-up" style="animation-delay: 0.35s;">
        <div class="dashboard-card h-100">
            <div class="dashboard-card__header">
                <div>
                    <h6 class="dashboard-card__title">Pesanan Terbaru</h6>
                    <p class="dashboard-card__subtitle">7 daftar transaksi terakhir yang masuk</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-success border-2 rounded-pill px-3">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="dashboard-card__body p-0">
                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 dashboard-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Pembayaran</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="fw-bold text-success text-decoration-none">
                                            #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-sm rounded-circle">{{ substr($order->customer->name ?? '?', 0, 1) }}</div>
                                            <span class="fw-medium text-dark">{{ $order->customer->name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $order->order_date->format('d M Y') }}</td>
                                    <td class="fw-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->payment)
                                            <span class="badge bg-light text-dark border px-2 py-1 text-capitalize">
                                                <i class="bi bi-credit-card-2-front me-1"></i> {{ $order->payment->payment_method }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge-status badge-status--warning">
                                                <span class="pulse-dot bg-warning"></span> Pending
                                            </span>
                                        @elseif($order->status == 'paid')
                                            <span class="badge-status badge-status--success">
                                                <span class="pulse-dot bg-success"></span> Lunas
                                            </span>
                                        @else
                                            <span class="badge-status badge-status--danger">
                                                <span class="pulse-dot bg-danger"></span> Batal
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50 text-success"></i>
                        <p class="mb-0 fw-medium">Belum ada pesanan masuk.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Right Column (Top Products & Alerts) --}}
    <div class="col-lg-4 d-flex flex-column gap-4 fade-in-up" style="animation-delay: 0.4s;">
        {{-- Top Products --}}
        <div class="dashboard-card flex-grow-1">
            <div class="dashboard-card__header">
                <div>
                    <h6 class="dashboard-card__title">Produk Terlaris</h6>
                    <p class="dashboard-card__subtitle">Top 5 tanaman paling diminati</p>
                </div>
                <div class="dashboard-card__action-icon text-warning">
                    <i class="bi bi-star-fill"></i>
                </div>
            </div>
            <div class="dashboard-card__body">
                @if($topProducts->count() > 0)
                    @foreach($topProducts as $index => $product)
                    <div class="top-product-item d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="top-product-rank rank-{{ $index + 1 }}">{{ $index + 1 }}</div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-bold text-dark text-truncate">{{ $product->name }}</div>
                            <small class="text-muted d-block text-truncate">{{ $product->category->name ?? '-' }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success fw-bold px-2 py-1 rounded">
                                {{ $product->total_sold }} Terjual
                            </span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-box fs-3 d-block mb-2 opacity-50"></i>
                        <small>Belum ada data penjualan.</small>
                    </div>
                @endif
            </div>
        </div>

        {{-- Low Stock Alert --}}
        <div class="dashboard-card">
            <div class="dashboard-card__header">
                <div>
                    <h6 class="dashboard-card__title">Stok Menipis</h6>
                    <p class="dashboard-card__subtitle">Perlu segera di-restock</p>
                </div>
                <div class="dashboard-card__action-icon text-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
            </div>
            <div class="dashboard-card__body">
                @if($lowStockProducts->count() > 0)
                    @foreach($lowStockProducts as $product)
                    <div class="low-stock-item d-flex align-items-center justify-content-between py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="min-w-0 me-2">
                            <div class="fw-bold text-dark text-truncate">{{ $product->name }}</div>
                            <small class="text-muted">Sisa Stok: <strong class="text-danger">{{ $product->stock }} pot</strong></small>
                        </div>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-light border rounded px-2">
                            <i class="bi bi-plus-lg text-success"></i>
                        </a>
                    </div>
                    @endforeach
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle-fill fs-2 d-block mb-2 text-success opacity-75"></i>
                        <small class="fw-medium">Semua stok tanaman aman! 🎉</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Category Summary --}}
<div class="row g-4 mb-4 fade-in-up" style="animation-delay: 0.45s;">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="dashboard-card__header">
                <div>
                    <h6 class="dashboard-card__title">Kategori Tanaman</h6>
                    <p class="dashboard-card__subtitle">Jumlah variasi produk per kategori</p>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-success border-2 rounded-pill px-3">
                    Kelola Kategori <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="dashboard-card__body">
                @if($categorySummary->count() > 0)
                    <div class="row g-3">
                        @foreach($categorySummary as $category)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="category-card shadow-sm border border-light">
                                <div class="category-card__icon">
                                    <i class="bi bi-flower{{ ($loop->index % 3) + 1 }}"></i>
                                </div>
                                <div class="category-card__name text-dark fw-bold">{{ $category->name }}</div>
                                <div class="category-card__count mt-1">
                                    <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1.5 rounded-pill">{{ $category->products_count }} produk</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-tags fs-3 d-block mb-2 opacity-50"></i>
                        <small>Belum ada kategori. <a href="{{ route('admin.categories.create') }}">Tambah sekarang</a></small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Load ApexCharts Library --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Revenue Area Chart
    var revenueOptions = {
        series: [{
            name: 'Pendapatan',
            data: {!! $revenues !!}
        }],
        chart: {
            type: 'area',
            height: 310,
            fontFamily: 'Outfit, sans-serif',
            toolbar: { show: false },
            zoom: { enabled: false }
        },
        colors: ['#2D6A4F'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [0, 95, 100]
            }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        xaxis: {
            categories: {!! $months !!},
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                style: {
                    colors: '#6C757D',
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#6C757D',
                    fontSize: '12px'
                },
                formatter: function (value) {
                    return "Rp " + value.toLocaleString('id-ID');
                }
            }
        },
        grid: {
            borderColor: 'rgba(0,0,0,0.05)',
            strokeDashArray: 4
        },
        markers: {
            size: 4,
            colors: ['#2D6A4F'],
            strokeColors: '#fff',
            strokeWidth: 2,
            hover: { size: 6 }
        }
    };
    var revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueOptions);
    revenueChart.render();

    // 2. Status Donut Chart
    var statusOptions = {
        series: {!! $statusData !!},
        chart: {
            type: 'donut',
            height: 280,
            fontFamily: 'Outfit, sans-serif'
        },
        labels: {!! $statusLabels !!},
        colors: ['#F59E0B', '#10B981', '#EF4444'],
        legend: {
            position: 'bottom',
            fontSize: '13px',
            fontFamily: 'Outfit, sans-serif',
            markers: { radius: 12 }
        },
        dataLabels: { enabled: false },
        plotOptions: {
            pie: {
                donut: {
                    size: '72%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '14px',
                            fontWeight: 500,
                            color: '#6C757D',
                            offsetY: -8
                        },
                        value: {
                            show: true,
                            fontSize: '22px',
                            fontWeight: 700,
                            color: '#2D3142',
                            offsetY: 8,
                            formatter: function (val) {
                                return val;
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total Pesanan',
                            fontSize: '13px',
                            fontWeight: 500,
                            color: '#6C757D',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            }
                        }
                    }
                }
            }
        }
    };
    var statusChart = new ApexCharts(document.querySelector("#statusChart"), statusOptions);
    statusChart.render();
});
</script>
@endsection

@push('styles')
<style>
/* ============================================
   DASHBOARD PREMIUM STYLES
   ============================================ */

/* Welcome Banner */
.dashboard-welcome {
    background: linear-gradient(135deg, #1B4332 0%, #2D6A4F 100%);
    padding: 32px;
    border-radius: 20px;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(27, 67, 50, 0.15);
}
.welcome-content {
    position: relative;
    z-index: 2;
}
.welcome-text h3 {
    color: #FFFFFF;
    font-size: 1.6rem;
}
.welcome-date {
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #FFFFFF;
    font-size: 0.9rem;
}
.welcome-bg-leaf {
    position: absolute;
    right: -20px;
    bottom: -40px;
    font-size: 10rem;
    color: rgba(255, 255, 255, 0.05);
    transform: rotate(-15deg);
    pointer-events: none;
}

/* Stats Cards */
.stats-card {
    background: #FFFFFF;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(0, 0, 0, 0.04);
}
.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(45, 106, 79, 0.08);
    border-color: rgba(82, 183, 136, 0.2);
}
.stats-card__label {
    font-size: 0.78rem;
    color: #6C757D;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}
.stats-card__value {
    font-size: 1.55rem;
    font-weight: 700;
    color: #2D3142;
}
.stats-card__icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
}
.stats-card__icon--revenue {
    background: #E8F5E9;
    color: #2E7D32;
}
.stats-card__icon--orders {
    background: #E3F2FD;
    color: #1565C0;
}
.stats-card__icon--products {
    background: #FFF8E1;
    color: #FF8F00;
}
.stats-card__icon--customers {
    background: #EDE7F6;
    color: #651FFF;
}
.stats-card__footer {
    margin-top: 16px;
    padding-top: 14px;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    font-size: 0.82rem;
    color: #6C757D;
    font-weight: 500;
    display: flex;
    align-items: center;
}
.stats-card__footer--revenue { color: #2E7D32; }
.stats-card__footer--orders { color: #1565C0; }

/* Dashboard Cards */
.dashboard-card {
    background: #FFFFFF;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(0, 0, 0, 0.04);
    overflow: hidden;
}
.dashboard-card__header {
    padding: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}
.dashboard-card__title {
    font-size: 1.05rem;
    font-weight: 700;
    margin-bottom: 2px;
    color: #2D3142;
}
.dashboard-card__subtitle {
    font-size: 0.8rem;
    color: #6C757D;
    margin-bottom: 0;
}
.dashboard-card__action-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: #F4F7F6;
    color: #2D6A4F;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}
.dashboard-card__body {
    padding: 24px;
}

/* Dashboard Table */
.dashboard-table thead th {
    background: #F8FAF9;
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #6C757D;
    padding: 16px 24px;
    border: none;
}
.dashboard-table tbody td {
    padding: 16px 24px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    font-size: 0.9rem;
}
.dashboard-table tbody tr:last-child td {
    border-bottom: none;
}
.dashboard-table tbody tr:hover {
    background-color: rgba(82, 183, 136, 0.03);
}

/* Avatar Group */
.avatar-sm {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #74C69D, #2D6A4F);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.82rem;
    font-weight: 700;
    flex-shrink: 0;
}

/* Badge Status Styling */
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

/* Top Product lists */
.top-product-rank {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 0.85rem;
    flex-shrink: 0;
    background: #F4F7F6;
    color: #6C757D;
}
.rank-1 { background: #FFF3CD; color: #856404; }
.rank-2 { background: #E2E3E5; color: #383D41; }
.rank-3 { background: #F8D7DA; color: #721C24; }

/* Category Cards */
.category-card {
    background: #FFFFFF;
    border-radius: 16px;
    padding: 24px 16px;
    text-align: center;
    transition: all 0.3s ease;
}
.category-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(82, 183, 136, 0.1) !important;
    border-color: rgba(82, 183, 136, 0.2) !important;
}
.category-card__icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #74C69D, #2D6A4F);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 1.25rem;
    box-shadow: 0 4px 10px rgba(45, 106, 79, 0.15);
}
.category-card__name {
    font-size: 0.95rem;
}
.category-card__count span {
    font-size: 0.75rem;
    font-weight: 600;
}

/* Animations */
.fade-in-up {
    animation: fadeInUp 0.5s ease backwards;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

.min-w-0 { min-width: 0; }
.backdrop-blur {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}
</style>
@endpush
