<form action="{{ route('jobdesk.store') }}" id="formcreateJobdesk" method="POST" class="space-y-4" novalidate>
    @csrf

    @hasanyrole(['super admin', 'pimpinan pesantren', 'sekretaris'])
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Unit Kerja -->
            <div class="space-y-1.5">
                <label for="kode_unit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-building text-sm text-slate-400"></i>
                    <span>Unit Kerja <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-building text-base"></i>
                    </div>
                    <select name="kode_unit" id="kode_unit" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">-- Pilih Unit Kerja --</option>
                        @foreach ($unit as $d)
                            <option value="{{ $d->kode_unit }}" {{ (isset($pre_selected_unit) && $pre_selected_unit == $d->kode_unit) ? 'selected' : '' }}>
                                {{ strtoupper($d->nama_unit) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Departemen -->
            <div class="space-y-1.5">
                <label for="kode_dept" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-sitemap text-sm text-slate-400"></i>
                    <span>Departemen <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-sitemap text-base"></i>
                    </div>
                    <select name="kode_dept" id="kode_dept" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" required>
                        <option value="">-- Pilih Departemen --</option>
                        @foreach ($departemen as $d)
                            <option value="{{ $d->kode_dept }}" {{ (isset($pre_selected_dept) && $pre_selected_dept == $d->kode_dept) ? 'selected' : '' }}>
                                {{ strtoupper($d->nama_dept) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Jabatan -->
        <div class="space-y-1.5">
            <label for="kode_jabatan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-briefcase text-sm text-slate-400"></i>
                <span>Jabatan <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-briefcase text-base"></i>
                </div>
                <select name="kode_jabatan" id="kode_jabatan" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" required>
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach ($jabatan as $d)
                        <option value="{{ $d->kode_jabatan }}" {{ (isset($pre_selected_jabatan) && $pre_selected_jabatan == $d->kode_jabatan) ? 'selected' : '' }}>
                            {{ strtoupper($d->nama_jabatan) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endhasanyrole

    <!-- Uraian Jobdesk -->
    <div class="space-y-1.5">
        <label for="jobdesk" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-file-text text-sm text-slate-400"></i>
            <span>Uraian Tugas Pokok & Fungsi (Jobdesk) <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <textarea name="jobdesk" 
                      id="jobdesk" 
                      rows="4" 
                      placeholder="Contoh: Menyusun silabus dan RPP, melaksanakan proses pembelajaran, mengelola nilai rapor siswa..." 
                      class="w-full p-3 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition resize-y"></textarea>
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Tuliskan rincian tugas pokok dan tanggung jawab jabatan di unit terkait.</p>
    </div>

    <!-- Actions Footer -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSimpan" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Data Jobdesk</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formcreateJobdesk");

        // Validation Rules Map
        const validationRules = {
            'kode_dept': {
                required: true,
                message: 'Departemen wajib dipilih'
            },
            'kode_jabatan': {
                required: true,
                message: 'Jabatan wajib dipilih'
            },
            'jobdesk': {
                required: true,
                message: 'Uraian tugas pokok (jobdesk) wajib diisi'
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

            clearError($el);
            return true;
        }

        // Realtime validation trigger
        form.on('input change blur', 'input, select, textarea', function(e) {
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
            const submitBtn = form.find('#btnSimpan');
            submitBtn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');
            setTimeout(function() {
                submitBtn.prop('disabled', true);
            }, 50);
            return true;
        });
    });
</script>
