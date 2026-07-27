@foreach ($historibayar as $d)
    <tr class="align-middle">
        <td class="py-2">{{ $d->no_bukti }}</td>
        <td class="py-2">{{ DateToIndo($d->tanggal) }}</td>
        <td class="text-end py-2 fw-bold">{{ formatAngka($d->jumlah) }}</td>
        <td class="py-2 small">{{ $d->keterangan }}</td>
        <td class="py-2 small">{{ $d->name }}</td>
        <td class="py-2">
            <div class="d-flex justify-content-center gap-1">
                <a href="#" class="btn btn-icon btn-sm btn-label-info border shadow-none btnDetailbayar" 
                    no_bukti="{{ Crypt::encrypt($d->no_bukti) }}" title="Detail">
                    <i class="ti ti-file-description fs-6"></i>
                </a>
                <a href="{{ route('pembayaranpendidikan.cetak', Crypt::encrypt($d->no_bukti)) }}" 
                    class="btn btn-icon btn-sm btn-label-success border shadow-none btnPrint" 
                    target="_blank" title="Cetak Kwitansi">
                    <i class="ti ti-printer fs-6"></i>
                </a>
                <a href="#" class="btn btn-icon btn-sm btn-label-danger border shadow-none btnDeletebayar" 
                    key="{{ Crypt::encrypt($d->no_bukti) }}" title="Hapus Pembayaran">
                    <i class="ti ti-trash fs-6"></i>
                </a>
            </div>
        </td>
    </tr>
@endforeach
