<form action="{{ route('departemen.store') }}" id="formcreateDepartemen" method="POST" class="space-y-4" novalidate>
    @csrf

    <!-- Kode Departemen -->
    <div class="space-y-1.5">
        <label for="kode_dept" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-barcode text-sm text-slate-400"></i>
            <span>Kode Departemen <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-barcode text-base"></i>
            </div>
            <input type="text" 
                   id="kode_dept" 
                   name="kode_dept" 
                   maxlength="6"
                   placeholder="Contoh: DP01 / IT / KEU" 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-black uppercase font-mono tracking-wider text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Kode departemen singkat (contoh: DP01, IT, SDM, KEU).</p>
    </div>

    <!-- Nama Departemen -->
    <div class="space-y-1.5">
        <label for="nama_dept" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-building text-sm text-slate-400"></i>
            <span>Nama Lengkap Departemen <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-building text-base"></i>
            </div>
            <input type="text" 
                   id="nama_dept" 
                   name="nama_dept" 
                   placeholder="Contoh: Departemen Sumber Daya Manusia / Keuangan..." 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
    </div>

    <!-- Actions Footer -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSubmitDepartemen" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Departemen</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formcreateDepartemen");

        // Force uppercase on kode_dept
        form.find('#kode_dept').on('input', function() {
            $(this).val($(this).val().toUpperCase().replace(/[^A-Z0-9]/g, ''));
        });

        // Validation Rules Map
        const validationRules = {
            'kode_dept': { 
                required: true, 
                message: 'Kode Departemen wajib diisi'
            },
            'nama_dept': { 
                required: true, 
                message: 'Nama Departemen wajib diisi' 
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
               .addClass('border-slate-300');
            
            $el.siblings('.pointer-events-none').find('i').removeClass('text-rose-500').addClass('text-slate-400');
            $container.find('.error-msg').remove();
        }

        function validateField(input) {
            const name = $(input).attr('name');
            const val = $(input).val() ? $(input).val().trim() : '';
            const rule = validationRules[name];

            if (!rule) return true;

            if (rule.required && !val) {
                showError(input, rule.message);
                return false;
            }

            clearError(input);
            return true;
        }

        form.find('input[type="text"]').on('input blur', function() {
            validateField(this);
        });

        // Form Submit
        form.on('submit', function(e) {
            e.preventDefault();
            let isValid = true;
            let firstInvalid = null;

            $.each(validationRules, function(fieldName, rule) {
                const input = form.find(`[name="${fieldName}"]`);
                if (input.length && !validateField(input[0])) {
                    isValid = false;
                    if (!firstInvalid) firstInvalid = input;
                }
            });

            if (!isValid) {
                if (firstInvalid) firstInvalid.focus();
                return false;
            }

            const btnSubmit = form.find("#btnSubmitDepartemen");
            btnSubmit.prop('disabled', true).html(`
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                <span>Menyimpan...</span>
            `);

            this.submit();
        });
    });
</script>
