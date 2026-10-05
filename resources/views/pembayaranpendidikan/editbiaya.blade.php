<form action="" id="formEditBiaya" class="space-y-4">
    @csrf
    <input type="hidden" name="no_pendaftaran" value="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}">
    <input type="hidden" name="old_kode_biaya" value="{{ Crypt::encrypt($old_kode_biaya) }}">

    <!-- Warning Alert -->
    <div class="p-3.5 bg-amber-50 border border-amber-200 text-amber-900 rounded-xl text-xs flex items-start gap-2.5">
        <i class="ti ti-alert-triangle text-amber-600 text-base shrink-0 mt-0.5"></i>
        <div class="leading-relaxed">
            Mengubah konfigurasi biaya akan <strong>menghapus rencana SPP, potongan, dan mutasi</strong> yang telah dikonfigurasi pada biaya sebelumnya.
        </div>
    </div>

    <!-- Pilih Konfigurasi Biaya -->
    <div class="space-y-1.5">
        <label for="new_kode_biaya" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-settings text-sm text-slate-400"></i>
            <span>Pilih Konfigurasi Biaya Baru <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-building-community text-base"></i>
            </div>
            <select name="new_kode_biaya" id="new_kode_biaya" 
                    class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer" required>
                <option value="">-- Pilih Konfigurasi Biaya --</option>
                @foreach ($available_biayas as $biaya)
                    <option value="{{ $biaya->kode_biaya }}" {{ $biaya->kode_biaya == $old_kode_biaya ? 'selected' : '' }}>
                        {{ $biaya->kode_biaya }} - {{ $biaya->asrama == 1 ? 'Asrama' : 'Non-Asrama/Reguler' }} {{ $biaya->is_pindahan == 1 ? '(Pindahan)' : '' }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Footer Actions -->
    <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSimpanEditBiaya" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</form>
