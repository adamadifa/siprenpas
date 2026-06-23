@extends('layouts.app')
@section('titlepage', 'Wali Kelas - Kelas Binaan')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-presentation fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Kelas Binaan (Wali Kelas)</h4>
                        <p class="text-muted mb-0 small">Pemantauan dan manajemen kelas binaan Anda</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-school me-1"></i> Akademik
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-presentation me-1"></i> Wali Kelas
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <!-- Top Row: Class Info & Wali Kelas Profile -->
    <div class="col-12 mb-4">
        <div class="row g-3">
            <!-- Left Side: Class Selector and/or Class Details -->
            <div class="col-lg-7 col-md-12">
                <div class="row g-3 h-100">
                    @if ($kelasBinaan->count() > 1)
                        <div class="col-md-5">
                            <div class="card h-100 shadow-sm border-0" style="border-left: 4px solid #064e3b !important;">
                                <div class="card-body p-3 d-flex flex-column justify-content-center">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="avatar avatar-xs rounded bg-label-success d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; min-width: 28px;">
                                            <i class="ti ti-chalkboard fs-6 text-success"></i>
                                        </div>
                                        <label class="form-label fw-bold text-dark mb-0 small">Pilih Kelas Binaan</label>
                                    </div>
                                    <form action="{{ route('wali-kelas.index') }}" method="GET" id="formSelectKelas">
                                        <select name="kode_kelas" class="form-select border shadow-sm" style="border-color: #cbd5e1 !important; font-weight: 600;" onchange="document.getElementById('formSelectKelas').submit();">
                                            @foreach ($kelasBinaan as $kb)
                                                <option value="{{ $kb->kode_kelas }}" {{ $currentKelas->kode_kelas == $kb->kode_kelas ? 'selected' : '' }}>
                                                    Kelas {{ $kb->nama_kelas }} ({{ $kb->unit->nama_unit }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="{{ $kelasBinaan->count() > 1 ? 'col-md-7' : 'col-12' }}">
                        <div class="card border-0 shadow-sm text-white h-100" style="background: linear-gradient(135deg, #0f4e36 0%, #1e7552 100%);">
                            <div class="card-body p-3 d-flex flex-column justify-content-center">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div>
                                        <h4 class="fw-bold mb-1 text-white">Kelas {{ $currentKelas->nama_kelas }}</h4>
                                        <p class="mb-0 opacity-75 small">
                                            <i class="ti ti-building me-1"></i> Unit: {{ $currentKelas->unit->nama_unit }} 
                                            | <i class="ti ti-users me-1"></i> {{ $students->count() }} Siswa
                                        </p>
                                    </div>
                                    <div class="px-2 py-1 rounded bg-white">
                                        <span class="small fw-semibold" style="color: #0f4e36;">
                                            TA: {{ $activeTa->tahun_ajaran }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Wali Kelas Profile -->
            <div class="col-lg-5 col-md-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3 d-flex flex-column justify-content-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                                <i class="ti ti-user-check fs-3 text-success"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <h6 class="mb-0 fw-bold text-dark">{{ $guruModel->nama_guru }}</h6>
                                    <span class="badge bg-label-success px-2 py-0.5" style="font-size: 0.65rem;">Wali Kelas</span>
                                </div>
                                <p class="text-muted small mb-0" style="font-size: 0.75rem;">NPP: {{ $guruModel->npp ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-top text-muted d-flex align-items-center gap-1" style="font-size: 0.72rem; line-height: 1.2;">
                           <i class="ti ti-info-circle text-primary fs-6 flex-shrink-0"></i>
                           <span>Bertanggung jawab atas rekap nilai, presensi, & rapor kelas binaan ini.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabbed Content Area for Wali Kelas (Full Width) -->
    <div class="col-12 mb-4">
        <div class="nav-align-top nav-tabs-shadow">
            <ul class="nav nav-tabs border-bottom" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active py-3 px-4 fw-bold text-uppercase" role="tab" data-bs-toggle="tab" data-bs-target="#navs-siswa" aria-controls="navs-siswa" aria-selected="true" style="letter-spacing: 0.5px;">
                        <i class="ti ti-users me-1"></i> Daftar Siswa
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link py-3 px-4 fw-bold text-uppercase" role="tab" data-bs-toggle="tab" data-bs-target="#navs-monitoring" aria-controls="navs-monitoring" aria-selected="false" style="letter-spacing: 0.5px;">
                        <i class="ti ti-report-analytics me-1"></i> Monitoring Rapor
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link py-3 px-4 fw-bold text-uppercase" role="tab" data-bs-toggle="tab" data-bs-target="#navs-presensi" aria-controls="navs-presensi" aria-selected="false" style="letter-spacing: 0.5px;">
                        <i class="ti ti-calendar-check me-1"></i> Monitoring Presensi
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link py-3 px-4 fw-bold text-uppercase" role="tab" data-bs-toggle="tab" data-bs-target="#navs-cetakraport" aria-controls="navs-cetakraport" aria-selected="false" style="letter-spacing: 0.5px;">
                        <i class="ti ti-printer me-1"></i> Cetak Rapor
                    </button>
                </li>
            </ul>
            <div class="tab-content p-0">
                <!-- Tab Panel Daftar Siswa -->
                <div class="tab-pane fade show active" id="navs-siswa" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead style="background-color: #053b2d;">
                                <tr>
                                    <th class="text-white py-3 text-center" style="width: 50px;">NO</th>
                                    <th class="text-white py-3" style="width: 150px;">NIS</th>
                                    <th class="text-white py-3">NAMA SISWA</th>
                                    <th class="text-white py-3 text-center" style="width: 80px;">L/P</th>
                                    <th class="text-white py-3">TEMPAT, TGL LAHIR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $index => $student)
                                    <tr>
                                        <td class="text-center py-2 fw-semibold text-secondary">{{ $index + 1 }}</td>
                                        <td class="py-2"><span class="fw-bold text-dark">{{ $student->nis ?? '-' }}</span></td>
                                        <td class="py-2 fw-bold text-dark">{{ $student->nama_lengkap }}</td>
                                        <td class="text-center py-2">
                                            @if(strtoupper($student->jenis_kelamin) == 'L' || strtoupper($student->jenis_kelamin) == 'LAKI-LAKI')
                                                <span class="badge bg-label-primary px-2">L</span>
                                            @else
                                                <span class="badge bg-label-danger px-2">P</span>
                                            @endif
                                        </td>
                                        <td class="py-2 text-muted" style="font-size: 0.8rem;">
                                            {{ $student->tempat_lahir ?? '-' }}, {{ $student->tanggal_lahir ? \Carbon\Carbon::parse($student->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center p-5">
                                            <div class="mb-3 text-muted">
                                                <i class="ti ti-users fs-1 opacity-25"></i>
                                            </div>
                                            <h5>Belum ada siswa terdaftar di kelas ini.</h5>
                                            <p class="text-muted small">Hubungi admin akademik untuk memasukkan siswa ke kelas ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Panel Monitoring Rapor -->
                <div class="tab-pane fade" id="navs-monitoring" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead style="background-color: #053b2d;">
                                <tr>
                                    <th class="text-white py-3 text-center" style="width: 50px;">NO</th>
                                    <th class="text-white py-3">MATA PELAJARAN</th>
                                    <th class="text-white py-3">GURU PENGAMPU</th>
                                    <th class="text-white py-3 text-center" style="width: 100px;">SUMATIF</th>
                                    <th class="text-white py-3 text-center" style="width: 100px;">SAS</th>
                                    <th class="text-white py-3 text-center" style="width: 200px;">PROGRESS NILAI</th>
                                    <th class="text-white py-3 text-center" style="width: 130px;">STATUS</th>
                                    <th class="text-white py-3 text-center" style="width: 100px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($monitoringData as $index => $item)
                                    <tr>
                                        <td class="text-center py-2 fw-semibold text-secondary" style="font-size: 0.85rem;">{{ $index + 1 }}</td>
                                        <td class="py-2"><span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $item->mapel_nama }}</span></td>
                                        <td class="py-2 text-dark" style="font-size: 0.85rem;">{{ $item->guru_nama }}</td>
                                        <td class="text-center py-2">
                                            <span class="badge bg-label-info px-2 py-1" style="font-size: 0.75rem;">{{ $item->rencana_sumatif }} Rencana</span>
                                        </td>
                                        <td class="text-center py-2">
                                            <span class="badge bg-label-info px-2 py-1" style="font-size: 0.75rem;">{{ $item->rencana_sas }} Rencana</span>
                                        </td>
                                        <td class="py-2">
                                            <div class="d-flex align-items-center gap-2 text-nowrap">
                                                <div class="progress" style="width: 80px; height: 8px; flex-shrink: 0;">
                                                    <div class="progress-bar {{ $item->completion_rate == 100 ? 'bg-success' : ($item->completion_rate > 0 ? 'bg-warning' : 'bg-danger') }}" 
                                                         role="progressbar" 
                                                         style="width: {{ $item->completion_rate }}%;" 
                                                         aria-valuenow="{{ $item->completion_rate }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100"></div>
                                                </div>
                                                <span class="fw-semibold text-dark" style="font-size: 0.85rem;">{{ $item->completion_rate }}%</span>
                                                <span class="text-muted" style="font-size: 0.75rem;">({{ $item->nilai_count }}/{{ $item->expected_count }})</span>
                                            </div>
                                        </td>
                                        <td class="text-center py-2">
                                            @if ($item->status == 'Lengkap')
                                                <span class="badge bg-success px-2 py-1" style="font-size: 0.75rem;">Lengkap</span>
                                            @elseif ($item->status == 'Belum Lengkap')
                                                <span class="badge bg-warning px-2 py-1" style="font-size: 0.75rem;">Belum Lengkap</span>
                                            @elseif ($item->status == 'Belum Diisi')
                                                <span class="badge bg-danger px-2 py-1" style="font-size: 0.75rem;">Belum Diisi</span>
                                            @else
                                                <span class="badge bg-secondary px-2 py-1" style="font-size: 0.75rem;">Belum Ada Rencana</span>
                                            @endif
                                        </td>
                                        <td class="text-center py-2">
                                            <a href="{{ route('wali-kelas.detail-penilaian', $item->jadwal_id) }}" class="btn btn-label-success btn-xs px-2 py-1" style="font-size: 0.75rem;">
                                                <i class="ti ti-eye me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center p-5">
                                            <div class="mb-3 text-muted">
                                                <i class="ti ti-book fs-1 opacity-25"></i>
                                            </div>
                                            <h5>Belum ada jadwal pelajaran terdaftar di kelas ini untuk semester ini.</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Panel Monitoring Presensi -->
                <div class="tab-pane fade" id="navs-presensi" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead style="background-color: #053b2d;">
                                <tr>
                                    <th class="text-white py-3 text-center" style="width: 50px;">NO</th>
                                    <th class="text-white py-3">HARI & JAM</th>
                                    <th class="text-white py-3">MATA PELAJARAN</th>
                                    <th class="text-white py-3">GURU PENGAMPU</th>
                                    <th class="text-white py-3 text-center" style="width: 150px;">JUMLAH PERTEMUAN</th>
                                    <th class="text-white py-3 text-center" style="width: 150px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($presenceSchedules as $index => $schedule)
                                    <tr>
                                        <td class="text-center py-2 fw-semibold text-secondary" style="font-size: 0.85rem;">{{ $index + 1 }}</td>
                                        <td class="py-2" style="font-size: 0.85rem;">
                                            <span class="fw-bold text-dark">{{ $schedule->hari }}</span><br>
                                            <span class="text-muted small">Jam ke-{{ $schedule->jam_ke }} ({{ $schedule->jam_mulai }} - {{ $schedule->jam_selesai }})</span>
                                        </td>
                                        <td class="py-2"><span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $schedule->mapel ? $schedule->mapel->nama_matpel : 'Mapel Tidak Diketahui' }}</span></td>
                                        <td class="py-2 text-dark" style="font-size: 0.85rem;">{{ $schedule->guru ? $schedule->guru->nama_guru : 'Guru Tidak Diketahui' }}</td>
                                        <td class="text-center py-2">
                                            <span class="badge bg-label-success px-2 py-1" style="font-size: 0.75rem;">{{ $schedule->presensi_count }} Pertemuan</span>
                                        </td>
                                        <td class="text-center py-2">
                                            <a href="{{ route('jadwal-pelajaran.cetak-presensi', \Illuminate\Support\Facades\Crypt::encrypt($schedule->id)) }}" target="_blank" class="btn btn-label-success btn-xs px-2 py-1" style="font-size: 0.75rem;">
                                                <i class="ti ti-printer me-1"></i> Cetak Presensi
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center p-5">
                                            <div class="mb-3 text-muted">
                                                <i class="ti ti-calendar fs-1 opacity-25"></i>
                                            </div>
                                            <h5>Belum ada jadwal pelajaran terdaftar di kelas ini untuk semester ini.</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Panel Cetak Rapor -->
                <div class="tab-pane fade" id="navs-cetakraport" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead style="background-color: #053b2d;">
                                <tr>
                                    <th class="text-white py-3 text-center" style="width: 50px;">NO</th>
                                    <th class="text-white py-3" style="width: 150px;">NIS</th>
                                    <th class="text-white py-3">NAMA SISWA</th>
                                    <th class="text-white py-3 text-center" style="width: 80px;">L/P</th>
                                    <th class="text-white py-3 text-center" style="width: 150px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $index => $student)
                                    <tr>
                                        <td class="text-center py-2 fw-semibold text-secondary">{{ $index + 1 }}</td>
                                        <td class="py-2"><span class="fw-bold text-dark">{{ $student->nis ?? '-' }}</span></td>
                                        <td class="py-2 fw-bold text-dark">{{ $student->nama_lengkap }}</td>
                                        <td class="text-center py-2">
                                            @if(strtoupper($student->jenis_kelamin) == 'L' || strtoupper($student->jenis_kelamin) == 'LAKI-LAKI')
                                                <span class="badge bg-label-primary px-2">L</span>
                                            @else
                                                <span class="badge bg-label-danger px-2">P</span>
                                            @endif
                                        </td>
                                        <td class="text-center py-2">
                                            @if ($student->no_pendaftaran)
                                                <a href="{{ route('rapor-siswa.preview', Crypt::encrypt($student->no_pendaftaran)) }}" class="btn btn-label-success btn-xs px-2 py-1" style="font-size: 0.75rem;">
                                                    <i class="ti ti-printer me-1"></i> Cetak Rapor
                                                </a>
                                            @else
                                                <span class="text-muted small">No Pendaftaran Kosong</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center p-5">
                                            <div class="mb-3 text-muted">
                                                <i class="ti ti-users fs-1 opacity-25"></i>
                                            </div>
                                            <h5>Belum ada siswa terdaftar di kelas ini.</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
