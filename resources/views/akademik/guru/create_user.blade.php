<form action="{{ route('guru.storeUser', Crypt::encrypt($guru->id)) }}" method="POST" id="formManagePasswordGuru" class="space-y-4" novalidate>
    @csrf
    <div class="space-y-4">

        <!-- Info Callout -->
        <div class="p-3.5 bg-gradient-to-r from-emerald-50 to-teal-50/60 border border-emerald-200/90 rounded-xl flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-lg font-bold shadow-2xs shrink-0">
                <i class="ti ti-key"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-xs font-bold text-slate-800">
                    Akses Login Tenaga Pendidik
                </h4>
                <p class="text-[11px] text-slate-500 mt-0.5">
                    Pengaturan akun untuk akses Portal Guru, Presensi Mapel, dan Penilaian Rapor Siswa.
                </p>
            </div>
        </div>

        <!-- Nama Guru (Readonly) -->
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-user text-sm text-slate-400"></i>
                <span>Nama Tenaga Pendidik</span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-user text-base"></i>
                </div>
                <input type="text" class="w-full pl-9 pr-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-bold" value="{{ $guru->nama_lengkap }}" readonly disabled>
            </div>
        </div>

        <!-- Username / NPP (Readonly) -->
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-barcode text-sm text-slate-400"></i>
                <span>Username Login (NPP)</span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-barcode text-base"></i>
                </div>
                <input type="text" class="w-full pl-9 pr-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-mono font-bold" value="{{ $guru->npp }}" readonly disabled>
            </div>
        </div>

        <!-- Password Baru -->
        <div class="space-y-1.5">
            <label for="password_guru" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-lock text-sm text-slate-400"></i>
                <span>Password Login Baru</span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-lock text-base"></i>
                </div>
                <input type="password" 
                       name="password" 
                       id="password_guru" 
                       class="w-full pl-9 pr-10 py-2.5 text-xs bg-white border border-slate-300 rounded-xl text-slate-800 font-medium placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                       placeholder="Kosongkan jika ingin menggunakan password default (NPP)">
                <button type="button" 
                        id="togglePasswordGuru" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition cursor-pointer">
                    <i class="ti ti-eye text-base"></i>
                </button>
            </div>
            <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] text-slate-600 flex items-start gap-2">
                <i class="ti ti-bulb text-amber-500 text-base shrink-0 mt-0.5"></i>
                <span>Jika kolom ini dikosongkan, password akun guru otomatis diset sesuai nomor <strong>NPP ({{ $guru->npp }})</strong>.</span>
            </div>
        </div>

        <!-- Actions Footer -->
        <div class="pt-4 mt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
            <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
                Batal
            </button>
            <button type="submit" id="btnSubmitPasswordGuru" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                <i class="ti ti-device-floppy text-base"></i>
                <span>Simpan Password</span>
            </button>
        </div>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formManagePasswordGuru");

        $("#togglePasswordGuru").click(function(e) {
            e.preventDefault();
            const input = $("#password_guru");
            const icon = $(this).find("i");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
                icon.removeClass("ti-eye").addClass("ti-eye-off");
            } else {
                input.attr("type", "password");
                icon.removeClass("ti-eye-off").addClass("ti-eye");
            }
        });

        function showError(element, message) {
            const $el = $(element);
            const $container = $el.closest('.space-y-1\\.5').length ? $el.closest('.space-y-1\\.5') : $el.parent();
            
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
            const $container = $el.closest('.space-y-1\\.5').length ? $el.closest('.space-y-1\\.5') : $el.parent();
            
            $el.removeClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20')
               .addClass('border-slate-300');
            
            $el.siblings('.pointer-events-none').find('i').removeClass('text-rose-500').addClass('text-slate-400');
            $container.find('.error-msg').remove();
        }

        form.find('#password_guru').on('input blur', function() {
            const val = $(this).val();
            if (val && val.length < 6) {
                showError(this, 'Password minimal 6 karakter');
            } else {
                clearError(this);
            }
        });

        form.on('submit', function(e) {
            const passInput = form.find('#password_guru');
            const val = passInput.val();
            if (val && val.length < 6) {
                e.preventDefault();
                showError(passInput, 'Password minimal 6 karakter');
                passInput.focus();
                return false;
            }

            $("#btnSubmitPasswordGuru").prop('disabled', true).html(`
                <i class="ti ti-loader animate-spin text-base"></i>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>
