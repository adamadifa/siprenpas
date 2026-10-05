<form action="{{ route('permissiongroups.update', $permission_groups->id) }}" id="formeditGroup" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <!-- Info Note -->
    <div class="flex items-start gap-2.5 p-3 bg-emerald-50 border border-emerald-200/80 rounded-xl text-emerald-900 text-xs">
        <i class="ti ti-info-circle text-emerald-600 text-base shrink-0 mt-0.5"></i>
        <span>Perubahan nama group akan memperbarui kelompok modul permission di seluruh menu pengaturan hak akses.</span>
    </div>

    <!-- Group Name Field -->
    <div>
        <label for="edit_group_name" class="block text-xs font-bold text-slate-700 mb-1.5">
            Nama Group Modul <span class="text-rose-500">*</span>
        </label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                <i class="ti ti-folder text-base"></i>
            </span>
            <input type="text" id="edit_group_name" name="name" value="{{ $permission_groups->name }}" required autofocus
                class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50/70 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"
                placeholder="Contoh: Karyawan, Pembayaran, Jabatan...">
        </div>
    </div>

    <!-- Submit Button -->
    <div class="pt-2">
        <button type="submit" id="btnUpdateGroup" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition active:scale-95 flex items-center justify-center gap-2 cursor-pointer border-0">
            <i class="ti ti-repeat text-base"></i>
            <span>Update Group</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $("#formeditGroup").submit(function(e) {
            let name = $("#edit_group_name").val().trim();
            if (!name) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Nama group modul wajib diisi!',
                    confirmButtonColor: '#064e3b'
                });
                return false;
            }
            $("#btnUpdateGroup").prop("disabled", true).html('<i class="ti ti-loader animate-spin text-base"></i> Memperbarui...');
        });
    });
</script>

