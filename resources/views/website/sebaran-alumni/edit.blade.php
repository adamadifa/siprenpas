@extends('layouts.app')

@section('title', 'Edit Sebaran Alumni')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Sebaran Alumni</h5>
                <a href="{{ route('sebaran-alumni.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('sebaran-alumni.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" for="nama_universitas">Nama Universitas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_universitas') is-invalid @enderror" id="nama_universitas"
                            name="nama_universitas" value="{{ old('nama_universitas', $item->nama_universitas) }}" required>
                        @error('nama_universitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="logo">Logo Universitas</label>
                        @if ($item->logo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $item->logo) }}" alt="logo" class="img-fluid" style="max-height: 80px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                        <div class="form-text">Kosongkan jika tidak ingin mengubah. Maks 2MB.</div>
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('sebaran-alumni.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
