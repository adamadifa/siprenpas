@extends('layouts.app')
@section('titlepage', 'Jam Kerja')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-clock fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Jam Kerja</h4>
                        <p class="text-muted mb-0 small">Manajemen pengaturan waktu kerja karyawan</p>
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
                                <i class="ti ti-clock me-1"></i> Jam Kerja
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="d-flex justify-content-start mb-3">
            @can('jamkerja.create')
                <a href="#" class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btnCreate"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Jam Kerja</span>
                </a>
            @endcan
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-clock-pause fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Jam Kerja</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 1%;">NO.</th>
                                <th class="text-white py-3">KODE</th>
                                <th class="text-white py-3">NAMA JAM KERJA</th>
                                <th class="text-white py-3 text-center">JAM MASUK</th>
                                <th class="text-white py-3 text-center">JAM PULANG</th>
                                <th class="text-white py-3 text-center">TOTAL JAM</th>
                                <th class="text-white py-3 text-center">LINTAS HARI</th>
                                <th class="text-white py-3 text-end" style="width: 100px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jamkerja as $d)
                                <tr>
                                    <td class="py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2 fw-bold text-muted small">{{ $d->kode_jam_kerja }}</td>
                                    <td class="py-2 fw-bold text-dark">{{ $d->nama_jam_kerja }}</td>
                                    <td class="py-2 text-center">
                                        <span class="badge bg-label-success">{{ $d->jam_masuk }}</span>
                                    </td>
                                    <td class="py-2 text-center">
                                        <span class="badge bg-label-danger">{{ $d->jam_pulang }}</span>
                                    </td>
                                    <td class="py-2 text-center fw-bold">{{ $d->total_jam }} Jam</td>
                                    <td class="py-2 text-center">
                                        @if ($d->lintas_hari == 1)
                                            <span class="badge bg-label-warning">Ya</span>
                                        @else
                                            <span class="text-muted small">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1 px-3">
                                            @can('jamkerja.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                    style="width: 28px; height: 28px;"
                                                    kode_jam_kerja="{{ Crypt::encrypt($d->kode_jam_kerja) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('jamkerja.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('jamkerja.delete', Crypt::encrypt($d->kode_jam_kerja)) }}">
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
                                    <td colspan="8" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-clock-off fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Jam Kerja</h5>
                                        <p class="text-muted">Silahkan tambah jam kerja baru untuk pengaturan presensi.</p>
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

<x-modal-form id="mdlCreate" size="" show="loadCreate" title="Buat Jam Kerja" />
<x-modal-form id="mdlEdit" size="" show="loadEdit" title="Edit Jam Kerja" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#mdlCreate').modal("show");
            $("#loadCreate").load("{{ route('jamkerja.create') }}");
        });

        $(".btnEdit").click(function(e) {
            var kode_jam_kerja = $(this).attr("kode_jam_kerja");
            e.preventDefault();
            $('#mdlEdit').modal("show");
            $("#loadEdit").load('/jamkerja/' + kode_jam_kerja + '/edit');
        });
    });
</script>
@endpush
