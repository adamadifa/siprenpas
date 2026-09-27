{{-- Report Kelengkapan Data: Ultra-Clean SaaS Dashboard Aesthetic with Global KPI Cards --}}
<style>
    .clean-dashboard-wrapper {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    /* KPI Summary Stat Cards */
    .kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.2rem 1.4rem;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(15, 23, 42, 0.07);
    }
    .kpi-card .kpi-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }
    .kpi-icon.icon-blue { background: #eff6ff; color: #2563eb; }
    .kpi-icon.icon-emerald { background: #ecfdf5; color: #059669; }
    .kpi-icon.icon-amber { background: #fffbeb; color: #d97706; }
    .kpi-icon.icon-purple { background: #faf5ff; color: #7c3aed; }

    .kpi-title {
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 0.2rem;
    }
    .kpi-value {
        font-size: 1.45rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }
    .kpi-sub {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 0.35rem;
    }

    /* Unit Clean Cards */
    .clean-unit-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.4rem;
        transition: all 0.25s ease;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .clean-unit-card:hover {
        border-color: #cbd5e1;
        transform: translateY(-3px);
        box-shadow: 0 12px 24px -6px rgba(15, 23, 42, 0.08);
    }

    .unit-avatar-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        color: #064e3b;
        font-size: 1.05rem;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.03);
    }
    .unit-avatar-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .clean-segment-track {
        height: 6px;
        background: #f1f5f9;
        border-radius: 100px;
        overflow: hidden;
    }

    .clean-badge-pill {
        border-radius: 100px;
        padding: 0.25rem 0.75rem;
        font-size: 0.74rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .metric-row {
        padding: 0.7rem 0;
        border-bottom: 1px solid #f8fafc;
    }
    .metric-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .metric-name {
        font-size: 0.82rem;
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
        padding: 0.25rem 0.7rem;
        border-radius: 8px;
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

    .btn-action-unit {
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.76rem;
        padding: 0.35rem 0.75rem;
    }
</style>

<div class="clean-dashboard-wrapper" id="captureAllUnitsWrapper">

    {{-- 1. KPI GLOBAL OVERVIEW (SUMMARY STATS) --}}
    @if(isset($summary))
    <div class="row g-3 mb-4">
        {{-- Total Santri Aktif --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="kpi-title">Total Santri</div>
                        <div class="kpi-value">{{ number_format($summary['total_santri'] ?? 0, 0, ',', '.') }}</div>
                        <div class="kpi-sub">Santri terdaftar & aktif</div>
                    </div>
                    <div class="kpi-icon icon-blue">
                        <i class="ti ti-users"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Profil Santri Lengkap --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="kpi-title">Profil Santri Lengkap</div>
                        <div class="kpi-value text-success">
                            {{ $summary['persen_santri_lengkap'] ?? 0 }}%
                        </div>
                        <div class="kpi-sub">{{ $summary['total_santri_lengkap'] ?? 0 }} dari {{ $summary['total_santri'] ?? 0 }} santri</div>
                    </div>
                    <div class="kpi-icon icon-emerald">
                        <i class="ti ti-id-badge-2"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ploting Kelas / Rombel --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="kpi-title">Ploting Rombel</div>
                        <div class="kpi-value text-primary">
                            {{ $summary['persen_santri_plotted'] ?? 0 }}%
                        </div>
                        <div class="kpi-sub">{{ $summary['total_santri_plotted'] ?? 0 }} santri sudah masuk kelas</div>
                    </div>
                    <div class="kpi-icon icon-purple">
                        <i class="ti ti-layout-grid"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Jadwal Pelajaran Terplot --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="kpi-card h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="kpi-title">Kesiapan Jadwal</div>
                        <div class="kpi-value text-warning">
                            {{ $summary['persen_jadwal'] ?? 0 }}%
                        </div>
                        <div class="kpi-sub">{{ $summary['total_kelas_jadwal'] ?? 0 }}/{{ $summary['total_kelas'] ?? 0 }} rombel terjadwal</div>
                    </div>
                    <div class="kpi-icon icon-amber">
                        <i class="ti ti-calendar-time"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- 2. HEADER REKAPITULASI UNIT --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
        <div>
            <h6 class="mb-0 fw-bold text-dark" style="font-size: 1.05rem; letter-spacing: -0.2px;">
                Rekapitulasi Kesiapan Unit Pendidikan
            </h6>
            <div class="text-muted" style="font-size: 0.78rem;">Monitoring 4 pilar operasional per unit pendidikan • TA: <strong>{{ $selectedTa ? $selectedTa->tahun_ajaran : $kode_ta }}</strong></div>
        </div>
        <div class="d-flex align-items-center gap-2" id="headerActionRekap">
            <span class="badge clean-badge-pill" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;">
                <i class="ti ti-school text-primary"></i> {{ count($reportData) }} Unit Terdaftar
            </span>
            <button type="button" class="btn btn-sm btn-success d-flex align-items-center gap-1.5 fw-semibold shadow-sm" id="btnDownloadAllUnits" title="Download Gambar Rekap Seluruh Unit untuk WhatsApp / Laporan" style="border-radius: 8px; padding: 0.4rem 0.85rem; font-size: 0.8rem;">
                <i class="ti ti-download fs-6"></i> <span>Unduh Rekap Semua Unit</span>
            </button>
        </div>
    </div>

    {{-- 3. UNIT CARDS GRID --}}
    <div class="row g-3">
        @forelse ($reportData as $row)
            @php
                $u = $row['unit'];
                $mapel = $row['mapel'];
                $jadwal = $row['jadwal'];
                $santri = $row['santri'];
                $ploting = $row['ploting'];
                $score = $row['overall_score'];
                $hasJadwal = $row['has_jadwal'] ?? true;

                if ($score >= 80) {
                    $badgeStyle = 'background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;';
                    $labelKesiapan = 'Lengkap';
                    $scoreColor = '#15803d';
                } elseif ($score >= 40) {
                    $badgeStyle = 'background: #fef3c7; color: #b45309; border: 1px solid #fde68a;';
                    $labelKesiapan = 'Dalam Proses';
                    $scoreColor = '#b45309';
                } else {
                    $badgeStyle = 'background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;';
                    $labelKesiapan = 'Belum Siap';
                    $scoreColor = '#b91c1c';
                }
            @endphp
            <div class="col-12 col-md-6 col-xl-4">
                <div class="clean-unit-card h-100" id="card-unit-{{ $u->kode_unit }}">
                    <div>
                        {{-- Top: Unit Header --}}
                        <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom" style="border-color: #f1f5f9 !important;">
                            <div class="d-flex align-items-center gap-3 overflow-hidden me-2">
                                @if (!empty($u->logo))
                                    <img src="{{ asset('storage/' . $u->logo) }}" alt="{{ $u->nama_unit }}" class="flex-shrink-0" style="width: 44px; height: 44px; object-fit: contain;">
                                @else
                                    <div class="unit-avatar-box">
                                        {{ substr($u->nama_unit, 0, 2) }}
                                    </div>
                                @endif
                                <div class="overflow-hidden">
                                    <div class="fw-bold text-dark text-truncate" style="font-size: 0.96rem; letter-spacing: -0.2px; line-height: 1.3;" title="{{ $u->nama_unit }}">
                                        {{ $u->nama_unit }}
                                    </div>
                                    <div class="mt-0.5" style="font-size: 0.76rem; color: #64748b;">Kode Unit: <strong class="text-dark">{{ $u->kode_unit }}</strong></div>
                                </div>
                            </div>
                            <span class="badge clean-badge-pill flex-shrink-0" style="{{ $badgeStyle }}">
                                <span style="font-size: 0.82rem; font-weight: 800;">{{ $score }}%</span> • {{ $labelKesiapan }}
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

                            @if ($hasJadwal)
                                {{-- 2. Setting Jadwal (Khusus SDIT, MTs, MA) --}}
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
                                        <div class="h-100 {{ $jadwal['persen'] == 100 ? 'bg-success' : 'bg-primary' }}" style="width: {{ $jadwal['persen'] }}%; border-radius: 100px;"></div>
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
                            @endif

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
                                    <div class="h-100 {{ $santri['persen'] >= 80 ? 'bg-success' : ($santri['persen'] >= 40 ? 'bg-warning' : 'bg-danger') }}" style="width: {{ $santri['persen'] }}%; border-radius: 100px;"></div>
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
                                        <span class="text-success fw-semibold" style="font-size: 0.74rem;"><i class="ti ti-check me-0.5"></i> 100% Lengkap</span>
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
                                    <div class="h-100 bg-primary" style="width: {{ $ploting['persen'] }}%; border-radius: 100px;"></div>
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
                                        <span class="text-success fw-semibold" style="font-size: 0.74rem;"><i class="ti ti-check me-0.5"></i> 100% Ter-plot</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Action Buttons --}}
                    <div class="pt-3 mt-3 border-top d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-1.5">
                            <div class="dropdown">
                                <button class="btn btn-xs btn-outline-secondary dropdown-toggle btn-action-unit" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-category me-1"></i> Menu Unit
                                </button>
                                <ul class="dropdown-menu shadow-lg border-0" style="font-size: 0.82rem; border-radius: 10px;">
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

                            {{-- Tombol Download Gambar --}}
                            <button type="button" class="btn btn-xs btn-outline-success btn-download-unit-card btn-action-unit d-flex align-items-center gap-1" data-card-id="card-unit-{{ $u->kode_unit }}" data-unit-name="{{ $u->nama_unit }}" title="Download Rekap Gambar untuk WhatsApp / Grup">
                                <i class="ti ti-download fs-6"></i> <span>Unduh</span>
                            </button>
                        </div>

                        <a href="{{ route('kelas.index', ['kode_unit_search' => $u->kode_unit, 'kode_ta' => $kode_ta]) }}" class="btn btn-xs btn-dark btn-action-unit d-flex align-items-center gap-1">
                            <span>Kelola</span> <i class="ti ti-arrow-right" style="font-size: 0.75rem;"></i>
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

{{-- Load html2canvas if not already loaded --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    $(document).off('click', '.btn-download-unit-card').on('click', '.btn-download-unit-card', function(e) {
        e.preventDefault();
        let $btn = $(this);
        let cardId = $btn.data('card-id');
        let unitName = $btn.data('unit-name') || 'Unit';
        let cardElement = document.getElementById(cardId);

        if (!cardElement) return;

        let originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span>');

        // Sembunyikan footer action button sementara agar gambar rekap bersih dan rapi
        let $footer = $(cardElement).find('.border-top:last');
        $footer.addClass('d-none');

        // Render card dengan background putih & resolusi tajam (scale 2)
        html2canvas(cardElement, {
            scale: 2.5,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#ffffff',
            logging: false
        }).then(function(canvas) {
            $footer.removeClass('d-none');
            $btn.prop('disabled', false).html(originalHtml);

            let link = document.createElement('a');
            let sanitizedName = unitName.replace(/[^a-zA-Z0-9]/g, '_');
            link.download = `Rekap_${sanitizedName}_TA_${new Date().toISOString().slice(0, 10)}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
        }).catch(function(err) {
            $footer.removeClass('d-none');
            $btn.prop('disabled', false).html(originalHtml);
            console.error(err);
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengunduh',
                    text: 'Terjadi kendala saat merender gambar rekap.',
                    customClass: { confirmButton: 'btn btn-danger' }
                });
            } else {
                alert('Gagal mengunduh gambar rekap.');
            }
        });
    });

    // Download Rekap Seluruh Unit Sekaligus
    $(document).off('click', '#btnDownloadAllUnits').on('click', '#btnDownloadAllUnits', function(e) {
        e.preventDefault();
        let $btn = $(this);
        let captureElement = document.getElementById('captureAllUnitsWrapper');

        if (!captureElement) return;

        let originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span> Menyiapkan Gambar...');

        // Sembunyikan elemen aksi interaktif agar gambar rekap bersih
        let $footers = $(captureElement).find('.clean-unit-card .border-top:last');
        let $drilldowns = $(captureElement).find('.drilldown-btn');
        let $headerAction = $('#headerActionRekap');

        $footers.addClass('d-none');
        $drilldowns.addClass('d-none');
        $headerAction.addClass('d-none');

        html2canvas(captureElement, {
            scale: 2,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#f8fafc',
            logging: false,
            windowWidth: 1400
        }).then(function(canvas) {
            $footers.removeClass('d-none');
            $drilldowns.removeClass('d-none');
            $headerAction.removeClass('d-none');
            $btn.prop('disabled', false).html(originalHtml);

            let link = document.createElement('a');
            let taName = '{{ $selectedTa ? str_replace('/', '-', $selectedTa->tahun_ajaran) : $kode_ta }}';
            link.download = `Rekap_Semua_Unit_TA_${taName}_${new Date().toISOString().slice(0, 10)}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Mengunduh',
                    text: 'Gambar rekapitulasi seluruh unit siap dibagikan.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        }).catch(function(err) {
            $footers.removeClass('d-none');
            $drilldowns.removeClass('d-none');
            $headerAction.removeClass('d-none');
            $btn.prop('disabled', false).html(originalHtml);
            console.error(err);
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengunduh',
                    text: 'Terjadi kendala saat merender gambar rekap seluruh unit.',
                    customClass: { confirmButton: 'btn btn-danger' }
                });
            } else {
                alert('Gagal mengunduh gambar rekap.');
            }
        });
    });
</script>


