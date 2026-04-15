@extends('layouts.app')
@section('titlepage', 'Tahun Ajaran & Semester')

@section('content')
@section('navigasi')
    <span class="text-muted fw-light">Konfigurasi /</span> Tahun Ajaran & Semester
@endsection

<div class="row g-4 match-height">
    <!-- Tahun Ajaran Column -->
    <div class="col-xl-7 col-lg-6 col-md-12">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center py-3" style="background-color: #104e30; color: white;">
                <div>
                    <h5 class="card-title mb-0 text-white fw-bold"><i class="ti ti-calendar-stats me-2"></i>Tahun Ajaran</h5>
                    <small class="text-white-50">Manajemen periode tahun akademik</small>
                </div>
                @can('tahunajaran.create')
                    <button class="btn btn-sm btn-white text-success fw-bold waves-effect shadow-sm" id="btnCreate">
                        <i class="ti ti-plus me-1"></i> Baru
                    </button>
                @endcan
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr style="background-color: #104e30;">
                                <th class="ps-4 border-0 text-uppercase small fw-bold text-white py-3" style="width: 60px;">No.</th>
                                <th class="border-0 text-uppercase small fw-bold text-white py-3">Kode</th>
                                <th class="border-0 text-uppercase small fw-bold text-white py-3">Tahun Ajaran</th>
                                <th class="border-0 text-uppercase small fw-bold text-white text-center py-3">Status</th>
                                <th class="border-0 text-uppercase small fw-bold text-white text-end pe-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach ($tahun_ajaran as $d)
                                <tr class="{{ $d->status == '1' ? 'bg-light-success' : '' }}">
                                    <td class="ps-4 py-3">
                                        <span class="text-muted small">{{ $loop->iteration }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-label-secondary border-0 px-2 py-1 text-uppercase fw-medium">{{ $d->kode_ta }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-dark">{{ $d->tahun_ajaran }}</span>
                                    </td>
                                    <td class="text-center py-3">
                                        @if ($d->status == '1')
                                            <span class="badge bg-success shadow-none rounded-pill px-3">
                                                <i class="ti ti-check-check me-1"></i>Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-label-danger shadow-none rounded-pill px-3">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4 py-3">
                                        <div class="btn-group shadow-sm" role="group">
                                            @can('tahunajaran.edit')
                                                <a href="#" class="btn btn-sm btn-outline-warning py-1 px-2 waves-effect btnEdit" 
                                                    kode_ta="{{ Crypt::encrypt($d->kode_ta) }}" data-bs-toggle="tooltip" title="Edit Data">
                                                    <i class="ti ti-edit fs-5"></i>
                                                </a>
                                            @endcan

                                            @can('tahunajaran.delete')
                                                <form method="POST" action="{{ route('tahunajaran.delete', Crypt::encrypt($d->kode_ta)) }}" class="deleteform d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger delete-confirm rounded-0 rounded-end py-1 px-2 waves-effect" data-bs-toggle="tooltip" title="Hapus Data">
                                                        <i class="ti ti-trash fs-5"></i>
                                                    </button>
                                                </form>
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

    <!-- Semester Column -->
    <div class="col-xl-5 col-lg-6 col-md-12">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header py-3" style="background-color: #104e30; color: white;">
                <h5 class="card-title mb-0 text-white fw-bold"><i class="ti ti-adjustments-horizontal me-2"></i>Semester Aktif</h5>
                <small class="text-white-50">Tentukan semester yang sedang berjalan</small>
            </div>
            <div class="card-body py-4">
                <div class="d-flex flex-column gap-4">
                    @foreach ($semester as $s)
                        @php
                            $isActive = $s->status == '1';
                            $label = $s->semester == 1 ? 'Ganjil' : 'Genap';
                            $icon = $s->semester == 1 ? 'ti-sun-filled' : 'ti-moon-filled';
                            $activeClass = $isActive ? 'active-semester' : 'inactive-semester';
                        @endphp
                        <div class="semester-card {{ $activeClass }} p-4 rounded-4 border transition-all position-relative shadow-sm">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="semester-icon d-flex align-items-center justify-content-center rounded-3 {{ $isActive ? 'bg-success text-white' : 'bg-light text-muted' }}" 
                                        style="width: 56px; height: 56px;">
                                        <i class="ti {{ $icon }} fs-2"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 fw-black text-dark">Semester {{ $label }}</h5>
                                        <p class="mb-0 text-muted small">
                                            {{ $isActive ? 'Pilihan semester saat ini' : 'Klik tombol samping untuk berpindah' }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    @if ($isActive)
                                        <div class="text-success d-flex align-items-center fw-bold gap-1 bg-light-success px-3 py-2 rounded-pill">
                                            <i class="ti ti-circle-check-filled fs-5"></i> <span>AKTIF</span>
                                        </div>
                                    @else
                                        <a href="{{ route('tahunajaran.setsemester', $s->id) }}" 
                                            class="btn btn-primary rounded-pill px-4 shadow-sm waves-effect btn-sm">
                                            <i class="ti ti-rotate-clockwise me-1"></i> Ganti
                                        </a>
                                    @endif
                                </div>
                            </div>
                            
                            @if($isActive)
                                <div class="active-indicator"></div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 p-4 rounded-4 bg-label-info border-info border border-dashed text-center">
                    <div class="avatar bg-info rounded-pill mx-auto mb-3" style="width: 48px; height: 48px;">
                        <i class="ti ti-info-circle text-white fs-3 font-weight-bold"></i>
                    </div>
                    <h6 class="text-info fw-bold mb-2">Pemberitahuan Penting</h6>
                    <p class="mb-0 small text-dark" style="line-height: 1.6;">
                        Pengaturan semester aktif akan merubah seluruh data default pada modul <b>Penilaian</b>, <b>Jadwal</b>, dan <b>Rapor</b>. 
                        Pastikan data tahun ajaran juga disesuaikan dengan benar.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="modal" size="" show="loadmodal" title="" />

<style>
    .match-height { display: flex; flex-wrap: wrap; }
    .bg-light-success { background-color: rgba(16, 78, 48, 0.04); }
    .btn-text-success:hover { background-color: rgba(40, 199, 111, 0.1); }
    .btn-text-danger:hover { background-color: rgba(234, 84, 85, 0.1); }
    .transition-all { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    
    .semester-card {
        border-width: 2px !important;
        background: #fff;
    }
    
    .active-semester {
        border-color: #104e30 !important;
        background: rgba(16, 78, 48, 0.02) !important;
    }
    
    .inactive-semester {
        border-color: #eee !important;
    }
    
    .semester-card:hover:not(.active-semester) {
        border-color: #ced4da !important;
        transform: translateY(-3px);
    }
    
    .active-indicator {
        position: absolute;
        top: -2px;
        right: 40px;
        width: 30px;
        height: 10px;
        background: #104e30;
        border-radius: 0 0 10px 10px;
    }
    
    .fw-black { font-weight: 800; }
    .bg-light-success { color: #104e30; background: rgba(16, 78, 48, 0.08); }
</style>

@endsection

@push('myscript')
<script>
    $(function() {
        // Equal height helper
        if($('.match-height').length) {
            $('.match-height').each(function() {
                var card = $(this).find('.card');
                card.height('auto');
                var maxHeight = 0;
                card.each(function() {
                    if($(this).height() > maxHeight) {
                        maxHeight = $(this).height();
                    }
                });
                card.height(maxHeight);
            });
        }

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

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
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus data tahun ajaran ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#104e30',
                cancelButtonColor: '#ea5455',
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