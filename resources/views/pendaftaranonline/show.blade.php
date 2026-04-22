@php
    $namaSekolah = optional($pengaturan)->nama_sekolah ?? 'PESANTREN PERSATUAN ISLAM 80 AL AMIN SINDANGKASIH';
    $alamatSekolah = optional($pengaturan)->alamat_sekolah ?? 'Jln. Raya Ancol No. 27 Ancol I Sindangkasih';
    $teleponSekolah = optional($pengaturan)->telepon ?? '(0265) 325285';
    $emailSekolah = optional($pengaturan)->email ?? 'peris.alamin80sinkas@gmail.com';
    $websiteSekolah = optional($pengaturan)->website ?? 'persisalamin.com';
    $logoUrl = optional($pengaturan)->logo
        ? asset('storage/' . $pengaturan->logo)
        : asset('assets/img/logo/persisalamin.png');
@endphp
<div class="row">
    <div class="col-md-12 text-center">
        <img src="{{ $logoUrl }}" alt="Logo" style="height:80px; margin-bottom:8px;">
        <h5 class="m-0">PANITIA PENERIMAAN SANTRI BARU (PSB)</h5>
        <h5 class="m-0">{{ strtoupper($namaSekolah) }}</h5>
        <h5 class="m-0">TINGKAT {{ $pendaftaran->nama_unit }} TAHUN {{ $pendaftaran->tahun_ajaran }}</h5>
        <p>
            <i>
                {{ $alamatSekolah }}
                @if ($teleponSekolah)
                    Telp. {{ $teleponSekolah }}
                @endif
                e-mail : {{ $emailSekolah }}
                @if ($websiteSekolah)
                    - web : {{ $websiteSekolah }}
                @endif
            </i>
        </p>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-end">
        Nomor Pendaftaran : <span class="fw-bold">{{ $pendaftaran->no_register }}</span>
        <a href="{{ route('pendaftaranonline.cetak', Crypt::encrypt($pendaftaran->no_register)) }}" target="_blank"
            class="btn btn-primary btn-sm ms-2 shadow-sm" style="background-color: #064e3b; border-color: #064e3b">
            <i class="ti ti-printer me-1"></i>Cetak PDF
        </a>
    </div>
</div>
<style>
    .table-report td {
        border: none !important;
        padding: 2px 5px !important;
    }
</style>
<div class="row">
    <div class="col-12 mt-3 mb-2">
        <h6 class="fw-bold mb-0 p-2 text-white rounded-1" style="background-color: #064e3b">
            <i class="ti ti-user me-2"></i>A. DATA PESERTA DIDIK
        </h6>
    </div>
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
                <td>{{ textCamelCase($pendaftaran->tempat_lahir) }},
                    {{ $pendaftaran->tanggal_lahir ? DateToIndo($pendaftaran->tanggal_lahir) : '' }}
                </td>
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
<div class="row mt-3">
    <div class="col-12 mb-2">
        <h6 class="fw-bold mb-0 p-2 text-white rounded-1" style="background-color: #064e3b">
            <i class="ti ti-map-pin me-2"></i>B. ALAMAT
        </h6>
    </div>
    <div class="col">
        <table class="table table-report" style="width: auto !important; ">
            <tr>
                <td style="width: 1%">1.</td>
                <td style="width:30%">Kp/Jln.</td>
                <td style="width: 1%">:</td>
                <td style="width: 68%">{{ textCamelCase($pendaftaran->alamat) }}</td>
            </tr>
            <tr>
                <td style="width: 1%">2.</td>
                <td style="width:30%">Kelurahan</td>
                <td>:</td>
                <td>{{ textCamelCase($pendaftaran->desa) }}</td>
            </tr>
            <tr>
                <td style="width: 1%">3.</td>
                <td style="width:30%">Kecamatan</td>
                <td>:</td>
                <td>{{ textCamelCase($pendaftaran->kecamatan) }}</td>
            </tr>
            <tr>
                <td style="width: 1%">4.</td>
                <td style="width:30%">Kota</td>
                <td>:</td>
                <td>{{ textCamelCase($pendaftaran->kabupaten) }}</td>
            </tr>
            <tr>
                <td style="width: 1%">5.</td>
                <td style="width:30%">Provinsi</td>
                <td>:</td>
                <td>{{ textCamelCase($pendaftaran->provinsi) }}</td>
            </tr>

        </table>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12 mb-2">
        <h6 class="fw-bold mb-0 p-2 text-white rounded-1" style="background-color: #064e3b">
            <i class="ti ti-users me-2"></i>C. INFORMASI ORANG TUA
        </h6>
    </div>
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
{{-- <div class="row mt-3">
    <div class="col">
        <a href="{{ route('pendaftaran.cetak', Crypt::encrypt($pendaftaran->no_pendaftaran)) }}" target="_blank" class=" btn btn-primary w-100"><i
                class="ti ti-printer me-2"></i>Cetak Formulir Pendaftaran</a>
    </div>
</div> --}}

{{-- DATA PEMBAYARAN --}}
<div class="row mt-4">
    <div class="col">
        @if (!$pembayaran)
            <div class="alert alert-warning mt-2">Belum melakukan konfirmasi pembayaran.</div>
        @else
            <table class="table table-bordered mt-2" style="width: auto !important; max-width: 500px;">
                <tr>
                    <th style="width: 40%">Tanggal Pembayaran</th>
                    <td>{{ DateToIndo($pembayaran->tanggal_pembayaran ?? '-') }}</td>
                </tr>
                <tr>
                    <th>Jumlah Pembayaran</th>
                    <td>Rp {{ formatRupiah($pembayaran->jumlah_pembayaran) }}</td>
                </tr>
                <tr>
                    <th>Metode Pembayaran</th>
                    <td>{{ ucfirst($pembayaran->metode_pembayaran) }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if (!empty($pendaftaran->no_pendaftaran))
                            <span class="badge bg-success">
                                <i class="ti ti-checks me-1"></i>Sudah
                                Verifikasi</span>
                        @else
                            @if (!empty($pendaftaran->id_bayar))
                                <span class="badge bg-warning">Sudah Konfirmasi</span>
                            @else
                                <span class="badge bg-danger">Belum Konfirmasi</span>
                            @endif
                        @endif
                    </td>
                </tr>
                @if ($pembayaran->bukti_pembayaran)
                    <tr>
                        <th>Bukti Pembayaran</th>
                        <td><a href="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" target="_blank">Lihat
                                Bukti</a></td>
                    </tr>
                @endif
                @if ($pembayaran->keterangan)
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $pembayaran->keterangan }}</td>
                    </tr>
                @endif
            </table>
        @endif
    </div>
</div>

{{-- FORM KONFIRMASI PEMBAYARAN ADMIN --}}

@if (!empty($pendaftaran->id_bayar))
    @if (empty($pendaftaran->no_pendaftaran))
        <div class="row mt-4">
            <div class="col">
                <form action="{{ route('pendaftaranonline.konfirmasi', Crypt::encrypt($pendaftaran->no_register)) }}"
                    method="POST">
                    @csrf
                    <div class="row g-2">
                        <div class="col-6">
                            <button type="submit" name="status" value="1" class="btn btn-success w-100">
                                <i class="ti ti-check me-1"></i>Diterima
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="submit" name="status" value="2" class="btn btn-danger w-100">
                                <i class="ti ti-x me-1"></i>Ditolak
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="row mt-4">
            <div class="col">
                <form action="{{ route('pendaftaranonline.cancel', Crypt::encrypt($pendaftaran->no_register)) }}"
                    method="POST">
                    @csrf
                    <div class="row g-2">
                        <div class="col">
                            <button type="submit" name="status" value="1" class="btn btn-danger w-100">
                                <i class="ti ti-square-rounded-x me-1"></i>Batalkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

@endif



<script>
    $(function() {

        function loadDokumen() {
            const no_pendaftaran = '{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}';
            $("#loaddokumen").load(`/pendaftaran/${no_pendaftaran}/getdokumen`);
        }

        loadDokumen();
        $('#uploadDokumen').on('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);
            $("#loaddokumen").html(`<tr><td colspan="3">Loading...</td></tr>`);
            $.ajax({
                url: "{{ url('/pendaftaran/uploaddokumen') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        title: "Success!",
                        text: "Upload Dokumen Persyaratan Berhasil",
                        icon: "success",
                        showConfirmButton: true,
                        didClose: (e) => {
                            $('#uploadDokumen')[0].reset();
                            loadDokumen();
                        },
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = "";

                        $.each(errors, function(key, value) {
                            errorMessages += value[0];
                        });

                        Swal.fire({
                            title: "Error!",
                            html: errorMessages,
                            icon: "error",
                            showConfirmButton: true,
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error",
                            showConfirmButton: true,
                        });
                    }
                    loadDokumen();
                }
            });
        });

        $('body').on('click', '.deletedokumen', function(e) {
            var no_pendaftaran = $(this).attr('no_pendaftaran');
            var kode_dokumen = $(this).attr('kode_dokumen');
            event.preventDefault();
            Swal.fire({
                title: `Apakah Anda Yakin Ingin Menghapus Data Ini ?`,
                text: "Jika dihapus maka data akan hilang permanent.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: "#554bbb",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Hapus Saja!"
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "/pendaftaran/deletedokumen",
                        data: {
                            _token: "{{ csrf_token() }}",
                            no_pendaftaran: no_pendaftaran,
                            kode_dokumen: kode_dokumen
                        },
                        cache: false,
                        success: function(response) {
                            Swal.fire({
                                title: "Success!",
                                text: "Dokumen Berhasil Dihapus",
                                icon: "success",
                                showConfirmButton: true,
                                didClose: (e) => {
                                    $('#uploadDokumen')[0].reset();
                                    loadDokumen();
                                },
                            });
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                let errorMessages = "";

                                $.each(errors, function(key, value) {
                                    errorMessages += value[0];
                                });

                                Swal.fire({
                                    title: "Error!",
                                    html: errorMessages,
                                    icon: "error",
                                    showConfirmButton: true,
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: xhr.responseJSON.message,
                                    icon: "error",
                                    showConfirmButton: true,
                                });
                            }
                            loadDokumen();
                        }
                    });
                }
            });
        });
    });
</script>
