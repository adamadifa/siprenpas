@php
    $jumlah_pembiayaan = $pembiayaan->jumlah + ($pembiayaan->persentase / 100) * $pembiayaan->jumlah;
    $isLunas = $pembiayaan->jmlbayar >= $jumlah_pembiayaan;
    $progress = $jumlah_pembiayaan > 0 ? min(100, round(($pembiayaan->jmlbayar / $jumlah_pembiayaan) * 100)) : 0;
    $sisa_tagihan = max(0, $jumlah_pembiayaan - $pembiayaan->jmlbayar);
@endphp

<div class="space-y-5">
    
    <!-- Top Summary Banner -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200/90 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Pembiayaan</span>
                <div class="text-base sm:text-lg font-black font-mono text-emerald-800">
                    Rp {{ formatAngka($jumlah_pembiayaan) }}
                </div>
            </div>
            <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg">
                <i class="ti ti-receipt-tax"></i>
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-teal-50/80 border border-teal-200/90 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Sudah Dibayar</span>
                <div class="text-base sm:text-lg font-black font-mono text-teal-800">
                    Rp {{ formatAngka($pembiayaan->jmlbayar) }}
                </div>
            </div>
            <div class="w-9 h-9 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-lg">
                <i class="ti ti-circle-check"></i>
            </div>
        </div>

        <div class="p-4 rounded-2xl {{ $isLunas ? 'bg-emerald-50/80 border-emerald-200/90' : 'bg-rose-50/80 border-rose-200/90' }} flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Sisa Tagihan</span>
                <div class="text-base sm:text-lg font-black font-mono {{ $isLunas ? 'text-emerald-700' : 'text-rose-700' }}">
                    Rp {{ formatAngka($sisa_tagihan) }}
                </div>
            </div>
            <div class="w-9 h-9 rounded-xl {{ $isLunas ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} flex items-center justify-center text-lg">
                <i class="ti ti-coins"></i>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        
        <!-- Left: Contract Details Card (4 Cols) -->
        <div class="lg:col-span-4 bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex flex-col justify-between space-y-4">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center text-sm">
                            <i class="ti ti-file-certificate"></i>
                        </div>
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Informasi Akad</h4>
                    </div>
                    @if ($isLunas)
                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase">LUNAS</span>
                    @else
                        <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-black uppercase">BELUM LUNAS</span>
                    @endif
                </div>

                <div class="space-y-2.5 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium">No. Akad</span>
                        <span class="font-bold font-mono text-slate-800">{{ $pembiayaan->no_akad }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium">Tanggal Akad</span>
                        <span class="font-bold text-slate-800">{{ DateToIndo($pembiayaan->tanggal) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium">Jenis Pembiayaan</span>
                        <span class="font-bold text-emerald-700">{{ $pembiayaan->jenis_pembiayaan }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium">Jangka Waktu</span>
                        <span class="font-bold text-slate-800">{{ $pembiayaan->jangka_waktu }} Bulan</span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                        <span class="text-slate-400 font-medium">Pokok Pembiayaan</span>
                        <span class="font-bold font-mono text-slate-800">Rp {{ formatAngka($pembiayaan->jumlah) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium">Jasa Koperasi ({{ $pembiayaan->persentase }}%)</span>
                        <span class="font-bold font-mono text-slate-800">Rp {{ formatAngka($jumlah_pembiayaan - $pembiayaan->jumlah) }}</span>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="pt-3 border-t border-slate-100 space-y-1.5">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-400 font-medium">Progress Pelunasan</span>
                    <span class="font-black text-emerald-700">{{ $progress }}%</span>
                </div>
                <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-600 to-teal-500 rounded-full" style="width: {{ $progress }}%;"></div>
                </div>
            </div>
        </div>

        <!-- Right: Schedule Installment Table (8 Cols) -->
        <div class="lg:col-span-8 bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-5 py-3.5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-calendar-stats text-emerald-600"></i>
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Rencana & Riwayat Cicilan</h4>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-400">{{ count($rencanapembiayaan) }} Angsuran</span>
                </div>

                <div class="overflow-x-auto max-h-80 overflow-y-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead class="sticky top-0 bg-slate-100 text-slate-600 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                            <tr>
                                <th class="py-2.5 px-3 text-center">Ke</th>
                                <th class="py-2.5 px-3">Jatuh Tempo</th>
                                <th class="py-2.5 px-3 text-right">Tagihan</th>
                                <th class="py-2.5 px-3 text-right">Bayar</th>
                                <th class="py-2.5 px-3 text-right">Sisa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @foreach ($rencanapembiayaan as $d)
                                @php
                                    $bulanCicilan = (int)$d->bulan;
                                    $tahunCicilan = (int)$d->tahun;
                                    if ($bulanCicilan > 12) {
                                        $tahunCicilan += intdiv($bulanCicilan - 1, 12);
                                        $bulanCicilan = (($bulanCicilan - 1) % 12) + 1;
                                    }
                                    $jatuhtempo = sprintf('%04d-%02d-05', $tahunCicilan, $bulanCicilan);
                                    $tagihan = $d->jumlah ?? 0;
                                    $bayar = $d->bayar ?? 0;
                                    $sisa = $tagihan - $bayar;
                                    $isPaid = ($sisa <= 0);
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors {{ $isPaid ? 'bg-emerald-50/40' : '' }}">
                                    <td class="py-2.5 px-3 text-center font-bold text-slate-500">
                                        {{ $d->cicilan_ke }}
                                    </td>
                                    <td class="py-2.5 px-3 whitespace-nowrap">
                                        {{ date('d M Y', strtotime($jatuhtempo)) }}
                                    </td>
                                    <td class="py-2.5 px-3 text-right font-mono font-bold text-slate-800">
                                        Rp {{ formatAngka($tagihan) }}
                                    </td>
                                    <td class="py-2.5 px-3 text-right font-mono font-bold text-emerald-600">
                                        Rp {{ formatAngka($bayar) }}
                                    </td>
                                    <td class="py-2.5 px-3 text-right font-mono font-bold {{ $sisa > 0 ? 'text-rose-600' : 'text-slate-400' }}">
                                        Rp {{ formatAngka($sisa) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
