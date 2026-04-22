@extends('layouts.app')

@section('titlepage', 'Sebaran Alumni')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-school fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Sebaran Alumni</h4>
                        <p class="text-muted mb-0 small">Manajemen data universitas sebaran alumni</p>
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
                            <li class="breadcrumb-item active">
                                <i class="ti ti-school me-1"></i> Sebaran Alumni
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-7">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('sebaran-alumni.create') }}" class="btn d-flex align-items-center gap-2 shadow-sm text-white"
                style="background-color: #064e3b">
                <i class="ti ti-plus fs-4"></i>
                <span>Tambah Sebaran Alumni</span>
            </a>
        </div>

        <!-- Filter Section -->
        <style>
            .form-filter .form-group {
                margin-bottom: 0 !important;
            }
        </style>
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('sebaran-alumni.index') }}" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-11 col-md-10">
                            <x-input-with-icon label="" value="{{ Request('nama_universitas') }}" name="nama_universitas"
                                placeholder="Cari Nama Universitas" icon="ti ti-search" />
                        </div>
                        <div class="col-lg-1 col-md-2">
                            <button type="submit" class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center"
                                style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search fs-5"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-school fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Sebaran Alumni</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 1%;">NO.</th>
                                <th class="text-white py-3 text-center" style="width: 80px;">LOGO</th>
                                <th class="text-white py-3">NAMA UNIVERSITAS</th>
                                <th class="text-white py-3 text-end" style="width: 80px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $d)
                                <tr>
                                    <td class="py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2 text-center">
                                        @if ($d->logo && Storage::disk('public')->exists($d->logo))
                                            <div class="avatar avatar-lg rounded overflow-hidden border bg-white p-1 shadow-sm mx-auto" style="width: 50px; height: 50px;">
                                                <img src="{{ asset('storage/' . $d->logo) }}" alt="{{ $d->nama_universitas }}" style="object-fit: contain; width: 100%; height: 100%;">
                                            </div>
                                        @else
                                            <div class="avatar avatar-lg rounded bg-label-success mx-auto d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;">
                                                <i class="ti ti-building-community fs-3"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-2 fw-bold text-dark">{{ $d->nama_universitas }}</td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('sebaran-alumni.edit', $d->id) }}"
                                                class="btn btn-icon btn-label-success border"
                                                style="width: 28px; height: 28px;">
                                                <i class="ti ti-edit fs-6"></i>
                                            </a>
                                            <form method="POST" class="deleteform" action="{{ route('sebaran-alumni.destroy', $d->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                                    style="width: 28px; height: 28px;">
                                                    <i class="ti ti-trash fs-6"></i>
                                                </a>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-school fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Alumni</h5>
                                        <p class="text-muted">Silahkan tambah data universitas sebaran alumni baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
