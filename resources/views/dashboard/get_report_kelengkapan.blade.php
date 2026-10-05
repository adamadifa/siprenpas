{{-- Report Kelengkapan Data: 100% Pure Tailwind CSS Modern Dashboard Layout --}}
<div class="space-y-6">

    <!-- ================= 1. GLOBAL 4 KPI SUMMARY STATS (SINGLE SEAMLESS EMERALD GRADIENT CARD WITH TAPERED DIVIDERS & PROGRESS) ================= -->
    @if(isset($summary))
    <div class="rounded-2xl shadow-sm bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 text-white p-5 sm:p-6 border border-emerald-900/30 relative overflow-hidden">
        <!-- Background watermark -->
        <div class="absolute -right-8 -bottom-10 text-white/5 pointer-events-none">
            <i class="ti ti-chart-dots-3 text-[200px]"></i>
        </div>

        <div class="relative z-10 flex flex-wrap sm:flex-nowrap items-stretch justify-between gap-y-6">

            <!-- Segment 1: Total Santri -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Total Santri
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/20 text-white border border-white/25">
                            Semua
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5">
                        {{ number_format($summary['total_santri'] ?? 0, 0, ',', '.') }}
                    </div>
                </div>

                <div class="mt-3.5">
                    <!-- Progress Bar -->
                    @php
                        $persenMapel = ($summary['total_mapel'] ?? 0) > 0 ? round((($summary['total_mapel_aktif'] ?? 0) / $summary['total_mapel']) * 100) : 100;
                    @endphp
                    <div class="w-full h-1.5 bg-black/20 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-white/90 rounded-full transition-all duration-500" style="width: {{ $persenMapel }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-emerald-200/90">
                        <span class="font-medium text-[11px] flex items-center gap-1">
                            <i class="ti ti-book-2 text-xs opacity-70"></i>
                            <span>Mapel Aktif</span>
                        </span>
                        <span class="font-black text-white text-[10px] bg-white/20 px-2 py-0.5 rounded-md">
                            {{ $summary['total_mapel_aktif'] ?? 0 }} / {{ $summary['total_mapel'] ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 2: Kelengkapan Profil -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Profil Lengkap
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Santri
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5 flex items-baseline gap-1.5">
                        <span>{{ $summary['persen_santri_lengkap'] ?? 0 }}%</span>
                        <span class="text-xs font-semibold text-emerald-200">selesai</span>
                    </div>
                </div>

                <div class="mt-3.5">
                    <!-- Progress Bar -->
                    <div class="w-full h-1.5 bg-black/20 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-white/90 rounded-full transition-all duration-500" style="width: {{ $summary['persen_santri_lengkap'] ?? 0 }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-emerald-200/90">
                        <span class="font-medium text-[11px] flex items-center gap-1">
                            <i class="ti ti-id-badge text-xs opacity-70"></i>
                            <span>Santri Lengkap</span>
                        </span>
                        <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                            {{ number_format($summary['total_santri_lengkap'] ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 3: Ploting Rombel -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Ploting Rombel
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Kelas
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5 flex items-baseline gap-1.5">
                        <span>{{ $summary['persen_santri_plotted'] ?? 0 }}%</span>
                        <span class="text-xs font-semibold text-emerald-200">terplot</span>
                    </div>
                </div>

                <div class="mt-3.5">
                    <!-- Progress Bar -->
                    <div class="w-full h-1.5 bg-black/20 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-white/90 rounded-full transition-all duration-500" style="width: {{ $summary['persen_santri_plotted'] ?? 0 }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-emerald-200/90">
                        <span class="font-medium text-[11px] flex items-center gap-1">
                            <i class="ti ti-layout-grid text-xs opacity-70"></i>
                            <span>Masuk Rombel</span>
                        </span>
                        <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                            {{ number_format($summary['total_santri_plotted'] ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Tapered Vertical Divider Line -->
            <div class="hidden sm:block w-[1px] bg-gradient-to-b from-transparent via-white/35 to-transparent self-center h-16 shrink-0"></div>

            <!-- Segment 4: Kesiapan Jadwal -->
            <div class="flex-1 min-w-[140px] sm:min-w-[160px] px-3 sm:px-4 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 truncate">
                            Kesiapan Jadwal
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-white/15 text-emerald-100 border border-white/20">
                            Jadwal
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight mt-1.5 flex items-baseline gap-1.5">
                        <span>{{ $summary['persen_jadwal'] ?? 0 }}%</span>
                        <span class="text-xs font-semibold text-emerald-200">terjadwal</span>
                    </div>
                </div>

                <div class="mt-3.5">
                    <!-- Progress Bar -->
                    <div class="w-full h-1.5 bg-black/20 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-white/90 rounded-full transition-all duration-500" style="width: {{ $summary['persen_jadwal'] ?? 0 }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-emerald-200/90">
                        <span class="font-medium text-[11px] flex items-center gap-1">
                            <i class="ti ti-calendar-time text-xs opacity-70"></i>
                            <span>Rombel Siap</span>
                        </span>
                        <span class="font-black text-white text-[10px] bg-white/15 px-2 py-0.5 rounded-md">
                            {{ $summary['total_kelas_jadwal'] ?? 0 }} / {{ $summary['total_kelas'] ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endif

    <!-- ================= 2. UNIT / JENJANG CARDS GRID ================= -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 sm:gap-6">
        @forelse ($reportData as $data)
            @php
                $score = $data['overall_score'];
                if ($score >= 80) {
                    $scoreBadge = 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-xs shadow-emerald-500/20';
                    $scoreLabel = 'Sangat Siap';
                    $cardBorder = 'border-slate-200/90 hover:border-emerald-300';
                } elseif ($score >= 50) {
                    $scoreBadge = 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-xs shadow-amber-500/20';
                    $scoreLabel = 'Cukup Siap';
                    $cardBorder = 'border-slate-200/90 hover:border-amber-300';
                } else {
                    $scoreBadge = 'bg-gradient-to-r from-rose-500 to-red-500 text-white shadow-xs shadow-rose-500/20';
                    $scoreLabel = 'Perlu Tindakan';
                    $cardBorder = 'border-slate-200/90 hover:border-rose-300';
                }

                // Resolve Unit Logo
                $logoSrc = null;
                if (!empty($data['unit']->logo) && Storage::disk('public')->exists($data['unit']->logo)) {
                    $logoSrc = asset('storage/' . $data['unit']->logo);
                } elseif (!empty($data['unit']->logo) && file_exists(public_path('storage/' . $data['unit']->logo))) {
                    $logoSrc = asset('storage/' . $data['unit']->logo);
                } else {
                    $namaLower = strtolower($data['unit']->nama_unit);
                    if (str_contains($namaLower, 'tk') || str_contains($namaLower, 'calisa') || str_contains($namaLower, 'rabbani')) {
                        $logoSrc = asset('assets/img/logo/tk.png');
                    } elseif (str_contains($namaLower, 'sd') || str_contains($namaLower, 'sdit')) {
                        $logoSrc = asset('assets/img/logo/sdit.png');
                    } elseif (str_contains($namaLower, 'mdu')) {
                        $logoSrc = asset('assets/img/logo/mdu.png');
                    } elseif (str_contains($namaLower, 'mts')) {
                        $logoSrc = asset('assets/img/logo/mts.png');
                    } elseif (str_contains($namaLower, 'ma') || str_contains($namaLower, 'aliyah')) {
                        $logoSrc = asset('assets/img/logo/ma.png');
                    } elseif (str_contains($namaLower, 'asrama') || str_contains($namaLower, 'pesantren')) {
                        $logoSrc = asset('assets/img/logo/asrama.png');
                    } elseif (file_exists(public_path('assets/img/logo/persisalamin.png'))) {
                        $logoSrc = asset('assets/img/logo/persisalamin.png');
                    }
                }
            @endphp

            <div class="bg-white border {{ $cardBorder }} rounded-2xl p-5 sm:p-6 shadow-xs hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between group">
                
                <div>
                    <!-- Unit Header -->
                    <div class="flex items-start justify-between gap-3 pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200/90 shadow-2xs flex items-center justify-center p-1.5 overflow-hidden shrink-0 group-hover:scale-105 group-hover:border-slate-300 transition-all duration-300">
                                @if ($logoSrc)
                                    <img src="{{ $logoSrc }}" alt="Logo {{ $data['unit']->nama_unit }}" class="w-full h-full object-contain filter drop-shadow-2xs">
                                @else
                                    <div class="w-full h-full rounded-xl bg-gradient-to-tr from-slate-100 to-slate-200 flex items-center justify-center font-black text-slate-700 text-xs tracking-wider uppercase">
                                        {{ substr($data['unit']->nama_unit, 0, 3) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-tight truncate" title="{{ $data['unit']->nama_unit }}">
                                    {{ $data['unit']->nama_unit }}
                                </h3>
                                <p class="text-[11px] font-semibold text-slate-400 mt-0.5">Kode: {{ $data['unit']->kode_unit }}</p>
                            </div>
                        </div>

                        <!-- Overall Score Badge -->
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black {{ $scoreBadge }} shrink-0">
                            <i class="ti ti-chart-donut text-sm"></i>
                            <span>{{ $score }}%</span>
                        </div>
                    </div>

                    <!-- 4 Pillars Breakdown Rows -->
                    <div class="py-3.5 space-y-3">

                        <!-- 1. Kurikulum & Mapel -->
                        <div class="flex items-center justify-between text-xs py-1">
                            <div class="flex items-center gap-2.5 text-slate-700 font-medium">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 border border-slate-200/80 flex items-center justify-center text-sm shrink-0">
                                    <i class="ti ti-books"></i>
                                </div>
                                <span>Kurikulum / Mapel</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-800">{{ $data['mapel']['aktif'] }} Aktif</span>
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md {{ $data['mapel']['aktif'] > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                    {{ $data['mapel']['status'] }}
                                </span>
                            </div>
                        </div>

                        <!-- 2. Jadwal Pelajaran -->
                        @if($data['has_jadwal'])
                            <div class="text-xs py-1 border-t border-slate-50">
                                <div class="flex items-center justify-between mb-1.5">
                                    <div class="flex items-center gap-2.5 text-slate-700 font-medium">
                                        <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 border border-slate-200/80 flex items-center justify-center text-sm shrink-0">
                                            <i class="ti ti-calendar-time"></i>
                                        </div>
                                        <span>Jadwal Pelajaran</span>
                                    </div>
                                    <button type="button" 
                                            class="btn-view-jadwal text-[11px] font-bold text-slate-700 hover:text-emerald-700 hover:underline inline-flex items-center gap-1 cursor-pointer" 
                                            data-kode-unit="{{ $data['unit']->kode_unit }}">
                                        <span>{{ $data['jadwal']['kelas_terjadwal'] }}/{{ $data['jadwal']['total_kelas'] }} Kelas</span>
                                        <i class="ti ti-chevron-right text-[10px]"></i>
                                    </button>
                                </div>
                                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-600 rounded-full transition-all duration-500" style="width: {{ $data['jadwal']['persen'] }}%"></div>
                                </div>
                            </div>
                        @endif

                        <!-- 3. Kelengkapan Santri -->
                        <div class="text-xs py-1 border-t border-slate-50">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2.5 text-slate-700 font-medium">
                                    <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 border border-slate-200/80 flex items-center justify-center text-sm shrink-0">
                                        <i class="ti ti-id-badge"></i>
                                    </div>
                                    <span>Kelengkapan Berkas</span>
                                </div>
                                <button type="button" 
                                        class="btn-view-santri-belum-lengkap text-[11px] font-bold {{ $data['santri']['belum_lengkap'] > 0 ? 'text-amber-600 hover:text-amber-800' : 'text-slate-700 hover:text-emerald-700' }} hover:underline inline-flex items-center gap-1 cursor-pointer" 
                                        data-kode-unit="{{ $data['unit']->kode_unit }}">
                                    <span>{{ $data['santri']['lengkap'] }}/{{ $data['santri']['total'] }} Santri</span>
                                    @if($data['santri']['belum_lengkap'] > 0)
                                        <span class="px-1.5 py-0.2 bg-amber-50 text-amber-700 border border-amber-200/80 rounded text-[9px] font-bold">({{ $data['santri']['belum_lengkap'] }} Belum)</span>
                                    @endif
                                </button>
                            </div>
                            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-600 rounded-full transition-all duration-500" style="width: {{ $data['santri']['persen'] }}%"></div>
                            </div>
                        </div>

                        <!-- 4. Ploting Kelas -->
                        <div class="text-xs py-1 border-t border-slate-50">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2.5 text-slate-700 font-medium">
                                    <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 border border-slate-200/80 flex items-center justify-center text-sm shrink-0">
                                        <i class="ti ti-users-group"></i>
                                    </div>
                                    <span>Ploting Rombel</span>
                                </div>
                                <button type="button" 
                                        class="btn-view-santri-belum-plot text-[11px] font-bold {{ $data['ploting']['belum_plotted'] > 0 ? 'text-amber-600 hover:text-amber-800' : 'text-slate-700 hover:text-emerald-700' }} hover:underline inline-flex items-center gap-1 cursor-pointer" 
                                        data-kode-unit="{{ $data['unit']->kode_unit }}">
                                    <span>{{ $data['ploting']['plotted'] }}/{{ $data['ploting']['total'] }} Santri</span>
                                    @if($data['ploting']['belum_plotted'] > 0)
                                        <span class="px-1.5 py-0.2 bg-amber-50 text-amber-700 border border-amber-200/80 rounded text-[9px] font-bold">({{ $data['ploting']['belum_plotted'] }} Belum)</span>
                                    @endif
                                </button>
                            </div>
                            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-600 rounded-full transition-all duration-500" style="width: {{ $data['ploting']['persen'] }}%"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Unit Action Footer -->
                <div class="pt-3.5 border-t border-slate-100 flex items-center justify-between gap-2 mt-2">
                    <span class="text-[11px] text-slate-400 font-medium">Status: <b class="text-slate-800">{{ $scoreLabel }}</b></span>
                    <div class="flex items-center gap-1.5">
                        <button type="button" 
                                class="btn-view-santri-belum-lengkap px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-[11px] font-bold rounded-xl shadow-2xs transition active:scale-95 cursor-pointer flex items-center gap-1"
                                data-kode-unit="{{ $data['unit']->kode_unit }}"
                                title="Lihat Santri Belum Lengkap">
                            <i class="ti ti-list-details text-xs"></i>
                            <span>Detail Santri</span>
                        </button>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full bg-white border border-slate-200/80 rounded-2xl p-10 text-center text-slate-400">
                <i class="ti ti-folder-x text-4xl block mb-2 mx-auto"></i>
                <p class="text-xs font-semibold">Tidak ada data unit yang dapat ditampilkan.</p>
            </div>
        @endforelse
    </div>

</div>
