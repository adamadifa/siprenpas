<form action="{{ route('kelas.store') }}" method="POST" id="formKelas">
    @csrf
    <x-input-with-icon icon="ti ti-file-description" label="Kelas" name="nama_kelas" />
    <div class="invalid-feedback" id="error-nama_kelas" style="display:none"></div>
    <x-select label="Jenjang / Unit" name="kode_unit" :data="$unit" key="kode_unit" textShow="nama_unit"
        upperCase="true" />
    <div class="invalid-feedback" id="error-kode_unit" style="display:none"></div>
    <div class="form-group mb-3">
        <select name="tingkat" id="tingkat" class="form-select">
            <option value="">Pilih Tingkat</option>
        </select>
        <div class="invalid-feedback" id="error-tingkat" style="display:none"></div>
    </div>
    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Submit
        </button>
    </div>
</form>
