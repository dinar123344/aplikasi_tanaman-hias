@extends('layouts.customer')

@section('title', 'Profil Akun - Toko Tanaman Hias')
@section('page_title', 'Profil Akun')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3">Informasi Akun</h5>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle fw-bold fs-2 mb-3 shadow-sm" style="width: 90px; height: 90px; background: linear-gradient(135deg, #74C69D, #2D6A4F) !important;">
                    {{ substr($user->name, 0, 1) }}
                </div>
            </div>
                        
                    

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Email</label>
                        <input type="email" name="email" class="form-control rounded-3" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <hr>
                    <h6 class="fw-bold mb-3">Ubah Password</h6>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Password Baru</label>
                        <input type="password" name="password" class="form-control rounded-3" placeholder="Kosongkan jika tidak ingin diubah">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-3" placeholder="Ulangi password baru">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom px-4 py-2 fw-bold">Simpan</button>
                        <a href="{{ route('profile.contact') }}" class="btn btn-outline-secondary px-4 py-2">Edit Kontak & Alamat</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
