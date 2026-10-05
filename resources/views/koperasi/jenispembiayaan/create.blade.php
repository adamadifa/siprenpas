<form action="{{ route('jenispembiayaan.store') }}" id="formcreatePembiayaan" method="POST" class="space-y-4" novalidate>
    @csrf

    <!-- Kode Pembiayaan -->
    <div class="space-y-1.5">
        <label for="kode_pembiayaan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-barcode text-sm text-slate-400"></i>
            <span>Kode Pembiayaan (3 Karakter) <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-barcode text-base"></i>
            </div>
            <input type="text" 
                   id="kode_pembiayaan" 
                   name="kode_pembiayaan" 
                   maxlength="3"
                   placeholder="Contoh: P01" 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-black uppercase font-mono tracking-wider text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Format kode harus tepat 3 karakter (contoh: P01, P02, PMB).</p>
    </div>

    <!-- Nama Jenis Pembiayaan -->
    <div class="space-y-1.5">
        <label for="jenis_pembiayaan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-cash text-sm text-slate-400"></i>
            <span>Nama Jenis Pembiayaan <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-cash text-base"></i>
            </div>
            <input type="text" 
                   id="jenis_pembiayaan" 
                   name="jenis_pembiayaan" 
                   placeholder="Contoh: Pembiayaan Murabahah / Pembiayaan Mudharabah..." 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
    </div>

    <!-- Persentase Margin / Jasa -->
    <div class="space-y-1.5">
        <label for="persentase" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-percentage text-sm text-slate-400"></i>
            <span>Persentase Margin / Jasa (%) <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-percentage text-base"></i>
            </div>
            <input type="number" 
                   step="0.01"
                   min="0"
                   id="persentase" 
                   name="persentase" 
                   placeholder="Contoh: 10 atau 12.5" 
                   class="w-full pl-9 pr-8 py-2.5 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 font-bold text-xs">
                %
            </div>
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Besaran margin bagi hasil / jasa pembiayaan dalam persen.</p>
    </div>

    <!-- Actions Footer -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSubmitPembiayaan" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Jenis Pembiayaan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formcreatePembiayaan");

        // Force uppercase on kode_pembiayaan
        form.find('#kode_pembiayaan').on('input', function() {
            $(this).val($(this).val().toUpperCase());
        });

        // Validation Rules Map
        const validationRules = {
            'kode_pembiayaan': { 
                required: true, 
                message: 'Kode Pembiayaan wajib diisi', 
                minLength: 3, 
                maxLength: 3, 
                lengthMessage: 'Kode Pembiayaan harus tepat 3 karakter (contoh: P01)' 
            },
            'jenis_pembiayaan': { 
                required: true, 
                message: 'Nama Jenis Pembiayaan wajib diisi' 
            },
            'persentase': { 
                required: true, 
                message: 'Persentase Margin / Jasa wajib diisi',
                custom: function(val) {
                    if (isNaN(val) || parseFloat(val) < 0) {
                        return 'Persentase harus berupa angka valid >= 0';
                    }
                    return true;
                }
            }
        };

        function showError(element, message) {
            const $el = $(element);
            const $container = $el.closest('.space-y-1\\.5').length ? $el.closest('.space-y-1\\.5') : ($el.closest('.space-y-1').length ? $el.closest('.space-y-1') : $el.parent());
            
            $el.addClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20')
               .removeClass('border-slate-300 focus:ring-emerald-500/20 focus:border-emerald-600');
            
            // Left icon highlight
            $el.siblings('.pointer-events-none').find('i').addClass('text-rose-500').removeClass('text-slate-400');
            
            // Remove existing error msg
            $container.find('.error-msg').remove();
            
            // Append error message
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

            if (rule.minLength && val.length < rule.minLength) {
                showError($el, rule.lengthMessage || `Minimal ${rule.minLength} karakter`);
                return false;
            }

            if (rule.maxLength && val.length > rule.maxLength) {
                showError($el, rule.lengthMessage || `Maksimal ${rule.maxLength} karakter`);
                return false;
            }

            if (rule.custom) {
                const customResult = rule.custom(val);
                if (customResult !== true) {
                    showError($el, customResult);
                    return false;
                }
            }

            clearError($el);
            return true;
        }

        // Realtime validation trigger
        form.on('input change blur', 'input', function(e) {
            const $this = $(this);
            const hasError = $this.hasClass('border-rose-500');
            const val = ($this.val() || '').toString().trim();
            
            if (e.type === 'blur' || val !== '' || hasError) {
                validateSingleField(this);
            }
        });

        // Form Submit Validation
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
                    firstInvalidEl.focus();
                }
                return false;
            }

            // Disable button & show spinner
            const submitBtn = form.find('#btnSubmitPembiayaan');
            submitBtn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');
            setTimeout(function() {
                submitBtn.prop('disabled', true);
            }, 50);
        });
    });
</script>
