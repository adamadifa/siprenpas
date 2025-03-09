<form action="{{ route('laporankoperasi.cetaksimpanan') }}" method="POST" target="_blank" id="formLaporanSimpanan">
    @csrf
    <div class="form-group mb-3">
        <select name="kode_simpanan" id="kode_simpanan" class="form-select select2Kodejenissimpanan">
            <option value="">Semua Jenis Simpanan</option>
            @foreach ($jenis_simpanan as $d)
                <option value="{{ $d->kode_simpanan }}">{{ textUpperCase($d->jenis_simpanan) }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group mb-3">
        <select name="no_anggota" id="no_anggota" class="form-select select2Noanggotasimpanan">
            <option value="">Semua Anggota</option>
            @foreach ($anggota as $d)
                <option value="{{ $d->no_anggota }}">{{ textUpperCase($d->nama_lengkap) }}</option>
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
