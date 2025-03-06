@extends('layouts.app')
@section('titlepage', 'Karyawan')

@section('content')
@section('navigasi')
    <span>Karyawan</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('karyawan.create')
                    <a href="#" class="btn btn-primary" id="btncreateKaryawan"><i class="fa fa-plus me-2"></i> Tambah
                        Karyawan</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('karyawan.index') }}">
                            <div class="row">
                                <div class="col-lg-10 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Cari Nama Karyawan" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                        icon="ti ti-search" />
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
                                        <th>NPP</th>
                                        <th>Nama Karyawan</th>
                                        <th>Jabatan</th>
                                        <th>Unit</th>
                                        <th>TMT</th>
                                        <th>No. HP</th>
                                        <th>Foto</th>
                                        <th>PIN</th>
                                        <th>Status</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($karyawan as $d)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration + $karyawan->firstItem() - 1 }}
                                            </td>
                                            <td>{{ $d->npp }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ $d->nama_jabatan }}</td>
                                            <td>{{ $d->nama_unit }}</td>
                                            <td>{{ !empty($d->tmt) ? date('d-m-Y', strtotime($d->tmt)) : '' }}</td>
                                            <td>{{ $d->no_hp }}</td>
                                            <td>
                                                @if (!empty($d->foto))
                                                    @if (Storage::disk('public')->exists('/karyawan/' . $d->foto))
                                                        <div class="avatar avatar-xs me-2">
                                                            <img src="{{ getfotoKaryawan($d->foto) }}" alt="" class="rounded-circle">
                                                        </div>
                                                    @else
                                                        <div class="avatar avatar-xs me-2">
                                                            <img src="{{ asset('assets/img/avatars/No_Image_Available.jpg') }}" alt=""
                                                                class="rounded-circle">
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="avatar avatar-xs me-2">
                                                        <img src="{{ asset('assets/img/avatars/No_Image_Available.jpg') }}" alt=""
                                                            class="rounded-circle">
                                                    </div>
                                                @endif

                                            </td>
                                            <td>{{ $d->pin }}</td>
                                            <td>
                                                <a href="{{ route('karyawan.updatestatus', Crypt::encrypt($d->npp)) }}">
                                                    @if ($d->status == 1)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Tidak Aktif</span>
                                                    @endif
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('karyawan.create')
                                                        <div>
                                                            <a href="#" class="me-2 btnSetJamkerja" npp="{{ Crypt::encrypt($d->npp) }}">
                                                                <i class="ti ti-device-watch text-primary"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @can('karyawan.edit')
                                                        <div>
                                                            <a href="#" class="me-2 editKaryawan" npp="{{ Crypt::encrypt($d->npp) }}">
                                                                <i class="ti ti-edit text-success"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @can('karyawan.show')
                                                        <div>
                                                            <a href="{{ route('karyawan.show', Crypt::encrypt($d->npp)) }}" class="me-2">
                                                                <i class="ti ti-file-description text-info"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    <div>
                                                        <a href="#" npp="{{ Crypt::encrypt($d->npp) }}" class="me-1 btnSetharikerja">
                                                            <i class="ti ti-clock-check text-warning"></i>
                                                        </a>
                                                    </div>

                                                    @can('karyawan.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform me-1"
                                                                action="{{ route('karyawan.delete', Crypt::encrypt($d->npp)) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a href="#" class="delete-confirm ml-1">
                                                                    <i class="ti ti-trash text-danger"></i>
                                                                </a>
                                                            </form>
                                                        </div>
                                                    @endcan
                                                    @can('karyawan.createuser')
                                                        @if (empty($d->id_user))
                                                            <a href="{{ route('karyawan.createuser', Crypt::encrypt($d->npp)) }}">
                                                                <i class="ti ti-user-plus text-danger"></i>
                                                            </a>
                                                        @else
                                                            <i class="ti ti-user text-success"></i>
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
                            {{ $karyawan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="mdlcreateKaryawan" size="" show="loadcreateKaryawan" title="Tambah Karyawan" />
<x-modal-form id="mdleditKaryawan" size="" show="loadeditKaryawan" title="Edit Karyawan" />
<x-modal-form id="mdlsetharikerja" size="" show="loadsetharikerja" title="Set Hari Kerja" />
<x-modal-form id="modalSetJamkerja" show="loadmodalSetJamkerja" size="modal-lg" title="Set Jam Kerja" />
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btncreateKaryawan").click(function(e) {
            e.preventDefault();
            $('#mdlcreateKaryawan').modal("show");
            $("#loadcreateKaryawan").load('/karyawan/create');
        });

        $(".editKaryawan").click(function(e) {
            var npp = $(this).attr("npp");
            e.preventDefault();
            $('#mdleditKaryawan').modal("show");
            $("#loadeditKaryawan").load('/karyawan/' + npp + '/edit');
        });

        $(".btnSetharikerja").click(function(e) {
            var npp = $(this).attr("npp");
            e.preventDefault();
            $('#mdlsetharikerja').modal("show");
            $("#loadsetharikerja").load('/karyawan/' + npp + '/setharikerja');
        });

        $(".btnSetJamkerja").click(function() {
            const npp = $(this).attr("npp");
            $("#modalSetJamkerja").modal("show");
            $("#loadmodalSetJamkerja").html(`<div class="sk-wave sk-primary" style="margin:auto">
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            </div>`);

            $("#loadmodalSetJamkerja").load(`/karyawan/${npp}/setjamkerja`);
        });
    });
</script>
@endpush
