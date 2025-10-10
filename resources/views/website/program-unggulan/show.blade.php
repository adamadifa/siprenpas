@extends('layouts.app')
@section('titlepage', 'Detail Program Unggulan')

@section('content')
@section('navigasi')
    <span>Program Unggulan</span>
@endsection

<div class="row">
    <div class="col-lg-8 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Detail Program Unggulan</h5>
                <div class="d-flex gap-2">
                    @can('program-unggulan.edit')
                        <a href="{{ route('program-unggulan.edit', $programUnggulan) }}" class="btn btn-warning">
                            <i class="ti ti-pencil me-1"></i>
                            Edit
                        </a>
                    @endcan
                    <a href="{{ route('program-unggulan.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Nama Program</label>
                            <p class="form-control-plaintext">{{ $programUnggulan->nama_program }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Urutan</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-primary">{{ $programUnggulan->urutan }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <div class="form-control-plaintext">
                                @if ($programUnggulan->deskripsi)
                                    {{ $programUnggulan->deskripsi }}
                                @else
                                    <em class="text-muted">Tidak ada deskripsi</em>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Dibuat</label>
                            <p class="form-control-plaintext">{{ $programUnggulan->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Diperbarui</label>
                            <p class="form-control-plaintext">{{ $programUnggulan->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
