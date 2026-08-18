@extends('layouts.app')
@section('titlepage', 'Pinjaman Saya')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-4">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e6f4ea; color: #064e3b">
                        <i class="ti ti-cash fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-extrabold" style="color: #064e3b; letter-spacing: -0.5px;">Pinjaman Saya</h4>
                        <p class="text-muted mb-0 small">Pantau status pembiayaan dan rencana cicilan Koperasi Tsarwah Anda</p>
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
                                <i class="ti ti-cash me-1"></i> Pinjaman Saya
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .pembiayaan-card {
        transition: all 0.2s ease-in-out;
    }
    .pembiayaan-card:hover {
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
                                        <span class="fw-bold text-white" style="font-size: 0.8rem; letter-spacing: 0.2px;">{{ strtoupper($karyawan->nama_jabatan) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-hierarchy-2 text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Departemen</span>
                                        <span class="fw-bold text-white" style="font-size: 0.8rem; letter-spacing: 0.2px;">{{ strtoupper($karyawan->nama_dept) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-building text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Unit Kerja</span>
                                        <span class="fw-bold text-white" style="font-size: 0.8rem; letter-spacing: 0.2px;">{{ strtoupper($karyawan->nama_unit) }}</span>
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
                        Status keanggotaan koperasi Anda belum aktif. Silakan hubungi pengurus Koperasi Tsarwah untuk melakukan pendaftaran anggota terlebih dahulu agar dapat mengajukan dan memantau pembiayaan.
                    </p>
                </div>
            </div>
        @else
            <!-- Action Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-dark mb-0">Daftar Pembiayaan Anda</h5>
                <!-- Hidden for now
                <a href="{{ route('pembiayaan.createpinjaman') }}" class="btn text-white px-4 d-flex align-items-center gap-2"
                   style="background-color: #064e3b; border-radius: 8px; height: 38px;">
                    <i class="ti ti-file-plus fs-5"></i>
                    <span class="fw-semibold">Ajukan Pembiayaan</span>
                </a>
                -->
            </div>

            <!-- Loan Cards Grid -->
            <div class="row g-4 mb-4">
                @forelse ($pembiayaan as $d)
                    @php
                        $jumlah_pembiayaan = $d->jumlah + $d->jumlah * ($d->persentase / 100);
                        $total_bayar = $d->total_bayar ?? 0;
                        $sisa_tagihan = $jumlah_pembiayaan - $total_bayar;
                        $persen_progress = $jumlah_pembiayaan > 0 ? round(($total_bayar / $jumlah_pembiayaan) * 100) : 0;
                        $isLunas = $sisa_tagihan <= 0;
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden pembiayaan-card h-100 d-flex flex-column justify-content-between">
                            <div class="card-header border-0 py-3 d-flex align-items-center justify-content-between" style="background-color: #064e3b;">
                                <span class="badge bg-white text-success px-2 py-1 small fw-bold" style="color: #064e3b !important;">
                                    {{ $d->no_akad }}
                                </span>
                                @if($isLunas)
                                    <span class="badge bg-success rounded-pill fw-bold small">LUNAS</span>
                                @else
                                    <span class="badge bg-danger rounded-pill fw-bold small">BELUM LUNAS</span>
                                @endif
                            </div>
                            <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                                <div>
                                    <h5 class="fw-extrabold text-dark mb-1">{{ $d->jenis_pembiayaan }}</h5>
                                    <p class="text-muted small mb-3">
                                        <i class="ti ti-calendar me-1 text-success"></i>Tgl Akad: {{ date('d-m-Y', strtotime($d->tanggal)) }}
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom text-secondary small">
                                        <span>Jangka Waktu</span>
                                        <span class="fw-bold text-dark">{{ $d->jangka_waktu }} Bulan</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom text-secondary small">
                                        <span>Total Pembiayaan</span>
                                        <span class="fw-bold text-success font-monospace">Rp {{ number_format($jumlah_pembiayaan, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom text-secondary small">
                                        <span>Sudah Dibayar</span>
                                        <span class="fw-bold text-primary font-monospace">Rp {{ number_format($total_bayar, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center py-2 text-secondary small mb-3">
                                        <span>Sisa Tagihan</span>
                                        <span class="fw-bold text-danger font-monospace">Rp {{ number_format($sisa_tagihan, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div>
                                    <!-- Progress bar -->
                                    <div class="d-flex justify-content-between align-items-center mb-1 text-secondary" style="font-size: 0.75rem;">
                                        <span>Progress Pelunasan</span>
                                        <span class="fw-bold text-success">{{ $persen_progress }}%</span>
                                    </div>
                                    <div class="progress rounded-pill mb-4" style="height: 6px;">
                                        <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: {{ $persen_progress }}%;" aria-valuenow="{{ $persen_progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                    <a href="#" class="btn btn-outline-success w-100 btn-view-plan rounded-3 d-flex align-items-center justify-content-center gap-2"
                                       style="height: 38px;"
                                       data-id="{{ Crypt::encrypt($d->no_akad) }}">
                                        <i class="ti ti-list-check fs-5"></i>
                                        <span>Rencana Angsuran</span>
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
                                    <i class="ti ti-cash-off fs-1 text-muted"></i>
                                </div>
                                <h5 class="fw-bold text-dark">Belum Ada Riwayat Pembiayaan</h5>
                                <p class="text-muted mb-0">Anda belum memiliki riwayat pembiayaan atau pinjaman aktif di Koperasi Tsarwah.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        @endif

    </div>
</div>

<!-- Modal Form Rencana Angsuran -->
<x-modal-form id="mdlRencanaAngsuran" size="modal-xl" show="loadRencanaAngsuran" title="Rencana Angsuran Pembiayaan" />

@endsection

@push('myscript')
<script>
    $(function() {
        $(".btn-view-plan").click(function(e) {
            e.preventDefault();
            var no_akad = $(this).attr("data-id");
            $('#mdlRencanaAngsuran').modal("show");
            $("#loadRencanaAngsuran").load('/pembiayaan/' + no_akad + '/showdetail');
        });
    });
</script>
@endpush
