<form action="{{ route('biaya.duplicate-ta.store') }}" method="POST" id="formDuplicateTa" class="space-y-4">
    @csrf

    <!-- Callout Banner -->
    <div class="flex items-start gap-3 p-3.5 bg-sky-50/80 border border-sky-200/80 rounded-xl text-sky-900">
        <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-copy"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-sky-950">Salin Massal Paket Biaya Antar Tahun Ajaran</p>
            <p class="text-sky-700/90 mt-0.5 leading-relaxed">
                Fitur ini akan menyalin seluruh paket konfigurasi biaya beserta semua rincian tarif komponennya dari tahun ajaran asal ke tahun ajaran tujuan baru secara otomatis.
            </p>
        </div>
    </div>

    <!-- Pilihan Tahun Ajaran Asal & Tujuan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Tahun Ajaran Asal -->
        <div class="space-y-1.5">
            <label for="kode_ta_from" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-calendar-minus text-slate-400"></i>
                <span>Tahun Ajaran Asal (Sumber) <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <select name="kode_ta_from" 
                        id="kode_ta_from" 
                        required
                        class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 outline-none transition cursor-pointer">
                    <option value="">-- Pilih Tahun Ajaran Asal --</option>
                    @foreach ($tahunajaran as $d)
                        <option value="{{ $d->kode_ta }}">
                            {{ $d->tahun_ajaran }} {{ $d->status == '1' ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Tahun Ajaran Tujuan -->
        <div class="space-y-1.5">
            <label for="kode_ta_to" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-calendar-plus text-emerald-600"></i>
                <span>Tahun Ajaran Baru (Tujuan) <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <select name="kode_ta_to" 
                        id="kode_ta_to" 
                        required
                        class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition cursor-pointer">
                    <option value="">-- Pilih Tahun Ajaran Baru --</option>
                    @foreach ($tahunajaran as $d)
                        <option value="{{ $d->kode_ta }}" {{ $d->status == '1' ? 'selected' : '' }}>
                            {{ $d->tahun_ajaran }} {{ $d->status == '1' ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Filter Jenjang / Unit (Opsional) -->
    <div class="space-y-1.5">
        <label for="kode_unit_dup" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-building text-slate-400"></i>
            <span>Jenjang / Unit Pendidikan</span>
        </label>
        <div class="relative">
            <select name="kode_unit" 
                    id="kode_unit_dup" 
                    class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-sky-500/20 focus:border-sky-600 outline-none transition cursor-pointer">
                <option value="">-- Salin Semua Unit / Jenjang --</option>
                @foreach ($unit as $u)
                    <option value="{{ $u->kode_unit }}">{{ strtoupper($u->nama_unit) }}</option>
                @endforeach
            </select>
        </div>
        <p class="text-[11px] text-slate-400">Biarkan "Salin Semua Unit" jika ingin menduplikasi seluruh jenjang sekaligus.</p>
    </div>

    <!-- Opsi Penanganan Data Duplikat -->
    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
        <div class="flex items-center gap-2.5">
            <input type="checkbox" name="overwrite" value="1" id="checkOverwrite" class="w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500 cursor-pointer">
            <label for="checkOverwrite" class="text-xs font-bold text-slate-700 select-none cursor-pointer">
                Timpa / Update jika paket biaya sudah ada di TA tujuan
            </label>
        </div>
        <p class="text-[11px] text-slate-500 pl-6">
            Jika dicentang, paket biaya yang sudah ada di TA tujuan akan ditimpa dengan rincian dari TA asal. Jika tidak dicentang, paket yang sudah ada akan dilewati.
        </p>
    </div>

    <!-- Modal Footer Actions -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
        <button type="button" data-bs-dismiss="modal" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
            Batal
        </button>
        <button type="submit" id="btnSubmitDuplicateTa" class="inline-flex items-center gap-2 px-5 py-2 bg-sky-600 hover:bg-sky-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer active:scale-95">
            <i class="ti ti-copy text-base"></i>
            <span>Proses Duplikasi</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formDuplicateTa");

        form.submit(function(e) {
            const from = form.find("#kode_ta_from").val();
            const to = form.find("#kode_ta_to").val();

            if (!from) {
                Swal.fire({ title: "Oops!", text: "Silahkan pilih Tahun Ajaran Asal (Sumber)!", icon: "warning", confirmButtonColor: "#0284c7" });
                return false;
            }
            if (!to) {
                Swal.fire({ title: "Oops!", text: "Silahkan pilih Tahun Ajaran Baru (Tujuan)!", icon: "warning", confirmButtonColor: "#0284c7" });
                return false;
            }
            if (from === to) {
                Swal.fire({ title: "Tahun Ajaran Sama!", text: "Tahun Ajaran Asal dan Tujuan tidak boleh sama.", icon: "warning", confirmButtonColor: "#0284c7" });
                return false;
            }

            form.find("#btnSubmitDuplicateTa").prop("disabled", true).html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Memproses Duplikasi...</span>
            `);
        });
    });
</script>
