@extends('layouts.app')
@section('titlepage', 'Dashboard')
@section('content')
    <style>
        .welcome-banner {
            background: #ffffff;
            border-radius: 1.25rem;
            padding: 1.35rem 1.75rem;
            margin-bottom: 1.25rem;
            border: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .welcome-banner .avatar {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            object-fit: cover;
            border: 1px solid #e2e8f0;
        }

        .welcome-banner .welcome {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 0.15rem;
            color: #0f172a;
            letter-spacing: -0.3px;
        }

        .welcome-banner .desc {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .welcome-banner .info-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .welcome-banner .info-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 0.2rem 0.65rem;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #334155;
        }

        .welcome-banner .datetime-info {
            text-align: right;
            flex-shrink: 0;
            background: #f8fafc;
            padding: 0.65rem 1rem;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
        }

        .welcome-banner .current-date {
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 500;
        }

        .welcome-banner .current-time {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0f172a;
            font-variant-numeric: tabular-nums;
        }

        @media (max-width: 768px) {
            .welcome-banner {
                padding: 1.25rem;
                flex-direction: column;
                text-align: center;
            }
            .welcome-banner .datetime-info {
                display: none;
            }
            .welcome-banner .info-badges {
                justify-content: center;
            }
        }
    </style>

    {{-- HEADER BANNER --}}
    <div class="welcome-banner">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <img src="{{ asset(auth()->user()->avatar ? 'storage/avatars/' . auth()->user()->avatar : 'assets/img/avatars/1.png') }}"
                class="avatar" alt="Avatar">
            <div>
                <div class="welcome">Selamat Datang, {{ auth()->user()->name }}</div>
                <div class="desc">Kelola administrasi, jadwal, data santri & rombel unit Anda dengan efisien.</div>
                <div class="info-badges">
                    <div class="info-badge">
                        <i class="ti ti-shield-check text-success"></i>
                        <span>{{ auth()->user()->getRoleNames()->first() ?? 'Admin Unit' }}</span>
                    </div>
                    @if (!empty(auth()->user()->unit))
                        <div class="info-badge">
                            <i class="ti ti-building text-primary"></i>
                            <span>{{ auth()->user()->unit->nama_unit ?? auth()->user()->kode_unit }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="datetime-info d-none d-md-block">
            <div class="current-date" id="currentDate"></div>
            <div class="current-time" id="currentTime"></div>
        </div>
    </div>

    {{-- FILTER TOOLBAR --}}
    <div class="card mb-4 border-0" style="border-radius: 1.25rem; border: 1px solid #e9ecef !important; background: #ffffff; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);">
        <div class="card-body p-3 px-4">
            <div class="row align-items-center g-3">
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar avatar-md rounded-3 d-flex align-items-center justify-content-center" style="background-color: #0f172a; color: #ffffff;">
                            <i class="ti ti-layout-dashboard fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold" style="color: #0f172a; font-size: 1rem;">Monitoring Kesiapan Unit</h6>
                            <span style="font-size: 0.78rem; color: #64748b;">Status kurikulum, jadwal pelajaran, data santri & rombel</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                        <div class="input-group input-group-merge" style="width: auto; min-width: 175px;">
                            <span class="input-group-text" style="background-color: #f8fafc; border-color: #e2e8f0;"><i class="ti ti-calendar-event text-primary"></i></span>
                            <select id="filter_kode_ta" class="form-select form-select-sm fw-semibold" style="border-color: #e2e8f0; color: #0f172a; border-radius: 0 8px 8px 0;">
                                @foreach ($tahunajaran as $ta)
                                    <option value="{{ $ta->kode_ta }}" {{ ($activeTa && $activeTa->kode_ta == $ta->kode_ta) ? 'selected' : '' }}>
                                        TA {{ $ta->tahun_ajaran }} {{ $ta->status == '1' ? '(Aktif)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="filter_kode_unit" value="{{ auth()->user()->kode_unit }}">
                        <button type="button" class="btn btn-sm btn-dark d-flex align-items-center gap-1.5 fw-semibold" id="btnRefreshReport" style="border-radius: 8px; padding: 0.45rem 0.9rem;" title="Refresh Data">
                            <i class="ti ti-refresh fs-6"></i> <span>Refresh</span>
                        </button>
                    </div>
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
            <div class="modal-content border-0 shadow" id="modalDetailReportContent" style="border-radius: 1.25rem; overflow: hidden;">
                <div class="modal-body text-center p-5">
                    <div class="spinner-border text-success mx-auto mb-3" role="status"></div>
                    <div class="fw-bold text-dark">Memuat Detail...</div>
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
            // Modal stacking z-index handler agar backdrop modal kedua (misal: modal edit) berada di atas modal pertama
            $(document).on('show.bs.modal', '.modal', function() {
                const zIndex = 1090 + 10 * $('.modal:visible').length;
                $(this).css('z-index', zIndex);
                setTimeout(() => {
                    $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
                }, 0);
            });

            $(document).on('hidden.bs.modal', '.modal', function() {
                if ($('.modal:visible').length) {
                    $('body').addClass('modal-open');
                }
            });

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
                    <div class="modal-body text-center p-5">
                        <div class="spinner-border text-warning mx-auto mb-3" role="status"></div>
                        <div class="fw-bold text-dark">Memuat Data Santri Belum Lengkap...</div>
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
                    <div class="modal-body text-center p-5">
                        <div class="spinner-border text-primary mx-auto mb-3" role="status"></div>
                        <div class="fw-bold text-dark">Memuat Data Santri Belum Masuk Rombel...</div>
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
                    <div class="modal-body text-center p-5">
                        <div class="spinner-border text-success mx-auto mb-3" role="status"></div>
                        <div class="fw-bold text-dark">Memuat Data Jadwal Kelas...</div>
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
