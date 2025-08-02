<form action="{{ route('laporanmsdm.cetakpresensi') }}" method="POST" target="_blank" id="formPresensi">
    @csrf
    @if (auth()->user()->kode_unit != 'U06')
        <input type="hidden" name="kode_unit" value="{{ auth()->user()->kode_unit }}">
    @else
        <div class="form-group mb-3">
            <select name="kode_unit" id="kode_unit" class="form-select select2Kodeunitpresensi">
                <option value="">Semua Unit</option>
                @foreach ($unit as $d)
                    <option value="{{ $d->kode_unit }}">{{ textUpperCase($d->nama_unit) }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="form-group mb-3">
        <select name="nik" id="nik_presensi" class="form-select select2Nikpresensi">
            <option value="">Semua Karyawan</option>
        </select>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group mb-3">
                <select name="bulan" id="bulan" class="form-select">
                    <option value="">Bulan</option>
                    @foreach ($list_bulan as $d)
                        <option {{ date('m') == $d['kode_bulan'] ? 'selected' : '' }} value="{{ $d['kode_bulan'] }}">
                            {{ $d['nama_bulan'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="co">
            <div class="form-group mb-3">
                <select name="tahun" id="tahun" class="form-select">
                    <option value="">Tahun</option>
                    @for ($t = $start_year; $t <= date('Y'); $t++)
                        <option {{ date('Y') == $t ? 'selected' : '' }} value="{{ $t }}">{{ $t }}
                        </option>
                    @endfor
                </select>
            </div>
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
