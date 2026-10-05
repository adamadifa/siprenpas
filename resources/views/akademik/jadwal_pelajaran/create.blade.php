<form action="{{ route('jadwal-pelajaran.store') }}" id="formcreateJadwal" method="POST" class="space-y-4" novalidate>
    @csrf

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Unit Pendidikan -->
        <div class="space-y-1.5">
            <label for="create_kode_unit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-school text-sm text-slate-400"></i>
                <span>Unit Pendidikan <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-building text-base"></i>
                </div>
                <select name="kode_unit" id="create_kode_unit" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    @if(count($units) > 1)
                        <option value="">-- Pilih Unit --</option>
                    @endif
                    @foreach ($units as $unit)
                        <option value="{{ $unit->kode_unit }}" {{ count($units) == 1 ? 'selected' : '' }}>
                            {{ $unit->nama_unit }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Kelas -->
        <div class="space-y-1.5">
            <label for="create_kode_kelas" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-door-enter text-sm text-slate-400"></i>
                <span>Kelas <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-door text-base"></i>
                </div>
                <select name="kode_kelas" id="create_kode_kelas" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->kode_kelas }}">{{ $k->nama_kelas }} ({{ $k->unit->nama_unit ?? '-' }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Semester -->
        <div class="space-y-1.5">
            <label for="create_semester" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-calendar text-sm text-slate-400"></i>
                <span>Semester <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-calendar-time text-base"></i>
                </div>
                <select name="semester" id="create_semester" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Semester --</option>
                    <option value="1">Semester 1 (Ganjil)</option>
                    <option value="2">Semester 2 (Genap)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Mata Pelajaran -->
        <div class="space-y-1.5">
            <label for="create_mata_pelajaran_id" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-book text-sm text-slate-400"></i>
                <span>Mata Pelajaran <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-book-2 text-base"></i>
                </div>
                <select name="mata_pelajaran_id" id="create_mata_pelajaran_id" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach ($mapels as $mapel)
                        <option value="{{ $mapel->id }}" style="{{ is_null($mapel->parent_id) ? 'font-weight: bold;' : 'padding-left: 20px;' }}">
                            {{ is_null($mapel->parent_id) ? '● ' : '↳ ' }}{{ $mapel->nama_matpel }} (Kelompok {{ $mapel->kelompok }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Guru Pengampu -->
        <div class="space-y-1.5">
            <label for="create_guru_id" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-user-check text-sm text-slate-400"></i>
                <span>Guru Pengampu <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-user text-base"></i>
                </div>
                <select name="guru_id" id="create_guru_id" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Guru Pengampu --</option>
                    @foreach ($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <!-- Hari -->
        <div class="space-y-1.5">
            <label for="create_hari" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-calendar-event text-sm text-slate-400"></i>
                <span>Hari <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-calendar text-base"></i>
                </div>
                <select name="hari" id="create_hari" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Hari --</option>
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'] as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Jam Ke -->
        <div class="space-y-1.5">
            <label for="create_jam_ke" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-numbers text-sm text-slate-400"></i>
                <span>Jam Ke- <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-clock-play text-base"></i>
                </div>
                <input type="number" 
                       id="create_jam_ke" 
                       name="jam_ke" 
                       value="1" 
                       min="1" 
                       placeholder="1" 
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-black font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>

        <!-- Jam Mulai -->
        <div class="space-y-1.5">
            <label for="create_jam_mulai" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-clock text-sm text-slate-400"></i>
                <span>Jam Mulai <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-clock-hour-4 text-base"></i>
                </div>
                <input type="text" 
                       id="create_jam_mulai" 
                       name="jam_mulai" 
                       placeholder="07:30" 
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-black font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>

        <!-- Jam Selesai -->
        <div class="space-y-1.5">
            <label for="create_jam_selesai" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-clock text-sm text-slate-400"></i>
                <span>Jam Selesai <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-clock-hour-9 text-base"></i>
                </div>
                <input type="text" 
                       id="create_jam_selesai" 
                       name="jam_selesai" 
                       placeholder="08:30" 
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-black font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>
    </div>

    <!-- Actions Footer -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSubmitJadwal" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Jadwal</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formcreateJadwal");

        // Input mask if available
        if (typeof $.fn.mask === 'function') {
            form.find('#create_jam_mulai, #create_jam_selesai').mask('00:00');
        }

        // Dynamic Loading for Unit -> Kelas, Mapel, Guru
        form.find("#create_kode_unit").on('change', function() {
            const kode_unit = $(this).val();
            if(kode_unit) {
                form.find("#create_kode_kelas").html('<option value="">Memuat...</option>').prop('disabled', true);
                form.find("#create_mata_pelajaran_id").html('<option value="">Memuat...</option>').prop('disabled', true);
                form.find("#create_guru_id").html('<option value="">Memuat...</option>').prop('disabled', true);

                $.ajax({
                    url: "{{ route('jadwal-pelajaran.get-data-by-unit') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_unit: kode_unit
                    },
                    dataType: "json",
                    success: function(data) {
                        if(data.status === 'success') {
                            // Populate Kelas
                            let kelasOptions = '<option value="">-- Pilih Kelas --</option>';
                            $.each(data.kelas, function(k, v) {
                                kelasOptions += `<option value="${v.kode_kelas}">${v.nama_kelas}</option>`;
                            });
                            form.find("#create_kode_kelas").html(kelasOptions).prop('disabled', false);

                            // Populate Mapel
                            let mapelOptions = '<option value="">-- Pilih Mata Pelajaran --</option>';
                            $.each(data.mapel, function(k, v) {
                                const isParent = v.parent_id == null;
                                const prefix = isParent ? '● ' : '↳ ';
                                const style = isParent ? 'font-weight: bold;' : 'padding-left: 20px;';
                                mapelOptions += `<option value="${v.id}" style="${style}">${prefix}${v.nama_matpel} (Kelompok ${v.kelompok})</option>`;
                            });
                            form.find("#create_mata_pelajaran_id").html(mapelOptions).prop('disabled', false);

                            // Populate Guru
                            let guruOptions = '<option value="">-- Pilih Guru Pengampu --</option>';
                            $.each(data.guru, function(k, v) {
                                guruOptions += `<option value="${v.id}">${v.nama_guru}</option>`;
                            });
                            form.find("#create_guru_id").html(guruOptions).prop('disabled', false);
                        }
                    },
                    error: function() {
                        form.find("#create_kode_kelas").html('<option value="">-- Pilih Kelas --</option>').prop('disabled', false);
                        form.find("#create_mata_pelajaran_id").html('<option value="">-- Pilih Mata Pelajaran --</option>').prop('disabled', false);
                        form.find("#create_guru_id").html('<option value="">-- Pilih Guru Pengampu --</option>').prop('disabled', false);
                    }
                });
            }
        });

        // Validation Rules Map
        const validationRules = {
            'kode_unit': { required: true, message: 'Unit Pendidikan wajib dipilih' },
            'kode_kelas': { required: true, message: 'Kelas wajib dipilih' },
            'semester': { required: true, message: 'Semester wajib dipilih' },
            'mata_pelajaran_id': { required: true, message: 'Mata Pelajaran wajib dipilih' },
            'guru_id': { required: true, message: 'Guru Pengampu wajib dipilih' },
            'hari': { required: true, message: 'Hari pembelajaran wajib dipilih' },
            'jam_ke': { required: true, message: 'Jam ke wajib diisi' },
            'jam_mulai': { required: true, message: 'Jam mulai wajib diisi' },
            'jam_selesai': { required: true, message: 'Jam selesai wajib diisi' }
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

        // Realtime trigger
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
            const submitBtn = form.find('#btnSubmitJadwal');
            submitBtn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');
            setTimeout(function() {
                submitBtn.prop('disabled', true);
            }, 50);
        });
    });
</script>
