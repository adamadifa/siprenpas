@extends('layouts.app')
@section('titlepage', 'Program Kerja')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-notebook fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Program Kerja</h4>
                        <p class="text-muted mb-0 small">Manajemen program kerja tahun ajaran {{ $ta_aktif->tahun_ajaran }}</p>
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
                                <i class="ti ti-notebook me-1"></i> Program Kerja
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
            @can('agendakegiatan.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateProgramKerja"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Program Kerja</span>
                </button>
            @endcan
        </div>

        <!-- Filter Form -->
        <div class="card shadow-none border mb-4">
            <div class="card-body p-3">
                <form action="{{ route('programkerja.index') }}" id="myForm">
                    <div class="row g-2">
                        @if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris']))
                            <div class="col-lg-3 col-md-6">
                                <select name="kode_jabatan" id="kode_jabatan" class="form-select select2">
                                    <option value="">Semua Jabatan</option>
                                    @foreach ($jabatan as $d)
                                        <option value="{{ $d->kode_jabatan }}"
                                            {{ Request('kode_jabatan') == $d->kode_jabatan ? 'selected' : '' }}>
                                            {{ strtoUpper($d->nama_jabatan) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <select name="kode_dept" id="kode_dept" class="form-select select2">
                                    <option value="">Semua Departemen</option>
                                    @foreach ($departemen as $d)
                                        <option value="{{ $d->kode_dept }}" {{ Request('kode_dept') == $d->kode_dept ? 'selected' : '' }}>
                                            {{ strtoUpper($d->nama_dept) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-lg-2 col-md-6">
                            <select name="kode_ta" id="kode_ta" class="form-select select2">
                                @foreach ($tahunajaran as $d)
                                    <option value="{{ $d->kode_ta }}"
                                        {{ Request('kode_ta') == $d->kode_ta || $ta_aktif->kode_ta == $d->kode_ta ? 'selected' : '' }}>
                                        {{ $d->tahun_ajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-{{ $user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris']) ? '3' : '9' }} col-md-6">
                            <div class="input-group input-group-merge border rounded-2">
                                <span class="input-group-text bg-white border-0"><i class="ti ti-search text-muted"></i></span>
                                <input type="text" name="programkerja_search" class="form-control bg-white border-0 ps-2"
                                    placeholder="Cari Program Kerja..." value="{{ Request('programkerja_search') }}">
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-12">
                            <div class="d-flex gap-2 h-100">
                                <button type="submit" name="cari" value="1" class="btn shadow-none flex-grow-1 text-white px-3"
                                    style="background-color: #064e3b">
                                    <i class="ti ti-search fs-5"></i>
                                </button>
                                <button type="submit" name="cetak" value="1" id="cetakButton" class="btn btn-warning shadow-none px-3">
                                    <i class="ti ti-printer fs-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-notebook fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Program Kerja</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 1%;">NO.</th>
                                <th class="text-white py-3">PROGRAM KERJA</th>
                                <th class="text-white py-3">TARGET PENCAPAIAN</th>
                                <th class="text-white py-3" style="width: 1%;">DEPT</th>
                                <th class="text-white py-3 text-end" style="width: 80px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($programkerja as $d)
                                <tr>
                                    <td class="py-2">{{ $loop->iteration }}</td>
                                    <td class="py-2 fw-bold text-dark">{{ $d->program_kerja }}</td>
                                    <td class="py-2 small text-muted" style="min-width: 250px;">{{ removeHtmltag($d->target_pencapaian) }}</td>
                                    <td class="py-2 text-center">
                                        <span class="badge bg-label-success">{{ $d->kode_dept }}</span>
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('programkerja.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                    style="width: 28px; height: 28px;"
                                                    id="{{ Crypt::encrypt($d->kode_program_kerja) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('agendakegiatan.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('programkerja.delete', Crypt::encrypt($d->kode_program_kerja)) }}">
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
                                    <td colspan="5" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-notebook fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Program Kerja</h5>
                                        <p class="text-muted">Silahkan tambah program kerja baru atau sesuaikan filter pencarian.</p>
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

<x-modal-form id="mdlProgramkerja" size="" show="loadProgramkerja" title="" />

@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    document.getElementById('cetakButton').addEventListener('click', function(e) {
        e.preventDefault();
        // Ambil data form
        const form = document.getElementById('myForm');
        const formData = new FormData(form);
        const url = "{{ URL::current() }}";
        // URL tujuan untuk cetak
        const printUrl = url + '?' + new URLSearchParams(formData).toString() + '&cetak=1';

        // Buka tab baru untuk cetak
        window.open(printUrl, '_blank');
    });
</script>
<script>
    $(function() {
        $("#btncreateProgramKerja").click(function(e) {
            e.preventDefault();
            $('#mdlProgramkerja').modal("show");
            $("#mdlProgramkerja").find(".modal-title").text("Tambah Program Kerja {{ $ta_aktif->tahun_ajaran }}");
            $("#loadProgramkerja").load('/programkerja/create');
        });

        $(".btnEdit").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdlProgramkerja').modal("show");
            $("#mdlProgramkerja").find(".modal-title").text("Edit Program Kerja");
            $("#loadProgramkerja").load('/programkerja/' + id + '/edit');
        });


    });
</script>
@endpush
