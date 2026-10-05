@extends('layouts.app')
@section('titlepage', 'Jobdesk Saya')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-checklist"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Jobdesk Saya
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Daftar rincian tugas pokok & fungsi (tupoksi) resmi jabatan Anda
                </p>
            </div>
        </div>

        <!-- Breadcrumb & Print Action -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500">MSDM & Layanan</span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Jobdesk Saya</span>
            </nav>

            <button type="button" 
                    onclick="window.print()" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-lg text-xs border border-slate-200 shadow-2xs transition active:scale-95 cursor-pointer">
                <i class="ti ti-printer text-sm text-slate-500"></i>
                <span>Cetak Jobdesk</span>
            </button>
        </div>
    </div>

    <!-- ================= 2. EMPLOYEE PROFILE BANNER ================= -->
    @if(!empty($karyawan))
        <div class="bg-gradient-to-br from-emerald-800 via-emerald-900 to-teal-950 rounded-2xl p-5 sm:p-6 text-white shadow-sm relative overflow-hidden border border-emerald-700/50">
            <!-- Decorative subtle background circles -->
            <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-white/5 pointer-events-none"></div>
            <div class="absolute right-32 -top-12 w-32 h-32 rounded-full bg-emerald-500/10 pointer-events-none"></div>

            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-5 relative z-10">
                <!-- Avatar & Identity -->
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/20 flex items-center justify-center text-white text-2xl font-bold shadow-inner shrink-0">
                        <i class="ti ti-user-check"></i>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-700/60 border border-emerald-500/40 text-[11px] font-semibold text-emerald-200 mb-1">
                            <i class="ti ti-id"></i>
                            <span>NPP: {{ $karyawan->npp }}</span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-bold text-white tracking-tight">
                            {{ $karyawan->nama_lengkap }}
                        </h2>
                    </div>
                </div>

                <!-- Assignment Metadata Badges -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 w-full lg:w-auto">
                    <!-- Jabatan -->
                    <div class="bg-white/10 backdrop-blur-xs border border-white/15 rounded-xl px-3.5 py-2.5 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600/50 flex items-center justify-center text-emerald-200 shrink-0">
                            <i class="ti ti-briefcase text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold text-emerald-200/80 uppercase tracking-wider">Jabatan</p>
                            <p class="text-xs font-bold text-white truncate">{{ strtoupper($karyawan->nama_jabatan ?? '-') }}</p>
                        </div>
                    </div>

                    <!-- Departemen -->
                    <div class="bg-white/10 backdrop-blur-xs border border-white/15 rounded-xl px-3.5 py-2.5 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600/50 flex items-center justify-center text-emerald-200 shrink-0">
                            <i class="ti ti-sitemap text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold text-emerald-200/80 uppercase tracking-wider">Departemen</p>
                            <p class="text-xs font-bold text-white truncate">{{ strtoupper($karyawan->nama_dept ?? '-') }}</p>
                        </div>
                    </div>

                    <!-- Unit -->
                    <div class="bg-white/10 backdrop-blur-xs border border-white/15 rounded-xl px-3.5 py-2.5 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600/50 flex items-center justify-center text-emerald-200 shrink-0">
                            <i class="ti ti-building text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold text-emerald-200/80 uppercase tracking-wider">Unit Kerja</p>
                            <p class="text-xs font-bold text-white truncate">{{ strtoupper($karyawan->nama_unit ?? '-') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ================= 3. JOBDESK LIST SECTION ================= -->
    <div class="space-y-4">
        <!-- Section Header Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-3.5 border border-slate-200/90 rounded-2xl shadow-xs">
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 font-bold text-xs border border-emerald-200/60">
                    <i class="ti ti-list-details"></i>
                </span>
                <span class="text-sm font-bold text-slate-800">Rincian Butir Tugas Pokok</span>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                    {{ count($jobdesk) }} Butir
                </span>
            </div>

            <!-- Instant Search Box -->
            <div class="relative w-full sm:w-64">
                <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" 
                       id="searchKaryawanJobdesk" 
                       placeholder="Cari dalam jobdesk..." 
                       class="w-full pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-700 placeholder-slate-400 focus:outline-hidden focus:border-emerald-500 focus:bg-white transition">
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="jobdeskContainer">
            @forelse($jobdesk as $index => $jd)
                <div class="jobdesk-item bg-white border border-slate-200/90 hover:border-emerald-300 rounded-2xl p-4 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                    <div>
                        <!-- Header badge & number -->
                        <div class="flex items-center justify-between gap-2 pb-3 mb-3 border-b border-slate-100">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/70 uppercase tracking-wider">
                                <i class="ti ti-tag text-[10px]"></i>
                                <span>{{ $jd->kode_jobdesk }}</span>
                            </span>
                            <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-500 text-[11px] font-bold flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition">
                                {{ $index + 1 }}
                            </span>
                        </div>

                        <!-- Jobdesk Content -->
                        <div class="text-xs text-slate-700 leading-relaxed font-normal jobdesk-text prose-sm max-w-none">
                            {!! $jd->jobdesk !!}
                        </div>
                    </div>

                    <!-- Footer Info -->
                    <div class="mt-4 pt-3 border-t border-slate-100/70 flex items-center justify-between text-[11px] text-slate-400">
                        <span class="flex items-center gap-1">
                            <i class="ti ti-circle-check text-emerald-600"></i>
                            <span>Tugas Resmi</span>
                        </span>
                        <span class="text-[10px] font-medium text-slate-400">
                            Sipren Al Amin
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white border border-slate-200/90 rounded-2xl p-12 text-center shadow-xs">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center text-2xl mb-3 border border-slate-100">
                        <i class="ti ti-briefcase-off"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 mb-1">Belum Ada Jobdesk Yang Ditetapkan</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                        Data tugas pokok dan fungsi resmi untuk jabatan Anda belum diinput oleh bagian Kepegawaian (HRD/MSDM).
                    </p>
                </div>
            @endforelse
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchKaryawanJobdesk');
        const items = document.querySelectorAll('.jobdesk-item');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                items.forEach(item => {
                    const text = item.querySelector('.jobdesk-text')?.textContent.toLowerCase() || '';
                    const code = item.querySelector('.jobdesk-item span')?.textContent.toLowerCase() || '';
                    if (text.includes(query) || code.includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection

