@extends('layouts.app')

@section('title', 'Edit Pengaturan Umum')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Edit Pengaturan Umum</h5>
                        <a href="{{ route('pengaturan-umum.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>
                            Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pengaturan-umum.update', $pengaturan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_aplikasi" class="form-label">Nama Aplikasi</label>
                                        <input type="text" class="form-control @error('nama_aplikasi') is-invalid @enderror" id="nama_aplikasi"
                                            name="nama_aplikasi" value="{{ old('nama_aplikasi', $pengaturan->nama_aplikasi) }}">
                                        @error('nama_aplikasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_sekolah" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" id="nama_sekolah"
                                            name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturan->nama_sekolah) }}" required>
                                        @error('nama_sekolah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telepon" class="form-label">Telepon</label>
                                        <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon"
                                            value="{{ old('telepon', $pengaturan->telepon) }}">
                                        @error('telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat_sekolah" class="form-label">Alamat Sekolah <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat_sekolah') is-invalid @enderror" id="alamat_sekolah" name="alamat_sekolah" rows="3" required>{{ old('alamat_sekolah', $pengaturan->alamat_sekolah) }}</textarea>
                                @error('alamat_sekolah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                            value="{{ old('email', $pengaturan->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="website" class="form-label">Website</label>
                                        <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website"
                                            value="{{ old('website', $pengaturan->website) }}" placeholder="https://example.com">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo Sekolah</label>
                                @if ($pengaturan->logo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo Sekolah" class="img-fluid rounded"
                                            style="max-height: 150px;">
                                        <p class="text-muted small mt-1">Logo saat ini</p>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo"
                                    accept="image/*">
                                <div class="form-text">Format yang didukung: JPEG, PNG, JPG, GIF, SVG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah
                                    logo.</div>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="background_login" class="form-label">Background Login (Kiri)</label>
                                @if ($pengaturan->background_login)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $pengaturan->background_login) }}" alt="Background Login"
                                            class="img-fluid rounded" style="max-height: 180px;">
                                        <p class="text-muted small mt-1">Background login saat ini</p>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('background_login') is-invalid @enderror" id="background_login"
                                    name="background_login" accept="image/*">
                                <div class="form-text">Disarankan ukuran besar (misal 1600x900). Maksimal 4MB. Kosongkan jika tidak ingin mengubah.</div>
                                @error('background_login')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('pengaturan-umum.index') }}" class="btn btn-secondary">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
