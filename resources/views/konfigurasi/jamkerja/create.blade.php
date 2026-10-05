<form action="{{ route('jamkerja.store') }}" id="formcreateJamkerja" method="POST" novalidate class="space-y-4">
    @csrf

    <!-- Callout Info -->
    <div class="flex items-start gap-3 p-3.5 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-clock"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-emerald-950">Pengaturan Jam Shift Kerja</p>
            <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                Tentukan kode, rentang jam masuk, jam pulang, serta total jam kerja efektif untuk validasi presensi.
            </p>
        </div>
    </div>

    <!-- Kode & Nama Jam Kerja Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3.5">
        <!-- Kode Jam Kerja (4 cols) -->
        <div class="sm:col-span-4 space-y-1.5" id="group_kode_jam_kerja">
            <label for="kode_jam_kerja" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-barcode text-slate-400"></i>
                <span>Kode Shift <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-tag text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_kode_jam_kerja"></i>
                <input type="text" 
                       name="kode_jam_kerja" 
                       id="kode_jam_kerja" 
                       placeholder="Contoh: REG" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal uppercase">
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_kode_jam_kerja"></p>
        </div>

        <!-- Nama Jam Kerja (8 cols) -->
        <div class="sm:col-span-8 space-y-1.5" id="group_nama_jam_kerja">
            <label for="nama_jam_kerja" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-file-description text-slate-400"></i>
                <span>Nama Jam Kerja <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-typography text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_nama_jam_kerja"></i>
                <input type="text" 
                       name="nama_jam_kerja" 
                       id="nama_jam_kerja" 
                       placeholder="Contoh: Reguler Pagi, Shift Siang" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_nama_jam_kerja"></p>
        </div>
    </div>

    <!-- Jam Masuk & Jam Pulang Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Jam Masuk -->
        <div class="space-y-1.5" id="group_jam_masuk">
            <label for="jam_masuk" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-login text-slate-400"></i>
                <span>Jam Masuk <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-clock text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_jam_masuk"></i>
                <input type="text" 
                       name="jam_masuk" 
                       id="jam_masuk" 
                       placeholder="07:00" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all">
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_jam_masuk"></p>
        </div>

        <!-- Jam Pulang -->
        <div class="space-y-1.5" id="group_jam_pulang">
            <label for="jam_pulang" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-logout text-slate-400"></i>
                <span>Jam Pulang <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-clock text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_jam_pulang"></i>
                <input type="text" 
                       name="jam_pulang" 
                       id="jam_pulang" 
                       placeholder="15:00" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all">
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_jam_pulang"></p>
        </div>
    </div>

    <!-- Total Jam & Lintas Hari Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Total Jam -->
        <div class="space-y-1.5" id="group_total_jam">
            <label for="total_jam" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-hourglass-low text-slate-400"></i>
                <span>Total Jam Kerja (Jam) <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-calculator text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_total_jam"></i>
                <input type="number" 
                       name="total_jam" 
                       id="total_jam" 
                       step="0.5" 
                       min="1" 
                       placeholder="8" 
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all">
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_total_jam"></p>
        </div>

        <!-- Lintas Hari -->
        <div class="space-y-1.5" id="group_lintas_hari">
            <label for="lintas_hari" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-moon text-slate-400"></i>
                <span>Lintas Hari (Shift Malam) <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <select name="lintas_hari" 
                        id="lintas_hari" 
                        class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                    <option value="">-- Pilih Status Lintas Hari --</option>
                    <option value="0" selected>Tidak (Masuk & Pulang di Hari yang Sama)</option>
                    <option value="1">Ya (Pulang di Hari Berikutnya)</option>
                </select>
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_lintas_hari"></p>
        </div>
    </div>

    <!-- Modal Footer Actions -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
        <button type="button" 
                data-bs-dismiss="modal" 
                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
            Batal
        </button>
        <button type="submit" 
                id="btnSubmitJamkerja" 
                class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Jam Kerja</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $("#jam_masuk, #jam_pulang").mask("00:00");

        function showError($input, $group, $errorMsg, $icon, message) {
            $input.removeClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20")
                  .addClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20");
            if ($icon) $icon.removeClass("text-slate-400").addClass("text-rose-500");
            $errorMsg.html(`<i class="ti ti-alert-circle text-xs"></i> ${message}`).removeClass("hidden");
        }

        function clearError($input, $group, $errorMsg, $icon) {
            $input.removeClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20")
                  .addClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20");
            if ($icon) $icon.removeClass("text-rose-500").addClass("text-slate-400");
            $errorMsg.addClass("hidden").html("");
        }

        $("#kode_jam_kerja").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#group_kode_jam_kerja"), $("#error_kode_jam_kerja"), $("#icon_kode_jam_kerja"));
        });
        $("#nama_jam_kerja").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#group_nama_jam_kerja"), $("#error_nama_jam_kerja"), $("#icon_nama_jam_kerja"));
        });
        $("#jam_masuk").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#group_jam_masuk"), $("#error_jam_masuk"), $("#icon_jam_masuk"));
        });
        $("#jam_pulang").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#group_jam_pulang"), $("#error_jam_pulang"), $("#icon_jam_pulang"));
        });
        $("#total_jam").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#group_total_jam"), $("#error_total_jam"), $("#icon_total_jam"));
        });
        $("#lintas_hari").on("change", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#group_lintas_hari"), $("#error_lintas_hari"), null);
        });

        $('#formcreateJamkerja').on('submit', function(e) {
            let kode = $("#kode_jam_kerja").val().trim();
            let nama = $("#nama_jam_kerja").val().trim();
            let masuk = $("#jam_masuk").val().trim();
            let pulang = $("#jam_pulang").val().trim();
            let total = $("#total_jam").val().trim();
            let lintas = $("#lintas_hari").val().trim();
            let isValid = true;

            if (kode === "") {
                showError($("#kode_jam_kerja"), $("#group_kode_jam_kerja"), $("#error_kode_jam_kerja"), $("#icon_kode_jam_kerja"), "Kode jam kerja wajib diisi!");
                $("#kode_jam_kerja").focus();
                isValid = false;
            } else {
                clearError($("#kode_jam_kerja"), $("#group_kode_jam_kerja"), $("#error_kode_jam_kerja"), $("#icon_kode_jam_kerja"));
            }

            if (nama === "") {
                showError($("#nama_jam_kerja"), $("#group_nama_jam_kerja"), $("#error_nama_jam_kerja"), $("#icon_nama_jam_kerja"), "Nama jam kerja wajib diisi!");
                if (isValid) $("#nama_jam_kerja").focus();
                isValid = false;
            } else {
                clearError($("#nama_jam_kerja"), $("#group_nama_jam_kerja"), $("#error_nama_jam_kerja"), $("#icon_nama_jam_kerja"));
            }

            if (masuk === "") {
                showError($("#jam_masuk"), $("#group_jam_masuk"), $("#error_jam_masuk"), $("#icon_jam_masuk"), "Jam masuk wajib diisi!");
                if (isValid) $("#jam_masuk").focus();
                isValid = false;
            } else {
                clearError($("#jam_masuk"), $("#group_jam_masuk"), $("#error_jam_masuk"), $("#icon_jam_masuk"));
            }

            if (pulang === "") {
                showError($("#jam_pulang"), $("#group_jam_pulang"), $("#error_jam_pulang"), $("#icon_jam_pulang"), "Jam pulang wajib diisi!");
                if (isValid) $("#jam_pulang").focus();
                isValid = false;
            } else {
                clearError($("#jam_pulang"), $("#group_jam_pulang"), $("#error_jam_pulang"), $("#icon_jam_pulang"));
            }

            if (total === "") {
                showError($("#total_jam"), $("#group_total_jam"), $("#error_total_jam"), $("#icon_total_jam"), "Total jam kerja wajib diisi!");
                if (isValid) $("#total_jam").focus();
                isValid = false;
            } else {
                clearError($("#total_jam"), $("#group_total_jam"), $("#error_total_jam"), $("#icon_total_jam"));
            }

            if (lintas === "") {
                showError($("#lintas_hari"), $("#group_lintas_hari"), $("#error_lintas_hari"), null, "Pilih status lintas hari!");
                if (isValid) $("#lintas_hari").focus();
                isValid = false;
            } else {
                clearError($("#lintas_hari"), $("#group_lintas_hari"), $("#error_lintas_hari"), null);
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            $("#btnSubmitJamkerja").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitJamkerja").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>
