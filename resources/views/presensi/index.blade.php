@extends('layouts.app')
@section('titlepage', 'Monitoring Presensi')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-heart-rate-monitor fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Monitoring Presensi</h4>
                        <p class="text-muted mb-0 small">Monitoring kehadiran harian karyawan</p>
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
                            <li class="breadcrumb-item active text-dark fw-bold">
                                <i class="ti ti-heart-rate-monitor me-1"></i> Monitoring Presensi
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row g-3">
    <div class="col-12">
        <!-- Filter Form - Synced with Presensi Siswa -->
        <style>
            .form-filter .form-group {
                margin-bottom: 0 !important;
            }
        </style>
        <div class="card mb-4 shadow-none border-0 bg-transparent px-0">
            <div class="card-body p-0">
                <form action="{{ route('presensi.index') }}" class="form-filter">
                    <div class="row g-2 align-items-center">
                        <div class="col-lg-3 col-md-3">
                            <x-input-with-icon label="" value="{{ Request('tanggal') }}" name="tanggal"
                                icon="ti ti-calendar" datepicker="flatpickr-date" placeholder="Pilih Tanggal" />
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <x-select label="" name="kode_unit" :data="$unit" key="kode_unit"
                                    textShow="nama_unit" selected="{{ Request('kode_unit') }}" upperCase="true"
                                    select2="select2Kodeunit" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <x-input-with-icon label="" value="{{ Request('nama_karyawan') }}"
                                name="nama_karyawan" icon="ti ti-search" placeholder="Cari Nama Karyawan..." />
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <button type="submit" class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b; height: 38px;">
                                <i class="ti ti-search fs-5"></i>
                                <span>Cari Data</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Iconic Modern List -->
        <div class="presensi-modern-container">
            <style>
                .modern-card {
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    border: 1px solid rgba(6, 78, 59, 0.2) !important;
                    border-radius: 8px;
                    background: #fff;
                }
                .modern-card:hover {
                    box-shadow: 0 4px 12px rgba(6, 78, 59, 0.1) !important;
                    transform: translateX(4px);
                    background-color: #f8faf9;
                    border-color: #064e3b !important;
                }
                .avatar-initial-modern {
                    width: 42px;
                    height: 42px;
                    background: #f0f7f4;
                    color: #064e3b;
                    border-radius: 6px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: 800;
                    font-size: 1.1rem;
                    flex-shrink: 0;
                }
                .info-item {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    color: #4b5563;
                    font-size: 0.75rem;
                }
                .info-item i { 
                    font-size: 1rem;
                    color: #064e3b90;
                }
                .status-pill {
                    padding: 4px 12px;
                    border-radius: 30px;
                    font-weight: 800;
                    font-size: 0.65rem;
                    letter-spacing: 0.8px;
                }
                .presence-time {
                    padding: 4px 10px;
                    border-radius: 10px;
                    background: #f8fafc;
                    border: 1px solid #e2e8f0;
                    font-weight: 700;
                    font-size: 0.75rem;
                    transition: all 0.2s;
                }
                .presence-time:hover {
                    background: #fff;
                    border-color: #064e3b50;
                }
            </style>

            @forelse ($karyawan as $d)
                @php
                    $tanggal_presensi = Request('tanggal') ?? date('Y-m-d');
                    $jam_masuk_ref = $tanggal_presensi . ' ' . $d->jam_masuk;
                    $terlambat = hitungjamterlambat($d->jam_in, $jam_masuk_ref);
                    
                    $statusConfig = [
                        'h' => ['bg' => 'rgba(40, 199, 111, 0.12)', 'color' => '#28c76f', 'label' => 'HADIR'],
                        'i' => ['bg' => 'rgba(0, 207, 232, 0.12)', 'color' => '#00cfe8', 'label' => 'IZIN'],
                        's' => ['bg' => 'rgba(255, 159, 67, 0.12)', 'color' => '#ff9f43', 'label' => 'SAKIT'],
                        'a' => ['bg' => 'rgba(234, 84, 85, 0.12)', 'color' => '#ea5455', 'label' => 'ALPA'],
                    ];
                    $status = isset($statusConfig[$d->status]) ? $statusConfig[$d->status] : ['bg' => '#f1f5f9', 'color' => '#64748b', 'label' => 'BELUM ABSEN'];
                @endphp
                <div class="card modern-card shadow-none mb-1">
                    <div class="card-body p-3">
                        <div class="row align-items-center g-3">
                            <!-- Left: Identity -->
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-initial-modern me-3 shadow-sm border">
                                        {{ substr($d->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div class="overflow-hidden">
                                        <h6 class="mb-1 fw-bolder text-dark text-truncate small" style="letter-spacing: -0.1px">{{ $d->nama_lengkap }}</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="status-pill shadow-xs" style="background: {{ $status['bg'] }}; color: {{ $status['color'] }}">{{ $status['label'] }}</span>
                                            <div class="info-item fw-bold" style="font-size: 0.7rem">
                                                <i class="ti ti-id-badge"></i> {{ $d->npp }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Center Left: Work Profile -->
                            <div class="col-lg-2 col-md-4 col-12 border-start-lg ps-lg-4">
                                <div class="d-flex flex-column gap-2">
                                    <div class="info-item">
                                        <i class="ti ti-briefcase"></i>
                                        <span class="text-dark fw-bold text-truncate">{{ $d->nama_jabatan }}</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="ti ti-building"></i>
                                        <span class="text-muted text-truncate">{{ $d->nama_unit }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Center Right: Timing -->
                            <div class="col-lg-4 col-md-4 col-12 border-start-lg ps-lg-4">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="d-flex flex-column gap-2">
                                        <div class="icon-group">
                                            <i class="ti ti-clock-play"></i>
                                            <span class="text-muted fw-bold">Waktu Scan:</span>
                                        </div>
                                        <div class="d-flex gap-2">
                                            @if($d->jam_in)
                                                <a href="#" class="presence-time text-success btnShowpresensi_in" id="{{ $d->id }}" status="in">
                                                    <i class="ti ti-login-2 me-1"></i> <span class="fw-black">IN: {{ date('H:i', strtotime($d->jam_in)) }}</span>
                                                </a>
                                            @else
                                                <span class="presence-time text-muted opacity-50"><i class="ti ti-login-2"></i> IN: --:--</span>
                                            @endif

                                            @if($d->jam_out)
                                                <a href="#" class="presence-time text-danger btnShowpresensi_in" id="{{ $d->id }}" status="out">
                                                    <i class="ti ti-logout-2 me-1"></i> <span class="fw-black">OUT: {{ date('H:i', strtotime($d->jam_out)) }}</span>
                                                </a>
                                            @else
                                                <span class="presence-time text-muted opacity-50"><i class="ti ti-logout-2"></i> OUT: --:--</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="v-divider d-none d-lg-block"></div>
                                    
                                    <div class="d-none d-lg-block">
                                        @if($d->jam_in)
                                            <div class="text-muted extra-small mb-1">RECORD</div>
                                            <div class="fw-bold small text-dark d-flex align-items-center gap-1">
                                                <i class="ti ti-fingerprint fs-5 text-primary"></i> {{ date('H:i', strtotime($d->jam_in)) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Statistics & Actions -->
                            <div class="col-lg-3 col-md-12 text-end ms-auto border-start-lg ps-lg-4">
                                <div class="d-flex align-items-center justify-content-end gap-3">
                                    <div class="text-end d-none d-sm-block me-2">
                                        @if($terlambat != null && $terlambat['menitterlambat'] > 0)
                                            <div class="icon-group justify-content-end mb-1" style="font-size: 0.6rem; letter-spacing: 1px;">
                                                <i class="ti ti-clock-exclamation text-danger"></i> <span class="fw-black text-danger">LATE</span>
                                            </div>
                                            <div class="fw-bolder fs-5 text-danger">
                                                {{ $terlambat['menitterlambat'] }} <span style="font-size: 0.7rem">MENIT</span>
                                            </div>
                                        @elseif($d->jam_in)
                                            <div class="icon-group justify-content-end mb-1" style="font-size: 0.6rem; letter-spacing: 1px;">
                                                <i class="ti ti-circle-check text-success"></i> <span class="fw-black text-success">ON TIME</span>
                                            </div>
                                            <div class="fw-bolder fs-5 text-success">
                                                0 <span style="font-size: 0.7rem">MENIT</span>
                                            </div>
                                        @else
                                             <div class="text-muted opacity-25 fw-bold" style="font-size: 0.7rem">NO RECORD</div>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-icon btn-label-success koreksiPresensi shadow-xs border-0" 
                                            npp="{{ Crypt::encrypt($d->npp) }}" tanggal="{{ Request('tanggal') ?? date('Y-m-d') }}" title="Koreksi" style="width: 38px; height: 38px; border-radius: 14px;">
                                            <i class="ti ti-edit-circle fs-4"></i>
                                        </button>
                                        <button class="btn btn-icon btn-label-primary btngetDatamesin shadow-xs border-0" 
                                            pin="{{ $d->pin }}" tanggal="{{ Request('tanggal') ?? date('Y-m-d') }}" title="Data Mesin" style="width: 38px; height: 38px; border-radius: 14px;">
                                            <i class="ti ti-device-desktop-analytics fs-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center p-5 bg-white shadow-sm" style="border-radius: 25px;">
                    <img src="{{ asset('assets/img/illustrations/empty.png') }}" width="120" alt="Empty" class="mb-3 opacity-25">
                    <h5 class="text-muted fw-bold">Data Tidak Ditemukan</h5>
                    <p class="text-muted small mb-0">Sesuaikan tanggal atau pencarian Anda.</p>
                </div>
            @endforelse
        </div>

        <!-- Modern Pagination -->
        <div class="mt-4 d-flex justify-content-between align-items-center bg-white p-3 shadow-sm" style="border-radius: 18px;">
            <div class="text-muted small fw-bold">
                 Total Data: <span class="text-dark">{{ $karyawan->total() }}</span>
            </div>
            <div class="pagination-modern">{{ $karyawan->links() }}</div>
        </div>
    </div>
</div>


<x-modal-form id="modal" size="modal-xl" show="loadmodal" title="" />
@endsection
@push('myscript')
<script>
    $(document).on('click', '.koreksiPresensi', function(e) {
        e.preventDefault();
        let npp = $(this).attr('npp');
        let tanggal = $(this).attr('tanggal');
        $.ajax({
            type: 'POST',
            url: "{{ route('presensi.edit') }}",
            data: {
                _token: "{{ csrf_token() }}",
                npp: npp,
                tanggal: tanggal
            },
            cache: false,
            success: function(res) {
                $('#modal').modal('show');
                $('#modal').find('.modal-title').text('Koreksi Presensi');
                $('#loadmodal').html(res);
            }
        });
    });
    $(".btnShowpresensi_in, .btnShowpresensi_out").click(function(e) {
        e.preventDefault();
        const id = $(this).attr("id");
        const status = $(this).attr("status");
        $("#loadmodal").html(`<div class="sk-wave sk-primary" style="margin:auto">
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
      </div>`);
        //alert(kode_jadwal);
        $("#modal").modal("show");
        $(".modal-title").text("Data Presensi");
        $("#loadmodal").load(`/presensi/${id}/${status}/show`);
    });

    $(".btngetDatamesin").click(function(e) {
        e.preventDefault();
        var pin = $(this).attr("pin");
        var tanggal = $(this).attr("tanggal");
        // var kode_jadwal = $(this).attr("kode_jadwal");
        $("#loadmodal").html(`<div class="sk-wave sk-primary" style="margin:auto">
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
        </div>`);
        //alert(kode_jadwal);
        $("#modal").modal("show");
        $(".modal-title").text("Get Data Mesin");
        $.ajax({
            type: 'POST',
            url: '/presensi/getdatamesin',
            data: {
                _token: "{{ csrf_token() }}",
                pin: pin,
                tanggal: tanggal,
                // kode_jadwal: kode_jadwal
            },
            cache: false,
            success: function(respond) {
                console.log(respond);
                $("#loadmodal").html(respond);
            }
        });
    });
</script>
@endpush
{{-- @push('myscript')
<script>
    $(function() {
        $(document).on('click', '.koreksiPresensi', function() {
            let nik = $(this).attr('nik');
            let tanggal = $(this).attr('tanggal');
            $.ajax({
                type: 'POST',
                url: "{{ route('presensi.edit') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    nik: nik,
                    tanggal: tanggal
                },
                cache: false,
                success: function(res) {
                    $('#modal').modal('show');
                    $('#modal').find('.modal-title').text('Koreksi Presensi');
                    $('#loadmodal').html(res);
                }
            });
        });


        $(document).on('click', '.btnShow', function() {
            let nik = $(this).attr('nik');
            let tanggal = $(this).attr('tanggal');
            $.ajax({
                type: 'POST',
                url: "{{ route('presensi.show') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    nik: nik,
                    tanggal: tanggal
                },
                cache: false,
                success: function(res) {
                    $('#modal').modal('show');
                    $('#modal').find('.modal-title').text('Detail Presensi');
                    $('#loadmodal').html(res);
                }
            });
        });
    });
</script>
@endpush --}}
