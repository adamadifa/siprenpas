@php
    $jumlah_pembiayaan = $pembiayaan->jumlah + ($pembiayaan->persentase / 100) * $pembiayaan->jumlah;
@endphp

<form action="{{ route('pembiayaan.updaterencanacicilan', Crypt::encrypt($pembiayaan->no_akad)) }}" 
      method="POST" 
      id="formEditRencanapembiayaan" 
      class="space-y-4 sm:space-y-5" 
      novalidate>
    @csrf
    @method('PUT')

    <!-- Overview Box -->
    <div class="p-3.5 sm:p-4 bg-emerald-50/90 border border-emerald-200 text-emerald-900 rounded-xl flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-base font-bold shadow-2xs shrink-0">
                <i class="ti ti-edit"></i>
            </div>
            <div>
                <div class="text-xs sm:text-sm font-bold">Edit Rencana Cicilan</div>
                <div class="text-[11px] text-emerald-700/80 font-medium">No. Akad: <strong class="font-mono text-emerald-900">{{ $pembiayaan->no_akad }}</strong> ({{ $pembiayaan->jenis_pembiayaan }})</div>
            </div>
        </div>
        <div class="text-right">
            <span class="text-[10px] text-slate-500 font-medium block">Total Pembiayaan:</span>
            <span class="text-xs sm:text-sm font-black font-mono text-emerald-700" id="totalpembiayaan">{{ formatRupiah($jumlah_pembiayaan) }}</span>
        </div>
    </div>

    <!-- Summary Details Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs">
        <div>
            <span class="text-slate-400 block text-[10px] font-bold uppercase">Pokok:</span>
            <span class="font-bold font-mono text-slate-800">Rp {{ formatRupiah($pembiayaan->jumlah) }}</span>
        </div>
        <div>
            <span class="text-slate-400 block text-[10px] font-bold uppercase">Margin:</span>
            <span class="font-bold text-slate-800">{{ $pembiayaan->persentase }}%</span>
        </div>
        <div>
            <span class="text-slate-400 block text-[10px] font-bold uppercase">No. Anggota:</span>
            <span class="font-bold font-mono text-slate-800">{{ $pembiayaan->no_anggota }}</span>
        </div>
        <div>
            <span class="text-slate-400 block text-[10px] font-bold uppercase">Nasabah:</span>
            <span class="font-bold text-slate-800 truncate block">{{ $pembiayaan->nama_lengkap ?? '-' }}</span>
        </div>
    </div>

    <!-- Cicilan Table -->
    <div class="overflow-x-auto border border-slate-200 rounded-xl shadow-2xs bg-white">
        <table class="w-full text-left text-xs sm:text-sm border-collapse">
            <thead class="bg-emerald-600 text-white font-bold uppercase text-[11px] border-b border-emerald-700">
                <tr>
                    <th class="py-2.5 px-3 w-12 text-center text-emerald-100">Ke</th>
                    <th class="py-2.5 px-3 text-emerald-100">Jatuh Tempo</th>
                    <th class="py-2.5 px-3 text-right text-emerald-100 w-44">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs">
                @php $total = 0; @endphp
                @foreach ($rencana as $d)
                    @php
                        $bulanCicilan = (int)$d->bulan;
                        $tahunCicilan = (int)$d->tahun;
                        if ($bulanCicilan > 12) {
                            $tahunCicilan += intdiv($bulanCicilan - 1, 12);
                            $bulanCicilan = (($bulanCicilan - 1) % 12) + 1;
                        }
                        $jatuh_tempo = sprintf('%04d-%02d-05', $tahunCicilan, $bulanCicilan);
                        $total += $d->jumlah;
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-2 px-3 text-center font-bold font-mono text-slate-500">
                            <input type="hidden" name="cicilan_ke[]" value="{{ $d->cicilan_ke }}" class="cicilan_ke">
                            {{ $d->cicilan_ke }}
                        </td>
                        <td class="py-2 px-3 text-slate-700 font-medium whitespace-nowrap">
                            <input type="hidden" name="tahun[]" value="{{ $d->tahun }}" class="tahun">
                            <input type="hidden" name="bulan[]" value="{{ $d->bulan }}" class="bulan">
                            {{ DateToIndo($jatuh_tempo) }}
                        </td>
                        <td class="py-1.5 px-3 text-right">
                            <input type="text" 
                                   name="jumlah[]" 
                                   value="{{ formatRupiah($d->jumlah) }}"
                                   class="money jumlah w-full px-2.5 py-1.5 text-xs font-bold font-mono text-right text-slate-900 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-slate-50 font-bold border-t border-slate-200 text-xs">
                <tr>
                    <td colspan="2" class="py-2.5 px-3 text-center uppercase tracking-wider text-[11px] text-slate-600">Total Rencana Baru</td>
                    <td class="py-2.5 px-3 text-right font-mono text-emerald-700 font-bold text-sm" id="totalrencanapembiayaan">Rp {{ formatRupiah($total) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Actions Footer -->
    <div class="pt-3 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" 
                class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-lg transition cursor-pointer active:scale-95" 
                data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" 
                id="btnSimpanRencana" 
                class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $('#formEditRencanapembiayaan');
        $(".jumlah").maskMoney({
            thousands: '.',
            decimal: ',',
            precision: 0
        });

        function convertToRupiah(number) {
            if (number) {
                var rupiah = "";
                var numberrev = number.toString().split("").reverse().join("");
                for (var i = 0; i < numberrev.length; i++)
                    if (i % 3 == 0) rupiah += numberrev.substr(i, 3) + ".";
                return rupiah.split("", rupiah.length - 1).reverse().join("");
            } else {
                return '0';
            }
        }

        function updateTotalPembiayaan() {
            let total = 0;
            form.find('.jumlah').each(function() {
                let jumlah = $(this).val().toString().replace(/\./g, '');
                total += parseInt(jumlah) || 0;
            });
            form.find('#totalrencanapembiayaan').text('Rp ' + convertToRupiah(total));
        }

        updateTotalPembiayaan();
        form.find('.jumlah').on('input keyup keydown change', function() {
            updateTotalPembiayaan();
        });

        form.on('submit', function(e) {
            let total_pembiayaan = parseInt("{{ $jumlah_pembiayaan }}") || 0;
            let totalrencanapembiayaan = 0;
            form.find('.jumlah').each(function() {
                let jumlah = $(this).val().toString().replace(/\./g, '');
                totalrencanapembiayaan += parseInt(jumlah) || 0;
            });

            if (total_pembiayaan !== totalrencanapembiayaan) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Total Tidak Cocok',
                    text: `Total akumulasi rencana cicilan (Rp ${totalrencanapembiayaan.toLocaleString('id-ID')}) harus sama persis dengan total pembiayaan (Rp ${total_pembiayaan.toLocaleString('id-ID')})!`,
                    confirmButtonColor: '#064e3b'
                });
                return false;
            }

            $("#btnSimpanRencana").prop('disabled', true).html(`
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                <span>Menyimpan...</span>
            `);
        });
    });
</script>
