<div class="row">
    <div class="col">
        <table class="table table-striped">
            <tr>
                <th>No. Bukti</th>
                <td class="text-end">{{ $historibayar->no_bukti }}</td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td class="text-end">{{ DateToIndo($historibayar->tanggal) }}</td>
            </tr>
            <tr>
                <th>Petugas</th>
                <td class="text-end">{{ $historibayar->name }}</td>
            </tr>
        </table>

    </div>
</div>
<div class="row">
    <div class="col">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>Jenis Biaya</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->jenis_biaya }} {{ in_array($d->kode_jenis_biaya, ['B07', 'B01']) ? $d->tahun_ajaran : '' }}</td>
                        <td class="text-end">{{ formatAngka($d->jumlah) }}</td>
                        <td>{{ $d->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
