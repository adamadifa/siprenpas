<form action="{{ route('mesinfingerprint.store') }}" id="formcreateMesinFP" method="POST" novalidate class="space-y-4">
    @csrf

    <!-- Callout Info -->
    <div class="flex items-start gap-3 p-3.5 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-fingerprint"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-emerald-950">Informasi Perangkat Biometrik</p>
            <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                Pastikan Serial Number (SN) perangkat sesuai dengan yang tertera pada unit mesin agar proses koneksi dan penarikan log absensi berjalan lancar.
            </p>
        </div>
    </div>

    <!-- Nama Mesin -->
    <div class="space-y-1.5" id="group_nama_mesin">
        <label for="nama_mesin" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-device-desktop text-slate-400"></i>
            <span>Nama Mesin <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <i class="ti ti-typography text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_nama_mesin"></i>
            <input type="text" 
                   name="nama_mesin" 
                   id="nama_mesin" 
                   placeholder="Contoh: Mesin Gedung A (Putra), Mesin Asrama Putri" 
                   autocomplete="off"
                   class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
        </div>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_nama_mesin"></p>
    </div>

    <!-- Serial Number (SN) -->
    <div class="space-y-1.5" id="group_sn">
        <label for="sn" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-barcode text-slate-400"></i>
            <span>Serial Number (SN) <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <i class="ti ti-tag text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_sn"></i>
            <input type="text" 
                   name="sn" 
                   id="sn" 
                   placeholder="Contoh: C2630900115" 
                   autocomplete="off"
                   class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal uppercase">
        </div>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_sn"></p>
    </div>

    <!-- Grid: Titik Koordinat & Status -->
    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3.5">
        <!-- Titik Koordinat -->
        <div class="sm:col-span-7 space-y-1.5" id="group_titik_koordinat">
            <label for="titik_koordinat" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-map-pin text-slate-400"></i>
                <span>Titik Koordinat (Opsional)</span>
            </label>
            <div class="relative">
                <i class="ti ti-location text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base"></i>
                <input type="text" 
                       name="titik_koordinat" 
                       id="titik_koordinat" 
                       placeholder="-6.914744, 107.609810" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
            </div>
            <p class="text-[11px] text-slate-400">Format: Latitude, Longitude</p>
        </div>

        <!-- Status -->
        <div class="sm:col-span-5 space-y-1.5" id="group_status">
            <label for="status" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-toggle-right text-slate-400"></i>
                <span>Status Mesin <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <select name="status" 
                        id="status" 
                        class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                    <option value="Aktif" selected>Aktif (Terhubung)</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>
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
                id="btnSubmitMesinFP" 
                class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Mesin</span>
        </button>
    </div>
</form>

<script>
    $(function() {
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

        $("#nama_mesin").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#error_nama_mesin"), $("#icon_nama_mesin"));
        });
        $("#sn").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#error_sn"), $("#icon_sn"));
        });

        $("#formcreateMesinFP").on('submit', function(e) {
            e.preventDefault();
            
            let nama = $("#nama_mesin").val().trim();
            let sn = $("#sn").val().trim();
            let isValid = true;

            if (nama === "") {
                showError($("#nama_mesin"), $("#error_nama_mesin"), $("#icon_nama_mesin"), "Nama mesin wajib diisi!");
                $("#nama_mesin").focus();
                isValid = false;
            } else {
                clearError($("#nama_mesin"), $("#error_nama_mesin"), $("#icon_nama_mesin"));
            }

            if (sn === "") {
                showError($("#sn"), $("#error_sn"), $("#icon_sn"), "Serial Number (SN) wajib diisi!");
                if (isValid) $("#sn").focus();
                isValid = false;
            } else {
                clearError($("#sn"), $("#error_sn"), $("#icon_sn"));
            }

            if (!isValid) return false;

            const $btn = $("#btnSubmitMesinFP");
            $btn.prop("disabled", true).addClass("opacity-75 cursor-not-allowed");
            $btn.html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan...</span>
            `);

            var form = $(this);
            var actionUrl = form.attr('action');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data mesin fingerprint berhasil disimpan.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#059669',
                        customClass: {
                            popup: 'rounded-2xl shadow-xl border border-slate-100',
                            confirmButton: 'px-5 py-2 font-bold rounded-xl text-xs'
                        }
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    $btn.prop("disabled", false).removeClass("opacity-75 cursor-not-allowed");
                    $btn.html(`
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Mesin</span>
                    `);

                    var errors = xhr.responseJSON;
                    if (errors && errors.errors) {
                        var errorMessages = Object.values(errors.errors).flat().join('<br>');
                        Swal.fire({
                            title: 'Validasi Gagal!',
                            html: errorMessages,
                            icon: 'error',
                            confirmButtonText: 'Tutup',
                            confirmButtonColor: '#e11d48',
                            customClass: {
                                popup: 'rounded-2xl shadow-xl border border-slate-100',
                                confirmButton: 'px-5 py-2 font-bold rounded-xl text-xs'
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan sistem saat menyimpan data.',
                            icon: 'error',
                            confirmButtonText: 'Tutup',
                            confirmButtonColor: '#e11d48',
                            customClass: {
                                popup: 'rounded-2xl shadow-xl border border-slate-100',
                                confirmButton: 'px-5 py-2 font-bold rounded-xl text-xs'
                            }
                        });
                    }
                }
            });
        });
    });
</script>

