<form action="{{ route('tahunajaranppdb.store') }}" id="formcreateTahunajaranppdb" method="POST" novalidate class="space-y-4">
    @csrf

    <!-- Callout Info -->
    <div class="flex items-start gap-3 p-3.5 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-info-circle"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-emerald-950">Periode PPDB Baru</p>
            <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                Gunakan format 4 digit tahun (contoh: <strong class="font-mono">2025/2026</strong>). Kode TA PPDB otomatis dihasilkan oleh sistem.
            </p>
        </div>
    </div>

    <!-- Input Tahun Ajaran PPDB -->
    <div class="space-y-1.5" id="group_tahun_ajaran">
        <label for="tahun_ajaran" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-school text-slate-400"></i>
            <span>Tahun Ajaran PPDB <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <i class="ti ti-calendar text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_tahun_ajaran"></i>
            <input type="text" 
                   name="tahun_ajaran" 
                   id="tahun_ajaran" 
                   placeholder="2025/2026" 
                   autocomplete="off"
                   class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
        </div>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_tahun_ajaran"></p>
    </div>

    <!-- Input Status Keaktifan -->
    <div class="space-y-1.5" id="group_status">
        <label for="status" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-toggle-right text-slate-400"></i>
            <span>Status Keaktifan PPDB <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <select name="status" 
                    id="status" 
                    class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                <option value="">-- Pilih Status --</option>
                <option value="1">Aktif (Buka Pendaftaran)</option>
                <option value="0">Non-Aktif (Tutup)</option>
            </select>
        </div>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_status"></p>
    </div>

    <!-- Modal Footer Actions -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
        <button type="button" 
                data-bs-dismiss="modal" 
                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
            Batal
        </button>
        <button type="submit" 
                id="btnSubmitTahunajaranppdb" 
                class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Data</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $('#tahun_ajaran').mask('0000/0000');

        function showError($input, $errorMsg, $icon, message) {
            $input.removeClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20")
                  .addClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20");
            if ($icon) $icon.removeClass("text-slate-400").addClass("text-rose-500");
            $errorMsg.html(`<i class="ti ti-alert-circle text-xs"></i> ${message}`).removeClass("hidden");
        }

        function clearError($input, $errorMsg, $icon) {
            $input.removeClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20")
                  .addClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20");
            if ($icon) $icon.removeClass("text-rose-500").addClass("text-slate-400");
            $errorMsg.addClass("hidden").html("");
        }

        $("#tahun_ajaran").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#error_tahun_ajaran"), $("#icon_tahun_ajaran"));
        });
        $("#status").on("change", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#error_status"), null);
        });

        $('#formcreateTahunajaranppdb').on('submit', function(e) {
            let ta = $("#tahun_ajaran").val().trim();
            let st = $("#status").val().trim();
            let isValid = true;

            if (ta === "") {
                showError($("#tahun_ajaran"), $("#error_tahun_ajaran"), $("#icon_tahun_ajaran"), "Tahun ajaran PPDB wajib diisi!");
                $("#tahun_ajaran").focus();
                isValid = false;
            } else if (ta.length < 9) {
                showError($("#tahun_ajaran"), $("#error_tahun_ajaran"), $("#icon_tahun_ajaran"), "Format harus 4 digit tahun (contoh: 2025/2026)!");
                $("#tahun_ajaran").focus();
                isValid = false;
            } else {
                clearError($("#tahun_ajaran"), $("#error_tahun_ajaran"), $("#icon_tahun_ajaran"));
            }

            if (st === "") {
                showError($("#status"), $("#error_status"), null, "Pilih status keaktifan PPDB!");
                if (isValid) $("#status").focus();
                isValid = false;
            } else {
                clearError($("#status"), $("#error_status"), null);
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            $("#btnSubmitTahunajaranppdb").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitTahunajaranppdb").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>
