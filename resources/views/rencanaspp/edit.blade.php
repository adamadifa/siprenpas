<form action="#" method="POST" id="formEditrencanaspp" class="space-y-4">
    @csrf
    <input type="hidden" name="kode_rencana_spp" value="{{ $rencana_spp->kode_rencana_spp }}">

    <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-xs">
        <div class="px-4 py-3 bg-emerald-600 flex items-center justify-between text-white">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-md bg-white/20 text-white flex items-center justify-center text-xs font-bold">
                    <i class="ti ti-calendar-stats"></i>
                </div>
                <h6 class="text-xs font-extrabold text-white tracking-tight m-0 uppercase">Penyesuaian Jadwal Tagihan SPP</h6>
            </div>
            <div class="text-xs font-bold text-emerald-100">
                Target: <span id="tagihanspppertahun" class="text-white font-mono font-black">{{ formatAngka($biaya->jumlah - $biaya->jumlah_potongan - $biaya->jumlah_mutasi) }}</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-100/90 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-200">
                    <tr>
                        <th class="py-2.5 px-3.5">Bulan / Tahun</th>
                        <th class="py-2.5 px-3.5 text-end w-48">Nominal Tagihan (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach ($detailrencanaspp as $d)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-2.5 px-3.5 font-bold text-slate-800">
                                {{ $listbulan[$d->bulan] }} {{ $d->tahun }}
                                <input type="hidden" name="bulan[]" value="{{ $d->bulan }}">
                                <input type="hidden" name="tahun[]" value="{{ $d->tahun }}">
                            </td>
                            <td class="py-2 px-3 text-end">
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-xs font-bold text-slate-400">
                                        Rp
                                    </div>
                                    <input type="text" 
                                           name="jumlah[]" 
                                           value="{{ formatAngka($d->jumlah) }}" 
                                           class="money jmlsppperbulan w-full pl-8 pr-3 py-1.5 text-xs font-mono font-bold text-right text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-50 border-t-2 border-slate-200 font-bold">
                    <tr>
                        <td class="py-3 px-3.5 text-end uppercase tracking-wider text-slate-600 font-black">TOTAL RENCANA SPP</td>
                        <td class="py-3 px-3.5 text-end font-mono font-black text-emerald-700 text-sm" id="totalspppertahun">Rp 0</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Footer Actions -->
    <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSimpan" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $(".money").maskMoney({
            thousands: '.',
            decimal: ',',
            precision: 0
        });

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

        function hitungTotalSPP() {
            let totalSPP = 0;
            $(".jmlsppperbulan").each(function() {
                let val = $(this).val().replace(/[^0-9]/g, '');
                if (val) {
                    totalSPP += parseInt(val);
                }
            });
            $("#totalspppertahun").text(convertToRupiah(totalSPP));
        }

        hitungTotalSPP();

        $(".jmlsppperbulan").on('input keyup change', function() {
            hitungTotalSPP();
        });
    });
</script>
