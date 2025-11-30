<form action="{{ route('tahunajaran.store') }}" id="formTahunajaran" method="POST">
    @csrf
    <x-input-with-icon-label icon="ti ti-file-description" label="Tahun Ajaran" name="tahun_ajaran" />
    <div class="form-group mb-3">
        <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="">Status</option>
            <option value="1">Aktif</option>
            <option value="0">Non Aktif</option>
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
        $('#tahun_ajaran').mask('0000/0000');
    });
</script>