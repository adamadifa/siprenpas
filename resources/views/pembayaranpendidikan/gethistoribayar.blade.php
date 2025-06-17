@foreach ($historibayar as $d)
    <tr>
        <td>{{ $d->no_bukti }}</td>
        <td>{{ DateToIndo($d->tanggal) }}</td>
        <td class="text-end">{{ formatAngka($d->jumlah) }}</td>
        <td>{{ $d->keterangan }}</td>
        <td>{{ $d->name }}</td>
        <td>
            <div class="d-flex">
                <a href="#" class="btnDetailbayar me-1" no_bukti="{{ Crypt::encrypt($d->no_bukti) }}">
                    <i class="ti ti-file-description text-info"></i>
                </a>
                <a href="{{ route('pembayaranpendidikan.cetak', Crypt::encrypt($d->no_bukti)) }}" class="btnPrint me-1" target="_blank"><i class="ti ti-printer text-success"></i></a>
                @if ($loop->iteration == 1)
                    <a href="#" class="btnDeletebayar" key="{{ Crypt::encrypt($d->no_bukti) }}"><i class="ti ti-trash text-danger"></i></a>
                @endif

            </div>
        </td>
    </tr>
@endforeach
