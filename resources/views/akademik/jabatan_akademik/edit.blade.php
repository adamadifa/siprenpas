<form action="{{ route('jabatan-akademik.update', Crypt::encrypt($jabatan_akademik->kode_jabatan)) }}" id="formeditJabatanAkademik" method="POST" class="space-y-4" novalidate>
    @csrf
    @method('PUT')

    <!-- Kode Jabatan (Readonly) -->
    <div class="space-y-1.5">
        <label for="kode_jabatan_edit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-barcode text-sm text-slate-400"></i>
            <span>Kode Jabatan Akademik</span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-barcode text-base"></i>
            </div>
            <input type="text" 
                   id="kode_jabatan_edit" 
                   value="{{ $jabatan_akademik->kode_jabatan }}" 
                   readonly
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-black uppercase font-mono tracking-wider text-slate-600 bg-slate-100 border border-slate-300 rounded-xl shadow-2xs cursor-not-allowed">
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Kode jabatan bersifat permanen dan tidak dapat diubah.</p>
    </div>

    <!-- Nama Jabatan -->
    <div class="space-y-1.5">
        <label for="nama_jabatan_edit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-award text-sm text-slate-400"></i>
            <span>Nama Lengkap Jabatan <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-award text-base"></i>
            </div>
            <input type="text" 
                   id="nama_jabatan_edit" 
                   name="nama_jabatan" 
                   value="{{ $jabatan_akademik->nama_jabatan }}"
                   placeholder="Contoh: Kepala Sekolah / Wakasek Kurikulum / Wali Kelas..." 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
    </div>

    <!-- Urutan Hirarki -->
    <div class="space-y-1.5">
        <label for="urutan_edit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-list-numbers text-sm text-slate-400"></i>
            <span>Nomor Urutan Susunan <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-list-numbers text-base"></i>
            </div>
            <input type="number" 
                   id="urutan_edit" 
                   name="urutan" 
                   min="1"
                   value="{{ $jabatan_akademik->urutan }}"
                   placeholder="Contoh: 1, 2, 3..." 
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
        <p class="text-[11px] text-slate-400 font-medium">Urutan digunakan untuk tata letak susunan jabatan dan urutan tanda tangan.</p>
    </div>

    <!-- Tampil di Raport (Checkbox) -->
    <div class="pt-2">
        <label class="relative flex items-start gap-3 p-3 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/30 transition cursor-pointer group">
            <div class="flex items-center h-5 mt-0.5">
                <input type="checkbox" 
                       id="tampil_di_raport_edit" 
                       name="tampil_di_raport" 
                       value="1" 
                       {{ $jabatan_akademik->tampil_di_raport == 1 ? 'checked' : '' }}
                       class="w-4 h-4 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500 focus:ring-2 cursor-pointer">
            </div>
            <div class="text-xs">
                <span class="font-bold text-slate-800 group-hover:text-emerald-800 transition">Tampil di Dokumen Raport (Tanda Tangan)</span>
                <p class="text-slate-500 text-[11px] mt-0.5">Centang jika jabatan ini memiliki kolom tanda tangan resmi pada cetak lembar raport santri.</p>
            </div>
        </label>
    </div>

    <!-- Actions Footer -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSubmitEditJabatanAkademik" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Perbarui Jabatan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formeditJabatanAkademik");

        // Validation Rules Map
        const validationRules = {
            'nama_jabatan': { 
                required: true, 
                message: 'Nama Jabatan wajib diisi' 
            },
            'urutan': {
                required: true,
                message: 'Nomor Urutan wajib diisi'
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
        form.on('input change blur', 'input', function(e) {
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
            const submitBtn = form.find('#btnSubmitEditJabatanAkademik');
            submitBtn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');
            setTimeout(function() {
                submitBtn.prop('disabled', true);
            }, 50);
        });
    });
</script>
