@extends('layouts.app')
@section('titlepage', 'Galeri Kegiatan')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Galeri Kegiatan</h4>
        <a href="{{ route('gallery.create') }}" class="btn btn-primary">
            <i class="ti ti-plus me-1"></i>Tambah Album
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3">
        @forelse ($albums as $album)
            <div class="col">
                <div class="card h-100">
                    @if($album->cover)
                        <img src="{{ asset('storage/' . $album->cover) }}" class="card-img-top" style="height:180px; object-fit:cover;" alt="{{ $album->title }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height:180px;">
                            <i class="ti ti-photo text-muted" style="font-size:2rem;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-title mb-1">{{ $album->title }}</h6>
                        <p class="text-muted small mb-2">{{ Str::limit($album->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success">{{ $album->photos_count }} foto</span>
                            <div>
                                <a href="{{ route('gallery.show', $album->id) }}" class="btn btn-sm btn-outline-primary">Kelola</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">Belum ada album</div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $albums->links() }}
    </div>
</div>
@endsection

