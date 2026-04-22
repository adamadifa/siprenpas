<form action="{{ route('pendaftaran.store') }}" aria-autocomplete="false" id="formPendaftaran" method="POST">
    <input type="hidden" id="id_siswa" name="id_siswa">
    @csrf
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="divider text-start">
                <div class="divider-text">
                    <i class="ti ti-user"></i> Data Pendaftaran
                </div>
            </div>
            <x-input-with-icon icon="ti ti-barcode" label="Auto" name="no_pendaftaran" />
            <x-input-with-icon icon="ti ti-calendar" label="Tanggal Pendaftaran" name="tanggal_pendaftaran"
                datepicker="flatpickr-date" />
            <x-select label="Jenjang / Tingkat" name="kode_unit" :data="$unit" key="kode_unit" textShow="nama_unit"
                select2="select2Kodeunit" upperCase="true" />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="divider text-start">
                <div class="divider-text">
                    <i class="ti ti-user"></i> Data Siswa
                </div>
            </div>
            <x-input-with-icon-label icon="ti ti-barcode" label="NISN" name="nisn" />
            <div class="row">
                <div class="col-lg-10 col-sm-12 col-md-12">
                    <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap" name="nama_lengkap" />
                </div>
                <div class="col-lg-2 col-sm-12 col-md-12">
                    <div class="form-group mb-3">
                        <a href="#" class="btn btn-primary w-100 mt-4" id="btnCarisiswa"><i
                                class="ti ti-search"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                    <option value="">Jenis Kelamin</option>
                    <option value="L">Laki - Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <x-input-with-icon-label icon="ti ti-map-pin" label="Tempat Lahir" name="tempat_lahir" />
            <x-input-with-icon-label icon="ti ti-calendar" label="Tanggal Lahir" name="tanggal_lahir"
                datepicker="flatpickr-date" />
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <x-input-with-icon-label icon="ti ti-user" label="Anak Ke" name="anak_ke" />
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <x-input-with-icon-label icon="ti ti-users" label="Jumlah Saudara" name="jumlah_saudara" />
                </div>
            </div>
            <x-textarea-label name="alamat" label="Alamat" />
            <x-select-label label="Provinsi" name="id_province" :data="$provinsi" key="id" textShow="name"
                select2="select2Provinsi" upperCase="true" />
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
                    <i class="ti ti-building-skyscraper"></i> Data Asal Sekolah
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 col-sm-12 col-md-12">
                    <div class="form-group mb-3">
                        <select name="kode_asal_sekolah" class="form-select select2Kodeasalsekolah"
                            id="kode_asal_sekolah">
                            <option value="">Asal Sekolah</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-12 col-md-12">
                    <div class="form-group mb-3">
                        <a href="#" class="btn btn-primary w-100" id="btnTambahsekolah"><i
                                class="ti ti-plus"></i></a>
                    </div>
                </div>
            </div>
            <x-input-with-icon-label icon="ti ti-barcode" label="No. KK" name="no_kk" />
            <x-input-with-icon-label icon="ti ti-credit-card" label="NIK. Ayah" name="nik_ayah" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap Ayah" name="nama_ayah" />
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Pendidikan Ayah</label>
                <select name="pendidikan_ayah" id="pendidikan_ayah" class="form-select">
                    <option value="">Pendidikan Ayah</option>
                    @foreach ($pendidikan as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <x-input-with-icon-label icon="ti ti-building-skyscraper" label="Pekerjaan Ayah" name="pekerjaan_ayah" />


            <x-input-with-icon-label icon="ti ti-credit-card" label="NIK. Ibu" name="nik_ibu" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap Ibu" name="nama_ibu" />
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Pendidikan Ibu</label>
                <select name="pendidikan_ibu" id="pendidikan_ibu" class="form-select">
                    <option value="">Pendidikan Ibu</option>
                    @foreach ($pendidikan as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <x-input-with-icon-label icon="ti ti-building-skyscraper" label="Pekerjaan Ibu" name="pekerjaan_ibu" />

            <x-input-with-icon-label icon="ti ti-phone" label="No. HP Orangtua" name="no_hp_orang_tua" />
            <x-select-label label="Penghasilan Orantua" name="kode_penghasilan_ortu" :data="$penghasilan_ortu"
                key="kode_penghasilan_ortu" textShow="penghasilan" select2="select2Kodepenghasilanortu"
                upperCase="true" />
            <div class="form-group mt-3">
                <button class="btn btn-primary w-100 shadow-sm d-flex align-items-center justify-content-center gap-2" type="submit" id="btnSimpan" style="background-color: #064e3b; border-color: #064e3b">
                    <i class="ti ti-device-floppy fs-4"></i>
                    <span class="fw-bold">Simpan Pendaftaran</span>
                </button>
            </div>
        </div>
    </div>

</form>

<script src="{{ asset('assets/js/pages/pendaftaran.js') }}"></script>
<script>
    $(function() {
        const form = $("#formPendaftaran");
        const loading = `<div class="sk-wave sk-primary" style="margin:auto">
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            </div>`;
        $(".flatpickr-date").flatpickr();
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

        const select2Kodeasalsekolah = $('.select2Kodeasalsekolah');
        if (select2Kodeasalsekolah.length) {
            select2Kodeasalsekolah.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Asal Sekolah',
                    dropdownParent: $this.parent(),
                    allowClear: true
                });
            });
        }

        function getRegency(id_province = "", id_regency = "") {
            $.ajax({
                type: 'POST',
                url: '/regency/getregencybyprovince',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_province: id_province,
                    id_regency: id_regency
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    form.find("#id_regency").html(respond);
                }
            });
        }

        function getDistrict(id_regency = "", id_district = "") {
            $.ajax({
                type: 'POST',
                url: '/district/getdistrictbyregency',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_regency: id_regency,
                    id_district: id_district
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    form.find("#id_district").html(respond);
                }
            });
        }

        function getVillage(id_district = "", id_village = "") {
            $.ajax({
                type: 'POST',
                url: '/village/getvillagebydistrict',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_district: id_district,
                    id_village: id_village
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    form.find("#id_village").html(respond);
                }
            });
        }

        // AUTOLOAD DATA USER (EDIT FORM)
        @if(isset($user))
            // Inisialisasi Provinsi
            form.find('#id_province').val('{{ $user->id_province }}').trigger('change');
            // Setelah provinsi di-set, load kabupaten/kota
            getRegency('{{ $user->id_province }}', '{{ $user->id_regency }}');
            // Setelah kabupaten/kota di-set, load kecamatan
            getDistrict('{{ $user->id_regency }}', '{{ $user->id_district }}');
            // Setelah kecamatan di-set, load desa/kelurahan
            getVillage('{{ $user->id_district }}', '{{ $user->id_village }}');
            // Set value select2 (jika perlu)
            setTimeout(function() {
                form.find('#id_regency').val('{{ $user->id_regency }}').trigger('change');
                form.find('#id_district').val('{{ $user->id_district }}').trigger('change');
                form.find('#id_village').val('{{ $user->id_village }}').trigger('change');
            }, 1000);
        @endif

        $("#id_province").change(function() {
            getRegency(id_province = $(this).val(), id_regency = "");
        });

        $("#id_regency").change(function() {
            getDistrict(id_regency = $(this).val(), id_district = "");
        });

        $("#id_district").change(function() {
            getVillage(id_district = $(this).val(), id_village = "");
        });

        $("#btnCarisiswa").click(function() {
            $("#modalSiswa").modal("show");
        });

        function getSiswa(id_siswa) {
            $.ajax({
                url: `/siswa/${id_siswa}/getsiswa`,
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log(response);
                    form.find("#id_siswa").val(response.id_siswa);
                    form.find("#nisn").val(response.nisn);
                    form.find("#nama_lengkap").val(response.nama_lengkap);
                    form.find("#jenis_kelamin").val(response.jenis_kelamin);
                    form.find("#tempat_lahir").val(response.tempat_lahir);
                    form.find("#tanggal_lahir").val(response.tanggal_lahir);
                    form.find("#anak_ke").val(response.anak_ke);
                    form.find("#jumlah_saudara").val(response.jumlah_saudara);
                    form.find("#alamat").val(response.alamat);
                    form.find("#id_province").val(response.id_province).trigger('change');
                    getRegency(id_province = response.id_province, id_regency = response
                    .id_regency);
                    getDistrict(id_regency = response.id_regency, id_district = response
                        .id_district);
                    getVillage(id_district = response.id_district, id_village = response
                    .id_village);
                    form.find("#kode_pos").val(response.kode_pos);
                    form.find("#no_kk").val(response.no_kk);
                    form.find("#nik_ayah").val(response.nik_ayah);
                    form.find("#nama_ayah").val(response.nama_ayah);
                    form.find("#pendidikan_ayah").val(response.pendidikan_ayah);
                    form.find("#pekerjaan_ayah").val(response.pekerjaan_ayah);
                    form.find("#nik_ibu").val(response.nik_ibu);
                    form.find("#nama_ibu").val(response.nama_ibu);
                    form.find("#pendidikan_ibu").val(response.pendidikan_ibu);
                    form.find("#pekerjaan_ibu").val(response.pekerjaan_ibu);
                    form.find("#no_hp_orang_tua").val(response.no_hp_orang_tua);
                    $("#modalSiswa").modal("hide");
                }
            });
        }

        $('#tabelsiswa tbody').on('click', '.pilihsiswa', function(e) {
            e.preventDefault();
            let id_siswa = $(this).attr('id_siswa');
            getSiswa(id_siswa);
            //getKaryawan(nik);
        });


        form.find("#btnTambahsekolah").click(function(e) {
            // /alert("test");
            e.preventDefault();
            const kode_unit = form.find("#kode_unit").val();
            if (kode_unit == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Unit Sekolah Belum Di Pilih!',
                    didClose: (e) => {
                        form.find("#kode_unit").focus();
                    }
                });
            } else {
                $("#modalSekolah").modal("show");
                $("#modalSekolah").find("#loadmodal").html(loading);
                $("#modalSekolah").find(".modal-title").text("Tambah Data Asal Sekolah");
                $("#modalSekolah").find("#loadmodal").load("/asalsekolah/create");
            }
        });


        function loadasalsekolah() {
            const kode_unit = form.find("#kode_unit").val();
            const kode_asal_sekolah = "0";
            $("#kode_asal_sekolah").load(`/asalsekolah/${kode_unit}/${kode_asal_sekolah}/getasalsekolahbyunit`);
        }

        $("#kode_unit").change(function() {
            loadasalsekolah();
        });


    });
</script>
