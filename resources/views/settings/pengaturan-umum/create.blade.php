@extends('layouts.app')

@section('title', 'Tambah Pengaturan Umum')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Tambah Pengaturan Umum</h5>
                        <a href="{{ route('pengaturan-umum.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>
                            Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pengaturan-umum.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_aplikasi" class="form-label">Nama Aplikasi</label>
                                        <input type="text" class="form-control @error('nama_aplikasi') is-invalid @enderror" id="nama_aplikasi"
                                            name="nama_aplikasi" value="{{ old('nama_aplikasi') }}">
                                        @error('nama_aplikasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_sekolah" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" id="nama_sekolah"
                                            name="nama_sekolah" value="{{ old('nama_sekolah') }}" required>
                                        @error('nama_sekolah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telepon" class="form-label">Telepon</label>
                                        <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon"
                                            value="{{ old('telepon') }}">
                                        @error('telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="session_lifetime" class="form-label">Durasi Login Session (Menit) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control @error('session_lifetime') is-invalid @enderror" id="session_lifetime"
                                                name="session_lifetime" value="{{ old('session_lifetime', 120) }}"
                                                required min="1">
                                            <span class="input-group-text">Menit</span>
                                        </div>
                                        <div class="form-text">Waktu habis sesi login otomatis (default: 120 menit).</div>
                                        @error('session_lifetime')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat_sekolah" class="form-label">Alamat Sekolah <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat_sekolah') is-invalid @enderror" id="alamat_sekolah" name="alamat_sekolah" rows="3" required>{{ old('alamat_sekolah') }}</textarea>
                                @error('alamat_sekolah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="website" class="form-label">Website</label>
                                        <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website"
                                            value="{{ old('website') }}" placeholder="https://example.com">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="facebook" class="form-label">Facebook</label>
                                        <input type="url" class="form-control @error('facebook') is-invalid @enderror" id="facebook" name="facebook"
                                            value="{{ old('facebook') }}" placeholder="https://facebook.com/username">
                                        @error('facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="youtube" class="form-label">YouTube</label>
                                        <input type="url" class="form-control @error('youtube') is-invalid @enderror" id="youtube" name="youtube"
                                            value="{{ old('youtube') }}" placeholder="https://youtube.com/channel/...">
                                        @error('youtube')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="instagram" class="form-label">Instagram</label>
                                        <input type="url" class="form-control @error('instagram') is-invalid @enderror" id="instagram" name="instagram"
                                            value="{{ old('instagram') }}" placeholder="https://instagram.com/username">
                                        @error('instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tiktok" class="form-label">TikTok</label>
                                        <input type="url" class="form-control @error('tiktok') is-invalid @enderror" id="tiktok" name="tiktok"
                                            value="{{ old('tiktok') }}" placeholder="https://www.tiktok.com/@username">
                                        @error('tiktok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo Sekolah</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo"
                                    accept="image/*">
                                <div class="form-text">Format yang didukung: JPEG, PNG, JPG, GIF, SVG. Maksimal 2MB.</div>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="background_login" class="form-label">Background Login (Kiri)</label>
                                <input type="file" class="form-control @error('background_login') is-invalid @enderror" id="background_login"
                                    name="background_login" accept="image/*">
                                <div class="form-text">Gunakan gambar ukuran besar (misal 1600x900). Maks 4MB.</div>
                                @error('background_login')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">
                            <h6 class="mb-3">Foto Model</h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="model_1" class="form-label">Model 1</label>
                                        <input type="file" class="form-control @error('model_1') is-invalid @enderror" id="model_1"
                                            name="model_1" accept="image/*">
                                        <div class="form-text">Format: JPEG, PNG, JPG, GIF, SVG. Maksimal 4MB.</div>
                                        @error('model_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="model_2" class="form-label">Model 2</label>
                                        <input type="file" class="form-control @error('model_2') is-invalid @enderror" id="model_2"
                                            name="model_2" accept="image/*">
                                        <div class="form-text">Format: JPEG, PNG, JPG, GIF, SVG. Maksimal 4MB.</div>
                                        @error('model_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="model_3" class="form-label">Model 3</label>
                                        <input type="file" class="form-control @error('model_3') is-invalid @enderror" id="model_3"
                                            name="model_3" accept="image/*">
                                        <div class="form-text">Format: JPEG, PNG, JPG, GIF, SVG. Maksimal 4MB.</div>
                                        @error('model_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="model_4" class="form-label">Model 4</label>
                                        <input type="file" class="form-control @error('model_4') is-invalid @enderror" id="model_4"
                                            name="model_4" accept="image/*">
                                        <div class="form-text">Format: JPEG, PNG, JPG, GIF, SVG. Maksimal 4MB.</div>
                                        @error('model_4')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('pengaturan-umum.index') }}" class="btn btn-secondary">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
