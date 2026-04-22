<form action="{{ route('jenisbiaya.update',Crypt::encrypt($jenisbiaya->kode_jenis_biaya)) }}" id="formBiaya"
    method="POST">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-barcode" label="Kode Biaya" name="kode_jenis_biaya"
        value="{{ $jenisbiaya->kode_jenis_biaya }}" readonly="true" />
    <x-input-with-icon-label icon="ti ti-file-description" label="Jenis Biaya" name="jenis_biaya"
        value="{{ $jenisbiaya->jenis_biaya }}" required="true" />
    <div class="form-group">
        <button class="btn text-white w-100 py-2" type="submit" style="background-color: #064e3b">
            <i class="ti ti-device-floppy me-1"></i>
            Update Data
        </button>
    </div>
</form>
<script src="{{ asset('assets/js/pages/biaya.js') }}"></script>
<script>
    $(function(){
        $('#kode_biaya').mask('A00');
    });
</script>