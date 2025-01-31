@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-profile.css') }}" />
@section('titlepage', 'Data Pembiayaan')

@section('content')
@section('navigasi')
    <span class="text-muted">Anggota/</span> Detail
@endsection
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="user-profile-header-banner">
                <img src="{{ asset('assets/img/pages/profile-bg.jpg') }}" alt="Banner image" class="rounded-top">
                <h2 style="position: absolute; top: 30%; left: 50%; transform: translate(-50%, -50%);" class="text-white text-center">
                    {{ $pembiayaan->no_akad }} - Pembiayaan {{ $pembiayaan->jenis_pembiayaan }}
                    <br>
                    {{ $pembiayaan->keperluan }}
                    <br>
                    @php
                        $jumlah_pembiayaan = $pembiayaan->jumlah + $pembiayaan->jumlah * ($pembiayaan->persentase / 100);
                    @endphp
                    <sup>Rp. </sup>{{ formatRupiah($jumlah_pembiayaan) }}
                </h2>
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                    @if (Storage::disk('public')->exists('/anggota/' . $anggota->foto))
                        <img src="{{ getfotoKaryawan($anggota->foto) }}" alt="user image" class="d-block  ms-0 ms-sm-4 rounded user-profile-img"
                            height="150">
                    @else
                        <img src="{{ asset('assets/img/avatars/No_Image_Available.jpg') }}" alt="user image"
                            class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" width="150">
                    @endif

                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                    <div
                        class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                        <div class="user-profile-info">
                            <h4>{{ textCamelCase($anggota->nama_lengkap) }}</h4>
                            <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                <li class="list-inline-item d-flex gap-1">
                                    <i class="ti ti-barcode"></i> {{ textCamelCase($anggota->no_anggota) }}
                                </li>
                                <li class="list-inline-item d-flex gap-1">
                                    <i class="ti ti-credit-card"></i> {{ textCamelCase($anggota->nik) }}
                                </li>
                                <li class="list-inline-item d-flex gap-1">
                                    <i class="ti ti-credit-card"></i> {{ textCamelCase($pembiayaan->no_rekening) }}
                                </li>
                                <li class="list-inline-item d-flex gap-1">
                                    <i class="ti ti-file-description"></i> {{ textCamelCase($pembiayaan->jenis_pembiayaan) }}
                                </li>
                            </ul>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-4 col-lg-5 col-md-5">
        <!-- About User -->
        <div class="card mb-4">
            <div class="card-body">
                <small class="card-text text-uppercase">Data Karyawan</small>
                <ul class="list-unstyled mb-4 mt-3">
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-barcode text-heading"></i><span class="fw-medium mx-2 text-heading">No. Anggota</span>
                        <span>{{ $anggota->no_anggota }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-credit-card text-heading"></i><span class="fw-medium mx-2 text-heading">NIK</span>
                        <span>{{ $anggota->nik }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-user text-heading"></i><span class="fw-medium mx-2 text-heading">Nama Lengkap</span>
                        <span>{{ textCamelCase($anggota->nama_lengkap) }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-map-pin text-heading"></i><span class="fw-medium mx-2 text-heading">Tempat Lahir</span>
                        <span>{{ $anggota->tempat_lahir }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-calendar text-heading"></i><span class="fw-medium mx-2 text-heading">Tanggal Lahir</span>
                        <span>{{ \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d F Y') }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-gender-bigender text-heading"></i><span class="fw-medium mx-2 text-heading">Jenis Kelamin</span>
                        <span>{{ $anggota->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-book text-heading"></i><span class="fw-medium mx-2 text-heading">Pendidikan Terakhir</span>
                        <span>{{ $anggota->pendidikan_terakhir }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-rings text-heading"></i><span class="fw-medium mx-2 text-heading">Status Pernikahan</span>
                        @php
                            $status_menikah = ['M' => 'Menikah', 'BM' => 'Belum Meniah', 'JD' => 'Janda / Duda'];
                        @endphp
                        <span>{{ in_array($anggota->status_pernikahan, array_keys($status_menikah)) ? $status_menikah[$anggota->status_pernikahan] : 'Belum Diisi' }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-users text-heading"></i><span class="fw-medium mx-2 text-heading">Jumlah Tanggungan</span>
                        <span>{{ $anggota->jml_tanggungan }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-user text-heading"></i><span class="fw-medium mx-2 text-heading">Nama Pasangan</span>
                        <span>{{ $anggota->nama_pasangan }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-briefcase text-heading"></i><span class="fw-medium mx-2 text-heading">Pekerjaan Pasangan</span>
                        <span>{{ $anggota->pekerjaan_pasangan }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-user text-heading"></i><span class="fw-medium mx-2 text-heading">Nama Ibu</span>
                        <span>{{ $anggota->nama_ibu }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-user text-heading"></i><span class="fw-medium mx-2 text-heading">Nama Saudara</span>
                        <span>{{ $anggota->nama_saudara }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-phone-call text-heading"></i><span class="fw-medium mx-2 text-heading">No. HP</span>
                        <span>{{ $anggota->no_hp }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-map-pin text-heading"></i><span class="fw-medium mx-2 text-heading">Alamat</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <span class="ms-4">{{ $anggota->alamat }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-map-pin text-heading"></i><span class="fw-medium mx-2 text-heading">Provinsi</span>
                        <span>{{ $anggota->province_name }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-map-pin text-heading"></i><span class="fw-medium mx-2 text-heading">Kota</span>
                        <span>{{ $anggota->regency_name }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-map-pin text-heading"></i><span class="fw-medium mx-2 text-heading">Kecamatan</span>
                        <span>{{ $anggota->district_name }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-map-pin text-heading"></i><span class="fw-medium mx-2 text-heading">Kelurahan</span>
                        <span>{{ $anggota->village_name }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-envelope text-heading"></i><span class="fw-medium mx-2 text-heading">Kode Pos</span>
                        <span>{{ $anggota->kode_pos }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-home text-heading"></i><span class="fw-medium mx-2 text-heading">Status Tinggal</span>
                        @php
                            $status_tinggal = ['MS' => 'Milik Sendiri', 'MK' => 'Milik Keluarga', 'SK' => 'Sewa / Kontrak'];
                        @endphp
                        <span>{{ in_array($anggota->status_tinggal, array_keys($status_tinggal)) ? $status_tinggal[$anggota->status_tinggal] : 'Belum Diisi' }}</span>
                    </li>


                </ul>
            </div>
        </div>
        <!--/ About User -->
    </div>
    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12">

    </div>
</div>
<x-modal-form id="mdlBerita" size="" show="loadmodalberita" title="" />
<x-modal-form id="mdlPembiayaan" size="" show="loadmodalPembiayaan" title="" />
@endsection
@push('myscript')
<script>
    $(function() {
        $(document).on('click', '.btnShowberita', function(e) {
            e.preventDefault();
            var berita = $(this).attr("berita");
            $("#mdlBerita").modal("show");
            $("#loadmodalberita").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
            $("#mdlBerita").find(".modal-title").text("Detail Berita");
            $("#loadmodalberita").html(berita);
        });

        $(document).on('click', '#createPembiayaan', function(e) {
            e.preventDefault();
            let no_rekening = "{{ Crypt::encrypt($pembiayaan->no_rekening) }}";
            let jenis_transaksi = "S";
            $('#mdlPembiayaan').modal("show");
            $("#loadmodalPembiayaan").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
            $("#mdlPembiayaan").find(".modal-title").text("Input Data Pembiayaan");
            $("#loadmodalPembiayaan").load("/pembiayaan/" + no_rekening + "/" + jenis_transaksi + "/create");
        });

        $(document).on('click', '#createPenarikan', function(e) {
            e.preventDefault();
            let no_rekening = "{{ Crypt::encrypt($pembiayaan->no_rekening) }}";
            let jenis_transaksi = "T";
            $('#mdlPembiayaan').modal("show");
            $('#mdlSetoran').modal("show");
            $("#loadmodalSetoran").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
            $("#mdlSetoran").find(".modal-title").text("Input Data Penarikan");
            $("#loadmodalSetoran").load("/tabungan/" + no_rekening + "/" + jenis_transaksi + "/create");
        });
    });
</script>
@endpush
