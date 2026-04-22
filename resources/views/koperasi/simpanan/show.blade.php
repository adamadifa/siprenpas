@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-profile.css') }}" />
@section('titlepage', 'Detail Simpanan')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-database fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Detail Simpanan</h4>
                        <p class="text-muted mb-0 small">Informasi lengkap saldo dan mutasi simpanan anggota</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-building-bank me-1"></i> Koperasi
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-database me-1"></i> Detail Simpanan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-12">
        <div class="card mb-4 border-0 shadow-sm overflow-hidden" style="background-color: #064e3b">
            <!-- Header Banner - Integrated with Full Green Card -->
            <div class="user-profile-header-banner" style="background: linear-gradient(to right, rgba(0,0,0,0.1), rgba(0,0,0,0.3)); height: 80px;">
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row align-items-center align-items-sm-end text-sm-start text-center mb-4 px-4 pb-1">
                <div class="flex-shrink-0 mt-n4 mx-sm-0 mx-auto">
                    @if (Storage::disk('public')->exists('/anggota/' . $anggota->foto))
                        <img src="{{ getfotoKaryawan($anggota->foto) }}" alt="user image" 
                            class="d-block rounded border border-4 border-white shadow-sm user-profile-img"
                            style="width: 110px; height: 110px; object-fit: cover;">
                    @else
                        <div class="bg-white d-flex align-items-center justify-content-center rounded border border-4 border-white shadow-sm user-profile-img" 
                             style="width: 110px; height: 110px;">
                            <i class="ti ti-user fs-1 text-muted"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-0 ms-sm-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="user-profile-info">
                            <h4 class="mb-1 fw-bold text-white">{{ textCamelCase($anggota->nama_lengkap) }}</h4>
                            <div class="d-flex align-items-center flex-wrap gap-2 justify-content-center justify-content-sm-start">
                                <span class="text-white opacity-75 fw-medium small">
                                    <i class="ti ti-id me-1"></i>{{ $anggota->no_anggota }}
                                </span>
                                <span class="text-white opacity-25">|</span>
                                <span class="text-white opacity-75 fw-medium small">
                                    <i class="ti ti-credit-card me-1"></i>{{ $anggota->nik }}
                                </span>
                            </div>
                        </div>
                        <div class="ms-auto d-none d-md-block">
                            <span class="badge bg-white text-success px-3 py-2 rounded-pill shadow-sm">
                                <i class="ti ti-circle-check me-1 small"></i> Anggota Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-4 col-lg-5 col-md-12">
        <!-- Redesigned Profil Lengkap Card -->
        <div class="card mb-4 border-0 shadow-sm overflow-hidden">
            <!-- Header with Dark Green Theme -->
            <div class="card-header border-0 py-3 d-flex align-items-center gap-2" style="background-color: #064e3b">
                <i class="ti ti-id-badge text-white"></i>
                <h6 class="mb-0 fw-bold text-white">Profil Lengkap</h6>
            </div>
            <div class="card-body py-4">
                <!-- Personal Info Group -->
                <div class="mb-4">
                    <small class="text-uppercase fw-bold text-muted opacity-50 mb-3 d-block" style="letter-spacing: 1px; font-size: 0.65rem;">Informasi Pribadi</small>
                    
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="avatar avatar-sm flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-success"><i class="ti ti-calendar-event opacity-75"></i></span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="d-block text-muted small">Tempat, Tanggal Lahir</span>
                            <span class="fw-bold text-dark small">{{ $anggota->tempat_lahir }}, {{ date('d M Y', strtotime($anggota->tanggal_lahir)) }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-0">
                        <div class="avatar avatar-sm flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-success"><i class="ti ti-users opacity-75"></i></span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="d-block text-muted small">Status Sipil & Tanggungan</span>
                            @php $sm = ['M' => 'Menikah', 'BM' => 'Belum Menikah', 'JD' => 'Janda/Duda']; @endphp
                            <span class="fw-bold text-dark small">{{ $sm[$anggota->status_pernikahan] ?? '-' }} | {{ $anggota->jml_tanggungan }} Tanggungan</span>
                        </div>
                    </div>
                </div>

                <hr class="my-4 opacity-50">

                <!-- Contact & Address Group -->
                <div class="mb-4">
                    <small class="text-uppercase fw-bold text-muted opacity-50 mb-3 d-block" style="letter-spacing: 1px; font-size: 0.65rem;">Kontak & Alamat</small>
                    
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="avatar avatar-sm flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-success"><i class="ti ti-phone opacity-75"></i></span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="d-block text-muted small">Nomor Telepon</span>
                            <span class="fw-bold text-dark small">{{ $anggota->no_hp ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-0">
                        <div class="avatar avatar-sm flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-success"><i class="ti ti-map-pin opacity-75"></i></span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="d-block text-muted small">Alamat Lengkap</span>
                            <span class="fw-bold text-dark small" style="line-height: 1.4;">{{ $anggota->alamat ?: '-' }}</span>
                        </div>
                    </div>
                </div>

                <hr class="my-4 opacity-50">

                <!-- Education Group -->
                <div>
                    <small class="text-uppercase fw-bold text-muted opacity-50 mb-3 d-block" style="letter-spacing: 1px; font-size: 0.65rem;">Pendidikan</small>
                    
                    <div class="d-flex align-items-start gap-3 mb-0">
                        <div class="avatar avatar-sm flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-success"><i class="ti ti-school opacity-75"></i></span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="d-block text-muted small">Pendidikan Terakhir</span>
                            <span class="fw-bold text-dark small">{{ $anggota->pendidikan_terakhir ?: '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-7 col-md-12 mt-3">
        <!-- Saldo Summary Section - ATM Card Style -->
        <div class="row g-3 mb-4">
            <div class="col-12">
                <div class="swiper-container cardswiper">
                    <div class="swiper-wrapper">
                        @foreach ($saldo_simpanan as $l)
                            <div class="swiper-slide {{ $loop->first ? 'swiper-slide-active' : '' }}" style="width: auto;">
                                <div class="card border-0 shadow-lg overflow-hidden position-relative" 
                                    style="background: linear-gradient(135deg, #064e3b 0%, #065f46 100%); min-height: 160px; width: 300px; border-radius: 16px;">
                                    
                                    <!-- Decorative Elements -->
                                    <div class="position-absolute" style="top: -20px; right: -20px; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
                                    <div class="position-absolute" style="bottom: -10px; left: 10%; width: 50px; height: 50px; background: rgba(255,255,255,0.03); border-radius: 50%;"></div>
                                    
                                    <div class="card-body p-3 d-flex flex-column justify-content-between h-100">
                                        <!-- Card Top -->
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="d-flex flex-column">
                                                <small class="text-white-50 text-uppercase fw-bold mb-1" style="letter-spacing: 1px; font-size: 0.6rem;">
                                                    {{ $l->jenis_simpanan }}
                                                </small>
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="ti ti-building-bank text-white-50 fs-6"></i>
                                                    <small class="text-white-50 fw-medium" style="font-size: 0.75rem;">KOPERASI SIPREN</small>
                                                </div>
                                            </div>
                                            <i class="ti ti-wifi text-white-50 fs-5" style="transform: rotate(90deg);"></i>
                                        </div>

                                        <!-- Card Middle (Chip) -->
                                        <div class="mt-2">
                                            <div class="bg-warning opacity-75 rounded-1" style="width: 32px; height: 24px; background: linear-gradient(135deg, #ffd700, #ff8c00) !important; position: relative; overflow: hidden;">
                                                <div class="position-absolute w-100 h-100" style="background: repeating-linear-gradient(90deg, transparent, transparent 3px, rgba(0,0,0,0.1) 3px, rgba(0,0,0,0.1) 4px);"></div>
                                                <div class="position-absolute w-100 h-100" style="background: repeating-linear-gradient(0deg, transparent, transparent 3px, rgba(0,0,0,0.1) 3px, rgba(0,0,0,0.1) 4px);"></div>
                                            </div>
                                        </div>

                                        <!-- Card Bottom (Nominal & Holder) -->
                                        <div class="mt-auto pt-2">
                                            <div class="mb-1">
                                                <small class="text-white-50 small opacity-75" style="font-size: 0.7rem;">Available Balance</small>
                                                <h4 class="mb-0 text-white fw-bold" style="letter-spacing: 0.5px;">Rp {{ formatAngka($l->jumlah) }}</h4>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end mt-1">
                                                <span class="text-white small opacity-75 text-uppercase fw-medium" style="letter-spacing: 0.5px; font-size: 0.65rem;">
                                                    {{ $l->kode_simpanan }}
                                                </span>
                                                <div class="text-end">
                                                    <small class="text-white-50 d-block" style="font-size: 0.45rem; letter-spacing: 1px;">MEMBER ID</small>
                                                    <span class="text-white fw-bold" style="letter-spacing: 1px; font-size: 0.7rem;">
                                                        {{ substr($anggota->no_anggota, 0, 4) }} **** {{ substr($anggota->no_anggota, -4) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Professional Action Row -->
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-12">
                <button class="btn btn-primary w-100 py-3 shadow-sm d-flex align-items-center justify-content-center gap-2" 
                    id="createSetoran" style="background-color: #064e3b; border-color: #064e3b">
                    <i class="ti ti-transfer-in fs-4"></i>
                    <span class="fw-bold">Input Setoran</span>
                </button>
            </div>
            <div class="col-md-6 col-12">
                <button class="btn btn-outline-danger w-100 py-3 shadow-none bg-white d-flex align-items-center justify-content-center gap-2" 
                    id="createPenarikan">
                    <i class="ti ti-transfer-out fs-4"></i>
                    <span class="fw-bold">Input Penarikan</span>
                </button>
            </div>
        </div>

        <!-- Filter Row outside card - Unit Style -->
        <div class="mb-3 mt-4">
            <form action="#" method="GET" id="form-filter">
                <div class="row g-2">
                    <div class="col-md-5">
                        <div class="input-group input-group-merge border shadow-none rounded-2 h-100"
                            style="border-color: #e0e0e0 !important;">
                            <span class="input-group-text bg-white border-0"><i class="ti ti-calendar text-muted"></i></span>
                            <input type="text" name="dari" class="form-control bg-white border-0 ps-2 flatpickr-date"
                                placeholder="Periode Mulai" value="{{ Request('dari') }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group input-group-merge border shadow-none rounded-2 h-100"
                            style="border-color: #e0e0e0 !important;">
                            <span class="input-group-text bg-white border-0"><i class="ti ti-calendar text-muted"></i></span>
                            <input type="text" name="sampai" class="form-control bg-white border-0 ps-2 flatpickr-date"
                                placeholder="Periode Selesai" value="{{ Request('sampai') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn shadow-none d-flex align-items-center justify-content-center gap-2 text-white w-100 h-100"
                            style="background-color: #064e3b">
                            <i class="ti ti-search fs-5"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- History Section (Integrated Card) -->
        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b; border-radius: 0;">
                <i class="ti ti-history fs-5"></i>
                <h6 class="card-title mb-0 text-white">Riwayat Mutasi Saldo</h6>
            </div>
            <div class="card-body p-0">
                <!-- Premium Table -->
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-2">NO. TRANSAKSI</th>
                                <th class="text-white py-2 text-center">TANGGAL</th>
                                <th class="text-white py-2 text-center">KODE</th>
                                <th class="text-white py-2 text-end">SETOR (Rp)</th>
                                <th class="text-white py-2 text-end">TARIK (Rp)</th>
                                <th class="text-white py-2 text-end">SALDO (Rp)</th>
                                <th class="text-white py-2 text-center" style="width: 100px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Saldo Awal Row -->
                            <tr class="bg-light bg-opacity-50">
                                <td colspan="5" class="py-3 text-center small text-uppercase fw-bold text-muted">Saldo Awal Periode</td>
                                <td class="py-3 text-end fw-bold text-dark small">{{ formatAngka($saldo_awal) }}</td>
                                <td colspan="1"></td>
                            </tr>
                            @forelse ($simpanan as $d)
                                @php
                                    $setor = $d->jenis_transaksi == 'S' ? $d->jumlah : 0;
                                    $tarik = $d->jenis_transaksi == 'T' ? $d->jumlah : 0;
                                @endphp
                                <tr>
                                    <td class="py-2 text-dark small fw-bold">{{ $d->no_transaksi }}</td>
                                    <td class="py-2 text-center small">{{ date('d M Y', strtotime($d->tanggal)) }}</td>
                                    <td class="py-2 text-center"><span class="badge border text-info bg-label-info small">{{ $d->kode_simpanan }}</span></td>
                                    <td class="py-2 text-end text-success fw-bold small">{{ $setor > 0 ? formatAngka($setor) : '-' }}</td>
                                    <td class="py-2 text-end text-danger fw-bold small">{{ $tarik > 0 ? formatAngka($tarik) : '-' }}</td>
                                    <td class="py-2 text-end fw-bold text-dark small">{{ formatAngka($d->saldo) }}</td>
                                    <td class="py-2 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('simpanan.cetakkwitansi', Crypt::encrypt($d->no_transaksi)) }}"
                                                class="btn btn-icon btn-label-secondary border-0 btn-sm" target="_blank" title="Kwitansi">
                                                <i class="ti ti-printer fs-6"></i>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-label-secondary border-0 btn-sm btnShowberita" 
                                               berita="{{ $d->berita }}" title="Keterangan">
                                                <i class="ti ti-note fs-6"></i>
                                            </a>
                                            @can('simpanan.delete')
                                                @if ($d->no_transaksi == $lasttransaksi->no_transaksi && $d->tanggal == date('Y-m-d'))
                                                    <form method="POST" class="deleteform m-0"
                                                        action="{{ route('simpanan.delete', Crypt::encrypt($d->no_transaksi)) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a class="btn btn-icon btn-label-danger border-0 btn-sm delete-confirm" href="#">
                                                            <i class="ti ti-trash fs-6"></i>
                                                        </a>
                                                    </form>
                                                @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-folders fs-1 opacity-25"></i>
                                        </div>
                                        <h6 class="text-muted">Tidak ada riwayat mutasi dalam periode ini</h6>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-2 border-top bg-light bg-opacity-10 text-center">
                    <small class="text-muted italic">*Mutasi yang ditampilkan adalah transaksi pada periode yang dipilih.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlBerita" size="" show="loadmodalberita" title="" />
<x-modal-form id="mdlSetoran" size="" show="loadmodalSetoran" title="" />
@endsection

@push('myscript')
<script>
    $(function() {
        if ($('.cardswiper').length) {
            new Swiper('.cardswiper', {
                slidesPerView: 'auto',
                spaceBetween: 8,
                grabCursor: true,
                freeMode: true,
                mousewheel: true
            });
        }

        const loading = `<div class="d-flex justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span style="background-color: #064e3b" class="visually-hidden">Loading...</span>
            </div>
        </div>`;

        $(document).on('click', '.btnShowberita', function(e) {
            e.preventDefault();
            var berita = $(this).attr("berita");
            $("#mdlBerita").modal("show");
            $("#mdlBerita").find(".modal-title").text("Keterangan Transaksi");
            $("#loadmodalberita").html(`<div class="p-3 text-dark" style="line-height: 1.6;">${berita || 'Tidak ada keterangan tambahan.'}</div>`);
        });

        $(document).on('click', '#createSetoran', function(e) {
            e.preventDefault();
            let no_anggota = "{{ Crypt::encrypt($anggota->no_anggota) }}";
            let jenis_transaksi = "S";
            $('#mdlSetoran').modal("show");
            $("#loadmodalSetoran").html(loading);
            $("#mdlSetoran").find(".modal-title").text("Transaksi Setoran");
            $("#loadmodalSetoran").load("/simpanan/" + no_anggota + "/" + jenis_transaksi + "/create");
        });

        $(document).on('click', '#createPenarikan', function(e) {
            e.preventDefault();
            let no_anggota = "{{ Crypt::encrypt($anggota->no_anggota) }}";
            let jenis_transaksi = "T";
            $('#mdlSetoran').modal("show");
            $("#loadmodalSetoran").html(loading);
            $("#mdlSetoran").find(".modal-title").text("Transaksi Penarikan");
            $("#loadmodalSetoran").load("/simpanan/" + no_anggota + "/" + jenis_transaksi + "/create");
        });

        // Delete Confirm
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus Transaksi?',
                text: "Anda akan menghapus record transaksi terakhir. Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        });
    });
</script>
@endpush
