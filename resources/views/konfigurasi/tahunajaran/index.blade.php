@extends('layouts.app')
@section('titlepage', 'Tahun Ajaran & Semester')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-calendar-event fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Tahun Ajaran & Semester</h4>
                        <p class="text-muted mb-0 small">Manajemen periode akademik dan status semester aktif</p>
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
                                <i class="ti ti-calendar-event me-1"></i> Tahun Ajaran
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row g-4">
    <!-- Tahun Ajaran Column -->
    <div class="col-xl-7 col-lg-7 col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center py-3" style="background-color: #064e3b">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-calendar-stats text-white fs-5"></i>
                    <h6 class="card-title mb-0 text-white">Data Tahun Ajaran</h6>
                </div>
                @can('tahunajaran.create')
                    <button class="btn btn-sm btn-white text-dark fw-bold shadow-sm" id="btnCreate" style="background: white; border: none;">
                        <i class="ti ti-plus me-1"></i> Tambah Baru
                    </button>
                @endcan
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3 text-center" style="width: 1%;">NO.</th>
                                <th class="text-white py-3">KODE</th>
                                <th class="text-white py-3">TAHUN AJARAN</th>
                                <th class="text-white py-3 text-center">STATUS</th>
                                <th class="text-white py-3 text-end" style="width: 100px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tahun_ajaran as $d)
                                <tr class="{{ $d->status == '1' ? 'bg-label-success' : '' }}">
                                    <td class="py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2"><span class="badge bg-label-secondary small">{{ $d->kode_ta }}</span></td>
                                    <td class="py-2 fw-bold text-dark">{{ $d->tahun_ajaran }}</td>
                                    <td class="py-2 text-center">
                                        @if ($d->status == '1')
                                            <span class="badge bg-success rounded-pill px-3">
                                                <i class="ti ti-check me-1"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-label-danger rounded-pill px-3">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1 px-3">
                                            @can('tahunajaran.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit" 
                                                    style="width: 28px; height: 28px;" kode_ta="{{ Crypt::encrypt($d->kode_ta) }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('tahunajaran.delete')
                                                <form method="POST" action="{{ route('tahunajaran.delete', Crypt::encrypt($d->kode_ta)) }}" class="deleteform">
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
                                            <i class="ti ti-calendar-off fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data</h5>
                                        <p class="text-muted">Silahkan tambah tahun ajaran baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Semester Column -->
    <div class="col-xl-5 col-lg-5 col-md-12">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header py-3" style="background-color: #064e3b">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-adjustments-horizontal text-white fs-5"></i>
                    <h6 class="card-title mb-0 text-white">Konfigurasi Semester Aktif</h6>
                </div>
            </div>
            <div class="card-body pt-4">
                <div class="d-flex flex-column gap-3">
                    @foreach ($semester as $s)
                        @php
                            $isActive = $s->status == '1';
                            $label = $s->semester == 1 ? 'Ganjil' : 'Genap';
                            $icon = $s->semester == 1 ? 'ti-sun' : 'ti-moon';
                        @endphp
                        <div class="semester-card p-4 rounded-3 border-2 {{ $isActive ? 'active-border' : 'inactive-border' }} transition-all shadow-sm">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar avatar-md {{ $isActive ? 'bg-success text-white' : 'bg-label-secondary' }} rounded-3 shadow-sm">
                                        <i class="ti {{ $icon }} fs-2"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold text-dark">Semester {{ $label }}</h5>
                                        <p class="mb-0 text-muted small">Periode {{ $label }}</p>
                                    </div>
                                </div>
                                <div>
                                    @if ($isActive)
                                        <div class="badge bg-success shadow-sm rounded-pill px-3 py-2">
                                            <i class="ti ti-circle-check me-1"></i> AKTIF
                                        </div>
                                    @else
                                        <a href="{{ route('tahunajaran.setsemester', $s->id) }}" 
                                            class="btn btn-sm btn-primary rounded-pill px-4 shadow-sm"
                                            style="background-color: #064e3b; border-color: #064e3b">
                                            <i class="ti ti-rotate-clockwise me-1"></i> Aktifkan
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 p-3 rounded-3 bg-label-info border border-info border-dashed text-center">
                    <div class="avatar bg-info rounded-circle mx-auto mb-2" style="width: 40px; height: 40px;">
                        <i class="ti ti-info-circle text-white fs-4"></i>
                    </div>
                    <h6 class="text-info fw-bold mb-1">Informasi Penting</h6>
                    <p class="mb-0 small text-dark opacity-75">
                        Perubahan semester aktif akan berdampak pada seluruh modul penilaian, jadwal pelajaran, dan pelaporan raport.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="modal" size="" show="loadmodal" title="" />

<style>
    .transition-all { transition: all 0.3s ease; }
    .active-border { border: 2px solid #064e3b !important; background: rgba(6, 78, 59, 0.05); }
    .inactive-border { border: 2px solid #e0e0e0 !important; background: #fff; }
    .semester-card:hover:not(.active-border) { border-color: #064e3b !important; transform: translateY(-2px); }
    .bg-label-success { background-color: rgba(6, 78, 59, 0.08) !important; color: #064e3b !important; }
</style>

@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#modal').modal("show");
            $(".modal-title").text("Tambah Tahun Ajaran");
            $("#loadmodal").load("{{ route('tahunajaran.create') }}");
        });

        $(".btnEdit").click(function(e) {
            e.preventDefault();
            const kode_ta = $(this).attr('kode_ta')
            $('#modal').modal("show");
            $(".modal-title").text("Edit Tahun Ajaran");
            $("#loadmodal").load(`/tahunajaran/${kode_ta}/edit`);
        });

        $(".delete-confirm").click(function(e) {
            var form = $(this).closest("form");
            e.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data tahun ajaran ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    });
</script>
@endpush