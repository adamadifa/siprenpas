@extends('layouts.app')
@section('titlepage', 'Detail Penilaian Siswa')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle with Back Button -->
        <div class="flex items-center gap-3">
            <a href="{{ route('rapor-siswa.show', $jadwal->kode_kelas) }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200/90 text-slate-700 hover:text-emerald-700 hover:bg-emerald-50 hover:border-emerald-200 flex items-center justify-center transition shrink-0 shadow-xs" title="Kembali">
                <i class="ti ti-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>Detail Penilaian Siswa</span>
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Pemantauan rincian capaian nilai siswa (Read-Only)
                </p>
            </div>
        </div>

        <!-- Right Side: Breadcrumb Navigation -->
        <div class="flex flex-col md:items-end">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('rapor-siswa.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-file-analytics text-sm"></i>
                    <span>Rapor Siswa</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Rincian Nilai</span>
            </nav>
        </div>
    </div>

    <!-- ================= 2. INFO & BOBOT CARDS ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-3.5 sm:gap-4 items-stretch">
        <!-- Info Mapel -->
        <div class="lg:col-span-8 bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs flex items-center">
            <div class="flex items-center gap-3.5 flex-wrap">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center text-2xl shrink-0">
                    <i class="ti ti-book-2"></i>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900">{{ $jadwal->mapel->nama_matpel ?? '-' }}</h3>
                    <div class="flex items-center gap-2 mt-1 flex-wrap">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-slate-100 text-slate-700">
                            Kelas: {{ $jadwal->kelas->nama_kelas ?? '-' }}
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                            Guru: {{ $jadwal->guru->nama_guru ?? '-' }}
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Semester {{ (($activeSemester->semester ?? $jadwal->semester) == 1) ? '1 (Ganjil)' : '2 (Genap)' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bobot Penilaian (Read-Only) -->
        <div class="lg:col-span-4 bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden flex flex-col">
            <div class="px-4 py-2 bg-emerald-600 text-white text-center text-xs font-bold uppercase tracking-wider">
                Komposisi Bobot Nilai (100%)
            </div>
            <div class="p-4 flex items-center justify-around text-center flex-1">
                <div>
                    <span class="text-xs text-slate-400 font-medium block mb-0.5">Bobot Sumatif</span>
                    <span class="text-xl font-black text-emerald-600">{{ $bobot->bobot_sumatif }}%</span>
                </div>
                <div class="h-8 border-r border-slate-200"></div>
                <div>
                    <span class="text-xs text-slate-400 font-medium block mb-0.5">Bobot SAS</span>
                    <span class="text-xl font-black text-sky-600">{{ $bobot->bobot_sas }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= 3. TABBED CONTENT CONTAINER ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Seamless Green Tab Navigation Bar -->
        <div class="bg-emerald-700 px-4 pt-3 flex border-b border-emerald-600/70 gap-2 overflow-x-auto text-white">
            <button type="button" id="tabBtnRekap" class="tab-btn-detail px-5 py-3 text-xs sm:text-sm font-bold bg-emerald-600 text-white rounded-t-xl flex items-center gap-2 transition cursor-pointer shadow-xs border-t border-x border-emerald-500/50">
                <i class="ti ti-chart-bar text-base"></i>
                <span>Rekapitulasi Rapor</span>
            </button>

            <button type="button" id="tabBtnSumatif" class="tab-btn-detail px-5 py-3 text-xs sm:text-sm font-semibold bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 rounded-t-xl flex items-center gap-2 transition cursor-pointer">
                <i class="ti ti-notebook text-base"></i>
                <span>Rincian Sumatif</span>
            </button>

            <button type="button" id="tabBtnSas" class="tab-btn-detail px-5 py-3 text-xs sm:text-sm font-semibold bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 rounded-t-xl flex items-center gap-2 transition cursor-pointer">
                <i class="ti ti-file-certificate text-base"></i>
                <span>Rincian SAS</span>
            </button>
        </div>

        <!-- Toolbar & Search -->
        <div class="px-5 py-3 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white">
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-100">
                <i class="ti ti-info-circle text-base"></i>
                <span>Menampilkan nilai lengkap siswa untuk kelas dan semester aktif.</span>
            </div>

            <div class="relative w-full sm:w-64">
                <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-emerald-200 text-sm pointer-events-none"></i>
                <input type="text" id="searchInput" placeholder="Cari siswa atau NIS..." class="w-full pl-8 pr-3 py-1.5 text-xs bg-white/15 hover:bg-white/20 focus:bg-white text-white focus:text-slate-900 placeholder-emerald-100 focus:placeholder-slate-400 border border-white/20 rounded-lg outline-none transition">
            </div>
        </div>

        <!-- ================= PANEL 1: REKAPITULASI RAPOR ================= -->
        <div id="tabPanelRekap" class="tab-panel-detail block">
            <div class="overflow-x-auto bg-emerald-600">
                <table class="w-full text-left text-xs border-0 border-collapse" id="rekapTable">
                    <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-b border-emerald-700/80">
                        <tr>
                            <th class="py-2 px-3 text-center w-12 text-white">NO</th>
                            <th class="py-2 px-3 text-white w-28">NIS</th>
                            <th class="py-2 px-3 text-white">NAMA LENGKAP SISWA</th>
                            <th class="py-2 px-3 text-center text-white w-28">RATA SUMATIF</th>
                            <th class="py-2 px-3 text-center text-white w-24">NILAI SAS</th>
                            <th class="py-2 px-3 text-center text-white w-28">NILAI RAPOR</th>
                            <th class="py-2 px-3 text-white">DESKRIPSI CAPAIAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white text-slate-700 font-medium">
                        @forelse ($students as $index => $student)
                            <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-emerald-50/50 transition-colors searchable-row">
                                <td class="py-2 px-3 text-center text-slate-400 font-bold text-xs">{{ $index + 1 }}</td>
                                <td class="py-2 px-3 font-mono font-bold text-slate-800 text-xs">{{ $student->nis ?? '-' }}</td>
                                <td class="py-2 px-3 font-bold text-slate-900 text-xs sm:text-sm">{{ $student->nama_lengkap }}</td>
                                <td class="py-2 px-3 text-center font-bold text-slate-800">{{ $student->rata_sumatif }}</td>
                                <td class="py-2 px-3 text-center font-bold text-slate-800">{{ $student->nilai_sas }}</td>
                                <td class="py-2 px-3 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-black shadow-2xs {{ $student->nilai_rapor >= 75 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/80' : 'bg-rose-50 text-rose-700 border border-rose-200/80' }}">
                                        {{ $student->nilai_rapor }}
                                    </span>
                                </td>
                                <td class="py-2 px-3 text-slate-500 text-[11px] leading-snug max-w-sm">
                                    <span class="line-clamp-2">{{ strip_tags($student->capaian_kompetensi) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10 text-slate-400 text-xs">Belum ada data siswa untuk kelas ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= PANEL 2: RINCIAN SUMATIF ================= -->
        <div id="tabPanelSumatif" class="tab-panel-detail hidden">
            @php
                $rencanaSumatif = $rencanaPenilaian->where('kategori_penilaian', 'SUMATIF');
            @endphp
            <div class="overflow-x-auto bg-emerald-600">
                <table class="w-full text-left text-xs border-0 border-collapse" id="sumatifTable">
                    <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-b border-emerald-700/80">
                        <tr>
                            <th class="py-2 px-3 text-center w-12 text-white">NO</th>
                            <th class="py-2 px-3 text-white w-28">NIS</th>
                            <th class="py-2 px-3 text-white">NAMA LENGKAP SISWA</th>
                            @forelse ($rencanaSumatif as $rencana)
                                <th class="py-1.5 px-3 text-center text-white min-w-20">
                                    <span class="block font-bold text-[11px]">{{ $rencana->kode_penilaian }}</span>
                                    <span class="text-[9px] text-emerald-200 font-normal leading-tight block">{{ $rencana->nama_penilaian }}</span>
                                </th>
                            @empty
                                <th class="py-2 px-3 text-center text-white">RENCANA PENILAIAN</th>
                            @endforelse
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white text-slate-700 font-medium">
                        @forelse ($students as $index => $student)
                            <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-emerald-50/50 transition-colors searchable-row">
                                <td class="py-2 px-3 text-center text-slate-400 font-bold text-xs">{{ $index + 1 }}</td>
                                <td class="py-2 px-3 font-mono font-bold text-slate-800 text-xs">{{ $student->nis ?? '-' }}</td>
                                <td class="py-2 px-3 font-bold text-slate-900 text-xs sm:text-sm">{{ $student->nama_lengkap }}</td>
                                @forelse ($rencanaSumatif as $rencana)
                                    @php
                                        $score = $mappedGrades[$student->id_siswa][$rencana->id] ?? null;
                                    @endphp
                                    <td class="py-2 px-3 text-center font-bold text-xs">
                                        @if($score !== null)
                                            <span class="{{ $score < 75 ? 'text-rose-600 font-black' : 'text-emerald-700' }}">{{ number_format($score, 0) }}</span>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                @empty
                                    <td class="py-2 px-3 text-center text-slate-400 text-xs italic">Belum ada rencana penilaian sumatif.</td>
                                @endforelse
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 3 + max(1, $rencanaSumatif->count()) }}" class="text-center py-10 text-slate-400 text-xs">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= PANEL 3: RINCIAN SAS ================= -->
        <div id="tabPanelSas" class="tab-panel-detail hidden">
            @php
                $rencanaSas = $rencanaPenilaian->where('kategori_penilaian', 'SAS');
            @endphp
            <div class="overflow-x-auto bg-emerald-600">
                <table class="w-full text-left text-xs border-0 border-collapse" id="sasTable">
                    <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-b border-emerald-700/80">
                        <tr>
                            <th class="py-2 px-3 text-center w-12 text-white">NO</th>
                            <th class="py-2 px-3 text-white w-28">NIS</th>
                            <th class="py-2 px-3 text-white">NAMA LENGKAP SISWA</th>
                            @forelse ($rencanaSas as $rencana)
                                <th class="py-1.5 px-3 text-center text-white min-w-20">
                                    <span class="block font-bold text-[11px]">{{ $rencana->kode_penilaian }}</span>
                                    <span class="text-[9px] text-emerald-200 font-normal leading-tight block">{{ $rencana->nama_penilaian }}</span>
                                </th>
                            @empty
                                <th class="py-2 px-3 text-center text-white">RENCANA PENILAIAN</th>
                            @endforelse
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white text-slate-700 font-medium">
                        @forelse ($students as $index => $student)
                            <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-emerald-50/50 transition-colors searchable-row">
                                <td class="py-2 px-3 text-center text-slate-400 font-bold text-xs">{{ $index + 1 }}</td>
                                <td class="py-2 px-3 font-mono font-bold text-slate-800 text-xs">{{ $student->nis ?? '-' }}</td>
                                <td class="py-2 px-3 font-bold text-slate-900 text-xs sm:text-sm">{{ $student->nama_lengkap }}</td>
                                @forelse ($rencanaSas as $rencana)
                                    @php
                                        $score = $mappedGrades[$student->id_siswa][$rencana->id] ?? null;
                                    @endphp
                                    <td class="py-2 px-3 text-center font-bold text-xs">
                                        @if($score !== null)
                                            <span class="{{ $score < 75 ? 'text-rose-600 font-black' : 'text-emerald-700' }}">{{ number_format($score, 0) }}</span>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                @empty
                                    <td class="py-2 px-3 text-center text-slate-400 text-xs italic">Belum ada rencana penilaian SAS.</td>
                                @endforelse
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 3 + max(1, $rencanaSas->count()) }}" class="text-center py-10 text-slate-400 text-xs">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('myscript')
<script>
    $(function() {
        // Tab switcher
        $('#tabBtnRekap').on('click', function() {
            $('.tab-btn-detail').removeClass('bg-emerald-600 text-white font-bold border-t border-x border-emerald-500/50 shadow-xs')
                .addClass('bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 font-semibold border-none');
            $(this).removeClass('bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 font-semibold border-none')
                .addClass('bg-emerald-600 text-white font-bold border-t border-x border-emerald-500/50 shadow-xs');
            $('.tab-panel-detail').addClass('hidden').removeClass('block');
            $('#tabPanelRekap').removeClass('hidden').addClass('block');
        });

        $('#tabBtnSumatif').on('click', function() {
            $('.tab-btn-detail').removeClass('bg-emerald-600 text-white font-bold border-t border-x border-emerald-500/50 shadow-xs')
                .addClass('bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 font-semibold border-none');
            $(this).removeClass('bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 font-semibold border-none')
                .addClass('bg-emerald-600 text-white font-bold border-t border-x border-emerald-500/50 shadow-xs');
            $('.tab-panel-detail').addClass('hidden').removeClass('block');
            $('#tabPanelSumatif').removeClass('hidden').addClass('block');
        });

        $('#tabBtnSas').on('click', function() {
            $('.tab-btn-detail').removeClass('bg-emerald-600 text-white font-bold border-t border-x border-emerald-500/50 shadow-xs')
                .addClass('bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 font-semibold border-none');
            $(this).removeClass('bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 font-semibold border-none')
                .addClass('bg-emerald-600 text-white font-bold border-t border-x border-emerald-500/50 shadow-xs');
            $('.tab-panel-detail').addClass('hidden').removeClass('block');
            $('#tabPanelSas').removeClass('hidden').addClass('block');
        });

        // Search in rows
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".searchable-row").filter(function() {
                var match = $(this).text().toLowerCase().indexOf(value) > -1;
                $(this).toggle(match);
            });
        });
    });
</script>
@endpush
@endsection
