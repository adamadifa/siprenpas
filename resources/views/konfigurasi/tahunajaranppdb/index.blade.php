@extends('layouts.app')
@section('titlepage', 'Tahun Ajaran PPDB')

@section('content')
@section('navigasi')
<span>Tahun Ajaran PPDB</span>
@endsection
<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('tahunajaran.create')
                <a href="#" class="btn btn-primary" id="btnCreate"><i class="fa fa-plus me-2"></i> Buat
                    Tahun Ajaran Baru</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Status</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tahun_ajaran as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->kode_ta }}</td>
                                        <td>{{ $d->tahun_ajaran }}</td>
                                        <td>
                                            @if ($d->status=='1')
                                            <span class="badge bg-success">Aktif</span>
                                            @else
                                            <span class="badge bg-danger">Non Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @can('tahunajaran.edit')
                                                <div>
                                                    <a href="#" class="me-2 btnEdit"
                                                        kode_ta="{{ Crypt::encrypt($d->kode_ta) }}">
                                                        <i class="ti ti-edit text-success"></i>
                                                    </a>
                                                </div>
                                                @endcan

                                                @can('tahunajaran.delete')
                                                <div>
                                                    <form method="POST" name="deleteform" class="deleteform"
                                                        action="{{ route('tahunajaranppdb.delete', Crypt::encrypt($d->kode_ta)) }}">
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
<x-modal-form id="modal" size="" show="loadmodal" title="" />
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#modal').modal("show");
            $(".modal-title").text("Buat Tahun Ajaran Baru");
            $("#loadmodal").load("{{ route('tahunajaranppdb.create') }}");
        });

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const kode_ta = $(this).attr('kode_ta')
            $('#modal').modal("show");
            $(".modal-title").text("Edit Tahun Ajaran Baru");
            $("#loadmodal").load(`/tahunajaranppdb/${kode_ta}/edit`);
        });
    });
</script>
@endpush