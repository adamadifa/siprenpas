<form action="{{ route('agenda.update', ['id' => Crypt::encrypt($agenda->id)]) }}" id="formEditAgenda" method="POST" class="space-y-4" novalidate>
    @csrf
    @method('PUT')

    <!-- Nama Agenda -->
    <div class="space-y-1.5">
        <label for="nama_agenda" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-bookmark text-sm text-slate-400"></i>
            <span>Nama Agenda <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-calendar-event text-base"></i>
            </div>
            <input type="text" 
                   name="nama_agenda" 
                   id="nama_agenda" 
                   value="{{ $agenda->nama_agenda }}"
                   placeholder="Contoh: Rapat Pleno Dewan Guru & Pengasuhan"
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                   required>
        </div>
    </div>

    <!-- Tanggal Mulai & Tanggal Selesai -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Tanggal Mulai -->
        <div class="space-y-1.5">
            <label for="tanggal" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-calendar text-sm text-slate-400"></i>
                <span>Tanggal Mulai <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-calendar text-base"></i>
                </div>
                <input type="text" 
                       name="tanggal" 
                       id="tanggal" 
                       value="{{ $agenda->tanggal }}"
                       placeholder="YYYY-MM-DD"
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition flatpickr-date"
                       required>
            </div>
        </div>

        <!-- Tanggal Selesai -->
        <div class="space-y-1.5">
            <label for="tanggal_selesai" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-calendar-due text-sm text-slate-400"></i>
                <span>Tanggal Selesai <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-calendar-due text-base"></i>
                </div>
                <input type="text" 
                       name="tanggal_selesai" 
                       id="tanggal_selesai" 
                       value="{{ $agenda->tanggal_selesai ?? $agenda->tanggal }}"
                       placeholder="YYYY-MM-DD"
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition flatpickr-date">
            </div>
        </div>
    </div>

    <!-- Jam Mulai & Jam Selesai -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Jam Mulai -->
        <div class="space-y-1.5">
            <label for="jam_mulai" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-clock text-sm text-slate-400"></i>
                <span>Jam Mulai <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-clock text-base"></i>
                </div>
                <input type="text" 
                       name="jam_mulai" 
                       id="jam_mulai" 
                       value="{{ $agenda->jam_mulai }}"
                       placeholder="Contoh: 08:00"
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>

        <!-- Jam Selesai -->
        <div class="space-y-1.5">
            <label for="jam_selesai" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-clock-stop text-sm text-slate-400"></i>
                <span>Jam Selesai <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-clock-stop text-base"></i>
                </div>
                <input type="text" 
                       name="jam_selesai" 
                       id="jam_selesai" 
                       value="{{ $agenda->jam_selesai }}"
                       placeholder="Contoh: 11:30"
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>
    </div>

    <!-- Tempat / Lokasi -->
    <div class="space-y-1.5">
        <label for="tempat" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-map-pin text-sm text-slate-400"></i>
            <span>Tempat / Lokasi <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-map-pin text-base"></i>
            </div>
            <input type="text" 
                   name="tempat" 
                   id="tempat" 
                   value="{{ $agenda->tempat }}"
                   placeholder="Contoh: Aula Utama Pesantren Al Amin"
                   class="w-full pl-9 pr-3.5 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
    </div>

    <!-- Keterangan / Catatan -->
    <div class="space-y-1.5">
        <label for="keterangan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-notes text-sm text-slate-400"></i>
            <span>Keterangan & Detail Agenda <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></span>
        </label>
        <div class="relative">
            <textarea name="keterangan" 
                      id="keterangan" 
                      rows="4" 
                      placeholder="Tuliskan catatan tambahan, susunan acara ringkas, atau instruksi agenda..." 
                      class="w-full p-3 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition resize-y">{{ $agenda->keterangan }}</textarea>
        </div>
    </div>

    <!-- Modal Footer Actions -->
    <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-2.5">
        <div>
            @can('agenda.delete')
                <button type="button" id="btnHapus" class="w-full sm:w-auto px-4 py-2.5 bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white font-bold text-xs rounded-xl border border-rose-200 transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
                    <i class="ti ti-trash text-base"></i>
                    <span>Hapus Agenda</span>
                </button>
            @endcan
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:items-center gap-2.5">
            <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
                Batal
            </button>
            <button type="submit" id="btnSimpan" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                <i class="ti ti-device-floppy text-base"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </div>
</form>

@can('agenda.delete')
    <form id="formDeleteAgenda" action="{{ route('agenda.delete', ['id' => Crypt::encrypt($agenda->id)]) }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endcan

<script>
    $(function() {
        const form = $("#formEditAgenda");

        // Init flatpickr for dates
        form.find(".flatpickr-date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true
        });

        @can('agenda.delete')
            $("#btnHapus").click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Agenda ini akan dihapus secara permanen dari jadwal!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#formDeleteAgenda").submit();
                    }
                });
            });
        @endcan

        // Validation Rules Map
        const validationRules = {
            'nama_agenda': {
                required: true,
                message: 'Nama agenda wajib diisi'
            },
            'tanggal': {
                required: true,
                message: 'Tanggal mulai wajib diisi'
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
