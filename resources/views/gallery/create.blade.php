@extends('layouts.app')
@section('titlepage', 'Tambah Album')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Tambah Album</h4>
        <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Judul Album <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Cover Album</label>
                    <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
                    <div class="form-text">Opsional. Maksimal 4MB.</div>
                    @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Batal</a>
                    <button class="btn btn-primary" type="submit"><i class="ti ti-device-floppy me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

