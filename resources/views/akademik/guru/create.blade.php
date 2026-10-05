<style>
    /* Scoped Select2 Emerald Theme */
    .select2-emerald-wrapper {
        position: relative;
        width: 100%;
    }
    .select2-emerald-wrapper .select2-container {
        width: 100% !important;
    }
    .select2-emerald-wrapper .select2-container--default .select2-selection--single {
        height: 42px !important;
        padding-left: 36px !important;
        padding-right: 32px !important;
        padding-top: 6px !important;
        padding-bottom: 6px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.75rem !important; /* rounded-xl */
        background-color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03) !important;
        transition: all 0.15s ease-in-out !important;
    }
    .select2-emerald-wrapper .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1e293b !important;
        font-size: 0.75rem !important; /* text-xs */
        font-weight: 700 !important;
        padding-left: 0 !important;
        line-height: normal !important;
    }
    .select2-emerald-wrapper .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #94a3b8 !important; /* text-slate-400 */
        font-weight: 500 !important;
    }
    .select2-emerald-wrapper .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 10px !important;
        top: 1px !important;
    }
    .select2-emerald-wrapper .select2-container--default.select2-container--open .select2-selection--single,
    .select2-emerald-wrapper .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #059669 !important;
        outline: 0 !important;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2) !important;
    }
    .select2-dropdown {
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        overflow: hidden !important;
        z-index: 999999 !important;
        background-color: #ffffff !important;
    }
    .select2-container--default .select2-search--dropdown {
        padding: 8px !important;
        background-color: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.5rem !important;
        padding: 7px 10px !important;
        font-size: 0.75rem !important;
        font-weight: 500 !important;
        outline: none !important;
        background-color: #ffffff !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: #059669 !important;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2) !important;
    }
    .select2-container--default .select2-results__option {
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        padding: 8px 14px !important;
        color: #334155 !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #059669 !important;
        color: #ffffff !important;
    }
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #ecfdf5 !important;
        color: #065f46 !important;
        font-weight: 700 !important;
    }
</style>

<form action="{{ route('guru.store') }}" method="POST" id="formcreateGuru" enctype="multipart/form-data" class="space-y-4" novalidate>
    @csrf

    <!-- Info Callout -->
    <div class="p-3 bg-emerald-50/80 border border-emerald-200/80 rounded-xl flex items-start gap-2.5 text-xs text-emerald-900">
        <i class="ti ti-info-circle text-emerald-600 text-base shrink-0 mt-0.5"></i>
        <div>
            <strong class="font-bold">Penugasan Tenaga Pendidik:</strong>
            <p class="text-[11px] text-emerald-800/90 mt-0.5">Pilih pegawai aktif dari master karyawan untuk ditugaskan sebagai tenaga pendidik di unit akademik.</p>
        </div>
    </div>

    <!-- Pilih Pegawai (Karyawan) with Select2 -->
    <div class="space-y-1.5">
        <label for="npp" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-user text-sm text-slate-400"></i>
            <span>Pilih Pegawai (Karyawan) <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative select2-emerald-wrapper">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 z-10 text-slate-400">
                <i class="ti ti-user text-base"></i>
            </div>
            <select name="npp" class="select2Karyawan w-full" id="npp" style="width: 100%;">
                <option value="">-- Cari & Pilih Pegawai (Nama / NPP) --</option>
                @foreach ($karyawan as $d)
                    <option value="{{ $d->npp }}" data-unit="{{ $d->kode_unit }}">{{ $d->nama_lengkap }} (NPP: {{ $d->npp }})</option>
                @endforeach
            </select>
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Ketik nama atau NPP untuk mencari pegawai yang belum terdaftar sebagai guru.</p>
    </div>

    <!-- Grid: Unit Homebase & Jabatan Akademik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Unit Homebase (RDM) -->
        <div class="space-y-1.5">
            <label for="kode_unit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-building text-sm text-slate-400"></i>
                <span>Unit Homebase (RDM) <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-building text-base"></i>
                </div>
                <select name="kode_unit" id="kode_unit" class="w-full pl-9 pr-8 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Unit --</option>
                    @foreach ($unit as $u)
                        <option value="{{ $u->kode_unit }}">{{ $u->nama_unit }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Jabatan Akademik -->
        <div class="space-y-1.5">
            <label for="kode_jabatan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-award text-sm text-slate-400"></i>
                <span>Jabatan Akademik <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-award text-base"></i>
                </div>
                <select name="kode_jabatan" id="kode_jabatan" class="w-full pl-9 pr-8 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach ($jabatan as $j)
                        <option value="{{ $j->kode_jabatan }}">{{ $j->nama_jabatan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- NIP / NUPTK / PegID -->
    <div class="space-y-1.5">
        <label for="nomor_kemenag_dinas" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-id text-sm text-slate-400"></i>
            <span>NIP / NUPTK / PegID (Kemenag / Dinas)</span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-id text-base"></i>
            </div>
            <input type="text" 
                   name="nomor_kemenag_dinas" 
                   id="nomor_kemenag_dinas" 
                   placeholder="Contoh: 198501012010011001 / 1234567890" 
                   class="w-full pl-9 pr-3.5 py-2.5 text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Nomor identitas resmi untuk integrasi rapor siswa dan administrasi dinas/kemenag.</p>
    </div>

    <!-- Upload Tanda Tangan (Scan Digital) -->
    <div class="space-y-1.5">
        <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-file-certificate text-sm text-slate-400"></i>
            <span>Scan Tanda Tangan Digital (TTD)</span>
        </label>
        <div class="border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-xl p-3.5 text-center bg-slate-50/50 transition cursor-pointer group" onclick="$('#file_ttd_create').click()">
            <div class="flex flex-col items-center justify-center">
                <i class="ti ti-file-certificate text-2xl text-emerald-600 mb-1 group-hover:scale-110 transition-transform"></i>
                <p class="text-xs font-bold text-slate-700" id="ttd_filename_create">Klik untuk memilih file gambar TTD</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Format: PNG / JPG / JPEG (Maks. 2MB). Disarankan background transparan.</p>
            </div>
            <input type="file" 
                   name="file_ttd" 
                   id="file_ttd_create" 
                   class="hidden" 
                   accept="image/png, image/jpeg, image/jpg"
                   onchange="previewCreateTTD(this)">
        </div>
        <div id="preview_ttd_container_create" class="hidden p-2.5 bg-white border border-slate-200 rounded-xl flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2.5">
                <img id="preview_ttd_img_create" src="" alt="Preview TTD" class="h-10 object-contain border border-slate-200 rounded-lg p-1 bg-slate-50">
                <div>
                    <span class="text-xs font-bold text-slate-800 block" id="preview_ttd_name_create">ttd.png</span>
                    <span class="text-[10px] text-emerald-600 font-medium">File siap diupload</span>
                </div>
            </div>
            <button type="button" class="px-2.5 py-1 text-rose-600 hover:bg-rose-50 rounded-lg text-xs font-bold transition flex items-center gap-1" onclick="removeCreateTTD()">
                <i class="ti ti-trash"></i> <span>Hapus</span>
            </button>
        </div>
    </div>

    <!-- Actions Footer -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSubmitCreateGuru" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Data Guru</span>
        </button>
    </div>
</form>

<script>
    function previewCreateTTD(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_ttd_img_create').attr('src', e.target.result);
                $('#preview_ttd_name_create').text(file.name);
                $('#preview_ttd_container_create').removeClass('hidden');
                $('#ttd_filename_create').text(file.name);
            }
            reader.readAsDataURL(file);
        }
    }

    function removeCreateTTD() {
        $('#file_ttd_create').val('');
        $('#preview_ttd_container_create').addClass('hidden');
        $('#ttd_filename_create').text('Klik untuk memilih file gambar TTD');
    }

    $(function() {
        const form = $("#formcreateGuru");

        // Initialize Select2 for Karyawan with custom styling
        function initSelect2() {
            const selectKaryawan = form.find('#npp');
            if (selectKaryawan.length && typeof $.fn.select2 !== 'undefined') {
                if (selectKaryawan.hasClass('select2-hidden-accessible')) {
                    selectKaryawan.select2('destroy');
                }
                selectKaryawan.select2({
                    placeholder: '-- Cari & Pilih Pegawai (Nama / NPP) --',
                    dropdownParent: $('#mdlCreateGuru'),
                    allowClear: true,
                    width: '100%'
                });
            }
        }

        // Initialize immediately and also when modal is fully visible
        initSelect2();
        setTimeout(initSelect2, 100);

        // Auto select unit if data-unit is attached to employee
        $('#npp').on('change', function() {
            clearError(this);
            const selectedUnit = $(this).find(':selected').data('unit');
            if (selectedUnit) {
                $('#kode_unit').val(selectedUnit);
                clearError($('#kode_unit'));
            }
        });

        // Validation Rules Map
        const validationRules = {
            'npp': { 
                required: true, 
                message: 'Silakan pilih pegawai (karyawan) terlebih dahulu' 
            },
            'kode_unit': { 
                required: true, 
                message: 'Unit Homebase wajib dipilih' 
            },
            'kode_jabatan': { 
                required: true, 
                message: 'Jabatan Akademik wajib dipilih' 
            }
        };

        function showError(element, message) {
            const $el = $(element);
            const $container = $el.closest('.space-y-1\\.5').length ? $el.closest('.space-y-1\\.5') : ($el.closest('.space-y-1').length ? $el.closest('.space-y-1') : $el.parent());
            
            $el.addClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20')
               .removeClass('border-slate-300 focus:ring-emerald-500/20 focus:border-emerald-600');
            
            // Highlight Select2 container if applicable
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.next('.select2-container').find('.select2-selection').addClass('!border-rose-500 !ring-2 !ring-rose-500/20 !bg-rose-50/20');
            }

            // Left icon highlight
            $container.find('.pointer-events-none i').addClass('text-rose-500').removeClass('text-slate-400');
            
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
               .addClass('border-slate-300');
            
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.next('.select2-container').find('.select2-selection').removeClass('!border-rose-500 !ring-2 !ring-rose-500/20 !bg-rose-50/20');
            }

            $container.find('.pointer-events-none i').removeClass('text-rose-500').addClass('text-slate-400');
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

        form.find('select, input[type="text"]').on('change input blur', function() {
            validateField(this);
        });

        // Form Submit
        form.on('submit', function(e) {
            let isValid = true;
            let firstInvalid = null;

            // Validate all required fields
            $.each(validationRules, function(fieldName, rule) {
                const input = form.find(`[name="${fieldName}"]`);
                if (input.length) {
                    if (!validateField(input[0])) {
                        isValid = false;
                        if (!firstInvalid) firstInvalid = input;
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
                if (firstInvalid) {
                    if (firstInvalid.hasClass('select2-hidden-accessible')) {
                        firstInvalid.select2('open');
                    } else {
                        firstInvalid.focus();
                    }
                }

                // Shake button feedback
                const submitBtn = $("#btnSubmitCreateGuru");
                submitBtn.addClass('animate-shake');
                setTimeout(() => submitBtn.removeClass('animate-shake'), 500);

                return false;
            }

            // Valid -> Loading State
            $("#btnSubmitCreateGuru").prop('disabled', true).html(`
                <i class="ti ti-loader animate-spin text-base"></i>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>
