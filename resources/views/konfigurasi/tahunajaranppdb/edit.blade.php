<form action="{{ route('tahunajaranppdb.update',Crypt::encrypt($tahunajaran->kode_ta)) }}" id="formTahunajaran"
    method="POST">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-barcode" label="Kode Tahun Ajaran" name="kode_ta"
        value="{{ $tahunajaran->kode_ta }}" readonly="true" />
    <x-input-with-icon-label icon="ti ti-file-description" label="Tahun Ajaran" name="tahun_ajaran"
        value="{{ $tahunajaran->tahun_ajaran }}" />
    <div class="form-group mb-3">
        <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="">Status</option>
            <option value="1" {{ $tahunajaran->status=='1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $tahunajaran->status==='0' ? 'selected' : '' }}>Non Aktif</option>
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Submit
        </button>
    </div>
</form>
<script src="{{ asset('assets/js/pages/tahunajaran.js') }}"></script>
<script>
    $(function(){
        $('#tahunajaran_ppdb').mask('0000/0000');
        $('#kode_ta_ppdb').mask('AA0000');
    });
</script>