<form action="{{ route('kategori.store') }}" method="POST" id="formKategori" novalidate class="space-y-4">
    @csrf

    <!-- Callout Info -->
    <div class="flex items-start gap-3 p-3.5 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-info-circle"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-emerald-950">Informasi Kategori</p>
            <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                Kategori digunakan untuk mengelompokkan artikel atau warta berita di portal publik website Al-Amin.
            </p>
        </div>
    </div>

    <!-- Input Nama Kategori -->
    <div class="space-y-1.5" id="group_kategori">
        <label for="kategori" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-tag text-slate-400"></i>
            <span>Nama Kategori <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <i class="ti ti-folder text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_kategori"></i>
            <input type="text" 
                   name="kategori" 
                   id="kategori" 
                   placeholder="Contoh: Warta Santri, Pengumuman, Opini" 
                   autocomplete="off"
                   class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
        </div>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_kategori"></p>
    </div>

    <!-- Slug Preview (Auto Generated) -->
    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between gap-2">
        <span class="text-xs text-slate-500 font-medium flex items-center gap-1.5">
            <i class="ti ti-link text-slate-400"></i>
            <span>Preview Slug:</span>
        </span>
        <span class="text-xs font-mono font-bold text-emerald-700 bg-white px-2.5 py-1 rounded-lg border border-slate-200" id="slug_preview">
            -
        </span>
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
        function generateSlug(text) {
            return text.toString().toLowerCase().trim()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-');        // Replace multiple - with single -
        }

        $("#kategori").on("input", function() {
            let val = $(this).val();
            let slug = generateSlug(val);
            $("#slug_preview").text(slug.length > 0 ? slug : '-');
            
            if (val.trim() !== "") {
                clearError($("#kategori"), $("#group_kategori"), $("#error_kategori"), $("#icon_kategori"));
            }
        });

        function showError($input, $group, $errorMsg, $icon, message) {
            $input.removeClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20")
                  .addClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20");
            $icon.removeClass("text-slate-400").addClass("text-rose-500");
            $errorMsg.html(`<i class="ti ti-alert-circle text-xs"></i> ${message}`).removeClass("hidden");
        }

        function clearError($input, $group, $errorMsg, $icon) {
            $input.removeClass("border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/20")
                  .addClass("border-slate-300 focus:border-emerald-600 focus:ring-emerald-500/20");
            $icon.removeClass("text-rose-500").addClass("text-slate-400");
            $errorMsg.addClass("hidden").html("");
        }

        $('#formKategori').on('submit', function(e) {
            let kategoriVal = $("#kategori").val().trim();
            let isValid = true;

            if (kategoriVal === "") {
                showError($("#kategori"), $("#group_kategori"), $("#error_kategori"), $("#icon_kategori"), "Nama kategori wajib diisi!");
                $("#kategori").focus();
                isValid = false;
            } else if (kategoriVal.length < 2) {
                showError($("#kategori"), $("#group_kategori"), $("#error_kategori"), $("#icon_kategori"), "Nama kategori minimal 2 karakter!");
                $("#kategori").focus();
                isValid = false;
            } else {
                clearError($("#kategori"), $("#group_kategori"), $("#error_kategori"), $("#icon_kategori"));
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
