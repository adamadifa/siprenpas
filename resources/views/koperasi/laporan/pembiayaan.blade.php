<form action="{{ route('laporankoperasi.cetakpembiayaan') }}" method="POST" target="_blank" id="formLaporanPembiayaan">
    @csrf
    <div class="row g-2">
        <div class="col-md-6 col-12 mb-1">
            <x-input-with-icon icon="ti ti-calendar" label="" name="dari" datepicker="flatpickr-date" placeholder="Dari Tanggal" />
        </div>
        <div class="col-md-6 col-12 mb-1">
            <x-input-with-icon icon="ti ti-calendar" label="" name="sampai" datepicker="flatpickr-date" placeholder="Sampai Tanggal" />
        </div>
        <div class="col-12 mt-2">
            <div class="row g-2">
                <div class="col-10">
                    <button type="submit" name="submitButton" class="btn btn-primary w-100 py-2 shadow-sm d-flex align-items-center justify-content-center gap-2" 
                        style="background-color: #064e3b !important; border-color: #064e3b !important; color: #fff !important;">
                        <i class="ti ti-printer fs-5"></i>
                        <span class="fw-bold">Cetak</span>
                    </button>
                </div>
                <div class="col-2">
                    <button type="submit" name="exportButton" class="btn btn-label-success w-100 py-2 d-flex align-items-center justify-content-center shadow-sm" style="background-color: #2ecc71 !important; color: #fff !important; border-color: #2ecc71 !important;"
                        title="Export Excel">
                        <i class="ti ti-download fs-5"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
