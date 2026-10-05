<form action="{{ route('mata-pelajaran.update', Crypt::encrypt($matapelajaran->id)) }}" id="formeditMatpel" method="POST" class="space-y-4" novalidate>
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Unit Pendidikan -->
        <div class="space-y-1.5">
            <label for="kode_unit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-school text-sm text-slate-400"></i>
                <span>Unit Pendidikan <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-building text-base"></i>
                </div>
                <select name="kode_unit" id="kode_unit" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Unit Pendidikan --</option>
                    @foreach ($units as $u)
                        <option value="{{ $u->kode_unit }}" {{ $matapelajaran->kode_unit == $u->kode_unit ? 'selected' : '' }}>
                            {{ $u->nama_unit }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Kode Mapel (Readonly) -->
        <div class="space-y-1.5">
            <label for="kode_matpel" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-barcode text-sm text-slate-400"></i>
                <span>Kode Mata Pelajaran</span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-lock text-base"></i>
                </div>
                <input type="text" 
                       id="kode_matpel" 
                       name="kode_matpel" 
                       value="{{ $matapelajaran->kode_matpel }}" 
                       readonly 
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-bold font-mono uppercase text-slate-500 bg-slate-100/90 border border-slate-300 rounded-xl cursor-not-allowed shadow-2xs">
            </div>
            <p class="text-[11px] text-slate-400 font-medium">Kode mata pelajaran unik sebagai identitas relasi nilai & guru pengampu.</p>
        </div>
    </div>

    <!-- Nama Mata Pelajaran -->
    <div class="space-y-1.5">
        <label for="nama_matpel" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-book text-sm text-slate-400"></i>
            <span>Nama Mata Pelajaran <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-book text-base"></i>
            </div>
            <input type="text" 
                   id="nama_matpel" 
                   name="nama_matpel" 
                   value="{{ $matapelajaran->nama_matpel }}"
                   placeholder="Contoh: Matematika / Bahasa Arab / Fiqih..." 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Kelompok Mapel -->
        <div class="space-y-1.5">
            <label for="kelompok" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-layout-grid text-sm text-slate-400"></i>
                <span>Kelompok Kurikulum <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-category text-base"></i>
                </div>
                <select name="kelompok" id="kelompok" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Kelompok --</option>
                    <option value="A" {{ $matapelajaran->kelompok == 'A' ? 'selected' : '' }}>Kelompok A (Wajib Nasional / Umum)</option>
                    <option value="B" {{ $matapelajaran->kelompok == 'B' ? 'selected' : '' }}>Kelompok B (Muatan Lokal / Khas)</option>
                    <option value="C" {{ $matapelajaran->kelompok == 'C' ? 'selected' : '' }}>Kelompok C (Peminatan / Kepesantrenan)</option>
                </select>
            </div>
        </div>

        <!-- Urutan -->
        <div class="space-y-1.5">
            <label for="urutan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-sort-ascending-numbers text-sm text-slate-400"></i>
                <span>Urutan Tampilan di Rapor <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-numbers text-base"></i>
                </div>
                <input type="number" 
                       id="urutan" 
                       name="urutan" 
                       value="{{ $matapelajaran->urutan }}" 
                       min="1"
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-black font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
            <p class="text-[11px] text-slate-400 font-medium">Menentukan urutan baris mata pelajaran saat cetak rapor & transkrip nilai.</p>
        </div>
    </div>

    <!-- Parent (Mapel Induk) -->
    <div class="space-y-1.5">
        <label for="parent_id" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-hierarchy text-sm text-slate-400"></i>
            <span>Mata Pelajaran Induk (Parent)</span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-corner-down-right text-base"></i>
            </div>
            <select name="parent_id" id="parent_id" class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                <option value="">-- Tidak Ada (Jadikan Sebagai Mapel Utama) --</option>
                @foreach ($parents as $p)
                    <option value="{{ $p->id }}" {{ $matapelajaran->parent_id == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_matpel }} (Kelompok {{ $p->kelompok }} - {{ $p->unit->nama_unit ?? 'Semua Unit' }})
                    </option>
                @endforeach
            </select>
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Pilih jika mapel ini merupakan sub-materi dari mapel utama (misal: Sub Pendidikan Agama Islam -> Fiqih, Al-Qur'an Hadits).</p>
    </div>

    <!-- Status Aktif Switch -->
    <div class="p-3 bg-slate-50 border border-slate-200/90 rounded-xl flex items-center justify-between gap-3">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center text-base">
                <i class="ti ti-toggle-right"></i>
            </div>
            <div>
                <h5 class="text-xs font-bold text-slate-800">Status Keaktifan Mapel</h5>
                <p class="text-[11px] text-slate-400">Mapel aktif akan muncul pada jadwal pelajaran, presensi kelas, dan penilaian rapor</p>
            </div>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="aktif" value="1" class="sr-only peer" {{ $matapelajaran->aktif ? 'checked' : '' }}>
            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-hidden rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
        </label>
    </div>

    <!-- Actions Footer -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnUpdateMatpel" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formeditMatpel");

        // Validation Rules Map
        const validationRules = {
            'kode_unit': { 
                required: true, 
                message: 'Unit Pendidikan wajib dipilih' 
            },
            'nama_matpel': { 
                required: true, 
                message: 'Nama Mata Pelajaran wajib diisi' 
            },
            'kelompok': { 
                required: true, 
                message: 'Kelompok Kurikulum wajib dipilih' 
            },
            'urutan': { 
                required: true, 
                message: 'Urutan wajib diisi' 
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
            const submitBtn = form.find('#btnUpdateMatpel');
            submitBtn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');
            setTimeout(function() {
                submitBtn.prop('disabled', true);
            }, 50);
        });
    });
</script>
