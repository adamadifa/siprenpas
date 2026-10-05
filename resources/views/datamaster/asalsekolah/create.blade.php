<form action="{{ route('asalsekolah.store') }}" aria-autocomplete="false" id="formAsalSekolah" method="POST" class="space-y-4" novalidate>
    @csrf

    <!-- Nama Sekolah -->
    <div class="space-y-1">
        <label for="nama_sekolah" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
            <i class="ti ti-building-skyscraper text-sm text-slate-400"></i>
            <span>Nama Sekolah <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-building-skyscraper text-base"></i>
            </div>
            <input type="text" 
                   id="nama_sekolah" 
                   name="nama_sekolah" 
                   placeholder="Contoh: SD Negeri 1 Cirebon..." 
                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
    </div>

    <!-- Status Sekolah -->
    <div class="space-y-1">
        <label for="status_sekolah" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
            <i class="ti ti-tag text-sm text-slate-400"></i>
            <span>Status Sekolah <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-tag text-base"></i>
            </div>
            <select name="status_sekolah" 
                    id="status_sekolah" 
                    class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                <option value="">-- Pilih Status Sekolah --</option>
                <option value="S">Swasta</option>
                <option value="N">Negeri</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                <i class="ti ti-chevron-down text-sm"></i>
            </div>
        </div>
    </div>

    <!-- Kabupaten / Kota -->
    <div class="space-y-1">
        <label for="kota" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
            <i class="ti ti-map-pin text-sm text-slate-400"></i>
            <span>Kabupaten / Kota <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-map-pin text-base"></i>
            </div>
            <input type="text" 
                   id="kota" 
                   name="kota" 
                   placeholder="Contoh: Kab. Cirebon..." 
                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
        </div>
    </div>

    <!-- Submit Button Footer -->
    <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2.5">
        <button type="button" data-bs-dismiss="modal" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-lg transition active:scale-95 cursor-pointer">
            Batal
        </button>
        <button type="submit" id="btnSimpanSekolah" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
            <i class="ti ti-send text-sm"></i>
            <span>Simpan Sekolah</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const formAsalSekolah = $('#formAsalSekolah');

        function showError(element, message) {
            const $el = $(element);
            const $container = $el.closest('.space-y-1');
            
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
            const $container = $el.closest('.space-y-1');
            
            $el.removeClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20')
               .addClass('border-slate-300 focus:ring-emerald-500/20 focus:border-emerald-600');
            
            $el.siblings('.pointer-events-none').find('i').removeClass('text-rose-500').addClass('text-slate-400');
            $container.find('.error-msg').remove();
        }

        formAsalSekolah.on('input change blur', 'input, select', function(e) {
            const $this = $(this);
            const val = ($this.val() || '').toString().trim();
            if (val !== '') {
                clearError(this);
            } else if (e.type === 'blur') {
                const label = $this.closest('.space-y-1').find('label span').text().replace('*', '').trim();
                showError(this, `${label} wajib diisi`);
            }
        });

        function buttonDisable() {
            $("#btnSimpanSekolah").prop("disabled", true);
            $("#btnSimpanSekolah").html(`<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div><span>Menyimpan...</span>`);
        }

        function buttonEnable() {
            $("#btnSimpanSekolah").prop("disabled", false);
            $("#btnSimpanSekolah").html(`<i class="ti ti-send text-sm"></i><span>Simpan Sekolah</span>`);
        }

        function loadasalsekolah() {
            const kode_unit = $("#formPendaftaran").find("#kode_unit").val();
            const kode_sekolah = 0;
            $("#kode_asal_sekolah").load(`/asalsekolah/${kode_unit}/${kode_sekolah}/getasalsekolahbyunit`);
        }

        formAsalSekolah.submit(function(e) {
            e.preventDefault();
            const nama_sekolah = formAsalSekolah.find("#nama_sekolah").val();
            const status_sekolah = formAsalSekolah.find("#status_sekolah").val();
            const kota = formAsalSekolah.find("#kota").val();
            const kode_unit = $("#formPendaftaran").find("#kode_unit").val();

            let isValid = true;
            let firstInvalid = null;

            if (!nama_sekolah || nama_sekolah.trim() === '') {
                showError('#nama_sekolah', 'Nama sekolah wajib diisi');
                isValid = false;
                if (!firstInvalid) firstInvalid = $('#nama_sekolah');
            } else {
                clearError('#nama_sekolah');
            }

            if (!status_sekolah || status_sekolah.trim() === '') {
                showError('#status_sekolah', 'Status sekolah wajib dipilih');
                isValid = false;
                if (!firstInvalid) firstInvalid = $('#status_sekolah');
            } else {
                clearError('#status_sekolah');
            }

            if (!kota || kota.trim() === '') {
                showError('#kota', 'Kabupaten / Kota wajib diisi');
                isValid = false;
                if (!firstInvalid) firstInvalid = $('#kota');
            } else {
                clearError('#kota');
            }

            if (!isValid) {
                if (firstInvalid) firstInvalid.focus();
                return false;
            }

            buttonDisable();
            $.ajax({
                type: "POST",
                url: "{{ route('asalsekolah.store') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    nama_sekolah: nama_sekolah,
                    status_sekolah: status_sekolah,
                    kota: kota,
                    kode_unit: kode_unit
                },
                success: function(respond) {
                    buttonEnable();
                    if (respond.status == true) {
                        formAsalSekolah.trigger("reset");
                        Swal.fire({
                            title: "Berhasil!",
                            text: respond.message,
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false,
                            didClose: () => {
                                loadasalsekolah();
                                $("#modalSekolah").modal("hide");
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: respond.message || 'Gagal menyimpan asal sekolah',
                            icon: "error",
                            showConfirmButton: true
                        });
                    }
                },
                error: function() {
                    buttonEnable();
                    Swal.fire({
                        title: "Error!",
                        text: "Terjadi kesalahan server.",
                        icon: "error",
                        showConfirmButton: true
                    });
                }
            });
        });
    });
</script>
