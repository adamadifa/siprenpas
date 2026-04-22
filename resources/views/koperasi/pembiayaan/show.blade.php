@extends('layouts.app')
@section('titlepage', 'Detail Pembiayaan')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-cash fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Detail Pembiayaan</h4>
                        <p class="text-muted mb-0 small">Rincian akad, rencana pembayaran, dan histori angsuran</p>
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
                                <i class="ti ti-cash me-1"></i> Detail Pembiayaan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    $jumlah_pembiayaan = $pembiayaan->jumlah + $pembiayaan->jumlah * ($pembiayaan->persentase / 100);
@endphp

<div class="row">
    <div class="col-12">
        <div class="card mb-4 border-0 shadow-sm overflow-hidden" style="background-color: #064e3b">
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
                                <i class="ti ti-circle-check me-1 small"></i> Akad Aktif
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

    <div class="col-xl-8 col-lg-12 col-md-12 mt-3">
        <!-- Financing Detail Prominent Card -->
        <div class="card border-0 shadow-sm overflow-hidden mb-4" 
            style="background: linear-gradient(135deg, #064e3b 0%, #065f46 100%); border-radius: 16px;">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <small class="text-white-50 text-uppercase fw-bold mb-1 d-block" style="letter-spacing: 1.5px; font-size: 0.7rem;">
                            PEMBIAYAAN {{ strtoupper($pembiayaan->jenis_pembiayaan) }}
                        </small>
                        <h2 class="text-white fw-bold mb-1" style="letter-spacing: 1px;">
                            Rp {{ formatAngka($jumlah_pembiayaan) }}
                        </h2>
                        <div class="d-flex align-items-center gap-3 mt-2">
                            <span class="text-white opacity-75 small fw-medium">
                                No. Akad: <span class="text-warning fw-bold">{{ $pembiayaan->no_akad }}</span>
                            </span>
                            <span class="text-white opacity-25">|</span>
                            <span class="text-white opacity-75 small fw-medium">
                                Margin: <span class="bg-label-warning px-2 rounded small fw-bold text-white">{{ $pembiayaan->persentase }}%</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end mt-3 mt-md-0">
                        <div class="d-inline-flex flex-column align-items-md-end">
                            <small class="text-white-50 d-block" style="font-size: 0.6rem; letter-spacing: 1px;">KEPERLUAN</small>
                            <span class="text-white fw-bold mt-1 text-uppercase small">{{ $pembiayaan->keperluan }}</span>
                            <div class="mt-2 text-white-50 small">
                                <i class="ti ti-calendar me-1"></i> Mulai: {{ date('d M Y', strtotime($pembiayaan->tanggal)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="position-absolute" style="top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        </div>

        <!-- Professional Action Row -->
        <div class="row g-2 mb-4">
            <div class="col-md-4 col-12">
                <a href="{{ route('pembiayaan.updaterencana', Crypt::encrypt($pembiayaan->no_akad)) }}" 
                    class="btn btn-primary w-100 py-2 shadow-sm d-flex align-items-center justify-content-center gap-2" 
                    id="btnupdateRencana" style="background-color: #064e3b; border-color: #064e3b">
                    <i class="ti ti-refresh fs-5"></i>
                    <span class="fw-bold small">Update Rencana</span>
                </a>
            </div>
            @if ($pembiayaan->jmlbayar == 0)
                <div class="col-md-4 col-12">
                    <a href="#" no_akad="{{ Crypt::encrypt($pembiayaan->no_akad) }}" 
                        class="btn btn-warning w-100 py-2 shadow-sm d-flex align-items-center justify-content-center gap-2" 
                        id="btnEditrencana" style="border-color: #fbbf24">
                        <i class="ti ti-edit fs-5"></i>
                        <span class="fw-bold small">Edit Rencana</span>
                    </a>
                </div>
            @endif
            <div class="{{ $pembiayaan->jmlbayar == 0 ? 'col-md-4' : 'col-md-8' }} col-12">
                <a href="#" class="btn btn-outline-success w-100 py-2 shadow-none bg-white d-flex align-items-center justify-content-center gap-2 border-2" 
                    id="btncreateBayar" style="color: #064e3b; border-color: #064e3b">
                    <i class="ti ti-wallet fs-5"></i>
                    <span class="fw-bold small">Input Pembayaran</span>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Payment Plan Section -->
            <div class="col-lg-7 col-md-12">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-header d-flex align-items-center gap-2 text-white py-2" style="background-color: #064e3b; border-radius: 0;">
                        <i class="ti ti-list-check fs-5"></i>
                        <h6 class="card-title mb-0 text-white small">Rencana Pembayaran</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-nowrap">
                                <thead style="background-color: #064e3b">
                                    <tr>
                                        <th class="text-white py-2 small fw-bold">#</th>
                                        <th class="text-white py-2 text-center small fw-bold">JATUH TEMPO</th>
                                        <th class="text-white py-2 text-end small fw-bold">JUMLAH (Rp)</th>
                                        <th class="text-white py-2 text-end small fw-bold">BAYAR (Rp)</th>
                                        <th class="text-white py-2 text-end small fw-bold text-warning">SISA (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total_rencana = 0; $total_bayar = 0; $total_sisa = 0; @endphp
                                    @foreach ($rencana as $d)
                                        @php
                                            $jatuh_tempo = $d->tahun . '-' . $d->bulan . '-05';
                                            $sisa_tagihan = $d->jumlah - $d->bayar;
                                            $total_rencana += $d->jumlah;
                                            $total_bayar += $d->bayar;
                                            $total_sisa += $sisa_tagihan;
                                        @endphp
                                        <tr>
                                            <td class="py-2 text-dark small fw-bold text-center">{{ $d->cicilan_ke }}</td>
                                            <td class="py-2 text-center small">{{ date('d M Y', strtotime($jatuh_tempo)) }}</td>
                                            <td class="py-2 text-end fw-bold text-dark small">{{ formatAngka($d->jumlah) }}</td>
                                            <td class="py-2 text-end text-success fw-bold small">{{ $d->bayar > 0 ? formatAngka($d->bayar) : '-' }}</td>
                                            <td class="py-2 text-end fw-bold {{ $sisa_tagihan > 0 ? 'text-danger' : 'text-muted opacity-50' }} small">{{ formatAngka($sisa_tagihan) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <td colspan="2" class="py-2 text-center fw-bold small">TOTAL ESTIMASI</td>
                                        <td class="py-2 text-end fw-bold small">{{ formatAngka($total_rencana) }}</td>
                                        <td class="py-2 text-end text-success fw-bold small">{{ formatAngka($total_bayar) }}</td>
                                        <td class="py-2 text-end text-danger fw-bold small">{{ formatAngka($total_sisa) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment History Section -->
            <div class="col-lg-5 col-md-12">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-header d-flex align-items-center gap-2 text-white py-2" style="background-color: #064e3b; border-radius: 0;">
                        <i class="ti ti-history fs-5"></i>
                        <h6 class="card-title mb-0 text-white small">Histori Bayar</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-nowrap">
                                <thead style="background-color: #064e3b">
                                    <tr>
                                        <th class="text-white py-2 small fw-bold">TANGGAL</th>
                                        <th class="text-white py-2 text-end small fw-bold">JUMLAH (Rp)</th>
                                        <th class="text-white py-2 text-center small fw-bold">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($histori as $d)
                                        <tr>
                                            <td class="py-2 small">{{ date('d M Y', strtotime($d->tanggal)) }}</td>
                                            <td class="py-2 text-end fw-bold text-success small">{{ formatAngka($d->jumlah) }}</td>
                                            <td class="py-2 text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="{{ route('pembiayaan.cetakkwitansi', Crypt::encrypt($d->no_transaksi)) }}" 
                                                        class="btn btn-icon btn-label-secondary border-0 btn-sm" target="_blank" title="Kwitansi">
                                                        <i class="ti ti-printer fs-6"></i>
                                                    </a>
                                                    @can('pembiayaan.delete')
                                                        @if ($d->no_transaksi == $lasttransaksi->no_transaksi && date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d'))
                                                            <form method="POST" class="deleteform m-0"
                                                                action="{{ route('pembiayaan.deletebayar', Crypt::encrypt($d->no_transaksi)) }}">
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
                                    @endforeach
                                    @if(count($histori) == 0)
                                        <tr>
                                            <td colspan="3" class="py-4 text-center text-muted italic small">Belum ada transaksi pembayaran.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlBerita" size="" show="loadmodalberita" title="" />
<x-modal-form id="mdlPembiayaan" size="" show="loadmodalPembiayaan" title="" />
<x-modal-form id="mdlRencanapembiayaan" size="" show="loadrencanapembiayaan" title="" />
@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `<div class="d-flex justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span style="border-color: #064e3b" class="visually-hidden">Loading...</span>
            </div>
        </div>`;

        $(document).on('click', '.btnShowberita', function(e) {
            e.preventDefault();
            var berita = $(this).attr("berita");
            $("#mdlBerita").modal("show");
            $("#mdlBerita").find(".modal-title").text("Keterangan");
            $("#loadmodalberita").html(`<div class="p-3 text-dark">${berita || 'Tidak ada keterangan.'}</div>`);
        });

        $(document).on('click', '#btncreateBayar', function(e) {
            e.preventDefault();
            let no_akad = "{{ Crypt::encrypt($pembiayaan->no_akad) }}";
            $('#mdlPembiayaan').modal("show");
            $("#loadmodalPembiayaan").html(loading);
            $("#mdlPembiayaan").find(".modal-title").text("Input Pembayaran Angsuran");
            $("#loadmodalPembiayaan").load("/pembiayaan/" + no_akad + "/createbayar");
        });

        $(document).on('click', '#btnEditrencana', function(e) {
            e.preventDefault();
            let no_akad = "{{ Crypt::encrypt($pembiayaan->no_akad) }}";
            $('#mdlRencanapembiayaan').modal("show");
            $("#loadrencanapembiayaan").html(loading);
            $("#mdlRencanapembiayaan").find(".modal-title").text("Edit Rencana Pembayaran");
            $("#loadrencanapembiayaan").load("/pembiayaan/" + no_akad + "/editrencana");
        });

        // Delete Confirm
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus Pembayaran?',
                text: "Data pembayaran terakhir akan dihapus permanen!",
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
