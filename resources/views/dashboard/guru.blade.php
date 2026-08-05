@extends('layouts.app')
@section('titlepage', 'Dashboard Akademik Guru')
@section('content')
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #064e3b 0%, #0d6d53 100%);
            border-radius: 1.2rem;
            padding: 2rem;
            margin-bottom: 2rem;
            color: #fff;
            box-shadow: 0 4px 20px 0 rgba(6, 78, 59, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .dashboard-header .avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .dashboard-header .welcome {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
            color: #fff;
        }

        .dashboard-header .desc {
            font-size: 1rem;
            color: #a7f3d0;
        }

        .header-right {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.8rem 1.2rem;
            border-radius: 0.8rem;
            backdrop-filter: blur(5px);
        }

        .ta-badge {
            background-color: #f59e0b;
            color: #fff;
            padding: 0.3rem 0.7rem;
            border-radius: 0.4rem;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .schedule-card {
            transition: all 0.3s ease;
            border-left: 5px solid #064e3b;
        }

        .schedule-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.08) !important;
        }

        .quick-action-btn {
            transition: all 0.3s ease;
        }

        .quick-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.15) !important;
            background-color: #064e3b !important;
            color: #fff !important;
        }
        
        .quick-action-btn:hover i {
            color: #fff !important;
        }
    </style>

    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-left">
            @if (!empty($guru->karyawan->foto) && Storage::disk('public')->exists('photos/karyawan/' . $guru->karyawan->foto))
                <img src="{{ getfotoKaryawan($guru->karyawan->foto) }}" class="avatar" alt="Avatar">
            @else
                <div class="avatar bg-white d-flex align-items-center justify-content-center fw-bold text-success fs-3" style="width: 70px; height: 70px; border-radius: 50%;">
                    {{ substr($guru->karyawan->nama_lengkap, 0, 1) }}
                </div>
            @endif
            <div>
                <div class="welcome">{{ $sapaan }}, {{ $guru->karyawan->nama_lengkap }}</div>
                <div class="desc"><i class="ti ti-id me-1"></i>NPP: {{ $guru->npp }} | Unit: {{ $guru->unit->nama_unit ?? '-' }}</div>
            </div>
        </div>
        <div class="header-right text-end">
            <div class="small text-white-50">Tahun Ajaran Aktif</div>
            <div class="fw-bold fs-5 text-white mb-1">
                {{ $activeTa ? $activeTa->tahun_ajaran : 'Tidak Ada' }}
            </div>
            <span class="ta-badge">Semester {{ $activeTa ? (empty($activeSemester) ? '1' : $activeSemester->semester) : '-' }}</span>
        </div>
    </div>

    <div class="row g-4">
        <!-- Jadwal Hari Ini -->
        <div class="col-lg-8 col-md-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-4 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-sm bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                            <i class="ti ti-calendar-event fs-4 text-success"></i>
                        </div>
                        <h5 class="mb-0 fw-bold text-dark">Jadwal Mengajar Hari Ini ({{ $hariIni }})</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($jadwalHariIni->isEmpty())
                        <div class="text-center py-5">
                            <i class="ti ti-calendar-off fs-1 opacity-25 d-block mb-3"></i>
                            <h5 class="text-muted">Tidak ada jadwal mengajar hari ini</h5>
                            <p class="text-muted small mb-0">Nikmati waktu istirahat Anda atau lakukan persiapan mengajar berikutnya.</p>
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach($jadwalHariIni as $j)
                                <div class="col-md-6 col-12">
                                    <div class="card shadow-sm border-0 schedule-card h-100 bg-light-gray">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <span class="badge bg-label-primary px-2 mb-2">Jam Ke: {{ $j->jam_ke }}</span>
                                                    <h6 class="fw-bold mb-0 text-dark">{{ $j->mapel->nama_mapel ?? '-' }}</h6>
                                                    <span class="text-muted small"><i class="ti ti-clock me-1"></i>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</span>
                                                </div>
                                                @if($j->sudah_presensi)
                                                    <span class="badge bg-success rounded-pill px-3"><i class="ti ti-check me-1 small"></i>Presensi Selesai</span>
                                                @else
                                                    <span class="badge bg-warning rounded-pill px-3"><i class="ti ti-alert-triangle me-1 small"></i>Belum Presensi</span>
                                                @endif
                                            </div>
                                            <div class="border-top pt-2 mt-2 d-flex justify-content-between align-items-center">
                                                <span class="text-dark fw-semibold small"><i class="ti ti-chalkboard me-1 text-success"></i>Kelas {{ $j->kelas->nama_kelas ?? '-' }}</span>
                                                <a href="{{ route('presensi-mapel.index') }}" class="btn btn-xs btn-outline-success rounded d-flex align-items-center gap-1">
                                                    <i class="ti ti-clipboard-list small"></i> Presensi
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Info Kelas Binaan & Quick Actions -->
        <div class="col-lg-4 col-md-12">
            <div class="d-flex flex-column gap-4">
                <!-- Wali Kelas Card -->
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #fff;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge bg-label-success px-3 py-1 text-uppercase fw-semibold" style="font-size: 0.7rem;">Informasi Kelas</span>
                            <i class="ti ti-presentation fs-3 text-success"></i>
                        </div>
                        @if($kelasBinaan)
                            <h5 class="fw-bold text-white mb-1">Wali Kelas - {{ $kelasBinaan->nama_kelas }}</h5>
                            <p class="text-white-50 small mb-4">Unit: {{ $kelasBinaan->unit->nama_unit ?? '-' }}</p>
                            <div class="row text-center bg-white bg-opacity-10 rounded p-3">
                                <div class="col-6 border-end border-white border-opacity-10">
                                    <h4 class="fw-bold text-white mb-0">{{ $totalSiswa }}</h4>
                                    <span class="text-white-50 small">Total Siswa</span>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('wali-kelas.index') }}" class="btn btn-sm btn-success w-100 h-100 d-flex align-items-center justify-content-center gap-1 mt-1">
                                        <i class="ti ti-arrow-right"></i> Masuk Kelas
                                    </a>
                                </div>
                            </div>
                        @else
                            <h6 class="fw-bold text-white mb-1">Anda Bukan Wali Kelas</h6>
                            <p class="text-white-50 small mb-0">Akun Anda saat ini tidak terdaftar sebagai wali kelas untuk tahun ajaran aktif.</p>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="mb-0 fw-bold text-dark">Akses Cepat Akademik</h5>
                    </div>
                    <div class="card-body p-4 d-flex flex-column gap-2">
                        <a href="{{ route('presensi-mapel.index') }}" class="btn btn-light-secondary border text-start quick-action-btn py-3 px-3 rounded-3 d-flex align-items-center justify-content-between">
                            <span class="d-flex align-items-center gap-2">
                                <i class="ti ti-checklist text-success fs-4"></i>
                                <span class="fw-semibold text-dark small">Presensi Mata Pelajaran</span>
                            </span>
                            <i class="ti ti-chevron-right text-muted"></i>
                        </a>
                        <a href="{{ route('rapor.index') }}" class="btn btn-light-secondary border text-start quick-action-btn py-3 px-3 rounded-3 d-flex align-items-center justify-content-between">
                            <span class="d-flex align-items-center gap-2">
                                <i class="ti ti-file-report text-warning fs-4"></i>
                                <span class="fw-semibold text-dark small">Input Penilaian & Rapor</span>
                            </span>
                            <i class="ti ti-chevron-right text-muted"></i>
                        </a>
                        <a href="{{ route('jadwal-pelajaran.index') }}" class="btn btn-light-secondary border text-start quick-action-btn py-3 px-3 rounded-3 d-flex align-items-center justify-content-between">
                            <span class="d-flex align-items-center gap-2">
                                <i class="ti ti-calendar text-primary fs-4"></i>
                                <span class="fw-semibold text-dark small">Jadwal Mengajar Anda</span>
                            </span>
                            <i class="ti ti-chevron-right text-muted"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
