<form action="{{ route('kategori-pengumuman.update', $kategoriPengumuman->id) }}" method="POST"
    id="formKategoriPengumuman">
    @csrf
    @method('PUT')
    <x-input-with-icon icon="ti ti-category" label="Nama Kategori" name="nama_kategori"
        value="{{ old('nama_kategori', $kategoriPengumuman->nama_kategori) }}" />
    @error('nama_kategori')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    <div class="invalid-feedback" id="error-nama_kategori" style="display:none"></div>

    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit" id="btnSubmit">
            <i class="ti ti-send me-1"></i>Submit
        </button>
    </div>
</form>

<script src="{{ asset('assets/js/pages/kategori-pengumuman.js') }}"></script>
<!-- Form Validation JS -->
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
