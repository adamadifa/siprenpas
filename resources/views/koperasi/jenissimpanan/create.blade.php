<form action="{{ route('jenissimpanan.store') }}" id="formcreateSimpanan" method="POST" class="space-y-4" novalidate>
    @csrf

    <!-- Kode Simpanan -->
    <div class="space-y-1.5">
        <label for="kode_simpanan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-barcode text-sm text-slate-400"></i>
            <span>Kode Simpanan (3 Karakter) <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-barcode text-base"></i>
            </div>
            <input type="text" 
                   id="kode_simpanan" 
                   name="kode_simpanan" 
                   maxlength="3"
                   placeholder="Contoh: S01" 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-black uppercase font-mono tracking-wider text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Format kode harus tepat 3 karakter (contoh: S01, S02, SPK).</p>
    </div>

    <!-- Nama Jenis Simpanan -->
    <div class="space-y-1.5">
        <label for="jenis_simpanan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-vault text-sm text-slate-400"></i>
            <span>Nama Jenis Simpanan <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-vault text-base"></i>
            </div>
            <input type="text" 
                   id="jenis_simpanan" 
                   name="jenis_simpanan" 
                   placeholder="Contoh: Simpanan Pokok / Simpanan Wajib / Simpanan Sukarela..." 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
    </div>

    <!-- Actions Footer -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSubmitSimpanan" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Jenis Simpanan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formcreateSimpanan");

        // Force uppercase on kode_simpanan
        form.find('#kode_simpanan').on('input', function() {
            $(this).val($(this).val().toUpperCase());
        });

        // Validation Rules Map
        const validationRules = {
            'kode_simpanan': { 
                required: true, 
                message: 'Kode Simpanan wajib diisi', 
                minLength: 3, 
                maxLength: 3, 
                lengthMessage: 'Kode Simpanan harus tepat 3 karakter (contoh: S01)' 
            },
            'jenis_simpanan': { 
                required: true, 
                message: 'Nama Jenis Simpanan wajib diisi' 
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
            const submitBtn = form.find('#btnSubmitSimpanan');
            submitBtn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');
            setTimeout(function() {
                submitBtn.prop('disabled', true);
            }, 50);
        });
    });
</script>
