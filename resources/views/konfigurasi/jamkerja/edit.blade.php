<form action="{{ route('jamkerja.update', Crypt::encrypt($jamkerja->kode_jam_kerja)) }}" id="formeditJamkerja" method="POST" novalidate class="space-y-4">
    @csrf
    @method('PUT')

    <!-- Callout Info -->
    <div class="flex items-start gap-3 p-3.5 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-edit"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-emerald-950">Perbarui Pengaturan Jam Kerja</p>
            <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                Penyesuaian jam masuk dan pulang akan berlaku untuk perhitungan presensi dan keterlambatan selanjutnya.
            </p>
        </div>
    </div>

    <!-- Kode & Nama Jam Kerja Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3.5">
        <!-- Kode Jam Kerja (4 cols) -->
        <div class="sm:col-span-4 space-y-1.5">
            <label for="kode_jam_kerja_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-barcode text-slate-400"></i>
                <span>Kode Shift</span>
            </label>
            <div class="relative">
                <i class="ti ti-tag text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors"></i>
                <input type="text" 
                       name="kode_jam_kerja" 
                       id="kode_jam_kerja_edit" 
                       value="{{ $jamkerja->kode_jam_kerja }}"
                       readonly 
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono font-bold text-slate-500 bg-slate-100 border border-slate-200 rounded-xl outline-none cursor-not-allowed uppercase">
            </div>
        </div>

        <!-- Nama Jam Kerja (8 cols) -->
        <div class="sm:col-span-8 space-y-1.5" id="group_nama_jam_kerja_edit">
            <label for="nama_jam_kerja_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-file-description text-slate-400"></i>
                <span>Nama Jam Kerja <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-typography text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_nama_jam_kerja_edit"></i>
                <input type="text" 
                       name="nama_jam_kerja" 
                       id="nama_jam_kerja_edit" 
                       value="{{ old('nama_jam_kerja', $jamkerja->nama_jam_kerja) }}"
                       placeholder="Contoh: Reguler Pagi, Shift Siang" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_nama_jam_kerja_edit"></p>
        </div>
    </div>

    <!-- Jam Masuk & Jam Pulang Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Jam Masuk -->
        <div class="space-y-1.5" id="group_jam_masuk_edit">
            <label for="jam_masuk_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-login text-slate-400"></i>
                <span>Jam Masuk <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-clock text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_jam_masuk_edit"></i>
                <input type="text" 
                       name="jam_masuk" 
                       id="jam_masuk_edit" 
                       value="{{ old('jam_masuk', $jamkerja->jam_masuk) }}"
                       placeholder="07:00" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all">
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_jam_masuk_edit"></p>
        </div>

        <!-- Jam Pulang -->
        <div class="space-y-1.5" id="group_jam_pulang_edit">
            <label for="jam_pulang_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-logout text-slate-400"></i>
                <span>Jam Pulang <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-clock text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_jam_pulang_edit"></i>
                <input type="text" 
                       name="jam_pulang" 
                       id="jam_pulang_edit" 
                       value="{{ old('jam_pulang', $jamkerja->jam_pulang) }}"
                       placeholder="15:00" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all">
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_jam_pulang_edit"></p>
        </div>
    </div>

    <!-- Total Jam & Lintas Hari Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Total Jam -->
        <div class="space-y-1.5" id="group_total_jam_edit">
            <label for="total_jam_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-hourglass-low text-slate-400"></i>
                <span>Total Jam Kerja (Jam) <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-calculator text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_total_jam_edit"></i>
                <input type="number" 
                       name="total_jam" 
                       id="total_jam_edit" 
                       step="0.5" 
                       min="1" 
                       value="{{ old('total_jam', $jamkerja->total_jam) }}"
                       placeholder="8" 
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all">
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_total_jam_edit"></p>
        </div>

        <!-- Lintas Hari -->
        <div class="space-y-1.5" id="group_lintas_hari_edit">
            <label for="lintas_hari_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-moon text-slate-400"></i>
                <span>Lintas Hari (Shift Malam) <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <select name="lintas_hari" 
                        id="lintas_hari_edit" 
                        class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                    <option value="">-- Pilih Status Lintas Hari --</option>
                    <option value="0" {{ $jamkerja->lintas_hari == 0 ? 'selected' : '' }}>Tidak (Masuk & Pulang di Hari yang Sama)</option>
                    <option value="1" {{ $jamkerja->lintas_hari == 1 ? 'selected' : '' }}>Ya (Pulang di Hari Berikutnya)</option>
                </select>
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_lintas_hari_edit"></p>
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
                id="btnSubmitJamkerjaEdit" 
                class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Perbarui Jam Kerja</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $("#jam_masuk_edit, #jam_pulang_edit").mask("00:00");

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

        $("#nama_jam_kerja_edit").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#group_nama_jam_kerja_edit"), $("#error_nama_jam_kerja_edit"), $("#icon_nama_jam_kerja_edit"));
        });
        $("#jam_masuk_edit").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#group_jam_masuk_edit"), $("#error_jam_masuk_edit"), $("#icon_jam_masuk_edit"));
        });
        $("#jam_pulang_edit").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#group_jam_pulang_edit"), $("#error_jam_pulang_edit"), $("#icon_jam_pulang_edit"));
        });
        $("#total_jam_edit").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#group_total_jam_edit"), $("#error_total_jam_edit"), $("#icon_total_jam_edit"));
        });
        $("#lintas_hari_edit").on("change", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#group_lintas_hari_edit"), $("#error_lintas_hari_edit"), null);
        });

        $('#formeditJamkerja').on('submit', function(e) {
            let nama = $("#nama_jam_kerja_edit").val().trim();
            let masuk = $("#jam_masuk_edit").val().trim();
            let pulang = $("#jam_pulang_edit").val().trim();
            let total = $("#total_jam_edit").val().trim();
            let lintas = $("#lintas_hari_edit").val().trim();
            let isValid = true;

            if (nama === "") {
                showError($("#nama_jam_kerja_edit"), $("#group_nama_jam_kerja_edit"), $("#error_nama_jam_kerja_edit"), $("#icon_nama_jam_kerja_edit"), "Nama jam kerja wajib diisi!");
                $("#nama_jam_kerja_edit").focus();
                isValid = false;
            } else {
                clearError($("#nama_jam_kerja_edit"), $("#group_nama_jam_kerja_edit"), $("#error_nama_jam_kerja_edit"), $("#icon_nama_jam_kerja_edit"));
            }

            if (masuk === "") {
                showError($("#jam_masuk_edit"), $("#group_jam_masuk_edit"), $("#error_jam_masuk_edit"), $("#icon_jam_masuk_edit"), "Jam masuk wajib diisi!");
                if (isValid) $("#jam_masuk_edit").focus();
                isValid = false;
            } else {
                clearError($("#jam_masuk_edit"), $("#group_jam_masuk_edit"), $("#error_jam_masuk_edit"), $("#icon_jam_masuk_edit"));
            }

            if (pulang === "") {
                showError($("#jam_pulang_edit"), $("#group_jam_pulang_edit"), $("#error_jam_pulang_edit"), $("#icon_jam_pulang_edit"), "Jam pulang wajib diisi!");
                if (isValid) $("#jam_pulang_edit").focus();
                isValid = false;
            } else {
                clearError($("#jam_pulang_edit"), $("#group_jam_pulang_edit"), $("#error_jam_pulang_edit"), $("#icon_jam_pulang_edit"));
            }

            if (total === "") {
                showError($("#total_jam_edit"), $("#group_total_jam_edit"), $("#error_total_jam_edit"), $("#icon_total_jam_edit"), "Total jam kerja wajib diisi!");
                if (isValid) $("#total_jam_edit").focus();
                isValid = false;
            } else {
                clearError($("#total_jam_edit"), $("#group_total_jam_edit"), $("#error_total_jam_edit"), $("#icon_total_jam_edit"));
            }

            if (lintas === "") {
                showError($("#lintas_hari_edit"), $("#group_lintas_hari_edit"), $("#error_lintas_hari_edit"), null, "Pilih status lintas hari!");
                if (isValid) $("#lintas_hari_edit").focus();
                isValid = false;
            } else {
                clearError($("#lintas_hari_edit"), $("#group_lintas_hari_edit"), $("#error_lintas_hari_edit"), null);
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            $("#btnSubmitJamkerjaEdit").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitJamkerjaEdit").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Memperbarui...</span>
            `);
        });
    });
</script>
