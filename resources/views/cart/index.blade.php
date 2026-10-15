@extends('layouts.customer')

@section('title', 'Keranjang Belanja - Toko Tanaman Hias')
@section('page_title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4"><i class="bi bi-cart3 me-2"></i>Keranjang Belanja</h3>

    @if(count($cartItems) > 0)
    <div class="row">
        <div class="col-lg-8">
            @foreach($cartItems as $item)
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            @php
                                $cartImage = $item['product']->image ? (preg_match('/^https?:\/\//', $item['product']->image) ? $item['product']->image : asset('storage/' . $item['product']->image)) : 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?auto=format&fit=crop&q=80&w=600&h=600';
                            @endphp
                            <img src="{{ $cartImage }}" class="rounded-3 w-100" style="height: 80px; object-fit: cover;" alt="{{ $item['product']->name }}">
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold mb-1">{{ $item['product']->name }}</h6>
                            <span class="badge bg-secondary small">{{ $item['product']->category->name }}</span>
                        </div>
                        <div class="col-md-2 text-center">
                            <small class="text-muted d-block">Harga</small>
                            <span class="fw-bold text-success">Rp {{ number_format($item['product']->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="col-md-2 text-center">
                            <form action="{{ route('cart.update', $item['product']) }}" method="POST" class="d-flex align-items-center justify-content-center gap-1">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock }}" class="form-control form-control-sm text-center border-0 bg-light" style="width: 65px;" onchange="this.form.submit()">
                            </form>
                        </div>
                        <div class="col-md-1 text-end">
                            <span class="fw-bold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        <div class="col-md-1 text-end">
                            <form action="{{ route('cart.remove', $item['product']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 border-0">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                    
                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Total Item</span>
                        <span>{{ count($cartItems) }} produk</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total Harga</span>
                        <span class="fw-bold fs-5 text-success">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold" onclick="return confirm('Lanjutkan ke checkout?')">
                            <i class="bi bi-bag-check me-2"></i> Checkout Sekarang
                        </button>
                    </form>
                    
                    <a href="{{ url('/') }}" class="btn btn-outline-custom w-100 mt-2 py-2">
                        <i class="bi bi-arrow-left me-1"></i> Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <div class="p-5 bg-white rounded-4 shadow-sm d-inline-block">
            <i class="bi bi-cart-x display-1 text-muted d-block mb-3"></i>
            <h4 class="text-muted mb-2">Keranjang Anda masih kosong</h4>
            <p class="text-muted mb-4">Yuk mulai belanja tanaman hias favoritmu!</p>
            <a href="{{ url('/') }}" class="btn btn-primary-custom px-5 py-2">Belanja Sekarang</a>
        </div>
    </div>
    @endif
</div>
@endsection
