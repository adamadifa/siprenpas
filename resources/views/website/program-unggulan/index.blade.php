@extends('layouts.app')
@section('titlepage', 'Program Unggulan')

@section('content')
@section('navigasi')
    <span>Program Unggulan</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('programunggulan.create')
                    <a href="{{ route('program-unggulan.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-2"></i> Tambah Program Unggulan
                    </a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">No.</th>
                                        <th width="25%">Nama Program</th>
                                        <th width="40%">Deskripsi</th>
                                        <th width="10%">Urutan</th>
                                        <th width="10%">Dibuat</th>
                                        <th width="10%">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($programUnggulan as $d)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $d->nama_program }}</td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 300px;" title="{{ $d->deskripsi }}">
                                                    {{ $d->deskripsi ?: '-' }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ $d->urutan }}</span>
                                            </td>
                                            <td class="text-center">
                                                {{ $d->created_at->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('programunggulan.edit')
                                                        <div>
                                                            <a href="{{ route('program-unggulan.edit', $d->id) }}" class="me-2">
                                                                <i class="ti ti-edit text-success"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('programunggulan.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform"
                                                                action="{{ route('program-unggulan.destroy', $d->id) }}">
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
@endsection

@push('myscript')
<script>
    $(function() {
        $(".delete-confirm").click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
