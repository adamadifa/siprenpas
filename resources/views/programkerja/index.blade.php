@extends('layouts.app')
@section('titlepage', 'Program Kerja')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-4">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e6f4ea; color: #064e3b">
                        <i class="ti ti-notebook fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-extrabold" style="color: #064e3b; letter-spacing: -0.5px;">Program Kerja</h4>
                        <p class="text-muted mb-0 small">Manajemen program kerja tahun ajaran <span class="badge bg-label-success fw-bold">{{ $ta_aktif->tahun_ajaran }}</span></p>
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
                            <li class="breadcrumb-item active fw-medium" style="color: #064e3b">
                                <i class="ti ti-notebook me-1"></i> Program Kerja
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .form-filter .form-group {
        margin-bottom: 0 !important;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <!-- Actions & Info Header -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div class="d-flex align-items-center gap-2">
                @can('agendakegiatan.create')
                    <button class="btn d-flex align-items-center gap-2 shadow-sm text-white px-4 py-2-5 rounded-3 border-0 transition-all" id="btncreateProgramKerja"
                        style="background: linear-gradient(135deg, #064e3b 0%, #0b6e54 100%);">
                        <i class="ti ti-plus fs-5"></i>
                        <span class="fw-semibold">Tambah Program Kerja</span>
                    </button>
                @endcan

                @if(auth()->check() && auth()->user()->hasRole('super admin'))
                    <form method="POST" action="{{ route('programkerja.reset') }}" class="d-inline-block m-0" id="formResetProgramKerja">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger d-flex align-items-center gap-2 shadow-sm btn-reset-confirm px-4 py-2-5 rounded-3 border-0 transition-all">
                            <i class="ti ti-rotate fs-5"></i>
                            <span class="fw-semibold">Reset Program Kerja</span>
                        </button>
                    </form>
                @endif
            </div>
            <div class="text-muted small">
                Total: <span class="fw-bold text-dark">{{ count($programkerja) }}</span> Program Kerja Terdaftar
            </div>
        </div>

        <!-- Filter Form Card (Consistent with /akademik/siswa) -->
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('programkerja.index') }}" id="myForm" class="form-filter">
                    <div class="row g-3 align-items-center">
                        @if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris']))
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="input-group border rounded-2 shadow-sm bg-white" style="border-color: #e0e0e0 !important;">
                                        <span class="input-group-text bg-white border-0 border-end" style="border-color: #e0e0e0 !important; color: #8e9ba5; padding-right: 12px; padding-left: 12px;"><i class="ti ti-hierarchy-2 fs-5"></i></span>
                                        <select name="kode_dept" id="kode_dept" class="form-select border-0 ps-2 bg-transparent" style="box-shadow: none;">
                                            <option value="">Semua Departemen</option>
                                            @foreach ($departemen as $d)
                                                <option value="{{ $d->kode_dept }}" {{ Request('kode_dept') == $d->kode_dept ? 'selected' : '' }}>
                                                    {{ strtoUpper($d->nama_dept) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                                <div class="input-group border rounded-2 shadow-sm bg-white" style="border-color: #e0e0e0 !important;">
                                    <span class="input-group-text bg-white border-0 border-end" style="border-color: #e0e0e0 !important; color: #8e9ba5; padding-right: 12px; padding-left: 12px;"><i class="ti ti-calendar fs-5"></i></span>
                                    <select name="kode_ta" id="kode_ta" class="form-select border-0 ps-2 bg-transparent" style="box-shadow: none;">
                                        @foreach ($tahunajaran as $d)
                                            <option value="{{ $d->kode_ta }}"
                                                {{ Request('kode_ta') == $d->kode_ta || $ta_aktif->kode_ta == $d->kode_ta ? 'selected' : '' }}>
                                                {{ $d->tahun_ajaran }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-{{ $user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris']) ? '5' : '8' }} col-md-6">
                            <x-input-with-icon label="" value="{{ Request('programkerja_search') }}" name="programkerja_search"
                                placeholder="Cari program kerja..." icon="ti ti-search" />
                        </div>
                        <div class="col-lg-1 col-md-12">
                            <div class="d-flex gap-2">
                                <button type="submit" name="cari" value="1" class="btn btn-primary shadow-sm p-2 d-flex align-items-center justify-content-center flex-grow-1 gap-2" style="background-color: #064e3b; border-color: #064e3b; height: 38px;">
                                    <i class="ti ti-search fs-5"></i>
                                </button>
                                <button type="submit" name="cetak" value="1" id="cetakButton" class="btn btn-warning shadow-sm p-2 d-flex align-items-center justify-content-center gap-2" style="height: 38px;">
                                    <i class="ti ti-printer fs-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Card -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-header d-flex align-items-center justify-content-between py-3-5 px-4 bg-white border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-label-success p-2 rounded-2">
                        <i class="ti ti-table text-success fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Data Program Kerja</h5>
                        <p class="text-muted mb-0 small">Daftar agenda dan target pencapaian unit</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-center py-3 text-white font-weight-bold" style="width: 60px;">NO.</th>
                                <th class="py-3 text-white font-weight-bold" style="min-width: 250px;">PROGRAM KERJA</th>
                                <th class="py-3 text-white font-weight-bold" style="min-width: 380px;">TARGET PENCAPAIAN</th>
                                <th class="py-3 text-white font-weight-bold text-center" style="width: 120px;">DEPARTEMEN</th>
                                <th class="py-3 text-white font-weight-bold text-end pe-4" style="width: 110px;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($programkerja as $d)
                                <tr class="transition-all hover-bg-light">
                                    <td class="text-center fw-semibold text-muted py-3">{{ $loop->iteration }}</td>
                                    <td class="py-3">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark fs-6">{{ $d->program_kerja }}</span>
                                            @if(!empty($d->keterangan))
                                                <span class="text-muted small mt-1"><i class="ti ti-info-circle me-1 small"></i>{{ removeHtmltag($d->keterangan) }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="border-start border-2 border-success ps-3 py-1 bg-light/30 rounded-end text-secondary small leading-relaxed">
                                            {!! $d->target_pencapaian !!}
                                        </div>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge rounded-pill bg-label-success px-2-5 py-1-5 fw-semibold">{{ $d->kode_dept }}</span>
                                    </td>
                                    <td class="py-3 text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            @can('programkerja.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border-0 shadow-sm btnEdit rounded-3"
                                                    style="width: 32px; height: 32px;"
                                                    id="{{ Crypt::encrypt($d->kode_program_kerja) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Program Kerja">
                                                    <i class="ti ti-edit fs-5"></i>
                                                </a>
                                            @endcan
                                            @can('agendakegiatan.delete')
                                                <form method="POST" name="deleteform" class="deleteform m-0"
                                                    action="{{ route('programkerja.delete', Crypt::encrypt($d->kode_program_kerja)) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-label-danger border-0 shadow-sm delete-confirm rounded-3"
                                                        style="width: 32px; height: 32px;"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Program Kerja">
                                                        <i class="ti ti-trash fs-5"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-5 bg-white">
                                        @if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris']) && empty(Request('kode_dept')))
                                            <div class="mb-3 text-muted">
                                                <i class="ti ti-filter fs-1 opacity-50 text-success"></i>
                                            </div>
                                            <h5 class="fw-bold text-dark">Pilih Departemen Terlebih Dahulu</h5>
                                            <p class="text-muted small">Silakan pilih departemen pada filter di atas untuk melihat data program kerja.</p>
                                        @else
                                            <div class="mb-3 text-muted">
                                                <i class="ti ti-notebook-off fs-1 opacity-50 text-success"></i>
                                            </div>
                                            <h5 class="fw-bold text-dark">Belum Ada Program Kerja</h5>
                                            <p class="text-muted small">Silahkan tambah program kerja baru atau sesuaikan filter pencarian.</p>
                                        @endif
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
<script>
    document.getElementById('cetakButton').addEventListener('click', function(e) {
        e.preventDefault();
        const form = document.getElementById('myForm');
        const formData = new FormData(form);
        const url = "{{ URL::current() }}";
        const printUrl = url + '?' + new URLSearchParams(formData).toString() + '&cetak=1';
        window.open(printUrl, '_blank');
    });
</script>
<script>
    $(function() {
        // Initialize Tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

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

        $(document).on('click', '.btn-reset-confirm', function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            Swal.fire({
                title: `Apakah Anda Yakin Ingin Mereset Semua Program Kerja ?`,
                text: "Semua data program kerja akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Reset Semua!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

