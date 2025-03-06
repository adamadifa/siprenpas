<form action="{{ route('karyawan.update', Crypt::encrypt($karyawan->npp)) }}" id="formeditKaryawan" method="POST">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-barcode" label="NPP" name="npp" value="{{ $karyawan->npp }}" />
    <x-input-with-icon-label icon="ti ti-credit-card" label="No. KK" name="no_kk" value="{{ $karyawan->no_kk }}" />
    <x-input-with-icon-label icon="ti ti-credit-card" label="No. KTP" name="no_ktp" value="{{ $karyawan->no_ktp }}" />
    <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap" name="nama_lengkap" value="{{ $karyawan->nama_lengkap }}" />
    <div class="form-group mb-3">
        <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
            <option value="">Jenis Kelamin</option>
            <option value="L" {{ $karyawan->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-Laki</option>
            <option value="P" {{ $karyawan->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <x-input-with-icon-label icon="ti ti-map-pin" label="Tempat Lahir" name="tempat_lahir" value="{{ $karyawan->tempat_lahir }}" />
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <x-input-with-icon-label icon="ti ti-calendar" label="Tanggal Lahir" name="tanggal_lahir" value="{{ $karyawan->tanggal_lahir }}"
                datepicker="flatpickr-date" />
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Golongan Darah</label>
        <select name="golongan_darah" id="golongan_darah" class="form-select">
            <option value="">Golongan Darah</option>
            <option {{ $karyawan->golongan_darah == 'A' ? 'selected' : '' }} value="A">A</option>
            <option {{ $karyawan->golongan_darah == 'B' ? 'selected' : '' }} value="B">B</option>
            <option {{ $karyawan->golongan_darah == 'AB' ? 'selected' : '' }} value="AB">AB</option>
            <option {{ $karyawan->golongan_darah == 'O' ? 'selected' : '' }} value="O">O</option>
        </select>
    </div>
    <x-input-with-icon-label icon="ti ti-phone" label="No. HP" name="no_hp" value="{{ $karyawan->no_hp }}" />
    <x-textarea-label name="alamat_ktp" label="Alamat KTP" value="{{ $karyawan->alamat_ktp }}" />
    <x-textarea-label name="alamat_tinggal" label="Alamat Tinggal" value="{{ $karyawan->alamat_tinggal }}" />
    <x-input-with-icon-label icon="ti ti-calendar" label="TMT" name="tmt" value="{{ $karyawan->tmt }}" datepicker="flatpickr-date" />
    <div class="form-group mb-3" datepicker="flatpickr-date">
        <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Status Karyawan</label>
        <select name="status_karyawan" id="status_karyawan" class="form-select">
            <option value="">Status Karyawan</option>
            <option value="K" {{ $karyawan->status_karyawan == 'K' ? 'selected' : '' }}>Kontrak</option>
            <option value="T" {{ $karyawan->status_karyawan == 'T' ? 'selected' : '' }}>Tetap</option>
            <option value="O" {{ $karyawan->status_karyawan == 'O' ? 'selected' : '' }}>OJT</option>
        </select>
    </div>
    <div class="form-group mb-3">
        <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Pendidikan
            Terakhir</label>
        <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-select">
            <option value="">Pendidikan Terakhir</option>
            <option value="SD" {{ $karyawan->pendidikan_terakhir == 'SD' ? 'selected' : '' }}>SD</option>
            <option value="SMP" {{ $karyawan->pendidikan_terakhir == 'SMP' ? 'selected' : '' }}>SMP</option>
            <option value="SMA" {{ $karyawan->pendidikan_terakhir == 'SMA' ? 'selected' : '' }}>SMP</option>
            <option value="SMK" {{ $karyawan->pendidikan_terakhir == 'SMK' ? 'selected' : '' }}>SMK</option>
            <option value="D1" {{ $karyawan->pendidikan_terakhir == 'D1' ? 'selected' : '' }}>D1</option>
            <option value="D2" {{ $karyawan->pendidikan_terakhir == 'D2' ? 'selected' : '' }}>D2</option>
            <option value="D3" {{ $karyawan->pendidikan_terakhir == 'D3' ? 'selected' : '' }}>D3</option>
            <option value="D4" {{ $karyawan->pendidikan_terakhir == 'D4' ? 'selected' : '' }}>D4</option>
            <option value="S1" {{ $karyawan->pendidikan_terakhir == 'S1' ? 'selected' : '' }}>S1</option>
            <option value="S2" {{ $karyawan->pendidikan_terakhir == 'S2' ? 'selected' : '' }}>S2</option>
            <option value="S3" {{ $karyawan->pendidikan_terakhir == 'S3' ? 'selected' : '' }}>S3</option>
        </select>
    </div>

    <x-select-label label="Jabatan" name="kode_jabatan" selected="{{ $karyawan->kode_jabatan }}" :data="$jabatan" key="kode_jabatan"
        textShow="nama_jabatan" />
    <x-select-label label="Unit" name="kode_unit" selected="{{ $karyawan->kode_unit }}" :data="$unit" key="kode_unit" textShow="nama_unit"
        upperCase="true" />
    <div class="form-group mb-3" datepicker="flatpickr-date">
        <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="">Status</option>
            <option value="1" {{ $karyawan->status == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $karyawan->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Submit
        </button>
    </div>
</form>

<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/karyawan/edit.js') }}"></script>
<script>
    $(function() {
        $(".flatpickr-date").flatpickr();
    });
</script>
