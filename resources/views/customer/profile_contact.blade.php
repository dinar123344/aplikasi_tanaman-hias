@extends('layouts.customer')

@section('title', 'Kontak & Alamat - Toko Tanaman Hias')
@section('page_title', 'Kontak & Alamat')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3">Informasi Kontak & Pengiriman</h5>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('profile.contact.update') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted small">No. HP</label>
                            <input type="text" name="phone" class="form-control rounded-3" value="{{ old('phone', optional($user->customer)->phone) }}" placeholder="0812xxxx">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted small">Tanggal Lahir (opsional)</label>
                            <input type="date" name="birthdate" class="form-control rounded-3" value="{{ old('birthdate', optional($user->customer)->birthdate ?? '') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Alamat Pengiriman</label>
                        <textarea name="address" class="form-control rounded-3" rows="3" placeholder="Alamat lengkap untuk pengiriman">{{ old('address', optional($user->customer)->address) }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom px-4 py-2 fw-bold">Simpan Alamat</button>
                        <a href="{{ route('profile') }}" class="btn btn-outline-secondary px-4 py-2">Kembali ke Akun</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
