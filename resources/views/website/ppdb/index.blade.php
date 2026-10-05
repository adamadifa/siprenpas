@extends('layouts.app')
@section('titlepage', 'Pengaturan Dokumen PPDB')

@section('content')
<div class="space-y-6">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-file-text text-2xl"></i>
                </div>
                <span>Pengaturan Dokumen PPDB</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola brosur utama pendaftaran santri baru, brosur spesifik unit sekolah, dan infografis rincian biaya
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
                    <i class="ti ti-world text-sm"></i>
                    <span>Website</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">PPDB Setting</span>
            </nav>
        </div>
    </div>

    <!-- Main Form Container -->
    <form action="{{ route('ppdb-setting.store') }}" method="POST" enctype="multipart/form-data" id="formPpdbSetting" class="space-y-6">
        @csrf

        <!-- ================= 2. BROSUR UTAMA PESANTREN CARD ================= -->
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <!-- Solid Emerald Header -->
            <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2.5">
                    <i class="ti ti-files text-xl"></i>
                    <h3 class="font-bold text-sm tracking-wide text-white">Brosur Utama PPDB Pesantren</h3>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                    <i class="ti ti-world text-xs"></i> Publik Semua Unit
                </span>
            </div>

            <div class="p-5 sm:p-7 space-y-5">
                <!-- Callout Info -->
                <div class="flex items-start gap-3.5 p-4 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
                        <i class="ti ti-info-circle"></i>
                    </div>
                    <div class="text-xs">
                        <p class="font-bold text-emerald-950">Fungsi Brosur Utama</p>
                        <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                            Brosur utama memuat informasi global pendaftaran santri baru Pesantren Persatuan Islam 80 Al-Amin dan tampil di tombol unduh pada halaman depan (Landing Page).
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-center">
                    <!-- Upload Box -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                            <i class="ti ti-upload text-slate-400"></i>
                            <span>Pilih Berkas Brosur Utama Baru</span>
                        </label>
                        <div class="relative">
                            <input type="file" 
                                   name="brosur_utama" 
                                   id="brosur_utama" 
                                   accept=".pdf,.jpeg,.png,.jpg"
                                   class="w-full text-xs text-slate-700 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-300 rounded-xl p-1.5 bg-slate-50/50 cursor-pointer shadow-2xs">
                        </div>
                        <p class="text-[11px] text-slate-400">
                            Mendukung format PDF, PNG, JPG (Maks. 5MB). Kosongkan jika tidak ingin mengubah brosur utama.
                        </p>
                    </div>

                    <!-- Current File Status Box -->
                    <div class="p-4 rounded-xl border {{ $pengaturan && $pengaturan->brosur_utama ? 'bg-emerald-50/50 border-emerald-200/80' : 'bg-slate-50 border-dashed border-slate-200' }} text-center flex flex-col items-center justify-center">
                        @if($pengaturan && $pengaturan->brosur_utama)
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center mb-2">
                                <i class="ti ti-file-check text-xl"></i>
                            </div>
                            <p class="text-xs font-bold text-slate-800">Brosur Utama Aktif</p>
                            <span class="text-[11px] text-slate-400 truncate max-w-[200px] block mb-2">{{ basename($pengaturan->brosur_utama) }}</span>
                            <a href="{{ asset('storage/' . $pengaturan->brosur_utama) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-emerald-600 hover:text-white text-emerald-700 font-bold rounded-lg text-xs border border-emerald-300 shadow-2xs transition-all">
                                <i class="ti ti-download text-xs"></i>
                                <span>Unduh / Lihat</span>
                            </a>
                        @else
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mb-2">
                                <i class="ti ti-file-off text-xl"></i>
                            </div>
                            <p class="text-xs font-bold text-slate-600">Belum Ada Brosur</p>
                            <span class="text-[11px] text-slate-400">Silahkan pilih file untuk diunggah</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= 3. BROSUR & BIAYA PER UNIT CARD ================= -->
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <!-- Solid Emerald Header -->
            <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2.5">
                    <i class="ti ti-layout-grid text-xl"></i>
                    <div>
                        <h3 class="font-bold text-sm tracking-wide text-white">Brosur & Rincian Biaya per Unit Sekolah</h3>
                        <p class="text-[11px] text-emerald-100 font-medium">Unggah lampiran brosur dan tabel infografis biaya masing-masing jenjang</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                    Total: {{ count($units) }} Jenjang
                </span>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                            <th class="py-3.5 px-4 w-48">UNIT SEKOLAH</th>
                            <th class="py-3.5 px-4 w-1/3">BROSUR SPESIFIK UNIT (PDF/IMG)</th>
                            <th class="py-3.5 px-4 w-1/3">RINCIAN BIAYA FULL DAY</th>
                            <th class="py-3.5 px-4 w-1/3">RINCIAN BIAYA BOARDING</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                        @forelse ($units as $unit)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <!-- Unit Info -->
                                <td class="py-4 px-4 align-top">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200/80 p-1 shadow-2xs flex items-center justify-center shrink-0">
                                            @if ($unit->logo && Storage::disk('public')->exists($unit->logo))
                                                <img src="{{ asset('storage/' . $unit->logo) }}" alt="Logo" class="max-w-full max-h-full object-contain">
                                            @else
                                                <i class="ti ti-school text-xl text-slate-400"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-800 text-sm block leading-snug">
                                                {{ $unit->nama_unit }}
                                            </span>
                                            <span class="inline-block mt-0.5 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-mono text-[10px] font-bold border border-slate-200">
                                                Kode: {{ $unit->kode_unit }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Brosur Unit -->
                                <td class="py-4 px-4 align-top">
                                    <div class="space-y-2">
                                        <input type="file" 
                                               name="brosur_unit[{{ $unit->kode_unit }}]" 
                                               accept=".pdf,.jpeg,.png,.jpg"
                                               class="w-full text-xs text-slate-700 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-xl p-1 bg-white cursor-pointer shadow-2xs">
                                        
                                        @if ($unit->brosur_unit)
                                            <div class="flex items-center justify-between gap-2 p-2 bg-emerald-50/60 border border-emerald-200/70 rounded-xl">
                                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-800">
                                                    <i class="ti ti-file-check text-xs"></i>
                                                    <span>Tersedia</span>
                                                </span>
                                                <a href="{{ asset('storage/' . $unit->brosur_unit) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 bg-white hover:bg-emerald-700 hover:text-white text-emerald-700 font-bold rounded-lg text-[11px] border border-emerald-300 shadow-2xs transition-all">
                                                    <i class="ti ti-download text-[11px]"></i>
                                                    <span>Unduh</span>
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-[11px] text-slate-400 block italic">Belum ada berkas brosur unit</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Rincian Biaya Full Day -->
                                <td class="py-4 px-4 align-top">
                                    <div class="space-y-2">
                                        <input type="file" 
                                               name="rincian_biaya_fullday[{{ $unit->kode_unit }}]" 
                                               accept=".jpeg,.png,.jpg,.webp"
                                               class="w-full text-xs text-slate-700 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-xl p-1 bg-white cursor-pointer shadow-2xs">
                                        
                                        @if ($unit->rincian_biaya_fullday)
                                            <div class="flex items-center justify-between gap-2 p-2 bg-blue-50/60 border border-blue-200/70 rounded-xl">
                                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-800">
                                                    <i class="ti ti-photo-check text-xs"></i>
                                                    <span>Tersedia</span>
                                                </span>
                                                <a href="{{ asset('storage/' . $unit->rincian_biaya_fullday) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 bg-white hover:bg-blue-700 hover:text-white text-blue-700 font-bold rounded-lg text-[11px] border border-blue-300 shadow-2xs transition-all">
                                                    <i class="ti ti-eye text-[11px]"></i>
                                                    <span>Lihat Gambar</span>
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-[11px] text-slate-400 block italic">Belum ada rincian fullday</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Rincian Biaya Boarding -->
                                <td class="py-4 px-4 align-top">
                                    <div class="space-y-2">
                                        <input type="file" 
                                               name="rincian_biaya_boarding[{{ $unit->kode_unit }}]" 
                                               accept=".jpeg,.png,.jpg,.webp"
                                               class="w-full text-xs text-slate-700 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 border border-slate-200 rounded-xl p-1 bg-white cursor-pointer shadow-2xs">
                                        
                                        @if ($unit->rincian_biaya_boarding)
                                            <div class="flex items-center justify-between gap-2 p-2 bg-purple-50/60 border border-purple-200/70 rounded-xl">
                                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-purple-800">
                                                    <i class="ti ti-photo-check text-xs"></i>
                                                    <span>Tersedia</span>
                                                </span>
                                                <a href="{{ asset('storage/' . $unit->rincian_biaya_boarding) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 bg-white hover:bg-purple-700 hover:text-white text-purple-700 font-bold rounded-lg text-[11px] border border-purple-300 shadow-2xs transition-all">
                                                    <i class="ti ti-eye text-[11px]"></i>
                                                    <span>Lihat Gambar</span>
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-[11px] text-slate-400 block italic">Belum ada rincian boarding</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400">
                                    <p class="font-bold text-sm">Tidak ada data unit sekolah tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= 4. FLOATING / BOTTOM SUBMIT BAR ================= -->
        <div class="pt-2 flex justify-end">
            <button type="submit" id="btnSubmitPpdb" class="inline-flex items-center gap-2 px-7 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer active:scale-95">
                <i class="ti ti-device-floppy text-lg"></i>
                <span>Simpan Seluruh Pengaturan Dokumen PPDB</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        $("#formPpdbSetting").on("submit", function() {
            $("#btnSubmitPpdb").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitPpdb").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Mengunggah & Menyimpan Pengaturan...</span>
            `);
        });
    });
</script>
@endpush
