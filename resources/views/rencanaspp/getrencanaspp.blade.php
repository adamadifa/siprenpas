@php
    $total_spp = 0;
    $total_spp_per_ta = 0;
    $kode_ta = '';
@endphp

@forelse ($detailrencanaspp as $key => $d)
    @php
        $kode_tahun_ajaran = @$detailrencanaspp[$key + 1]->kode_ta;
        $jatuh_tempo = $d->tahun . '-' . $d->bulan . '-10';
        $total_spp += $d->jumlah;
        $total_spp_per_ta += $d->jumlah;
        $sisa_tagihan = $d->jumlah - $d->realisasi;
    @endphp

    @if ($kode_ta != $d->kode_ta)
        <!-- TA Header Row -->
        <tr class="bg-slate-100/90 border-t border-slate-200">
            <td colspan="4" class="py-1.5 px-3">
                <div class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded-md bg-emerald-600 text-white flex items-center justify-center text-[10px]">
                        <i class="ti ti-calendar"></i>
                    </span>
                    <span class="font-extrabold text-slate-800 text-xs">
                        SPP TAHUN AJARAN {{ $d->tahun_ajaran }}
                    </span>
                </div>
            </td>
            <td class="py-1.5 px-3 text-end">
                @can('rencanaspp.edit')
                    <a href="#" class="editrencanaspp inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200/80 text-[11px] font-bold transition active:scale-95 cursor-pointer shadow-2xs"
                        kode_rencana_spp="{{ Crypt::encrypt($d->kode_rencana_spp) }}">
                        <i class="ti ti-edit text-xs"></i>
                        <span>Edit Rencana</span>
                    </a>
                @endcan
            </td>
        </tr>
    @endif

    <tr class="hover:bg-emerald-50/40 transition-colors">
        <td class="py-1.5 px-3 font-semibold text-slate-800">
            {{ $listbulan[$d->bulan] }} {{ $d->tahun }}
        </td>
        <td class="text-end py-1.5 px-3 font-mono font-bold text-slate-800">
            {{ formatAngka($d->jumlah) }}
        </td>
        <td class="text-end py-1.5 px-3 font-mono text-slate-700">
            {{ formatAngka($d->realisasi) }}
        </td>
        <td class="text-end py-1.5 px-3 font-mono font-bold {{ $sisa_tagihan > 0 ? 'text-rose-600' : 'text-emerald-700' }}">
            {{ formatAngka($sisa_tagihan) }}
        </td>
        <td class="py-1.5 px-3 text-center whitespace-nowrap text-slate-500 font-mono text-xs">
            <span class="inline-flex items-center gap-1">
                <i class="ti ti-clock text-xs text-slate-400"></i> {{ date('d-m-Y', strtotime($jatuh_tempo)) }}
            </span>
        </td>
    </tr>

    @if ($kode_tahun_ajaran != $d->kode_ta)
        <!-- Subtotal Row -->
        <tr class="bg-emerald-50/70 border-t border-b border-emerald-200/80 font-bold text-slate-900">
            <td class="py-1.5 px-3 text-[11px] uppercase tracking-wider text-emerald-950 font-extrabold">
                <span class="inline-flex items-center gap-1">
                    <i class="ti ti-calculator text-xs"></i> Subtotal {{ $d->tahun_ajaran }}
                </span>
            </td>
            <td class="text-end py-1.5 px-3 text-slate-900 font-mono font-bold">{{ formatAngka($total_spp_per_ta) }}</td>
            <td colspan="3"></td>
        </tr>
        @php
            $total_spp_per_ta = 0;
        @endphp
    @endif

    @php
        $kode_ta = $d->kode_ta;
    @endphp
@empty
    <tr>
        <td colspan="5" class="text-center py-8">
            <div class="flex flex-col items-center justify-center">
                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-1.5">
                    <i class="ti ti-calendar-off text-xl"></i>
                </div>
                <p class="text-xs font-bold text-slate-700">Rencana SPP belum dibuat</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Silakan klik tombol "Buat Rencana SPP" di atas.</p>
            </div>
        </td>
    </tr>
@endforelse

@if(count($detailrencanaspp) > 0)
    <!-- Grand Total Row -->
    <tr class="bg-emerald-700 text-white font-bold border-t-2 border-emerald-800 text-xs shadow-xs">
        <td class="py-2 px-3 uppercase tracking-wider text-emerald-100 font-extrabold flex items-center gap-1.5">
            <i class="ti ti-sum text-sm"></i>
            <span>GRAND TOTAL SPP</span>
        </td>
        <td class="text-end py-2 px-3 font-mono font-black text-amber-300 text-sm">{{ formatAngka($total_spp) }}</td>
        <td colspan="3"></td>
    </tr>
@endif
