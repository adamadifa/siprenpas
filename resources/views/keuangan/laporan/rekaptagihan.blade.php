<form action="{{ route('lk.cetakrekaptagihan') }}" method="POST" target="_blank" id="formRekapTagihan" class="space-y-4" novalidate>
    @csrf

    <!-- 1. Unit Sekolah -->
    <div class="space-y-1.5">
        <label for="kode_unit_rekap" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-building text-emerald-600 text-sm"></i>
            <span>Unit Sekolah <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 z-10">
                <i class="ti ti-building text-base"></i>
            </div>
            <select name="kode_unit" 
                    id="kode_unit_rekap" 
                    class="select-kode-unit w-full pl-10 pr-9 py-2.5 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition appearance-none cursor-pointer">
                <option value="">-- Pilih Unit Sekolah --</option>
                @foreach ($unit as $d)
                    <option value="{{ $d->kode_unit }}">{{ textUpperCase($d->nama_unit) }}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                <i class="ti ti-chevron-down text-xs"></i>
            </div>
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Pilih unit lembaga pendidikan untuk memuat rombel tingkat kelas.</p>
    </div>

    <!-- 2. Tingkat / Jenjang Kelas -->
    <div class="space-y-1.5">
        <label for="tingkat_rekap" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-stairs text-emerald-600 text-sm"></i>
            <span>Tingkat / Jenjang <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 z-10">
                <i class="ti ti-stairs text-base"></i>
            </div>
            <select name="tingkat" 
                    id="tingkat_rekap" 
                    class="select-tingkat w-full pl-10 pr-9 py-2.5 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition appearance-none cursor-pointer">
                <option value="">-- Pilih Tingkat --</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                <i class="ti ti-chevron-down text-xs"></i>
            </div>
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Pilih tingkat rombel kelas yang akan direkapitulasi tagihannya.</p>
    </div>

    <!-- 3. Tahun Ajaran -->
    <div class="space-y-1.5">
        <label for="kode_ta_rekap" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-calendar-time text-emerald-600 text-sm"></i>
            <span>Tahun Ajaran <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 z-10">
                <i class="ti ti-calendar-time text-base"></i>
            </div>
            <select name="kode_ta" 
                    id="kode_ta_rekap" 
                    class="w-full pl-10 pr-9 py-2.5 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition appearance-none cursor-pointer">
                <option value="">-- Pilih Tahun Ajaran --</option>
                @foreach ($tahunajaran as $d)
                    <option value="{{ $d->kode_ta }}"
                        @if (Request('kode_ta') == $d->kode_ta) selected @elseif ($tahun_ajaran && $tahun_ajaran->kode_ta == $d->kode_ta) selected @endif>
                        {{ $d->tahun_ajaran }}
                    </option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                <i class="ti ti-chevron-down text-xs"></i>
            </div>
        </div>
    </div>

    <!-- Info Banner Inside Form -->
    <div class="p-3.5 bg-emerald-50/70 border border-emerald-200/80 rounded-xl flex items-start gap-2.5">
        <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-xs font-bold mt-0.5">
            <i class="ti ti-info-circle"></i>
        </div>
        <div class="text-xs text-slate-600 leading-relaxed">
            <span class="font-bold text-emerald-900">Rekapitulasi Tagihan Lengkap:</span> Laporan ini akan merinci seluruh komponen tagihan biaya santri, potongan/beasiswa, mutasi, dan total saldo tagihan berjalan.
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="pt-3 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-12 gap-2.5">
        <div class="sm:col-span-8">
            <button type="submit" name="submitButton" value="1" class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs sm:text-sm shadow-xs transition-all duration-150 active:scale-95 cursor-pointer">
                <i class="ti ti-printer text-base"></i>
                <span>Cetak Laporan Tagihan</span>
            </button>
        </div>
        <div class="sm:col-span-4">
            <button type="submit" name="exportButton" value="1" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300/80 font-bold rounded-xl text-xs sm:text-sm transition-all duration-150 active:scale-95 cursor-pointer shadow-2xs">
                <i class="ti ti-file-spreadsheet text-base text-emerald-600"></i>
                <span>Export Excel</span>
            </button>
        </div>
    </div>
</form>
