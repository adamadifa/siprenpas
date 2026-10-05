<form action="{{ route('pendaftarangottalent.store') }}" id="formcreatePendaftaranGotTalent" method="POST" class="space-y-4" novalidate>
    @csrf

    <!-- Biodata Header Section -->
    <div class="p-3.5 bg-emerald-50/80 border border-emerald-200/80 rounded-2xl flex items-center gap-3">
        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-base font-bold shadow-2xs">
            <i class="ti ti-user-check"></i>
        </div>
        <div>
            <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider">Biodata Calon Peserta</h4>
            <p class="text-[11px] text-slate-500">Lengkapi data diri peserta sesuai identitas resmi</p>
        </div>
    </div>

    <!-- Nama Lengkap -->
    <div class="space-y-1.5">
        <label for="nama_lengkap" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-user text-sm text-slate-400"></i>
            <span>Nama Lengkap <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-user text-base"></i>
            </div>
            <input type="text" 
                   id="nama_lengkap" 
                   name="nama_lengkap" 
                   placeholder="Masukkan nama lengkap peserta..." 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
    </div>

    <!-- Tempat & Tanggal Lahir -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <div class="space-y-1.5">
            <label for="tempat_lahir" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-map-pin text-sm text-slate-400"></i>
                <span>Tempat Lahir <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-map-pin text-base"></i>
                </div>
                <input type="text" 
                       id="tempat_lahir" 
                       name="tempat_lahir" 
                       placeholder="Kota kelahiran..." 
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>
        <div class="space-y-1.5">
            <label for="tanggal_lahir" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-calendar text-sm text-slate-400"></i>
                <span>Tanggal Lahir <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-calendar text-base"></i>
                </div>
                <input type="text" 
                       id="tanggal_lahir" 
                       name="tanggal_lahir" 
                       placeholder="YYYY-MM-DD" 
                       class="flatpickr-date w-full pl-9 pr-3.5 py-2.5 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
            </div>
        </div>
    </div>

    <!-- Jenjang Pendidikan & Asal Sekolah -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <div class="space-y-1.5">
            <label for="id_jenjang" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-school text-sm text-slate-400"></i>
                <span>Jenjang Pendidikan <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-school text-base"></i>
                </div>
                <select id="id_jenjang" 
                        name="id_jenjang" 
                        class="w-full pl-9 pr-8 py-2.5 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition appearance-none">
                    <option value="">-- Pilih Jenjang --</option>
                    @foreach ($jenjangPendidikan as $d)
                        <option value="{{ $d->id }}">{{ $d->jenjang_pendidikan }}</option>
                    @endforeach
                </select>
                <i class="ti ti-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
            </div>
        </div>
        <div class="space-y-1.5">
            <label for="asal_sekolah" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-building-community text-sm text-slate-400"></i>
                <span>Asal Sekolah / Madrasah <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-building-community text-base"></i>
                </div>
                <input type="text" 
                       id="asal_sekolah" 
                       name="asal_sekolah" 
                       placeholder="Nama sekolah asal..." 
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>
    </div>

    <!-- Kontak & Email -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <div class="space-y-1.5">
            <label for="no_hp" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-brand-whatsapp text-sm text-emerald-600"></i>
                <span>No. HP / WhatsApp <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-brand-whatsapp text-base text-emerald-600"></i>
                </div>
                <input type="text" 
                       id="no_hp" 
                       name="no_hp" 
                       placeholder="Contoh: 081234567890" 
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>
        <div class="space-y-1.5">
            <label for="email" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-mail text-sm text-slate-400"></i>
                <span>Email Aktif <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-mail text-base"></i>
                </div>
                <input type="email" 
                       id="email" 
                       name="email" 
                       placeholder="peserta@domain.com" 
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>
    </div>

    <!-- Alamat Sekolah & Rumah -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <div class="space-y-1.5">
            <label for="alamat_sekolah" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-map-pin text-sm text-slate-400"></i>
                <span>Alamat Sekolah <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <textarea id="alamat_sekolah" 
                      name="alamat_sekolah" 
                      rows="2" 
                      placeholder="Alamat lengkap asal sekolah..." 
                      class="w-full p-3 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"></textarea>
        </div>
        <div class="space-y-1.5">
            <label for="alamat_rumah" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-home text-sm text-slate-400"></i>
                <span>Alamat Rumah / Domisili <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <textarea id="alamat_rumah" 
                      name="alamat_rumah" 
                      rows="2" 
                      placeholder="Alamat lengkap tempat tinggal peserta..." 
                      class="w-full p-3 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"></textarea>
        </div>
    </div>

    <!-- Section Pilihan Cabang Perlombaan -->
    <div class="p-4 bg-slate-50 border border-slate-200/90 rounded-2xl space-y-3" id="container-perlombaan">
        <div class="flex items-center justify-between">
            <label class="block text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                <i class="ti ti-trophy text-emerald-600 text-sm"></i>
                <span>Pilihan Cabang Perlombaan <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-100/70 px-2 py-0.5 rounded-md border border-emerald-200/60 shadow-2xs">
                Pilih minimal 1 lomba
            </span>
        </div>

        @if ($perlombaan && $perlombaan->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 max-h-60 overflow-y-auto pr-1">
                @foreach ($perlombaan as $lomba)
                    <label class="flex items-center gap-3 p-3 bg-white hover:bg-emerald-50/50 border border-slate-200 rounded-xl cursor-pointer transition-all duration-150 group has-checked:border-emerald-500 has-checked:bg-emerald-50/70 has-checked:shadow-xs">
                        <input type="checkbox" name="perlombaan[]" value="{{ $lomba->id }}" id="perlombaan_{{ $lomba->id }}" 
                               class="w-4 h-4 text-emerald-600 rounded-md border-slate-300 focus:ring-emerald-500 cursor-pointer">
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-bold text-slate-900 group-hover:text-emerald-800 truncate">
                                {{ $lomba->jenis_perlombaan }}
                            </div>
                            <div class="flex items-center gap-2 mt-0.5 text-[10.5px]">
                                <span class="text-indigo-600 font-semibold">
                                    {{ $lomba->jenjangPendidikan->jenjang_pendidikan ?? '-' }}
                                </span>
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <span class="font-mono font-bold text-slate-700">
                                    {{ !empty($lomba->biaya_pendaftaran) ? 'Rp ' . formatRupiah($lomba->biaya_pendaftaran) : 'Gratis' }}
                                </span>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
        @else
            <p class="text-xs text-slate-400 italic">Belum ada data cabang perlombaan yang tersedia.</p>
        @endif
    </div>

    <!-- Actions Footer -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSubmitPendaftaran" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Pendaftaran</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formcreatePendaftaranGotTalent");

        if (typeof flatpickr !== 'undefined') {
            form.find(".flatpickr-date").flatpickr({
                dateFormat: "Y-m-d",
                allowInput: true
            });
        }

        // Validation Rules Map
        const validationRules = {
            'nama_lengkap': { required: true, message: 'Nama Lengkap wajib diisi' },
            'tempat_lahir': { required: true, message: 'Tempat Lahir wajib diisi' },
            'tanggal_lahir': { required: true, message: 'Tanggal Lahir wajib diisi' },
            'id_jenjang': { required: true, message: 'Jenjang Pendidikan harus dipilih' },
            'asal_sekolah': { required: true, message: 'Asal Sekolah wajib diisi' },
            'no_hp': { required: true, message: 'No. HP / WhatsApp wajib diisi' },
            'email': { required: true, message: 'Email aktif wajib diisi', email: true },
            'alamat_sekolah': { required: true, message: 'Alamat Sekolah wajib diisi' },
            'alamat_rumah': { required: true, message: 'Alamat Rumah wajib diisi' }
        };

        function showError(element, message) {
            const $el = $(element);
            const $container = $el.closest('.space-y-1\\.5').length ? $el.closest('.space-y-1\\.5') : $el.parent();
            
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
            const $container = $el.closest('.space-y-1\\.5').length ? $el.closest('.space-y-1\\.5') : $el.parent();
            
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

            if (rule.email && val) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(val)) {
                    showError($el, 'Format email tidak valid');
                    return false;
                }
            }

            clearError($el);
            return true;
        }

        // Realtime validation trigger
        form.on('input change blur', 'input, select, textarea', function(e) {
            const $this = $(this);
            if ($this.attr('type') === 'checkbox') return;
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

            // Validate Checkbox Perlombaan
            const checkedLomba = form.find('input[name="perlombaan[]"]:checked').length;
            const $lombaContainer = form.find('#container-perlombaan');
            $lombaContainer.find('.error-msg-lomba').remove();

            if (checkedLomba === 0) {
                isValid = false;
                $lombaContainer.addClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/10')
                               .removeClass('border-slate-200/90 bg-slate-50');
                $lombaContainer.append(`
                    <p class="error-msg-lomba text-[11px] font-semibold text-rose-500 mt-2 flex items-center gap-1">
                        <i class="ti ti-alert-circle text-xs shrink-0"></i>
                        <span>Pilihan Cabang Perlombaan harus dipilih minimal 1!</span>
                    </p>
                `);
                if (!firstInvalidEl) {
                    firstInvalidEl = $lombaContainer;
                }
            } else {
                $lombaContainer.removeClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/10')
                               .addClass('border-slate-200/90 bg-slate-50');
            }

            if (!isValid) {
                e.preventDefault();
                if (firstInvalidEl && typeof firstInvalidEl.focus === 'function') {
                    firstInvalidEl.focus();
                }
                return false;
            }

            // Disable submit button with spinner
            const submitBtn = form.find('#btnSubmitPendaftaran');
            submitBtn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');
            setTimeout(function() {
                submitBtn.prop('disabled', true);
            }, 50);
        });

        form.on('change', 'input[name="perlombaan[]"]', function() {
            const checkedCount = form.find('input[name="perlombaan[]"]:checked').length;
            const $lombaContainer = form.find('#container-perlombaan');
            if (checkedCount > 0) {
                $lombaContainer.removeClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/10')
                               .addClass('border-slate-200/90 bg-slate-50');
                $lombaContainer.find('.error-msg-lomba').remove();
            }
        });
    });
</script>
