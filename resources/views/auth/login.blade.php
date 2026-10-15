@extends('layouts.app')

@section('title', 'Login - Toko Tanaman Hias')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 fade-in-up">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-flower1 text-success display-4"></i>
                        <h3 class="fw-bold mt-2">Selamat Datang Kembali</h3>
                        <p class="text-muted">Silakan masuk ke akun Anda</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-start-0" id="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-start-0" id="password" required placeholder="********">
                            </div>
                        </div>
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label text-muted" for="remember">Ingat Saya</label>
                            </div>
                            <a href="#" class="text-success text-decoration-none small fw-medium">Lupa Password?</a>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary-custom py-2">Masuk</button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-success fw-bold text-decoration-none">Daftar sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
