<form action="{{ route('jamkerja.store') }}" id="formcreateJamkerja" method="POST">
    @csrf
    <x-input-with-icon-label icon="ti ti-barcode" label="Kode Jam Kerja" name="kode_jam_kerja" />
    <x-input-with-icon-label icon="ti ti-file-description" label="Nama Jam Kerja" name="nama_jam_kerja" />
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <x-input-with-icon-label icon="ti ti-clock" label="Jam Masuk" name="jam_masuk" />
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <x-input-with-icon-label icon="ti ti-clock" label="Jam Pulang" name="jam_pulang" />
        </div>
    </div>
    <x-input-with-icon-label icon="ti ti-file-description" label="Total Jam" name="total_jam" />
    <div class="form-group mb-3">
        <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Lintas Hari</label>
        <select name="lintas_hari" id="lintas_hari" class="form-select">
            <option value="">Lintas Hari</option>
            <option value="1">Ya</option>
            <option value="0">Tidak</option>
        </select>
    </div>

    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Submit
        </button>
    </div>
</form>
<script src="{{ asset('assets/js/pages/jamkerja/create.js') }}"></script>
<script>
    $(function() {

        $("#jam_masuk,#jam_pulang").mask("00:00");
    });
</script>
