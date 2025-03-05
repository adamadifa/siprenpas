<form action="{{ route('anggota.store') }}" aria-autocomplete="false" id="formAnggota" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="divider text-start">
                <div class="divider-text">
                    <i class="ti ti-user"></i> Data Anggota
                </div>
            </div>
            <x-input-with-icon icon="ti ti-barcode" label="Auto" name="no_anggota" disabled />
            <x-input-with-icon-label icon="ti ti-credit-card" label="Nomor Identitas" name="nik" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Anggota" name="nama_lengkap" />
            <x-input-with-icon-label icon="ti ti-map-pin" label="Tempat Lahir" name="tempat_lahir" />
            <x-input-with-icon-label icon="ti ti-calendar" label="Tanggal Lahir" name="tanggal_lahir" datepicker="flatpickr-date" />
            <div class="form-group mb-3">
                <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                    <option value="">Jenis Kelamin</option>
                    <option value="L">Laki - Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Pendidikan Terakhir</label>
                <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-select">
                    <option value="">Pendidikan Terakhir</option>
                    @foreach ($pendidikan as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Status Pernikahan</label>
                <select name="status_pernikahan" id="status_pernikahan" class="form-select">
                    <option value="">Status Pernikahan</option>
                    <option value="M">Menikah</option>
                    <option value="BM">Belum Menikah</option>
                    <option value="JD">Janda/Duda</option>
                </select>
            </div>
            <x-input-with-icon-label icon="ti ti-users" label="Jumlah Tanggungan" name="jml_tanggungan" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Pasangan" name="nama_pasangan" />
            <x-input-with-icon-label icon="ti ti-briefcase" label="Pekerjaan Pasangan" name="pekerjaan_pasangan" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Ibu" name="nama_ibu" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Saudara" name="nama_saudara" />
            <x-input-with-icon-label icon="ti ti-user" label="No. HP" name="no_hp" />

        </div>
        <div class="col-lg-1">
            <div class="divider divider-vertical">
                <div class="divider-text">
                    <i class="ti ti-crown"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-12 col-sm-12">
            <div class="divider text-start">
                <div class="divider-text">
                    <i class="ti ti-map-pin"></i> Data Alamat
                </div>
            </div>
            <x-textarea-label name="alamat" label="Alamat" />
            <x-select-label label="Provinsi" name="id_province" :data="$provinsi" key="id" textShow="name" select2="select2Provinsi"
                upperCase="true" />
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Kabupaten / Kota</label>
                <select name="id_regency" id="id_regency" class="select2Regency form-select">
                </select>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Kecamatan</label>
                <select name="id_district" id="id_district" class="select2District form-select">
                </select>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Desa / Kelurahan</label>
                <select name="id_village" id="id_village" class="select2Village form-select">
                </select>
            </div>
            <x-input-with-icon-label icon="ti ti-barcode" label="Kode Pos" name="kode_pos" />
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Status Tinggal</label>
                <select name="status_tinggal" id="status_tinggal" class="form-select">
                    <option value="">Status Tinggal</option>
                    <option value="MS">Milik Sendiri</option>
                    <option value="MK">Milik Keluarga</option>
                    <option value="SK">Sewa / Kontrak</option>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary w-100" id="btnSimpan" type="submit">
                    <ion-icon name="send-outline" class="me-1"></ion-icon>
                    Submit
                </button>
            </div>
        </div>
    </div>

</form>

<script>
    $(function() {
        $('.flatpickr-date').flatpickr();
        const formAnggota = $('#formAnggota');

        formAnggota.submit(function(e) {
            let nama_lengkap = $(this).find('input[name="nama_lengkap"]').val();
            let nik = $(this).find('input[name="nik"]').val();
            let tempat_lahir = $(this).find('input[name="tempat_lahir"]').val();
            let tanggal_lahir = $(this).find('input[name="tanggal_lahir"]').val();
            let jenis_kelamin = $(this).find('select[name="jenis_kelamin"]').val();
            let pendidikan_terakhir = $(this).find('select[name="pendidikan_terakhir"]').val();
            let status_pernikahan = $(this).find('select[name="status_pernikahan"]').val();
            let jml_tanggungan = $(this).find('input[name="jml_tanggungan"]').val();
            let nama_pasangan = $(this).find('input[name="nama_pasangan"]').val();
            let pekerjaan_pasangan = $(this).find('input[name="pekerjaan_pasangan"]').val();
            let nama_ibu = $(this).find('input[name="nama_ibu"]').val();
            let nama_saudara = $(this).find('input[name="nama_saudara"]').val();
            let no_hp = $(this).find('input[name="no_hp"]').val();
            let alamat = $(this).find('textarea[name="alamat"]').val();
            let id_province = $(this).find('select[name="id_province"]').val();
            let id_regency = $(this).find('select[name="id_regency"]').val();
            let id_district = $(this).find('select[name="id_district"]').val();
            let id_village = $(this).find('select[name="id_village"]').val();
            let status_tinggal = $(this).find('select[name="status_tinggal"]').val();
            let kode_pos = $(this).find('input[name="kode_pos"]').val();
            if (nama_lengkap == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Lengkap tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#nama_lengkap").focus();
                    }
                });
                return false;
            } else if (nik == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'NIK tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#nik").focus();
                    }
                });
                return false;
            } else if (tempat_lahir == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tempat Lahir tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#tempat_lahir").focus();
                    }
                });
                return false;
            } else if (tanggal_lahir == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal Lahir tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#tanggal_lahir").focus();
                    }
                });
                return false;
            } else if (jenis_kelamin == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jenis Kelamin tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#jenis_kelamin").focus();
                    }
                });
                return false;
            } else if (pendidikan_terakhir == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Pendidikan Terakhir tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#pendidikan_terakhir").focus();
                    }
                });
                return false;
            } else if (status_pernikahan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Status Pernikahan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#status_pernikahan").focus();
                    }
                });
                return false;
            } else if (jml_tanggungan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah Tanggungan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#jml_tanggungan").focus();
                    }
                });
                return false;
            } else if (nama_pasangan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Pasangan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#nama_pasangan").focus();
                    }
                });
                return false;
            } else if (pekerjaan_pasangan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Pekerjaan Pasangan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#pekerjaan_pasangan").focus();
                    }
                });
                return false;
            } else if (nama_ibu == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Ibu tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#nama_ibu").focus();
                    }
                });
                return false;
            } else if (nama_saudara == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Saudara tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#nama_saudara").focus();
                    }
                });
                return false;
            } else if (no_hp == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'No. HP tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#no_hp").focus();
                    }
                });
                return false;
            } else if (alamat == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Alamat tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#alamat").focus();
                    }
                });
                return false;
            } else if (id_province == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Provinsi tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#id_province").focus();
                    }
                });
                return false;
            } else if (id_regency == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kabupaten / Kota tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#id_regency").focus();
                    }
                });
                return false;
            } else if (id_district == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kecamatan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#id_district").focus();
                    }
                });
                return false;
            } else if (id_village == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Desa / Kelurahan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#id_village").focus();
                    }
                });
                return false;
            } else if (status_tinggal == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Status Tinggal tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#status_tinggal").focus();
                    }
                });
                return false;
            } else if (kode_pos == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kode Pos tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#kode_pos").focus();
                    }
                });
                return false;
            } else {
                $(this).find('button[type="submit"]').attr('disabled', 'disabled');
                $(this).find('button[type="submit"]').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                )
            }

        });
        const select2Provinsi = $('.select2Provinsi');
        if (select2Provinsi.length) {
            select2Provinsi.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Provinsi',
                    dropdownParent: $this.parent(),
                    allowClear: true
                });
            });
        }

        const select2Regency = $('.select2Regency');
        if (select2Regency.length) {
            select2Regency.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Kabupaten / Kota',
                    dropdownParent: $this.parent(),
                    allowClear: true
                });
            });
        }

        const select2District = $('.select2District');
        if (select2District.length) {
            select2District.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Kecamatan',
                    dropdownParent: $this.parent(),
                    allowClear: true
                });
            });
        }

        const select2Village = $('.select2Village');
        if (select2Village.length) {
            select2Village.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Desa / Kelurahan',
                    dropdownParent: $this.parent(),
                    allowClear: true
                });
            });
        }

        function getRegency() {
            var id_province = $("#formAnggota").find("#id_province").val();
            $.ajax({
                type: 'POST',
                url: '/regency/getregencybyprovince',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_province: id_province,
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    $("#formAnggota").find("#id_regency").html(respond);
                }
            });
        }

        function getDistrict() {
            var id_regency = $("#formAnggota").find("#id_regency").val();
            $.ajax({
                type: 'POST',
                url: '/district/getdistrictbyregency',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_regency: id_regency,
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    $("#formAnggota").find("#id_district").html(respond);
                }
            });
        }

        function getVillage() {
            var id_district = $("#formAnggota").find("#id_district").val();
            $.ajax({
                type: 'POST',
                url: '/village/getvillagebydistrict',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_district: id_district,
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    $("#formAnggota").find("#id_village").html(respond);
                }
            });
        }

        getRegency();
        getDistrict();
        getVillage();

        $("#id_province").change(function() {
            getRegency();
        });

        $("#id_regency").change(function() {
            getDistrict();
        });

        $("#id_district").change(function() {
            getVillage();
        });


    });
</script>
