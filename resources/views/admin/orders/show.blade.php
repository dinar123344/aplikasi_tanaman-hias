@extends('layouts.admin')

@section('title', 'Detail Pesanan - Admin Panel')
@section('page_title', 'Detail Pesanan #' . str_pad($order->id, 5, '0', STR_PAD_LEFT))

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold">Item Pesanan</h5>
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
                                            $adminOrderImage = $item->product->image ? (preg_match('/^https?:\/\//', $item->product->image) ? $item->product->image : asset('storage/' . $item->product->image)) : 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?auto=format&fit=crop&q=80&w=600&h=600';
                                        @endphp
                                        <img src="{{ $adminOrderImage }}" class="rounded-3 me-3" width="40" height="40" style="object-fit:cover;" alt="Image">
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $item->product->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end fw-bold text-success">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
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
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold">Informasi Pelanggan</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-person fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">{{ $order->customer->name ?? 'Unknown' }}</h6>
                        <small class="text-muted">Pelanggan</small>
                    </div>
                </div>
                <hr>
                <p class="mb-1 text-muted small">Alamat Pengiriman</p>
                <p class="fw-medium mb-3">{{ $order->customer->address ?? 'Belum ada data alamat' }}</p>
                
                <p class="mb-1 text-muted small">No. HP</p>
                <p class="fw-medium mb-0">{{ $order->customer->phone ?? 'Belum ada data No. HP' }}</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold">Update Status</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Status Saat Ini</label>
                        <select name="status" class="form-select bg-light border-0 fw-medium">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                            <option value="cancel" {{ $order->status == 'cancel' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary-custom w-100">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
