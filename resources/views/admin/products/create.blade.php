@extends('layouts.admin')

@section('title', 'Tambah Produk - Admin Panel')
@section('page_title', 'Tambah Produk')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-medium">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-light border-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Monstera Deliciosa">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select bg-light border-0 @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-medium">Status <span class="text-danger">*</span></label>
                            <select class="form-select bg-light border-0 @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-medium">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control bg-light border-0 @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required min="0">
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="stock" class="form-label fw-medium">Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control bg-light border-0 @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}" required min="0">
                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label fw-medium">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control bg-light border-0 @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label fw-medium">Gambar Produk</label>
                        <input type="file" class="form-control bg-light border-0 @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        <div class="form-text">Format: JPG, PNG. Maksimal 2MB.</div>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom px-4">Simpan Produk</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
