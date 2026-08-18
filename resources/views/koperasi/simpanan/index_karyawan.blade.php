@extends('layouts.app')
@section('titlepage', 'Simpanan Saya')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-4">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e6f4ea; color: #064e3b">
                        <i class="ti ti-wallet fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-extrabold" style="color: #064e3b; letter-spacing: -0.5px;">Simpanan Saya</h4>
                        <p class="text-muted mb-0 small">Pantau akumulasi saldo simpanan dan mutasi Koperasi Tsarwah Anda</p>
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
                            <li class="breadcrumb-item active fw-medium" style="color: #064e3b">
                                <i class="ti ti-wallet me-1"></i> Simpanan Saya
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .simpanan-card {
        transition: all 0.2s ease-in-out;
    }
    .simpanan-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.08) !important;
    }
</style>

<div class="row">
    <div class="col-lg-12">

        <!-- Employee Profile Summary Card -->
        @if(!empty($karyawan))
            <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden text-white" style="background: linear-gradient(135deg, #064e3b 0%, #043e2f 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center g-4">
                        <div class="col-auto">
                            <div class="avatar avatar-xl bg-white rounded-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                <i class="ti ti-user-check fs-2" style="color: #064e3b;"></i>
                            </div>
                        </div>
                        <div class="col-md">
                            <h4 class="fw-bold mb-1 text-white">{{ $karyawan->nama_lengkap }}</h4>
                            <p class="text-white-50 mb-0 small">NPP: <span class="fw-semibold text-white">{{ $karyawan->npp }}</span></p>
                        </div>
                        <div class="col-md-auto ms-md-auto">
                            <div class="d-flex flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-briefcase text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Jabatan</span>
                                        <span class="fw-bold text-white small">{{ strtoupper($karyawan->nama_jabatan) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-hierarchy-2 text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Departemen</span>
                                        <span class="fw-bold text-white small">{{ strtoupper($karyawan->nama_dept) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-building text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Unit Kerja</span>
                                        <span class="fw-bold text-white small">{{ strtoupper($karyawan->nama_unit) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (!$is_member)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center p-5">
                    <div class="avatar avatar-xl bg-label-danger mx-auto mb-4 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="ti ti-alert-triangle fs-1 text-danger"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Belum Terdaftar Sebagai Anggota</h4>
                    <p class="text-muted mx-auto" style="max-width: 500px;">
                        Status keanggotaan koperasi Anda belum aktif. Silakan hubungi pengurus Koperasi Tsarwah untuk melakukan pendaftaran anggota terlebih dahulu agar dapat melihat rincian saldo simpanan.
                    </p>
                </div>
            </div>
        @else
            <div class="row g-4 mb-4">
                <!-- Total Balance Metric Card -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm text-white h-100 p-4 d-flex flex-column justify-content-between rounded-3" 
                         style="background: linear-gradient(135deg, #0b6623 0%, #064e3b 100%); min-height: 180px;">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="ti ti-coin fs-4"></i>
                                <h6 class="fw-bold text-white mb-0 text-uppercase" style="letter-spacing: 0.5px; font-size: 0.75rem;">Total Saldo Simpanan</h6>
                            </div>
                            <h2 class="fw-extrabold font-monospace text-white mt-1 mb-0">Rp {{ number_format($total_saldo, 0, ',', '.') }}</h2>
                        </div>
                        <div class="mt-4 pt-2 border-top border-white-10">
                            <p class="text-white-50 mb-0 small">Koperasi Simpan Pinjam Tsarwah Al-Amin</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions Mini Card -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white h-100">
                        <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="color: #064e3b !important;">
                            <i class="ti ti-history"></i>
                            <span>5 Transaksi Terakhir</span>
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead>
                                    <tr class="text-secondary small">
                                        <th class="py-2">Tanggal</th>
                                        <th class="py-2">Keterangan</th>
                                        <th class="py-2 text-center">Jenis</th>
                                        <th class="py-2 text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($mutasi as $m)
                                        <tr>
                                            <td class="py-2 small">{{ date('d-m-Y', strtotime($m->tanggal)) }}</td>
                                            <td class="py-2 fw-semibold text-dark small">{{ $m->jenis_simpanan }}</td>
                                            <td class="py-2 text-center">
                                                @if ($m->jenis_transaksi == 'D')
                                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill fw-bold small">SIMPAN</span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill fw-bold small">TARIK</span>
                                                @endif
                                            </td>
                                            <td class="py-2 text-end font-monospace fw-bold text-dark small">Rp {{ number_format($m->jumlah, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted small">Belum ada riwayat transaksi simpanan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Savings Type Grid -->
            <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                <h5 class="fw-bold text-dark mb-0">Rincian Simpanan Anggota</h5>
            </div>

            <div class="row g-4 mb-4">
                @forelse ($saldo_simpanan as $s)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden simpanan-card h-100 d-flex flex-column justify-content-between">
                            <div class="card-header border-0 py-3 d-flex align-items-center justify-content-between" style="background-color: #064e3b;">
                                <span class="badge bg-white text-success px-2 py-1 small fw-bold" style="color: #064e3b !important;">
                                    {{ $s->kode_simpanan }}
                                </span>
                                <i class="ti ti-wallet text-white fs-4"></i>
                            </div>
                            <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                                <div class="mb-4">
                                    <h5 class="fw-extrabold text-dark mb-1">{{ $s->jenis_simpanan }}</h5>
                                    <p class="text-muted small">Kategori Simpanan Koperasi Tsarwah</p>
                                    
                                    <div class="mt-4 pt-2 border-top">
                                        <span class="text-secondary small d-block mb-1">Saldo Akumulasi</span>
                                        <h3 class="fw-extrabold text-success font-monospace mb-0">Rp {{ number_format($s->jumlah, 0, ',', '.') }}</h3>
                                    </div>
                                </div>

                                <div>
                                    <a href="#" class="btn btn-outline-success w-100 btn-view-mutasi rounded-3 d-flex align-items-center justify-content-center gap-2"
                                       style="height: 38px;"
                                       data-id="{{ $s->kode_simpanan }}">
                                        <i class="ti ti-file-text fs-5"></i>
                                        <span>Mutasi Rekening</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center p-5">
                                <div class="avatar avatar-xl bg-light mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                    <i class="ti ti-wallet fs-1 text-muted"></i>
                                </div>
                                <h5 class="fw-bold text-dark">Saldo Masih Kosong</h5>
                                <p class="text-muted mb-0">Rincian saldo simpanan belum terdaftar untuk akun koperasi Anda.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        @endif

    </div>
</div>

<!-- Modal Form Mutasi Rekening -->
<x-modal-form id="mdlMutasiSimpanan" size="modal-lg" show="loadMutasiSimpanan" title="Mutasi Rekening Simpanan" />

@endsection

@push('myscript')
<script>
    $(function() {
        $(".btn-view-mutasi").click(function(e) {
            e.preventDefault();
            var kode_simpanan = $(this).attr("data-id");
            $('#mdlMutasiSimpanan').modal("show");
            $("#loadMutasiSimpanan").load('/simpanansaya/mutasi/' + kode_simpanan);
        });
    });
</script>
@endpush
