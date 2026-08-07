@extends('layouts.app')
@section('titlepage', 'Mata Pelajaran')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-book fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Mata Pelajaran</h4>
                        <p class="text-muted mb-0 small">Manajemen kurikulum dan materi pelajaran</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-database me-1"></i> Data Master
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-book me-1"></i> Mata Pelajaran
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
            @can('matapelajaran.store')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btnCreate"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Mata Pelajaran</span>
                </button>
            @endcan
        </div>

        <!-- Filter Form -->
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('mata-pelajaran.index') }}" method="GET" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <x-input-with-icon label="" value="{{ Request('nama_matpel') }}" name="nama_matpel"
                                placeholder="Cari Nama Mapel" icon="ti ti-search" />
                        </div>
                        @if (auth()->user()->hasRole('super admin'))
                            <div class="col-md-3 col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="ti ti-school text-muted"></i></span>
                                        <select name="kode_unit" class="form-select">
                                            <option value="">Semua Unit</option>
                                            @foreach ($units as $u)
                                                <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                                    {{ $u->nama_unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-3 col-12">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-layout-grid text-muted"></i></span>
                                    <select name="kelompok" class="form-select">
                                        <option value="">Semua Kelompok</option>
                                        <option value="A" {{ Request('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A</option>
                                        <option value="B" {{ Request('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B</option>
                                        <option value="C" {{ Request('kelompok') == 'C' ? 'selected' : '' }}>Kelompok C</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b; height: 38px;">
                                    <i class="ti ti-search fs-5"></i>
                                    <span>Filter</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Mata Pelajaran</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">NO</th>
                                <th class="text-white py-3">KODE MAPEL</th>
                                <th class="text-white py-3">NAMA MATA PELAJARAN</th>
                                <th class="text-white py-3">KELOMPOK</th>
                                <th class="text-white py-3">UNIT</th>
                                <th class="text-white py-3 text-center">URUTAN</th>
                                <th class="text-white py-3">PARENT</th>
                                <th class="text-white py-3 text-center">STATUS</th>
                                <th class="text-white py-3 text-end" style="width: 100px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($matapelajaran as $mp)
                                <!-- Parent Row -->
                                <tr class="fw-bold bg-light">
                                    <td class="py-2">{{ $loop->iteration }}</td>
                                    <td class="py-2">{{ $mp->kode_matpel }}</td>
                                    <td class="py-2 text-dark">{{ $mp->nama_matpel }}</td>
                                    <td class="py-2">{{ $mp->kelompok }}</td>
                                    <td class="py-2">{{ $mp->unit->nama_unit ?? '-' }}</td>
                                    <td class="py-2 text-center">{{ $mp->urutan }}</td>
                                    <td class="py-2 text-muted">-</td>
                                    <td class="py-2 text-center">
                                        @if ($mp->aktif)
                                            <span class="badge bg-label-success rounded-pill">Aktif</span>
                                        @else
                                            <span class="badge bg-label-danger rounded-pill">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('matapelajaran.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                    style="width: 28px; height: 28px;"
                                                    data-id="{{ Crypt::encrypt($mp->id) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('matapelajaran.delete')
                                                <form method="POST" class="deleteform"
                                                    action="{{ route('mata-pelajaran.delete', Crypt::encrypt($mp->id)) }}">
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

                                <!-- Children Rows -->
                                @foreach ($mp->children as $child)
                                    <tr>
                                        <td class="py-2"></td>
                                        <td class="py-2 ps-4">{{ $child->kode_matpel }}</td>
                                        <td class="py-2 ps-4"><i class="ti ti-corner-down-right me-1 text-muted"></i> {{ $child->nama_matpel }}</td>
                                        <td class="py-2">{{ $child->kelompok }}</td>
                                        <td class="py-2">{{ $child->unit->nama_unit ?? '-' }}</td>
                                        <td class="py-2 text-center">{{ $child->urutan }}</td>
                                        <td class="py-2 small text-muted">{{ $mp->nama_matpel }}</td>
                                        <td class="py-2 text-center">
                                            @if ($child->aktif)
                                                <span class="badge bg-label-success rounded-pill" style="font-size: 0.65rem;">Aktif</span>
                                            @else
                                                <span class="badge bg-label-danger rounded-pill" style="font-size: 0.65rem;">Non-Aktif</span>
                                            @endif
                                        </td>
                                        <td class="py-2 text-end">
                                            <div class="d-flex justify-content-end gap-1">
                                                @can('matapelajaran.edit')
                                                    <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                        style="width: 26px; height: 26px;"
                                                        data-id="{{ Crypt::encrypt($child->id) }}">
                                                        <i class="ti ti-edit" style="font-size: 0.8rem;"></i>
                                                    </a>
                                                @endcan
                                                @can('matapelajaran.delete')
                                                    <form method="POST" class="deleteform"
                                                        action="{{ route('mata-pelajaran.delete', Crypt::encrypt($child->id)) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                                            style="width: 26px; height: 26px;">
                                                            <i class="ti ti-trash" style="font-size: 0.8rem;"></i>
                                                        </a>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-book-off fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Mata Pelajaran</h5>
                                        <p class="text-muted small">Silahkan tambah data baru atau sesuaikan filter pencarian.</p>
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
<x-modal-form id="modal" size="modal-lg" show="loadmodal" title="" />
@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `<div class="d-flex justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>`;

        // Handle Create Button
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Tambah Data Mata Pelajaran");
            $("#loadmodal").load(`{{ route('mata-pelajaran.create') }}`);
        });

        // Handle Edit Button
        $(document).on('click', '.btnEdit', function(e) {
            e.preventDefault();
            const id = $(this).data("id");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Edit Data Mata Pelajaran");
            $("#loadmodal").load(`/mata-pelajaran/${id}/edit`);
        });

        // Delete Confirm
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
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
