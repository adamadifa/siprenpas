{{-- Report Kelengkapan Data: Ultra-Clean SaaS Dashboard Aesthetic (Card Grid Only) --}}
<style>
    .clean-dashboard-wrapper {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    /* Unit Clean Cards */
    .clean-unit-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1.4rem;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }
    .clean-unit-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
    }

    .unit-avatar-box {
        width: 46px;
        height: 46px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #0f172a;
        font-size: 1rem;
        overflow: hidden;
        flex-shrink: 0;
    }
    .unit-avatar-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .clean-segment-track {
        height: 6px;
        background: #f1f5f9;
        border-radius: 100px;
        overflow: hidden;
    }

    .clean-badge-pill {
        border-radius: 100px;
        padding: 0.2rem 0.65rem;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .metric-row {
        padding: 0.65rem 0;
        border-bottom: 1px solid #f8fafc;
    }
    .metric-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .metric-name {
        font-size: 0.8rem;
        font-weight: 600;
        color: #334155;
    }

    .drilldown-btn {
        font-size: 0.72rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.22rem 0.65rem;
        border-radius: 6px;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        line-height: 1.2;
    }
    .drilldown-btn-primary {
        background: #f8fafc;
        color: #0f172a;
        border-color: #e2e8f0;
    }
    .drilldown-btn-primary:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }
    .drilldown-btn-warning {
        background: #fffbeb;
        color: #b45309;
        border-color: #fde68a;
    }
    .drilldown-btn-warning:hover {
        background: #f59e0b;
        color: #ffffff;
        border-color: #f59e0b;
    }
</style>

<div class="clean-dashboard-wrapper">
    {{-- Header Section Rekap Unit --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h6 class="mb-0 fw-bold text-dark" style="font-size: 1rem; letter-spacing: -0.2px;">
                Rekapitulasi Unit Pendidikan
            </h6>
            <div class="text-muted" style="font-size: 0.78rem;">Monitoring kesiapan 4 pilar operasional per unit • Tahun Ajaran: <strong>{{ $selectedTa ? $selectedTa->tahun_ajaran : $kode_ta }}</strong></div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge clean-badge-pill" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;">
                <i class="ti ti-school me-1 text-primary"></i> {{ count($reportData) }} Unit Terdaftar
            </span>
        </div>
    </div>

    {{-- Unit Card Grid --}}
    <div class="row g-3">
        @forelse ($reportData as $row)
            @php
                $u = $row['unit'];
                $mapel = $row['mapel'];
                $jadwal = $row['jadwal'];
                $santri = $row['santri'];
                $ploting = $row['ploting'];
                $score = $row['overall_score'];

                if ($score >= 80) {
                    $badgeStyle = 'background: #dcfce7; color: #15803d;';
                    $labelKesiapan = 'Lengkap';
                } elseif ($score >= 40) {
                    $badgeStyle = 'background: #fef3c7; color: #b45309;';
                    $labelKesiapan = 'Dalam Proses';
                } else {
                    $badgeStyle = 'background: #fee2e2; color: #b91c1c;';
                    $labelKesiapan = 'Belum Siap';
                }
            @endphp
            <div class="col-12 col-md-6 col-xl-4">
                <div class="clean-unit-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        {{-- Top: Unit Header --}}
                        <div class="d-flex align-items-center justify-content-between pb-4 mb-3.5 border-bottom" style="border-color: #f1f5f9 !important;">
                            <div class="d-flex align-items-center gap-3 overflow-hidden me-2">
                                @if (!empty($u->logo))
                                    <img src="{{ asset('storage/' . $u->logo) }}" alt="{{ $u->nama_unit }}" class="flex-shrink-0" style="width: 44px; height: 44px; object-fit: contain;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-dark flex-shrink-0" style="width: 44px; height: 44px; background: #f1f5f9; font-size: 0.95rem;">
                                        {{ substr($u->nama_unit, 0, 2) }}
                                    </div>
                                @endif
                                <div class="overflow-hidden">
                                    <div class="fw-bold text-dark text-truncate" style="font-size: 0.94rem; letter-spacing: -0.2px; line-height: 1.3;" title="{{ $u->nama_unit }}">
                                        {{ $u->nama_unit }}
                                    </div>
                                    <div class="mt-0.5" style="font-size: 0.76rem; color: #64748b;">Kode Unit: <strong class="text-dark">{{ $u->kode_unit }}</strong></div>
                                </div>
                            </div>
                            <span class="badge clean-badge-pill flex-shrink-0" style="{{ $badgeStyle }}">
                                {{ $score }}% • {{ $labelKesiapan }}
                            </span>
                        </div>

                        {{-- 4 Aspek Kelengkapan --}}
                        <div class="py-1">
                            {{-- 1. Mata Pelajaran --}}
                            <div class="metric-row">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="metric-name">
                                        <i class="ti ti-book text-muted me-1.5"></i> Mata Pelajaran
                                    </span>
                                    <div class="text-end">
                                        <span class="fw-bold text-dark" style="font-size: 0.84rem;">{{ $mapel['aktif'] }}</span>
                                        <span style="font-size: 0.76rem; color: #64748b;">/ {{ $mapel['total'] }} mapel</span>
                                    </div>
                                </div>
                            </div>

                            {{-- 2. Setting Jadwal --}}
                            <div class="metric-row">
                                <div class="d-flex align-items-center justify-content-between mb-1.5">
                                    <span class="metric-name">
                                        <i class="ti ti-calendar-event text-muted me-1.5"></i> Setting Jadwal
                                    </span>
                                    <div class="text-end">
                                        <span class="fw-bold text-dark" style="font-size: 0.84rem;">{{ $jadwal['kelas_terjadwal'] }}/{{ $jadwal['total_kelas'] }} kelas</span>
                                        <span style="font-size: 0.75rem; color: #64748b;">({{ $jadwal['persen'] }}%)</span>
                                    </div>
                                </div>
                                <div class="clean-segment-track mb-1.5">
                                    <div class="h-100 {{ $jadwal['persen'] == 100 ? 'bg-success' : 'bg-primary' }}" style="width: {{ $jadwal['persen'] }}%;"></div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span style="font-size: 0.74rem; color: #64748b;">{{ $jadwal['total_sesi'] }} Jam Pelajaran</span>
                                    @if ($jadwal['total_kelas'] > 0)
                                        <button class="drilldown-btn drilldown-btn-primary btn-view-jadwal" 
                                                data-kode-unit="{{ $u->kode_unit }}" data-nama-unit="{{ $u->nama_unit }}">
                                            <span>Detail</span> <i class="ti ti-arrow-right fs-6"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            {{-- 3. Data Profil Santri --}}
                            <div class="metric-row">
                                <div class="d-flex align-items-center justify-content-between mb-1.5">
                                    <span class="metric-name">
                                        <i class="ti ti-user-check text-muted me-1.5"></i> Profil Santri
                                    </span>
                                    <div class="text-end">
                                        <span class="fw-bold text-dark" style="font-size: 0.84rem;">{{ $santri['lengkap'] }}/{{ $santri['total'] }}</span>
                                        <span style="font-size: 0.75rem; color: #64748b;">({{ $santri['persen'] }}%)</span>
                                    </div>
                                </div>
                                <div class="clean-segment-track mb-1.5">
                                    <div class="h-100 {{ $santri['persen'] >= 80 ? 'bg-success' : ($santri['persen'] >= 40 ? 'bg-warning' : 'bg-danger') }}" style="width: {{ $santri['persen'] }}%;"></div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    @if ($santri['belum_lengkap'] > 0)
                                        <span class="text-danger fw-semibold" style="font-size: 0.74rem;">
                                            {{ $santri['belum_lengkap'] }} data kurang
                                        </span>
                                        <button class="drilldown-btn drilldown-btn-warning btn-view-santri-belum-lengkap" 
                                                data-kode-unit="{{ $u->kode_unit }}" data-nama-unit="{{ $u->nama_unit }}">
                                            <span>Periksa</span> <i class="ti ti-arrow-right fs-6"></i>
                                        </button>
                                    @else
                                        <span class="text-success fw-semibold" style="font-size: 0.74rem;">100% Lengkap</span>
                                    @endif
                                </div>
                            </div>

                            {{-- 4. Ploting Kelas --}}
                            <div class="metric-row">
                                <div class="d-flex align-items-center justify-content-between mb-1.5">
                                    <span class="metric-name">
                                        <i class="ti ti-layout-grid text-muted me-1.5"></i> Ploting Kelas
                                    </span>
                                    <div class="text-end">
                                        <span class="fw-bold text-dark" style="font-size: 0.84rem;">{{ $ploting['plotted'] }}/{{ $ploting['total'] }}</span>
                                        <span style="font-size: 0.75rem; color: #64748b;">({{ $ploting['persen'] }}%)</span>
                                    </div>
                                </div>
                                <div class="clean-segment-track mb-1.5">
                                    <div class="h-100 bg-primary" style="width: {{ $ploting['persen'] }}%;"></div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    @if ($ploting['belum_plotted'] > 0)
                                        <span class="text-danger fw-semibold" style="font-size: 0.74rem;">
                                            {{ $ploting['belum_plotted'] }} belum masuk rombel
                                        </span>
                                        <button class="drilldown-btn drilldown-btn-primary btn-view-santri-belum-plot" 
                                                data-kode-unit="{{ $u->kode_unit }}" data-nama-unit="{{ $u->nama_unit }}">
                                            <span>Daftar</span> <i class="ti ti-arrow-right fs-6"></i>
                                        </button>
                                    @else
                                        <span class="text-success fw-semibold" style="font-size: 0.74rem;">100% Ter-plot</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Action Buttons --}}
                    <div class="pt-3 mt-3 border-top d-flex align-items-center justify-content-between">
                        <div class="dropdown">
                            <button class="btn btn-xs btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px; font-weight: 500;">
                                Menu Unit
                            </button>
                            <ul class="dropdown-menu shadow-sm" style="font-size: 0.82rem; border-radius: 10px;">
                                <li>
                                    <a class="dropdown-item py-1.5" href="{{ route('mata-pelajaran.index', ['kode_unit' => $u->kode_unit]) }}">
                                        <i class="ti ti-book me-1.5 text-primary"></i> Mata Pelajaran
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-1.5" href="{{ route('jadwal-pelajaran.index', ['kode_unit' => $u->kode_unit, 'kode_ta' => $kode_ta]) }}">
                                        <i class="ti ti-calendar me-1.5 text-success"></i> Jadwal Pelajaran
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-1.5" href="{{ route('siswa.index', ['kode_unit' => $u->kode_unit]) }}">
                                        <i class="ti ti-users me-1.5 text-warning"></i> Data Santri
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-1.5" href="{{ route('kelas.index', ['kode_unit_search' => $u->kode_unit, 'kode_ta' => $kode_ta]) }}">
                                        <i class="ti ti-layout-grid me-1.5 text-info"></i> Ploting Kelas
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <a href="{{ route('kelas.index', ['kode_unit_search' => $u->kode_unit, 'kode_ta' => $kode_ta]) }}" class="btn btn-xs btn-dark d-flex align-items-center gap-1" style="border-radius: 8px; font-weight: 500;">
                            <span>Kelola Unit</span> <i class="ti ti-arrow-right" style="font-size: 0.75rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card p-4 text-center border" style="background: #ffffff; color: #64748b; border-radius: 1.25rem;">
                    <i class="ti ti-info-circle fs-3 text-warning mb-2"></i>
                    <div class="fw-semibold">Tidak ada data unit yang ditemukan untuk Tahun Ajaran ini.</div>
                </div>
            </div>
        @endforelse
    </div>
</div>

