<div class="space-y-4">
    <!-- Employee Info Box -->
    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-2xs">
                {{ strtoupper(substr($karyawan->nama_lengkap, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <div class="font-bold text-slate-900 text-sm truncate">{{ $karyawan->nama_lengkap }}</div>
                <div class="text-xs text-slate-500 flex items-center gap-2 mt-0.5">
                    <span class="font-mono font-semibold text-slate-700">NPP: {{ $karyawan->npp }}</span>
                    <span>•</span>
                    <span>{{ DateToIndo($tanggal) }}</span>
                </div>
            </div>
        </div>
        <div class="shrink-0 text-right">
            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                Koreksi Presensi
            </span>
        </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('presensi.update') }}" method="POST" id="formEditPresensi" class="space-y-4">
        @csrf
        <input type="hidden" value="{{ Crypt::encrypt($karyawan->npp) }}" name="npp">
        <input type="hidden" value="{{ $tanggal }}" name="tanggal">

        <!-- Status Kehadiran -->
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Status Kehadiran <span class="text-rose-500">*</span></label>
            <div class="relative">
                <select name="status" id="status" class="w-full px-3.5 py-2.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Status --</option>
                    <option value="h" {{ $presensi != null && $presensi->status == 'h' ? 'selected' : '' }}>Hadir</option>
                    <option value="i" {{ $presensi != null && $presensi->status == 'i' ? 'selected' : '' }}>Izin</option>
                    <option value="s" {{ $presensi != null && $presensi->status == 's' ? 'selected' : '' }}>Sakit</option>
                    <option value="c" {{ $presensi != null && $presensi->status == 'c' ? 'selected' : '' }}>Cuti</option>
                    <option value="a" {{ $presensi != null && $presensi->status == 'a' ? 'selected' : '' }}>Alpha</option>
                </select>
            </div>
        </div>

        <!-- Jam Kerja -->
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Jadwal Jam Kerja <span class="text-rose-500">*</span></label>
            <div class="relative">
                <select name="kode_jam_kerja" id="kode_jam_kerja" class="w-full px-3.5 py-2.5 text-xs font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    <option value="">-- Pilih Jam Kerja --</option>
                    @foreach ($jam_kerja as $d)
                        <option value="{{ $d->kode_jam_kerja }}"
                            {{ $presensi != null && $presensi->kode_jam_kerja == $d->kode_jam_kerja ? 'selected' : '' }}>
                            {{ $d->kode_jam_kerja }} - {{ $d->nama_jam_kerja }} ({{ substr($d->jam_masuk, 0, 5) }} - {{ substr($d->jam_pulang, 0, 5) }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Jam Masuk & Jam Pulang -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Jam Masuk (IN)</label>
                <div class="relative">
                    <i class="ti ti-clock text-slate-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input type="text" 
                           name="jam_in" 
                           id="jam_in" 
                           value="{{ $presensi != null ? $presensi->jam_in : '' }}" 
                           class="w-full pl-9 pr-3.5 py-2 text-xs font-bold font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                           placeholder="YYYY-MM-DD HH:mm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Jam Pulang (OUT)</label>
                <div class="relative">
                    <i class="ti ti-clock text-slate-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input type="text" 
                           name="jam_out" 
                           id="jam_out" 
                           value="{{ $presensi != null ? $presensi->jam_out : '' }}" 
                           class="w-full pl-9 pr-3.5 py-2 text-xs font-bold font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" 
                           placeholder="YYYY-MM-DD HH:mm">
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
            <button type="button" 
                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" 
                    data-bs-dismiss="modal">
                Batal
            </button>
            <button type="submit" 
                    id="btnSimpan" 
                    class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
                <i class="ti ti-device-floppy text-base"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>

<script>
    $(function() {
        $("#jam_in,#jam_out").mask("0000-00-00 00:00");
        $("#jam_in,#jam_out").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            allowInput: true,
        });

        function toggleInputs() {
            let val = $("#status").val();
            if (val !== 'h') {
                $("#jam_in,#jam_out").prop('disabled', true).addClass('bg-slate-100 cursor-not-allowed');
            } else {
                $("#jam_in,#jam_out").prop('disabled', false).removeClass('bg-slate-100 cursor-not-allowed');
            }
        }

        toggleInputs();
        $("#status").on('change', toggleInputs);

        $("#formEditPresensi").on('submit', function(e) {
            let status = $(this).find("#status").val();
            let kode_jam_kerja = $(this).find("#kode_jam_kerja").val();
            if (status === "") {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Status Belum Dipilih',
                    text: 'Silakan pilih status kehadiran karyawan!',
                    confirmButtonColor: '#064e3b'
                });
                return false;
            } else if (kode_jam_kerja === "") {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Jam Kerja Belum Dipilih',
                    text: 'Silakan pilih jadwal jam kerja karyawan!',
                    confirmButtonColor: '#064e3b'
                });
                return false;
            }

            $("#btnSimpan").prop('disabled', true).html(`
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>
