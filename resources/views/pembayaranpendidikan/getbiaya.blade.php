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
            <tr style="background-color: #e8f5e9; border-top: 1px solid #c8e6c9;" class="fw-bold">
                <td colspan="2" class="py-2 px-3 text-dark text-uppercase small">Subtotal {{ $tahun_ajaran }}</td>
                <td class="text-end py-2 text-dark small">{{ formatAngka($sub_biaya) }}</td>
                <td class="text-end py-2 text-danger small">{{ formatAngka($sub_potongan) }}</td>
                <td class="text-end py-2 text-dark small">{{ formatAngka($sub_biaya_bersih) }}</td>
                <td class="text-end py-2 text-info small">{{ formatAngka($sub_mutasi) }}</td>
                <td class="text-end py-2 text-dark small">{{ formatAngka($sub_bayar) }}</td>
                <td class="text-end py-2 text-success small">{{ formatAngka($sub_sisa_tagihan) }}</td>
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
        <tr style="background-color: #f1f3f4">
            <td colspan="8" class="text-dark fw-bold py-2 px-3 small">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="ti ti-calendar-event me-1 text-success"></i> TAHUN AJARAN {{ $b->tahun_ajaran }} ({{ $b->kode_biaya }})
                    </div>
                    @if (!$hasPayment)
                        <div>
                            <a href="#" class="btnEditBiaya btn btn-xs btn-label-warning border shadow-none" 
                                no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}" 
                                kode_biaya="{{ Crypt::encrypt($b->kode_biaya) }}"
                                title="Ubah Konfigurasi Biaya">
                                <i class="ti ti-edit me-1"></i> Ubah Biaya
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
    <tr class="align-middle">
        <td class="py-1 small text-muted">{{ $b->kode_biaya }}</td>
        <td class="py-1">
            <span class="fw-medium">{{ $b->jenis_biaya }}</span>
        </td>
        <td class="text-end py-1 fw-bold">{{ formatAngka($b->jumlah) }}</td>
        @if (empty($b->jumlah_potongan))
            <td class="text-center py-1">
                <a href="#" class="inputpotongan btn btn-icon btn-xs btn-label-danger border shadow-none" 
                    kode_jenis_biaya="{{ Crypt::encrypt($b->kode_jenis_biaya) }}"
                    no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}" 
                    jenis_biaya="{{ $b->jenis_biaya }}"
                    kode_biaya="{{ Crypt::encrypt($b->kode_biaya) }}"
                    title="Input Potongan">
                    <i class="ti ti-minus fs-6"></i>
                </a>
            </td>
        @else
            <td class="text-end py-1">
                <a href="#" class="inputpotongan text-danger fw-bold" 
                    kode_jenis_biaya="{{ Crypt::encrypt($b->kode_jenis_biaya) }}"
                    no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}" 
                    jenis_biaya="{{ $b->jenis_biaya }}"
                    kode_biaya="{{ Crypt::encrypt($b->kode_biaya) }}">
                    {{ formatAngka($b->jumlah_potongan) }}
                </a>
            </td>
        @endif
        <td class="text-end py-1 fw-bold">{{ formatAngka($jumlah_biaya) }}</td>
        @if (empty($b->jumlah_mutasi))
            <td class="text-center py-1">
                <a href="#" class="inputmutasi btn btn-icon btn-xs btn-label-info border shadow-none" 
                    kode_jenis_biaya="{{ Crypt::encrypt($b->kode_jenis_biaya) }}"
                    no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}" 
                    jenis_biaya="{{ $b->jenis_biaya }}"
                    kode_biaya="{{ Crypt::encrypt($b->kode_biaya) }}"
                    title="Input Mutasi">
                    <i class="ti ti-arrows-exchange fs-6"></i>
                </a>
            </td>
        @else
            <td class="text-end py-1">
                <a href="#" class="inputmutasi text-info fw-bold" 
                    kode_jenis_biaya="{{ Crypt::encrypt($b->kode_jenis_biaya) }}"
                    no_pendaftaran="{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}" 
                    jenis_biaya="{{ $b->jenis_biaya }}"
                    kode_biaya="{{ Crypt::encrypt($b->kode_biaya) }}">
                    {{ formatAngka($b->jumlah_mutasi) }}
                </a>
            </td>
        @endif
        <td class="text-end py-1">{{ formatAngka($b->jmlbayar) }}</td>
        <td class="text-end py-1 fw-bold text-success">{{ formatAngka($sisa_tagihan) }}</td>
    </tr>
@endforeach
@if ($tahun_ajaran != '')
    <tr style="background-color: #e8f5e9; border-top: 1px solid #c8e6c9;" class="fw-bold">
        <td colspan="2" class="py-2 px-3 text-dark text-uppercase small">Subtotal {{ $tahun_ajaran }}</td>
        <td class="text-end py-2 text-dark small">{{ formatAngka($sub_biaya) }}</td>
        <td class="text-end py-2 text-danger small">{{ formatAngka($sub_potongan) }}</td>
        <td class="text-end py-2 text-dark small">{{ formatAngka($sub_biaya_bersih) }}</td>
        <td class="text-end py-2 text-info small">{{ formatAngka($sub_mutasi) }}</td>
        <td class="text-end py-2 text-dark small">{{ formatAngka($sub_bayar) }}</td>
        <td class="text-end py-2 text-success small">{{ formatAngka($sub_sisa_tagihan) }}</td>
    </tr>
@endif
<tr style="background-color: #f8f9fa" class="border-top border-dark">
    <td colspan="2" class="fw-bold py-2 text-dark px-3">TOTAL</td>
    <td class="text-end fw-bold py-2 text-dark">{{ formatAngka($total_biaya) }}</td>
    <td class="text-end fw-bold py-2 text-danger">{{ formatAngka($total_potongan) }}</td>
    <td class="text-end fw-bold py-2 text-dark">{{ formatAngka($total_biaya_bersih) }}</td>
    <td class="text-end fw-bold py-2 text-info">{{ formatAngka($total_mutasi) }}</td>
    <td class="text-end fw-bold py-2 text-dark">{{ formatAngka($total_bayar) }}</td>
    <td class="text-end fw-bold py-2 text-success">{{ formatAngka($total_sisa_tagihan) }}</td>
</tr>
