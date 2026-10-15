@extends('layouts.admin')

@section('title', 'Tambah Kategori - Admin Panel')
@section('page_title', 'Tambah Kategori')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-medium">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-light border-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Kaktus">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="form-label fw-medium">Deskripsi Singkat</label>
                        <textarea class="form-control bg-light border-0 @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Opsional...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom px-4">Simpan</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
