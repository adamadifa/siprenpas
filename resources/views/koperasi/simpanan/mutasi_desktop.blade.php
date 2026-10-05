@php
    $saldo = $saldo_simpanan ? $saldo_simpanan->jumlah : 0;
    $nama_simpanan = $saldo_simpanan ? $saldo_simpanan->jenis_simpanan : 'Simpanan';
@endphp

<div class="space-y-4">
    <!-- Summary Header -->
    <div class="bg-emerald-50/80 border border-emerald-200/90 rounded-xl p-4 flex items-center justify-between gap-3 flex-wrap">
        <div>
            <h5 class="font-bold text-slate-900 text-sm mb-0.5">{{ $nama_simpanan }}</h5>
            <p class="text-slate-500 text-xs mb-0">Rincian mutasi rekening simpanan Koperasi</p>
        </div>
        <div class="text-right">
            <span class="text-slate-400 text-[11px] block font-medium">Saldo Akumulasi Saat Ini</span>
            <div class="font-black font-mono text-emerald-700 text-base sm:text-lg">
                Rp {{ number_format($saldo, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- Mutasi Transactions Table -->
    <div class="bg-white border border-slate-200/90 rounded-xl shadow-2xs overflow-hidden">
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-200/80 flex items-center justify-between">
            <h6 class="font-bold text-xs text-slate-800 uppercase tracking-wider mb-0 flex items-center gap-1.5">
                <i class="ti ti-history text-emerald-600"></i>
                <span>Riwayat Transaksi</span>
            </h6>
        </div>
        
        <div class="overflow-x-auto max-h-96 overflow-y-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="sticky top-0 bg-slate-100 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-200">
                    <tr>
                        <th class="py-2.5 px-3">Tanggal</th>
                        <th class="py-2.5 px-3">No. Transaksi</th>
                        <th class="py-2.5 px-3 text-center">Jenis Transaksi</th>
                        <th class="py-2.5 px-3 text-right">Jumlah (Rp)</th>
                        <th class="py-2.5 px-3 text-right">Saldo Akhir (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white">
                    @forelse ($mutasi as $d)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-2.5 px-3 text-slate-600">{{ date('d M Y', strtotime($d->tanggal)) }}</td>
                            <td class="py-2.5 px-3 font-mono font-bold text-slate-800">{{ $d->no_transaksi }}</td>
                            <td class="py-2.5 px-3 text-center">
                                @if ($d->jenis_transaksi == 'D' || $d->jenis_transaksi == 'S')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        SETORAN (+)
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        PENARIKAN (-)
                                    </span>
                                @endif
                            </td>
                            <td class="py-2.5 px-3 text-right font-mono font-bold text-xs {{ ($d->jenis_transaksi == 'D' || $d->jenis_transaksi == 'S') ? 'text-emerald-700' : 'text-rose-600' }}">
                                {{ ($d->jenis_transaksi == 'D' || $d->jenis_transaksi == 'S') ? '+' : '-' }} Rp {{ number_format($d->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="py-2.5 px-3 text-right font-mono font-bold text-slate-900 text-xs">
                                Rp {{ number_format($d->saldo, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-slate-400">
                                Belum ada riwayat mutasi transaksi untuk simpanan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
