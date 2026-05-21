@extends('layouts.app')
@section('titlepage', 'Detail Penilaian Siswa')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-clipboard-text fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Detail Penilaian Kelas Binaan</h4>
                        <p class="text-muted mb-0 small">Halaman khusus pemantauan rincian nilai siswa oleh Wali Kelas (Read-Only)</p>
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
                            <li class="breadcrumb-item">
                                <a href="{{ route('wali-kelas.index') }}" class="text-muted">Wali Kelas</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-eye me-1"></i> Detail Penilaian
                            </li>
                        </ol>
                    </nav>
                    <a href="{{ route('wali-kelas.index') }}" class="btn btn-label-secondary d-flex align-items-center gap-2 shadow-sm">
                        <i class="ti ti-arrow-left fs-5"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <!-- Info Panel -->
    <div class="col-lg-8 col-md-12 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="avatar avatar-lg bg-label-success rounded-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="ti ti-book-2 fs-2 text-success"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">{{ $jadwal->mapel->nama_matpel ?? '-' }}</h4>
                        <p class="mb-0 text-muted">
                            <span>Kelas: <strong>{{ $jadwal->kelas->nama_kelas ?? '-' }}</strong></span>
                            <span class="mx-2">|</span>
                            <span>Guru Pengampu: <strong class="text-dark">{{ $jadwal->guru->nama_guru ?? '-' }}</strong></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bobot Penilaian Panel (Read-Only) -->
    <div class="col-lg-4 col-md-12 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header text-white p-2" style="background-color: #104e30; border-radius: 8px 8px 0 0;">
                <h6 class="mb-0 text-white text-center small text-uppercase fw-bold" style="letter-spacing: 0.5px;">
                    <i class="ti ti-settings me-1"></i> Bobot Penilaian (Total: 100%)
                </h6>
            </div>
            <div class="card-body p-3 d-flex align-items-center justify-content-around text-center h-100">
                <div>
                    <span class="d-block text-muted small mb-1">Bobot Sumatif</span>
                    <span class="badge bg-label-success fs-5 px-3 py-1 fw-bold">{{ $bobot->bobot_sumatif }}%</span>
                </div>
                <div style="border-left: 1px solid #e5e7eb; height: 40px;"></div>
                <div>
                    <span class="d-block text-muted small mb-1">Bobot SAS</span>
                    <span class="badge bg-label-info fs-5 px-3 py-1 fw-bold">{{ $bobot->bobot_sas }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Detail Tabs Container -->
    <div class="col-12 mb-4">
        <div class="nav-align-top nav-tabs-shadow">
            <ul class="nav nav-tabs border-bottom" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active py-3 px-4 fw-bold text-uppercase" role="tab" data-bs-toggle="tab" data-bs-target="#navs-rekap" aria-controls="navs-rekap" aria-selected="true" style="letter-spacing: 0.5px;">
                        <i class="ti ti-chart-bar me-1"></i> Rekapitulasi Rapor
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link py-3 px-4 fw-bold text-uppercase" role="tab" data-bs-toggle="tab" data-bs-target="#navs-sumatif" aria-controls="navs-sumatif" aria-selected="false" style="letter-spacing: 0.5px;">
                        <i class="ti ti-notebook me-1"></i> Rincian Sumatif
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link py-3 px-4 fw-bold text-uppercase" role="tab" data-bs-toggle="tab" data-bs-target="#navs-sas" aria-controls="navs-sas" aria-selected="false" style="letter-spacing: 0.5px;">
                        <i class="ti ti-file-certificate me-1"></i> Rincian SAS
                    </button>
                </li>
            </ul>

            <!-- Unified Search Bar Section -->
            <div class="p-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background-color: #104e30; border-top: 1px solid rgba(255,255,255,0.1);">
                <div class="d-flex align-items-center text-white-50 small">
                    <i class="ti ti-info-circle me-1"></i>
                    <span>Menampilkan nilai lengkap siswa untuk semester aktif.</span>
                </div>
                <div class="position-relative" style="width: 300px;">
                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                        <i class="ti ti-search fs-5"></i>
                    </span>
                    <input type="text" id="searchInput" 
                        class="form-control form-control-sm ps-5 border-0 shadow-sm transition-all rounded-pill" 
                        placeholder="Cari siswa atau NIS..." 
                        style="background-color: rgba(255,255,255,0.95); height: 36px;">
                </div>
            </div>

            <div class="tab-content p-0">
                <!-- Tab Panel Rekapitulasi Rapor -->
                <div class="tab-pane fade show active" id="navs-rekap" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0 text-nowrap text-dark" id="rekapTable">
                            <thead style="background-color: #0b3d24;">
                                <tr>
                                    <th class="text-white py-3 text-center" style="width: 50px;">NO</th>
                                    <th class="text-white py-3" style="width: 150px;">NIS</th>
                                    <th class="text-white py-3">NAMA LENGKAP</th>
                                    <th class="text-white py-3 text-center" style="width: 120px;">RATA SUMATIF</th>
                                    <th class="text-white py-3 text-center" style="width: 120px;">NILAI SAS</th>
                                    <th class="text-white py-3 text-center" style="width: 150px;">NILAI RAPOR</th>
                                    <th class="text-white py-3">DESKRIPSI CAPAIAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $index => $student)
                                    <tr class="searchable-row">
                                        <td class="text-center py-2 fw-semibold text-secondary" style="font-size: 0.85rem;">{{ $index + 1 }}</td>
                                        <td class="py-2"><span class="fw-bold">{{ $student->nis ?? '-' }}</span></td>
                                        <td class="py-2 fw-bold text-primary">{{ $student->nama_lengkap }}</td>
                                        <td class="text-center py-2 fw-semibold">{{ $student->rata_sumatif }}</td>
                                        <td class="text-center py-2 fw-semibold">{{ $student->nilai_sas }}</td>
                                        <td class="text-center py-2">
                                            <span class="badge {{ $student->nilai_rapor >= 75 ? 'bg-success' : 'bg-danger' }} px-3 py-1.5 fs-6 fw-bold">
                                                {{ $student->nilai_rapor }}
                                            </span>
                                        </td>
                                        <td class="py-2 text-muted" style="font-size: 0.8rem; max-width: 400px; white-space: normal; line-height: 1.4;">
                                            {{ strip_tags($student->capaian_kompetensi) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center p-5 text-muted">
                                            <i class="ti ti-users fs-2 opacity-50 d-block mb-2"></i>
                                            Belum ada data siswa untuk kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Panel Rincian Sumatif -->
                <div class="tab-pane fade" id="navs-sumatif" role="tabpanel">
                    @php
                        $rencanaSumatif = $rencanaPenilaian->where('kategori_penilaian', 'SUMATIF');
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0 text-nowrap text-dark" id="sumatifTable">
                            <thead style="background-color: #0b3d24;">
                                <tr>
                                    <th class="text-white py-3 text-center" style="width: 50px;">NO</th>
                                    <th class="text-white py-3" style="width: 150px;">NIS</th>
                                    <th class="text-white py-3">NAMA LENGKAP</th>
                                    @forelse ($rencanaSumatif as $rencana)
                                        <th class="text-white py-2 text-center" style="min-width: 100px;">
                                            <div class="d-flex flex-column align-items-center">
                                                <span class="fw-bold">{{ $rencana->kode_penilaian }}</span>
                                                <span class="text-white-50" style="font-size: 0.65rem;">{{ $rencana->nama_penilaian }}</span>
                                            </div>
                                        </th>
                                    @empty
                                        <th class="text-white py-3 text-center">RENCANA PENILAIAN</th>
                                    @endforelse
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $index => $student)
                                    <tr class="searchable-row">
                                        <td class="text-center py-2 fw-semibold text-secondary" style="font-size: 0.85rem;">{{ $index + 1 }}</td>
                                        <td class="py-2"><span class="fw-bold">{{ $student->nis ?? '-' }}</span></td>
                                        <td class="py-2 fw-bold text-primary">{{ $student->nama_lengkap }}</td>
                                        @forelse ($rencanaSumatif as $rencana)
                                            @php
                                                $score = $mappedGrades[$student->id_siswa][$rencana->id] ?? null;
                                            @endphp
                                            <td class="text-center py-2 fw-bold">
                                                @if($score !== null)
                                                    <span class="{{ $score < 75 ? 'text-danger' : 'text-success' }}">{{ number_format($score, 0) }}</span>
                                                @else
                                                    <span class="text-muted opacity-50">-</span>
                                                @endif
                                            </td>
                                        @empty
                                            <td class="text-center text-muted py-2 fst-italic">Belum ada rencana penilaian sumatif dari guru pengampu.</td>
                                        @endforelse
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ 3 + max(1, $rencanaSumatif->count()) }}" class="text-center p-5 text-muted">
                                            Belum ada data siswa.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Panel Rincian SAS -->
                <div class="tab-pane fade" id="navs-sas" role="tabpanel">
                    @php
                        $rencanaSas = $rencanaPenilaian->where('kategori_penilaian', 'SAS');
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0 text-nowrap text-dark" id="sasTable">
                            <thead style="background-color: #0b3d24;">
                                <tr>
                                    <th class="text-white py-3 text-center" style="width: 50px;">NO</th>
                                    <th class="text-white py-3" style="width: 150px;">NIS</th>
                                    <th class="text-white py-3">NAMA LENGKAP</th>
                                    @forelse ($rencanaSas as $rencana)
                                        <th class="text-white py-2 text-center" style="min-width: 100px;">
                                            <div class="d-flex flex-column align-items-center">
                                                <span class="fw-bold">{{ $rencana->kode_penilaian }}</span>
                                                <span class="text-white-50" style="font-size: 0.65rem;">{{ $rencana->nama_penilaian }}</span>
                                            </div>
                                        </th>
                                    @empty
                                        <th class="text-white py-3 text-center">RENCANA PENILAIAN</th>
                                    @endforelse
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $index => $student)
                                    <tr class="searchable-row">
                                        <td class="text-center py-2 fw-semibold text-secondary" style="font-size: 0.85rem;">{{ $index + 1 }}</td>
                                        <td class="py-2"><span class="fw-bold">{{ $student->nis ?? '-' }}</span></td>
                                        <td class="py-2 fw-bold text-primary">{{ $student->nama_lengkap }}</td>
                                        @forelse ($rencanaSas as $rencana)
                                            @php
                                                $score = $mappedGrades[$student->id_siswa][$rencana->id] ?? null;
                                            @endphp
                                            <td class="text-center py-2 fw-bold">
                                                @if($score !== null)
                                                    <span class="{{ $score < 75 ? 'text-danger' : 'text-success' }}">{{ number_format($score, 0) }}</span>
                                                @else
                                                    <span class="text-muted opacity-50">-</span>
                                                @endif
                                            </td>
                                        @empty
                                            <td class="text-center text-muted py-2 fst-italic">Belum ada rencana penilaian SAS dari guru pengampu.</td>
                                        @endforelse
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ 3 + max(1, $rencanaSas->count()) }}" class="text-center p-5 text-muted">
                                            Belum ada data siswa.
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

@push('myscript')
<script>
    $(document).ready(function(){
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            
            // Search filter across all tables
            $(".searchable-row").filter(function() {
                var match = $(this).text().toLowerCase().indexOf(value) > -1;
                $(this).toggle(match);
            });
        });
    });
</script>
@endpush
@endsection
