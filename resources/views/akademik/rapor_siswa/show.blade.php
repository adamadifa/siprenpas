@extends('layouts.app')
@section('titlepage', 'Detail Progress Rapor')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle with Back Button -->
        <div class="flex items-center gap-3">
            <a href="{{ route('rapor-siswa.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200/90 text-slate-700 hover:text-emerald-700 hover:bg-emerald-50 hover:border-emerald-200 flex items-center justify-center transition shrink-0 shadow-xs" title="Kembali">
                <i class="ti ti-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>Detail Progress Rapor - Kelas {{ $class->nama_kelas }}</span>
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Monitoring kelengkapan penilaian mata pelajaran &amp; cetak rapor siswa
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
                <span class="font-bold text-slate-800">Detail Kelas</span>
            </nav>
        </div>
    </div>

    @php
        $totalMapel = $monitoringData->count();
        $completedMapel = $monitoringData->where('completion_rate', 100)->count();
        $avgMapelProgress = $totalMapel > 0 ? round($monitoringData->avg('completion_rate')) : 0;
        $totalSiswa = $students->count();
    @endphp

    <!-- ================= 2. CLASS STATISTIC CARDS ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
        <!-- Card 1: Kelas & Unit -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 shadow-xs hover:border-slate-300 hover:shadow-sm transition-all duration-200">
            <div class="flex items-start justify-between gap-3">
                <div class="space-y-1">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Rombel / Kelas</span>
                    <div class="flex items-baseline gap-1.5">
                        <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $class->nama_kelas }}</h3>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100/80 flex items-center justify-center text-xl shrink-0">
                    <i class="ti ti-chalkboard"></i>
                </div>
            </div>

            <div class="mt-3.5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500 font-medium flex items-center gap-1.5">
                    <i class="ti ti-building text-emerald-600"></i>
                    <span>Unit Jenjang</span>
                </span>
                <span class="font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200/60 text-[11px]">
                    {{ $class->unit->nama_unit ?? '-' }}
                </span>
            </div>
        </div>

        <!-- Card 2: Wali Kelas -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 shadow-xs hover:border-slate-300 hover:shadow-sm transition-all duration-200">
            <div class="flex items-start justify-between gap-3">
                <div class="space-y-1">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Wali Kelas</span>
                    <h4 class="text-base font-bold text-slate-900 line-clamp-1 mt-0.5">{{ $class->waliKelas->nama_guru ?? 'Belum Ditentukan' }}</h4>
                </div>
                <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-700 border border-sky-100/80 flex items-center justify-center text-xl shrink-0">
                    <i class="ti ti-user-check"></i>
                </div>
            </div>

            <div class="mt-3.5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500 font-medium flex items-center gap-1.5">
                    <i class="ti ti-calendar text-sky-600"></i>
                    <span>Tahun Ajaran</span>
                </span>
                <span class="font-bold text-sky-700 bg-sky-50 px-2 py-0.5 rounded-md border border-sky-200/60 text-[11px]">
                    {{ $activeTa->tahun_ajaran ?? '-' }}
                </span>
            </div>
        </div>

        <!-- Card 3: Total Siswa -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 shadow-xs hover:border-slate-300 hover:shadow-sm transition-all duration-200">
            <div class="flex items-start justify-between gap-3">
                <div class="space-y-1">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Total Siswa</span>
                    <div class="flex items-baseline gap-1.5">
                        <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $totalSiswa }}</h3>
                        <span class="text-xs font-bold text-slate-400">Siswa Terdaftar</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-100/80 flex items-center justify-center text-xl shrink-0">
                    <i class="ti ti-users"></i>
                </div>
            </div>

            <div class="mt-3.5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500 font-medium flex items-center gap-1.5">
                    <i class="ti ti-file-text text-indigo-600"></i>
                    <span>Status Rapor</span>
                </span>
                <span class="font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-md border border-indigo-200/60 text-[11px]">
                    Siap Dicetak
                </span>
            </div>
        </div>

        <!-- Card 4: Kelengkapan Mapel -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 shadow-xs hover:border-slate-300 hover:shadow-sm transition-all duration-200">
            <div class="flex items-start justify-between gap-3">
                <div class="space-y-1">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Kelengkapan Mapel</span>
                    <div class="flex items-baseline gap-1.5">
                        <h3 class="text-2xl sm:text-3xl font-black {{ $completedMapel == $totalMapel && $totalMapel > 0 ? 'text-emerald-600' : 'text-amber-500' }} tracking-tight">{{ $completedMapel }}</h3>
                        <span class="text-xs font-bold text-slate-400">/ {{ $totalMapel }} Mapel</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 border border-teal-100/80 flex items-center justify-center text-xl shrink-0">
                    <i class="ti ti-circle-check"></i>
                </div>
            </div>

            <div class="mt-3.5 pt-3 border-t border-slate-100">
                <div class="flex items-center justify-between text-xs mb-1.5">
                    <span class="text-slate-500 font-medium">Tingkat Kelengkapan</span>
                    <span class="font-bold text-[11px] {{ $avgMapelProgress >= 80 ? 'text-emerald-700' : ($avgMapelProgress >= 50 ? 'text-amber-700' : 'text-rose-700') }}">
                        {{ $avgMapelProgress }}%
                    </span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500 {{ $avgMapelProgress >= 80 ? 'bg-emerald-500' : ($avgMapelProgress >= 50 ? 'bg-amber-500' : 'bg-rose-500') }}" style="width: {{ $avgMapelProgress }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= 3. TABBED CONTENT CONTAINER ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Seamless Green Tab Navigation Bar -->
        <div class="bg-emerald-700 px-4 pt-3 flex border-b border-emerald-600/70 gap-2 overflow-x-auto text-white">
            <button type="button" id="tabBtnProgressMapel" class="subtab-button px-5 py-3 text-xs sm:text-sm font-bold bg-emerald-600 text-white rounded-t-xl flex items-center gap-2 transition cursor-pointer shadow-xs border-t border-x border-emerald-500/50">
                <i class="ti ti-chart-bar text-base"></i>
                <span>Progress Penilaian Mapel</span>
                <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/20 subtab-badge">
                    {{ $monitoringData->count() }}
                </span>
            </button>

            <button type="button" id="tabBtnDaftarSiswa" class="subtab-button px-5 py-3 text-xs sm:text-sm font-semibold bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 rounded-t-xl flex items-center gap-2 transition cursor-pointer">
                <i class="ti ti-users text-base"></i>
                <span>Daftar Siswa &amp; Cetak Rapor</span>
                <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-900/50 text-emerald-200 subtab-badge">
                    {{ $students->count() }}
                </span>
            </button>
        </div>

        <!-- ================= SUBTAB 1: PROGRESS MAPEL ================= -->
        <div id="subtabPanelProgressMapel" class="subtab-panel block">
            <!-- Solid Green Table Header -->
            <div class="px-5 pt-4 pb-3 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                        <i class="ti ti-books"></i>
                    </div>
                    <h3 class="text-sm font-extrabold text-white tracking-tight">Status Penilaian Per Mata Pelajaran</h3>
                </div>

                <!-- Instant Search for Mapel -->
                <div class="relative w-full sm:w-64">
                    <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-emerald-200 text-sm pointer-events-none"></i>
                    <input type="text" id="searchMapelInput" placeholder="Cari mapel / guru..." class="w-full pl-8 pr-3 py-1.5 text-xs bg-white/15 hover:bg-white/20 focus:bg-white text-white focus:text-slate-900 placeholder-emerald-100 focus:placeholder-slate-400 border border-white/20 rounded-lg outline-none transition">
                </div>
            </div>

            <!-- Mapel Table -->
            <div class="overflow-x-auto bg-emerald-600">
                <table class="w-full text-left text-xs border-0 border-collapse" id="mapelTable">
                    <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-b border-emerald-700/80">
                        <tr>
                            <th class="py-2 px-3 text-center w-12 text-white">NO</th>
                            <th class="py-2 px-3 text-white">MATA PELAJARAN</th>
                            <th class="py-2 px-3 text-white">GURU PENGAMPU</th>
                            <th class="py-2 px-3 text-center text-white">RENCANA NILAI</th>
                            <th class="py-2 px-3 text-white w-56">PROGRESS PENILAIAN</th>
                            <th class="py-2 px-3 text-center text-white">STATUS</th>
                            <th class="py-2 px-3 text-end text-white">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white text-slate-700 font-medium">
                        @forelse ($monitoringData as $index => $data)
                            <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-emerald-50/50 transition-colors mapel-row">
                                <td class="py-2 px-3 text-center text-slate-400 font-bold text-xs">{{ $index + 1 }}</td>
                                <td class="py-2 px-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0 border border-emerald-100/80">
                                            <i class="ti ti-book-2"></i>
                                        </div>
                                        <span class="font-bold text-slate-900 mapel-name text-xs leading-tight">{{ $data->mapel_nama }}</span>
                                    </div>
                                </td>
                                <td class="py-2 px-3">
                                    <div class="flex items-center gap-1.5 text-slate-700 font-medium text-xs">
                                        <i class="ti ti-user text-slate-400 text-xs"></i>
                                        <span class="guru-name">{{ $data->guru_nama }}</span>
                                    </div>
                                </td>
                                <td class="py-2 px-3 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200/60">
                                        {{ $data->rencana_count }} Rencana
                                    </span>
                                </td>
                                <td class="py-2 px-3">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-300 {{ $data->completion_rate === 100 ? 'bg-emerald-500' : ($data->completion_rate > 0 ? 'bg-sky-500' : 'bg-rose-500') }}" style="width: {{ $data->completion_rate }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold min-w-8 text-right {{ $data->completion_rate === 100 ? 'text-emerald-600' : ($data->completion_rate > 0 ? 'text-sky-600' : 'text-rose-600') }}">
                                            {{ $data->completion_rate }}%
                                        </span>
                                    </div>
                                </td>
                                <td class="py-2 px-3 text-center">
                                    @if ($data->status === 'Belum Ada Rencana')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200/70">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Belum Rencana
                                        </span>
                                    @elseif ($data->status === 'Belum Diisi')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/70">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Belum Diisi
                                        </span>
                                    @elseif ($data->status === 'Belum Lengkap')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200/70">
                                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> Belum Lengkap
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Lengkap
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 text-end">
                                    <a href="{{ route('rapor-siswa.nilai', $data->jadwal_id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-md text-xs shadow-2xs transition active:scale-95">
                                        <i class="ti ti-chart-bar text-xs"></i>
                                        <span>Lihat Nilai</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-1.5">
                                            <i class="ti ti-books-off text-xl"></i>
                                        </div>
                                        <p class="text-xs font-bold text-slate-700">Belum ada mata pelajaran terdaftar</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">Tidak ada jadwal pelajaran di kelas ini pada semester aktif.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= SUBTAB 2: DAFTAR SISWA & CETAK RAPOR ================= -->
        <div id="subtabPanelDaftarSiswa" class="subtab-panel hidden">
            <!-- Solid Green Table Header -->
            <div class="px-5 pt-4 pb-3 bg-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                        <i class="ti ti-user-check"></i>
                    </div>
                    <h3 class="text-sm font-extrabold text-white tracking-tight">Data Siswa Terdaftar &amp; Cetak Rapor</h3>
                </div>

                <!-- Instant Search for Students -->
                <div class="relative w-full sm:w-64">
                    <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-emerald-200 text-sm pointer-events-none"></i>
                    <input type="text" id="searchStudentInput" placeholder="Cari nama siswa / NIS..." class="w-full pl-8 pr-3 py-1.5 text-xs bg-white/15 hover:bg-white/20 focus:bg-white text-white focus:text-slate-900 placeholder-emerald-100 focus:placeholder-slate-400 border border-white/20 rounded-lg outline-none transition">
                </div>
            </div>

            <!-- Students Table -->
            <div class="overflow-x-auto bg-emerald-600">
                <table class="w-full text-left text-xs border-0 border-collapse" id="studentsTable">
                    <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-b border-emerald-700/80">
                        <tr>
                            <th class="py-2 px-3 text-center w-12 text-white">NO</th>
                            <th class="py-2 px-3 text-white">NIS</th>
                            <th class="py-2 px-3 text-white">NAMA LENGKAP SISWA</th>
                            <th class="py-2 px-3 text-center text-white">JENIS KELAMIN</th>
                            <th class="py-2 px-3 text-center text-white">NO. PENDAFTARAN</th>
                            <th class="py-2 px-3 text-end text-white">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white text-slate-700 font-medium">
                        @forelse ($students as $index => $student)
                            <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-emerald-50/50 transition-colors student-row">
                                <td class="py-2 px-3 text-center text-slate-400 font-bold text-xs">{{ $index + 1 }}</td>
                                <td class="py-2 px-3">
                                    <span class="font-mono text-xs font-bold text-slate-800 student-nis">{{ $student->nis ?? '-' }}</span>
                                </td>
                                <td class="py-2 px-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full {{ $student->jenis_kelamin == 'L' ? 'bg-sky-50 text-sky-600 border border-sky-200/80' : 'bg-pink-50 text-pink-600 border border-pink-200/80' }} flex items-center justify-center font-bold text-xs shrink-0">
                                            <i class="ti {{ $student->jenis_kelamin == 'L' ? 'ti-man' : 'ti-woman' }}"></i>
                                        </div>
                                        <span class="font-bold text-slate-900 student-name text-xs sm:text-sm">{{ $student->nama_lengkap }}</span>
                                    </div>
                                </td>
                                <td class="py-2 px-3 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold {{ $student->jenis_kelamin == 'L' ? 'bg-sky-50 text-sky-700 border border-sky-200/70' : 'bg-pink-50 text-pink-700 border border-pink-200/70' }}">
                                        {{ $student->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                                    </span>
                                </td>
                                <td class="py-2 px-3 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200/60 font-mono">
                                        {{ $student->no_pendaftaran }}
                                    </span>
                                </td>
                                <td class="py-2 px-3 text-end">
                                    <a href="{{ route('rapor-siswa.preview', Crypt::encrypt($student->no_pendaftaran)) }}" class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-md text-xs shadow-2xs transition active:scale-95">
                                        <i class="ti ti-printer text-xs"></i>
                                        <span>Cetak Rapor</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-1.5">
                                            <i class="ti ti-users-minus text-xl"></i>
                                        </div>
                                        <p class="text-xs font-bold text-slate-700">Tidak ada siswa terdaftar</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">Belum ada data siswa yang ditempatkan pada kelas ini.</p>
                                    </div>
                                </td>
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
        // Subtab switcher
        $('#tabBtnProgressMapel').on('click', function() {
            $('.subtab-button').removeClass('bg-emerald-600 text-white font-bold border-t border-x border-emerald-500/50 shadow-xs')
                .addClass('bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 font-semibold border-none');
            $('.subtab-button .subtab-badge').removeClass('bg-white/20 text-white border border-white/20')
                .addClass('bg-emerald-900/50 text-emerald-200 border-none');
            
            $(this).removeClass('bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 font-semibold border-none')
                .addClass('bg-emerald-600 text-white font-bold border-t border-x border-emerald-500/50 shadow-xs');
            $(this).find('.subtab-badge').removeClass('bg-emerald-900/50 text-emerald-200 border-none')
                .addClass('bg-white/20 text-white border border-white/20');

            $('#subtabPanelProgressMapel').removeClass('hidden').addClass('block');
            $('#subtabPanelDaftarSiswa').removeClass('block').addClass('hidden');
        });

        $('#tabBtnDaftarSiswa').on('click', function() {
            $('.subtab-button').removeClass('bg-emerald-600 text-white font-bold border-t border-x border-emerald-500/50 shadow-xs')
                .addClass('bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 font-semibold border-none');
            $('.subtab-button .subtab-badge').removeClass('bg-white/20 text-white border border-white/20')
                .addClass('bg-emerald-900/50 text-emerald-200 border-none');
            
            $(this).removeClass('bg-emerald-800/40 text-emerald-100 hover:text-white hover:bg-emerald-600/50 font-semibold border-none')
                .addClass('bg-emerald-600 text-white font-bold border-t border-x border-emerald-500/50 shadow-xs');
            $(this).find('.subtab-badge').removeClass('bg-emerald-900/50 text-emerald-200 border-none')
                .addClass('bg-white/20 text-white border border-white/20');

            $('#subtabPanelDaftarSiswa').removeClass('hidden').addClass('block');
            $('#subtabPanelProgressMapel').removeClass('block').addClass('hidden');
        });

        // Search mapel
        $('#searchMapelInput').on('keyup', function() {
            var val = $(this).val().toLowerCase();
            $('#mapelTable tbody tr.mapel-row').filter(function() {
                var mapel = $(this).find('.mapel-name').text().toLowerCase();
                var guru = $(this).find('.guru-name').text().toLowerCase();
                $(this).toggle(mapel.indexOf(val) > -1 || guru.indexOf(val) > -1);
            });
        });

        // Search student
        $('#searchStudentInput').on('keyup', function() {
            var val = $(this).val().toLowerCase();
            $('#studentsTable tbody tr.student-row').filter(function() {
                var name = $(this).find('.student-name').text().toLowerCase();
                var nis = $(this).find('.student-nis').text().toLowerCase();
                $(this).toggle(name.indexOf(val) > -1 || nis.indexOf(val) > -1);
            });
        });
    });
</script>
@endpush
@endsection
