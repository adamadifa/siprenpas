<form action="{{ route('realisasikegiatan.store') }}" id="formCreaterealisasikegiatan" method="POST" enctype="multipart/form-data" class="space-y-4" novalidate>
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
                <span>Nama Realisasi Kegiatan <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-activity text-base"></i>
                </div>
                <input type="text" 
                       name="nama_kegiatan" 
                       id="nama_kegiatan" 
                       placeholder="Contoh: Pembinaan Karakter Santri Asrama dan Tahsin"
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                       required>
            </div>
        </div>
    </div>

    @if ($user->hasRole('super admin'))
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
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

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Jobdesk -->
        <div class="space-y-1.5">
            <label for="kode_jobdesk" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-list-check text-sm text-slate-400"></i>
                <span>Terkait Jobdesk <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-list-check text-base"></i>
                </div>
                <select name="kode_jobdesk" id="kode_jobdesk" class="w-full pl-9 pr-8 py-2.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Jobdesk Terkait --</option>
                </select>
            </div>
        </div>

        <!-- Program Kerja -->
        <div class="space-y-1.5">
            <label for="kode_program_kerja" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-notebook text-sm text-slate-400"></i>
                <span>Terkait Program Kerja <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-notebook text-base"></i>
                </div>
                <select name="kode_program_kerja" id="kode_program_kerja" class="w-full pl-9 pr-8 py-2.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Program Kerja Terkait --</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Uraian Realisasi -->
    <div class="space-y-1.5">
        <label for="uraian_kegiatan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-notes text-sm text-slate-400"></i>
            <span>Uraian Realisasi & Hasil Capaian <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <textarea name="uraian_kegiatan" 
                      id="uraian_kegiatan" 
                      rows="4" 
                      placeholder="Jelaskan pelaksanaan kegiatan, hasil yang dicapai, kendala, atau tindak lanjut..." 
                      class="w-full p-3 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition resize-y"
                      required></textarea>
        </div>
    </div>

    <!-- Upload Foto Bukti Kegiatan -->
    <div class="space-y-1.5">
        <label for="foto" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-camera text-sm text-slate-400"></i>
            <span>Foto Dokumentasi / Bukti Kegiatan <span class="text-slate-400 font-normal text-[11px]">(Opsional, Maks 1MB)</span></span>
        </label>
        <div class="relative">
            <input type="file" 
                   name="foto" 
                   id="foto" 
                   accept="image/jpeg,image/png,image/jpg"
                   class="w-full p-2.5 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-xl shadow-2xs file:mr-3 file:py-1.5 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
        </div>
    </div>

    <!-- Modal Footer Actions -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSimpan" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Realisasi</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formCreaterealisasikegiatan");

        // Init flatpickr
        form.find("#tanggal").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true
        });

        // Validation Rules Map
        const validationRules = {
            'tanggal': {
                required: true,
                message: 'Tanggal realisasi wajib diisi'
            },
            'nama_kegiatan': {
                required: true,
                message: 'Nama kegiatan wajib diisi'
            },
            'uraian_kegiatan': {
                required: true,
                message: 'Uraian hasil realisasi wajib diisi'
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

        function getJobdesk() {
            let kode_jabatan = form.find('#kode_jabatan').val();
            let kode_dept = form.find('#kode_dept').val();

            $.ajax({
                url: "{{ route('jobdesk.getjobdesk') }}",
                type: "GET",
                data: {
                    kode_jabatan: kode_jabatan,
                    kode_dept: kode_dept
                },
                cache: false,
                success: function(response) {
                    let select = form.find("#kode_jobdesk");
                    select.empty().append('<option value="">-- Pilih Jobdesk Terkait --</option>');
                    for (let i = 0; i < response.length; i++) {
                        select.append('<option value="' + response[i].kode_jobdesk + '">' + response[i].jobdesk + '</option>');
                    }
                }
            });
        }

        function getProgramkerja() {
            let kode_jabatan = form.find('#kode_jabatan').val();
            let kode_dept = form.find('#kode_dept').val();

            $.ajax({
                url: "{{ route('programkerja.getprogramkerja') }}",
                type: "GET",
                data: {
                    kode_jabatan: kode_jabatan,
                    kode_dept: kode_dept
                },
                cache: false,
                success: function(response) {
                    let select = form.find("#kode_program_kerja");
                    select.empty().append('<option value="">-- Pilih Program Kerja Terkait --</option>');
                    for (let i = 0; i < response.length; i++) {
                        select.append('<option value="' + response[i].kode_program_kerja + '">' + response[i].program_kerja + '</option>');
                    }
                }
            });
        }

        form.find('#kode_jabatan, #kode_dept').on('change', function() {
            getJobdesk();
            getProgramkerja();
        });

        getJobdesk();
        getProgramkerja();

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

            // Validate File if present
            const fileInput = form.find('#foto')[0];
            if (fileInput && fileInput.files && fileInput.files[0]) {
                const file = fileInput.files[0];
                if (file.size > 1048576) {
                    showError(fileInput, 'Ukuran foto maksimal 1MB');
                    isValid = false;
                    if (!firstInvalidEl) firstInvalidEl = $(fileInput);
                }
            }

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
