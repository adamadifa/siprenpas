<form action="{{ route('pengumuman.store') }}" method="POST" id="formPengumuman">
    @csrf
    <x-input-with-icon icon="ti ti-file-description" label="Judul Pengumuman" name="judul" value="{{ old('judul') }}" />
    @error('judul')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    <div class="invalid-feedback" id="error-judul" style="display:none"></div>
    <x-select label="Kategori" name="kategori_id" :data="$kategori" key="id" textShow="nama_kategori" />
    @error('kategori_id')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    <div class="invalid-feedback" id="error-kategori_id" style="display:none"></div>
    <div class="row">
        <div class="col-lg-6 col-sm-12 col-md-12">
            <x-input-with-icon icon="ti ti-calendar" label="Tanggal" name="tanggal" datepicker="flatpickr-date"
                value="{{ old('tanggal', date('Y-m-d')) }}" />
        </div>
        <div class="col-lg-6 col-sm-12 col-md-12">
            <x-input-with-icon icon="ti ti-map-pin" label="Lokasi" name="lokasi" value="{{ old('lokasi') }}"
                placeholder="Contoh: Bank Syariah Mandiri, Kampus Pusat" />
        </div>
    </div>
    @error('tanggal')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    <div class="invalid-feedback" id="error-tanggal" style="display:none"></div>
    <x-textarea-label name="isi" label="Isi Pengumuman" value="{{ old('isi') }}" />
    @error('isi')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    <div class="invalid-feedback" id="error-isi" style="display:none"></div>
    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit" id="btnSubmit">
            <i class="ti ti-send me-1"></i>Submit
        </button>
    </div>
</form>

<script src="{{ asset('assets/js/pages/pengumuman.js') }}"></script>
<!-- Form Validation JS -->
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
