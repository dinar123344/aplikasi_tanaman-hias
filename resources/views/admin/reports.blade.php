@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Toko Tanaman Hias')
@section('page_title', 'Laporan Penjualan')

@section('content')
@php
    $months = json_encode(array_column($monthlyReport, 'month'));
    $revenues = json_encode(array_column($monthlyReport, 'revenue'));
@endphp

{{-- Header Action --}}
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 fade-in-up">
    <div>
        <h4 class="fw-bold mb-1">Analisis Performa & Penjualan</h4>
        <p class="text-muted mb-0">Laporan keuangan dan statistik produk toko tanaman hias Anda.</p>
    </div>
    <button onclick="window.print()" class="btn btn-success border-2 rounded-pill px-4 fw-semibold shadow-sm">
        <i class="bi bi-printer me-2"></i> Cetak Laporan
    </button>
</div>

{{-- Summary Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-4 fade-in-up" style="animation-delay: 0.05s;">
        <div class="report-summary-card">
            <div class="report-summary-card__icon bg-success-subtle text-success">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div>
                <span class="report-summary-card__label">Total Omset Penjualan</span>
                <h3 class="report-summary-card__value mt-1 text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4 fade-in-up" style="animation-delay: 0.1s;">
        <div class="report-summary-card">
            <div class="report-summary-card__icon bg-primary-subtle text-primary">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div>
                <span class="report-summary-card__label">Transaksi Lunas</span>
                <h3 class="report-summary-card__value mt-1 text-primary">{{ $totalPaidOrders }} Pesanan</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4 fade-in-up" style="animation-delay: 0.15s;">
        <div class="report-summary-card">
            <div class="report-summary-card__icon bg-danger-subtle text-danger">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <div>
                <span class="report-summary-card__label">Transaksi Batal</span>
                <h3 class="report-summary-card__value mt-1 text-danger">{{ $totalCancelledOrders }} Pesanan</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Monthly Revenue Trend --}}
    <div class="col-lg-8 fade-in-up" style="animation-delay: 0.2s;">
        <div class="dashboard-card h-100">
            <div class="dashboard-card__header">
                <div>
                    <h6 class="dashboard-card__title">Tren Penjualan Bulanan ({{ date('Y') }})</h6>
                    <p class="dashboard-card__subtitle">Grafik omset pendapatan sepanjang tahun ini</p>
                </div>
            </div>
            <div class="dashboard-card__body">
                <div id="monthlyReportChart"></div>
            </div>
        </div>
    </div>

    {{-- Category Performance --}}
    <div class="col-lg-4 fade-in-up" style="animation-delay: 0.25s;">
        <div class="dashboard-card h-100">
            <div class="dashboard-card__header">
                <div>
                    <h6 class="dashboard-card__title">Performa Kategori</h6>
                    <p class="dashboard-card__subtitle">Jumlah variasi produk per kategori</p>
                </div>
            </div>
            <div class="dashboard-card__body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-muted" style="font-size: 0.8rem; font-weight: 600;">
                                <th>Kategori</th>
                                <th class="text-end">Jumlah Produk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categoryReport as $category)
                            <tr>
                                <td class="fw-semibold text-dark">
                                    <i class="bi bi-tag-fill text-success me-2"></i> {{ $category->name }}
                                </td>
                                <td class="text-end text-muted">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1">
                                        {{ $category->products_count }} Pot
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var reportOptions = {
        series: [{
            name: 'Omset Penjualan',
            data: {!! $revenues !!}
        }],
        chart: {
            type: 'line',
            height: 320,
            fontFamily: 'Outfit, sans-serif',
            toolbar: { show: false }
        },
        colors: ['#10B981'],
        stroke: {
            curve: 'smooth',
            width: 4
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.3,
                opacityTo: 0.1,
                stops: [0, 90, 100]
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: {!! $months !!},
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                style: { colors: '#6C757D', fontSize: '12px' }
            }
        },
        yaxis: {
            labels: {
                style: { colors: '#6C757D', fontSize: '12px' },
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
            size: 6,
            colors: ['#10B981'],
            strokeColors: '#fff',
            strokeWidth: 3,
            hover: { size: 8 }
        }
    };
    var reportChart = new ApexCharts(document.querySelector("#monthlyReportChart"), reportOptions);
    reportChart.render();
});
</script>
@endsection

@push('styles')
<style>
.report-summary-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    border: 1px solid rgba(0,0,0,0.04);
    display: flex;
    align-items: center;
    gap: 20px;
}
.report-summary-card__icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    flex-shrink: 0;
}
.report-summary-card__label {
    font-size: 0.82rem;
    color: #6C757D;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}
.report-summary-card__value {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 0;
}

@media print {
    .admin-sidebar, .admin-header, button, .btn {
        display: none !important;
    }
    .admin-content {
        width: 100% !important;
        margin-left: 0 !important;
        padding: 0 !important;
    }
}
</style>
@endpush
