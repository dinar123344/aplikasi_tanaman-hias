@extends('layouts.customer')

@section('title', 'Pesanan Saya - Toko Tanaman Hias')
@section('page_title', 'Pesanan Saya')

@section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4"><i class="bi bi-bag me-2"></i>Pesanan Saya</h3>

    @if($orders->count() > 0)
        @foreach($orders as $order)
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <small class="text-muted d-block">No. Pesanan</small>
                        <span class="fw-bold fs-5">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Tanggal</small>
                        <span>{{ $order->order_date->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="col-md-2">
                        <small class="text-muted d-block">Total</small>
                        <span class="fw-bold text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="col-md-2">
                        <small class="text-muted d-block">Jumlah Item</small>
                        <span>{{ $order->orderItems->count() }} produk</span>
                    </div>
                    <div class="col-md-1">
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                        @elseif($order->status == 'paid')
                            <span class="badge bg-success px-3 py-2">Lunas</span>
                        @else
                            <span class="badge bg-danger px-3 py-2">Batal</span>
                        @endif
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-outline-custom btn-sm px-3">
                            Detail <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="text-center py-5">
            <div class="p-5 bg-white rounded-4 shadow-sm d-inline-block">
                <i class="bi bi-bag display-1 text-muted d-block mb-3"></i>
                <h4 class="text-muted mb-2">Belum ada pesanan</h4>
                <p class="text-muted mb-4">Anda belum pernah melakukan transaksi. Yuk mulai belanja!</p>
                <a href="{{ url('/') }}" class="btn btn-primary-custom px-5 py-2">Belanja Sekarang</a>
            </div>
        </div>
    @endif
</div>
@endsection
