@php
    $isOrangTua = $user->hasRole('orang tua');
@endphp

<form action="{{ route('users.update', Crypt::encrypt($user->id)) }}" id="formeditUser" method="POST" novalidate class="space-y-4">
    @csrf
    @method('PUT')

    <!-- Callout Info -->
    <div class="flex items-start gap-3 p-3.5 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-emerald-900">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-pencil"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-emerald-950">Edit Informasi Akun Pengguna</p>
            <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                Kosongkan kolom kata sandi jika tidak ingin mengganti password pengguna ini.
            </p>
        </div>
    </div>

    <!-- Nama Lengkap -->
    <div class="space-y-1.5" id="group_edit_name">
        <label for="edit_name" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-user text-slate-400"></i>
            <span>Nama Lengkap <span class="text-rose-500">*</span></span>
        </label>
        <div class="relative">
            <i class="ti ti-id text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base"></i>
            <input type="text" 
                   name="name" 
                   id="edit_name" 
                   value="{{ $user->name }}"
                   placeholder="Contoh: Ahmad Fauzi, S.Pd" 
                   autocomplete="off"
                   class="w-full pl-9 pr-3.5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
        </div>
    </div>

    <!-- Grid: Username & Email -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Username -->
        <div class="space-y-1.5" id="group_edit_username">
            <label for="edit_username" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-at text-slate-400"></i>
                <span>Username <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-user-circle text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base"></i>
                <input type="text" 
                       name="username" 
                       id="edit_username" 
                       value="{{ $user->username }}"
                       placeholder="ahmadfauzi" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
            </div>
        </div>

        <!-- Email -->
        <div class="space-y-1.5" id="group_edit_email">
            <label for="edit_email" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-mail text-slate-400"></i>
                <span>Alamat Email <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <i class="ti ti-mail-opened text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base"></i>
                <input type="email" 
                       name="email" 
                       id="edit_email" 
                       value="{{ $user->email }}"
                       placeholder="ahmad@alamin.sch.id" 
                       autocomplete="off"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
            </div>
        </div>
    </div>

    <!-- Password & Status Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Password (Optional on Edit) -->
        <div class="space-y-1.5" id="group_edit_password">
            <label for="edit_password" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-key text-slate-400"></i>
                <span>Ganti Password (Opsional)</span>
            </label>
            <div class="relative">
                <i class="ti ti-lock text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-base"></i>
                <input type="password" 
                       name="password" 
                       id="edit_password" 
                       placeholder="Biarkan kosong jika tidak diubah" 
                       autocomplete="new-password"
                       class="w-full pl-9 pr-3.5 py-2.5 text-xs font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all placeholder:font-normal placeholder:text-slate-400">
            </div>
        </div>

        <!-- Status -->
        <div class="space-y-1.5" id="group_edit_status">
            <label for="edit_status" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-toggle-right text-slate-400"></i>
                <span>Status Akun <span class="text-rose-500">*</span></span>
            </label>
            <div class="relative">
                <select name="status" 
                        id="edit_status" 
                        class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                    <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Role & Department Details -->
    @if ($isOrangTua)
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-700">Role Pengguna</label>
            <input type="text" class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-500 bg-slate-100 border border-slate-200 rounded-xl" value="Orang Tua" readonly disabled>
            <input type="hidden" name="role" value="orang tua">
        </div>
    @else
        <!-- Role -->
        <div class="space-y-1.5">
            <label for="edit_role" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-shield text-slate-400"></i>
                <span>Role Pengguna <span class="text-rose-500">*</span></span>
            </label>
            <select name="role" id="edit_role" class="w-full py-2.5 px-3.5 text-xs font-bold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                <option value="">-- Pilih Role --</option>
                @foreach ($roles as $r)
                    <option value="{{ $r->name }}" {{ ($user->roles->first()->name ?? '') == $r->name ? 'selected' : '' }}>
                        {{ ucwords($r->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Unit, Departemen, Jabatan Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
            <!-- Unit -->
            <div class="space-y-1.5">
                <label for="edit_kode_unit" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-building text-slate-400"></i>
                    <span>Unit Utama</span>
                </label>
                <select name="kode_unit" id="edit_kode_unit" class="w-full py-2.5 px-3 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                    <option value="">-- Pilih Unit --</option>
                    @foreach ($unit as $u)
                        <option value="{{ $u->kode_unit }}" {{ $user->kode_unit == $u->kode_unit ? 'selected' : '' }}>
                            {{ strtoupper($u->nama_unit) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Departemen -->
            <div class="space-y-1.5">
                <label for="edit_kode_dept" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-briefcase text-slate-400"></i>
                    <span>Departemen</span>
                </label>
                <select name="kode_dept" id="edit_kode_dept" class="w-full py-2.5 px-3 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                    <option value="">-- Pilih Dept --</option>
                    @foreach ($dept as $d)
                        <option value="{{ $d->kode_dept }}" {{ $user->kode_dept == $d->kode_dept ? 'selected' : '' }}>
                            {{ strtoupper($d->nama_dept) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jabatan -->
            <div class="space-y-1.5">
                <label for="edit_kode_jabatan" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i class="ti ti-id-badge-2 text-slate-400"></i>
                    <span>Jabatan</span>
                </label>
                <select name="kode_jabatan" id="edit_kode_jabatan" class="w-full py-2.5 px-3 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none transition-all cursor-pointer">
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach ($jabatan as $j)
                        <option value="{{ $j->kode_jabatan }}" {{ $user->kode_jabatan == $j->kode_jabatan ? 'selected' : '' }}>
                            {{ strtoupper($j->nama_jabatan) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    <!-- Modal Footer Actions -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
        <button type="button" 
                data-bs-dismiss="modal" 
                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
            Batal
        </button>
        <button type="submit" 
                id="btnSubmitEditUser" 
                class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 cursor-pointer">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $('#formeditUser').on('submit', function(e) {
            let name = $('#edit_name').val().trim();
            let username = $('#edit_username').val().trim();
            let email = $('#edit_email').val().trim();

            if (name === "" || username === "" || email === "") {
                e.preventDefault();
                Swal.fire({
                    title: 'Form Belum Lengkap',
                    text: 'Nama, Username, dan Email tidak boleh kosong!',
                    icon: 'warning',
                    confirmButtonColor: '#059669',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-100',
                        confirmButton: 'px-5 py-2 font-bold rounded-xl text-xs'
                    }
                });
                return false;
            }

            const $btn = $('#btnSubmitEditUser');
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

