@extends('layouts.customer')

@section('title', 'Detail Pesanan - Toko Tanaman Hias')
@section('page_title', 'Detail Pesanan')

@section('content')
<div class="container py-5">
    <a href="{{ route('customer.orders.index') }}" class="text-success text-decoration-none fw-medium mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Pesanan Saya
    </a>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h5 class="fw-bold mb-0">Pesanan #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h5>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('customer.orders.print', $order) }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 py-2">
                            <i class="bi bi-printer me-2"></i> Cetak Struk
                        </a>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark px-3 py-2">Menunggu Pembayaran</span>
                        @elseif($order->status == 'paid')
                            <span class="badge bg-success px-3 py-2">Sudah Dibayar</span>
                        @else
                            <span class="badge bg-danger px-3 py-2">Dibatalkan</span>
                        @endif
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @php
                                                $orderItemImage = $item->product->image ? (preg_match('/^https?:\/\//', $item->product->image) ? $item->product->image : asset('storage/' . $item->product->image)) : 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?auto=format&fit=crop&q=80&w=600&h=600';
                                            @endphp
                                            <img src="{{ $orderItemImage }}" class="rounded-3 me-3" width="45" height="45" style="object-fit:cover;" alt="Image">
                                            <span class="fw-medium">{{ $item->product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total Pembayaran</td>
                                    <td class="text-end fw-bold text-success fs-5">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Payment Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Pembayaran</h5>

                    @if($order->status == 'pending')
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3 mb-3 text-center">
                            <i class="bi bi-exclamation-triangle text-warning fs-3 d-block mb-2"></i>
                            <p class="text-muted mb-0">Pesanan ini belum dibayar. Segera lakukan pembayaran.</p>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Tagihan</span>
                            <span class="fw-bold text-success fs-5">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Metode</span>
                            <span class="fw-medium">Transfer Bank</span>
                        </div>

                        <form action="{{ route('customer.orders.pay', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold" onclick="return confirm('Konfirmasi pembayaran sebesar Rp {{ number_format($order->total_amount, 0, ',', '.') }}?')">
                                <i class="bi bi-credit-card me-2"></i> Bayar Sekarang
                            </button>
                        </form>
                    @elseif($order->status == 'paid')
                        <div class="bg-success bg-opacity-10 rounded-3 p-4 text-center">
                            <i class="bi bi-check-circle-fill text-success display-4 d-block mb-2"></i>
                            <h5 class="fw-bold text-success">Pembayaran Berhasil</h5>
                            @if($order->payment)
                                <p class="text-muted small mb-1">Dibayar pada {{ $order->payment->paid_at->format('d M Y, H:i') }}</p>
                                <p class="text-muted small mb-0">Metode: {{ ucfirst($order->payment->payment_method) }}</p>
                            @endif
                        </div>
                    @else
                        <div class="bg-danger bg-opacity-10 rounded-3 p-4 text-center">
                            <i class="bi bi-x-circle-fill text-danger display-4 d-block mb-2"></i>
                            <h5 class="fw-bold text-danger">Pesanan Dibatalkan</h5>
                            <p class="text-muted small mb-0">Pesanan ini telah dibatalkan dan tidak bisa dibayar.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info Card -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Info Pesanan</h6>
                    <div class="mb-2">
                        <small class="text-muted d-block">Alamat Pengiriman</small>
                        <span>{{ $order->shipping_address ?? '-' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">Kurir</small>
                        <span>{{ $order->courier_name ?? '-' }} {{ $order->courier_service ? '(' . $order->courier_service . ')' : '' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">Nomor Resi</small>
                        <span class="fw-bold text-success">{{ $order->tracking_number ?? '-' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">Metode Pembayaran</small>
                        <span>{{ $order->payment_method ? ucfirst($order->payment_method) : '-' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">Tanggal Pemesanan</small>
                        <span>{{ $order->order_date->format('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block">Total Item</small>
                        <span>{{ $order->orderItems->sum('quantity') }} barang</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
