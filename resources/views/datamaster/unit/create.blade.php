<form action="{{ route('unit.store') }}" id="formcreateUnit" method="POST" enctype="multipart/form-data" class="space-y-4" novalidate>
    @csrf

    <!-- Kode Unit -->
    <div class="space-y-1.5">
        <label for="kode_unit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-barcode text-sm text-slate-400"></i>
            <span>Kode Unit (2-3 Karakter) <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-barcode text-base"></i>
            </div>
            <input type="text" 
                   id="kode_unit" 
                   name="kode_unit" 
                   maxlength="3"
                   placeholder="Contoh: TK / SDI / MTS / MA" 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-black uppercase font-mono tracking-wider text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Format kode unit 2-3 huruf unik (contoh: TK, SDI, MTS, MA).</p>
    </div>

    <!-- Nama Unit -->
    <div class="space-y-1.5">
        <label for="nama_unit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-building-community text-sm text-slate-400"></i>
            <span>Nama Lengkap Unit <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-building-community text-base"></i>
            </div>
            <input type="text" 
                   id="nama_unit" 
                   name="nama_unit" 
                   placeholder="Contoh: TK Islam Terpadu Al-Amin..." 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
    </div>

    <!-- Status Tampilan -->
    <div class="space-y-1.5">
        <label for="status" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-eye text-sm text-slate-400"></i>
            <span>Status Unit <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-eye text-base"></i>
            </div>
            <select name="status" 
                    id="status" 
                    class="w-full appearance-none pl-9 pr-9 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                <option value="1">Show (Tampilkan di Sistem & Menu)</option>
                <option value="0">Hide (Sembunyikan)</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                <i class="ti ti-chevron-down text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Keterangan -->
    <div class="space-y-1.5">
        <label for="keterangan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-notes text-sm text-slate-400"></i>
            <span>Keterangan (Opsional)</span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute top-3 left-3 text-slate-400">
                <i class="ti ti-notes text-base"></i>
            </div>
            <textarea id="keterangan" 
                      name="keterangan" 
                      rows="2" 
                      placeholder="Catatan tambahan mengenai unit ini..."
                      class="w-full pl-9 pr-3.5 py-2.5 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition resize-none"></textarea>
        </div>
    </div>

    <!-- Upload Logo Unit -->
    <div class="space-y-1.5">
        <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-photo text-sm text-slate-400"></i>
            <span>Logo Unit (Opsional)</span>
        </label>
        <div class="relative">
            <label for="logo" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-xl bg-slate-50/70 hover:bg-emerald-50/20 transition cursor-pointer text-center group">
                <div id="uploadPlaceholder" class="flex flex-col items-center space-y-1">
                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 group-hover:text-emerald-600 group-hover:border-emerald-200 flex items-center justify-center text-xl transition shadow-2xs">
                        <i class="ti ti-cloud-upload"></i>
                    </div>
                    <div class="text-xs font-bold text-slate-700 group-hover:text-emerald-700">Klik untuk upload logo unit</div>
                    <p class="text-[11px] text-slate-400">Format: PNG, JPG, JPEG, WEBP (Maks. 2MB)</p>
                </div>
                <div id="previewContainer" class="hidden flex flex-col items-center space-y-2">
                    <img id="previewImg" src="" alt="Preview Logo" class="h-16 w-auto max-w-[120px] object-contain rounded-lg p-1 bg-white border border-slate-200 shadow-2xs">
                    <button type="button" id="btnRemoveLogo" class="px-2.5 py-1 bg-rose-50 text-rose-600 hover:bg-rose-100 font-bold text-[11px] rounded-lg border border-rose-200 transition">
                        <i class="ti ti-trash mr-1"></i> Hapus Logo
                    </button>
                </div>
                <input type="file" name="logo" id="logo" class="hidden" accept="image/*">
            </label>
        </div>
    </div>

    <!-- Actions Footer -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSubmitUnit" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Unit</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formcreateUnit");

        // Force uppercase on kode_unit
        form.find('#kode_unit').on('input', function() {
            $(this).val($(this).val().toUpperCase().replace(/[^A-Z0-9]/g, ''));
        });

        // Logo Image Preview Handler
        const logoInput = document.getElementById('logo');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const previewContainer = document.getElementById('previewContainer');
        const previewImg = document.getElementById('previewImg');
        const btnRemoveLogo = document.getElementById('btnRemoveLogo');

        if (logoInput) {
            logoInput.addEventListener('change', function(e) {
                const file = this.files[0];
                if (file) {
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ukuran Terlalu Besar',
                            text: 'Ukuran logo maksimal 2MB',
                            confirmButtonColor: '#059669',
                            customClass: { popup: 'rounded-2xl shadow-2xl' }
                        });
                        this.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        previewImg.src = event.target.result;
                        uploadPlaceholder.classList.add('hidden');
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        if (btnRemoveLogo) {
            btnRemoveLogo.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (logoInput) logoInput.value = '';
                previewImg.src = '';
                previewContainer.classList.add('hidden');
                uploadPlaceholder.classList.remove('hidden');
            });
        }

        // Real-time validation rules
        const validationRules = {
            'kode_unit': { 
                required: true, 
                message: 'Kode Unit wajib diisi', 
                minLength: 2, 
                maxLength: 3, 
                lengthMessage: 'Kode Unit harus 2 sampai 3 karakter (contoh: TK, SDI, MTS)' 
            },
            'nama_unit': { 
                required: true, 
                message: 'Nama Unit Pendidikan wajib diisi' 
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

            if (rule.minLength && val.length < rule.minLength) {
                showError(input, rule.lengthMessage || `Minimal ${rule.minLength} karakter`);
                return false;
            }

            if (rule.maxLength && val.length > rule.maxLength) {
                showError(input, rule.lengthMessage || `Maksimal ${rule.maxLength} karakter`);
                return false;
            }

            clearError(input);
            return true;
        }

        form.find('input').on('input blur', function() {
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

            const btnSubmit = form.find("#btnSubmitUnit");
            btnSubmit.prop('disabled', true).html(`
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                <span>Menyimpan...</span>
            `);

            this.submit();
        });
    });
</script>
