<form action="{{ route('guru.update', Crypt::encrypt($guru->id)) }}" method="POST" id="formeditGuru" enctype="multipart/form-data" class="space-y-4" novalidate>
    @csrf
    @method('PUT')
    <div class="space-y-4">

        <!-- Teacher Profile Card Banner -->
        <div class="p-3.5 bg-gradient-to-r from-emerald-50 to-teal-50/60 border border-emerald-200/90 rounded-xl flex items-center gap-3.5">
            <div class="relative shrink-0">
                @if (!empty($karyawan->foto) && Storage::disk('public')->exists('photos/karyawan/' . $karyawan->foto))
                    <img src="{{ getfotoKaryawan($karyawan->foto) }}" alt="{{ $karyawan->nama_lengkap }}" class="w-12 h-15 rounded-lg object-cover border border-emerald-200 shadow-2xs">
                @else
                    <div class="w-12 h-15 rounded-lg bg-emerald-600 text-white flex flex-col items-center justify-center font-bold text-base shadow-2xs">
                        {{ strtoupper(substr($guru->karyawan->nama_lengkap ?? 'G', 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <h4 class="text-sm font-bold text-slate-800 truncate capitalize">
                        {{ textCamelCase($guru->karyawan->nama_lengkap ?? '-') }}
                    </h4>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $guru->status_aktif_ajar == 1 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                        {{ $guru->status_aktif_ajar == 1 ? 'AKTIF' : 'NON-AKTIF' }}
                    </span>
                </div>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-xs text-slate-500">
                    <span>NPP: <strong class="text-slate-800">{{ $guru->npp }}</strong></span>
                    <span>•</span>
                    <span>Unit Asal: <strong class="text-slate-700">{{ $karyawan->unit->nama_unit ?? '-' }}</strong></span>
                </div>
            </div>
        </div>

        <!-- Grid: Unit Homebase & Jabatan Akademik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Unit Homebase (RDM) -->
            <div class="space-y-1.5">
                <label for="kode_unit_edit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-building text-sm text-slate-400"></i>
                    <span>Unit Homebase (RDM) <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-building text-base"></i>
                    </div>
                    <select name="kode_unit" id="kode_unit_edit" class="w-full pl-9 pr-8 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">-- Pilih Unit --</option>
                        @foreach ($unit as $u)
                            <option value="{{ $u->kode_unit }}" {{ $guru->kode_unit == $u->kode_unit ? 'selected' : '' }}>
                                {{ $u->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Jabatan Akademik -->
            <div class="space-y-1.5">
                <label for="kode_jabatan_edit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-award text-sm text-slate-400"></i>
                    <span>Jabatan Akademik <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-award text-base"></i>
                    </div>
                    <select name="kode_jabatan" id="kode_jabatan_edit" class="w-full pl-9 pr-8 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach ($jabatan as $j)
                            <option value="{{ $j->kode_jabatan }}" {{ $guru->kode_jabatan == $j->kode_jabatan ? 'selected' : '' }}>
                                {{ $j->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Grid: NIP & Status Mengajar -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- NIP / NUPTK / PegID -->
            <div class="space-y-1.5">
                <label for="nomor_kemenag_dinas_edit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-id text-sm text-slate-400"></i>
                    <span>NIP / NUPTK / PegID</span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-id text-base"></i>
                    </div>
                    <input type="text" 
                           name="nomor_kemenag_dinas" 
                           id="nomor_kemenag_dinas_edit" 
                           value="{{ $guru->nomor_kemenag_dinas }}"
                           placeholder="Contoh: 198501012010011001" 
                           class="w-full pl-9 pr-3.5 py-2.5 text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </div>
            </div>

            <!-- Status Mengajar -->
            <div class="space-y-1.5">
                <label for="status_aktif_ajar" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-activity text-sm text-slate-400"></i>
                    <span>Status Mengajar <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-activity text-base"></i>
                    </div>
                    <select name="status_aktif_ajar" id="status_aktif_ajar" class="w-full pl-9 pr-8 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        <option value="1" {{ $guru->status_aktif_ajar == 1 ? 'selected' : '' }}>Aktif Mengajar</option>
                        <option value="0" {{ $guru->status_aktif_ajar == 0 ? 'selected' : '' }}>Tidak Aktif / Cuti</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Upload Tanda Tangan (Scan Digital) -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between">
                <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-file-certificate text-sm text-slate-400"></i>
                    <span>Scan Tanda Tangan Digital (TTD)</span>
                </label>
                @if($guru->file_ttd)
                    <span class="text-[11px] font-bold text-emerald-600 flex items-center gap-1">
                        <i class="ti ti-circle-check"></i> File TTD Tersedia
                    </span>
                @endif
            </div>

            <div class="border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-xl p-3.5 text-center bg-slate-50/50 transition cursor-pointer group" onclick="$('#file_ttd_edit').click()">
                <div class="flex flex-col items-center justify-center">
                    <i class="ti ti-file-certificate text-2xl text-emerald-600 mb-1 group-hover:scale-110 transition-transform"></i>
                    <p class="text-xs font-bold text-slate-700" id="ttd_filename_edit">
                        {{ $guru->file_ttd ? 'Klik untuk mengganti file TTD yang ada' : 'Klik untuk memilih file gambar TTD' }}
                    </p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Format: PNG / JPG / JPEG (Maks. 2MB). Disarankan background transparan.</p>
                </div>
                <input type="file" 
                       name="file_ttd" 
                       id="file_ttd_edit" 
                       class="hidden" 
                       accept="image/png, image/jpeg, image/jpg"
                       onchange="previewEditTTD(this)">
            </div>

            <!-- Existing TTD or Preview -->
            @if($guru->file_ttd)
                <div id="existing_ttd_container" class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between shadow-2xs">
                    <div class="flex items-center gap-2.5">
                        <img src="{{ asset('storage/uploads/ttd_guru/' . $guru->file_ttd) }}" alt="TTD Guru" class="h-10 object-contain border border-slate-200 rounded-lg p-1 bg-white">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">TTD Digital Saat Ini</span>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $guru->file_ttd }}</span>
                        </div>
                    </div>
                    <a href="{{ asset('storage/uploads/ttd_guru/' . $guru->file_ttd) }}" target="_blank" class="px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg text-xs font-bold hover:bg-blue-100 transition shadow-2xs">
                        <i class="ti ti-eye"></i> Lihat Penuh
                    </a>
                </div>
            @endif

            <div id="preview_ttd_container_edit" class="hidden p-2.5 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <img id="preview_ttd_img_edit" src="" alt="Preview TTD Baru" class="h-10 object-contain border border-emerald-200 rounded-lg p-1 bg-white">
                    <div>
                        <span class="text-xs font-bold text-emerald-800 block" id="preview_ttd_name_edit">ttd_baru.png</span>
                        <span class="text-[10px] text-emerald-600 font-medium">File baru akan menggantikan TTD sebelumnya</span>
                    </div>
                </div>
                <button type="button" class="px-2.5 py-1 text-rose-600 hover:bg-rose-50 rounded-lg text-xs font-bold transition flex items-center gap-1" onclick="removeEditTTD()">
                    <i class="ti ti-trash"></i> Batal
                </button>
            </div>
        </div>

        <!-- Actions Footer -->
        <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
            <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
                Batal
            </button>
            <button type="submit" id="btnSubmitEditGuru" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                <i class="ti ti-device-floppy text-base"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </div>
</form>

<script>
    function previewEditTTD(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_ttd_img_edit').attr('src', e.target.result);
                $('#preview_ttd_name_edit').text(file.name);
                $('#preview_ttd_container_edit').removeClass('hidden');
                $('#existing_ttd_container').addClass('hidden');
                $('#ttd_filename_edit').text(file.name);
            }
            reader.readAsDataURL(file);
        }
    }

    function removeEditTTD() {
        $('#file_ttd_edit').val('');
        $('#preview_ttd_container_edit').addClass('hidden');
        $('#existing_ttd_container').removeClass('hidden');
        $('#ttd_filename_edit').text('Klik untuk mengganti file TTD yang ada');
    }

    $(function() {
        const form = $("#formeditGuru");

        // Validation Rules Map
        const validationRules = {
            'kode_unit': { 
                required: true, 
                message: 'Unit Homebase wajib dipilih' 
            },
            'kode_jabatan': { 
                required: true, 
                message: 'Jabatan Akademik wajib dipilih' 
            },
            'status_aktif_ajar': { 
                required: true, 
                message: 'Status Mengajar wajib dipilih' 
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
                    firstInvalid.focus();
                }

                // Shake button feedback
                const submitBtn = $("#btnSubmitEditGuru");
                submitBtn.addClass('animate-shake');
                setTimeout(() => submitBtn.removeClass('animate-shake'), 500);

                return false;
            }

            // Valid -> Loading State
            $("#btnSubmitEditGuru").prop('disabled', true).html(`
                <i class="ti ti-loader animate-spin text-base"></i>
                <span>Memperbarui...</span>
            `);
        });
    });
</script>
