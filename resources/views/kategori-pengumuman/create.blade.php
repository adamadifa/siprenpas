<form action="{{ route('kategori-pengumuman.store') }}" method="POST" id="formKategoriPengumuman" novalidate class="space-y-4">
    @csrf

    <!-- Callout Info -->
    <div class="flex items-start gap-3 p-3.5 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-tag"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-emerald-950">Informasi Kategori Pengumuman</p>
            <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                Kategori digunakan untuk mengelompokkan jenis pengumuman (contoh: *Kedinasan, Libur & Hari Besar, Keuangan, Kepesantrenan*).
            </p>
        </div>
    </div>

    <!-- Nama Kategori -->
    <div class="space-y-1.5" id="group_nama_kategori">
        <label for="nama_kategori" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-tag text-slate-400"></i>
            <span>Nama Kategori Pengumuman <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <i class="ti ti-folder text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_nama_kategori"></i>
            <input type="text" 
                   name="nama_kategori" 
                   id="nama_kategori" 
                   value="{{ old('nama_kategori') }}"
                   placeholder="Contoh: Edaran Kepesantrenan, Agenda Santri" 
                   autocomplete="off"
                   class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
        </div>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_nama_kategori"></p>
    </div>

    <!-- Modal Footer Actions -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
        <button type="button" 
                data-bs-dismiss="modal" 
                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
            Batal
        </button>
        <button type="submit" 
                id="btnSubmitKategori" 
                class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Kategori</span>
        </button>
    </div>
</form>

<script>
    $(function() {
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

        $("#nama_kategori").on("input", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#nama_kategori"), $("#group_nama_kategori"), $("#error_nama_kategori"), $("#icon_nama_kategori"));
            }
        });

        $('#formKategoriPengumuman').on('submit', function(e) {
            let val = $("#nama_kategori").val().trim();
            let isValid = true;

            if (val === "") {
                showError($("#nama_kategori"), $("#group_nama_kategori"), $("#error_nama_kategori"), $("#icon_nama_kategori"), "Nama kategori pengumuman wajib diisi!");
                $("#nama_kategori").focus();
                isValid = false;
            } else if (val.length < 2) {
                showError($("#nama_kategori"), $("#group_nama_kategori"), $("#error_nama_kategori"), $("#icon_nama_kategori"), "Nama kategori minimal 2 karakter!");
                $("#nama_kategori").focus();
                isValid = false;
            } else {
                clearError($("#nama_kategori"), $("#group_nama_kategori"), $("#error_nama_kategori"), $("#icon_nama_kategori"));
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            $("#btnSubmitKategori").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitKategori").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>
