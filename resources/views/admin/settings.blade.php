@extends('layouts.admin')

@section('title', 'Pengaturan Toko - Toko Tanaman Hias')
@section('page_title', 'Pengaturan Toko')

@section('content')
<div class="row g-4 fade-in-up">
    <div class="col-lg-8 mx-auto">
        <div class="dashboard-card shadow-sm">
            <div class="dashboard-card__header bg-white">
                <div>
                    <h5 class="fw-bold mb-1">Konfigurasi Toko Tanaman</h5>
                    <p class="text-muted mb-0">Ubah informasi umum, alamat toko, dan pengaturan pengiriman default.</p>
                </div>
                <div class="dashboard-card__action-icon text-success">
                    <i class="bi bi-gear-fill"></i>
                </div>
            </div>
            
            <div class="dashboard-card__body p-4">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    
                    {{-- Section 1: Informasi Umum --}}
                    <div class="mb-4 pb-4 border-bottom">
                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-info-circle-fill me-2"></i> Informasi Umum</h6>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small uppercase">Nama Toko</label>
                                <input type="text" name="store_name" class="form-control rounded-3" value="{{ get_setting('store_name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small uppercase">Slogan</label>
                                <input type="text" name="store_slogan" class="form-control rounded-3" value="{{ get_setting('store_slogan') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small uppercase">Nomor WhatsApp Admin</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-whatsapp"></i></span>
                                    <input type="text" name="store_whatsapp" class="form-control rounded-3" value="{{ get_setting('store_whatsapp') }}" placeholder="Contoh: 0812...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small uppercase">Email Kontak</label>
                                <input type="email" name="store_email" class="form-control rounded-3" value="{{ get_setting('store_email') }}" required>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Alamat Toko --}}
                    <div class="mb-4 pb-4 border-bottom">
                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-geo-alt-fill me-2"></i> Alamat Toko</h6>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small uppercase">Alamat Lengkap</label>
                            <textarea name="store_address" class="form-control rounded-3" rows="3" required>{{ get_setting('store_address') }}</textarea>
                        </div>
                    </div>

                    {{-- Section 3: Pengiriman & Finansial --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-truck me-2"></i> Pengiriman & Tarif</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small uppercase">Tarif Pengiriman Default (Flat)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="number" name="default_shipping_fee" class="form-control rounded-3" value="{{ get_setting('default_shipping_fee') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small uppercase">Mata Uang</label>
                                <select name="currency" class="form-select rounded-3">
                                    <option value="IDR" {{ get_setting('currency') == 'IDR' ? 'selected' : '' }}>Rupiah (IDR)</option>
                                    <option value="USD" {{ get_setting('currency') == 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-success border-2 rounded-pill px-4 py-2.5 fw-semibold shadow-sm">
                            <i class="bi bi-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-control:focus, .form-select:focus {
    border-color: #2D6A4F;
    box-shadow: 0 0 0 0.25rem rgba(45, 106, 79, 0.15);
}
.uppercase {
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
</style>
@endpush
