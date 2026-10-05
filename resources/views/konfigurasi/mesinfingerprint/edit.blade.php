<form action="{{ route('mesinfingerprint.update', Crypt::encrypt($mesin->id)) }}" id="formeditMesinFP" method="POST" novalidate class="space-y-4">
    @csrf
    @method('PUT')

    <!-- Callout Info -->
    <div class="flex items-start gap-3 p-3.5 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-pencil"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-emerald-950">Ubah Konfigurasi Mesin</p>
            <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                Perubahan data perangkat akan langsung memengaruhi sinkronisasi log presensi real-time.
            </p>
        </div>
    </div>

    <!-- Nama Mesin -->
    <div class="space-y-1.5" id="group_edit_nama_mesin">
        <label for="edit_nama_mesin" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-device-desktop text-slate-400"></i>
            <span>Nama Mesin <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <i class="ti ti-typography text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_edit_nama_mesin"></i>
            <input type="text" 
                   name="nama_mesin" 
                   id="edit_nama_mesin" 
                   value="{{ $mesin->nama_mesin }}"
                   placeholder="Contoh: Mesin Gedung A (Putra)" 
                   autocomplete="off"
                   class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
        </div>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_edit_nama_mesin"></p>
    </div>

    <!-- Serial Number (SN) -->
    <div class="space-y-1.5" id="group_edit_sn">
        <label for="edit_sn" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-barcode text-slate-400"></i>
            <span>Serial Number (SN) <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <i class="ti ti-tag text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base transition-colors" id="icon_edit_sn"></i>
            <input type="text" 
                   name="sn" 
                   id="edit_sn" 
                   value="{{ $mesin->sn }}"
                   placeholder="Contoh: C2630900115" 
                   autocomplete="off"
                   class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal uppercase">
        </div>
        <p class="text-[11px] font-semibold text-rose-500 hidden mt-1 flex items-center gap-1" id="error_edit_sn"></p>
    </div>

    <!-- Grid: Titik Koordinat & Status -->
    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3.5">
        <!-- Titik Koordinat -->
        <div class="sm:col-span-7 space-y-1.5" id="group_edit_titik_koordinat">
            <label for="edit_titik_koordinat" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-map-pin text-slate-400"></i>
                <span>Titik Koordinat (Opsional)</span>
            </label>
            <div class="relative">
                <i class="ti ti-location text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base"></i>
                <input type="text" 
                       name="titik_koordinat" 
                       id="edit_titik_koordinat" 
                       value="{{ $mesin->titik_koordinat }}"
                       placeholder="-6.914744, 107.609810" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
            </div>
            <p class="text-[11px] text-slate-400">Format: Latitude, Longitude</p>
        </div>

        <!-- Status -->
        <div class="sm:col-span-5 space-y-1.5" id="group_edit_status">
            <label for="edit_status" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-toggle-right text-slate-400"></i>
                <span>Status Mesin <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <select name="status" 
                        id="edit_status" 
                        class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                    <option value="Aktif" {{ $mesin->status == 'Aktif' ? 'selected' : '' }}>Aktif (Terhubung)</option>
                    <option value="Nonaktif" {{ $mesin->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
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
                id="btnSubmitEditMesinFP" 
                class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Perubahan</span>
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

        $("#edit_nama_mesin").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#error_edit_nama_mesin"), $("#icon_edit_nama_mesin"));
        });
        $("#edit_sn").on("input", function() {
            if ($(this).val().trim() !== "") clearError($(this), $("#error_edit_sn"), $("#icon_edit_sn"));
        });

        $("#formeditMesinFP").on('submit', function(e) {
            e.preventDefault();
            
            let nama = $("#edit_nama_mesin").val().trim();
            let sn = $("#edit_sn").val().trim();
            let isValid = true;

            if (nama === "") {
                showError($("#edit_nama_mesin"), $("#error_edit_nama_mesin"), $("#icon_edit_nama_mesin"), "Nama mesin wajib diisi!");
                $("#edit_nama_mesin").focus();
                isValid = false;
            } else {
                clearError($("#edit_nama_mesin"), $("#error_edit_nama_mesin"), $("#icon_edit_nama_mesin"));
            }

            if (sn === "") {
                showError($("#edit_sn"), $("#error_edit_sn"), $("#icon_edit_sn"), "Serial Number (SN) wajib diisi!");
                if (isValid) $("#edit_sn").focus();
                isValid = false;
            } else {
                clearError($("#edit_sn"), $("#error_edit_sn"), $("#icon_edit_sn"));
            }

            if (!isValid) return false;

            const $btn = $("#btnSubmitEditMesinFP");
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
                        text: 'Data mesin fingerprint berhasil diperbarui.',
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
                        <span>Simpan Perubahan</span>
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
                            text: 'Terjadi kesalahan sistem saat memperbarui data.',
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

