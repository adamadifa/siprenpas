@extends('layouts.app')
@section('titlepage', 'Dashboard')
@section('content')
    {{-- <style>
        .table-modal {
            height: auto;
            max-height: 550px;
            overflow-y: scroll;

        }
    </style> --}}
    <style>
        .detail {
            cursor: pointer;
        }

        #tab-content-main {
            box-shadow: none !important;
            background: none !important;
        }

        .dashboard-header {
            background: linear-gradient(120deg, #1B5E20 60%, #388e3c 100%);
            border-radius: 1.2rem;
            padding: 1.5rem 2rem 1.2rem 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
            box-shadow: 0 4px 16px 0 rgba(27, 94, 32, 0.10);
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .dashboard-header .avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(27, 94, 32, 0.10);
        }

        .dashboard-header .welcome {
            font-size: 1.7rem;
            font-weight: 700;
            margin-bottom: 0.1rem;
            color: #fff;
        }

        .dashboard-header .desc {
            font-size: 1rem;
            color: #b9f6ca;
            opacity: 1;
        }

        .card.h-100 {
            background: linear-gradient(120deg, #1B5E20 60%, #388e3c 100%);
            color: #fff;
            border: none;
            border-radius: 1.1rem;
            box-shadow: 0 4px 16px 0 rgba(27, 94, 32, 0.10);
            margin-bottom: 1.2rem;
        }

        .card .card-header {
            background: transparent;
            border-bottom: none;
            padding-bottom: 0.5rem;
        }

        .card .card-title {
            color: #fff;
            font-weight: 700;
        }

        .card .text-success {
            color: #b9f6ca !important;
        }

        .card .text-body,
        .card .text-muted,
        .card small,
        .card .card-text {
            color: #e0f2f1 !important;
        }

        .badge.bg-label-info,
        .badge.bg-label-primary {
            background: #e8f5e9;
            color: #1B5E20;
        }

        .progress-bar.bg-primary {
            background: #00e676 !important;
        }

        .progress-bar.bg-danger {
            background: #ff8c00 !important;
        }

        .swiper-container .card.dark-bg {
            background: #1B5E20;
            color: #fff;
            border-radius: 1.2rem;
            box-shadow: 0 4px 16px 0 rgba(27, 94, 32, 0.18);
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
            min-height: 170px;
            padding: 0;
        }

        .atm-glossy {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, rgba(255, 255, 255, 0.13) 10%, rgba(255, 255, 255, 0.03) 60%, rgba(255, 255, 255, 0.18) 100%);
            pointer-events: none;
            z-index: 2;
        }

        .atm-chip {
            width: 38px;
            height: 28px;
            border-radius: 6px;

            margin-bottom: 1.1rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .atm-chip-bar {
            width: 24px;
            height: 4px;
            background: #bdbdbd;
            border-radius: 2px;
            margin: 0 2px;
        }

        .atm-card-content {
            position: relative;
            z-index: 3;
            padding: 1.2rem 1.5rem 1rem 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .atm-card-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .atm-card-label {
            font-size: 0.85rem;
            color: #b9f6ca;
            letter-spacing: 1px;
            font-weight: 500;
        }

        .atm-card-number {
            font-size: 1.15rem;
            letter-spacing: 2px;
            font-family: 'Courier New', Courier, monospace;
            font-weight: 600;
            margin-bottom: 0.2rem;
        }

        .atm-card-balance {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            text-shadow: 0 2px 8px rgba(27, 94, 32, 0.18), 0 1px 0 #1B5E20;
        }

        .atm-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 0.7rem;
        }

        .atm-card-logo {
            width: 48px;
            height: 24px;
            object-fit: contain;
            opacity: 0.85;
        }

        .timeline .timeline-item .timeline-event {
            background: #e8f5e9;
            color: #1B5E20;
            border-radius: 0.7rem;
            box-shadow: 0 2px 8px 0 rgba(27, 94, 32, 0.08);
            margin-bottom: 0.7rem;
        }

        .timeline .timeline-item .timeline-event .text-muted,
        .timeline .timeline-item .timeline-event .small {
            color: #388e3c !important;
        }

        .nav-pills .nav-link.active {
            background: #1B5E20;
            color: #fff !important;
            font-weight: 600;
            border-radius: 2rem;
        }

        .nav-pills .nav-link {
            color: #1B5E20;
            font-weight: 500;
            margin-right: 0.5rem;
        }

        .nav-pills {
            margin-bottom: 1rem;
        }

        .tab-content {
            margin-top: 1rem;
        }

        .row,
        .col,
        .form-group,
        .timeline,
        .swiper-container {
            margin-bottom: 0.8rem;
        }

        .form-group {
            margin-bottom: 0.6rem;
        }

        .timeline .timeline-item {
            margin-bottom: 0.5rem;
        }

        .swiper-container .card.dark-bg h4,
        .swiper-container .card.dark-bg .nominal-highlight {
            color: #fff !important;
            text-shadow: 0 2px 8px rgba(27, 94, 32, 0.18), 0 1px 0 #1B5E20;
            font-weight: 700;
        }

        @media (max-width: 600px) {
            .dashboard-header {
                padding: 1rem 0.7rem 0.8rem 0.7rem;
                gap: 0.7rem;
            }

            .dashboard-header .avatar {
                width: 38px;
                height: 38px;
            }

            .dashboard-header .welcome {
                font-size: 1.1rem;
            }

            .dashboard-header .desc {
                font-size: 0.85rem;
            }
        }
    </style>

    <div class="dashboard-header">
        <img src="{{ asset(auth()->user()->avatar ? 'storage/avatars/' . auth()->user()->avatar : 'assets/img/avatars/1.png') }}" class="avatar"
            alt="Avatar">
        <div>
            <div class="welcome">Selamat Datang, {{ auth()->user()->name }}</div>
            <div class="desc">Semoga harimu menyenangkan dan produktif!</div>
            <div class="role">Role: {{ auth()->user()->getRoleNames()->first() }}</div>
            @if ($pengaturan)
                <div class="desc" style="font-size: 0.9rem; margin-top: 0.5rem;">
                    <i class="ti ti-building me-1"></i>{{ $pengaturan->nama_sekolah }}
                </div>
            @endif
        </div>
    </div>


    <div class="nav-align-top">
        <ul class="nav nav-pills nav-scrollable" role="tablist">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active waves-effect waves-light" role="tab" data-bs-toggle="tab"
                    data-bs-target="#agenda-realisasi" aria-controls="agenda-realisasi" aria-selected="true">Agenda &
                    Kegiatan</button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link  waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#jadwal-kerja"
                    aria-controls="jadwal-kerja" aria-selected="true">Jadwal Kerja
                    SDM</button>
            </li>
        </ul>
    </div>
    <div class="tab-content p-0 m-0 bg-transparent" id="tab-content-main">
        <div class="tab-pane fade show active" id="agenda-realisasi" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <div class="form-group mt-3">
                        <select name="kode_dept" id="kode_dept" class="form-select select2Kodedept">
                            <option value="">Departemen</option>
                            @foreach ($departemen as $d)
                                <option value="{{ $d->kode_dept }}">{{ strtoupper($d->nama_dept) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col">
                            <x-input-with-icon icon="ti ti-calendar" label="Tanggal" name="dari" datepicker="flatpickr-date"
                                value="{{ date('Y-m-d') }}" />
                        </div>
                        <div class="col">
                            <x-input-with-icon icon="ti ti-calendar" label="Tanggal" name="sampai" datepicker="flatpickr-date"
                                value="{{ date('Y-m-d') }}" />
                        </div>
                    </div>
                </div>

                <div class="nav-align-top">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-new"
                                aria-controls="navs-justified-new" aria-selected="true">Agenda
                                Kegiatan</button>

                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-link-preparing"
                                aria-controls="navs-justified-link-preparing" aria-selected="false" tabindex="-1">Realisasi
                                Kegiatan</button>
                        </li>
                    </ul>
                    <div class="tab-content px-2 mx-1 pb-0">
                        <div class="tab-pane fade active show" id="navs-justified-new" role="tabpanel">
                            <ul class="timeline mb-0 pb-1" id="getagendakegiatan">

                            </ul>

                        </div>

                        <div class="tab-pane fade" id="navs-justified-link-preparing" role="tabpanel">
                            <ul class="timeline mb-0 pb-1" id="getrealisasikegiatan">

                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="tab-pane fade" id="jadwal-kerja" role="tabpanel">
            <div class="row mt-2">
                <div class="col">
                    <div class="form-group">
                        @php
                            $hariini = date('Y-m-d');
                            $nama_hari = getnamaHari(date('D', strtotime($hariini)));
                        @endphp
                        <select name="hari" id="hari" class="form-select">
                            <option value="Senin" {{ $nama_hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                            <option value="Selasa" {{ $nama_hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                            <option value="Rabu" {{ $nama_hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                            <option value="Kamis" {{ $nama_hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                            <option value="Jumat" {{ $nama_hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                            <option value="Sabtu" {{ $nama_hari == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                            <option value="Minggu" {{ $nama_hari == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="unit" id="unit" class="form-select">
                            <option value="">Unit</option>
                            @foreach ($unit as $u)
                                <option value="{{ $u->kode_unit }}">{{ $u->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col" id="loadjadwalkerja">

                </div>
            </div>
        </div>
    </div>
    <x-modal-form id="modal" show="loadmodal" title="Detail Aktifitas" size="modal-lg" />
@endsection
@push('myscript')
    <script>
        $(function() {
            function getrealisasikegiatan() {
                // alert('test');
                let dari = $('#dari').val();
                let sampai = $('#sampai').val();
                let kode_dept = $('#kode_dept').val();
                $("#getrealisasikegiatan").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
                $.ajax({
                    method: "POST",
                    url: "{{ route('dashboard.getrealisasikegiatan') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        dari: dari,
                        sampai: sampai,
                        kode_dept: kode_dept
                    },
                    cache: false,
                    success: function(data) {
                        $('#getrealisasikegiatan').html(data);
                    }
                })
            }

            function getagendakegiatan() {
                // alert('test');
                let dari = $('#dari').val();
                let sampai = $('#sampai').val();
                let kode_dept = $('#kode_dept').val();
                $("#getrealisasikegiatan").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
                $.ajax({
                    method: "POST",
                    url: "{{ route('dashboard.getagendakegiatan') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        dari: dari,
                        sampai: sampai,
                        kode_dept: kode_dept
                    },
                    cache: false,
                    success: function(data) {
                        $('#getagendakegiatan').html(data);
                    }
                })
            }

            $("#kode_dept, #dari, #sampai").on('change', function() {
                getrealisasikegiatan();
                getagendakegiatan();
            });

            function getjadwalkerja() {
                let hari = $('#hari').val();
                let unit = $('#unit').val();
                $("#loadjadwalkerja").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
                $.ajax({
                    method: "POST",
                    url: "{{ route('karyawan.getjadwalkerja') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        hari: hari,
                        unit: unit

                    },
                    cache: false,
                    success: function(data) {
                        $('#loadjadwalkerja').html(data);
                    }
                })
            }

            $("#hari, #unit").on('change', function() {
                getjadwalkerja();
            });
            getjadwalkerja();
            getrealisasikegiatan();
            getagendakegiatan();
        });
    </script>
@endpush
