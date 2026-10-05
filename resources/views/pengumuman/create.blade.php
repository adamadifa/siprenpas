<form action="{{ route('pengumuman.store') }}" method="POST" id="formPengumuman" novalidate class="space-y-4">
    @csrf

    <!-- Callout Info -->
    <div class="flex items-start gap-3 p-3.5 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-speakerphone"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-emerald-950">Informasi Pengumuman Baru</p>
            <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                Pengumuman yang disimpan akan langsung terkirim sebagai notifikasi aplikasi dan muncul pada dashboard santri/wali.
            </p>
        </div>
    </div>

    <!-- Judul Pengumuman -->
    <div class="space-y-1.5" id="group_judul">
        <label for="judul" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-file-description text-slate-400"></i>
            <span>Judul Pengumuman <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <i class="ti ti-heading text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_judul"></i>
            <input type="text" 
                   name="judul" 
                   id="judul" 
                   value="{{ old('judul') }}"
                   placeholder="Contoh: Edaran Libur Hari Raya Idul Fitri 1446 H" 
                   autocomplete="off"
                   class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
        </div>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_judul"></p>
    </div>

    <!-- Kategori -->
    <div class="space-y-1.5" id="group_kategori_id">
        <label for="kategori_id" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-category text-slate-400"></i>
            <span>Kategori Pengumuman <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <select name="kategori_id" 
                    id="kategori_id" 
                    class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $kat)
                    <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_kategori_id"></p>
    </div>

    <!-- Tanggal & Lokasi Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Tanggal -->
        <div class="space-y-1.5" id="group_tanggal">
            <label for="tanggal" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-calendar text-slate-400"></i>
                <span>Tanggal <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-calendar-event text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_tanggal"></i>
                <input type="date" 
                       name="tanggal" 
                       id="tanggal" 
                       value="{{ old('tanggal', date('Y-m-d')) }}" 
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_tanggal"></p>
        </div>

        <!-- Lokasi -->
        <div class="space-y-1.5" id="group_lokasi">
            <label for="lokasi" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-map-pin text-slate-400"></i>
                <span>Lokasi (Opsional)</span>
            </label>
            <div class="relative">
                <i class="ti ti-building-estate text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors"></i>
                <input type="text" 
                       name="lokasi" 
                       id="lokasi" 
                       value="{{ old('lokasi') }}" 
                       placeholder="Contoh: Masjid Jami' / Aula Utama" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
            </div>
        </div>
    </div>

    <!-- Isi Pengumuman -->
    <div class="space-y-1.5" id="group_isi">
        <label for="isi" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-notes text-slate-400"></i>
            <span>Isi Pengumuman <span class="text-rose-500">*</span></span>
        </label>
        <textarea name="isi" 
                  id="isi" 
                  rows="5" 
                  placeholder="Tuliskan isi pengumuman lengkap secara jelas..." 
                  class="w-full p-3.5 text-xs text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:text-slate-400 leading-relaxed">{{ old('isi') }}</textarea>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_isi"></p>
    </div>

    <!-- Modal Footer Actions -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
        <button type="button" 
                data-bs-dismiss="modal" 
                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
            Batal
        </button>
        <button type="submit" 
                id="btnSubmitPengumuman" 
                class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
            <i class="ti ti-send text-base"></i>
            <span>Simpan & Kirim Pengumuman</span>
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

        $("#judul").on("input", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#judul"), $("#group_judul"), $("#error_judul"), $("#icon_judul"));
            }
        });

        $("#kategori_id").on("change", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#kategori_id"), $("#group_kategori_id"), $("#error_kategori_id"), null);
            }
        });

        $("#tanggal").on("input change", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#tanggal"), $("#group_tanggal"), $("#error_tanggal"), $("#icon_tanggal"));
            }
        });

        $("#isi").on("input", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#isi"), $("#group_isi"), $("#error_isi"), null);
            }
        });

        $('#formPengumuman').on('submit', function(e) {
            let judul = $("#judul").val().trim();
            let kategori_id = $("#kategori_id").val().trim();
            let tanggal = $("#tanggal").val().trim();
            let isi = $("#isi").val().trim();
            let isValid = true;

            if (judul === "") {
                showError($("#judul"), $("#group_judul"), $("#error_judul"), $("#icon_judul"), "Judul pengumuman wajib diisi!");
                $("#judul").focus();
                isValid = false;
            } else {
                clearError($("#judul"), $("#group_judul"), $("#error_judul"), $("#icon_judul"));
            }

            if (kategori_id === "") {
                showError($("#kategori_id"), $("#group_kategori_id"), $("#error_kategori_id"), null, "Pilih kategori pengumuman!");
                if (isValid) $("#kategori_id").focus();
                isValid = false;
            } else {
                clearError($("#kategori_id"), $("#group_kategori_id"), $("#error_kategori_id"), null);
            }

            if (tanggal === "") {
                showError($("#tanggal"), $("#group_tanggal"), $("#error_tanggal"), $("#icon_tanggal"), "Tanggal pengumuman wajib diisi!");
                if (isValid) $("#tanggal").focus();
                isValid = false;
            } else {
                clearError($("#tanggal"), $("#group_tanggal"), $("#error_tanggal"), $("#icon_tanggal"));
            }

            if (isi === "") {
                showError($("#isi"), $("#group_isi"), $("#error_isi"), null, "Isi pengumuman wajib diisi!");
                if (isValid) $("#isi").focus();
                isValid = false;
            } else {
                clearError($("#isi"), $("#group_isi"), $("#error_isi"), null);
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            $("#btnSubmitPengumuman").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitPengumuman").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>
