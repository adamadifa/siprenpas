<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .bukti-pembayaran {
                page-break-inside: avoid;
                border: 1px solid #ccc;
                margin-bottom: 20px;
            }
        }

        body {
            font-size: 14px;
        }

        .bukti-pembayaran {
            padding: 20px;
            margin-bottom: 30px;
        }

        .bordered-table th,
        .bordered-table td {
            border: 1px solid #dee2e6;
            padding: 5px;
        }

        .bordered-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        .judul {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body class="container py-4">

    <!-- BUKTI 1 -->
    <div class="bukti-pembayaran">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <div class="judul">BUKTI PEMBAYARAN</div>
                <div>Pesantren Persis 80 Al-Amin Sindangkasih</div>
                <small>Jl. Raya Ancol No. 27 Sindangkasih Ciamis</small>
            </div>
            <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo" height="60">
        </div>

        <div class="row mb-2">
            <div class="col-6">
                <p><strong>Nama:</strong> {{ $historibayar->nama_lengkap }}</p>
                <p><strong>NIS:</strong> {{ $historibayar->nis }}</p>
                <p><strong>Kelas:</strong> {{ $historibayar->kelas }}</p>
            </div>
            <div class="col-6 text-end">
                <p><strong>Tanggal:</strong> {{ DateToIndo($historibayar->tanggal) }}</p>
                <p><strong>No. Bukti:</strong> {{ $historibayar->no_bukti }}</p>
            </div>
        </div>

        <table class="bordered-table">
            <thead class="table-light">
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
                        <td>{{ $d->jenis_biaya }}
                            {{ in_array($d->kode_jenis_biaya, ['B07', 'B01']) ? $d->tahun_ajaran : '' }}</td>
                        <td class="text-end">{{ formatAngka($d->jumlah) }}</td>
                        <td>{{ $d->keterangan }}</td>
                    </tr>
                @endforeach
                {{-- <tr>
          <th class="text-end">Total</th>
          <th class="text-end">Rp{{ formatAngka($historibayar->total) }}</th>
        </tr> --}}
            </tbody>
        </table>

        <div class="row mt-4">
            <div class="col-7">
                <p><strong>Keterangan:</strong></p>
                <p>Pembayaran dilakukan secara tunai kepada bendahara sekolah.</p>
            </div>
            <div class="col-5 text-end">
                <p>Sindangkasih, {{ DateToIndo($historibayar->tanggal) }}</p>
                <div style="margin-top: 60px;">({{ $historibayar->name }})</div>
            </div>
        </div>
    </div>


</body>

</html>
