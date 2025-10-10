<form id="formPembiayaan" action="{{ route('pembiayaan.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <x-input-with-icon-label icon="ti ti-barcode" label="No. Akad" name="no_akad" disabled="true" />
            <x-input-with-icon-label icon="ti ti-calendar" label="Tanggal Akad" name="tanggal"
                datepicker="flatpickr-date" />
            <label for="no_anggota" class="form-label" style="font-weight: 600"> Anggota</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="no_anggota" id="no_anggota" readonly=""
                    placeholder="Cari Anggota" aria-label="Cari Anggota" aria-describedby="no_anggota">
                <a class="btn btn-primary waves-effect" id="no_anggota_search"><i
                        class="ti ti-search text-white"></i></a>
            </div>
            <x-input-with-icon-label icon="ti ti-credit-card" label="Nomor Identitas" name="nik" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap" name="nama_lengkap" />
            <x-input-with-icon-label icon="ti ti-map-pin" label="Tempat Lahir" name="tempat_lahir" />
            <x-input-with-icon-label icon="ti ti-calendar" label="Tanggal Lahir" name="tanggal_lahir" />
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
            <div class="divider divider-vertical p-0 m-0">
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
            <x-select-label label="Provinsi" name="id_province" :data="$provinsi" key="id" textShow="name"
                select2="select2Provinsi" upperCase="true" />
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Kabupaten / Kota</label>
                <select name="id_regency" id="id_regency" class="select2Regency form-select">
                    <option value="">Kabupaten / Kota</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Kecamatan</label>
                <select name="id_district" id="id_district" class="select2District form-select">
                    <option value="">Kecamatan</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Desa / Kelurahan</label>
                <select name="id_village" id="id_village" class="select2Village form-select">
                    <option value="">Desa / Kelurahan</option>
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
            <div class="divider text-start">
                <div class="divider-text">
                    <i class="ti ti-file-description"></i> Data Ajuan Pembiayaan
                </div>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Jenis Pembiayaan</label>
                <select name="kode_pembiayaan" id="kode_pembiayaan" class="form-select">
                    <option value="">Jenis Pembiayaan</option>
                    @foreach ($jenis_pembiayaan as $d)
                        <option value="{{ $d->kode_pembiayaan }}" persentase="{{ $d->persentase }}">
                            {{ $d->jenis_pembiayaan }}</option>
                    @endforeach
                </select>
            </div>
            <x-input-with-icon-label icon="ti ti-percentage" label="Persentase (%)" name="persentase" value="0"
                readonly />
            <div class="form-gropu mb-3">
                <label for="jangka_watu" style="font-weight: 600" class="form-label"> Jangka Waktu</label>
                <select name="jangka_waktu" id="jangka_waktu" class="form-select">
                    <option value="">Jangka Waktu</option>
                    @for ($i = 1; $i <= 30; $i++)
                        <option value="{{ $i }}">{{ $i }} Bulan</option>
                    @endfor
                </select>
            </div>
            <x-input-with-icon-label label="Jumlah Pembiayaan" name="jumlah" icon="ti ti-moneybag" money="true"
                align="right" />
            <x-input-with-icon-label label="Jumlah Pengembalian" name="jumlah_pengembalian" icon="ti ti-moneybag"
                readonly align="right" />
            <x-textarea-label name="keperluan" label="keperluan" />
            <x-input-with-icon-label icon="ti ti-file-description" label="Jaminan" name="jaminan"
                datepicker="flatpickr-date" />
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
        $("#jumlah").maskMoney();
        $("#tanggal").flatpickr();

        function disableFields() {
            $(document).find("#formPembiayaan").find('input[name="nik"]').attr('disabled', 'disabled');
            $(document).find("#formPembiayaan").find('input[name="nama_lengkap"]').attr('disabled', 'disabled');
            $(document).find("#formPembiayaan").find('input[name="tempat_lahir"]').attr('disabled', 'disabled');
            $(document).find("#formPembiayaan").find('input[name="tanggal_lahir"]').attr('disabled',
            'disabled');
            $(document).find("#formPembiayaan").find('select[name="jenis_kelamin"]').attr('disabled',
                'disabled');
            $(document).find("#formPembiayaan").find('select[name="pendidikan_terakhir"]').attr('disabled',
                'disabled');
            $(document).find("#formPembiayaan").find('select[name="status_pernikahan"]').attr('disabled',
                'disabled');
            $(document).find("#formPembiayaan").find('input[name="jml_tanggungan"]').attr('disabled',
                'disabled');
            $(document).find("#formPembiayaan").find('input[name="nama_pasangan"]').attr('disabled',
            'disabled');
            $(document).find("#formPembiayaan").find('input[name="pekerjaan_pasangan"]').attr('disabled',
                'disabled');
            $(document).find("#formPembiayaan").find('input[name="nama_ibu"]').attr('disabled', 'disabled');
            $(document).find("#formPembiayaan").find('input[name="nama_saudara"]').attr('disabled', 'disabled');
            $(document).find("#formPembiayaan").find('input[name="no_hp"]').attr('disabled', 'disabled');
            $(document).find("#formPembiayaan").find('textarea[name="alamat"]').attr('disabled', 'disabled');
            $(document).find("#formPembiayaan").find('select[name="id_province"]').attr('disabled', 'disabled');
            $(document).find("#formPembiayaan").find('select[name="id_regency"]').attr('disabled', 'disabled');
            $(document).find("#formPembiayaan").find('select[name="id_district"]').attr('disabled', 'disabled');
            $(document).find("#formPembiayaan").find('select[name="id_village"]').attr('disabled', 'disabled');
            $(document).find("#formPembiayaan").find('select[name="status_tinggal"]').attr('disabled',
                'disabled');
            $(document).find("#formPembiayaan").find('input[name="kode_pos"]').attr('disabled', 'disabled');
        }
        disableFields();
    });
</script>
