<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Presensi {{ date('Y-m-d H:i:s') }}</title>
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
    @php
        $namaSekolah = optional($pengaturan)->nama_sekolah ?? 'PESANTREN PERSIS 80 AL AMIN';
        $alamatSekolah = optional($pengaturan)->alamat_sekolah ?? 'Jln. Raya Ancol No. 27 Sindangkasih - Ciamis';
        $teleponSekolah = optional($pengaturan)->telepon ?? '(0265) 325285';
        $emailSekolah = optional($pengaturan)->email ?? 'peris.alamin80sinkas@gmail.com';
        $websiteSekolah = optional($pengaturan)->website ?? 'persisalamin.com';
        $logoUrl = optional($pengaturan)->logo ? asset('storage/' . $pengaturan->logo) : asset('assets/img/logo/persisalamin.png');
    @endphp
    <div class="header" style="margin-bottom: 10px">
        <table>
            <tr>
                <td>
                    <img src="{{ $logoUrl }}" alt="Logo Perusahaan" style="max-width: 100px;">
                </td>
                <td>
                    <h4 style="line-height: 20px; margin-bottom: 5px">
                        REKAP TAGIHAN SANTRI
                        <br>
                        {{ strtoupper($namaSekolah) }}
                        <br>
                        SINDANGKASIH - CIAMIS
                        <br>
                    </h4>
                    <span style="font-style: italic;">
                        {{ $alamatSekolah }}
                        @if ($teleponSekolah)
                            | Telp. {{ $teleponSekolah }}
                        @endif
                    </span><br>
                    <span style="font-style: italic;">
                        e-mail : {{ $emailSekolah }}
                        @if ($websiteSekolah)
                            | web : {{ $websiteSekolah }}
                        @endif
                    </span>
                </td>
            </tr>
        </table>
    </div>
    <div class="content">
        <table class="datatable3" style="width:200% !important">
            <thead>
                <tr>
                    <th rowspan="3">No.</th>
                    <th rowspan="3">NIS</th>
                    <th rowspan="3">Nama Lengkap</th>
                    <th colspan="{{ count($biaya) * 5 }}">Tagihan</th>
                    <th rowspan="2" colspan="5">TOTAL</th>
                </tr>


                <tr>
                    @foreach ($biaya as $b)
                        <th colspan="5">{{ $b->jenis_biaya }}</th>
                    @endforeach
                </tr>
                <tr>
                    @foreach ($biaya as $b)
                        <th>Tagihan</th>
                        <th>Potongan</th>
                        <th>Mutasi</th>
                        <th>Bayar</th>
                        <th>Sisa</th>
                    @endforeach
                    <th>Tagihan</th>
                    <th>Potongan</th>
                    <th>Mutasi</th>
                    <th>Bayar</th>
                    <th>Sisa</th>
                </tr>

            </thead>
            <tbody>
                @foreach ($biaya as $b)
                    @php
                        ${'total_tagihan_' . $b->kode_jenis_biaya} = 0;
                        ${'total_potongan_' . $b->kode_jenis_biaya} = 0;
                        ${'total_mutasi_' . $b->kode_jenis_biaya} = 0;
                        ${'total_bayar_' . $b->kode_jenis_biaya} = 0;
                        ${'total_sisa_' . $b->kode_jenis_biaya} = 0;
                    @endphp
                @endforeach
                @foreach ($rekaptagihan as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->nis }}</td>
                        <td>{{ $d->nama_lengkap }}</td>
                        @php
                            $total_tagihan = 0;
                            $total_potongan = 0;
                            $total_mutasi = 0;
                            $total_bayar = 0;
                            $total_sisa = 0;
                        @endphp
                        @foreach ($biaya as $b)
                            @php
                                ${'total_tagihan_' . $b->kode_jenis_biaya} += $d->{'jumlah_' . $b->kode_jenis_biaya};
                                ${'total_potongan_' . $b->kode_jenis_biaya} +=
                                    $d->{'jumlah_potongan_' . $b->kode_jenis_biaya};
                                ${'total_mutasi_' . $b->kode_jenis_biaya} +=
                                    $d->{'jumlah_mutasi_' . $b->kode_jenis_biaya};
                                ${'total_bayar_' . $b->kode_jenis_biaya} +=
                                    $d->{'jumlah_bayar_' . $b->kode_jenis_biaya};
                                $sisa_tagihan =
                                    $d->{'jumlah_' . $b->kode_jenis_biaya} -
                                    $d->{'jumlah_potongan_' . $b->kode_jenis_biaya} -
                                    $d->{'jumlah_mutasi_' . $b->kode_jenis_biaya} -
                                    $d->{'jumlah_bayar_' . $b->kode_jenis_biaya};
                                ${'total_sisa_' . $b->kode_jenis_biaya} += $sisa_tagihan;

                                $total_tagihan += $d->{'jumlah_' . $b->kode_jenis_biaya};
                                $total_potongan += $d->{'jumlah_potongan_' . $b->kode_jenis_biaya};
                                $total_mutasi += $d->{'jumlah_mutasi_' . $b->kode_jenis_biaya};
                                $total_bayar += $d->{'jumlah_bayar_' . $b->kode_jenis_biaya};
                                $total_sisa += $sisa_tagihan;
                            @endphp
                            <td style="text-align: right">
                                {{ formatAngka($d->{'jumlah_' . $b->kode_jenis_biaya}) }}
                            </td>
                            <td style="text-align: right">
                                {{ formatAngka($d->{'jumlah_potongan_' . $b->kode_jenis_biaya}) }}
                            </td>
                            <td style="text-align: right">
                                {{ formatAngka($d->{'jumlah_mutasi_' . $b->kode_jenis_biaya}) }}
                            </td>
                            <td style="text-align: right">
                                {{ formatAngka($d->{'jumlah_bayar_' . $b->kode_jenis_biaya}) }}
                            </td>
                            <td style="text-align: right">
                                {{ formatAngka($sisa_tagihan) }}
                            </td>
                        @endforeach
                        <td style="text-align: right">
                            {{ formatAngka($total_tagihan) }}
                        </td>
                        <td style="text-align: right">
                            {{ formatAngka($total_potongan) }}
                        </td>
                        <td style="text-align: right">
                            {{ formatAngka($total_mutasi) }}
                        </td>
                        <td style="text-align: right">
                            {{ formatAngka($total_bayar) }}
                        </td>
                        <td style="text-align: right">
                            {{ formatAngka($total_sisa) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">TOTAL</th>
                    @php
                        $grandtotal_tagihan = 0;
                        $grandtotal_potongan = 0;
                        $grandtotal_mutasi = 0;
                        $grandtotal_bayar = 0;
                        $grandtotal_sisa = 0;
                    @endphp
                    @foreach ($biaya as $b)
                        @php
                            $grandtotal_tagihan += ${'total_tagihan_' . $b->kode_jenis_biaya};
                            $grandtotal_potongan += ${'total_potongan_' . $b->kode_jenis_biaya};
                            $grandtotal_mutasi += ${'total_mutasi_' . $b->kode_jenis_biaya};
                            $grandtotal_bayar += ${'total_bayar_' . $b->kode_jenis_biaya};
                            $grandtotal_sisa += ${'total_sisa_' . $b->kode_jenis_biaya};
                        @endphp
                        <th style="text-align: right">
                            {{ formatAngka(${'total_tagihan_' . $b->kode_jenis_biaya}) }}
                        </th>
                        <th style="text-align: right">
                            {{ formatAngka(${'total_potongan_' . $b->kode_jenis_biaya}) }}
                        </th>
                        <th style="text-align: right">
                            {{ formatAngka(${'total_mutasi_' . $b->kode_jenis_biaya}) }}
                        </th>
                        <th style="text-align: right">
                            {{ formatAngka(${'total_bayar_' . $b->kode_jenis_biaya}) }}
                        </th>
                        <th style="text-align: right">
                            {{ formatAngka(${'total_sisa_' . $b->kode_jenis_biaya}) }}
                        </th>
                    @endforeach
                    <th style="text-align: right">
                        {{ formatAngka($grandtotal_tagihan) }}
                    </th>
                    <th style="text-align: right">
                        {{ formatAngka($grandtotal_potongan) }}
                    </th>
                    <th style="text-align: right">
                        {{ formatAngka($grandtotal_mutasi) }}
                    </th>
                    <th style="text-align: right">
                        {{ formatAngka($grandtotal_bayar) }}
                    </th>
                    <th style="text-align: right">
                        {{ formatAngka($grandtotal_sisa) }}
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
