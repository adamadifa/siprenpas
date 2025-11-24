<form action="{{ route('unit.store') }}" id="formcreateUnit" method="POST" enctype="multipart/form-data">
    @csrf
    <x-input-with-icon-label icon="ti ti-barcode" label="Kode Unit" name="kode_unit" />
    <x-input-with-icon-label icon="ti ti-file-description" label="Nama Unit" name="nama_unit" />
    <x-input-file-with-label label="Logo Unit" name="logo" />
    <x-textarea-label label="Keterangan" name="keterangan" />
    <div class="form-group mb-3">
        <label for="status" class="form-label" style="font-weight: 600">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="1">Show</option>
            <option value="0">Hide</option>
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Submit
        </button>
    </div>
</form>
<script src="{{ asset('assets/js/pages/unit/create.js') }}"></script>
