<div class="row">
    <div class="col-md-12 text-center">
        <h5 class="m-0">PANITIA PENERIMAAN SANTRI BARU (PSB)</h5>
        <h5 class="m-0">PESANTREN PERSATUAN ISLAM 80 AL AMIN SINDANGKASIH</h5>
        <h5 class="m-0">TINGKAT {{ $pendaftaran->nama_unit }} TAHUN {{ $pendaftaran->tahun_ajaran }}</h5>
        <p>
            <i>
                Jln. Raya Ancol No. 27 Ancol I Sindangkasih Telp.-Fax. (0265) 325285 Ciamis 46268 e-mail :
                peris.alamin80sinkas@gmail.com - web :
                persisalamin.com
            </i>
        </p>
        <a href="{{ route('pendaftaran.cetakpdf', Crypt::encrypt($pendaftaran->no_pendaftaran)) }}" target="_blank" class="btn btn-danger mt-2">
            <i class="ti ti-printer"></i> Cetak PDF
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-end">
        Nomor Pendaftaran : <span class="fw-bold">{{ $pendaftaran->no_pendaftaran }}</span>
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
                <td>{{ textCamelCase($pendaftaran->kota) }}</td>
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
{{-- <div class="row mt-3">
    <div class="col">
        <a href="{{ route('pendaftaran.cetak', Crypt::encrypt($pendaftaran->no_pendaftaran)) }}" target="_blank" class=" btn btn-primary w-100"><i
                class="ti ti-printer me-2"></i>Cetak Formulir Pendaftaran</a>
    </div>
</div> --}}
<form action="#" id="uploadDokumen" enctype="multipart/form-data" method="POST">

    <div class="row mt-3">
        <h5 class="m-0 mb-3">D. DOKUMEN PERSYARATAN</h5>

        @csrf
        <input type="hidden" name="no_pendaftaran" value="{{ $pendaftaran->no_pendaftaran }}">
        <div class="col-lg-4">
            <div class="form-group mb-3">
                <select name="kode_dokumen" id="kode_dokumen" class="form-select">
                    <option value="">Jenis Dokumen</option>
                    @foreach ($jenisdokumenpendaftaran as $d)
                        <option value="{{ $d->kode_dokumen }}">{{ $d->jenis_dokumen }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <x-input-file label="File" name="file" />
        </div>
        <div class="col-lg-2">
            <button class="btn btn-primary" type="submit"><i class="ti ti-upload"></i></button>
        </div>

    </div>
</form>
<div class="row mt-2">
    <div class="col">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>Jenis Dokumen</th>
                    <th>File</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody id="loaddokumen"></tbody>
        </table>
    </div>
</div>
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
