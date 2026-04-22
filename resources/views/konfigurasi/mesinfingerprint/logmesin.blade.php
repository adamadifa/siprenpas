@extends('layouts.app')
@section('titlepage', 'Log Mesin Presensi')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-list-details fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Log Aktifitas Mesin</h4>
                        <p class="text-muted mb-0 small">Histori sinkronisasi data dari perangkat fingerprint</p>
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
                                <a href="{{ route('mesinfingerprint.index') }}" class="text-muted">Mesin Fingerprint</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-history me-1"></i> Log Mesin
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12">
        <!-- Search & Filter Bar -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('mesinfingerprint.index') }}" class="btn btn-label-secondary d-flex align-items-center gap-2">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <form method="GET" action="{{ route('mesinfingerprint.logmesin') }}" class="d-flex align-items-center gap-2">
                        <div class="input-group shadow-none border rounded overflow-hidden" style="width: 250px;">
                            <span class="input-group-text border-0 bg-transparent text-muted"><i class="ti ti-calendar"></i></span>
                            <input type="date" name="tanggal" class="form-control border-0 bg-transparent"
                                value="{{ request('tanggal', date('Y-m-d')) }}">
                        </div>
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2" style="background-color: #064e3b; border-color: #064e3b">
                            <i class="ti ti-filter"></i> Filter
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-database fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Log Sinkronisasi</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3 text-center" style="width: 1%;">NO.</th>
                                <th class="text-white py-3">WAKTU SISTEM</th>
                                <th class="text-white py-3 text-center">PIN</th>
                                <th class="text-white py-3 text-center">JAM ABSEN</th>
                                <th class="text-white py-3 text-center">SCAN</th>
                                <th class="text-white py-3">NAMA PERANGKAT</th>
                                <th class="text-white py-3 text-center">STATUS</th>
                                <th class="text-white py-3">KETERANGAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logmesin as $d)
                                <tr>
                                    <td class="py-2 text-center small text-muted">{{ $loop->iteration + ($logmesin->currentPage() - 1) * $logmesin->perPage() }}</td>
                                    <td class="py-2 small fw-medium">
                                        <div class="d-flex flex-column">
                                            <span class="text-dark">{{ $d->created_at ? $d->created_at->format('d/m/Y') : '-' }}</span>
                                            <span class="text-muted extra-small">{{ $d->created_at ? $d->created_at->format('H:i:s') : '' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-2 text-center">
                                        <span class="badge bg-label-dark fw-bold px-3">{{ $d->pin }}</span>
                                    </td>
                                    <td class="py-2 text-center fw-bold text-success">{{ $d->jam_absen }}</td>
                                    <td class="py-2 text-center">
                                        <span class="badge bg-label-info">{{ $d->status_scan }}</span>
                                    </td>
                                    <td class="py-2">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ $d->nama_mesin ?? 'Unknown' }}</span>
                                            <span class="text-muted extra-small">{{ $d->sn ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-2 text-center">
                                        @if ($d->status == 1)
                                            <span class="badge bg-success shadow-none rounded-pill px-3">
                                                <i class="ti ti-circle-check me-1"></i> Berhasil
                                            </span>
                                        @else
                                            <span class="badge bg-danger shadow-none rounded-pill px-3">
                                                <i class="ti ti-circle-x me-1"></i> Gagal
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-2">
                                        <span class="text-muted small d-inline-block text-truncate" style="max-width: 200px;" title="{{ $d->keterangan }}">
                                            {{ $d->keterangan }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-database-off fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Tidak Ada Data Log</h5>
                                        <p class="text-muted">Tidak ditemukan log sinkronisasi pada tanggal yang dipilih.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top">
                    {{ $logmesin->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .extra-small { font-size: 0.7rem; }
    .table td { vertical-align: middle; }
</style>
@endsection
