@extends('layouts.app')
@section('titlepage', 'Dashboard')
@section('content')
    <style>
        /* Seamless & Cardless Executive Header */
        .dash-page-header {
            padding: 0.25rem 0 1.25rem 0;
            margin-bottom: 0.5rem;
        }

        .dash-page-header .welcome-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.02em;
            line-height: 1.25;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dash-page-header .welcome-meta {
            font-size: 0.84rem;
            color: #64748b;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.35rem;
        }

        .dash-page-header .meta-divider {
            color: #cbd5e1;
        }

        .dash-page-header .badge-role {
            font-size: 0.74rem;
            font-weight: 600;
            color: #047857;
            background: #ecfdf5;
            border: 1px solid #d1fae5;
            padding: 0.15rem 0.55rem;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .dash-page-header .clock-date {
            font-size: 0.76rem;
            font-weight: 500;
            color: #64748b;
            margin-bottom: 0.1rem;
        }

        .dash-page-header .clock-time {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            font-variant-numeric: tabular-nums;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        /* Filter Toolbar Card */
        .dash-filter-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            padding: 0.9rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .dash-filter-card .icon-badge {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: #f8fafc;
            color: #0f172a;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
        }

        .dash-filter-card .custom-select-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #1e293b;
            transition: all 0.2s ease;
        }
        .dash-filter-card .custom-select-box:focus {
            background: #ffffff;
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
        }

        .btn-dash-refresh {
            background: #0f172a;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 0.42rem 0.9rem;
            font-weight: 600;
            font-size: 0.82rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s ease;
        }
        .btn-dash-refresh:hover {
            background: #1e293b;
            color: #ffffff;
        }
    </style>

    {{-- CARDLESS SEAMLESS WELCOME HEADER --}}
    <div class="dash-page-header">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h4 class="welcome-title mb-0">
                        <i class="ti ti-user-circle text-muted fs-3"></i>
                        <span>Selamat Datang, {{ auth()->user()->name }}</span>
                    </h4>
                    <span class="badge-role">
                        <i class="ti ti-shield-check fs-6"></i>
                        {{ auth()->user()->getRoleNames()->first() ?? 'Admin Unit' }}
                    </span>
                </div>
                <div class="welcome-meta">
                    <span>{{ auth()->user()->unit->nama_unit ?? ($pengaturan->nama_sekolah ?? 'Pesantren Persatuan Islam 80 Al Amin') }}</span>
                    <span class="meta-divider">&bull;</span>
                    <span>Monitoring Administrasi & Kesiapan Unit</span>
                </div>
            </div>

            <div class="text-md-end d-none d-md-block">
                <div class="clock-date" id="currentDate"></div>
                <div class="clock-time" id="currentTime"></div>
            </div>
        </div>
    </div>

    {{-- FILTER TOOLBAR --}}
    <div class="dash-filter-card">
        <div class="row align-items-center g-3">
            <div class="col-12 col-md-6">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-badge">
                        <i class="ti ti-chart-dots-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold" style="color: #0f172a; font-size: 0.98rem; letter-spacing: -0.2px;">Monitoring Kesiapan Unit</h6>
                        <span style="font-size: 0.78rem; color: #64748b;">Status kurikulum, jadwal pelajaran, data santri & rombel</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                    <div class="input-group input-group-merge" style="width: auto; min-width: 175px;">
                        <span class="input-group-text" style="background-color: #f8fafc; border-color: #e2e8f0;"><i class="ti ti-calendar-event text-primary"></i></span>
                        <select id="filter_kode_ta" class="form-select form-select-sm custom-select-box" style="border-radius: 0 8px 8px 0;">
                            @foreach ($tahunajaran as $ta)
                                <option value="{{ $ta->kode_ta }}" {{ ($activeTa && $activeTa->kode_ta == $ta->kode_ta) ? 'selected' : '' }}>
                                    TA {{ $ta->tahun_ajaran }} {{ $ta->status == '1' ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" id="filter_kode_unit" value="{{ auth()->user()->kode_unit }}">

                    <button type="button" class="btn btn-dash-refresh" id="btnRefreshReport" title="Segarkan Data Kesiapan">
                        <i class="ti ti-refresh fs-6"></i> <span>Refresh</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTAINER AJAX REPORT KELENGKAPAN --}}
    <div id="loadReportKelengkapan" class="mb-4">
        <div class="card p-5 text-center border-0 shadow-sm" style="border-radius: 1.1rem;">
            <div class="spinner-border text-success mx-auto mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
            <h6 class="fw-bold text-dark mb-1">Memuat Rekap Kelengkapan Data...</h6>
            <small class="text-muted">Menghitung kelengkapan mata pelajaran, jadwal, santri & kelas</small>
        </div>
    </div>

    {{-- MODAL DRILL-DOWN REPORT --}}
    <div class="modal fade" id="modalDetailReport" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-2xl rounded-2xl overflow-hidden" id="modalDetailReportContent">
                <div class="p-8 text-center bg-white">
                    <div class="w-10 h-10 border-3 border-orange-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                    <p class="text-xs font-bold text-slate-700">Memuat Detail Data...</p>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT DATA SISWA (IN-PLACE DARI REPORT) --}}
    <x-modal-form id="modalEditSiswa" size="modal-lg" show="loadmodaleditsiswa" title="Edit Data Siswa" icon="ti ti-user-edit" />
    <x-modal-form id="modalSekolah" size="" show="loadmodal" title="" icon="ti ti-school" />

@endsection

@push('myscript')
    <script>
        $(function() {
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

            updateDateTime();
            setInterval(updateDateTime, 1000);

            // AJAX REPORT KELENGKAPAN
            function getReportKelengkapan() {
                let kode_ta = $('#filter_kode_ta').val();
                let kode_unit = $('#filter_kode_unit').val();

                $("#loadReportKelengkapan").html(`
                    <div class="card p-5 text-center border-0 shadow-sm" style="border-radius: 1.1rem;">
                        <div class="spinner-border text-success mx-auto mb-3" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                        <h6 class="fw-bold text-dark mb-1">Memperbarui Rekap Kelengkapan Data...</h6>
                        <small class="text-muted">Tahun Ajaran: ${$('#filter_kode_ta option:selected').text()}</small>
                    </div>
                `);

                $.ajax({
                    method: "POST",
                    url: "{{ route('dashboard.getReportKelengkapan') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_ta: kode_ta,
                        kode_unit: kode_unit
                    },
                    cache: false,
                    success: function(response) {
                        $('#loadReportKelengkapan').html(response);
                    },
                    error: function() {
                        $('#loadReportKelengkapan').html(`
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="ti ti-alert-circle fs-3 me-2"></i>
                                <div>
                                    <strong>Gagal memuat data report.</strong> Silakan refresh halaman atau hubungi administrator.
                                </div>
                            </div>
                        `);
                    }
                });
            }

            $('#filter_kode_ta').on('change', function() {
                getReportKelengkapan();
            });

            $('#btnRefreshReport').on('click', function() {
                getReportKelengkapan();
            });

            getReportKelengkapan();

            // MODAL DRILL-DOWNS
            $(document).on('click', '.btn-view-santri-belum-lengkap', function() {
                let kode_unit = $(this).data('kode-unit') || $('#filter_kode_unit').val();
                let kode_ta = $('#filter_kode_ta').val();

                $('#modalDetailReportContent').html(`
                    <div class="p-8 text-center bg-white">
                        <div class="w-10 h-10 border-3 border-amber-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                        <div class="text-xs font-bold text-slate-800">Memuat Data Santri Belum Lengkap...</div>
                    </div>
                `);
                $('#modalDetailReport').modal('show');

                $.ajax({
                    method: "POST",
                    url: "{{ route('dashboard.getDetailSantriBelumLengkap') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_unit: kode_unit,
                        kode_ta: kode_ta
                    },
                    success: function(html) {
                        $('#modalDetailReportContent').html(html);
                    }
                });
            });

            $(document).on('click', '.btn-view-santri-belum-plot', function() {
                let kode_unit = $(this).data('kode-unit') || $('#filter_kode_unit').val();
                let kode_ta = $('#filter_kode_ta').val();

                $('#modalDetailReportContent').html(`
                    <div class="p-8 text-center bg-white">
                        <div class="w-10 h-10 border-3 border-indigo-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                        <div class="text-xs font-bold text-slate-800">Memuat Data Santri Belum Masuk Rombel...</div>
                    </div>
                `);
                $('#modalDetailReport').modal('show');

                $.ajax({
                    method: "POST",
                    url: "{{ route('dashboard.getDetailSantriBelumPlot') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_unit: kode_unit,
                        kode_ta: kode_ta
                    },
                    success: function(html) {
                        $('#modalDetailReportContent').html(html);
                    }
                });
            });

            $(document).on('click', '.btn-view-jadwal', function() {
                let kode_unit = $(this).data('kode-unit') || $('#filter_kode_unit').val();
                let kode_ta = $('#filter_kode_ta').val();

                $('#modalDetailReportContent').html(`
                    <div class="p-8 text-center bg-white">
                        <div class="w-10 h-10 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                        <div class="text-xs font-bold text-slate-800">Memuat Data Jadwal Kelas...</div>
                    </div>
                `);
                $('#modalDetailReport').modal('show');

                $.ajax({
                    method: "POST",
                    url: "{{ route('dashboard.getDetailJadwalKelas') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_unit: kode_unit,
                        kode_ta: kode_ta
                    },
                    success: function(html) {
                        $('#modalDetailReportContent').html(html);
                    }
                });
            });

            // Modal Edit Santri In-Place (Konsep Menu Akademik)
            $(document).on('click', '.btn-edit-siswa-modal', function(e) {
                e.preventDefault();
                let no_pendaftaran = $(this).data('no-pendaftaran');
                $('#modalEditSiswa').modal('show');
                $('#modalEditSiswa').find('.modal-title').text('Edit Pendaftaran & Data Siswa');
                $('#loadmodaleditsiswa').html(`
                    <div class="p-5 text-center">
                        <div class="spinner-border text-success mb-2" role="status"></div>
                        <div class="text-muted fw-semibold">Memuat Formulir Pendaftaran Siswa...</div>
                    </div>
                `);
                $('#loadmodaleditsiswa').load(`/pendaftaran/${no_pendaftaran}/edit`);
            });
        });
    </script>
@endpush
