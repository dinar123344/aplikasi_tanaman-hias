@extends('layouts.customer')

@section('title', 'Checkout - Toko Tanaman Hias')
@section('page_title', 'Checkout')

@section('content')
<div class="container py-5">
    <div class="row g-4 fade-in-up">
        <div class="col-lg-8">
            {{-- Review Items Card --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-bag-check-fill text-success me-2"></i> Tinjau Pesanan Anda</h5>
                
                @foreach($cartItems as $item)
                @php $product = $item['product']; @endphp
                <div class="d-flex align-items-center justify-content-between py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-light rounded-3 p-1" style="width: 70px; height: 70px; overflow: hidden;">
                            @php
                                $imageUrl = $product->image ? (preg_match('/^https?:\/\//', $product->image) ? $product->image : asset('storage/' . $product->image)) : 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?auto=format&fit=crop&q=80&w=600&h=600';
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">{{ $product->name }}</h6>
                            <small class="text-muted">Jumlah: {{ $item['quantity'] }} pot</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="fw-bold text-success">Rp {{ number_format($product->price * $item['quantity'], 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Shipping Address Card (Form Mockup) --}}
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-geo-alt-fill text-success me-2"></i> Informasi Pengiriman</h5>
                <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small">Nama Penerima</label>
                            <input type="text" name="recipient_name" class="form-control rounded-3" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small">Nomor Telepon</label>
                            <input type="text" name="recipient_phone" class="form-control rounded-3" value="{{ optional(Auth::user()->customer)->phone ?? '' }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted small">Alamat Lengkap</label>
                            <textarea name="shipping_address" class="form-control rounded-3" rows="3" required placeholder="Jl. Raya No. 12, Kel. Kecamatan, Kota, Provinsi">{{ optional(Auth::user()->customer)->address ?? '' }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small">Kurir</label>
                            <select name="courier_name" class="form-select rounded-3">
                                <option value="JNE">JNE</option>
                                <option value="J&T">J&T</option>
                                <option value="SiCepat">SiCepat</option>
                                <option value="GoSend">GoSend</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small">Layanan Kurir</label>
                            <input type="text" name="courier_service" class="form-control rounded-3" placeholder="REG / YES / ECO">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted small">Metode Pembayaran</label>
                            <select id="payment_method" name="payment_method" class="form-select rounded-3" required>
                                <option value="transfer">Transfer Bank</option>
                                <option value="cod">Bayar di Tempat (COD)</option>
                                <option value="ewallet">E-Wallet (OVO/Dana/GoPay)</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="ewalletProviderWrapper" style="display:none;">
                            <label class="form-label fw-semibold text-muted small">Pilih E-Wallet</label>
                            <select name="ewallet_provider" class="form-select rounded-3">
                                <option value="OVO">OVO</option>
                                <option value="Dana">Dana</option>
                                <option value="GoPay">GoPay</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted small">Catatan Pembayaran / Detail</label>
                            <textarea name="payment_details" class="form-control rounded-3" rows="2" placeholder="Mis. Nama Bank, No. Rekening, atau catatan (opsional)"></textarea>
                        </div>
                    </div>
                </form>
                <script>
                    (function(){
                        const pm = document.getElementById('payment_method');
                        const wrapper = document.getElementById('ewalletProviderWrapper');
                        function toggle() {
                            if (!pm) return;
                            wrapper.style.display = pm.value === 'ewallet' ? 'block' : 'none';
                        }
                        if (pm) {
                            pm.addEventListener('change', toggle);
                            toggle();
                        }
                    })();
                </script>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-4">Ringkasan Pembayaran</h5>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Harga ({{ count($cartItems) }} produk)</span>
                    <span class="fw-semibold text-dark">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Ongkos Kirim</span>
                    <span class="fw-semibold text-dark">Rp {{ number_format(get_setting('default_shipping_fee'), 0, ',', '.') }}</span>
                </div>
                
                <hr class="my-3">
                
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold text-dark fs-5">Total Bayar</span>
                    <span class="fw-bold text-success fs-5">Rp {{ number_format($totalAmount + get_setting('default_shipping_fee'), 0, ',', '.') }}</span>
                </div>

                <button type="submit" form="checkoutForm" class="btn btn-primary-custom w-100 py-3 rounded-3 fw-bold">
                    <i class="bi bi-credit-card-fill me-2"></i> Buat Pesanan Sekarang
                </button>
                
                <a href="{{ route('cart.index') }}" class="btn btn-light w-100 py-2.5 rounded-3 mt-3 fw-semibold text-muted border">
                    <i class="bi bi-chevron-left me-1"></i> Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
