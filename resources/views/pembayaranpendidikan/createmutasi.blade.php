<form action="#" method="post" id="formMutasi" class="space-y-4">
    @csrf
    <input type="hidden" name="no_pendaftaran" value="{{ $no_pendaftaran }}">
    <input type="hidden" name="kode_jenis_biaya" value="{{ $kode_jenis_biaya }}">
    <input type="hidden" name="kode_biaya" value="{{ $kode_biaya }}">

    <!-- Jumlah Mutasi -->
    <div class="space-y-1.5">
        <label for="jumlah" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-arrows-exchange text-sm text-slate-400"></i>
            <span>Jumlah Mutasi (Rp) <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-xs font-bold text-sky-600">
                Rp
            </div>
            <input type="text" 
                   id="jumlah" 
                   name="jumlah" 
                   value="{{ $mutasi != null ? formatAngka($mutasi->jumlah_mutasi) : '' }}" 
                   placeholder="0" 
                   required
                   class="money w-full pl-9 pr-3.5 py-2.5 text-sm font-mono font-bold text-right text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
    </div>

    <!-- Keterangan -->
    <div class="space-y-1.5">
        <label for="keterangan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-notes text-sm text-slate-400"></i>
            <span>Keterangan Mutasi <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <textarea id="keterangan" 
                  name="keterangan" 
                  rows="3" 
                  required
                  placeholder="Contoh: Pengalihan Biaya dari Pendaftaran Lama..." 
                  class="w-full px-3.5 py-2.5 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">{{ $mutasi != null ? $mutasi->keterangan : '' }}</textarea>
    </div>

    <!-- Footer Actions -->
    <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Mutasi</span>
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#jumlah").maskMoney({
            thousands: '.',
            decimal: ',',
            precision: 0
        });
    });
</script>
