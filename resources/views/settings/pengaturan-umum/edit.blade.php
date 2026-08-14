@extends('layouts.app')

@section('titlepage', 'Edit Pengaturan Umum')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-settings fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Edit Pengaturan</h4>
                        <p class="text-muted mb-0 small">Perbarui konfigurasi sistem dan identitas lembaga</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-home-2 me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('pengaturan-umum.index') }}" class="text-muted">Pengaturan Umum</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-edit me-1"></i> Edit
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<form action="{{ route('pengaturan-umum.update', $pengaturan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row g-4">
        <!-- Main Configuration -->
        <div class="col-lg-8">
            <!-- Dasar & Kontak -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                    <i class="ti ti-info-circle fs-5"></i>
                    <h6 class="card-title mb-0 text-white">Informasi Dasar & Kontak</h6>
                </div>
                <div class="card-body pt-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Aplikasi</label>
                            <input type="text" class="form-control @error('nama_aplikasi') is-invalid @enderror" 
                                name="nama_aplikasi" value="{{ old('nama_aplikasi', $pengaturan->nama_aplikasi) }}"
                                placeholder="Masukkan nama aplikasi...">
                            @error('nama_aplikasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Lembaga <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" 
                                name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturan->nama_sekolah) }}" required
                                placeholder="Masukkan nama lembaga/sekolah...">
                            @error('nama_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Telepon</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                name="telepon" value="{{ old('telepon', $pengaturan->telepon) }}"
                                placeholder="Contoh: 021-123456">
                            @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email Resmi</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email', $pengaturan->email) }}"
                                placeholder="Contoh: info@lembaga.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Website Resmi</label>
                            <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                name="website" value="{{ old('website', $pengaturan->website) }}"
                                placeholder="https://www.lembaga.com">
                            @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat_sekolah') is-invalid @enderror" 
                                name="alamat_sekolah" rows="3" required
                                placeholder="Masukkan alamat lengkap lembaga...">{{ old('alamat_sekolah', $pengaturan->alamat_sekolah) }}</textarea>
                            @error('alamat_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media Sosial -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                    <i class="ti ti-share fs-5"></i>
                    <h6 class="card-title mb-0 text-white">Media Sosial</h6>
                </div>
                <div class="card-body pt-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Facebook URL</label>
                            <div class="input-group input-group-merge border rounded">
                                <span class="input-group-text border-0 text-primary"><i class="ti ti-brand-facebook"></i></span>
                                <input type="url" class="form-control border-0" name="facebook" value="{{ old('facebook', $pengaturan->facebook) }}" placeholder="https://facebook.com/...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Instagram URL</label>
                            <div class="input-group input-group-merge border rounded">
                                <span class="input-group-text border-0 text-danger"><i class="ti ti-brand-instagram"></i></span>
                                <input type="url" class="form-control border-0" name="instagram" value="{{ old('instagram', $pengaturan->instagram) }}" placeholder="https://instagram.com/...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">YouTube URL</label>
                            <div class="input-group input-group-merge border rounded">
                                <span class="input-group-text border-0 text-danger"><i class="ti ti-brand-youtube"></i></span>
                                <input type="url" class="form-control border-0" name="youtube" value="{{ old('youtube', $pengaturan->youtube) }}" placeholder="https://youtube.com/...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">TikTok URL</label>
                            <div class="input-group input-group-merge border rounded">
                                <span class="input-group-text border-0 text-dark"><i class="ti ti-brand-tiktok"></i></span>
                                <input type="url" class="form-control border-0" name="tiktok" value="{{ old('tiktok', $pengaturan->tiktok) }}" placeholder="https://tiktok.com/@...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Keamanan & Sesi -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                    <i class="ti ti-lock fs-5"></i>
                    <h6 class="card-title mb-0 text-white">Sesi & Keamanan</h6>
                </div>
                <div class="card-body pt-4">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Durasi Login Session (Menit) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('session_lifetime') is-invalid @enderror" 
                                    name="session_lifetime" value="{{ old('session_lifetime', $pengaturan->session_lifetime ?? 120) }}"
                                    required min="1">
                                <span class="input-group-text">Menit</span>
                            </div>
                            <div class="form-text mt-2"><i class="ti ti-info-circle me-1"></i>Waktu otomatis logout saat tidak ada aktifitas (Default: 120 Menit).</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visuals & Branding -->
        <div class="col-lg-4">
            <!-- Logo Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                    <i class="ti ti-photo fs-5"></i>
                    <h6 class="card-title mb-0 text-white">Logo Lembaga</h6>
                </div>
                <div class="card-body pt-4">
                    <div class="text-center mb-4 p-3 bg-light rounded-3 border-dashed border-2" style="border-style: dashed !important; border-color: #e0e0e0 !important;">
                        @if ($pengaturan->logo && Storage::disk('public')->exists($pengaturan->logo))
                            <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" class="img-fluid mb-2" style="max-height: 120px;">
                            <p class="small text-muted mb-0">Logo Saat Ini</p>
                        @else
                            <div class="avatar avatar-xl bg-label-secondary mx-auto mb-2">
                                <i class="ti ti-photo fs-2"></i>
                            </div>
                            <p class="small text-muted mb-0">Belum Ada Logo</p>
                        @endif
                    </div>
                    <div class="mb-0">
                        <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" accept="image/*">
                        <div class="form-text mt-2 small">Format: PNG, JPG, WEBP (Maks 2MB).</div>
                    </div>
                </div>
            </div>

            <!-- Background Login -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                    <i class="ti ti-layout-dashboard fs-5"></i>
                    <h6 class="card-title mb-0 text-white">Background Login</h6>
                </div>
                <div class="card-body pt-4">
                    <div class="text-center mb-4 p-2 bg-light rounded-3 overflow-hidden" style="height: 120px;">
                        @if ($pengaturan->background_login && Storage::disk('public')->exists($pengaturan->background_login))
                            <img src="{{ asset('storage/' . $pengaturan->background_login) }}" alt="BG" class="img-fluid" style="height: 100%; object-fit: cover; width: 100%;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                <i class="ti ti-wallpaper fs-2"></i>
                            </div>
                        @endif
                    </div>
                    <div class="mb-0">
                        <input type="file" class="form-control @error('background_login') is-invalid @enderror" name="background_login" accept="image/*">
                        <div class="form-text mt-2 small">Format: JPG, WEBP (Maks 4MB).</div>
                    </div>
                </div>
            </div>

            <!-- Foto Model (Condensed) -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                    <i class="ti ti-users fs-5"></i>
                    <h6 class="card-title mb-0 text-white">Foto Model Hero</h6>
                </div>
                <div class="card-body pt-4">
                    <div class="row g-3">
                        @for($i=1; $i<=4; $i++)
                            @php $modelField = 'model_'.$i; @endphp
                            <div class="col-6">
                                <label class="form-label small fw-bold">Model {{ $i }}</label>
                                <div class="bg-light rounded mb-2 overflow-hidden" style="height: 60px;">
                                    @if ($pengaturan->$modelField && Storage::disk('public')->exists($pengaturan->$modelField))
                                        <img src="{{ asset('storage/' . $pengaturan->$modelField) }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                            <i class="ti ti-user fs-4"></i>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" class="form-control form-control-sm" name="{{ $modelField }}" accept="image/*">
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Sticky Actions -->
            <div class="card shadow-sm border-0 sticky-top" style="top: 100px; z-index: 10;">
                <div class="card-body p-4">
                    <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2 py-2 mb-2 shadow-sm"
                        style="background-color: #064e3b; border-color: #064e3b">
                        <i class="ti ti-device-floppy fs-4"></i>
                        <span class="fw-bold">Simpan Perubahan</span>
                    </button>
                    <a href="{{ route('pengaturan-umum.index') }}" class="btn btn-label-secondary w-100">Batal</a>
                    <div class="mt-3 p-3 bg-label-warning rounded-3">
                        <p class="small mb-0 text-dark">
                            <i class="ti ti-info-circle me-1"></i> Perubahan pada konfigurasi sistem akan berdampak langsung pada seluruh interface aplikasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
