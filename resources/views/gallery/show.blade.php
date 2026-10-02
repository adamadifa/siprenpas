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
            <a href="{{ route('gallery.edit', $album->id) }}" class="btn btn-warning"><i class="ti ti-edit me-1"></i>Edit Album</a>
            <a href="{{ route('gallery.index') }}" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i>Kembali</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-circle-check me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="alert alert-primary d-flex align-items-center gap-2 mb-3" role="alert">
        <i class="ti ti-info-circle fs-4"></i>
        <div>
            <strong>Info Hero Section Website:</strong> Aktifkan tanda <strong>"Tampil di Hero"</strong> pada foto yang ingin dimunculkan pada animasi marquee hero section di halaman utama web.
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header pb-0">
            <h5 class="card-title mb-0"><i class="ti ti-cloud-upload me-2 text-primary"></i>Upload Foto ke Album Ini</h5>
        </div>
        <div class="card-body pt-3">
            <form action="{{ route('gallery.photos.upload', $album->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Foto (Bisa pilih banyak sekaligus)</label>
                    <input type="file" name="photos[]" class="form-control @error('photos.*') is-invalid @enderror" accept="image/*" multiple required>
                    <div class="form-text">Format: JPG, PNG, GIF, SVG, WEBP. Maksimal 4MB per foto.</div>
                    @error('photos.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary"><i class="ti ti-upload me-1"></i>Upload Foto</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
        @forelse ($album->photos as $photo)
            <div class="col" id="photo-card-{{ $photo->id }}">
                <div class="card h-100 shadow-sm border {{ $photo->is_hero ? 'border-primary border-2' : '' }}">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $photo->path) }}" class="card-img-top" style="height:190px; object-fit:cover;" alt="{{ $photo->title ?? 'Photo' }}">
                        
                        <!-- Badge Hero Indicator -->
                        <span id="hero-badge-{{ $photo->id }}" class="badge bg-primary position-absolute top-0 start-0 m-2 shadow-sm {{ $photo->is_hero ? '' : 'd-none' }}">
                            <i class="ti ti-sparkles me-1"></i>Tampil di Hero
                        </span>
                    </div>

                    <div class="card-body p-3 d-flex flex-col justify-content-between">
                        <div class="w-100">
                            <!-- Toggle Hero Checkbox / Switch Button -->
                            <form action="{{ route('gallery.photos.toggle-hero', [$album->id, $photo->id]) }}" method="POST" class="form-toggle-hero mb-2" data-photo-id="{{ $photo->id }}">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $photo->is_hero ? 'btn-primary' : 'btn-outline-primary' }} w-100 btn-hero-toggle" id="btn-hero-{{ $photo->id }}">
                                    <i class="ti {{ $photo->is_hero ? 'ti-check' : 'ti-plus' }} me-1" id="icon-hero-{{ $photo->id }}"></i>
                                    <span id="text-hero-{{ $photo->id }}">{{ $photo->is_hero ? 'Tampil di Hero (Aktif)' : 'Tampilkan di Hero' }}</span>
                                </button>
                            </form>

                            <!-- Delete Photo Form -->
                            <form action="{{ route('gallery.photos.destroy', [$album->id, $photo->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                    <i class="ti ti-trash me-1"></i>Hapus Foto
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-4">
                    <i class="ti ti-photo-off fs-1 d-block mb-2"></i>
                    Belum ada foto dalam album ini. Silakan upload foto menggunakan form di atas.
                </div>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.form-toggle-hero');
    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const photoId = form.getAttribute('data-photo-id');
            const btn = document.getElementById('btn-hero-' + photoId);
            const icon = document.getElementById('icon-hero-' + photoId);
            const text = document.getElementById('text-hero-' + photoId);
            const badge = document.getElementById('hero-badge-' + photoId);
            const card = document.querySelector('#photo-card-' + photoId + ' .card');

            btn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                if (data.success) {
                    if (data.is_hero) {
                        btn.className = 'btn btn-sm btn-primary w-100 btn-hero-toggle';
                        icon.className = 'ti ti-check me-1';
                        text.textContent = 'Tampil di Hero (Aktif)';
                        badge.classList.remove('d-none');
                        card.classList.add('border-primary', 'border-2');
                    } else {
                        btn.className = 'btn btn-sm btn-outline-primary w-100 btn-hero-toggle';
                        icon.className = 'ti ti-plus me-1';
                        text.textContent = 'Tampilkan di Hero';
                        badge.classList.add('d-none');
                        card.classList.remove('border-primary', 'border-2');
                    }
                }
            })
            .catch(err => {
                btn.disabled = false;
                // Fallback submit form normally if fetch fails
                form.submit();
            });
        });
    });
});
</script>
@endpush
@endsection
