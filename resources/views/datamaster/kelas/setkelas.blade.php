@extends('layouts.app')
@section('titlepage', 'Set Kelas')

@section('content')
@section('navigasi')
    <span>Set Kelas</span>
@endsection
<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('kelas.create')
                    <a href="#" class="btn btn-primary" id="btnAddsiswa"><i class="fa fa-plus me-2"></i>Tambah Siswa</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody id="">

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18">Tambah Siswa</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="#" id="frmTambahSiswa">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary" id="tambahkansemua"><i class="ti ti-plus me-1"></i>
                                    Tambahkan Semua
                                </button>
                                <button class="btn btn-danger" id="batalkansemua"><i
                                        class="ti ti-circle-minus me-1"></i> Batalkan Semua
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <x-input-with-icon label="Nama Siswa" name="nama_siswa" icon="ti ti-user" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table class="table table-bordered table-striped table-hover" id="tabelsiswa">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>ID</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody id="loadsiswa">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}


<script>
    $(function() {
        $("#btnAddsiswa").click(function(e) {
            e.preventDefault();
            const kode_kelas = "{{ Crypt::encrypt($kelas->kode_kelas) }}";
            $('#modal').modal("show");
            $(".modal-title").text("Tambah Data Siswa");
            getSiswa();
        });

        function getSiswa() {
            const kode_kelas = "{{ $kelas->kode_kelas }}";
            const nama_siswa = $(document).find("#nama_siswa").val();
            // $("#loadkaryawan").html(`<tr><td colspan="5" class="text-center">Tunggu Sebentar...</td></tr>`);
            $.ajax({
                type: 'POST',
                url: `/kelas/getsiswa`,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_kelas: kode_kelas,
                    nama_siswa: nama_siswa
                },
                cache: false,
                success: function(respond) {
                    let no = 1;
                    $(document).find("#loadsiswa").html("");
                    respond.forEach(element => {
                        $(document).find("#loadsiswa").append(`
                            <tr>
                                <td>${no++}</td>
                                <td>${element.id_siswa}</td>
                                <td>${element.nis}</td>
                                <td>${element.nama_lengkap}</td>
                                <td>
                                ${element.ceksiswa == null ? `<a href="#"><i class="ti ti-circle-plus text-success"></i></a>` : `<a href="#"><i class="ti ti-circle-minus text-danger"></i></a>`}
                                </td>
                            </tr>
                        `);
                    });
                }
            })
        }




    });
</script>
@endpush
