@extends('layouts.app')
@section('titlepage', 'Laporan Kegiatan')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER & BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-bold border border-emerald-200 shadow-2xs">
                <i class="ti ti-printer"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Laporan Kegiatan
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Cetak dan export data rekapitulasi realisasi serta agenda kegiatan kerja
                </p>
            </div>
        </div>

        <!-- Breadcrumb Navigation -->
        <div class="flex flex-col md:items-end">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500">MSDM & Layanan</span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Laporan Kegiatan</span>
            </nav>
        </div>
    </div>

    <!-- ================= 2. MAIN REPORT CONTAINER WITH TABS ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left Tab Selection Nav -->
        <div class="lg:col-span-4 xl:col-span-3 space-y-2">
            <div class="bg-white p-2 border border-slate-200/90 rounded-2xl shadow-xs space-y-1">
                <button type="button" 
                        class="tab-btn active w-full flex items-center gap-3 px-3.5 py-3 rounded-xl font-bold text-xs transition-all duration-200 text-left cursor-pointer active:scale-98" 
                        data-target="#tab-realisasi">
                    <div class="tab-icon w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-base shrink-0 font-bold">
                        <i class="ti ti-activity"></i>
                    </div>
                    <div>
                        <span class="block text-slate-900 text-xs font-bold leading-tight">Realisasi Kegiatan</span>
                        <span class="block text-[11px] text-slate-400 font-normal mt-0.5">Laporan hasil kegiatan kerja</span>
                    </div>
                </button>

                <button type="button" 
                        class="tab-btn w-full flex items-center gap-3 px-3.5 py-3 rounded-xl font-bold text-xs transition-all duration-200 text-left cursor-pointer active:scale-98" 
                        data-target="#tab-agenda">
                    <div class="tab-icon w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center text-base shrink-0 font-bold">
                        <i class="ti ti-calendar-event"></i>
                    </div>
                    <div>
                        <span class="block text-slate-900 text-xs font-bold leading-tight">Agenda Kegiatan</span>
                        <span class="block text-[11px] text-slate-400 font-normal mt-0.5">Laporan jadwal rencana agenda</span>
                    </div>
                </button>
            </div>

            <!-- Helpful Tip Box -->
            <div class="p-4 bg-emerald-50/70 border border-emerald-200/70 rounded-2xl text-xs space-y-1.5">
                <div class="flex items-center gap-2 font-bold text-emerald-900">
                    <i class="ti ti-info-circle text-base text-emerald-600"></i>
                    <span>Informasi Cetak</span>
                </div>
                <p class="text-[11px] text-emerald-800 leading-relaxed">
                    Pilih periode bulan dan tahun, serta filter unit kerja atau karyawan jika diperlukan. Dokumen dapat langsung dicetak atau diunduh format Excel.
                </p>
            </div>
        </div>

        <!-- Right Form Content Box -->
        <div class="lg:col-span-8 xl:col-span-9">
            
            {{-- TAB 1: LAPORAN REALISASI KEGIATAN --}}
            <div id="tab-realisasi" class="tab-pane-content bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <!-- Header Card -->
                <div class="px-5 py-3.5 bg-emerald-600 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                            <i class="ti ti-activity"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-tight">Form Cetak Laporan Realisasi Kegiatan</h3>
                            <p class="text-[11px] text-emerald-100 font-medium">Rekapitulasi pelaksanaan dan capaian kegiatan kerja karyawan</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="p-5 sm:p-6">
                    <form action="{{ route('kegiatan.laporan.cetak') }}" method="POST" target="_blank" class="space-y-4" id="formLaporanRealisasi">
                        @csrf
                        
                        @if($can_filter_all)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Unit Filter -->
                                <div class="space-y-1.5">
                                    <label for="kode_unit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                        <i class="ti ti-building text-sm text-slate-400"></i>
                                        <span>Unit Kerja <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
                                    </label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <i class="ti ti-building text-base"></i>
                                        </div>
                                        <select name="kode_unit" id="kode_unit" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                            <option value="">Semua Unit</option>
                                            @foreach($unit as $u)
                                                <option value="{{ $u->kode_unit }}">{{ strtoupper($u->nama_unit) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Department Filter -->
                                <div class="space-y-1.5">
                                    <label for="kode_dept" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                        <i class="ti ti-sitemap text-sm text-slate-400"></i>
                                        <span>Departemen <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
                                    </label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <i class="ti ti-sitemap text-base"></i>
                                        </div>
                                        <select name="kode_dept" id="kode_dept" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                            <option value="">Semua Departemen</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Jabatan Filter -->
                                <div class="space-y-1.5">
                                    <label for="kode_jabatan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                        <i class="ti ti-briefcase text-sm text-slate-400"></i>
                                        <span>Jabatan <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
                                    </label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <i class="ti ti-briefcase text-base"></i>
                                        </div>
                                        <select name="kode_jabatan" id="kode_jabatan" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                            <option value="">Semua Jabatan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Karyawan Filter -->
                                <div class="space-y-1.5">
                                    <label for="npp" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                        <i class="ti ti-user text-sm text-slate-400"></i>
                                        <span>Karyawan Spesifik <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
                                    </label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <i class="ti ti-user text-base"></i>
                                        </div>
                                        <select name="npp" id="npp" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                            <option value="">Semua Karyawan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Periode Bulan & Tahun -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                            <!-- Bulan -->
                            <div class="space-y-1.5">
                                <label for="bulan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-calendar text-sm text-slate-400"></i>
                                    <span>Bulan <span class="text-rose-500 font-bold">*</span></span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-calendar text-base"></i>
                                    </div>
                                    <select name="bulan" id="bulan" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" required>
                                        <option value="">-- Pilih Bulan --</option>
                                        @foreach ($list_bulan as $d)
                                            <option {{ date('m') == $d['kode_bulan'] ? 'selected' : '' }} value="{{ $d['kode_bulan'] }}">
                                                {{ $d['nama_bulan'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Tahun -->
                            <div class="space-y-1.5">
                                <label for="tahun" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-calendar-event text-sm text-slate-400"></i>
                                    <span>Tahun <span class="text-rose-500 font-bold">*</span></span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-calendar-event text-base"></i>
                                    </div>
                                    <select name="tahun" id="tahun" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" required>
                                        <option value="">-- Pilih Tahun --</option>
                                        @for ($t = $start_year; $t <= date('Y'); $t++)
                                            <option {{ date('Y') == $t ? 'selected' : '' }} value="{{ $t }}">{{ $t }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-3">
                            <button type="submit" class="w-full sm:flex-1 py-2.5 px-5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                                <i class="ti ti-printer text-base"></i>
                                <span>Cetak Laporan Realisasi</span>
                            </button>
                            <button type="submit" name="export_excel" value="true" class="w-full sm:w-auto py-2.5 px-5 bg-white hover:bg-emerald-50 text-emerald-700 border border-emerald-300 font-bold text-xs sm:text-sm rounded-xl shadow-2xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                                <i class="ti ti-file-spreadsheet text-base"></i>
                                <span>Export Excel</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TAB 2: LAPORAN AGENDA KEGIATAN --}}
            <div id="tab-agenda" class="tab-pane-content hidden bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
                <!-- Header Card -->
                <div class="px-5 py-3.5 bg-emerald-600 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center text-xs font-bold border border-white/20 shadow-2xs">
                            <i class="ti ti-calendar-event"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-tight">Form Cetak Laporan Agenda Kegiatan</h3>
                            <p class="text-[11px] text-emerald-100 font-medium">Rekapitulasi jadwal rencana agenda kegiatan kerja</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="p-5 sm:p-6">
                    <form action="{{ route('kegiatan.laporan.cetak-agenda') }}" method="POST" target="_blank" class="space-y-4" id="formLaporanAgenda">
                        @csrf
                        
                        @if($can_filter_all)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Unit Filter -->
                                <div class="space-y-1.5">
                                    <label for="agenda_kode_unit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                        <i class="ti ti-building text-sm text-slate-400"></i>
                                        <span>Unit Kerja <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
                                    </label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <i class="ti ti-building text-base"></i>
                                        </div>
                                        <select name="kode_unit" id="agenda_kode_unit" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                            <option value="">Semua Unit</option>
                                            @foreach($unit as $u)
                                                <option value="{{ $u->kode_unit }}">{{ strtoupper($u->nama_unit) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Department Filter -->
                                <div class="space-y-1.5">
                                    <label for="agenda_kode_dept" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                        <i class="ti ti-sitemap text-sm text-slate-400"></i>
                                        <span>Departemen <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
                                    </label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <i class="ti ti-sitemap text-base"></i>
                                        </div>
                                        <select name="kode_dept" id="agenda_kode_dept" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                            <option value="">Semua Departemen</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Jabatan Filter -->
                                <div class="space-y-1.5">
                                    <label for="agenda_kode_jabatan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                        <i class="ti ti-briefcase text-sm text-slate-400"></i>
                                        <span>Jabatan <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
                                    </label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <i class="ti ti-briefcase text-base"></i>
                                        </div>
                                        <select name="kode_jabatan" id="agenda_kode_jabatan" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                            <option value="">Semua Jabatan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Karyawan Filter -->
                                <div class="space-y-1.5">
                                    <label for="agenda_npp" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                        <i class="ti ti-user text-sm text-slate-400"></i>
                                        <span>Karyawan Spesifik <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
                                    </label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <i class="ti ti-user text-base"></i>
                                        </div>
                                        <select name="npp" id="agenda_npp" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                            <option value="">Semua Karyawan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Periode Bulan & Tahun -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                            <!-- Bulan -->
                            <div class="space-y-1.5">
                                <label for="agenda_bulan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-calendar text-sm text-slate-400"></i>
                                    <span>Bulan <span class="text-rose-500 font-bold">*</span></span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-calendar text-base"></i>
                                    </div>
                                    <select name="bulan" id="agenda_bulan" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" required>
                                        <option value="">-- Pilih Bulan --</option>
                                        @foreach ($list_bulan as $d)
                                            <option {{ date('m') == $d['kode_bulan'] ? 'selected' : '' }} value="{{ $d['kode_bulan'] }}">
                                                {{ $d['nama_bulan'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Tahun -->
                            <div class="space-y-1.5">
                                <label for="agenda_tahun" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="ti ti-calendar-event text-sm text-slate-400"></i>
                                    <span>Tahun <span class="text-rose-500 font-bold">*</span></span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <i class="ti ti-calendar-event text-base"></i>
                                    </div>
                                    <select name="tahun" id="agenda_tahun" class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" required>
                                        <option value="">-- Pilih Tahun --</option>
                                        @for ($t = $start_year; $t <= date('Y'); $t++)
                                            <option {{ date('Y') == $t ? 'selected' : '' }} value="{{ $t }}">{{ $t }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-3">
                            <button type="submit" class="w-full sm:flex-1 py-2.5 px-5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                                <i class="ti ti-printer text-base"></i>
                                <span>Cetak Laporan Agenda</span>
                            </button>
                            <button type="submit" name="export_excel" value="true" class="w-full sm:w-auto py-2.5 px-5 bg-white hover:bg-emerald-50 text-emerald-700 border border-emerald-300 font-bold text-xs sm:text-sm rounded-xl shadow-2xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                                <i class="ti ti-file-spreadsheet text-base"></i>
                                <span>Export Excel</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection

@push('myscript')
<script>
    $(function() {
        // Tab switching behavior
        $('.tab-btn').on('click', function(e) {
            e.preventDefault();
            const targetId = $(this).data('target');

            // Set active state on button
            $('.tab-btn').removeClass('active bg-emerald-50/70 text-emerald-800 border-emerald-200');
            $('.tab-btn .tab-icon').removeClass('bg-emerald-100 text-emerald-700').addClass('bg-slate-100 text-slate-500');

            $(this).addClass('active bg-emerald-50/70 text-emerald-800');
            $(this).find('.tab-icon').removeClass('bg-slate-100 text-slate-500').addClass('bg-emerald-100 text-emerald-700');

            // Show target pane
            $('.tab-pane-content').addClass('hidden');
            $(targetId).removeClass('hidden');
        });

        // Initialize active tab styling
        $('.tab-btn.active').addClass('bg-emerald-50/70 text-emerald-800');

        function setupCascadingFilters(prefix) {
            let unitSelect = $('#' + (prefix ? prefix + '_' : '') + 'kode_unit');
            let deptSelect = $('#' + (prefix ? prefix + '_' : '') + 'kode_dept');
            let jabatanSelect = $('#' + (prefix ? prefix + '_' : '') + 'kode_jabatan');
            let nppSelect = $('#' + (prefix ? prefix + '_' : '') + 'npp');

            function update() {
                let kode_unit = unitSelect.val();
                let kode_dept = deptSelect.val();
                let kode_jabatan = jabatanSelect.val();

                if (kode_unit === "" || kode_unit === null) {
                    deptSelect.html('<option value="">Semua Departemen</option>');
                    jabatanSelect.html('<option value="">Semua Jabatan</option>');
                    nppSelect.html('<option value="">Semua Karyawan</option>');
                    return;
                }

                if (kode_dept === "" || kode_dept === null) {
                    jabatanSelect.html('<option value="">Semua Jabatan</option>');
                    nppSelect.html('<option value="">Semua Karyawan</option>');
                }

                $.ajax({
                    url: "{{ route('kegiatan.laporan.get-filter-options') }}",
                    type: "GET",
                    data: {
                        kode_unit: kode_unit,
                        kode_dept: kode_dept,
                        kode_jabatan: kode_jabatan
                    },
                    success: function(response) {
                        let currentDept = deptSelect.val();
                        deptSelect.html('<option value="">Semua Departemen</option>');
                        response.departments.forEach(function(d) {
                            let selected = d.kode_dept === currentDept ? 'selected' : '';
                            deptSelect.append(`<option value="${d.kode_dept}" ${selected}>${d.nama_dept.toUpperCase()}</option>`);
                        });

                        let currentJabatan = jabatanSelect.val();
                        jabatanSelect.html('<option value="">Semua Jabatan</option>');
                        if (kode_dept !== "" && kode_dept !== null) {
                            response.jabatans.forEach(function(j) {
                                let selected = j.kode_jabatan === currentJabatan ? 'selected' : '';
                                jabatanSelect.append(`<option value="${j.kode_jabatan}" ${selected}>${j.nama_jabatan.toUpperCase()}</option>`);
                            });
                        }

                        let currentKaryawan = nppSelect.val();
                        nppSelect.html('<option value="">Semua Karyawan</option>');
                        response.karyawans.forEach(function(k) {
                            let selected = k.npp === currentKaryawan ? 'selected' : '';
                            nppSelect.append(`<option value="${k.npp}" ${selected}>${k.nama_lengkap.toUpperCase()}</option>`);
                        });
                    }
                });
            }

            unitSelect.on('change', function() {
                deptSelect.val('');
                jabatanSelect.val('');
                nppSelect.val('');
                update();
            });

            deptSelect.on('change', function() {
                jabatanSelect.val('');
                nppSelect.val('');
                update();
            });

            jabatanSelect.on('change', function() {
                nppSelect.val('');
                update();
            });
        }

        // Initialize for Realisasi tab
        setupCascadingFilters('');
        // Initialize for Agenda tab
        setupCascadingFilters('agenda');
    });
</script>
@endpush
