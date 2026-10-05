<form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST" id="formPengumumanEdit" novalidate class="space-y-4">
    @csrf
    @method('PUT')

    <!-- Callout Info -->
    <div class="flex items-start gap-3 p-3.5 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-edit"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-emerald-950">Perbarui Data Pengumuman</p>
            <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                Pembaruan pengumuman akan otomatis terupdate pada portal dan aplikasi wali santri.
            </p>
        </div>
    </div>

    <!-- Judul Pengumuman -->
    <div class="space-y-1.5" id="group_judul_edit">
        <label for="judul_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-file-description text-slate-400"></i>
            <span>Judul Pengumuman <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <i class="ti ti-heading text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_judul_edit"></i>
            <input type="text" 
                   name="judul" 
                   id="judul_edit" 
                   value="{{ old('judul', $pengumuman->judul) }}"
                   placeholder="Contoh: Edaran Libur Hari Raya Idul Fitri 1446 H" 
                   autocomplete="off"
                   class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
        </div>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_judul_edit"></p>
    </div>

    <!-- Kategori -->
    <div class="space-y-1.5" id="group_kategori_id_edit">
        <label for="kategori_id_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-category text-slate-400"></i>
            <span>Kategori Pengumuman <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <select name="kategori_id" 
                    id="kategori_id_edit" 
                    class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $kat)
                    <option value="{{ $kat->id }}" {{ old('kategori_id', $pengumuman->kategori_id) == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_kategori_id_edit"></p>
    </div>

    <!-- Tanggal & Lokasi Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Tanggal -->
        <div class="space-y-1.5" id="group_tanggal_edit">
            <label for="tanggal_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-calendar text-slate-400"></i>
                <span>Tanggal <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-calendar-event text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_tanggal_edit"></i>
                <input type="date" 
                       name="tanggal" 
                       id="tanggal_edit" 
                       value="{{ old('tanggal', \Carbon\Carbon::parse($pengumuman->tanggal)->format('Y-m-d')) }}" 
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
            </div>
            <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_tanggal_edit"></p>
        </div>

        <!-- Lokasi -->
        <div class="space-y-1.5" id="group_lokasi_edit">
            <label for="lokasi_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-map-pin text-slate-400"></i>
                <span>Lokasi (Opsional)</span>
            </label>
            <div class="relative">
                <i class="ti ti-building-estate text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors"></i>
                <input type="text" 
                       name="lokasi" 
                       id="lokasi_edit" 
                       value="{{ old('lokasi', $pengumuman->lokasi) }}" 
                       placeholder="Contoh: Masjid Jami' / Aula Utama" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
            </div>
        </div>
    </div>

    <!-- Isi Pengumuman -->
    <div class="space-y-1.5" id="group_isi_edit">
        <label for="isi_edit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-notes text-slate-400"></i>
            <span>Isi Pengumuman <span class="text-rose-500">*</span></span>
        </label>
        <textarea name="isi" 
                  id="isi_edit" 
                  rows="5" 
                  placeholder="Tuliskan isi pengumuman lengkap secara jelas..." 
                  class="w-full p-3.5 text-xs text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:text-slate-400 leading-relaxed">{{ old('isi', $pengumuman->isi) }}</textarea>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_isi_edit"></p>
    </div>

    <!-- Modal Footer Actions -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
        <button type="button" 
                data-bs-dismiss="modal" 
                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
            Batal
        </button>
        <button type="submit" 
                id="btnSubmitPengumumanEdit" 
                class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Perbarui Pengumuman</span>
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

        $("#judul_edit").on("input", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#judul_edit"), $("#group_judul_edit"), $("#error_judul_edit"), $("#icon_judul_edit"));
            }
        });

        $("#kategori_id_edit").on("change", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#kategori_id_edit"), $("#group_kategori_id_edit"), $("#error_kategori_id_edit"), null);
            }
        });

        $("#tanggal_edit").on("input change", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#tanggal_edit"), $("#group_tanggal_edit"), $("#error_tanggal_edit"), $("#icon_tanggal_edit"));
            }
        });

        $("#isi_edit").on("input", function() {
            if ($(this).val().trim() !== "") {
                clearError($("#isi_edit"), $("#group_isi_edit"), $("#error_isi_edit"), null);
            }
        });

        $('#formPengumumanEdit').on('submit', function(e) {
            let judul = $("#judul_edit").val().trim();
            let kategori_id = $("#kategori_id_edit").val().trim();
            let tanggal = $("#tanggal_edit").val().trim();
            let isi = $("#isi_edit").val().trim();
            let isValid = true;

            if (judul === "") {
                showError($("#judul_edit"), $("#group_judul_edit"), $("#error_judul_edit"), $("#icon_judul_edit"), "Judul pengumuman wajib diisi!");
                $("#judul_edit").focus();
                isValid = false;
            } else {
                clearError($("#judul_edit"), $("#group_judul_edit"), $("#error_judul_edit"), $("#icon_judul_edit"));
            }

            if (kategori_id === "") {
                showError($("#kategori_id_edit"), $("#group_kategori_id_edit"), $("#error_kategori_id_edit"), null, "Pilih kategori pengumuman!");
                if (isValid) $("#kategori_id_edit").focus();
                isValid = false;
            } else {
                clearError($("#kategori_id_edit"), $("#group_kategori_id_edit"), $("#error_kategori_id_edit"), null);
            }

            if (tanggal === "") {
                showError($("#tanggal_edit"), $("#group_tanggal_edit"), $("#error_tanggal_edit"), $("#icon_tanggal_edit"), "Tanggal pengumuman wajib diisi!");
                if (isValid) $("#tanggal_edit").focus();
                isValid = false;
            } else {
                clearError($("#tanggal_edit"), $("#group_tanggal_edit"), $("#error_tanggal_edit"), $("#icon_tanggal_edit"));
            }

            if (isi === "") {
                showError($("#isi_edit"), $("#group_isi_edit"), $("#error_isi_edit"), null, "Isi pengumuman wajib diisi!");
                if (isValid) $("#isi_edit").focus();
                isValid = false;
            } else {
                clearError($("#isi_edit"), $("#group_isi_edit"), $("#error_isi_edit"), null);
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            $("#btnSubmitPengumumanEdit").prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $("#btnSubmitPengumumanEdit").html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Memperbarui...</span>
            `);
        });
    });
</script>
