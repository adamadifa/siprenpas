@extends('layouts.app')
@section('titlepage', 'Album: ' . $album->title)
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1">{{ $album->title }}</h4>
            <p class="text-muted mb-0">{{ $album->description }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('gallery.edit', $album->id) }}" class="btn btn-warning"><i class="ti ti-edit me-1"></i>Edit</a>
            <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('gallery.photos.upload', $album->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Upload Foto (bisa lebih dari satu)</label>
                    <input type="file" name="photos[]" class="form-control @error('photos.*') is-invalid @enderror" accept="image/*" multiple required>
                    <div class="form-text">Format: JPG, PNG, GIF, SVG. Maksimal 4MB per foto.</div>
                    @error('photos.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary"><i class="ti ti-upload me-1"></i>Upload</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
        @forelse ($album->photos as $photo)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $photo->path) }}" class="card-img-top" style="height:180px; object-fit:cover;" alt="{{ $photo->title ?? 'Photo' }}">
                    <div class="card-body p-2">
                        <form action="{{ route('gallery.photos.destroy', [$album->id, $photo->id]) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger w-100"><i class="ti ti-trash me-1"></i>Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">Belum ada foto dalam album ini.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection

