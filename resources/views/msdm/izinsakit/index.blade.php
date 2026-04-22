@extends('layouts.app')
@section('titlepage', 'Izin Sakit')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-first-aid-kit fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Izin Sakit</h4>
                        <p class="text-muted mb-0 small">Manajemen pengajuan izin sakit karyawan</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-database me-1"></i> MSDM
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-dark fw-bold">
                                <i class="ti ti-first-aid-kit me-1"></i> Izin Sakit
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('action_button')
    @can('izinsakit.create')
        <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" id="btnCreate"
            style="background-color: #064e3b; border-color: #064e3b; border-radius: 10px;">
            <i class="ti ti-plus fs-4"></i>
            <span>Tambah Data</span>
        </button>
    @endcan
@endsection
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="nav-align-top mb-4">
            @include('layouts.navigation.nav_pengajuan_absen')
            <div class="tab-content p-0 bg-transparent shadow-none border-0">
                <div class="tab-pane fade active show" id="navs-justified-home" role="tabpanel">
                    <div class="row mt-1 mb-1">
                        <div class="col-12">
                            <form action="{{ route('izinsakit.index') }}" class="form-filter">
                                <!-- Row 1: Date Period -->
                                <!-- Row 1: Date Period -->
                                <div class="row g-2 mb-0">
                                    <div class="col-lg-6 col-md-6 mb-1">
                                        <x-input-with-icon label="" value="{{ Request('dari') }}" name="dari"
                                            icon="ti ti-calendar" datepicker="flatpickr-date" placeholder="Dari Tanggal" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 mb-1">
                                        <x-input-with-icon label="" value="{{ Request('sampai') }}" name="sampai"
                                            icon="ti ti-calendar" datepicker="flatpickr-date" placeholder="Sampai Tanggal" />
                                    </div>
                                </div>
                                <!-- Row 2: Categories, Name & Search -->
                                <div class="row g-2 align-items-center mb-0">
                                    <div class="col-lg-3 col-md-4 mb-1">
                                        <div class="form-group mb-0">
                                            <select name="kode_unit" id="kode_unit" class="form-select">
                                                <option value=""> Unit</option>
                                                @foreach ($unit as $d)
                                                    <option value="{{ $d->kode_unit }}"
                                                        {{ Request('kode_unit') == $d->kode_unit ? 'selected' : '' }}>
                                                        {{ textUpperCase($d->nama_unit) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-1">
                                        <div class="form-group mb-0">
                                            <select name="status" id="status" class="form-select">
                                                <option value="">Status</option>
                                                <option value="0" {{ Request('status') === '0' ? 'selected' : '' }}>Pending</option>
                                                <option value="1" {{ Request('status') == '1' ? 'selected' : '' }}>Disetujui</option>
                                                <option value="2" {{ Request('status') == '2' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-10 mb-1">
                                        <x-input-with-icon label="" name="nama_lengkap"
                                            value="{{ Request('nama_lengkap') }}" icon="ti ti-user" placeholder="Nama Karyawan..." />
                                    </div>
                                    <div class="col-lg-1 col-md-2 mb-1">
                                        <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center" style="background-color: #064e3b; border-color: #064e3b; height: 38px;">
                                            <i class="ti ti-search fs-5"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="izinsakit-list">
                                @forelse ($izinsakit as $d)
                                    @php
                                        $lama = hitungHari($d->dari, $d->sampai);
                                        $statusConfig = [
                                            '0' => [
                                                'bg' => 'rgba(255, 159, 67, 0.12)',
                                                'color' => '#ff9f43',
                                                'label' => 'PENDING',
                                                'icon' => 'hourglass-high',
                                            ],
                                            '1' => [
                                                'bg' => 'rgba(40, 199, 111, 0.12)',
                                                'color' => '#28c76f',
                                                'label' => 'DISETUJUI',
                                                'icon' => 'checks',
                                            ],
                                            '2' => [
                                                'bg' => 'rgba(234, 84, 85, 0.12)',
                                                'color' => '#ea5455',
                                                'label' => 'DITOLAK',
                                                'icon' => 'square-x',
                                            ],
                                        ];
                                        $status = $statusConfig[$d->status] ?? $statusConfig['0'];
                                    @endphp
                                    <div class="card modern-card shadow-none mb-2">
                                        <div class="card-body p-3">
                                            <!-- Row 1: Identity & Actions -->
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="d-flex align-items-center gap-2 overflow-hidden">
                                                    <div class="avatar-initial-modern">
                                                        {{ substr($d->nama_lengkap, 0, 1) }}
                                                    </div>
                                                    <div class="overflow-hidden">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <h6 class="mb-0 fw-bold text-dark text-truncate"
                                                                style="font-size: 0.85rem">{{ $d->nama_lengkap }}</h6>
                                                            @if (!empty($d->doc_sid) && Storage::disk('public')->exists('/uploads/sid/' . $d->doc_sid))
                                                                <a href="{{ getSid($d->doc_sid) }}" target="_blank"
                                                                    class="badge bg-label-info p-1 py-0 rounded-pill"
                                                                    title="Lihat SID">
                                                                    <i class="ti ti-paperclip fs-6"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="text-muted extra-small fw-bold">{{ $d->npp }}</span>
                                                            <span class="status-badge"
                                                                style="background: {{ $status['bg'] }}; color: {{ $status['color'] }}">
                                                                <i class="ti ti-{{ $status['icon'] }} me-1"
                                                                    style="font-size: 0.7rem"></i>{{ $status['label'] }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 ms-2">
                                                    @can('izinsakit.approve')
                                                        @if ($d->status == 0)
                                                            <button class="btn btn-icon btn-sm btn-label-primary btnApprove border-0"
                                                                kode_izin="{{ Crypt::encrypt($d->kode_izin_sakit) }}"
                                                                style="width: 28px; height: 28px;">
                                                                <i class="ti ti-check fs-5"></i>
                                                            </button>
                                                        @elseif($d->status == 1)
                                                            <form method="POST" name="deleteform" class="deleteform m-0"
                                                                action="{{ route('izinsakit.cancelapprove', Crypt::encrypt($d->kode_izin_sakit)) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-icon btn-sm btn-label-danger cancel-confirm border-0"
                                                                    style="width: 28px; height: 28px;">
                                                                    <i class="ti ti-rotate-clockwise fs-5"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endcan

                                                    <button class="btn btn-icon btn-sm btn-label-info btnShow border-0"
                                                        kode_izin="{{ Crypt::encrypt($d->kode_izin_sakit) }}"
                                                        style="width: 28px; height: 28px;">
                                                        <i class="ti ti-file-text fs-5"></i>
                                                    </button>

                                                    @can('izinsakit.edit')
                                                        @if ($d->status == 0)
                                                            <button class="btn btn-icon btn-sm btn-label-success btnEdit border-0"
                                                                kode_izin="{{ Crypt::encrypt($d->kode_izin_sakit) }}"
                                                                style="width: 28px; height: 28px;">
                                                                <i class="ti ti-edit fs-5"></i>
                                                            </button>
                                                        @endif
                                                    @endcan

                                                    @can('izinsakit.delete')
                                                        @if ($d->status == 0)
                                                            <form method="POST" name="deleteform" class="deleteform m-0"
                                                                action="{{ route('izinsakit.delete', Crypt::encrypt($d->kode_izin_sakit)) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-icon btn-sm btn-label-danger delete-confirm border-0"
                                                                    style="width: 28px; height: 28px;">
                                                                    <i class="ti ti-trash fs-5"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endcan
                                                </div>
                                            </div>

                                            <div class="border-top pt-2 mt-2">
                                                <div class="row g-2">
                                                    <div class="col-7">
                                                        <div class="compact-label">Tanggal Pengajuan</div>
                                                        <div class="compact-value text-primary">
                                                            <i class="ti ti-calendar-event me-1"></i>
                                                            {{ date('d/m/y', strtotime($d->dari)) }} -
                                                            {{ date('d/m/y', strtotime($d->sampai)) }}
                                                            <span class="badge bg-label-info ms-1"
                                                                style="font-size: 0.6rem">{{ $lama }} Hari</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-5 text-end">
                                                        <div class="compact-label">Unit & Jabatan</div>
                                                        <div class="compact-value text-muted text-truncate"
                                                            title="{{ $d->nama_unit }} / {{ $d->nama_jabatan }}">
                                                            {{ $d->nama_unit }} / {{ $d->nama_jabatan }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="card shadow-none border-0 text-center p-5 mt-4"
                                        style="background: #f8fafc; border-radius: 20px;">
                                        <img src="{{ asset('assets/img/illustrations/empty.png') }}" width="120"
                                            alt="Empty" class="mb-3 mx-auto opacity-50">
                                        <h5 class="text-muted fw-bold">Belum Ada Pengajuan Izin Sakit</h5>
                                    </div>
                                @endforelse
                            </div>
                            <div class="mt-3">
                                {{ $izinsakit->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="modal" size="" show="loadmodal" title="" />
@endsection
@push('myscript')
<script>
    $(function() {
        function loading() {
            $("#loadmodal").html(
                `<div class="sk-wave sk-primary" style="margin:auto">
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            </div>`
            );
        }
        $("#btnCreate").click(function() {
            $("#modal").modal("show");
            loading();
            $("#modal").find(".modal-title").text("Buat Izin Sakit");
            $("#loadmodal").load("/izinsakit/create");
        });

        $(".btnApprove").click(function() {
            const kode_izin = $(this).attr("kode_izin");
            $("#modal").modal("show");
            loading();
            $("#modal").find(".modal-title").text("Approve Izin Sakit");
            $("#loadmodal").load(`/izinsakit/${kode_izin}/approve`);
        });

        $(".btnShow").click(function() {
            const kode_izin = $(this).attr("kode_izin");
            $("#modal").modal("show");
            loading();
            $("#modal").find(".modal-title").text("Detail Izin Sakit");
            $("#loadmodal").load(`/izinsakit/${kode_izin}/show`);
        });

        $(".btnEdit").click(function() {
            const kode_izin = $(this).attr("kode_izin");
            $("#modal").modal("show");
            loading();
            $("#modal").find(".modal-title").text("Edit Izin Sakit");
            $("#loadmodal").load(`/izinsakit/${kode_izin}/edit`);
        });
    });
</script>
@endpush
