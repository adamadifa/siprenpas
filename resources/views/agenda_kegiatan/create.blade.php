<form action="{{ route('agendakegiatan.store') }}" id="formCreateAgendakegiatan" method="POST" class="space-y-4" novalidate>
    @csrf

    <!-- Tanggal & Nama Kegiatan -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
        <!-- Tanggal -->
        <div class="space-y-1.5 sm:col-span-1">
            <label for="tanggal" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-calendar text-sm text-slate-400"></i>
                <span>Tanggal <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-calendar text-base"></i>
                </div>
                <input type="text" 
                       name="tanggal" 
                       id="tanggal" 
                       value="{{ date('Y-m-d') }}"
                       placeholder="Pilih Tanggal"
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition flatpickr-date"
                       required>
            </div>
        </div>

        <!-- Nama Kegiatan -->
        <div class="space-y-1.5 sm:col-span-2">
            <label for="nama_kegiatan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-file-description text-sm text-slate-400"></i>
                <span>Nama Agenda Kegiatan <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-calendar-event text-base"></i>
                </div>
                <input type="text" 
                       name="nama_kegiatan" 
                       id="nama_kegiatan" 
                       placeholder="Contoh: Rapat Koordinasi Evaluasi Kurikulum Pesantren"
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                       required>
            </div>
        </div>
    </div>

    @if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris']))
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
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
                    <select name="kode_unit" id="kode_unit" class="w-full pl-9 pr-8 py-2.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">Semua / Umum</option>
                        @foreach ($unit as $u)
                            <option value="{{ $u->kode_unit }}">{{ strtoupper($u->nama_unit) }}</option>
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
                    <select name="kode_dept" id="kode_dept" class="w-full pl-9 pr-8 py-2.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" required>
                        <option value="">-- Pilih Departemen --</option>
                        @foreach ($departemen as $d)
                            <option value="{{ $d->kode_dept }}">{{ strtoupper($d->nama_dept) }}</option>
                        @endforeach
                    </select>
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
                    <select name="kode_jabatan" id="kode_jabatan" class="w-full pl-9 pr-8 py-2.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach ($jabatan as $j)
                            <option value="{{ $j->kode_jabatan }}">{{ strtoupper($j->nama_jabatan) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    @endif

    <!-- Uraian Kegiatan -->
    <div class="space-y-1.5">
        <label for="uraian_kegiatan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-notes text-sm text-slate-400"></i>
            <span>Uraian & Rincian Agenda Kegiatan <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <textarea name="uraian_kegiatan" 
                      id="uraian_kegiatan" 
                      rows="4" 
                      placeholder="Uraikan detail agenda kegiatan, susunan acara, lokasi pelaksanaan, serta personil yang terlibat..." 
                      class="w-full p-3 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition resize-y"
                      required></textarea>
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Tuliskan penjelasan agenda kegiatan secara ringkas, jelas, dan terstruktur.</p>
    </div>

    <!-- Modal Footer Actions -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSimpan" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Agenda</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formCreateAgendakegiatan");

        // Init flatpickr
        form.find("#tanggal").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true
        });

        // Validation Rules Map
        const validationRules = {
            'tanggal': {
                required: true,
                message: 'Tanggal kegiatan wajib diisi'
            },
            'nama_kegiatan': {
                required: true,
                message: 'Nama kegiatan wajib diisi'
            },
            'uraian_kegiatan': {
                required: true,
                message: 'Uraian kegiatan wajib diisi'
            },
            'kode_dept': {
                required: true,
                message: 'Departemen wajib dipilih'
            },
            'kode_jabatan': {
                required: true,
                message: 'Jabatan wajib dipilih'
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

        // Dynamic Department & Jabatan Cascade
        function updateCascades() {
            let kode_unit = form.find('#kode_unit').val();
            let kode_dept = form.find('#kode_dept').val();

            if (kode_unit === "" || kode_unit === null) {
                return;
            }

            $.ajax({
                url: "{{ route('programkerja.get-karyawan-filter-options') }}",
                type: "GET",
                data: {
                    kode_unit: kode_unit,
                    kode_dept: kode_dept
                },
                success: function(response) {
                    let deptSelect = form.find('#kode_dept');
                    let activeDept = deptSelect.val();
                    deptSelect.empty().append('<option value="">-- Pilih Departemen --</option>');
                    response.departments.forEach(function(dept) {
                        let selected = activeDept === dept.kode_dept ? 'selected' : '';
                        deptSelect.append(`<option value="${dept.kode_dept}" ${selected}>${dept.nama_dept.toUpperCase()}</option>`);
                    });

                    let jabSelect = form.find('#kode_jabatan');
                    let activeJab = jabSelect.val();
                    jabSelect.empty().append('<option value="">-- Pilih Jabatan --</option>');
                    if (kode_dept !== "" && kode_dept !== null) {
                        response.jabatans.forEach(function(jab) {
                            let selected = activeJab === jab.kode_jabatan ? 'selected' : '';
                            jabSelect.append(`<option value="${jab.kode_jabatan}" ${selected}>${jab.nama_jabatan.toUpperCase()}</option>`);
                        });
                    }
                }
            });
        }

        form.find('#kode_unit').on('change', function() {
            form.find('#kode_dept').val('');
            form.find('#kode_jabatan').val('');
            updateCascades();
        });

        form.find('#kode_dept').on('change', function() {
            let kode_unit = form.find('#kode_unit').val();
            let kode_dept = $(this).val();

            $.ajax({
                url: "{{ route('programkerja.get-karyawan-filter-options') }}",
                type: "GET",
                data: {
                    kode_unit: kode_unit,
                    kode_dept: kode_dept
                },
                success: function(response) {
                    let jabSelect = form.find('#kode_jabatan');
                    let activeJab = jabSelect.val();
                    jabSelect.empty().append('<option value="">-- Pilih Jabatan --</option>');
                    response.jabatans.forEach(function(jab) {
                        let selected = activeJab === jab.kode_jabatan ? 'selected' : '';
                        jabSelect.append(`<option value="${jab.kode_jabatan}" ${selected}>${jab.nama_jabatan.toUpperCase()}</option>`);
                    });
                }
            });
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
