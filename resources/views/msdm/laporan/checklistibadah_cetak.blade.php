<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkllist Ibadah {{ date('Y-m-d H:i:s') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
    <style>
        p {
            line-height: 1rem !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
</head>

<body>
    <div class="header" style="margin-bottom: 10px">
        <table>
            <tr>
                <td>
                    {{-- @if ($generalsetting->logo && Storage::exists('public/logo/' . $generalsetting->logo))
                        <img src="{{ asset('storage/logo/' . $generalsetting->logo) }}" alt="Logo Perusahaan"
                            style="max-width: 100px;">
                    @else
                        <img src="https://placehold.co/100x100?text=Logo" alt="Logo Default" style="max-width: 100px;">
                    @endif --}}
                    <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo Perusahaan"
                        style="max-width: 100px;">
                </td>
                <td>
                    <h4 style="line-height: 20px; margin-bottom: 5px">
                        LAPORAN CHECKLIST IBADAH
                        <br>
                        PESANTREN PERSIS AL AMIN 80 AL AMIN
                        <br>
                        SINDANGKASIH - CIAMIS
                        {{-- <br>
                        PERIODE {{ date('d-m-Y', strtotime($periode_dari)) }} -
                        {{ date('d-m-Y', strtotime($periode_sampai)) }} --}}
                    </h4>
                    <span style="font-style: italic;">
                        Jln. Raya Ancol No. 27 Sindangkasih - Ciamis
                    </span><br>
                    {{-- <span style="font-style: italic;">08123456789</span> --}}
                </td>
            </tr>
        </table>
    </div>
    <div class="content">
        <table class="datatable3" style="width: 200%">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">NPP</th>
                    <th rowspan="2">Nama Karyawan</th>
                    @foreach ($kegiatan->groupBy('kategori.kategori_ibadah') as $kategori => $daftarKegiatan)
                        <th colspan="{{ $daftarKegiatan->count() }}">{{ $kategori }}</th>
                    @endforeach
                </tr>
                <tr>
                    @foreach ($kegiatan as $k)
                        <th>{{ $k->nama_kegiatan }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($rekap as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data['npp'] }}</td>
                        <td>{{ $data['nama_lengkap'] }}</td>
                        @foreach ($kegiatan as $k)
                            <td style="text-align: center">{{ $data['data'][$k->id] ?? '' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
