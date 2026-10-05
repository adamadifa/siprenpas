@extends('layouts.app')
@section('titlepage', 'Detail Data Karyawan')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="ti ti-id-badge text-emerald-600 text-2xl"></i>
                <span>Detail Profil Karyawan</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Informasi biodata lengkap, status penempatan kepegawaian, dan konfigurasi kerja
            </p>
        </div>

        <!-- Right Side: Breadcrumb & Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500 flex items-center gap-1">
                    <i class="ti ti-database text-sm"></i>
                    <span>Master Data</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <a href="{{ route('karyawan.index') }}" class="hover:text-slate-700 transition font-medium text-slate-500">
                    Karyawan
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Detail</span>
            </nav>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('karyawan.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold border border-slate-300/90 rounded-lg text-xs shadow-xs transition active:scale-95 cursor-pointer">
                    <i class="ti ti-arrow-left text-sm"></i>
                    <span>Kembali ke Daftar</span>
                </a>

                @can('karyawan.edit')
                    <button type="button" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs shadow-xs transition active:scale-95 editKaryawan cursor-pointer"
                            npp="{{ Crypt::encrypt($karyawan->npp) }}">
                        <i class="ti ti-edit text-sm"></i>
                        <span>Edit Profil</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- ================= 2. HERO PROFILE BANNER CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Banner Background -->
        <div class="h-28 sm:h-36 bg-linear-to-r from-emerald-800 via-teal-700 to-emerald-900 relative">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
            <div class="absolute top-4 right-4 flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/20 backdrop-blur-md text-white border border-white/30 shadow-xs">
                    {{ $karyawan->nama_unit ?? 'Unit Belum Ditentukan' }}
                </span>
            </div>
        </div>

        <!-- Profile Header Content -->
        <div class="px-5 sm:px-8 pb-6 pt-0 relative">
            <div class="flex flex-col sm:flex-row items-center sm:items-end justify-between gap-4 -mt-14 sm:-mt-16">
                <!-- Left: Avatar & Identity -->
                <div class="flex flex-col sm:flex-row items-center sm:items-end gap-4 text-center sm:text-left">
                    <!-- Avatar 3x4 Frame -->
                    <div class="relative shrink-0">
                        <div class="w-24 h-32 sm:w-28 sm:h-36 rounded-2xl bg-white p-1 shadow-lg ring-4 ring-white/80 overflow-hidden border border-slate-200">
                            @if (!empty($karyawan->foto) && Storage::disk('public')->exists('photos/karyawan/' . $karyawan->foto))
                                <img src="{{ getfotoKaryawan($karyawan->foto) }}" alt="{{ $karyawan->nama_lengkap }}" class="w-full h-full object-cover rounded-xl">
                            @else
                                <div class="w-full h-full rounded-xl bg-slate-100 flex flex-col items-center justify-center text-slate-400">
                                    <i class="ti ti-user text-4xl"></i>
                                    <span class="text-[10px] font-bold text-slate-400 mt-1">No Photo</span>
                                </div>
                            @endif
                        </div>

                        <!-- Status Floating Badge -->
                        @if($karyawan->status == 1)
                            <span class="absolute -bottom-1.5 -right-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-600 text-white border-2 border-white shadow-xs flex items-center gap-1">
                                <i class="ti ti-check text-xs"></i>
                                <span>Aktif</span>
                            </span>
                        @else
                            <span class="absolute -bottom-1.5 -right-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-600 text-white border-2 border-white shadow-xs flex items-center gap-1">
                                <i class="ti ti-x text-xs"></i>
                                <span>Off</span>
                            </span>
                        @endif
                    </div>

                    <!-- Name & Sub-details -->
                    <div class="space-y-1 sm:pb-2">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                            <h2 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight">
                                {{ textCamelCase($karyawan->nama_lengkap) }}
                            </h2>
                            @if(!empty($karyawan->status_karyawan))
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    {{ $karyawan->status_karyawan }}
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-x-3 gap-y-1 text-xs text-slate-500 font-medium">
                            <span class="flex items-center gap-1 text-slate-700 font-bold">
                                <i class="ti ti-barcode text-emerald-600 text-sm"></i>
                                <span>NPP: {{ $karyawan->npp }}</span>
                            </span>
                            <span class="text-slate-300">•</span>
                            <span class="flex items-center gap-1 text-amber-800 font-bold bg-amber-50 px-2 py-0.5 rounded border border-amber-200 text-[11px]">
                                <i class="ti ti-briefcase text-xs"></i>
                                <span>{{ $karyawan->nama_jabatan ?? 'Jabatan Belum Diatur' }}</span>
                            </span>
                            @if(!empty($karyawan->nama_dept))
                                <span class="text-slate-300">•</span>
                                <span class="flex items-center gap-1 text-blue-700 font-semibold bg-blue-50 px-2 py-0.5 rounded border border-blue-100 text-[11px]">
                                    <i class="ti ti-sitemap text-xs"></i>
                                    <span>{{ $karyawan->nama_dept }}</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right: Quick Action Pill Buttons -->
                <div class="flex flex-wrap items-center justify-center gap-2 sm:pb-2">
                    <button type="button" 
                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg text-xs font-bold transition active:scale-95 btnSetJamkerja cursor-pointer"
                            npp="{{ Crypt::encrypt($karyawan->npp) }}">
                        <i class="ti ti-clock text-sm"></i>
                        <span>Atur Jam Kerja</span>
                    </button>
                    <button type="button" 
                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-lg text-xs font-bold transition active:scale-95 btnSetharikerja cursor-pointer"
                            npp="{{ Crypt::encrypt($karyawan->npp) }}">
                        <i class="ti ti-calendar text-sm"></i>
                        <span>Hari Kerja</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= 3. TWO COLUMN SPECIFICATION GRID ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Column 1: Biodata & Data Pribadi -->
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs p-5 sm:p-6 space-y-4">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-200">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-base font-bold shadow-2xs">
                    <i class="ti ti-user-circle"></i>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900">1. Biodata & Data Pribadi</h3>
                    <p class="text-xs text-slate-500">Identitas kependudukan dan informasi kontak personal</p>
                </div>
            </div>

            <div class="divide-y divide-slate-100 text-xs">
                <!-- NIK / No KTP -->
                <div class="py-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-credit-card text-slate-400 text-sm"></i>
                        <span>NIK / No. KTP</span>
                    </span>
                    <span class="font-bold text-slate-900 font-mono text-sm bg-slate-50 px-2 py-0.5 rounded border border-slate-200">
                        {{ $karyawan->no_ktp ?? '-' }}
                    </span>
                </div>

                <!-- No Kartu Keluarga -->
                <div class="py-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-id-badge-2 text-slate-400 text-sm"></i>
                        <span>No. Kartu Keluarga (KK)</span>
                    </span>
                    <span class="font-bold text-slate-800 font-mono">
                        {{ $karyawan->no_kk ?? '-' }}
                    </span>
                </div>

                <!-- Tempat & Tgl Lahir -->
                <div class="py-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-cake text-slate-400 text-sm"></i>
                        <span>Tempat, Tanggal Lahir</span>
                    </span>
                    <span class="font-bold text-slate-800">
                        {{ textCamelCase($karyawan->tempat_lahir) }}, {{ !empty($karyawan->tanggal_lahir) ? DateToIndo($karyawan->tanggal_lahir) : '-' }}
                    </span>
                </div>

                <!-- Jenis Kelamin -->
                <div class="py-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-gender-intergender text-slate-400 text-sm"></i>
                        <span>Jenis Kelamin</span>
                    </span>
                    <span class="font-bold text-slate-800 inline-flex items-center gap-1">
                        @if($karyawan->jenis_kelamin == 'L')
                            <i class="ti ti-gender-male text-blue-600 text-sm"></i>
                            <span>Laki-Laki</span>
                        @elseif($karyawan->jenis_kelamin == 'P')
                            <i class="ti ti-gender-female text-rose-500 text-sm"></i>
                            <span>Perempuan</span>
                        @else
                            <span>-</span>
                        @endif
                    </span>
                </div>

                <!-- No WhatsApp / Handphone -->
                <div class="py-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-brand-whatsapp text-slate-400 text-sm"></i>
                        <span>No. WhatsApp / HP</span>
                    </span>
                    @if(!empty($karyawan->no_hp))
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $karyawan->no_hp)) }}" 
                           target="_blank"
                           class="font-bold text-emerald-700 hover:text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200 inline-flex items-center gap-1 transition">
                            <i class="ti ti-brand-whatsapp text-sm text-emerald-600"></i>
                            <span>{{ $karyawan->no_hp }}</span>
                            <i class="ti ti-external-link text-[10px] text-slate-400"></i>
                        </a>
                    @else
                        <span class="font-bold text-slate-400">-</span>
                    @endif
                </div>

                <!-- Pendidikan Terakhir -->
                <div class="py-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-school text-slate-400 text-sm"></i>
                        <span>Pendidikan Terakhir</span>
                    </span>
                    <span class="font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                        {{ $karyawan->pendidikan_terakhir ?? '-' }}
                    </span>
                </div>

                <!-- Alamat KTP -->
                <div class="py-2.5 flex flex-col gap-1">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-map-pin text-slate-400 text-sm"></i>
                        <span>Alamat Sesuai KTP:</span>
                    </span>
                    <p class="font-semibold text-slate-800 bg-slate-50/80 p-2.5 rounded-lg border border-slate-200 leading-relaxed">
                        {{ $karyawan->alamat_ktp ?? '-' }}
                    </p>
                </div>

                <!-- Alamat Domisili -->
                <div class="py-2.5 flex flex-col gap-1">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-home text-slate-400 text-sm"></i>
                        <span>Alamat Domisili / Tempat Tinggal Sekarang:</span>
                    </span>
                    <p class="font-semibold text-slate-800 bg-slate-50/80 p-2.5 rounded-lg border border-slate-200 leading-relaxed">
                        {{ $karyawan->alamat_tinggal ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Column 2: Data Kepegawaian & Penempatan -->
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs p-5 sm:p-6 space-y-4">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-200">
                <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-base font-bold shadow-2xs">
                    <i class="ti ti-briefcase"></i>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900">2. Kepegawaian & Penempatan</h3>
                    <p class="text-xs text-slate-500">Unit kerja, struktur jabatan, hari kerja, dan akun sistem</p>
                </div>
            </div>

            <div class="divide-y divide-slate-100 text-xs">
                <!-- Unit Penempatan -->
                <div class="py-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-building text-slate-400 text-sm"></i>
                        <span>Unit Kerja Penempatan</span>
                    </span>
                    <span class="font-extrabold text-slate-900 uppercase bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200">
                        {{ $karyawan->nama_unit ?? '-' }}
                    </span>
                </div>

                <!-- Departemen -->
                <div class="py-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-sitemap text-slate-400 text-sm"></i>
                        <span>Departemen</span>
                    </span>
                    <span class="font-bold text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded border border-blue-100">
                        {{ $karyawan->nama_dept ?? 'Umum / Tidak Ada' }}
                    </span>
                </div>

                <!-- Jabatan -->
                <div class="py-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-id text-slate-400 text-sm"></i>
                        <span>Jabatan Struktural / Fungsional</span>
                    </span>
                    <span class="font-bold text-amber-800 bg-amber-50 px-2.5 py-0.5 rounded border border-amber-200">
                        {{ $karyawan->nama_jabatan ?? '-' }}
                    </span>
                </div>

                <!-- Status Kepegawaian -->
                <div class="py-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-badge text-slate-400 text-sm"></i>
                        <span>Status Kepegawaian</span>
                    </span>
                    <span class="font-bold text-slate-800">
                        {{ $karyawan->status_karyawan ?? '-' }}
                    </span>
                </div>

                <!-- TMT (Terhitung Mulai Tugas) -->
                <div class="py-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-calendar-event text-slate-400 text-sm"></i>
                        <span>TMT (Mulai Bertugas)</span>
                    </span>
                    <span class="font-bold text-slate-900 bg-emerald-50 text-emerald-800 px-2.5 py-0.5 rounded border border-emerald-200">
                        {{ !empty($karyawan->tmt) ? DateToIndo($karyawan->tmt) : '-' }}
                    </span>
                </div>

                <!-- Hari Kerja Mingguan -->
                <div class="py-2.5 flex flex-col gap-1.5">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-calendar-check text-slate-400 text-sm"></i>
                        <span>Hari Kerja Mingguan:</span>
                    </span>
                    <div class="flex flex-wrap items-center gap-1.5">
                        @php
                            $workDays = !empty($karyawan->hari_kerja) ? explode(',', $karyawan->hari_kerja) : [];
                            $allDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        @endphp
                        @foreach($allDays as $day)
                            @php
                                $isWork = in_array(trim($day), array_map('trim', $workDays)) || in_array(strtolower(trim($day)), array_map('strtolower', array_map('trim', $workDays)));
                            @endphp
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $isWork ? 'bg-emerald-600 text-white shadow-2xs' : 'bg-slate-100 text-slate-400 border border-slate-200' }}">
                                {{ $day }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Akun Login Sistem -->
                <div class="py-2.5 flex flex-col gap-1.5">
                    <span class="text-slate-500 font-medium flex items-center gap-1.5">
                        <i class="ti ti-shield-lock text-slate-400 text-sm"></i>
                        <span>Akun Login Sistem:</span>
                    </span>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-medium">Username / Login:</span>
                            <span class="font-bold text-slate-900 font-mono">{{ $karyawan->npp }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-medium">Email Terdaftar:</span>
                            <span class="font-bold text-slate-700 font-mono">{{ strtolower(removeTitik($karyawan->npp)) }}@persisalamin.com</span>
                        </div>
                        <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-200/80">
                            <span class="text-slate-500 font-medium">Status Akun:</span>
                            <span class="text-emerald-700 font-bold flex items-center gap-1">
                                <i class="ti ti-circle-check text-xs"></i>
                                <span>Akun Aktif (Role: Karyawan)</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- ================= MODAL CONTAINERS ================= -->
<x-modal-form id="mdleditKaryawan" size="modal-xl" show="loadeditKaryawan" title="" icon="ti ti-user-edit" />
<x-modal-form id="mdlsetharikerja" size="modal-lg" show="loadsetharikerja" title="" icon="ti ti-calendar-check" />
<x-modal-form id="modalSetJamkerja" size="modal-xl" show="loadmodalSetJamkerja" title="" icon="ti ti-clock-plus" />

@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `
            <div class="p-12 text-center bg-white">
                <div class="w-10 h-10 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                <div class="text-xs font-bold text-slate-700">Memuat Data Karyawan...</div>
            </div>
        `;

        $(document).on('click', '.editKaryawan', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var npp = $(this).attr("npp");
            $('#mdleditKaryawan').modal("show");
            $("#mdleditKaryawan").find("#loadeditKaryawan").html(loading);
            $("#mdleditKaryawan").find(".modal-title").text("Edit Profil & Data Karyawan");
            $("#loadeditKaryawan").load('/karyawan/' + npp + '/edit');
        });

        $(document).on('click', ".btnSetharikerja", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var npp = $(this).attr("npp");
            $('#mdlsetharikerja').modal("show");
            $("#mdlsetharikerja").find("#loadsetharikerja").html(loading);
            $("#mdlsetharikerja").find(".modal-title").text("Atur Hari Kerja Pegawai");
            $("#loadsetharikerja").load('/karyawan/' + npp + '/setharikerja');
        });

        $(document).on('click', ".btnSetJamkerja", function(e) {
            e.preventDefault();
            e.stopPropagation();
            const npp = $(this).attr("npp");
            $("#modalSetJamkerja").modal("show");
            $("#modalSetJamkerja").find("#loadmodalSetJamkerja").html(loading);
            $("#modalSetJamkerja").find(".modal-title").text("Atur Shift & Jadwal Jam Kerja");
            $("#loadmodalSetJamkerja").load(`/karyawan/${npp}/setjamkerja`);
        });
    });
</script>
@endpush
