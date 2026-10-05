<form action="{{ route('tabungan.store', ['no_rekening' => Crypt::encrypt($no_rekening), 'jenis_transaksi' => $jenis_transaksi]) }}" 
      id="formTabunganTransaksi" 
      method="POST" 
      class="space-y-4 sm:space-y-5" 
      novalidate>
    @csrf

    <!-- Transaction Badge / Type Notice -->
    <div class="p-3.5 sm:p-4 {{ $jenis_transaksi == 'S' ? 'bg-emerald-50/90 border-emerald-200 text-emerald-900' : 'bg-rose-50/90 border-rose-200 text-rose-900' }} border rounded-xl flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg {{ $jenis_transaksi == 'S' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} flex items-center justify-center text-base font-bold shadow-2xs shrink-0">
                <i class="ti {{ $jenis_transaksi == 'S' ? 'ti-download' : 'ti-upload' }}"></i>
            </div>
            <div>
                <div class="text-xs sm:text-sm font-bold">{{ $jenis_transaksi == 'S' ? 'Pencatatan Setoran Tabungan' : 'Pencatatan Penarikan Tabungan' }}</div>
                <div class="text-[11px] opacity-75">No. Rekening: <span class="font-mono font-bold">{{ $no_rekening }}</span></div>
            </div>
        </div>
        <span class="px-2.5 py-1 rounded-lg text-[11px] font-black uppercase tracking-wider {{ $jenis_transaksi == 'S' ? 'bg-emerald-600 text-white' : 'bg-rose-600 text-white' }} shadow-2xs">
            {{ $jenis_transaksi == 'S' ? 'Setoran (+)' : 'Penarikan (-)' }}
        </span>
    </div>

    <!-- Form Section Block -->
    <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-4">
        
        <!-- Tanggal Transaksi -->
        <div class="space-y-1.5">
            <label for="tanggal_transaksi" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-calendar text-sm text-slate-400"></i>
                <span>Tanggal Transaksi <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <i class="ti ti-calendar-event text-base"></i>
                </div>
                <input type="text" 
                       id="tanggal_transaksi" 
                       name="tanggal" 
                       value="{{ date('Y-m-d') }}"
                       class="flatpickr-date w-full pl-10 pr-3.5 py-2.5 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                       placeholder="Pilih Tanggal Transaksi" 
                       required>
            </div>
        </div>

        <!-- Nominal Jumlah (Rp) -->
        <div class="space-y-1.5">
            <label for="jumlah" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-cash text-sm text-slate-400"></i>
                <span>Nominal Jumlah (Rp) <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-emerald-700 font-bold text-xs sm:text-sm">
                    Rp
                </div>
                <input type="text" 
                       id="jumlah" 
                       name="jumlah" 
                       class="money w-full pl-10 pr-3.5 py-2.5 text-xs sm:text-sm font-bold font-mono text-slate-900 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition text-right" 
                       placeholder="0" 
                       required>
            </div>
        </div>

        <!-- Keterangan / Berita Transaksi -->
        <div class="space-y-1.5">
            <label for="berita" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-note text-sm text-slate-400"></i>
                <span>Berita / Keterangan Transaksi <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <textarea id="berita" 
                      name="berita" 
                      rows="3" 
                      class="w-full px-3.5 py-2.5 text-xs sm:text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                      placeholder="Contoh: Setoran Tabungan Santri / Karyawan" 
                      required>{{ $jenis_transaksi == 'S' ? 'Setoran Tabungan' : 'Penarikan Tabungan' }}</textarea>
        </div>

    </div>

    <!-- Actions Footer -->
    <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" 
                class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-lg transition cursor-pointer active:scale-95" 
                data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" 
                id="btnSimpan" 
                class="w-full sm:w-auto px-6 py-2.5 {{ $jenis_transaksi == 'S' ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-rose-600 hover:bg-rose-700' }} text-white font-bold text-xs rounded-lg shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>{{ $jenis_transaksi == 'S' ? 'Simpan Setoran' : 'Simpan Penarikan' }}</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $('#formTabunganTransaksi');

        $(".flatpickr-date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true
        });

        $("#jumlah").maskMoney({
            thousands: '.',
            decimal: ',',
            precision: 0
        });

        // Validation Rules Map
        const validationRules = {
            'tanggal': {
                required: true,
                message: 'Tanggal transaksi wajib diisi'
            },
            'jumlah': {
                required: true,
                message: 'Nominal jumlah wajib diisi dan harus lebih besar dari Rp 0',
                custom: function(val) {
                    if (!val) return false;
                    const num = parseInt(val.toString().replace(/\./g, '')) || 0;
                    return num > 0;
                }
            },
            'berita': {
                required: true,
                message: 'Berita atau keterangan transaksi wajib diisi',
                minLength: 3,
                lengthMessage: 'Berita / keterangan minimal 3 karakter'
            }
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

            if (rule.custom && typeof rule.custom === 'function') {
                if (!rule.custom(val)) {
                    showError($el, rule.message);
                    return false;
                }
            }

            if (rule.minLength && val.length < rule.minLength) {
                showError($el, rule.lengthMessage || `Minimal ${rule.minLength} karakter`);
                return false;
            }

            clearError($el);
            return true;
        }

        // Realtime validation triggers
        form.on('input change blur', 'input, textarea', function(e) {
            const $this = $(this);
            const hasError = $this.hasClass('border-rose-500');
            const val = ($this.val() || '').toString().trim();
            
            if (e.type === 'blur' || val !== '' || hasError) {
                validateSingleField(this);
            }
        });

        // Form Submit
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

            const submitBtn = form.find('#btnSimpan');
            submitBtn.prop("disabled", true).html(`
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>
