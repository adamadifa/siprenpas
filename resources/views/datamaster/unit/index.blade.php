@extends('layouts.app')
@section('titlepage', 'Unit')

@section('content')
@section('navigasi')
    <span>Unit</span>
@endsection
<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('unit.create')
                    <a href="#" class="btn btn-primary" id="btncreateUnit"><i class="fa fa-plus me-2"></i> Tambah
                        Unit</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('unit.index') }}">
                            <div class="row">
                                <div class="col-lg-10 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Nama Unit" value="{{ Request('nama_unit_search') }}"
                                        name="nama_unit_search" icon="ti ti-search" />
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
                                        <th>Kode Unit</th>
                                        <th>Nama Unit</th>
                                        <th>Logo</th>
                                        <th>Status</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($unit as $d)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $d->kode_unit }}</td>
                                            <td>{{ $d->nama_unit }}</td>
                                            <td class="text-center">
                                                @if ($d->logo)
                                                    <img src="{{ asset('storage/' . $d->logo) }}"
                                                        alt="Logo {{ $d->nama_unit }}" class="img-fluid"
                                                        style="max-height: 50px;">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($d->status == 1)
                                                    <span class="badge bg-success">Show</span>
                                                @else
                                                    <span class="badge bg-secondary">Hide</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('unit.edit')
                                                        <div>
                                                            <a href="#" class="me-2 editUnit"
                                                                kode_unit="{{ Crypt::encrypt($d->kode_unit) }}">
                                                                <i class="ti ti-edit text-success"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('unit.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform"
                                                                action="{{ route('unit.delete', Crypt::encrypt($d->kode_unit)) }}">
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
<x-modal-form id="mdlcreateUnit" size="" show="loadcreateUnit" title="Tambah Unit" />
<x-modal-form id="mdleditUnit" size="" show="loadeditUnit" title="Edit Unit" />
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btncreateUnit").click(function(e) {
            e.preventDefault();
            $('#mdlcreateUnit').modal("show");
            $("#loadcreateUnit").load('/unit/create');
        });

        $(".editUnit").click(function(e) {
            var kode_unit = $(this).attr("kode_unit");
            e.preventDefault();
            $('#mdleditUnit').modal("show");
            $("#loadeditUnit").load('/unit/' + kode_unit + '/edit');
        });
    });
</script>
@endpush
