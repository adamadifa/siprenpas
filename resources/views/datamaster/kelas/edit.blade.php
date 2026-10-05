<form action="{{ route('kelas.update', Crypt::encrypt($kelas->kode_kelas)) }}" id="formeditKelas" method="POST" class="space-y-4" novalidate>
    @csrf
    @method('PUT')

    <!-- Nama Kelas -->
    <div class="space-y-1.5">
        <label for="nama_kelas" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-door-enter text-sm text-slate-400"></i>
            <span>Nama Kelas <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-door text-base"></i>
            </div>
            <input type="text" 
                   id="nama_kelas" 
                   name="nama_kelas" 
                   value="{{ $kelas->nama_kelas }}"
                   placeholder="Contoh: A / B / VII-A / 10 IPA 1..." 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Nama rombongan belajar / sebutan kelas di unit pendidikan.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Jenjang / Unit -->
        <div class="space-y-1.5">
            <label for="kode_unit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-school text-sm text-slate-400"></i>
                <span>Jenjang / Unit <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-building text-base"></i>
                </div>
                <select name="kode_unit" id="kode_unit" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Unit --</option>
                    @foreach ($unit as $u)
                        <option value="{{ $u->kode_unit }}" {{ $kelas->kode_unit == $u->kode_unit ? 'selected' : '' }}>
                            {{ strtoupper($u->nama_unit) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Tingkat Kelas -->
        <div class="space-y-1.5">
            <label for="tingkat" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-chart-bar text-sm text-slate-400"></i>
                <span>Tingkat / Jenjang Kelas <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-numbers text-base"></i>
                </div>
                <select name="tingkat" id="tingkat" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Tingkat --</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Wali Kelas -->
    <div class="space-y-1.5" id="wali_kelas_group">
        <label for="guru_id" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-user-check text-sm text-slate-400"></i>
            <span>Wali Kelas (Opsional)</span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-user text-base"></i>
            </div>
            <select name="guru_id" id="guru_id" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                <option value="">-- Pilih Wali Kelas --</option>
                @foreach ($gurus as $g)
                    <option value="{{ $g->id }}" {{ $kelas->guru_id == $g->id ? 'selected' : '' }}>
                        {{ $g->nama_guru }}
                    </option>
                @endforeach
            </select>
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Guru yang ditugaskan bertanggung jawab mengelola presensi dan rapor kelas ini.</p>
    </div>

    <!-- Actions Footer -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnUpdateKelas" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formeditKelas");

        // Validation Rules Map
        const validationRules = {
            'nama_kelas': { 
                required: true, 
                message: 'Nama Kelas wajib diisi' 
            },
            'kode_unit': { 
                required: true, 
                message: 'Unit Pendidikan wajib dipilih' 
            },
            'tingkat': { 
                required: true, 
                message: 'Tingkat Kelas wajib dipilih' 
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
        form.on('input change blur', 'input, select', function(e) {
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
            const submitBtn = form.find('#btnUpdateKelas');
            submitBtn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');
            setTimeout(function() {
                submitBtn.prop('disabled', true);
            }, 50);
        });
    });
</script>
