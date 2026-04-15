@extends('layouts.app')
@section('titlepage', 'Mesin Fingerprint')

@section('content')
@section('navigasi')
    <span class="text-muted fw-light">Konfigurasi /</span> Mesin Fingerprint
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <a href="#" class="btn btn-primary" id="btnCreate"><i class="fa fa-plus me-2"></i> Tambah
                        Mesin</a>
                    <a href="{{ route('mesinfingerprint.logmesin') }}" class="btn btn-outline-info"><i
                            class="ti ti-list me-1"></i> Log Mesin</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Mesin</th>
                                        <th>Serial Number (SN)</th>
                                        <th>Titik Koordinat</th>
                                        <th>Status</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mesin as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->nama_mesin }}</td>
                                            <td><code>{{ $d->sn }}</code></td>
                                            <td>{{ $d->titik_koordinat ?? '-' }}</td>
                                            <td>
                                                @if ($d->status == 'Aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <a href="#" class="me-2 btnEdit"
                                                            data-id="{{ Crypt::encrypt($d->id) }}">
                                                            <i class="ti ti-edit text-success"></i>
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <form method="POST" name="deleteform" class="deleteform"
                                                            action="{{ route('mesinfingerprint.delete', Crypt::encrypt($d->id)) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="#" class="delete-confirm ml-1">
                                                                <i class="ti ti-trash text-danger"></i>
                                                            </a>
                                                        </form>
                                                    </div>
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
<x-modal-form id="mdlCreate" size="" show="loadCreate" title="Tambah Mesin Fingerprint" />
<x-modal-form id="mdlEdit" size="" show="loadEdit" title="Edit Mesin Fingerprint" />
@endsection
@push('myscript')
<script>
    $(function() {
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#mdlCreate').modal("show");
            $("#loadCreate").load("{{ route('mesinfingerprint.create') }}");
        });

        $(".btnEdit").click(function(e) {
            var id = $(this).attr("data-id");
            e.preventDefault();
            $('#mdlEdit').modal("show");
            $("#loadEdit").load('/mesinfingerprint/' + id + '/edit');
        });
    });
</script>
@endpush
