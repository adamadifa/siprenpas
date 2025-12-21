@extends('layouts.app')
@section('titlepage', 'Biaya')

@section('content')
@section('navigasi')
    <span>Biaya</span>
@endsection
<div class="row">
    <div class="col-lg-10 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('biaya.create')
                    <a href="#" class="btn btn-primary" id="btnCreate"><i class="fa fa-plus me-2"></i> Tambah
                        Biaya</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('biaya.index') }}">
                            <div class="row">
                                <div class="col-lg-5 col-sm-12 col-md-12">
                                    <x-select label="Jenjang / Unit" name="kode_unit" :data="$unit" key="kode_unit" textShow="nama_unit"
                                        upperCase="true" selected="{{ Request('kode_unit') }}" />
                                </div>
                                <div class="col-lg-5 col-sm-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <select name="kode_ta" id="kode_ta" class="form-select">
                                            <option value="">Tahun Ajaran</option>
                                            @foreach ($tahunajaran as $d)
                                                <option value="{{ $d->kode_ta }}"
                                                    @if (!empty(Request('kode_ta'))) {{ Request('kode_ta') == $d->kode_ta ? 'selected' : '' }} @else {{ $d->status == '1' ? 'selected' : '' }} @endif>
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
                                        <th>Kode Biaya</th>
                                        <th>Jenjang / Unit</th>
                                        <th>Tingkat</th>
                                        <th>Asrama</th>
                                        <th>Tahun Ajaran</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biaya as $d)
                                        <tr>
                                            <td>{{ $d->kode_biaya }}</td>
                                            <td>{{ $d->nama_unit }} {!! $d->asrama == 1 ? '<span class="badge bg-success">Asrama</span>' : '' !!}</td>
                                            <td>{{ $d->tingkat }}</td>
                                            <td class="text-center">
                                                @if ($d->asrama)
                                                    <i class="ti ti-square-check text-success"></i>
                                                @else
                                                    <i class="ti ti-square-x text-danger"></i>
                                                @endif
                                            </td>
                                            <td>{{ $d->tahun_ajaran }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('biaya.edit')
                                                        <div>
                                                            <a href="#" class="me-2 btnEdit" kode_biaya="{{ Crypt::encrypt($d->kode_biaya) }}">
                                                                <i class="ti ti-edit text-success"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @can('biaya.show')
                                                        <div>
                                                            <a href="#" class="me-2 btnShow" kode_biaya="{{ Crypt::encrypt($d->kode_biaya) }}">
                                                                <i class="ti ti-file-description text-info"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @can('biaya.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform"
                                                                action="{{ route('biaya.delete', Crypt::encrypt($d->kode_biaya)) }}">
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
<x-modal-form id="modal" size="modal-lg" show="loadmodal" title="" />
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#modal').modal("show");
            $(".modal-title").text("Tambah Data Biaya");
            $("#loadmodal").load("{{ route('biaya.create') }}");
        });

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const kode_biaya = $(this).attr("kode_biaya");
            $('#modal').modal("show");
            $(".modal-title").text("Edit Data Biaya");
            $("#loadmodal").load(`/biaya/${kode_biaya}/edit`);
        });

        $(".btnShow").click(function(e) {
            e.preventDefault();
            const kode_biaya = $(this).attr("kode_biaya");
            $('#modal').modal("show");
            $(".modal-title").text("Detail Data Biaya");
            $("#loadmodal").load(`/biaya/${kode_biaya}/show`);
        });
    });
</script>
@endpush
