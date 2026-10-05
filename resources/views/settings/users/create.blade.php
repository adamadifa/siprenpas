<form action="{{ route('users.store') }}" id="formcreateUser" method="POST" novalidate class="space-y-4">
    @csrf

    <!-- Callout Info -->
    <div class="flex items-start gap-3 p-3.5 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-user-plus"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-emerald-950">Tambah Akun Pengguna Baru</p>
            <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                Lengkapi informasi autentikasi dan pilih hak akses role serta unit departemen yang sesuai.
            </p>
        </div>
    </div>

    <!-- Nama Lengkap -->
    <div class="space-y-1.5" id="group_name">
        <label for="name" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-user text-slate-400"></i>
            <span>Nama Lengkap <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <i class="ti ti-id text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base"></i>
            <input type="text" 
                   name="name" 
                   id="name" 
                   placeholder="Contoh: Ahmad Fauzi, S.Pd" 
                   autocomplete="off"
                   class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
        </div>
    </div>

    <!-- Grid: Username & Email -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Username -->
        <div class="space-y-1.5" id="group_username">
            <label for="username" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-at text-slate-400"></i>
                <span>Username <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-user-circle text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base"></i>
                <input type="text" 
                       name="username" 
                       id="username" 
                       placeholder="ahmadfauzi" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
            </div>
        </div>

        <!-- Email -->
        <div class="space-y-1.5" id="group_email">
            <label for="email" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-mail text-slate-400"></i>
                <span>Alamat Email <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-mail-opened text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base"></i>
                <input type="email" 
                       name="email" 
                       id="email" 
                       placeholder="ahmad@alamin.sch.id" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
            </div>
        </div>
    </div>

    <!-- Password & Role Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Password -->
        <div class="space-y-1.5" id="group_password">
            <label for="password" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-key text-slate-400"></i>
                <span>Password <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-lock text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base"></i>
                <input type="password" 
                       name="password" 
                       id="password" 
                       placeholder="Minimal 6 karakter" 
                       autocomplete="new-password"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
            </div>
        </div>

        <!-- Role -->
        <div class="space-y-1.5" id="group_role">
            <label for="role" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-shield text-slate-400"></i>
                <span>Role Pengguna <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <select name="role" 
                        id="role" 
                        class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                    <option value="">-- Pilih Role --</option>
                    @foreach ($roles as $r)
                        <option value="{{ $r->name }}">{{ ucwords($r->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Unit, Departemen, Jabatan Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
        <!-- Unit -->
        <div class="space-y-1.5">
            <label for="kode_unit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-building text-slate-400"></i>
                <span>Unit Utama</span>
            </label>
            <select name="kode_unit" id="kode_unit" class="w-full py-2.5 px-3 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                <option value="">-- Pilih Unit --</option>
                @foreach ($unit as $u)
                    <option value="{{ $u->kode_unit }}">{{ strtoupper($u->nama_unit) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Departemen -->
        <div class="space-y-1.5">
            <label for="kode_dept" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-briefcase text-slate-400"></i>
                <span>Departemen</span>
            </label>
            <select name="kode_dept" id="kode_dept" class="w-full py-2.5 px-3 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                <option value="">-- Pilih Dept --</option>
                @foreach ($dept as $d)
                    <option value="{{ $d->kode_dept }}">{{ strtoupper($d->nama_dept) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Jabatan -->
        <div class="space-y-1.5">
            <label for="kode_jabatan" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-id-badge-2 text-slate-400"></i>
                <span>Jabatan</span>
            </label>
            <select name="kode_jabatan" id="kode_jabatan" class="w-full py-2.5 px-3 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                <option value="">-- Pilih Jabatan --</option>
                @foreach ($jabatan as $j)
                    <option value="{{ $j->kode_jabatan }}">{{ strtoupper($j->nama_jabatan) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Modal Footer Actions -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
        <button type="button" 
                data-bs-dismiss="modal" 
                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
            Batal
        </button>
        <button type="submit" 
                id="btnSubmitCreateUser" 
                class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Pengguna</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $('#formcreateUser').on('submit', function(e) {
            let name = $('#name').val().trim();
            let username = $('#username').val().trim();
            let email = $('#email').val().trim();
            let password = $('#password').val().trim();
            let role = $('#role').val().trim();

            if (name === "" || username === "" || email === "" || password === "" || role === "") {
                e.preventDefault();
                Swal.fire({
                    title: 'Form Belum Lengkap',
                    text: 'Harap isi Nama, Username, Email, Password, dan Role pengguna!',
                    icon: 'warning',
                    confirmButtonColor: '#059669',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-100',
                        confirmButton: 'px-5 py-2 font-bold rounded-xl text-xs'
                    }
                });
                return false;
            }

            const $btn = $('#btnSubmitCreateUser');
            $btn.prop('disabled', true).addClass('opacity-75 cursor-not-allowed');
            $btn.html(`
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>

