@extends('layouts.app')
@section('titlepage', 'Pembayaran Pendidikan')

@section('content')
@section('navigasi')
    <span>Pembayaran Pendidikan</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('pembayaranpendidikan.index') }}">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Cari Nama Siswa" value="{{ Request('nama_lengkap') }}"
                                        name="nama_lengkap" icon="ti ti-search" />
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <select name="kode_unit" id="kode_unit_search" class="form-select">
                                            <option value="">Unit</option>
                                            @foreach ($unit as $d)
                                                <option value="{{ $d->kode_unit }}"
                                                    {{ Request('kode_unit') == $d->kode_unit ? 'selected' : '' }}>
                                                    {{ $d->nama_unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <select name="tingkat" id="tingkat" class="form-select">
                                            <option value="">Tingkat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <select name="kode_ta" id="kode_ta_search" class="form-select">
                                            <option value="">Tahun Ajaran</option>
                                            @foreach ($tahunajaran as $d)
                                                <option value="{{ $d->kode_ta }}"
                                                    @if (!empty(Request('kode_ta'))) @if (Request('kode_ta') == $d->kode_ta)
                                                            selected @endif
                                                @else @if ($kode_ta == $d->kode_ta) selected @endif
                                                    @endif
                                                    >
                                                    {{ $d->tahun_ajaran }}

                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                        <th>No.</th>
                                        <th>No. Pendaftaran</th>
                                        <th>ID Siswa</th>
                                        {{-- <th>NISN</th> --}}
                                        <th>NIS</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Unit</th>
                                        <th>Tingkat</th>
                                        <th>Kelas</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendaftaran as $d)
                                        <tr>
                                            <td>{{ $loop->iteration + ($pendaftaran->currentPage() - 1) * $pendaftaran->perPage() }}
                                            </td>
                                            <td>{{ $d->no_pendaftaran }}</td>
                                            <td>{{ $d->id_siswa }}</td>
                                            {{-- <td>{{ $d->nisn }}</td> --}}
                                            <td>{{ $d->nis }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ !empty($d->tanggal_lahir) ? DateToIndo($d->tanggal_lahir) : '' }}
                                            </td>
                                            <td>{{ !empty($d->jenis_kelamin) ? $jenis_kelamin[$d->jenis_kelamin] : '' }}
                                            </td>
                                            <td>{{ $d->nama_unit }}</td>
                                            <td>{{ $d->tingkat }}</td>
                                            <td>{{ $d->nama_kelas }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('pembayaranpdd.show')
                                                        <a href="#" class="btnShow"
                                                            no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}">
                                                            <i class="ti ti-moneybag text-info"></i>
                                                        </a>
                                                    @endcan
                                                    @if ($d->kode_ta != $kode_ta)
                                                        <a href="{{ route('pembayaranpendidikan.prosesnaikkelas', Crypt::encrypt($d->no_pendaftaran)) }}"
                                                            class=""
                                                            no_pendaftaran="{{ Crypt::encrypt($d->no_pendaftaran) }}">
                                                            <i class="ti ti-arrow-up btn-warning ms-2"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="float: right;">
                            {{ $pendaftaran->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="modal" size="modal-xl" show="loadmodal" title="" />
<x-modal-form id="modalpotongan" size="" show="loadmodalpotongan" title="" />
<x-modal-form id="modalmutasi" size="" show="loadmodalmutasi" title="" />
<x-modal-form id="modalrencanaspp" size="" show="loadmodalrencanaspp" title="" />
<x-modal-form id="modaleditrencanaspp" size="" show="loadeditrencanaspp" title="" />
<x-modal-form id="modalpembayaran" size="modal-lg" show="loadmodalpembayaran" title="" />
<x-modal-form id="modalDetailbayar" size="modal-lg" show="loaddetailbayar" title="" />
@endsection
@push('myscript')
<script>
    $(function() {
        $(document).on('show.bs.modal', '.modal', function() {
            const zIndex = 1090 + 10 * $('.modal:visible').length;
            $(this).css('z-index', zIndex);
            setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1)
                .addClass('modal-stack'));
        });

        const loading = `<div class="sk-wave sk-primary" style="margin:auto">
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            </div>`;


        $('.btnShow').click(function(e) {
            e.preventDefault();
            var no_pendaftaran = $(this).attr('no_pendaftaran');
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $.ajax({
                url: `/pembayaranpendidikan/${no_pendaftaran}/show`,
                type: 'GET',
                success: function(response) {

                    $('#loadmodal').html(response);
                    getbiaya(no_pendaftaran);
                    getrencanaspp(no_pendaftaran);
                    gethistoribayar(no_pendaftaran);

                },
                error: function(error) {
                    console.error('Error loading modal content', error);
                }
            });
            // $("#modal").modal("show");
            // $("#modal").find("#loadmodal").html(loading);
            // $("#modal").find(".modal-title").text("Data Pembayaran Pendidikan");
            // $("#loadmodal").load(`/pembayaranpendidikan/${no_pendaftaran}/show`);
            // getbiaya(no_pendaftaran);

        });



        function getbiaya(no_pendaftaran) {
            // $(document).find(".tabelbiaya").html(`<tr>
            //     <td colspan="12" class="text-center">
            //         Loading...
            //     </td>
            // </tr>`);
            $.ajax({
                type: 'GET',
                url: `/pembayaranpendidikan/${no_pendaftaran}/getbiaya`,
                cache: false,
                success: function(res) {
                    $(document).find(".tabelbiaya").html(res);
                }
            });
        }

        $(document).on('click', '.inputpotongan', function(e) {
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            const kode_biaya = $(this).attr('kode_biaya');
            const kode_jenis_biaya = $(this).attr('kode_jenis_biaya');
            const jenis_biaya = $(this).attr('jenis_biaya');
            // alert(no_pendaftaran);
            $("#modalpotongan").modal("show");
            $("#modalpotongan").find("#loadmodalpotongan").html(loading);
            $("#modalpotongan").find(".modal-title").text("Input Potongan Biaya " + jenis_biaya);
            $("#loadmodalpotongan").load(
                `/pembayaranpendidikan/${no_pendaftaran}/${kode_jenis_biaya}/${kode_biaya}/inputpotongan`
            );
        });


        $(document).on('submit', '#formPotongan', function(e) {
            e.preventDefault();
            const data = $(this).serialize();
            const potongan = $(this).find("#potongan").val();
            const keterangan = $(this).find("#keterangan").val();

            if (potongan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Potongan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#potongan").focus();
                    }
                });
                return false;
            } else if (keterangan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Keterangan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#keterangan").focus();
                    }
                });
                return false;
            } else {
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').html(
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...'
                );

                $.ajax({
                    url: "{{ route('pembayaranpendidikan.storepotongan') }}",
                    type: "POST",
                    data: data,
                    cache: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        });
                        getbiaya(response.no_pendaftaran);
                        $("#modalpotongan").modal("hide");
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                            didClose: (e) => {
                                $(document).find('#formPotongan').find(
                                    'button[type="submit"]').prop(
                                    'disabled', false);
                                $(document).find('#formPotongan').find(
                                    'button[type="submit"]').html(
                                    '<i class="ti ti-send me-2"></i> Submit'
                                );
                            }
                        });


                    }

                });
            }
        });


        $(document).on('click', '.inputmutasi', function(e) {
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            const kode_jenis_biaya = $(this).attr('kode_jenis_biaya');
            const jenis_biaya = $(this).attr('jenis_biaya');
            const kode_biaya = $(this).attr('kode_biaya');
            // alert(no_pendaftaran);
            $("#modalmutasi").modal("show");
            $("#modalmutasi").find("#loadmodalmutasi").html(loading);
            $("#modalmutasi").find(".modal-title").text("Input Mutasi Biaya " + jenis_biaya);
            $("#loadmodalmutasi").load(
                `/pembayaranpendidikan/${no_pendaftaran}/${kode_jenis_biaya}/${kode_biaya}/inputmutasi`
            );
        });


        $(document).on('submit', '#formMutasi', function(e) {
            e.preventDefault();
            const data = $(this).serialize();
            const jumlah = $(this).find("#jumlah").val();
            const keterangan = $(this).find("#keterangan").val();

            if (jumlah == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah Mutasi tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#jumlah").focus();
                    }
                });
                return false;
            } else if (keterangan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Keterangan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#keterangan").focus();
                    }
                });
                return false;
            } else {
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').html(
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...'
                );

                $.ajax({
                    url: "{{ route('pembayaranpendidikan.storemutasi') }}",
                    type: "POST",
                    data: data,
                    cache: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        });
                        getbiaya(response.no_pendaftaran);
                        $("#modalmutasi").modal("hide");
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                            didClose: (e) => {
                                $(document).find('#formMutasi').find(
                                    'button[type="submit"]').prop(
                                    'disabled', false);
                                $(document).find('#formMutasi').find(
                                    'button[type="submit"]').html(
                                    '<i class="ti ti-send me-2"></i> Submit'
                                );
                            }
                        });


                    }

                });
            }
        });


        $(document).on('click', '#buatrencanaspp', function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            $("#modalrencanaspp").modal("show");
            $("#modalrencanaspp").find("#loadmodalrencanaspp").html(loading);
            $("#modalrencanaspp").find(".modal-title").text("Buat Rencana SPP");
            $("#loadmodalrencanaspp").load(`/rencanaspp/${no_pendaftaran}/create`);
        });


        $(document).on('click', '#btnBayar', function(e) {
            e.preventDefault();
            const no_pendaftaran = $(this).attr('no_pendaftaran');
            $("#modalpembayaran").modal("show");
            $("#modalpembayaran").find("#loadmodalpembayaran").html(loading);
            $("#modalpembayaran").find(".modal-title").text("Pembayaran");
            $("#loadmodalpembayaran").load(`/pembayaranpendidikan/${no_pendaftaran}/create`);

        });

        function toNumber(value) {
            let cleanValue = value.replace(/\./g, '');
            return cleanValue;
        }


        $(document).on('submit', '#formBuatrencanaspp', function(e) {
            e.preventDefault();
            let kode_biaya = $(this).find("#kode_biaya").val();
            let mulai_pembayaran = $(this).find("#mulai_pembayaran").val();
            let jumlah_spp = toNumber($(this).find("#jumlah_spp").val());
            let jumlah_spp_perbulan = $(this).find("#jumlah_spp_perbulan").val();
            let jumlah_bulan = $(this).find("#jumlah_bulan").val();

            let no_pendaftaran = $(this).find("#no_pendaftaran").val();

            if (kode_biaya == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tahun Ajaran Harus Dipilih!',
                    didClose: (e) => {
                        $(this).find("#kode_biaya").focus();
                    }
                });
                return false;
            } else if (mulai_pembayaran == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Mulai Pembayaran tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#mulai_pembayaran").focus();
                    }
                });
                return false;
            } else if (jumlah_spp_perbulan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah SPP Perbulan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#jumlah_spp_perbulan").focus();
                    }
                });
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('rencanaspp.store') }}",
                    data: $(this).serialize(),
                    cache: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            didClose: (e) => {
                                getrencanaspp(response.no_pendaftaran);
                            }
                        });
                    },

                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                            didClose: (e) => {

                            }
                        });
                    }
                });
            }
        });

        function getrencanaspp(no_pendaftaran) {
            $.ajax({
                type: 'GET',
                url: `/rencanaspp/${no_pendaftaran}/getrencanaspp`,
                cache: false,
                success: function(res) {
                    $(document).find("#tabelrencanaspp").html(res);
                }
            })
        }

        $(document).on('click', '.editrencanaspp', function(e) {
            e.preventDefault();
            let kode_rencana_spp = $(this).attr('kode_rencana_spp');
            $("#modalrencanaspp").modal("show");
            $("#modalrencanaspp").find("#loadmodalrencanaspp").html(loading);
            $("#modalrencanaspp").find(".modal-title").text("Edit Rencana SPP");
            $("#loadmodalrencanaspp").load(`/rencanaspp/${kode_rencana_spp}/edit`);
        });

        $(document).on('submit', '#formEditrencanaspp', function(e) {
            e.preventDefault();
            let tagihanspppertahun = $(this).find("#tagihanspppertahun").text().replace(/[^0-9]/g, '');
            let totalspppertahun = $(this).find("#totalspppertahun").text().replace(/[^0-9]/g, '');
            if (parseInt(tagihanspppertahun) != parseInt(totalspppertahun)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah Pembayaran melebihi jumlah SPP pada Tahun Ajaran ini!',
                    didClose: (e) => {
                        $(this).find("#tagihanspppertahun").focus();
                    }
                });
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('rencanaspp.update') }}",
                    data: $(this).serialize(),
                    cache: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            didClose: (e) => {

                            }
                        });
                        $("#modalrencanaspp").modal("hide");
                        getrencanaspp(response.no_pendaftaran);
                    },

                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                            didClose: (e) => {
                                $("#modalrencanaspp").modal("hide");
                            }
                        });
                    }
                });
            }
        });
        let no = 1;
        $(document).on('click', '#btnTambahdetailbayar', function(e) {
            let biaya = $(document).find("#formDetailbayar").find("#kode_biaya").val();
            let databiaya = biaya.split("|");
            let kode_biaya = databiaya[1];
            let kode_jenis_biaya = databiaya[0];
            let jenis_biaya = $(document).find("#formDetailbayar").find("#kode_biaya option:selected")
                .text();
            let jumlah = $(document).find("#formDetailbayar").find("#jumlah").val().replace(/[^0-9]/g,
                '');
            let keterangan = $(document).find("#formDetailbayar").find("#keterangan").val();
            let sisa_tagihan = $(document).find("#formDetailbayar").find("#sisa_tagihan").val().replace(
                /[^0-9]/g, '');

            if (biaya == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Biaya tidak boleh kosong!',
                    didClose: (e) => {
                        $(document).find("#formDetailbayar").find("#kode_biaya").focus();
                    }
                });
                return false;
            } else if (jumlah == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah tidak boleh kosong!',
                    didClose: (e) => {
                        $(document).find("#formDetailbayar").find("#jumlah").focus();
                    }
                });
                return false;
            } else if (parseInt(jumlah) > parseInt(sisa_tagihan)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah melebihi sisa tagihan!',
                    didClose: (e) => {
                        $(document).find("#formDetailbayar").find("#jumlah").focus();
                    }
                });
                return false;
            } else if ($(document).find(`#index_${kode_biaya+kode_jenis_biaya}`).length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Data Sudah Ada!',
                    didClose: (e) => {
                        $(document).find("#formDetailbayar").find("#kode_biaya").focus();
                    }
                });
                return false;
            } else {
                let data = `<tr id="index_${kode_biaya+kode_jenis_biaya}">
                <td>${jenis_biaya}</td>
                <td class='text-end jmlbayar'>${convertToRupiah(jumlah)}</td>
                <td>${keterangan}</td>
                <td>
                    <input type="hidden" name="kode_biaya[]" value="${kode_biaya}" />
                    <input type="hidden" name="kode_jenis_biaya[]" value="${kode_jenis_biaya}" />
                    <input type="hidden" name="keterangan[]" value="${keterangan}" />
                    <input type="hidden" name="jumlah[]" value="${jumlah}" />
                    <a href="#" key="${kode_biaya+kode_jenis_biaya}" class="delete"><i class="ti ti-trash text-danger"></i></a>
                </td>
            </tr>`;

                $(document).find("#detailbayar").append(data);
                no++;

                $(document).find("#formDetailbayar").find("#kode_biaya").val("").trigger("change");
                $(document).find("#formDetailbayar").find("#jumlah").val("");
                $(document).find("#formDetailbayar").find("#keterangan").val("");
                $(document).find("#formDetailbayar").find("#sisa_tagihan").val("");

                hitungTotalBayar();
            }
        });


        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            let key = $(this).attr("key");
            event.preventDefault();
            Swal.fire({
                title: `Apakah Anda Yakin Ingin Menghapus Data Ini ?`,
                text: "Jika dihapus maka data akan hilang permanent.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: "#554bbb",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Hapus Saja!"
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $(document).find(`#index_${key}`).remove();
                    hitungTotalBayar();
                }
            });
        });


        $(document).on('click', '.btnDeletebayar', function(e) {
            e.preventDefault();
            let key = $(this).attr("key");
            event.preventDefault();
            Swal.fire({
                title: `Apakah Anda Yakin Ingin Menghapus Data Ini ?`,
                text: "Jika dihapus maka data akan hilang permanent.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: "#554bbb",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Hapus Saja!"
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('pembayaranpendidikan.delete') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'no_bukti': key
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data Berhasil Dihapus',
                                didClose: (e) => {
                                    gethistoribayar(response
                                        .no_pendaftaran);
                                    getbiaya(response.no_pendaftaran);
                                    getrencanaspp(response
                                        .no_pendaftaran);
                                }
                            })
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "Error!",
                                text: response.responseJSON.message,
                                icon: "error",
                                showConfirmButton: true,
                                didClose: (e) => {

                                }
                            });
                        }
                    });
                }
            });
        });
        $(document).on('click', '.btnDetailbayar', function(e) {
            let no_bukti = $(this).attr('no_bukti');
            $("#modalDetailbayar").modal('show');
            $("#loaddetailbayar").html(loading);
            $("#modalDetailbayar").find(".modal-title").text("Detail Pembayaran");
            $("#loaddetailbayar").load(`/pembayaranpendidikan/${no_bukti}/showdetailbayar`);

        });

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

        function hitungTotalBayar() {
            let totalBayar = 0;
            $(document).find(".jmlbayar").each(function() {
                totalBayar += parseInt($(this).text().replace(/[^0-9]/g, ''));
            });
            $("#totalbayar").text(convertToRupiah(totalBayar));
        }

        $(document).on('submit', '#formDetailbayar', function(e) {
            e.preventDefault();
            let tanggal = $(this).find("#tanggal").val();
            let cekdetail = $(this).find('#tableDetailbayar').find('#detailbayar tr').length;
            let metode_pembayaran = $(this).find("#metode_pembayaran").val();
            if (tanggal == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#tanggal").focus();
                    }
                });
                return false;
            } else if (cekdetail == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Detail Bayar tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#kode_biaya").focus();
                    }
                });
                return false;
            } else if (metode_pembayaran == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Metode pembayaran tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#metode_pembayaran").focus();
                    }
                });
                return false;
            } else {
                $(this).find("#btnSimpan").prop('disabled', true);
                $(this).find("#btnSimpan").html(
                    '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...'
                );
                $.ajax({
                    type: "POST",
                    url: "{{ route('pembayaranpendidikan.store') }}",
                    cache: false,
                    data: $(this).serialize(),
                    success: function(respond) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: respond.message,
                            didClose: (e) => {
                                $("#modalpembayaran").modal("hide");
                                gethistoribayar(respond.no_pendaftaran);
                                getrencanaspp(respond.no_pendaftaran);
                                getbiaya(respond.no_pendaftaran);

                            }
                        });
                    },
                    error: function(respond) {
                        $(this).find("#btnSimpan").prop('disabled', false);
                        Swal.fire({
                            title: "Error!",
                            text: respond.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                        });
                    }
                });
            }
        });

        function gethistoribayar(no_pendaftaran) {
            $.ajax({
                type: 'GET',
                url: `/pembayaranpendidikan/${no_pendaftaran}/gethistoribayar`,
                cache: false,
                success: function(res) {
                    $(document).find("#tabelhistoribayar").html(res);
                }
            });
        }

        function getTingkatByUnit(kode_unit, selected = '') {
            selected = "{{ Request('tingkat') }}"
            $.ajax({
                type: "POST",
                url: "{{ route('unit.gettingkatbyunit') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    selected: selected
                },
                success: function(respond) {
                    $(document).find("#tingkat").html(respond);
                }
            });

        }
        $(document).on('change', '#kode_unit_search', function() {
            const kode_unit = $(this).val();
            getTingkatByUnit(kode_unit);
        });

        getTingkatByUnit("{{ Request('kode_unit') }}");
    });
</script>
@endpush
