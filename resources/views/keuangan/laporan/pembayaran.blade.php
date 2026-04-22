<form action="{{ route('lk.cetakpembayaran') }}" method="POST" target="_blank" id="formPembayaran">
    @csrf
    <div class="form-group mb-2">
        <select name="kode_unit" id="kode_unit" class="form-select select2Kodeunit border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
            <option value="">Pilih Unit</option>
            @foreach ($unit as $d)
                <option value="{{ $d->kode_unit }}">{{ textUpperCase($d->nama_unit) }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-2">
        <select name="tingkat" id="tingkat" class="form-select select2Tingkat border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
            <option value="">Pilih Tingkat</option>
        </select>
    </div>

    <div class="row g-2 mb-3">
        <div class="col-md-6 col-12">
            <x-input-with-icon icon="ti ti-calendar" label="" name="dari" datepicker="flatpickr-date" placeholder="Dari Tanggal" class="border-0 shadow-sm border" required/>
        </div>
        <div class="col-md-6 col-12">
            <x-input-with-icon icon="ti ti-calendar" label="" name="sampai" datepicker="flatpickr-date" placeholder="Sampai Tanggal" class="border-0 shadow-sm border" required/>
        </div>
    </div>
    
    <div class="row g-2">
        <div class="col-10">
            <button type="submit" name="submitButton" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2 py-2 shadow-sm" style="background-color: #064e3b; border-color: #064e3b">
                <i class="ti ti-printer fs-5"></i>
                <span class="fw-bold">Cetak</span>
            </button>
        </div>
        <div class="col-2">
            <button type="submit" name="exportButton" class="btn btn-label-success w-100 py-2 d-flex align-items-center justify-content-center shadow-sm" style="background-color: #2ecc71 !important; color: #fff !important; border-color: #2ecc71 !important;">
                <i class="ti ti-download fs-5"></i>
            </button>
        </div>
    </div>
</form>
