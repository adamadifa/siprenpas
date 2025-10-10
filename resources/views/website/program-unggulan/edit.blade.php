@extends('layouts.app')
@section('titlepage', 'Edit Program Unggulan')

@section('content')
@section('navigasi')
    <span>Program Unggulan</span>
@endsection

<div class="row">
    <div class="col-lg-8 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Program Unggulan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('program-unggulan.update', $programUnggulan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="nama_program" class="form-label">Nama Program <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_program') is-invalid @enderror"
                                    id="nama_program" name="nama_program"
                                    value="{{ old('nama_program', $programUnggulan->nama_program) }}" required>
                                @error('nama_program')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="urutan" class="form-label">Urutan <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                    id="urutan" name="urutan" value="{{ old('urutan', $programUnggulan->urutan) }}"
                                    min="0" required>
                                @error('urutan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $programUnggulan->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i> Update
                                </button>
                                <a href="{{ route('program-unggulan.index') }}" class="btn btn-secondary">
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
