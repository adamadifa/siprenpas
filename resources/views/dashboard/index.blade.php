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
            background: linear-gradient(135deg, #144725 0%, #1a5e31 100%);
            border-radius: 1.25rem;
            padding: 2.5rem;
            margin-bottom: 2rem;
            color: #fff;
            box-shadow: 0 10px 30px 0 rgba(20, 71, 37, 0.2);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dashboard-header:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px 0 rgba(20, 71, 37, 0.3);
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 1;
        }

        .dashboard-header::after {
            content: '';
            position: absolute;
            bottom: -15%;
            left: -5%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 152, 0, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 1;
        }

        .dashboard-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .dashboard-header .avatar-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .dashboard-header .avatar {
            width: 90px;
            height: 90px;
            border-radius: 24px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.2);
            padding: 4px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .dashboard-header:hover .avatar {
            transform: rotate(3deg) scale(1.05);
            border-color: rgba(255, 152, 0, 0.5);
        }

        .dashboard-header .avatar-status {
            position: absolute;
            bottom: -5px;
            right: -5px;
            width: 24px;
            height: 24px;
            background: #4caf50;
            border: 4px solid #144725;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .dashboard-header .welcome-content {
            flex: 1;
        }

        .dashboard-header .welcome-greeting {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dashboard-header .welcome {
            font-size: 2.25rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
            color: #fff;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .dashboard-header .desc {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1.5rem;
            font-weight: 400;
            max-width: 500px;
        }

        .dashboard-header .info-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .dashboard-header .info-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            padding: 0.6rem 1.25rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.9);
        }

        .dashboard-header .info-badge:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .dashboard-header .info-badge i {
            font-size: 1.1rem;
            color: #ff9800;
        }

        .dashboard-header .datetime-info {
            text-align: right;
            flex-shrink: 0;
            background: rgba(0, 0, 0, 0.15);
            padding: 1.25rem;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .dashboard-header .current-date {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 0.4rem;
            font-weight: 500;
            font-variant-numeric: tabular-nums;
        }

        .dashboard-header .current-time {
            font-size: 1.75rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
            font-family: 'Inter', system-ui, sans-serif;
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

        @media (max-width: 768px) {
            .dashboard-header {
                padding: 1.5rem;
            }

            .dashboard-header-content {
                flex-direction: column;
                text-align: center;
            }

            .dashboard-header .avatar {
                width: 70px;
                height: 70px;
            }

            .dashboard-header .welcome {
                font-size: 1.5rem;
            }

            .dashboard-header .desc {
                font-size: 0.9rem;
            }

            .dashboard-header .info-badges {
                justify-content: center;
            }

            .dashboard-header .datetime-info {
                text-align: center;
                margin-top: 1rem;
            }

            .dashboard-header .current-time {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .dashboard-header {
                padding: 1.2rem;
            }

            .dashboard-header .avatar {
                width: 60px;
                height: 60px;
            }

            .dashboard-header .welcome {
                font-size: 1.3rem;
            }

            .dashboard-header .info-badge {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
        }
    </style>

    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <div class="avatar-wrapper">
                <img src="{{ asset(auth()->user()->avatar ? 'storage/avatars/' . auth()->user()->avatar : 'assets/img/avatars/1.png') }}" class="avatar"
                    alt="Avatar">
                <span class="avatar-status"></span>
            </div>
            <div class="welcome-content">
                <div class="welcome-greeting">
                    @php
                        $hour = date('H');
                        $greeting = 'Selamat ';
                        if ($hour >= 5 && $hour < 11) {
                            $greeting .= 'Pagi';
                            $icon = 'ti-sun';
                        } elseif ($hour >= 11 && $hour < 15) {
                            $greeting .= 'Siang';
                            $icon = 'ti-sun';
                        } elseif ($hour >= 15 && $hour < 18) {
                            $greeting .= 'Sore';
                            $icon = 'ti-cloud-sun';
                        } else {
                            $greeting .= 'Malam';
                            $icon = 'ti-moon';
                        }
                    @endphp
                    <i class="ti {{ $icon }} me-1"></i> {{ $greeting }}
                </div>
                <div class="welcome">{{ auth()->user()->name }}</div>
                <div class="desc">Selamat datang kembali! Mari kendalikan operasional pesantren dengan lebih efisien hari ini.</div>
                <div class="info-badges">
                    <div class="info-badge">
                        <i class="ti ti-shield-check"></i>
                        <span>{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</span>
                    </div>
                    @if ($pengaturan)
                        <div class="info-badge">
                            <i class="ti ti-building-community"></i>
                            <span>{{ $pengaturan->nama_sekolah }}</span>
                        </div>
                    @endif
                    <div class="info-badge">
                        <i class="ti ti-calendar-event"></i>
                        <span>{{ date('Y') }} / {{ date('Y') + 1 }}</span>
                    </div>
                </div>
            </div>
            <div class="datetime-info d-none d-md-block">
                <div class="current-date" id="currentDate"></div>
                <div class="current-time" id="currentTime"></div>
            </div>
        </div>
    </div>



@endsection
@push('myscript')
    <script>
        $(function() {
            // Update waktu dan tanggal
            function updateDateTime() {
                const now = new Date();
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];

                const dayName = days[now.getDay()];
                const day = now.getDate();
                const month = months[now.getMonth()];
                const year = now.getFullYear();

                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');

                $('#currentDate').text(`${dayName}, ${day} ${month} ${year}`);
                $('#currentTime').text(`${hours}:${minutes}:${seconds}`);
            }

            // Update setiap detik
            updateDateTime();
            setInterval(updateDateTime, 1000);

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
