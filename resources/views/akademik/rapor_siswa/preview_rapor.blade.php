@extends('layouts.app')
@section('titlepage', 'Preview & Cetak Rapor')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle with Back Button -->
        <div class="flex items-center gap-3">
            <a href="{{ route('rapor-siswa.show', $kelas->kode_kelas ?? '') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200/90 text-slate-700 hover:text-emerald-700 hover:bg-emerald-50 hover:border-emerald-200 flex items-center justify-center transition shrink-0 shadow-xs" title="Kembali">
                <i class="ti ti-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>Cetak Rapor - {{ $siswa->nama_lengkap }}</span>
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Preview ringkasan nilai dan unduh dokumen rapor siswa dalam format PDF
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
                <span class="font-bold text-slate-800">Preview &amp; Cetak</span>
            </nav>
        </div>
    </div>

    <form action="{{ route('rapor-siswa.pdf', Crypt::encrypt($pendaftaran->no_pendaftaran)) }}" method="POST" target="_blank">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
            <!-- ================= PANEL INFORMASI SISWA (KIRI) ================= -->
            <div class="lg:col-span-5 bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-emerald-600 text-white flex items-center gap-2">
                    <i class="ti ti-id-badge-2 text-lg"></i>
                    <h3 class="font-extrabold text-sm text-white tracking-tight">Informasi Data Siswa</h3>
                </div>

                <div class="p-5 space-y-4">
                    <!-- Student Header Box -->
                    <div class="flex items-center gap-3 p-3.5 rounded-xl bg-emerald-50/60 border border-emerald-100">
                        <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xl shrink-0 font-bold">
                            <i class="ti ti-user"></i>
                        </div>
                        <div>
                            <h4 class="text-sm sm:text-base font-extrabold text-slate-900">{{ strtoupper($siswa->nama_lengkap) }}</h4>
                            <span class="text-xs text-slate-500 font-medium">NIS: <strong>{{ $pendaftaran->nis ?? '-' }}</strong> / NISN: <strong>{{ $siswa->nisn ?? '-' }}</strong></span>
                        </div>
                    </div>

                    <!-- Details Table -->
                    <div class="space-y-2.5 text-xs sm:text-sm">
                        <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Rombel / Kelas</span>
                            <span class="font-bold text-slate-900">{{ $kelas->nama_kelas ?? '-' }} ({{ $kelas->unit->nama_unit ?? '-' }})</span>
                        </div>
                        <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Tahun Ajaran</span>
                            <span class="font-semibold text-slate-800">{{ $activeTa->tahun_ajaran ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Semester</span>
                            <span class="font-semibold text-slate-800">{{ ($activeSemester->semester ?? 1) == 1 ? 'Semester 1 (Ganjil)' : 'Semester 2 (Genap)' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">No. Pendaftaran</span>
                            <span class="font-mono font-bold text-slate-800">{{ $pendaftaran->no_pendaftaran }}</span>
                        </div>
                    </div>

                    <!-- Presensi Recap Box -->
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2.5">
                            <i class="ti ti-calendar-check text-emerald-600 mr-1"></i> Rekap Presensi Siswa
                        </span>
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div class="p-2 rounded-lg bg-white border border-slate-200">
                                <span class="text-[11px] text-slate-400 font-medium block">Sakit</span>
                                <span class="text-sm font-bold text-amber-600">{{ $kehadiran->sakit ?? 0 }} Hari</span>
                            </div>
                            <div class="p-2 rounded-lg bg-white border border-slate-200">
                                <span class="text-[11px] text-slate-400 font-medium block">Izin</span>
                                <span class="text-sm font-bold text-sky-600">{{ $kehadiran->izin ?? 0 }} Hari</span>
                            </div>
                            <div class="p-2 rounded-lg bg-white border border-slate-200">
                                <span class="text-[11px] text-slate-400 font-medium block">Alpa</span>
                                <span class="text-sm font-bold text-rose-600">{{ $kehadiran->alpa ?? 0 }} Hari</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs sm:text-sm shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                        <i class="ti ti-printer text-lg"></i>
                        <span>Cetak &amp; Unduh Dokumen Rapor PDF</span>
                    </button>
                </div>
            </div>

            <!-- ================= PANEL PREVIEW NILAI (KANAN) ================= -->
            <div class="lg:col-span-7 bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <div class="px-5 py-3.5 bg-emerald-600 text-white flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-table text-lg"></i>
                        <h3 class="font-extrabold text-sm text-white tracking-tight">Preview Nilai Akhir Akademik (Read-Only)</h3>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white border border-white/30 shadow-2xs">
                        Kurikulum Aktif
                    </span>
                </div>

                <div class="overflow-x-auto bg-emerald-600">
                    <table class="w-full text-left text-xs border-0 border-collapse">
                        <thead class="bg-emerald-600 text-white font-bold uppercase tracking-wider text-[11px] border-0 border-b border-emerald-700/80">
                            <tr>
                                <th class="py-2 px-3 text-white">MATA PELAJARAN</th>
                                <th class="py-2 px-3 text-center text-white w-28">NILAI AKHIR</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-slate-700 font-medium">
                            @php $index = 1; @endphp
                            @foreach ($subjects as $mapel)
                                @if ($mapel->children->count() > 0)
                                    <tr class="bg-slate-100/90 font-bold text-slate-900">
                                        <td colspan="2" class="py-1.5 px-3 text-xs">
                                            <i class="ti ti-folder text-slate-500 mr-1"></i> {{ $index++ }}. {{ $mapel->nama_matpel }}
                                        </td>
                                    </tr>
                                    @foreach ($mapel->children as $child)
                                        <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-emerald-50/50 transition-colors">
                                            <td class="py-2 px-3 pl-8 text-slate-800 text-xs">
                                                {{ $child->nama_matpel }}
                                            </td>
                                            <td class="py-2 px-3 text-center font-bold">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-black shadow-2xs {{ ($child->grade->nilai_rapor ?? 0) >= 75 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/80' : 'bg-rose-50 text-rose-700 border border-rose-200/80' }}">
                                                    {{ $child->grade->nilai_rapor ?? 0 }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-emerald-50/50 transition-colors">
                                        <td class="py-2 px-3 text-slate-800 font-bold text-xs">
                                            {{ $index++ }}. {{ $mapel->nama_matpel }}
                                        </td>
                                        <td class="py-2 px-3 text-center font-bold">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-black shadow-2xs {{ ($mapel->grade->nilai_rapor ?? 0) >= 75 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/80' : 'bg-rose-50 text-rose-700 border border-rose-200/80' }}">
                                                {{ $mapel->grade->nilai_rapor ?? 0 }}
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
