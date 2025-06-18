@extends('layouts.app')
@section('titlepage', 'Data Pembiayaan Koperasi')

@section('content')
@section('navigasi')
    <span>Data Pembiayaan</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('pembiayaan.create')
                    <a href="#" class="btn btn-primary" id="btncreatePembiayaan"><i class="fa fa-plus me-2"></i> Input
                        Pembiayaan</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ URL::current() }}">
                            <div class="row">
                                <div class="col-lg-10 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Cari Nama Anggota Koperasi"
                                        value="{{ Request('nama_anggota') }}" name="nama_anggota" icon="ti ti-search" />
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    <button class="btn btn-primary">Cari</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>NO</th>
                                        <th>No. Akad</th>
                                        <th>Tanggal</th>
                                        <th>No. Anggota</th>
                                        <th>Nama Anggota</th>
                                        <th>Jenis Pembiayaan</th>
                                        <th>Pokok</th>
                                        <th>Pembiayaan</th>
                                        <th>L/BL</th>
                                        <th>Status</th>
                                        <th>#</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($pembiayaan) == 0)
                                        <tr>
                                            <td colspan="7" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    @endif
                                    @foreach ($pembiayaan as $d)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration + $pembiayaan->firstItem() - 1 }}</td>
                                            <td class="">{{ $d->no_akad }}</td>
                                            <td class="">{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                            <td class="">{{ $d->no_anggota }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ $d->jenis_pembiayaan }}</td>
                                            <td class="text-end">{{ formatAngka($d->jumlah) }}</td>
                                            <td class="text-end">
                                                @php
                                                    $jumlah_pembiayaan =
                                                        $d->jumlah + $d->jumlah * ($d->persentase / 100);
                                                @endphp
                                                {{ formatAngka($jumlah_pembiayaan) }}
                                            </td>
                                            <td class="text-end">
                                                @if ($d->total_bayar == $jumlah_pembiayaan)
                                                    <span class="badge bg-success">L</span>
                                                @else
                                                    <span class="badge bg-danger">BL</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->status == 1)
                                                    <span class="badge bg-success">Disetujui</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Disetujui</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('tabungan.index')
                                                        <a href="{{ route('pembiayaan.show', Crypt::encrypt($d->no_akad)) }}"
                                                            class="me-1">
                                                            <i class="ti ti-book"></i>
                                                        </a>
                                                    @endcan
                                                    @can('tabungan.delete')
                                                        @if ($d->jmlbayar == 0)
                                                            <form method="POST" class="deleteform"
                                                                action="{{ route('pembiayaan.delete', Crypt::encrypt($d->no_akad)) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a class="delete-confirm ml-1 cursor-pointer">
                                                                    <i class="ti ti-trash text-danger"></i>
                                                                </a>
                                                            </form>
                                                        @endif
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="float: right;">
                            {{ $pembiayaan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="mdlPembiayaan" size="modal-lg" show="loadmodalPembiayaan" title="" />
<div class="modal fade" id="mdlAnggota" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18">Data Anggota</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="tabelanggota">
                    <thead class="table-dark">
                        <tr>
                            <th>No. Anggota</th>
                            <th>NIK</th>
                            <th>NAMA LENGKAP</th>
                            <th>No. HP</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
    $(function() {
        $("#btncreatePembiayaan").click(function(e) {
            e.preventDefault();
            $('#mdlPembiayaan').modal("show");
            $(".modal-title").text("Tambah Data Pembiayaan");
            $("#loadmodalPembiayaan").load("{{ route('pembiayaan.create') }}");

        })
        $(document).on('show.bs.modal', '.modal', function() {
            const zIndex = 1090 + 10 * $('.modal:visible').length;
            $(this).css('z-index', zIndex);
            setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1)
                .addClass('modal-stack'));
        });

        $(document).on('click', '#no_anggota_search', function() {
            $('#mdlAnggota').modal("show");
        })


        $('#tabelanggota').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}', // memanggil route yang menampilkan data json
            columns: [{ // mengambil & menampilkan kolom sesuai tabel database
                    data: 'no_anggota',
                    name: 'no_anggota'
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama_lengkap',
                    name: 'nama_lengkap'
                },
                {
                    data: 'no_hp',
                    name: 'no_hp'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],

        });

        function getAnggota(no_anggota) {
            $.ajax({
                url: `/anggota/${no_anggota}/getanggota`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $(document).find("#formPembiayaan").find("#no_anggota").val(response
                        .no_anggota);
                    $(document).find("#formPembiayaan").find("#nik").val(response.nik);
                    $(document).find("#formPembiayaan").find("#nama_lengkap").val(response
                        .nama_lengkap);
                    $(document).find("#formPembiayaan").find("#no_hp").val(response.no_hp);
                    $(document).find("#formPembiayaan").find("#tempat_lahir").val(response
                        .tempat_lahir);
                    $(document).find("#formPembiayaan").find("#tanggal_lahir").val(response
                        .tanggal_lahir);
                    $(document).find("#formPembiayaan").find("#jenis_kelamin").val(response
                        .jenis_kelamin);
                    $(document).find("#formPembiayaan").find("#pendidikan_terakhir").val(response
                        .pendidikan_terakhir);
                    $(document).find("#formPembiayaan").find("#status_pernikahan").val(response
                        .status_pernikahan);
                    $(document).find("#formPembiayaan").find("#jml_tanggungan").val(response
                        .jml_tanggungan);
                    $(document).find("#formPembiayaan").find("#nama_pasangan").val(response
                        .nama_pasangan);
                    $(document).find("#formPembiayaan").find("#pekerjaan_pasangan").val(response
                        .pekerjaan_pasangan);
                    $(document).find("#formPembiayaan").find("#nama_ibu").val(response.nama_ibu);
                    $(document).find("#formPembiayaan").find("#nama_saudara").val(response
                        .nama_saudara);
                    $(document).find("#formPembiayaan").find("#alamat").val(response.alamat);
                    $(document).find("#formPembiayaan").find("#id_province").val(response
                        .id_province).trigger('change');
                    getRegency(id_province = response.id_province, id_regency = response
                        .id_regency);
                    getDistrict(id_regency = response.id_regency, id_district = response
                        .id_district);
                    getVillage(id_district = response.id_district, id_village = response
                        .id_village);
                    $(document).find("#formPembiayaan").find("#kode_pos").val(response.kode_pos);
                    $(document).find("#formPembiayaan").find("#status_tinggal").val(response
                        .status_tinggal);
                    enableFields();
                    $("#mdlAnggota").modal("hide");
                }
            });
        }

        function getRegency(id_province, id_regency) {
            $.ajax({
                type: 'POST',
                url: '/regency/getregencybyprovince',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_province: id_province,
                    id_regency: id_regency
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    $(document).find("#formPembiayaan").find("#id_regency").html(respond);
                }
            });
        }

        function getDistrict(id_regency, id_district) {
            $.ajax({
                type: 'POST',
                url: '/district/getdistrictbyregency',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_regency: id_regency,
                    id_district: id_district,
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    $(document).find("#formPembiayaan").find("#id_district").html(respond);
                }
            });
        }

        function getVillage(id_district, id_village) {
            $.ajax({
                type: 'POST',
                url: '/village/getvillagebydistrict',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_district: id_district,
                    id_village: id_village
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    $(document).find("#formPembiayaan").find("#id_village").html(respond);
                }
            });
        }

        $(document).on('change', '#id_province', function() {
            // alert(id_province = $(this).val());
            getRegency(id_province = $(this).val(), id_regency = "");
        })

        $(document).on('change', '#id_regency', function() {
            getDistrict(id_regency = $(this).val(), id_district = "");
        })

        $(document).on('change', '#id_district', function() {
            getVillage(id_district = $(this).val(), id_village = "");
        })

        // $("#id_province").change(function() {
        //     getRegency();
        // });

        // $("#id_regency").change(function() {
        //     getDistrict();
        // });

        // $("#id_district").change(function() {
        //     getVillage();
        // });
        $('#tabelanggota tbody').on('click', '.pilihAnggota', function(e) {
            e.preventDefault();
            let no_anggota = $(this).attr('no_anggota');
            getAnggota(no_anggota);
        });

        $(document).on('change', '#kode_pembiayaan', function() {
            let persentase = $('option:selected', this).attr('persentase');
            $(document).find("#formPembiayaan").find("#persentase").val(persentase);
            let jml = $(document).find("#formPembiayaan").find("#jumlah").val();
            let jumlah = jml.replace(/\./g, '');
            var jumlah_pengembalian = parseInt(jumlah) + (parseInt(jumlah) * (parseInt(persentase) /
                100));
            if (jumlah == "" || jumlah === 0) {
                jumlah_pengembalian = 0;
            } else {
                jumlah_pengembalian = jumlah_pengembalian;
            }
            $(document).find("#formPembiayaan").find("#jumlah_pengembalian").val(convertToRupiah(
                jumlah_pengembalian));

        });

        $(document).on('keyup keydown', '#jumlah', function() {
            let persentase = $(document).find("#formPembiayaan").find("#persentase").val();
            let jml = $(document).find("#formPembiayaan").find("#jumlah").val();
            let jumlah = jml.replace(/\./g, '');
            var jumlah_pengembalian = parseInt(jumlah) + (parseInt(jumlah) * (parseInt(persentase) /
                100));
            if (jumlah == "" || jumlah === 0) {
                jumlah_pengembalian = 0;
            } else {
                jumlah_pengembalian = jumlah_pengembalian;
            }
            $(document).find("#formPembiayaan").find("#jumlah_pengembalian").val(convertToRupiah(
                jumlah_pengembalian));
        })

        function convertToRupiah(number) {
            if (number) {
                var rupiah = "";
                var numberrev = number
                    .toString()
                    .split("")
                    .reverse()
                    .join("");
                for (var i = 0; i < numberrev.length; i++)
                    if (i % 3 == 0) rupiah += numberrev.substr(i, 3) + ".";
                return (
                    rupiah
                    .split("", rupiah.length - 1)
                    .reverse()
                    .join("")
                );
            } else {
                return number;
            }
        }


        $(document).on('submit', '#formPembiayaan', function(e) {
            let tangggal = $(this).find('input[name="tanggal"]').val();
            let no_anggota = $(this).find('input[name="no_anggota"]').val();
            let nama_lengkap = $(this).find('input[name="nama_lengkap"]').val();
            let nik = $(this).find('input[name="nik"]').val();
            let tempat_lahir = $(this).find('input[name="tempat_lahir"]').val();
            let tanggal_lahir = $(this).find('input[name="tanggal_lahir"]').val();
            let jenis_kelamin = $(this).find('select[name="jenis_kelamin"]').val();
            let pendidikan_terakhir = $(this).find('select[name="pendidikan_terakhir"]').val();
            let status_pernikahan = $(this).find('select[name="status_pernikahan"]').val();
            let jml_tanggungan = $(this).find('input[name="jml_tanggungan"]').val();
            let nama_pasangan = $(this).find('input[name="nama_pasangan"]').val();
            let pekerjaan_pasangan = $(this).find('input[name="pekerjaan_pasangan"]').val();
            let nama_ibu = $(this).find('input[name="nama_ibu"]').val();
            let nama_saudara = $(this).find('input[name="nama_saudara"]').val();
            let no_hp = $(this).find('input[name="no_hp"]').val();
            let alamat = $(this).find('textarea[name="alamat"]').val();
            let id_province = $(this).find('select[name="id_province"]').val();
            let id_regency = $(this).find('select[name="id_regency"]').val();
            let id_district = $(this).find('select[name="id_district"]').val();
            let id_village = $(this).find('select[name="id_village"]').val();
            let status_tinggal = $(this).find('select[name="status_tinggal"]').val();
            let kode_pos = $(this).find('input[name="kode_pos"]').val();
            let kode_pembiayaan = $(this).find('select[name="kode_pembiayaan"]').val();
            let jangka_waktu = $(this).find('select[name="jangka_waktu"]').val();
            let jumlah = $(this).find('input[name="jumlah"]').val();
            let keperluan = $(this).find('textarea[name="keperluan"]').val();
            let jaminan = $(this).find('input[name="jaminan"]').val();

            if (tangggal == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#tanggal").focus();
                    }
                });
                return false;
            } else if (no_anggota == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silahkan Pilih Anggota terlebih Dahulu!',
                    didClose: (e) => {
                        $(this).find("#no_anggota").focus();
                        $(this).find("#btnCariAnggota").click();
                    }
                });
                return false;
            } else if (nama_lengkap == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Lengkap tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#nama_lengkap").focus();
                    }
                });
                return false;
            } else if (nik == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'NIK tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#nik").focus();
                    }
                });
                return false;
            } else if (tempat_lahir == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tempat Lahir tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#tempat_lahir").focus();
                    }
                });
                return false;
            } else if (tanggal_lahir == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal Lahir tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#tanggal_lahir").focus();
                    }
                });
                return false;
            } else if (jenis_kelamin == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jenis Kelamin tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#jenis_kelamin").focus();
                    }
                });
                return false;
            } else if (pendidikan_terakhir == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Pendidikan Terakhir tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#pendidikan_terakhir").focus();
                    }
                });
                return false;
            } else if (status_pernikahan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Status Pernikahan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#status_pernikahan").focus();
                    }
                });
                return false;
            } else if (jml_tanggungan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah Tanggungan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#jml_tanggungan").focus();
                    }
                });
                return false;
            } else if (nama_pasangan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Pasangan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#nama_pasangan").focus();
                    }
                });
                return false;
            } else if (pekerjaan_pasangan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Pekerjaan Pasangan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#pekerjaan_pasangan").focus();
                    }
                });
                return false;
            } else if (nama_ibu == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Ibu tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#nama_ibu").focus();
                    }
                });
                return false;
            } else if (nama_saudara == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Saudara tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#nama_saudara").focus();
                    }
                });
                return false;
            } else if (no_hp == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'No. HP tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#no_hp").focus();
                    }
                });
                return false;
            } else if (alamat == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Alamat tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#alamat").focus();
                    }
                });
                return false;
            } else if (id_province == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Provinsi tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#id_province").focus();
                    }
                });
                return false;
            } else if (id_regency == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kabupaten / Kota tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#id_regency").focus();
                    }
                });
                return false;
            } else if (id_district == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kecamatan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#id_district").focus();
                    }
                });
                return false;
            } else if (id_village == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Desa / Kelurahan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#id_village").focus();
                    }
                });
                return false;
            } else if (status_tinggal == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Status Tinggal tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#status_tinggal").focus();
                    }
                });
                return false;
            } else if (kode_pos == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kode Pos tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#kode_pos").focus();
                    }
                });
                return false;
            } else if (kode_pembiayaan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jenis Pembiayaan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#kode_pembiayaan").focus();
                    }
                });
                return false;
            } else if (jangka_waktu == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jangka Waktu tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#jangka_waktu").focus();
                    }
                });
                return false;
            } else if (jumlah == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#jumlah").focus();
                    }
                });
                return false;
            } else if (keperluan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Keperluan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#keperluan").focus();
                    }
                });
                return false;
            } else if (jaminan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jaminan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#jaminan").focus();
                    }
                });
                return false;
            } else {
                $(this).find('button[type="submit"]').attr('disabled', 'disabled');
                $(this).find('button[type="submit"]').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                )
            }
        });

        function enableFields() {
            $(document).find("#formPembiayaan").find('input[name="nik"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('input[name="nama_lengkap"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('input[name="tempat_lahir"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('input[name="tanggal_lahir"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('select[name="jenis_kelamin"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('select[name="pendidikan_terakhir"]').removeAttr(
                'disabled');
            $(document).find("#formPembiayaan").find('select[name="status_pernikahan"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('input[name="jml_tanggungan"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('input[name="nama_pasangan"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('input[name="pekerjaan_pasangan"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('input[name="nama_ibu"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('input[name="nama_saudara"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('input[name="no_hp"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('textarea[name="alamat"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('select[name="id_province"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('select[name="id_regency"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('select[name="id_district"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('select[name="id_village"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('select[name="status_tinggal"]').removeAttr('disabled');
            $(document).find("#formPembiayaan").find('input[name="kode_pos"]').removeAttr('disabled');
        }

    });
</script>
@endpush
