@extends('layouts.app')
@section('titlepage', 'Edit Album')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Edit Album</h4>
        <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('gallery.update', $album->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Judul Album <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $album->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $album->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Cover Album</label>
                    @if($album->cover)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $album->cover) }}" alt="Cover" class="img-fluid rounded" style="max-height:150px;">
                            <p class="text-muted small mt-1">Cover saat ini</p>
                        </div>
                    @endif
                    <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
                    <div class="form-text">Kosongkan jika tidak ingin mengubah. Maksimal 4MB.</div>
                    @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Batal</a>
                    <button class="btn btn-primary" type="submit"><i class="ti ti-device-floppy me-1"></i>Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

