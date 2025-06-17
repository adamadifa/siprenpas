@extends('layouts.app')
@section('titlepage', 'Agenda Kegiatan')

@section('content')
@section('navigasi')
    <span>Agenda Kegiatan</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('agendakegiatan.create')
                    <a href="#" class="btn btn-primary" id="btncreateAgendaKegiatan"><i class="fa fa-plus me-2"></i>
                        Tambah
                        Agenda Kegiatan</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('agendakegiatan.index') }}" id="myForm">
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-warning" type="submit" value="1" name="cetak" id="cetakButton"><i class="ti ti-printer me-1"></i> Cetak</button>
                                        <button class="btn btn-danger" type="submit" value="1" name="cetak_pdf" id="cetakPdfButton"><i class="ti ti-file-text me-1"></i> Cetak PDF</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Dari" value="{{ Request('dari') }}" name="dari"
                                        icon="ti ti-calendar" datepicker="flatpickr-date" />
                                </div>
                                <div class="col-lg-6 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Sampai" value="{{ Request('sampai') }}" name="sampai"
                                        icon="ti ti-calendar" datepicker="flatpickr-date" />
                                </div>
                            </div>
                            @if ($user->hasRole('super admin'))
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <select name="kode_jabatan" id="kode_jabatan"
                                                class="form-select select2Kodejabatansearch">
                                                <option value="">Jabatan</option>
                                                @foreach ($jabatan as $d)
                                                    <option value="{{ $d->kode_jabatan }}"
                                                        {{ Request('kode_jabatan') == $d->kode_jabatan ? 'selected' : '' }}>
                                                        {{ strtoUpper($d->nama_jabatan) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <select name="kode_dept" id="kode_dept"
                                                class="form-select select2Kodedeptsearc">
                                                <option value="">Departemen</option>
                                                @foreach ($departemen as $d)
                                                    <option value="{{ $d->kode_dept }}"
                                                        {{ Request('kode_dept') == $d->kode_dept ? 'selected' : '' }}>
                                                        {{ strtoUpper($d->nama_dept) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12">
                                    <button class="btn btn-primary w-100"><i class="ti ti-search me-2"></i>Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 1%">No.</th>
                                        <th style="width: 10%">Tanggal</th>
                                        <th style="width: 29%">Nama Kegiatan</th>
                                        <th style="width: 40%">Uraian Kegiatan</th>

                                        <th style="width: 5%">Dept</th>
                                        <th style="width: 10%">User</th>
                                        <th style="width: 5%">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agenda_kegiatan as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                            <td>{{ strip_tags($d->nama_kegiatan) }}</td>
                                            <td>{{ strip_tags($d->uraian_kegiatan) }}</td>

                                            <td>{{ $d->kode_dept }}</td>
                                            <td>{{ formatNama1($d->name) }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('agendakegiatan.edit')
                                                        <div>
                                                            <a href="#" class="me-2 btnEdit"
                                                                id="{{ Crypt::encrypt($d->id) }}">
                                                                <i class="ti ti-edit text-success"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('agendakegiatan.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform"
                                                                action="{{ route('agendakegiatan.delete', Crypt::encrypt($d->id)) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a href="#" class="delete-confirm ml-1">
                                                                    <i class="ti ti-trash text-danger"></i>
                                                                </a>
                                                            </form>
                                                        </div>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        {{ $agenda_kegiatan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="mdlAgendaKegiatan" size="" show="loadAgendaKegiatan" title="" />

@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $('#cetakButton').click(function(e) {
        e.preventDefault();
        // Ambil data form menggunakan jQuery
        const formData = $('#myForm').serialize();
        const url = "{{ URL::current() }}";
        // URL tujuan untuk cetak menggunakan jQuery
        const printUrl = url + '?' + formData + '&cetak=1';

        const kode_dept = $('#kode_dept').val();
        const dari = $('#dari').val();
        const sampai = $('#sampai').val();

        if (kode_dept == '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Departemen tidak boleh kosong!',
                didClose: (e) => {
                    $('#kode_dept').focus();
                }
            });
            return false;
        } else if (dari == '' || sampai == '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Tanggal tidak boleh kosong!',
                didClose: (e) => {
                    $('#dari').focus();
                }
            });
            return false;
        } else {
            window.open(printUrl, '_blank');
        }
        // Buka tab baru untuk cetak menggunakan jQuery
    });
</script>
<script>
    $(function() {
        $("#btncreateAgendaKegiatan").click(function(e) {
            e.preventDefault();
            $('#mdlAgendaKegiatan').modal("show");
            $("#mdlAgendaKegiatan").find(".modal-title").text("Tambah Agenda Kegiatan");
            $("#loadAgendaKegiatan").load('/agendakegiatan/create');
        });

        $(".btnEdit").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdlAgendaKegiatan').modal("show");
            $("#mdlAgendaKegiatan").find(".modal-title").text("Edit Agenda Kegiatan");
            $("#loadAgendaKegiatan").load('/agendakegiatan/' + id + '/edit');
        });
    });
</script>
@endpush
