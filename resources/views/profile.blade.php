@extends('layouts.customer')

@section('title', 'Profil Saya - Toko Tanaman Hias')
@section('page_title', 'Profil Saya')

@section('content')
<div class="container py-5">
    <div class="row g-4 justify-content-center fade-in-up">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle fw-bold fs-2 mb-3 shadow-sm" style="width: 70px; height: 70px; background: linear-gradient(135deg, #74C69D, #2D6A4F) !important;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h5 class="fw-bold mb-1 text-dark">{{ $user->name }}</h5>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1.5 text-capitalize">{{ $user->role }}</span>
                </div>

                <hr class="my-4">

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small uppercase">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control rounded-3" value="{{ $user->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small uppercase">Email Address</label>
                        <input type="email" name="email" class="form-control rounded-3" value="{{ $user->email }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small uppercase">Password Baru <span class="text-muted fw-normal">(Biarkan kosong jika tidak ingin diubah)</span></label>
                        <input type="password" name="password" class="form-control rounded-3" placeholder="Minimal 6 karakter">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small uppercase">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-3" placeholder="Ulangi password baru">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small uppercase">No. HP</label>
                        <input type="text" name="phone" class="form-control rounded-3" value="{{ optional($user->customer)->phone }}" placeholder="0812xxxx" >
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small uppercase">Alamat Pengiriman</label>
                        <textarea name="address" class="form-control rounded-3" rows="3" placeholder="Alamat lengkap untuk pengiriman">{{ optional($user->customer)->address }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100 py-2.5 rounded-3 fw-bold">
                        <i class="bi bi-save me-2"></i> Simpan Profil
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.uppercase {
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
</style>
@endpush
