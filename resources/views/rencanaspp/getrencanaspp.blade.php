@php
    $total_spp = 0;
    $total_spp_per_ta = 0;
    $kode_ta = '';
@endphp
@foreach ($detailrencanaspp as $key => $d)
    @php
        $kode_tahun_ajaran = @$detailrencanaspp[$key + 1]->kode_ta;
    @endphp
    @php
        $jatuh_tempo = $d->tahun . '-' . $d->bulan . '-10';
        $total_spp += $d->jumlah;
        $total_spp_per_ta += $d->jumlah;
    @endphp
    @if ($kode_ta != $d->kode_ta)
        <tr class="table-dark">
            <td colspan="4">SPP TAHUN AJARAN {{ $d->tahun_ajaran }}</td>
            <td>
                <a href="#" class="btn btn-warning btn-sm editrencanaspp"
                    kode_rencana_spp="{{ Crypt::encrypt($d->kode_rencana_spp) }}"><i class="ti ti-edit me-1"></i>Edit
                    Rencana SPP</a>
            </td>
        </tr>
    @endif
    <tr>
        <td>{{ $listbulan[$d->bulan] }} {{ $d->tahun }}</td>
        <td class="text-end">{{ formatAngka($d->jumlah) }}</td>
        <td class="text-end">{{ formatAngka($d->realisasi) }}</td>
        <td class="text-end">
            @php
                $sisa_tagihan = $d->jumlah - $d->realisasi;
            @endphp
            {{ formatAngka($sisa_tagihan) }}
        </td>
        <td>{{ date('d-m-Y', strtotime($jatuh_tempo)) }}</td>
    </tr>

    @if ($kode_tahun_ajaran != $d->kode_ta)
        <tr class="table-dark">
            <td>TOTAL</td>
            <td class="text-end">{{ formatAngka($total_spp_per_ta) }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @php
            $total_spp_per_ta = 0;
        @endphp
    @endif
    @php
        $kode_ta = $d->kode_ta;
    @endphp
@endforeach
<tr class="table-dark">
    <td>GRAND TOTAL</td>
    <td class="text-end">{{ formatAngka($total_spp) }}</td>
    <td></td>
    <td></td>
    <td></td>
</tr>
