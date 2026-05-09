@extends('layouts.app')
@section('titlepage', 'Preview Migrasi Siswa')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('migrasi-siswa.index') }}" class="btn btn-icon btn-label-secondary rounded-circle">
                        <i class="ti ti-arrow-left fs-4"></i>
                    </a>
                    <div>
                        <h4 class="mb-0 fw-bold">Preview Hasil Validasi</h4>
                        <p class="text-muted mb-0 small">File: <b>{{ $log->nama_file }}</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row g-3 text-center">
                    <div class="col-md-4">
                        <div class="border rounded p-3 bg-label-secondary">
                            <h3 class="mb-1 fw-bold">{{ $log->total_baris }}</h3>
                            <span class="text-muted small">Total Data Diproses</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 bg-label-success">
                            <h3 class="mb-1 fw-bold text-success">{{ $log->berhasil }}</h3>
                            <span class="text-success small">Data Valid (Siap Simpan)</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 bg-label-danger">
                            <h3 class="mb-1 fw-bold text-danger">{{ $log->gagal }}</h3>
                            <span class="text-danger small">Data Error / Gagal</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($log->gagal > 0)
            <div class="card shadow-sm border-0 border-top border-danger border-4 mb-4">
                <div class="card-header bg-transparent d-flex align-items-center justify-content-between">
                    <h6 class="card-title text-danger fw-bold mb-0">
                        <i class="ti ti-alert-circle me-2"></i>Daftar Error
                    </h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="10%">Baris Excel</th>
                                <th width="30%">Nama Siswa (Estimasi)</th>
                                <th>Deskripsi Error / Alasan Gagal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($error_data as $err)
                            <tr>
                                <td class="text-center fw-bold">{{ $err->baris_excel }}</td>
                                <td>
                                    @php
                                        // Try to find the name from the JSON notes if saved there, or it might just be the reason
                                        $reason = $err->keterangan;
                                    @endphp
                                    <span class="text-muted italic">Cek baris ke-{{ $err->baris_excel }} di Excel</span>
                                </td>
                                <td><span class="text-danger">{{ $err->keterangan }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light text-muted small">
                    * Data yang error <b>tidak akan disimpan</b> ke database. Harap perbaiki file Excel Anda dan upload ulang, atau lanjutkan untuk menyimpan data yang valid saja.
                </div>
            </div>
        @endif

        @if($log->berhasil > 0)
            <div class="card shadow-sm border-0 border-top border-success border-4 mb-4">
                <div class="card-header bg-transparent d-flex align-items-center justify-content-between">
                    <h6 class="card-title text-success fw-bold mb-0">
                        <i class="ti ti-check me-2"></i>Preview Data Valid (Sukses)
                    </h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="10%">Baris Excel</th>
                                <th>No Pendaftaran / NIS</th>
                                <th>ID Siswa</th>
                                <th>Status Siswa</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($valid_data->take(50) as $valid)
                            <tr>
                                <td class="text-center">{{ $valid->baris_excel }}</td>
                                <td>
                                    <span class="fw-bold">{{ $valid->no_pendaftaran }}</span><br>
                                    <small class="text-muted">{{ $valid->pendaftaran->nis ?? '-' }}</small>
                                </td>
                                <td><code>{{ $valid->id_siswa }}</code></td>
                                <td>
                                    @if($valid->is_new_siswa)
                                        <span class="badge bg-label-success">Siswa Baru</span>
                                    @else
                                        <span class="badge bg-label-warning">Data Siswa Ditemukan</span>
                                    @endif
                                </td>
                                <td><small>{{ $valid->keterangan }}</small></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($valid_data->count() > 50)
                <div class="card-footer bg-light text-center">
                    <small class="text-muted">Menampilkan 50 data valid pertama dari total {{ $valid_data->count() }} data.</small>
                </div>
                @endif
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end gap-3 mb-5">
            <a href="{{ route('migrasi-siswa.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-x me-1"></i> Batalkan
            </a>
            
            @if($log->berhasil > 0)
            <form action="{{ route('migrasi-siswa.proses', $log->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success fw-bold shadow-sm px-4">
                    <i class="ti ti-device-floppy me-2"></i> Konfirmasi & Selesai
                </button>
            </form>
            @endif
        </div>

    </div>
</div>
@endsection
