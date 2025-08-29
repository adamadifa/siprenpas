@extends('layouts.app')
@section('titlepage', 'Testimoni')

@section('content')
@section('navigasi')
    <span>Testimoni</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('testimonials.create')
                    <a href="{{ route('testimonials.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-2"></i> Tambah Testimoni
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
                                        <th width="15%">Foto</th>
                                        <th width="20%">Nama</th>
                                        <th width="40%">Testimoni</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($testimonials as $d)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="text-center">
                                                @if ($d->foto)
                                                    <img src="{{ asset('storage/testimonials/' . $d->foto) }}" alt="Foto {{ $d->nama }}"
                                                        class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
                                                @else
                                                    <div class="bg-light text-center p-2 rounded">
                                                        <i class="ti ti-user" style="font-size: 2rem;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $d->nama }}</td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 300px;" title="{{ $d->testimoni }}">
                                                    {{ $d->testimoni }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if ($d->status)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('testimonials.edit')
                                                        <div>
                                                            <a href="{{ route('testimonials.edit', $d->id) }}" class="me-2">
                                                                <i class="ti ti-edit text-success"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                    @can('testimonials.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform"
                                                                action="{{ route('testimonials.destroy', $d->id) }}">
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
