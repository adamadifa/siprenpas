<form action="{{ route('jenisbiaya.store') }}" id="formBiaya" method="POST">
    @csrf
    <x-input-with-icon-label icon="ti ti-barcode" label="Kode Jenis Biaya" name="kode_jenis_biaya" required="true" />
    <x-input-with-icon-label icon="ti ti-file-description" label="Jenis Biaya" name="jenis_biaya" required="true" />
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
