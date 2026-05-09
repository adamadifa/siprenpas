@extends('layouts.app')
@section('titlepage', 'Riwayat Migrasi Siswa')

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
                        <h4 class="mb-0 fw-bold">Riwayat Migrasi Siswa</h4>
                        <p class="text-muted mb-0 small">Daftar file Excel yang pernah di-import ke sistem</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                <h6 class="card-title mb-0 fw-bold">
                    <i class="ti ti-history me-2"></i>Log Import
                </h6>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Waktu Import</th>
                            <th>Nama File</th>
                            <th>Tahun Ajaran</th>
                            <th class="text-center">Total Baris</th>
                            <th class="text-center">Berhasil</th>
                            <th class="text-center">Gagal</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $log)
                        <tr>
                            <td>{{ $loop->iteration + $riwayat->firstItem() - 1 }}</td>
                            <td>
                                <div class="fw-bold">{{ $log->created_at->format('d M Y') }}</div>
                                <small class="text-muted">{{ $log->created_at->format('H:i:s') }} oleh {{ $log->user->name ?? 'System' }}</small>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $log->nama_file }}">
                                    {{ $log->nama_file }}
                                </span>
                            </td>
                            <td><span class="badge bg-label-primary">{{ $log->kode_ta }}</span></td>
                            <td class="text-center">{{ $log->total_baris }}</td>
                            <td class="text-center"><span class="text-success fw-bold">{{ $log->berhasil }}</span></td>
                            <td class="text-center"><span class="text-danger fw-bold">{{ $log->gagal }}</span></td>
                            <td class="text-center">
                                @if($log->status == 'done')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($log->status == 'processing')
                                    <span class="badge bg-warning">Processing</span>
                                @elseif($log->status == 'error')
                                    <span class="badge bg-danger">Error</span>
                                @elseif($log->status == 'rolled_back')
                                    <span class="badge bg-secondary">Rolled Back</span>
                                @else
                                    <span class="badge bg-info">{{ ucfirst($log->status) }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($log->status == 'done' && $log->berhasil > 0)
                                    <form action="{{ route('migrasi-siswa.rollback', $log->id) }}" method="POST" class="d-inline rollback-form">
                                        @csrf
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-rollback">
                                            <i class="ti ti-arrow-back-up me-1"></i> Rollback
                                        </button>
                                    </form>
                                @elseif($log->status == 'processing')
                                    <a href="{{ route('migrasi-siswa.preview', $log->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="ti ti-eye me-1"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="mb-3">
                                    <i class="ti ti-file-off fs-1 text-muted opacity-50"></i>
                                </div>
                                <h6>Belum ada riwayat migrasi</h6>
                                <p class="text-muted small">Data import Excel Anda akan muncul di sini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($riwayat->hasPages())
            <div class="card-footer bg-transparent border-top">
                <div class="d-flex justify-content-end">
                    {{ $riwayat->links() }}
                </div>
            </div>
            @endif
            
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        $('.btn-rollback').click(function() {
            let form = $(this).closest('form');
            
            Swal.fire({
                title: "Apakah Anda yakin?",
                html: "Anda akan melakukan <b>Rollback</b>.<br>Semua data pendaftaran, biaya, dan mutasi dari batch ini akan <b>DIHAPUS</b> permanen.<br>Siswa yang baru terdaftar juga akan dihapus.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus Data!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading saat proses lama
                    Swal.fire({
                        title: 'Memproses Rollback...',
                        text: 'Mohon tunggu, jangan tutup halaman ini.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
