@extends('layouts.app')
@section('titlepage', 'Jenjang Pendidikan')

@section('content')
@section('navigasi')
<span>Jenjang Pendidikan</span>
@endsection
<div class="row">
    <div class="col-lg-5 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('jenjang-pendidikan.create')
                <a href="#" class="btn btn-primary" id="btncreateJenjangPendidikan"><i class="fa fa-plus me-2"></i> Tambah
                    Jenjang Pendidikan</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('jenjang-pendidikan.index') }}">
                            <div class="row">
                                <div class="col-lg-10 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Jenjang Pendidikan" value="{{ Request('jenjang_pendidikan_search') }}"
                                        name="jenjang_pendidikan_search" icon="ti ti-search" />
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
                                        <th>Jenjang Pendidikan</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jenjangPendidikan as $d)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $d->jenjang_pendidikan }}</td>
                                        <td>
                                            <div class="d-flex">
                                                @can('jenjang-pendidikan.edit')
                                                <div>
                                                    <a href="#" class="me-2 editJenjangPendidikan"
                                                        id_jenjang="{{ Crypt::encrypt($d->id) }}">
                                                        <i class="ti ti-edit text-success"></i>
                                                    </a>
                                                </div>
                                                @endcan

                                                @can('jenjang-pendidikan.delete')
                                                <div>
                                                    <form method="POST" name="deleteform" class="deleteform"
                                                        action="{{ route('jenjang-pendidikan.delete', Crypt::encrypt($d->id)) }}">
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
            </div>
        </div>
    </div>
</div>
<x-modal-form id="mdlcreateJenjangPendidikan" size="" show="loadcreateJenjangPendidikan" title="Tambah Jenjang Pendidikan" />
<x-modal-form id="mdleditJenjangPendidikan" size="" show="loadeditJenjangPendidikan" title="Edit Jenjang Pendidikan" />
@endsection
@push('myscript')
<script>
    $(function() {
        $("#btncreateJenjangPendidikan").click(function(e) {
            e.preventDefault();
            $('#mdlcreateJenjangPendidikan').modal("show");
            $("#loadcreateJenjangPendidikan").load('/jenjang-pendidikan/create');
        });

        $(".editJenjangPendidikan").click(function(e) {
            var id_jenjang = $(this).attr("id_jenjang");
            e.preventDefault();
            $('#mdleditJenjangPendidikan').modal("show");
            $("#loadeditJenjangPendidikan").load('/jenjang-pendidikan/' + id_jenjang + '/edit');
        });
    });
</script>
@endpush







