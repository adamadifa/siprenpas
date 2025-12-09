@extends('layouts.app')
@section('titlepage', 'Tambah Pilar Pendidikan')

@section('content')
@section('navigasi')
    <span>Pilar Pendidikan</span>
@endsection

<div class="row">
    <div class="col-lg-8 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tambah Pilar Pendidikan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pilar-pendidikan.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="nama_pilar" class="form-label">Nama Pilar <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_pilar') is-invalid @enderror"
                                    id="nama_pilar" name="nama_pilar" value="{{ old('nama_pilar') }}" required>
                                @error('nama_pilar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="urutan" class="form-label">Urutan <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                    id="urutan" name="urutan" value="{{ old('urutan', 0) }}" min="0" required>
                                @error('urutan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i> Simpan
                                </button>
                                <a href="{{ route('pilar-pendidikan.index') }}" class="btn btn-secondary">
                                    <i class="ti ti-arrow-left me-1"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

