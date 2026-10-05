<form action="{{ route('izinabsen.store') }}" method="POST" id="formIzin" class="space-y-4">
    @csrf

    <!-- Auto Kode Izin Alert Info -->
    <div class="p-3 bg-emerald-50/70 border border-emerald-200/80 rounded-xl flex items-center gap-2.5 text-xs text-emerald-800">
        <i class="ti ti-info-circle text-base text-emerald-600 shrink-0"></i>
        <span>Kode Izin akan dibuat secara otomatis oleh sistem saat permohonan disimpan.</span>
    </div>

    <!-- Pilih Karyawan -->
    <div class="space-y-1.5">
        <label class="block text-xs font-bold text-slate-700">
            Nama Karyawan <span class="text-rose-500">*</span>
        </label>
        <div class="relative">
            <select name="npp" id="npp" class="select2Nik w-full">
                <option value="">Pilih Karyawan</option>
                @foreach ($karyawan as $d)
                    <option value="{{ $d->npp }}">{{ $d->npp }} - {{ strtoupper($d->nama_lengkap) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Periode Tanggal -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-slate-700">
                Dari Tanggal <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <i class="ti ti-calendar absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <input type="text" 
                       id="dari" 
                       name="dari" 
                       placeholder="YYYY-MM-DD" 
                       class="flatpickr-date w-full pl-9 pr-3 py-2 text-xs bg-white border border-slate-300 rounded-xl text-slate-800 font-medium placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-slate-700">
                Sampai Tanggal <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <i class="ti ti-calendar absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
                <input type="text" 
                       id="sampai" 
                       name="sampai" 
                       placeholder="YYYY-MM-DD" 
                       class="flatpickr-date w-full pl-9 pr-3 py-2 text-xs bg-white border border-slate-300 rounded-xl text-slate-800 font-medium placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>
    </div>

    <!-- Durasi Hari (Auto) -->
    <div class="space-y-1.5">
        <label class="block text-xs font-bold text-slate-700">
            Jumlah Hari Izin <span class="text-slate-400 font-normal">(Maks. 3 Hari)</span>
        </label>
        <div class="relative">
            <i class="ti ti-sun absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none"></i>
            <input type="text" 
                   id="jml_hari" 
                   name="jml_hari" 
                   readonly 
                   value="0 Hari" 
                   class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-bold">
        </div>
    </div>

    <!-- Alasan / Keterangan -->
    <div class="space-y-1.5">
        <label class="block text-xs font-bold text-slate-700">
            Keterangan / Alasan Izin <span class="text-rose-500">*</span>
        </label>
        <textarea name="keterangan" 
                  id="keterangan" 
                  rows="3" 
                  placeholder="Tuliskan alasan permohonan izin..." 
                  class="w-full px-3 py-2 text-xs bg-white border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"></textarea>
    </div>

    <!-- Submit Button -->
    <div class="pt-2">
        <button type="submit" 
                id="btnSimpan" 
                class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-send text-base"></i>
            <span>Simpan Permohonan Izin</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $('#formIzin');
        
        $(".flatpickr-date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true
        });

        const select2Nik = $('.select2Nik');
        if (select2Nik.length) {
            select2Nik.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Karyawan',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        function hitungHari(startDate, endDate) {
            if (startDate && endDate) {
                var start = new Date(startDate);
                var end = new Date(endDate);
                if (end < start) return 0;
                var timeDifference = end - start + (1000 * 3600 * 24);
                var dayDifference = timeDifference / (1000 * 3600 * 24);
                return Math.round(dayDifference);
            }
            return 0;
        }

        $("#dari, #sampai").on("change", function() {
            const dari = form.find("#dari").val();
            const sampai = form.find("#sampai").val();
            const days = hitungHari(dari, sampai);
            form.find("#jml_hari").val(days > 0 ? `${days} Hari` : '0 Hari');
        });

        function buttonDisabled() {
            $("#btnSimpan").prop('disabled', true).addClass('opacity-75');
            $("#btnSimpan").html(`
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                <span>Menyimpan...</span>
            `);
        }

        form.submit(function(e) {
            const npp = form.find("#npp").val();
            const dari = form.find("#dari").val();
            const sampai = form.find("#sampai").val();
            const keterangan = form.find("#keterangan").val();
            const jmlHari = hitungHari(dari, sampai);

            if (!npp) {
                Swal.fire({
                    title: "Peringatan",
                    text: "Silakan pilih karyawan terlebih dahulu!",
                    icon: "warning",
                    confirmButtonColor: '#064e3b'
                });
                return false;
            } else if (!dari || !sampai) {
                Swal.fire({
                    title: "Peringatan",
                    text: "Periode tanggal izin harus diisi lengkap!",
                    icon: "warning",
                    confirmButtonColor: '#064e3b'
                });
                return false;
            } else if (sampai < dari) {
                Swal.fire({
                    title: "Peringatan",
                    text: "Tanggal akhir tidak boleh lebih awal dari tanggal mulai!",
                    icon: "warning",
                    confirmButtonColor: '#064e3b'
                });
                return false;
            } else if (jmlHari > 3) {
                Swal.fire({
                    title: "Peringatan",
                    text: "Periode izin tidak boleh lebih dari 3 hari kerja berturut-turut!",
                    icon: "warning",
                    confirmButtonColor: '#064e3b'
                });
                return false;
            } else if (!keterangan.trim()) {
                Swal.fire({
                    title: "Peringatan",
                    text: "Keterangan/alasan izin harus diisi!",
                    icon: "warning",
                    confirmButtonColor: '#064e3b'
                });
                return false;
            } else {
                buttonDisabled();
            }
        });
    });
</script>
