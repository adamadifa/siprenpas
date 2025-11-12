@extends('layouts.app')
@section('titlepage', 'Pendaftaran Got Talent')

@section('content')
@section('navigasi')
    <span>Pendaftaran Got Talent</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('pendaftaran-got-talent.create')
                    <a href="#" class="btn btn-primary" id="btncreatePendaftaranGotTalent"><i class="fa fa-plus me-2"></i>
                        Tambah
                        Pendaftaran</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('pendaftaran-got-talent.index') }}">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Nomor Register"
                                        value="{{ Request('nomor_register_search') }}" name="nomor_register_search"
                                        icon="ti ti-search" />
                                </div>
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Nama Lengkap" value="{{ Request('nama_lengkap_search') }}"
                                        name="nama_lengkap_search" icon="ti ti-search" />
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-12">
                                    <select name="id_jenjang_search" id="id_jenjang_search" class="form-select">
                                        <option value="">Jenjang Pendidikan</option>
                                        @foreach ($jenjangPendidikan as $d)
                                            <option value="{{ $d->id }}"
                                                {{ Request('id_jenjang_search') == $d->id ? 'selected' : '' }}>
                                                {{ $d->jenjang_pendidikan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-1 col-sm-12 col-md-12">
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
                                        <th>Nomor Register</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jenjang Pendidikan</th>
                                        <th>Asal Sekolah</th>
                                        <th>No. HP</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendaftaranGotTalent as $d)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $d->nomor_register }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ $d->jenjangPendidikan->jenjang_pendidikan ?? '-' }}</td>
                                            <td>{{ $d->asal_sekolah ?? '-' }}</td>
                                            <td>{{ $d->no_hp ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('pendaftaran-got-talent.index')
                                                        <div>
                                                            <a href="#" class="me-2 showDetailPendaftaranGotTalent"
                                                                id_pendaftaran="{{ Crypt::encrypt($d->id) }}">
                                                                <i class="ti ti-info-circle text-info"
                                                                    title="Detail Peserta & Lomba"></i>
                                                            </a>
                                                        </div>
                                                        <div>
                                                            <a href="{{ route('pendaftaran-got-talent.show', Crypt::encrypt($d->id)) }}"
                                                                class="me-2">
                                                                <i class="ti ti-eye text-primary" title="Lihat Detail"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('pendaftaran-got-talent.edit')
                                                        <div>
                                                            <a href="#" class="me-2 editPendaftaranGotTalent"
                                                                id_pendaftaran="{{ Crypt::encrypt($d->id) }}">
                                                                <i class="ti ti-edit text-success" title="Edit"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('pendaftaran-got-talent.index')
                                                        @if (empty($d->id_user))
                                                            <div>
                                                                <a href="{{ route('pendaftaran-got-talent.createuser', Crypt::encrypt($d->id)) }}"
                                                                    class="me-2" title="Buat User Peserta">
                                                                    <i class="ti ti-user-plus text-warning"></i>
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div>
                                                                <i class="ti ti-user text-success me-2"
                                                                    title="User sudah dibuat"></i>
                                                            </div>
                                                        @endif
                                                    @endcan

                                                    @can('pendaftaran-got-talent.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform"
                                                                action="{{ route('pendaftaran-got-talent.delete', Crypt::encrypt($d->id)) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a href="#" class="delete-confirm ml-1">
                                                                    <i class="ti ti-trash text-danger" title="Hapus"></i>
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
            </div>
        </div>
    </div>
</div>
<x-modal-form id="mdlcreatePendaftaranGotTalent" size="" show="loadcreatePendaftaranGotTalent"
    title="Tambah Pendaftaran Got Talent" />
<x-modal-form id="mdleditPendaftaranGotTalent" size="" show="loadeditPendaftaranGotTalent"
    title="Edit Pendaftaran Got Talent" />
<x-modal-form id="mdlshowDetailPendaftaranGotTalent" size="modal-xl" show="loadshowDetailPendaftaranGotTalent"
    title="Detail Peserta & Lomba" />
@endsection
@push('myscript')
<script>
    $(function() {
        $("#btncreatePendaftaranGotTalent").click(function(e) {
            e.preventDefault();
            $('#mdlcreatePendaftaranGotTalent').modal("show");
            $("#loadcreatePendaftaranGotTalent").load('/pendaftaran-got-talent/create');
        });

        $(".editPendaftaranGotTalent").click(function(e) {
            var id_pendaftaran = $(this).attr("id_pendaftaran");
            e.preventDefault();
            $('#mdleditPendaftaranGotTalent').modal("show");
            $("#loadeditPendaftaranGotTalent").load('/pendaftaran-got-talent/' + id_pendaftaran +
                '/edit');
        });

        $(".showDetailPendaftaranGotTalent").click(function(e) {
            var id_pendaftaran = $(this).attr("id_pendaftaran");
            e.preventDefault();
            $('#mdlshowDetailPendaftaranGotTalent').modal("show");
            $("#loadshowDetailPendaftaranGotTalent").load('/pendaftaran-got-talent/' + id_pendaftaran +
                '/show');
        });
    });
</script>
@endpush
