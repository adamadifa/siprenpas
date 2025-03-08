<form action="{{ route('laporankoperasi.cetaktabungan') }}" method="POST" target="_blank" id="formLaporanTabungan">
    @csrf
    <div class="form-group mb-3">
        <select name="kode_tabungan" id="kode_tabungan" class="form-select select2Kodejenistabungan">
            <option value="">Semua Jenis Tabungan</option>
            @foreach ($jenis_tabungan as $d)
                <option value="{{ $d->kode_tabungan }}">{{ textUpperCase($d->jenis_tabungan) }}</option>
            @endforeach
        </select>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <x-input-with-icon icon="ti ti-calendar" label="Dari" name="dari" datepicker="flatpickr-date" />
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <x-input-with-icon icon="ti ti-calendar" label="Sampai" name="sampai" datepicker="flatpickr-date" />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 col-md-12 col-sm-12">
            <button type="submit" name="submitButton" class="btn btn-primary w-100" id="submitButton">
                <i class="ti ti-printer me-1"></i> Cetak
            </button>
        </div>
        <div class="col-lg-2 col-md-12 col-sm-12">
            <button type="submit" name="exportButton" class="btn btn-success w-100" id="exportButton">
                <i class="ti ti-download"></i>
            </button>
        </div>
    </div>
</form>
