<form action="{{ route('lk.cetakrekaptagihan') }}" method="POST" target="_blank" id="formPresensi">
    @csrf
    <div class="form-group mb-3">
        <select name="kode_unit" id="kode_unit" class="form-select select2Kodeunitpresensi">
            <option value="">Pilih Unit</option>
            @foreach ($unit as $d)
                <option value="{{ $d->kode_unit }}">{{ textUpperCase($d->nama_unit) }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <select name="tingkat" id="tingkat" class="form-select">
            <option value="">Pilih Tingkat</option>
        </select>
    </div>
    <div class="form-group mb-3">
        <select name="kode_ta" id="kode_ta_search" class="form-select">
            <option value="">Tahun Ajaran</option>
            @foreach ($tahunajaran as $d)
                <option value="{{ $d->kode_ta }}"
                    @if (Request('kode_ta') == $d->kode_ta) selected @elseif ($tahun_ajaran->kode_ta == $d->kode_ta) selected @endif>
                    {{ $d->tahun_ajaran }}</option>
            @endforeach
        </select>
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
