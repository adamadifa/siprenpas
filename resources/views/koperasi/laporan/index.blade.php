@extends('layouts.app')
@section('titlepage', 'Laporan Koperasi')

@section('content')

@section('navigasi')
    <span>Laporan Koperasi</span>
@endsection
<div class="row">
    <div class="col-xl-6 col-md-12 col-sm-12">
        <div class="nav-align-left nav-tabs-shadow mb-4">
            <ul class="nav nav-tabs" role="tablist">
                @can('simpanan.index')
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#simpanan"
                            aria-controls="simpanan" aria-selected="false" tabindex="-1">
                            Simpanan
                        </button>
                    </li>
                @endcan
                @can('tabungan.index')
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tabungan" aria-controls="tabungan"
                            aria-selected="false" tabindex="-1">
                            Tabungan
                        </button>
                    </li>
                @endcan
                @can('pembiayaan.index')
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#pembiayaan"
                            aria-controls="pembiayaan" aria-selected="false" tabindex="-1">
                            Pembiayaan
                        </button>
                    </li>
                @endcan
            </ul>
            <div class="tab-content">
                @can('simpanan.index')
                    <div class="tab-pane fade active show" id="simpanan" role="tabpanel">
                        @include('koperasi.laporan.simpanan')
                    </div>
                @endcan
                @can('tabungan.index')
                    <div class="tab-pane fade" id="tabungan" role="tabpanel">
                        @include('koperasi.laporan.tabungan')
                    </div>
                @endcan
                @can('pembiayaan.index')
                    <div class="tab-pane fade" id="pembiayaan" role="tabpanel">
                        @include('koperasi.laporan.pembiayaan')
                    </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
    const formLaporanSimpanan = $("#formLaporanSimpanan");
    const formLaporanTabungan = $("#formLaporanTabungan");
    const formLaporanPembiayaan = $("#formLaporanPembiayaan");



    const select2Noanggotasimpanan = $(".select2Noanggotasimpanan");
    if (select2Noanggotasimpanan.length) {
        select2Noanggotasimpanan.each(function() {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>').select2({
                placeholder: 'Semua Anggota',
                allowClear: true,
                dropdownParent: $this.parent()
            });
        });
    }


    const select2Kodejenissimpanan = $(".select2Kodejenissimpanan");
    if (select2Kodejenissimpanan.length) {
        select2Kodejenissimpanan.each(function() {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>').select2({
                placeholder: 'Semua Jenis Simpanan',
                allowClear: true,
                dropdownParent: $this.parent()
            });
        });
    }


    const select2Kodejenistabungan = $(".select2Kodejenistabungan");
    if (select2Kodejenistabungan.length) {
        select2Kodejenistabungan.each(function() {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>').select2({
                placeholder: 'Semua Jenis Tabungan',
                allowClear: true,
                dropdownParent: $this.parent()
            });
        });
    }

    formLaporanSimpanan.submit(function(e) {
        let kode_simpanan = formLaporanSimpanan.find('select[name="kode_simpanan"]').val();
        let dari = formLaporanSimpanan.find('input[name="dari"]').val();
        let sampai = formLaporanSimpanan.find('input[name="sampai"]').val();
        const start = new Date(dari);
        const end = new Date(sampai);
        if (dari == "") {
            Swal.fire({
                title: "Oops!",
                text: "Dari Tanggal Harus Diisi !",
                icon: "warning",
                showConfirmButton: true,
                didClose: (e) => {
                    $(this).find("#dari").focus();
                },
            });
            return false;
        } else if (sampai == "") {
            Swal.fire({
                title: "Oops!",
                text: "Sampai Tanggal Harus Diisi !",
                icon: "warning",
                showConfirmButton: true,
                didClose: (e) => {
                    $(this).find("#sampai").focus();
                },
            });
            return false;
        } else if (start.getTime() > end.getTime()) {
            Swal.fire({
                title: "Oops!",
                text: "Periode Tidak Valid !, Periode Sampai Harus Lebih Akhir dari Periode Dari",
                icon: "warning",
                showConfirmButton: true,
                didClose: (e) => {
                    $(this).find("#sampai").focus();
                },
            });
            return false;
        }



        formLaporanTabungan.submit(function(e) {
            let kode_tabungan = formLaporanTabungan.find('select[name="kode_tabungan"]').val();
            let dari = formLaporanTabungan.find('input[name="dari"]').val();
            let sampai = formLaporanTabungan.find('input[name="sampai"]').val();
            const start = new Date(dari);
            const end = new Date(sampai);
            if (dari == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Dari Tanggal Harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        $(this).find("#dari").focus();
                    },
                });
                return false;
            } else if (sampai == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Sampai Tanggal Harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        $(this).find("#sampai").focus();
                    },
                });
                return false;
            } else if (start.getTime() > end.getTime()) {
                Swal.fire({
                    title: "Oops!",
                    text: "Periode Tidak Valid !, Periode Sampai Harus Lebih Akhir dari Periode Dari",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        $(this).find("#sampai").focus();
                    },
                });
                return false;
            }
        });


        formLaporanPembiayaan.submit(function(e) {
            let dari = formLaporanTabungan.find('input[name="dari"]').val();
            let sampai = formLaporanTabungan.find('input[name="sampai"]').val();
            const start = new Date(dari);
            const end = new Date(sampai);
            if (dari == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Dari Tanggal Harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        $(this).find("#dari").focus();
                    },
                });
                return false;
            } else if (sampai == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Sampai Tanggal Harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        $(this).find("#sampai").focus();
                    },
                });
                return false;
            } else if (start.getTime() > end.getTime()) {
                Swal.fire({
                    title: "Oops!",
                    text: "Periode Tidak Valid !, Periode Sampai Harus Lebih Akhir dari Periode Dari",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        $(this).find("#sampai").focus();
                    },
                });
                return false;
            }
        });
    });
</script>
@endpush
