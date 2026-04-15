@extends('layouts.app')
@section('titlepage', 'Log Mesin Presensi')

@section('content')
@section('navigasi')
    <span class="text-muted fw-light">Konfigurasi / Mesin Fingerprint /</span> Log Mesin
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('mesinfingerprint.index') }}" class="btn btn-outline-secondary"><i
                            class="ti ti-arrow-left me-1"></i> Kembali</a>
                </div>
                <div>
                    <form method="GET" action="{{ route('mesinfingerprint.logmesin') }}" class="d-flex gap-2">
                        <input type="date" name="tanggal" class="form-control form-control-sm"
                            value="{{ request('tanggal', date('Y-m-d')) }}">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="ti ti-filter"></i> Filter
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover table-bordered table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>Waktu</th>
                                        <th>PIN</th>
                                        <th>Jam Absen</th>
                                        <th>Status Scan</th>
                                        <th>Mesin</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logmesin as $d)
                                        <tr>
                                            <td>{{ $loop->iteration + ($logmesin->currentPage() - 1) * $logmesin->perPage() }}</td>
                                            <td>{{ $d->created_at ? $d->created_at->format('d/m/Y H:i:s') : '-' }}</td>
                                            <td><code>{{ $d->pin }}</code></td>
                                            <td>{{ $d->jam_absen }}</td>
                                            <td class="text-center">{{ $d->status_scan }}</td>
                                            <td>{{ $d->nama_mesin ?? '-' }} {{ $d->sn ? '(' . $d->sn . ')' : '' }}</td>
                                            <td class="text-center">
                                                @if ($d->status == 1)
                                                    <span class="badge bg-success">Berhasil</span>
                                                @else
                                                    <span class="badge bg-danger">Gagal</span>
                                                @endif
                                            </td>
                                            <td><small>{{ $d->keterangan }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $logmesin->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
