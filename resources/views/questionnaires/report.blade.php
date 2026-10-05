@extends('layouts.app')
@section('titlepage', 'Hasil Rekapitulasi Kuisioner')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-chart-bar text-2xl"></i>
                </div>
                <span>Hasil Rekapitulasi Kuisioner</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Laporan statistik jawaban responden dan persentase pilihan untuk instrumen survei
            </p>
        </div>

        <!-- Right Side: Breadcrumb Navigation & Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('admin.questionnaires.index') }}" class="hover:text-slate-700 transition">Kuisioner</a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Hasil Rekap</span>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.questionnaires.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200 shadow-2xs transition active:scale-95">
                    <i class="ti ti-arrow-left text-base text-slate-500"></i>
                    <span>Kembali</span>
                </a>
                <a href="{{ route('admin.questionnaires.questions.index', $questionnaire->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition active:scale-95">
                    <i class="ti ti-list-details text-base"></i>
                    <span>Kelola Soal</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================= 2. EXECUTIVE HERO SUMMARY BANNER ================= -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-700 text-white p-5 sm:p-6 shadow-md border border-emerald-900/40">
        <div class="absolute -right-6 -bottom-8 opacity-10 pointer-events-none text-white">
            <i class="ti ti-chart-pie text-[150px]"></i>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div class="max-w-2xl space-y-1.5">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/20 border border-white/20 text-[11px] font-bold tracking-wide uppercase">
                    <i class="ti ti-survey text-xs"></i>
                    <span>Instrumen Survei Aktif</span>
                </div>
                <h2 class="text-lg sm:text-xl font-black tracking-tight leading-snug">
                    {{ $questionnaire->title }}
                </h2>
                <p class="text-xs text-emerald-100/90 leading-relaxed">
                    {{ $questionnaire->description ?: 'Instrumen evaluasi dan survei kepuasan layanan.' }}
                </p>
            </div>

            <!-- Stats Highlight Chips -->
            <div class="grid grid-cols-2 gap-3 shrink-0">
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/15 text-center min-w-[110px]">
                    <div class="text-[10px] uppercase font-bold text-emerald-200 tracking-wider">Total Responden</div>
                    <div class="text-xl sm:text-2xl font-black mt-0.5">
                        {{ $questionnaire->respondents_count ?? (isset($totalRespondents) ? $totalRespondents : ($questionnaire->respondents ? $questionnaire->respondents->count() : 0)) }}
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/15 text-center min-w-[110px]">
                    <div class="text-[10px] uppercase font-bold text-emerald-200 tracking-wider">Total Soal</div>
                    <div class="text-xl sm:text-2xl font-black mt-0.5">
                        {{ count($reportData) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= 3. QUESTIONS REPORT GRID ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        @forelse($reportData as $i => $q)
            @php
                $totalAnswersInQuestion = collect($q['options'])->sum('count');
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col justify-between">
                <!-- Question Header -->
                <div>
                    <div class="bg-slate-50/80 px-4 py-3 border-b border-slate-200/80 flex items-start gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-black text-xs flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                            {{ $i + 1 }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xs sm:text-sm font-extrabold text-slate-800 leading-snug">
                                {{ $q['question'] }}
                            </h3>
                            <span class="text-[11px] font-semibold text-slate-400 mt-0.5 block">
                                Total Respons: <strong class="text-slate-700">{{ $totalAnswersInQuestion }} jawaban</strong>
                            </span>
                        </div>
                    </div>

                    <!-- Breakdown Table & Progress -->
                    <div class="p-4 space-y-3">
                        <div class="space-y-2">
                            @foreach($q['options'] as $idx => $opt)
                                @php
                                    $pct = $totalAnswersInQuestion > 0 ? round(($opt['count'] / $totalAnswersInQuestion) * 100, 1) : 0;
                                @endphp
                                <div class="p-2.5 rounded-xl bg-slate-50/60 border border-slate-100 hover:border-emerald-200 transition">
                                    <div class="flex items-center justify-between gap-2 text-xs mb-1.5">
                                        <div class="flex items-center gap-2 font-bold text-slate-800">
                                            <span class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-black flex items-center justify-center shrink-0">
                                                {{ chr(65 + $idx) }}
                                            </span>
                                            <span class="truncate max-w-[200px] sm:max-w-xs">{{ $opt['option'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 shrink-0">
                                            <span class="font-extrabold text-slate-900 text-xs">{{ $opt['count'] }} suara</span>
                                            <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-black">
                                                {{ $pct }}%
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-2 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- ApexCharts Sparkline Section -->
                <div class="px-4 pb-4 pt-1 bg-slate-50/40 border-t border-slate-100">
                    <div class="flex items-center justify-between text-[11px] font-bold text-slate-400 mb-1">
                        <span>Distribusi Grafik</span>
                        <i class="ti ti-chart-histogram text-emerald-600"></i>
                    </div>
                    <div id="chart-{{ $i }}" class="w-full" style="min-height: 140px;"></div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-2xl border border-slate-200">
                <i class="ti ti-chart-pie-off text-5xl mb-2 text-slate-300 block"></i>
                <h4 class="text-sm font-bold text-slate-700">Belum Ada Data Hasil Kuisioner</h4>
                <p class="text-xs text-slate-400 mt-1">Belum ada pertanyaan atau responden yang mengisi survei ini.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection

@push('myscript')
<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeColors = ['#059669', '#0d9488', '#0284c7', '#6366f1', '#8b5cf6', '#d97706', '#e11d48'];
        @foreach($reportData as $i => $q)
        var options{{ $i }} = {
            chart: {
                type: 'bar',
                height: 140,
                fontFamily: 'Inter, sans-serif',
                toolbar: { show: false },
                sparkline: { enabled: false }
            },
            series: [{
                name: 'Jumlah Responden',
                data: {!! json_encode(collect($q['options'])->pluck('count')) !!}
            }],
            xaxis: {
                categories: {!! json_encode(collect($q['options'])->map(function($o, $k) { return chr(65 + $k); })) !!},
                labels: { 
                    style: { 
                        fontSize: '11px',
                        fontWeight: 700,
                        colors: '#64748b'
                    } 
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: { fontSize: '10px', colors: '#94a3b8' }
                }
            },
            plotOptions: {
                bar: {
                    distributed: true,
                    horizontal: false,
                    columnWidth: '45%',
                    borderRadius: 6
                }
            },
            dataLabels: { 
                enabled: true,
                style: {
                    fontSize: '11px',
                    fontWeight: 'bold',
                    colors: ['#ffffff']
                }
            },
            colors: themeColors,
            grid: { 
                borderColor: '#f1f5f9',
                strokeDashArray: 4
            },
            legend: { show: false },
            tooltip: { 
                theme: 'light',
                y: {
                    formatter: function (val) {
                        return val + " responden";
                    }
                }
            }
        };
        var chart{{ $i }} = new ApexCharts(document.querySelector("#chart-{{ $i }}"), options{{ $i }});
        chart{{ $i }}.render();
        @endforeach
    });
</script>
@endpush
