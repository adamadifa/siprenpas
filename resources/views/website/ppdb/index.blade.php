@extends('layouts.app')
@section('titlepage', 'PPDB Website Settings')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-file-text fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">PPDB Settings</h4>
                        <p class="text-muted mb-0 small">Manajemen brosur utama, brosur per unit, dan rincian biaya pendaftaran</p>
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
                                <i class="ti ti-file-text me-1"></i> PPDB Settings
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="d-flex">
            <i class="ti ti-check-circle me-2 fs-4"></i>
            <div>
                {{ Session::get('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex">
            <i class="ti ti-alert-triangle me-2 fs-4"></i>
            <div>
                {{ Session::get('error') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('ppdb-setting.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Brosur Utama -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                    <i class="ti ti-files fs-5"></i>
                    <h6 class="card-title mb-0 text-white font-weight-bold">Brosur Utama PPDB</h6>
                </div>
                <div class="card-body pt-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Upload Brosur Utama <span class="text-muted">(PDF, JPG, PNG - Max 5MB)</span></label>
                                <input type="file" class="form-control @error('brosur_utama') is-invalid @enderror" name="brosur_utama" accept=".pdf,.jpeg,.png,.jpg">
                                @error('brosur_utama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text mt-2">
                                    Brosur utama digunakan untuk promosi pendaftaran PPDB secara keseluruhan di semua unit.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            @if($pengaturan && $pengaturan->brosur_utama)
                                <div class="p-3 border rounded bg-light">
                                    <i class="ti ti-file-text text-success fs-1 mb-2 d-block"></i>
                                    <a href="{{ asset('storage/' . $pengaturan->brosur_utama) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                        <i class="ti ti-download me-1"></i> Lihat Brosur Utama
                                    </a>
                                </div>
                            @else
                                <div class="p-3 border border-dashed rounded text-muted">
                                    Belum ada brosur utama yang diunggah
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Brosur & Rincian Biaya per Unit -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                    <i class="ti ti-layout-grid fs-5"></i>
                    <h6 class="card-title mb-0 text-white font-weight-bold">Brosur & Rincian Biaya per Unit Sekolah</h6>
                </div>
                <div class="card-body pt-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="text-white" style="background-color: #064e3b">
                                <tr>
                                    <th width="5%" class="text-center text-white">Logo</th>
                                    <th width="20%" class="text-white">Unit Sekolah</th>
                                    <th width="25%" class="text-white">Brosur per Unit (PDF/JPG/PNG)</th>
                                    <th width="25%" class="text-white">Rincian Biaya Full Day (Image)</th>
                                    <th width="25%" class="text-white">Rincian Biaya Boarding (Image)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($units as $unit)
                                    <tr>
                                        <td class="text-center">
                                            @if ($unit->logo && Storage::disk('public')->exists($unit->logo))
                                                <img src="{{ asset('storage/' . $unit->logo) }}" alt="Logo" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="avatar bg-label-secondary d-inline-flex align-items-center justify-content-center rounded" style="width: 40px; height: 40px;">
                                                    <i class="ti ti-school"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark">{{ $unit->nama_unit }}</span>
                                            <small class="text-muted d-block">Kode: {{ $unit->kode_unit }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">
                                                <input type="file" class="form-control form-control-sm" name="brosur_unit[{{ $unit->kode_unit }}]" accept=".pdf,.jpeg,.png,.jpg">
                                                @if ($unit->brosur_unit)
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-label-success text-xxs">
                                                            <i class="ti ti-check me-1"></i> Tersedia
                                                        </span>
                                                        <a href="{{ asset('storage/' . $unit->brosur_unit) }}" target="_blank" class="btn btn-xs btn-label-success py-1 px-2">
                                                            <i class="ti ti-download me-1"></i> Unduh
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">Belum ada brosur</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">
                                                <input type="file" class="form-control form-control-sm" name="rincian_biaya_fullday[{{ $unit->kode_unit }}]" accept=".jpeg,.png,.jpg,.webp">
                                                @if ($unit->rincian_biaya_fullday)
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-label-info text-xxs">
                                                            <i class="ti ti-photo me-1"></i> Tersedia
                                                        </span>
                                                        <a href="{{ asset('storage/' . $unit->rincian_biaya_fullday) }}" target="_blank" class="btn btn-xs btn-label-info py-1 px-2">
                                                            <i class="ti ti-eye me-1"></i> Lihat
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">Belum ada biaya fullday</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">
                                                <input type="file" class="form-control form-control-sm" name="rincian_biaya_boarding[{{ $unit->kode_unit }}]" accept=".jpeg,.png,.jpg,.webp">
                                                @if ($unit->rincian_biaya_boarding)
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-label-info text-xxs">
                                                            <i class="ti ti-photo me-1"></i> Tersedia
                                                        </span>
                                                        <a href="{{ asset('storage/' . $unit->rincian_biaya_boarding) }}" target="_blank" class="btn btn-xs btn-label-info py-1 px-2">
                                                            <i class="ti ti-eye me-1"></i> Lihat
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">Belum ada biaya boarding</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center p-4">Tidak ada data unit tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-12 text-end mb-5">
            <button type="submit" class="btn btn-primary px-4 py-2 d-inline-flex align-items-center gap-2" style="background-color: #064e3b; border-color: #064e3b">
                <i class="ti ti-device-floppy fs-5"></i>
                <span>Simpan Semua Pengaturan PPDB</span>
            </button>
        </div>
    </div>
</form>
@endsection
