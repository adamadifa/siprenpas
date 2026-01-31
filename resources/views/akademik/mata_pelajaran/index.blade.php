@extends('layouts.app')
@section('title', 'Data Mata Pelajaran')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Mata Pelajaran</h5>
                    <a href="#" class="btn btn-primary btn-sm" id="btnCreate">
                        <i class="ti ti-plus me-1"></i> Tambah Data
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Filter Form -->
                    <div class="row mb-3">
                        <div class="col-12">
                             <form action="{{ route('mata-pelajaran.index') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <x-input-with-icon label="Cari Nama Mapel" value="{{ Request('nama_matpel') }}" name="nama_matpel" icon="ti ti-search" />
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="form-group">
                                            <select name="kode_unit" class="form-select select2-filter">
                                                <option value="">Semua Unit</option>
                                                @foreach ($units as $u)
                                                    <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>{{ $u->nama_unit }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="form-group">
                                             <select name="kelompok" class="form-select">
                                                <option value="">Semua Kelompok</option>
                                                <option value="A" {{ Request('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A</option>
                                                <option value="B" {{ Request('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B</option>
                                                <option value="C" {{ Request('kelompok') == 'C' ? 'selected' : '' }}>Kelompok C</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary"><i class="ti ti-filter me-1"></i> Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Mapel</th>
                                    <th>Nama Mata Pelajaran</th>
                                    <th>Kelompok</th>
                                    <th>Unit</th>
                                    <th>Urutan</th>
                                    <th>Parent</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($matapelajaran as $mp)
                                    <!-- Parent Row -->
                                    <tr class="fw-bold bg-light">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mp->kode_matpel }}</td>
                                        <td>{{ $mp->nama_matpel }}</td>
                                        <td>{{ $mp->kelompok }}</td>
                                        <td>{{ $mp->unit->nama_unit ?? '-' }}</td>
                                        <td>{{ $mp->urutan }}</td>
                                        <td>-</td>
                                        <td>
                                            @if ($mp->aktif)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Non-Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group shadow-sm" role="group">
                                                <a href="#" data-id="{{ Crypt::encrypt($mp->id) }}"
                                                    class="btn btn-sm btn-outline-warning py-1 px-2 waves-effect btnEdit">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                <form method="POST" class="d-inline"
                                                    action="{{ route('mata-pelajaran.delete', Crypt::encrypt($mp->id)) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger delete-confirm rounded-0 rounded-end py-1 px-2 waves-effect">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Children Rows -->
                                    @foreach ($mp->children as $child)
                                        <tr>
                                            <td></td>
                                            <td class="ps-4">{{ $child->kode_matpel }}</td>
                                            <td class="ps-4"><i class="ti ti-corner-down-right me-1 text-muted"></i> {{ $child->nama_matpel }}</td>
                                            <td>{{ $child->kelompok }}</td>
                                            <td>{{ $child->unit->nama_unit ?? '-' }}</td>
                                            <td>{{ $child->urutan }}</td>
                                            <td>{{ $mp->nama_matpel }}</td>
                                            <td>
                                                @if ($child->aktif)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Non-Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group shadow-sm" role="group">
                                                    <a href="#" data-id="{{ Crypt::encrypt($child->id) }}"
                                                        class="btn btn-sm btn-outline-warning py-1 px-2 waves-effect btnEdit">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                    <form method="POST" class="d-inline"
                                                        action="{{ route('mata-pelajaran.delete', Crypt::encrypt($child->id)) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger delete-confirm rounded-0 rounded-end py-1 px-2 waves-effect">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
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
        // Modal Z-Index handling
        $(document).on('show.bs.modal', '.modal', function() {
            const zIndex = 1090 + 10 * $('.modal:visible').length;
            $(this).css('z-index', zIndex);
            setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1)
                .addClass('modal-stack'));
        });

        const loading = `<div class="sk-wave sk-primary" style="margin:auto">
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
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
        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const id = $(this).data("id");
            $("#modal").modal("show");
            $("#modal").find("#loadmodal").html(loading);
            $("#modal").find(".modal-title").text("Edit Data Mata Pelajaran");
            $("#loadmodal").load(`/mata-pelajaran/${id}/edit`);
        });
    });
</script>
@endpush
