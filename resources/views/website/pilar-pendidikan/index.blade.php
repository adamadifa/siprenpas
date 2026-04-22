@extends('layouts.app')
@section('titlepage', 'Pilar Pendidikan')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-columns fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Pilar Pendidikan</h4>
                        <p class="text-muted mb-0 small">Manajemen data pilar utama pendidikan pesantren</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-home-2 me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-columns me-1"></i> Pilar Pendidikan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('pilarpendidikan.create')
                <a href="{{ route('pilar-pendidikan.create') }}" class="btn d-flex align-items-center gap-2 shadow-sm text-white"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Pilar Pendidikan</span>
                </a>
            @endcan
        </div>

        <!-- Filter Section -->
        <style>
            .form-filter .form-group {
                margin-bottom: 0 !important;
            }
        </style>
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('pilar-pendidikan.index') }}" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-11 col-md-10">
                            <x-input-with-icon label="" value="{{ Request('nama_pilar') }}" name="nama_pilar"
                                placeholder="Cari Nama Pilar" icon="ti ti-columns" />
                        </div>
                        <div class="col-lg-1 col-md-2">
                            <button type="submit" class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center"
                                style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search fs-5"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-columns fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Pilar Pendidikan</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 1%;">NO.</th>
                                <th class="text-white py-3">NAMA PILAR</th>
                                <th class="text-white py-3">DESKRIPSI</th>
                                <th class="text-white py-3 text-center">URUTAN</th>
                                <th class="text-white py-3 text-center">DIBUAT</th>
                                <th class="text-white py-3 text-end" style="width: 80px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pilarPendidikan as $pilar)
                                <tr>
                                    <td class="py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2 fw-bold text-dark">{{ $pilar->nama_pilar }}</td>
                                    <td class="py-2">
                                        <div class="small text-muted text-wrap" style="max-width: 400px;">{{ $pilar->deskripsi ?: '-' }}</div>
                                    </td>
                                    <td class="py-2 text-center">
                                        <span class="badge bg-label-primary">{{ $pilar->urutan }}</span>
                                    </td>
                                    <td class="py-2 text-center small">
                                        {{ $pilar->created_at?->format('d/m/Y') }}
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('pilarpendidikan.edit')
                                                <a href="{{ route('pilar-pendidikan.edit', $pilar->id) }}"
                                                    class="btn btn-icon btn-label-success border"
                                                    style="width: 28px; height: 28px;">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('pilarpendidikan.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('pilar-pendidikan.destroy', $pilar->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                                        style="width: 28px; height: 28px;">
                                                        <i class="ti ti-trash fs-6"></i>
                                                    </a>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-columns fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Pilar Pendidikan</h5>
                                        <p class="text-muted">Silahkan tambah pilar pendidikan baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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

