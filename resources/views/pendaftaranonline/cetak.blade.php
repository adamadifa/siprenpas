<div style="text-align:center; margin-bottom: 10px;">
    <img src="{{ public_path('assets/img/logo/persisalamin.png') }}" alt="Logo"
        style="height:70px; margin-bottom:8px;">
    <div style="font-size:1.1rem; font-weight:bold;">PANITIA PENERIMAAN SANTRI BARU (PSB)</div>
    <div style="font-size:1.1rem; font-weight:bold;">PESANTREN PERSATUAN ISLAM 80 AL AMIN SINDANGKASIH</div>
    <div style="font-size:1.1rem; font-weight:bold;">TINGKAT {{ $pendaftaran->nama_unit }} TAHUN
        {{ $pendaftaran->tahun_ajaran }}</div>
    <div style="font-size:0.95rem; font-style:italic; margin-top:2px;">
        Jln. Raya Ancol No. 27 Ancol I Sindangkasih Telp.-Fax. (0265) 325285 Ciamis 46268<br>
        e-mail : peris.alamin80sinkas@gmail.com - web : persisalamin.com
    </div>
    <hr style="border:1.5px solid #000; margin:10px 0 15px 0;">
</div>
<div class="row">
    <div class="col-md-12 text-end">
        Nomor Pendaftaran : <span class="fw-bold">{{ $pendaftaran->no_register }}</span>
    </div>
</div>
<style>
    .table-report td {
        border: none !important;
        padding: 2px 5px !important;
    }
</style>
<div class="row">
    <h5 class="m-0">A. DATA PESERTA DIDK</h5>
    <div class="col">
        <table class="table table-report" style="width: auto !important; ">
            <tr>
                <td style="width: 1%">1.</td>
                <td style="width:30%">NISN</td>
                <td style="width: 1%">:</td>
                <td style="width: 68%">{{ $pendaftaran->nisn }}</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td>{{ $pendaftaran->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Tempat / Tanggal Lahir</td>
                <td>:</td>
                <td>{{ textCamelCase($pendaftaran->tempat_lahir) }}, {{ DateToIndo($pendaftaran->tanggal_lahir) }}</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>AnakKe</td>
                <td>:</td>
                <td>{{ $pendaftaran->anak_ke }}</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Jumlah Saudara</td>
                <td>:</td>
                <td>{{ $pendaftaran->jumlah_saudara }}</td>
            </tr>
        </table>
    </div>
</div>
<div class="row mt-2">
    <h5 class="m-0">B. ALAMAT</h5>
    <div class="col">
        <table class="table table-report" style="width: auto !important; ">
            <tr>
                <td style="width: 1%">1.</td>
                <td style="width:30%">Kp/Jln.</td>
                <td style="width: 1%">:</td>
                <td style="width: 68%">{{ textCamelCase($pendaftaran->alamat) }}</td>
            </tr>

        </table>
    </div>
</div>
<div class="row mt-2">
    <h5 class="m-0">C. INFORMASI ORANG TUA</h5>
    <div class="col">
        <table class="table table-report" style="width: auto !important; ">
            <tr>
                <td style="width: 1%">1.</td>
                <td style="width:30%">NIK Ayah</td>
                <td style="1%">:</td>
                <td style="width:68%">{{ textCamelCase($pendaftaran->nik_ayah) }}</td>
            </tr>
            <tr>
                <td style="width: 1%">2.</td>
                <td style="width:30%">Nama Ayah</td>
                <td>:</td>
                <td>{{ textCamelCase($pendaftaran->nama_ayah) }}</td>
            </tr>
            <tr>
                <td style="width: 1%">3.</td>
                <td style="width:30%">Pendidikan Ayah</td>
                <td>:</td>
                <td>{{ textCamelCase($pendaftaran->pendidikan_ayah) }}</td>
            </tr>
            <tr>
                <td style="width: 1%">4.</td>
                <td style="width:30%">Pekerjaan Ayah</td>
                <td>:</td>
                <td>{{ textCamelCase($pendaftaran->pekerjaan_ayah) }}</td>
            </tr>
            <tr>
                <td style="width: 1%">5.</td>
                <td style="width:30%">NIK Ibu</td>
                <td>:</td>
                <td>{{ textCamelCase($pendaftaran->nik_ibu) }}</td>
            </tr>
            <tr>
                <td style="width: 1%">6.</td>
                <td style="width:30%">Nama Ibu</td>
                <td>:</td>
                <td>{{ textCamelCase($pendaftaran->nama_ibu) }}</td>
            </tr>
            <tr>
                <td style="width: 1%">7.</td>
                <td style="width:30%">Pendidikan Ibu</td>
                <td>:</td>
                <td>{{ textCamelCase($pendaftaran->pendidikan_ibu) }}</td>
            </tr>
            <tr>
                <td style="width: 1%">8.</td>
                <td style="width:30%">Pekerjaan Ibu</td>
                <td>:</td>
                <td>{{ textCamelCase($pendaftaran->pekerjaan_ibu) }}</td>
            </tr>
        </table>
    </div>
</div>
