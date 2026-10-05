<form action="{{ route('tabungan.storerekening') }}" 
      id="formTabungan" 
      method="POST" 
      class="space-y-4 sm:space-y-5" 
      novalidate>
    @csrf

    <!-- Header Banner Notice -->
    <div class="p-3.5 sm:p-4 bg-emerald-50/90 border border-emerald-200 text-emerald-900 rounded-xl flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-base font-bold shadow-2xs shrink-0">
                <i class="ti ti-wallet"></i>
            </div>
            <div>
                <div class="text-xs sm:text-sm font-bold">Pembukaan Rekening Baru</div>
                <div class="text-[11px] text-emerald-700/80 font-medium">Pilih anggota dan jenis tabungan yang akan dibuka</div>
            </div>
        </div>
        <span class="px-2.5 py-1 rounded-lg text-[11px] font-black uppercase tracking-wider bg-emerald-600 text-white shadow-2xs">
            Auto No. Rek
        </span>
    </div>

    <!-- Form Section -->
    <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-4">
        
        <!-- Cari Anggota Field -->
        <div class="space-y-1.5">
            <label for="no_anggota" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-user text-sm text-slate-400"></i>
                <span>Anggota Koperasi <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="flex items-center gap-2">
                <div class="relative flex-1">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <i class="ti ti-id text-base"></i>
                    </div>
                    <input type="text" 
                           id="no_anggota" 
                           name="no_anggota" 
                           readonly 
                           class="w-full pl-10 pr-3.5 py-2.5 text-xs sm:text-sm font-mono font-bold text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer" 
                           placeholder="Pilih Anggota..." 
                           required>
                </div>
                <button type="button" 
                        id="no_anggota_search" 
                        class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-xs transition flex items-center justify-center gap-1.5 shrink-0 cursor-pointer active:scale-95">
                    <i class="ti ti-search text-sm"></i>
                    <span>Cari Anggota</span>
                </button>
            </div>
            
            <!-- Member preview card (shown when member selected) -->
            <div id="memberPreviewCard" class="hidden mt-2 p-3 bg-white border border-slate-200 rounded-lg shadow-2xs flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0">
                        <i class="ti ti-user-check"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-slate-900 truncate" id="nama_lengkap_text">-</div>
                        <div class="text-[11px] text-slate-500 flex items-center gap-2 font-mono">
                            <span>No: <strong id="no_anggota_text" class="text-slate-700">-</strong></span>
                        </div>
                    </div>
                </div>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">
                    Terpilih
                </span>
            </div>
        </div>

        <!-- Jenis Tabungan Select -->
        <div class="space-y-1.5">
            <label for="kode_tabungan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-building-bank text-sm text-slate-400"></i>
                <span>Jenis Tabungan <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 z-10">
                    <i class="ti ti-wallet text-base"></i>
                </div>
                <select name="kode_tabungan" 
                        id="kode_tabungan" 
                        class="select2Kodetabungan w-full pl-10 pr-3.5 py-2.5 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                        required>
                    <option value="">-- Pilih Jenis Tabungan --</option>
                    @foreach ($jenis_tabungan as $d)
                        <option value="{{ $d->kode_tabungan }}">{{ $d->kode_tabungan }} - {{ textUpperCase($d->jenis_tabungan) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- RFID Input (Opsional) -->
        <div class="space-y-1.5">
            <label for="rfid" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-nfc text-sm text-slate-400"></i>
                <span>Kode RFID / Smart Card <span class="text-slate-400 font-normal">(Opsional)</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <i class="ti ti-credit-card text-base"></i>
                </div>
                <input type="text" 
                       name="rfid" 
                       id="rfid" 
                       maxlength="20"
                       class="w-full pl-10 pr-3.5 py-2.5 text-xs sm:text-sm font-mono font-bold text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition uppercase" 
                       placeholder="Scan kartu RFID atau ketik kode...">
            </div>
            <p class="text-[11px] text-slate-400 font-medium">
                Maksimal 20 karakter. Kosongkan jika rekening tidak menggunakan kartu pintar.
            </p>
        </div>

    </div>

    <!-- Actions Footer -->
    <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" 
                class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-lg transition cursor-pointer active:scale-95" 
                data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" 
                id="btnSimpanRekening" 
                class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Buka Rekening</span>
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        const form = $('#formTabungan');
        const select2Kodetabungan = $('.select2Kodetabungan');
        
        if (select2Kodetabungan.length) {
            select2Kodetabungan.each(function() {
                var $this = $(this);
                $this.select2({
                    placeholder: '-- Pilih Jenis Tabungan --',
                    dropdownParent: $this.closest('.modal').length ? $this.closest('.modal') : $(document.body),
                    allowClear: true,
                    width: '100%'
                });
            });
        }

        // Validation Rules Map
        const validationRules = {
            'no_anggota': {
                required: true,
                message: 'Silakan pilih anggota koperasi terlebih dahulu'
            },
            'kode_tabungan': {
                required: true,
                message: 'Jenis tabungan wajib dipilih'
            },
            'rfid': {
                required: false,
                maxLength: 20,
                message: 'Kode RFID maksimal 20 karakter'
            }
        };

        function showError(element, message) {
            const $el = $(element);
            const $container = $el.closest('.space-y-1\\.5').length ? $el.closest('.space-y-1\\.5') : ($el.closest('.space-y-1').length ? $el.closest('.space-y-1') : $el.parent());
            
            $el.addClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20')
               .removeClass('border-slate-300 focus:ring-emerald-500/20 focus:border-emerald-600');
            
            $el.siblings('.pointer-events-none').find('i').addClass('text-rose-500').removeClass('text-slate-400');
            
            $container.find('.error-msg').remove();
            
            $container.append(`
                <p class="error-msg text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1 animate-in fade-in duration-200">
                    <i class="ti ti-alert-circle text-xs shrink-0"></i>
                    <span>${message}</span>
                </p>
            `);
        }

        function clearError(element) {
            const $el = $(element);
            const $container = $el.closest('.space-y-1\\.5').length ? $el.closest('.space-y-1\\.5') : ($el.closest('.space-y-1').length ? $el.closest('.space-y-1') : $el.parent());
            
            $el.removeClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20')
               .addClass('border-slate-300 focus:ring-emerald-500/20 focus:border-emerald-600');
            
            $el.siblings('.pointer-events-none').find('i').removeClass('text-rose-500').addClass('text-slate-400');
            
            $container.find('.error-msg').remove();
        }

        function validateSingleField(el) {
            const $el = $(el);
            const name = $el.attr('name') || $el.attr('id');
            const val = ($el.val() || '').toString().trim();

            const rule = validationRules[name];
            if (!rule) {
                clearError($el);
                return true;
            }

            if (rule.required && !val) {
                showError($el, rule.message);
                return false;
            }

            if (rule.maxLength && val.length > rule.maxLength) {
                showError($el, rule.message);
                return false;
            }

            clearError($el);
            return true;
        }

        // Realtime validation triggers
        form.on('input change blur', 'input, select', function(e) {
            const $this = $(this);
            const hasError = $this.hasClass('border-rose-500');
            const val = ($this.val() || '').toString().trim();
            
            if (e.type === 'blur' || e.type === 'change' || val !== '' || hasError) {
                validateSingleField(this);
            }
        });

        // Auto-format RFID input (uppercase)
        $('#rfid').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Click no_anggota input triggers modal search
        $('#no_anggota').on('click', function() {
            $('#no_anggota_search').trigger('click');
        });

        // Form Submit
        form.on('submit', function(e) {
            let isValid = true;
            let firstInvalidEl = null;

            Object.keys(validationRules).forEach(function(fieldName) {
                const $el = form.find(`[name="${fieldName}"]`);
                if ($el.length > 0 && $el.is(':visible')) {
                    const valid = validateSingleField($el);
                    if (!valid) {
                        isValid = false;
                        if (!firstInvalidEl) {
                            firstInvalidEl = $el;
                        }
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
                if (firstInvalidEl) {
                    if (firstInvalidEl.attr('name') === 'no_anggota') {
                        $('#no_anggota_search').trigger('click');
                    } else {
                        firstInvalidEl.focus();
                    }
                }
                return false;
            }

            const submitBtn = form.find('#btnSimpanRekening');
            submitBtn.prop("disabled", true).html(`
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>
