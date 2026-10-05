@php
    $total_biaya = 0;
    $total_potongan = 0;
    $total_biaya_bersih = 0;
    $total_mutasi = 0;
    $total_bayar = 0;
    $total_sisa_tagihan = 0;

    // Subtotal variables per Year
    $sub_biaya = 0;
    $sub_potongan = 0;
    $sub_biaya_bersih = 0;
    $sub_mutasi = 0;
    $sub_bayar = 0;
    $sub_sisa_tagihan = 0;

    $tahun_ajaran = '';
    $first = true;
@endphp

@foreach ($biaya as $key => $b)
    @php
        $jumlah_biaya = $b->jumlah - $b->jumlah_potongan;
        $sisa_tagihan = $jumlah_biaya - $b->jumlah_mutasi - $b->jmlbayar;
    @endphp

    @if ($tahun_ajaran != $b->tahun_ajaran)
        @if (!$first)
            <!-- Subtotal Row -->
            <tr class="bg-emerald-50/70 border-t border-b border-emerald-200/80 font-bold text-slate-900">
                <td colspan="2" class="py-1.5 px-3 text-[11px] uppercase tracking-wider text-emerald-950">
                    <span class="inline-flex items-center gap-1 font-extrabold text-emerald-900">
                        <i class="ti ti-calculator text-xs"></i> Subtotal TA {{ $tahun_ajaran }}
                    </span>
                </td>
                <td class="text-end py-1.5 px-3 text-slate-900 font-mono">{{ formatAngka($sub_biaya) }}</td>
                <td class="text-end py-1.5 px-3 text-rose-600 font-mono">{{ $sub_potongan > 0 ? formatAngka($sub_potongan) : '-' }}</td>
                <td class="text-end py-1.5 px-3 text-slate-900 font-mono">{{ formatAngka($sub_biaya_bersih) }}</td>
                <td class="text-end py-1.5 px-3 text-sky-700 font-mono">{{ $sub_mutasi > 0 ? formatAngka($sub_mutasi) : '-' }}</td>
                <td class="text-end py-1.5 px-3 text-slate-900 font-mono">{{ formatAngka($sub_bayar) }}</td>
                <td class="text-end py-1.5 px-3 text-emerald-700 font-mono font-black">{{ formatAngka($sub_sisa_tagihan) }}</td>
            </tr>
            @php
                $sub_biaya = 0;
                $sub_potongan = 0;
                $sub_biaya_bersih = 0;
                $sub_mutasi = 0;
                $sub_bayar = 0;
                $sub_sisa_tagihan = 0;
            @endphp
        @endif

        @php
            $tahun_ajaran = $b->tahun_ajaran;
            $hasPayment = $biaya->where('kode_biaya', $b->kode_biaya)->sum('jmlbayar') > 0;
            $first = false;
        @endphp

        <!-- Group Header -->
        <tr class="bg-slate-100/90 border-t border-slate-200">
            <td colspan="8" class="py-1.5 px-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-md bg-emerald-600 text-white flex items-center justify-center text-[10px]">
                            <i class="ti ti-calendar-event"></i>
                        </span>
                        <span class="font-extrabold text-slate-800 text-xs">
                            TAHUN AJARAN {{ $b->tahun_ajaran }} <span class="text-slate-400 font-normal font-mono">({{ $b->kode_biaya }})</span>
                        </span>
                    </div>
                    @if (!$hasPayment)
                        <div>
                            <a href="#" class="btnEditBiaya inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200/80 text-[11px] font-bold transition active:scale-95 cursor-pointer shadow-2xs" 
                                no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}" 
                                kode_biaya="{{ Crypt::encrypt($b->kode_biaya) }}"
                                title="Ubah Konfigurasi Biaya">
                                <i class="ti ti-edit text-xs"></i>
                                <span>Ubah Biaya</span>
                            </a>
                        </div>
                    @endif
                </div>
            </td>
        </tr>
    @endif

    @php
        $total_biaya += $b->jumlah;
        $total_potongan += $b->jumlah_potongan;
        $total_biaya_bersih += $jumlah_biaya;
        $total_sisa_tagihan += $sisa_tagihan;
        $total_mutasi += $b->jumlah_mutasi;
        $total_bayar += $b->jmlbayar;

        $sub_biaya += $b->jumlah;
        $sub_potongan += $b->jumlah_potongan;
        $sub_biaya_bersih += $jumlah_biaya;
        $sub_sisa_tagihan += $sisa_tagihan;
        $sub_mutasi += $b->jumlah_mutasi;
        $sub_bayar += $b->jmlbayar;
    @endphp

    <tr class="hover:bg-emerald-50/40 transition-colors">
        <td class="py-1.5 px-3 font-mono text-[11px] text-slate-500">{{ $b->kode_biaya }}</td>
        <td class="py-1.5 px-3 font-semibold text-slate-800">
            {{ $b->jenis_biaya }}
        </td>
        <td class="text-end py-1.5 px-3 font-mono font-bold text-slate-800">{{ formatAngka($b->jumlah) }}</td>
        
        <!-- Potongan -->
        @if (empty($b->jumlah_potongan))
            <td class="text-center py-1.5 px-3">
                <a href="#" class="inputpotongan inline-flex items-center justify-center w-5.5 h-5.5 rounded-md bg-slate-50 hover:bg-rose-50 text-slate-400 hover:text-rose-600 border border-slate-200 hover:border-rose-200 transition cursor-pointer text-xs" 
                    kode_jenis_biaya="{{ Crypt::encrypt($b->kode_jenis_biaya) }}"
                    no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}" 
                    jenis_biaya="{{ $b->jenis_biaya }}"
                    kode_biaya="{{ Crypt::encrypt($b->kode_biaya) }}"
                    title="Input Potongan">
                    <i class="ti ti-minus text-[11px]"></i>
                </a>
            </td>
        @else
            <td class="text-end py-1.5 px-3">
                <a href="#" class="inputpotongan inline-flex items-center gap-1 font-mono font-bold text-rose-600 hover:text-rose-800 bg-rose-50 px-1.5 py-0.5 rounded border border-rose-200/60 text-xs transition" 
                    kode_jenis_biaya="{{ Crypt::encrypt($b->kode_jenis_biaya) }}"
                    no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}" 
                    jenis_biaya="{{ $b->jenis_biaya }}"
                    kode_biaya="{{ Crypt::encrypt($b->kode_biaya) }}"
                    title="Ubah Potongan">
                    <i class="ti ti-discount text-xs"></i> {{ formatAngka($b->jumlah_potongan) }}
                </a>
            </td>
        @endif

        <td class="text-end py-1.5 px-3 font-mono font-bold text-slate-800">{{ formatAngka($jumlah_biaya) }}</td>

        <!-- Mutasi -->
        @if (empty($b->jumlah_mutasi))
            <td class="text-center py-1.5 px-3">
                <a href="#" class="inputmutasi inline-flex items-center justify-center w-5.5 h-5.5 rounded-md bg-slate-50 hover:bg-sky-50 text-slate-400 hover:text-sky-600 border border-slate-200 hover:border-sky-200 transition cursor-pointer text-xs" 
                    kode_jenis_biaya="{{ Crypt::encrypt($b->kode_jenis_biaya) }}"
                    no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}" 
                    jenis_biaya="{{ $b->jenis_biaya }}"
                    kode_biaya="{{ Crypt::encrypt($b->kode_biaya) }}"
                    title="Input Mutasi">
                    <i class="ti ti-arrows-exchange text-[11px]"></i>
                </a>
            </td>
        @else
            <td class="text-end py-1.5 px-3">
                <a href="#" class="inputmutasi inline-flex items-center gap-1 font-mono font-bold text-sky-700 hover:text-sky-900 bg-sky-50 px-1.5 py-0.5 rounded border border-sky-200/60 text-xs transition" 
                    kode_jenis_biaya="{{ Crypt::encrypt($b->kode_jenis_biaya) }}"
                    no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}" 
                    jenis_biaya="{{ $b->jenis_biaya }}"
                    kode_biaya="{{ Crypt::encrypt($b->kode_biaya) }}"
                    title="Ubah Mutasi">
                    <i class="ti ti-arrows-exchange text-xs"></i> {{ formatAngka($b->jumlah_mutasi) }}
                </a>
            </td>
        @endif

        <td class="text-end py-1.5 px-3 font-mono text-slate-700">{{ formatAngka($b->jmlbayar) }}</td>
        <td class="text-end py-1.5 px-3 font-mono font-bold {{ $sisa_tagihan > 0 ? 'text-emerald-700' : 'text-slate-400' }}">
            {{ formatAngka($sisa_tagihan) }}
        </td>
    </tr>
@endforeach

@if ($tahun_ajaran != '')
    <!-- Final Subtotal Row -->
    <tr class="bg-emerald-50/70 border-t border-b border-emerald-200/80 font-bold text-slate-900">
        <td colspan="2" class="py-1.5 px-3 text-[11px] uppercase tracking-wider text-emerald-950">
            <span class="inline-flex items-center gap-1 font-extrabold text-emerald-900">
                <i class="ti ti-calculator text-xs"></i> Subtotal TA {{ $tahun_ajaran }}
            </span>
        </td>
        <td class="text-end py-1.5 px-3 text-slate-900 font-mono">{{ formatAngka($sub_biaya) }}</td>
        <td class="text-end py-1.5 px-3 text-rose-600 font-mono">{{ $sub_potongan > 0 ? formatAngka($sub_potongan) : '-' }}</td>
        <td class="text-end py-1.5 px-3 text-slate-900 font-mono">{{ formatAngka($sub_biaya_bersih) }}</td>
        <td class="text-end py-1.5 px-3 text-sky-700 font-mono">{{ $sub_mutasi > 0 ? formatAngka($sub_mutasi) : '-' }}</td>
        <td class="text-end py-1.5 px-3 text-slate-900 font-mono">{{ formatAngka($sub_bayar) }}</td>
        <td class="text-end py-1.5 px-3 text-emerald-700 font-mono font-black">{{ formatAngka($sub_sisa_tagihan) }}</td>
    </tr>
@endif

<!-- Grand Total Row -->
<tr class="bg-emerald-700 text-white font-bold border-t-2 border-emerald-800 text-xs shadow-xs">
    <td colspan="2" class="py-2 px-3 uppercase tracking-wider text-emerald-100 font-extrabold">
        <span class="inline-flex items-center gap-1.5">
            <i class="ti ti-sum text-sm"></i>
            <span>GRAND TOTAL</span>
        </span>
    </td>
    <td class="text-end py-2 px-3 font-mono font-bold text-white">{{ formatAngka($total_biaya) }}</td>
    <td class="text-end py-2 px-3 font-mono font-bold text-rose-200">{{ formatAngka($total_potongan) }}</td>
    <td class="text-end py-2 px-3 font-mono font-bold text-white">{{ formatAngka($total_biaya_bersih) }}</td>
    <td class="text-end py-2 px-3 font-mono font-bold text-sky-200">{{ formatAngka($total_mutasi) }}</td>
    <td class="text-end py-2 px-3 font-mono font-bold text-white">{{ formatAngka($total_bayar) }}</td>
    <td class="text-end py-2 px-3 font-mono font-black text-amber-300 text-sm">{{ formatAngka($total_sisa_tagihan) }}</td>
</tr>
