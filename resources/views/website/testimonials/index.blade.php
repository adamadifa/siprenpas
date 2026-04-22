@extends('layouts.app')
@section('titlepage', 'Testimoni')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-message-2 fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Testimoni</h4>
                        <p class="text-muted mb-0 small">Manajemen testimoni dan ulasan wali santri/alumni</p>
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
                                <i class="ti ti-message-2 me-1"></i> Testimoni
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
            @can('testimonials.create')
                <a href="{{ route('testimonials.create') }}" class="btn d-flex align-items-center gap-2 shadow-sm text-white"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Testimoni</span>
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
                <form action="{{ route('testimonials.index') }}" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-11 col-md-10">
                            <x-input-with-icon label="" value="{{ Request('nama') }}" name="nama"
                                placeholder="Cari Nama" icon="ti ti-user" />
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
                <i class="ti ti-message-2 fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Testimoni</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 1%;">NO.</th>
                                <th class="text-white py-3 text-center" style="width: 80px;">FOTO</th>
                                <th class="text-white py-3">NAMA</th>
                                <th class="text-white py-3">TESTIMONI</th>
                                <th class="text-white py-3 text-center">STATUS</th>
                                <th class="text-white py-3 text-end" style="width: 80px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($testimonials as $d)
                                <tr>
                                    <td class="py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2 text-center">
                                        <div class="avatar avatar-lg rounded overflow-hidden border bg-white p-1 shadow-sm mx-auto" style="width: 50px; height: 50px;">
                                            @if ($d->foto && Storage::disk('public')->exists('testimonials/' . $d->foto))
                                                <img src="{{ asset('storage/testimonials/' . $d->foto) }}" alt="{{ $d->nama }}" style="object-fit: cover; width: 100%; height: 100%;">
                                            @else
                                                <div class="bg-label-success d-flex align-items-center justify-content-center h-100 w-100">
                                                    <i class="ti ti-user fs-3"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-2 fw-bold text-dark">{{ $d->nama }}</td>
                                    <td class="py-2">
                                        <div class="small text-muted text-wrap" style="max-width: 400px;">{{ $d->testimoni }}</div>
                                    </td>
                                    <td class="py-2 text-center">
                                        @if ($d->status)
                                            <span class="badge bg-label-success">Aktif</span>
                                        @else
                                            <span class="badge bg-label-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('testimonials.edit')
                                                <a href="{{ route('testimonials.edit', $d->id) }}"
                                                    class="btn btn-icon btn-label-success border"
                                                    style="width: 28px; height: 28px;">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('testimonials.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('testimonials.destroy', $d->id) }}">
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
                                            <i class="ti ti-message-2 fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Testimoni</h5>
                                        <p class="text-muted">Silahkan tambah testimoni baru.</p>
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
