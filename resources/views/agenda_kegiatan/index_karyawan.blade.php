@extends('layouts.app')
@section('titlepage', 'Agenda Kegiatan Saya')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-4">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e6f4ea; color: #064e3b">
                        <i class="ti ti-calendar-event fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-extrabold" style="color: #064e3b; letter-spacing: -0.5px;">Agenda Kegiatan Saya</h4>
                        <p class="text-muted mb-0 small">Monitoring dan perencanaan agenda kegiatan kerja Anda</p>
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
                                <i class="ti ti-calendar-event me-1"></i> Agenda Kegiatan Saya
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    @media (min-width: 768px) {
        .border-end-md {
            border-right: 1px solid #eef2f6 !important;
        }
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .card-agenda {
        transition: all 0.2s ease-in-out;
    }
    .card-agenda:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.08) !important;
    }
</style>

<div class="row">
    <div class="col-lg-12">

        <!-- Employee Profile Summary Card -->
        @if(!empty($karyawan))
            <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden text-white" style="background: linear-gradient(135deg, #064e3b 0%, #043e2f 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center g-4">
                        <div class="col-auto">
                            <div class="avatar avatar-xl bg-white rounded-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                <i class="ti ti-user-check fs-2" style="color: #064e3b;"></i>
                            </div>
                        </div>
                        <div class="col-md">
                            <h4 class="fw-bold mb-1 text-white">{{ $karyawan->nama_lengkap }}</h4>
                            <p class="text-white-50 mb-0 small">NPP: <span class="fw-semibold text-white">{{ $karyawan->npp }}</span></p>
                        </div>
                        <div class="col-md-auto ms-md-auto">
                            <div class="d-flex flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-briefcase text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Jabatan</span>
                                        <span class="fw-bold text-white" style="font-size: 0.8rem; letter-spacing: 0.2px;">{{ strtoupper($karyawan->nama_jabatan) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-hierarchy-2 text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Departemen</span>
                                        <span class="fw-bold text-white" style="font-size: 0.8rem; letter-spacing: 0.2px;">{{ strtoupper($karyawan->nama_dept) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-building text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Unit Kerja</span>
                                        <span class="fw-bold text-white" style="font-size: 0.8rem; letter-spacing: 0.2px;">{{ strtoupper($karyawan->nama_unit) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Action & Filter Section -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white px-4" id="btncreateAgendaKegiatan"
                    style="background-color: #064e3b; border-radius: 8px; height: 38px;">
                    <i class="ti ti-plus fs-5"></i>
                    <span class="fw-semibold">Tambah Agenda Kegiatan</span>
                </button>
            </div>
            
            <div class="flex-grow-1 flex-md-grow-0">
                <form action="{{ route('agendakegiatan.index') }}" class="form-filter" id="myForm">
                    <div class="row g-2 align-items-center justify-content-md-end">
                        <div class="col-lg-4 col-md-4 col-6">
                            <x-input-with-icon label="" placeholder="Dari Tanggal" name="dari" id="dari" value="{{ Request('dari') }}" datepicker="flatpickr-date" icon="ti ti-calendar" />
                        </div>
                        <div class="col-lg-4 col-md-4 col-6">
                            <x-input-with-icon label="" placeholder="Sampai Tanggal" name="sampai" id="sampai" value="{{ Request('sampai') }}" datepicker="flatpickr-date" icon="ti ti-calendar" />
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="d-flex gap-2 align-items-center" style="height: 38px;">
                                <button type="submit" class="btn btn-success shadow-sm d-flex align-items-center justify-content-center flex-grow-1"
                                    style="background-color: #064e3b; border-color: #064e3b; height: 38px; border-radius: 8px;">
                                    <i class="ti ti-search fs-5 me-1"></i> Cari
                                </button>
                                <button type="submit" name="cetak" value="1" id="cetakButton" class="btn btn-warning shadow-sm border-0 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; border-radius: 8px;">
                                    <i class="ti ti-printer fs-5 text-white"></i>
                                </button>
                                <button type="submit" name="cetak_pdf" value="1" id="cetakPdfButton" class="btn btn-danger shadow-sm border-0 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; border-radius: 8px;">
                                    <i class="ti ti-file-text fs-5 text-white"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Agenda Cards Stack -->
        <div class="d-flex flex-column gap-3 mb-4">
            @forelse ($agenda_kegiatan as $d)
                <div class="card border-0 border-start border-success border-4 shadow-sm card-agenda">
                    <div class="card-body p-3">
                        <div class="row align-items-center g-3">
                            <!-- Left Column: Date -->
                            <div class="col-12 col-md-3 border-end-md">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small fw-medium mb-1"><i class="ti ti-calendar me-1 text-success"></i>Tanggal</span>
                                    <span class="fw-bold text-dark mb-1">{{ date('d-m-Y', strtotime($d->tanggal)) }}</span>
                                    <span class="text-muted small fw-medium mb-1"><i class="ti ti-clock me-1 text-success"></i>Waktu</span>
                                    <span class="text-dark small">{{ date('H:i', strtotime($d->created_at)) }}</span>
                                </div>
                            </div>
                            
                            <!-- Middle Column: Kegiatan & Uraian -->
                            <div class="col-12 col-md-6 border-end-md">
                                <div class="pe-md-3">
                                    <span class="badge bg-label-success mb-2">Agenda</span>
                                    <h6 class="fw-bold text-dark mb-1">{{ strip_tags($d->nama_kegiatan) }}</h6>
                                    <p class="text-muted small mb-0 text-truncate-2">
                                        {{ strip_tags($d->uraian_kegiatan) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Right Column: Actions -->
                            <div class="col-12 col-md-3">
                                <div class="d-flex justify-content-md-end gap-2 align-items-center">
                                    <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                        style="width: 38px; height: 38px;"
                                        id="{{ Crypt::encrypt($d->id) }}"
                                        data-bs-toggle="tooltip" title="Edit">
                                        <i class="ti ti-edit fs-5"></i>
                                    </a>
                                    <form method="POST" name="deleteform" class="deleteform m-0"
                                        action="{{ route('agendakegiatan.delete', Crypt::encrypt($d->id)) }}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                            style="width: 38px; height: 38px;"
                                            data-bs-toggle="tooltip" title="Hapus">
                                            <i class="ti ti-trash fs-5"></i>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="mb-3">
                            <i class="ti ti-calendar-event fs-1 text-muted opacity-50"></i>
                        </div>
                        <h5 class="fw-bold">Belum Ada Agenda Kegiatan</h5>
                        <p class="text-muted mb-0">Silakan tambahkan agenda rencana kegiatan baru Anda dengan menekan tombol Tambah Agenda.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-end">
            {{ $agenda_kegiatan->links() }}
        </div>

    </div>
</div>

<x-modal-form id="mdlAgendaKegiatan" size="" show="loadAgendaKegiatan" title="" />
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btncreateAgendaKegiatan").click(function(e) {
            e.preventDefault();
            $('#mdlAgendaKegiatan').modal("show");
            $("#mdlAgendaKegiatan").find(".modal-title").text("Tambah Agenda Kegiatan");
            $("#loadAgendaKegiatan").load('/agendakegiatan/create');
        });

        $(".btnEdit").click(function(e) {
            var id = $(this).attr("id");
            e.preventDefault();
            $('#mdlAgendaKegiatan').modal("show");
            $("#mdlAgendaKegiatan").find(".modal-title").text("Edit Agenda Kegiatan");
            $("#loadAgendaKegiatan").load('/agendakegiatan/' + id + '/edit');
        });

        $('#cetakButton, #cetakPdfButton').click(function(e) {
            const dari = $('#dari').val();
            const sampai = $('#sampai').val();

            if (dari == '' || sampai == '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal tidak boleh kosong!',
                    didClose: (e) => {
                        $('#dari').focus();
                    }
                });
                return false;
            }
        });
    });
</script>
@endpush
