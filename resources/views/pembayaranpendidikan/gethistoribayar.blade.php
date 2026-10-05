@forelse ($historibayar as $d)
    <tr class="hover:bg-emerald-50/40 transition-colors">
        <td class="py-2.5 px-3">
            <span class="px-2 py-0.5 rounded-md text-xs font-mono font-bold bg-slate-100 text-slate-800 border border-slate-200">
                {{ $d->no_bukti }}
            </span>
        </td>
        <td class="py-2.5 px-3 whitespace-nowrap text-slate-700 font-medium">
            {{ DateToIndo($d->tanggal) }}
        </td>
        <td class="text-end py-2.5 px-3 font-mono font-black text-emerald-700 whitespace-nowrap">
            {{ formatAngka($d->jumlah) }}
        </td>
        <td class="py-2.5 px-3 text-slate-600 text-xs">
            {{ $d->keterangan ?: '-' }}
        </td>
        <td class="py-2.5 px-3 whitespace-nowrap">
            <span class="inline-flex items-center gap-1 text-slate-700 font-medium">
                <i class="ti ti-user text-xs text-slate-400"></i> {{ $d->name }}
            </span>
        </td>
        <td class="py-2.5 px-3 text-center">
            <div class="inline-flex items-center justify-center gap-1">
                <!-- Detail Kwitansi -->
                <a href="#" class="btnDetailbayar w-7 h-7 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs" 
                    no_bukti="{{ Crypt::encrypt($d->no_bukti) }}" title="Lihat Detail Transaksi">
                    <i class="ti ti-file-description text-xs"></i>
                </a>

                <!-- Cetak Kwitansi -->
                <a href="{{ route('pembayaranpendidikan.cetak', Crypt::encrypt($d->no_bukti)) }}" 
                    class="btnPrint w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 flex items-center justify-center transition active:scale-95 shadow-2xs" 
                    target="_blank" title="Cetak Kwitansi">
                    <i class="ti ti-printer text-xs"></i>
                </a>

                <!-- Hapus (Only last transaction) -->
                @if ($loop->iteration == 1)
                    <a href="#" class="btnDeletebayar w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 flex items-center justify-center transition active:scale-95 cursor-pointer shadow-2xs" 
                        key="{{ Crypt::encrypt($d->no_bukti) }}" title="Hapus Pembayaran Terakhir">
                        <i class="ti ti-trash text-xs"></i>
                    </a>
                @endif
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-8">
            <div class="flex flex-col items-center justify-center">
                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-1.5">
                    <i class="ti ti-receipt-off text-xl"></i>
                </div>
                <p class="text-xs font-bold text-slate-700">Belum ada riwayat transaksi pembayaran</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Klik tombol "Input Pembayaran Baru" untuk merekam pembayaran.</p>
            </div>
        </td>
    </tr>
@endforelse
