<form action="" id="formBuatrencanaspp" class="space-y-4">
    @csrf
    <input type="hidden" name="no_pendaftaran" value="{{ $no_pendaftaran }}" id="no_pendaftaran">
    
    <!-- Tahun Ajaran -->
    <div class="space-y-1.5">
        <label for="kode_biaya" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-calendar-event text-sm text-slate-400"></i>
            <span>Tahun Ajaran <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-calendar-event text-base"></i>
            </div>
            <select name="kode_biaya" id="kode_biaya" 
                    class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer" required>
                <option value="">-- Pilih Tahun Ajaran --</option>
                @foreach ($biayaSiswa as $d)
                    <option value="{{ $d->kode_biaya }}">{{ $d->tahun_ajaran }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Total SPP -->
    <div class="space-y-1.5">
        <label for="jumlah_spp" class="block text-xs font-bold text-slate-500 flex items-center gap-1.5">
            <i class="ti ti-moneybag text-sm text-slate-400"></i>
            <span>Jumlah SPP Total (Rp)</span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-xs font-bold text-slate-400">
                Rp
            </div>
            <input type="text" 
                   id="jumlah_spp" 
                   name="jumlah_spp" 
                   readonly 
                   placeholder="0" 
                   class="money w-full pl-9 pr-3.5 py-2.5 text-sm font-mono font-bold text-right text-slate-600 bg-slate-100/90 border border-slate-200 rounded-xl shadow-2xs cursor-not-allowed select-none">
        </div>
    </div>

    <!-- Mulai Pembayaran Bulan -->
    <div class="space-y-1.5">
        <label for="mulai_pembayaran" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-calendar text-sm text-slate-400"></i>
            <span>Mulai Pembayaran Bulan <span class="text-rose-500 font-bold">*</span></span>
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="ti ti-calendar text-base"></i>
            </div>
            <select name="mulai_pembayaran" id="mulai_pembayaran" 
                    class="w-full pl-9 pr-8 py-2.5 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer" required>
                <option value="">-- Pilih Bulan Mulai --</option>
                @foreach ($list_bulan as $d)
                    <option value="{{ $d['kode_bulan'] }}" {{ $d['kode_bulan'] == 7 ? 'selected' : '' }}>{{ $d['nama_bulan'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Grid Jumlah Bulan & SPP Per Bulan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
        <!-- Jumlah Bulan -->
        <div class="space-y-1.5">
            <label for="jumlah_bulan" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-clock-hour-4 text-sm text-slate-400"></i>
                <span>Jumlah Bulan</span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-clock-hour-4 text-base"></i>
                </div>
                <input type="number" 
                       id="jumlah_bulan" 
                       name="jumlah_bulan" 
                       value="12" 
                       min="1" 
                       max="12" 
                       class="w-full pl-9 pr-3.5 py-2.5 text-sm font-mono font-bold text-right text-slate-800 bg-white border border-slate-300 rounded-xl placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>

        <!-- SPP Per Bulan -->
        <div class="space-y-1.5">
            <label for="jumlah_spp_perbulan" class="block text-xs font-bold text-slate-500 flex items-center gap-1.5">
                <i class="ti ti-cash text-sm text-slate-400"></i>
                <span>SPP / Bulan (Rp)</span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-xs font-bold text-emerald-600">
                    Rp
                </div>
                <input type="text" 
                       id="jumlah_spp_perbulan" 
                       name="jumlah_spp_perbulan" 
                       readonly 
                       placeholder="0" 
                       class="money w-full pl-9 pr-3.5 py-2.5 text-sm font-mono font-black text-right text-emerald-700 bg-slate-100/90 border border-slate-200 rounded-xl shadow-2xs cursor-not-allowed select-none">
            </div>
        </div>
    </div>

    <!-- Footer Actions -->
    <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-progress text-base"></i>
            <span>Generate Rencana SPP</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $("#jumlah_spp_perbulan").maskMoney({
            thousands: '.',
            decimal: ',',
            precision: 0
        });
        const formRencanaspp = $("#formBuatrencanaspp");

        function hitungsppperbulan() {
            let jumlah_spp = toNumber(formRencanaspp.find("#jumlah_spp").val());
            let jumlah_bulan = toNumber(formRencanaspp.find("#jumlah_bulan").val());
            if (jumlah_bulan > 0) {
                let jumlah_spp_perbulan = parseInt(jumlah_spp) / parseInt(jumlah_bulan);
                formRencanaspp.find("#jumlah_spp_perbulan").val(convertToRupiah(Math.round(jumlah_spp_perbulan)));
            }
        }

        formRencanaspp.find("#jumlah_bulan").on('input keyup change', function() {
            hitungsppperbulan();
        });

        function getSPP() {
            let kode_biaya = formRencanaspp.find("#kode_biaya").val();
            let no_pendaftaran = formRencanaspp.find("#no_pendaftaran").val();
            if (!kode_biaya) {
                formRencanaspp.find("#jumlah_spp").val('');
                formRencanaspp.find("#jumlah_spp_perbulan").val('');
                return;
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('rencanaspp.getspp') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_biaya: kode_biaya,
                    no_pendaftaran: no_pendaftaran
                },
                success: function(response) {
                    if (response.status) {
                        formRencanaspp.find("#jumlah_spp").val(convertToRupiah(response.jumlah_spp));
                        hitungsppperbulan();
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: response.message,
                            didClose: () => {
                                formRencanaspp.find("#kode_biaya").val('');
                                formRencanaspp.find("#kode_biaya").focus();
                            },
                        });
                    }
                }
            });
        }

        formRencanaspp.find("#kode_biaya").change(function() {
            getSPP();
        });

        function toNumber(value) {
            if (!value) return 0;
            let cleanValue = value.toString().replace(/\./g, '');
            return parseInt(cleanValue) || 0;
        }

        function convertToRupiah(number) {
            if (number) {
                var rupiah = "";
                var numberrev = number
                    .toString()
                    .split("")
                    .reverse()
                    .join("");
                for (var i = 0; i < numberrev.length; i++)
                    if (i % 3 == 0) rupiah += numberrev.substr(i, 3) + ".";
                return (
                    rupiah
                    .split("", rupiah.length - 1)
                    .reverse()
                    .join("")
                );
            } else {
                return "0";
            }
        }
    });
</script>
