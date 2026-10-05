<form action="{{ route('lk.cetakpembayaran') }}" method="POST" target="_blank" id="formPembayaran" class="space-y-4" novalidate>
    @csrf

    <!-- 1. Unit Sekolah -->
    <div class="space-y-1.5">
        <label for="kode_unit_bayar" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-building text-emerald-600 text-sm"></i>
            <span>Unit Sekolah</span>
            <span class="text-[11px] font-normal text-slate-400">(Opsional - Kosongkan untuk semua unit)</span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 z-10">
                <i class="ti ti-building text-base"></i>
            </div>
            <select name="kode_unit" 
                    id="kode_unit_bayar" 
                    class="select-kode-unit w-full pl-10 pr-9 py-2.5 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition appearance-none cursor-pointer">
                <option value="">-- Semua Unit Sekolah --</option>
                @foreach ($unit as $d)
                    <option value="{{ $d->kode_unit }}">{{ textUpperCase($d->nama_unit) }}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                <i class="ti ti-chevron-down text-xs"></i>
            </div>
        </div>
    </div>

    <!-- 2. Tingkat / Jenjang Kelas -->
    <div class="space-y-1.5">
        <label for="tingkat_bayar" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-stairs text-emerald-600 text-sm"></i>
            <span>Tingkat / Jenjang</span>
            <span class="text-[11px] font-normal text-slate-400">(Opsional - Kosongkan untuk semua tingkat)</span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 z-10">
                <i class="ti ti-stairs text-base"></i>
            </div>
            <select name="tingkat" 
                    id="tingkat_bayar" 
                    class="select-tingkat w-full pl-10 pr-9 py-2.5 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition appearance-none cursor-pointer">
                <option value="">-- Semua Tingkat --</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                <i class="ti ti-chevron-down text-xs"></i>
            </div>
        </div>
    </div>

    <!-- 3. Periode Tanggal -->
    <div class="space-y-1.5">
        <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-calendar-event text-emerald-600 text-sm"></i>
            <span>Periode Tanggal Pembayaran <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <!-- Dari Tanggal -->
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 z-10">
                    <i class="ti ti-calendar text-base text-emerald-600"></i>
                </div>
                <input type="text" 
                       name="dari" 
                       id="dari" 
                       placeholder="Dari Tanggal" 
                       required
                       autocomplete="off"
                       class="flatpickr-date w-full pl-10 pr-3.5 py-2.5 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Sampai Tanggal -->
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 z-10">
                    <i class="ti ti-calendar text-base text-emerald-600"></i>
                </div>
                <input type="text" 
                       name="sampai" 
                       id="sampai" 
                       placeholder="Sampai Tanggal" 
                       required
                       autocomplete="off"
                       class="flatpickr-date w-full pl-10 pr-3.5 py-2.5 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Pilih rentang tanggal transaksi pembayaran yang akan dicetak.</p>
    </div>

    <!-- Info Banner Inside Form -->
    <div class="p-3.5 bg-emerald-50/70 border border-emerald-200/80 rounded-xl flex items-start gap-2.5">
        <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-xs font-bold mt-0.5">
            <i class="ti ti-info-circle"></i>
        </div>
        <div class="text-xs text-slate-600 leading-relaxed">
            <span class="font-bold text-emerald-900">Histori Pembayaran Detail:</span> Laporan ini menyajikan nomor bukti, tanggal bayar, NIS, nama siswa, jenis biaya, dan total nominal yang masuk ke kas sekolah.
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="pt-3 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-12 gap-2.5">
        <div class="sm:col-span-8">
            <button type="submit" name="submitButton" value="1" class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs sm:text-sm shadow-xs transition-all duration-150 active:scale-95 cursor-pointer">
                <i class="ti ti-printer text-base"></i>
                <span>Cetak Laporan Pembayaran</span>
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
