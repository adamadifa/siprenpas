<form action="{{ route('jenisbiaya.update', Crypt::encrypt($jenisbiaya->kode_jenis_biaya)) }}" id="formeditBiaya" method="POST" class="space-y-4" novalidate>
    @csrf
    @method('PUT')

    <!-- Kode Jenis Biaya (Readonly) -->
    <div class="space-y-1.5">
        <label for="kode_jenis_biaya" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-barcode text-sm text-slate-400"></i>
            <span>Kode Jenis Biaya (Tidak Dapat Diubah)</span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-barcode text-base"></i>
            </div>
            <input type="text" 
                   id="kode_jenis_biaya" 
                   name="kode_jenis_biaya" 
                   value="{{ $jenisbiaya->kode_jenis_biaya }}"
                   readonly
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-black uppercase font-mono tracking-wider text-slate-600 bg-slate-100 border border-slate-300 rounded-xl shadow-2xs cursor-not-allowed">
        </div>
    </div>

    <!-- Nama Jenis Biaya -->
    <div class="space-y-1.5">
        <label for="jenis_biaya" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-receipt-2 text-sm text-slate-400"></i>
            <span>Nama Jenis Biaya <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-receipt-2 text-base"></i>
            </div>
            <input type="text" 
                   id="jenis_biaya" 
                   name="jenis_biaya" 
                   value="{{ $jenisbiaya->jenis_biaya }}"
                   placeholder="Contoh: Biaya Pendaftaran / SPP Bulanan..." 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
    </div>

    <!-- Tampilkan di Landing Page -->
    <div class="p-3.5 bg-slate-50 border border-slate-200/90 rounded-xl space-y-2">
        <div class="flex items-center justify-between">
            <label for="tampilkan_di_landing_edit" class="text-xs font-bold text-slate-800 flex items-center gap-1.5 cursor-pointer">
                <i class="ti ti-browser-check text-emerald-600 text-sm"></i>
                <span>Tampilkan di Landing Page (Biaya Masuk)</span>
            </label>
            <label class="switch-toggle">
                <input type="checkbox" 
                       id="tampilkan_di_landing_edit" 
                       name="tampilkan_di_landing" 
                       value="1" 
                       {{ $jenisbiaya->tampilkan_di_landing ? 'checked' : '' }}
                       class="switch-toggle-input">
                <span class="switch-toggle-slider"></span>
            </label>
        </div>
        <p class="text-[11px] text-slate-500 leading-relaxed">
            Jika diaktifkan, komponen biaya ini akan otomatis masuk dalam kalkulasi dan tabel rincian biaya awal pendaftaran di website publik.
        </p>
    </div>

    <!-- Actions Footer -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSubmitEditBiaya" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formeditBiaya");

        // Validation Rules Map
        const validationRules = {
            'jenis_biaya': { 
                required: true, 
                message: 'Nama Jenis Biaya wajib diisi' 
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

            const btnSubmit = form.find("#btnSubmitEditBiaya");
            btnSubmit.prop('disabled', true).html(`
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                <span>Menyimpan...</span>
            `);

            this.submit();
        });
    });
</script>