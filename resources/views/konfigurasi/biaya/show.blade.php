<div class="space-y-4">
    <!-- Header Overview Card -->
    <div class="p-4 bg-slate-50 border border-slate-200/90 rounded-2xl">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100 font-bold">
                    <i class="ti ti-building text-xl"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Jenjang / Unit</span>
                    <span class="text-xs font-black text-slate-800">{{ $biaya->nama_unit }}</span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100 font-bold">
                    <i class="ti ti-stairs text-xl"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Tingkat & Status</span>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-sky-100 text-sky-800">
                            Kelas {{ $biaya->tingkat }}
                        </span>
                        @if ($biaya->is_pindahan)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-800">
                                Pindahan
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 border border-slate-200 font-bold">
                    <i class="ti ti-calendar text-xl"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Tahun Ajaran</span>
                    <span class="text-xs font-mono font-bold text-slate-800">{{ $biaya->tahun_ajaran }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Title -->
    <div class="flex items-center gap-3 pt-1">
        <div class="h-px bg-slate-200 flex-1"></div>
        <span class="text-xs font-extrabold uppercase text-slate-400 tracking-wider flex items-center gap-1.5">
            <i class="ti ti-receipt text-emerald-600"></i>
            Rincian Komponen Biaya
        </span>
        <div class="h-px bg-slate-200 flex-1"></div>
    </div>

    <!-- Tabel Rincian Detail Biaya -->
    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs bg-white">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100 text-slate-700 text-[11px] font-extrabold uppercase border-b border-slate-200">
                    <th class="py-2.5 px-3 w-28 text-center">KODE</th>
                    <th class="py-2.5 px-4">JENIS BIAYA</th>
                    <th class="py-2.5 px-4 text-right w-44">JUMLAH (RP)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                @php
                    $total_biaya = 0;
                @endphp
                @forelse ($detail as $d)
                    @php
                        $total_biaya += $d->jumlah;
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3 px-3 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 font-mono text-[11px] font-bold border border-slate-200">
                                {{ $d->kode_jenis_biaya }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-bold text-slate-800">{{ strtoupper($d->jenis_biaya) }}</td>
                        <td class="py-3 px-4 text-right font-mono font-bold text-slate-800">
                            Rp {{ formatAngka($d->jumlah) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-8 text-center text-slate-400">Tidak ada komponen rincian biaya.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-slate-900 text-white font-extrabold text-xs">
                    <td colspan="2" class="py-3.5 px-4 text-left uppercase tracking-wider">Total Biaya Pendidikan</td>
                    <td class="py-3.5 px-4 text-right font-mono text-sm text-emerald-400">
                        Rp {{ formatAngka($total_biaya) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Modal Footer Action -->
    <div class="pt-2 flex justify-end">
        <button type="button" data-bs-dismiss="modal" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
            Tutup
        </button>
    </div>
</div>
