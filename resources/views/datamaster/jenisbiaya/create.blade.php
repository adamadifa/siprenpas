<form action="{{ route('jenisbiaya.store') }}" id="formBiaya" method="POST">
    @csrf
    <x-input-with-icon-label icon="ti ti-barcode" label="Kode Jenis Biaya" name="kode_jenis_biaya" required="true" />
    <x-input-with-icon-label icon="ti ti-file-description" label="Jenis Biaya" name="jenis_biaya" required="true" />
    <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" role="switch" id="tampilkan_di_landing" name="tampilkan_di_landing" value="1" checked style="cursor: pointer;">
        <label class="form-check-label fw-semibold" for="tampilkan_di_landing">
            Tampilkan di Landing Page (Rincian Biaya Masuk)
        </label>
        <small class="d-block text-muted">Jika diaktifkan, biaya ini akan masuk dalam kalkulasi dan tabel rincian biaya awal masuk di landing page.</small>
    </div>
    <div class="form-group">
        <button class="btn text-white w-100 py-2" type="submit" style="background-color: #064e3b">
            <i class="ti ti-send me-1"></i>
            Simpan Data
        </button>
    </div>
</form>
<script src="{{ asset('assets/js/pages/biaya.js') }}"></script>
<script>
    $(function() {
        $('#kode_biaya').mask('A00');
    });
</script>
