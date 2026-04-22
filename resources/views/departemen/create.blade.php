<form action="{{ route('departemen.store') }}" id="formcreateDepartemen" method="POST">
    @csrf
    <x-input-with-icon-label icon="ti ti-barcode" label="Kode Departemen" name="kode_dept" required="true" />
    <x-input-with-icon-label icon="ti ti-file-description" label="Nama Departemen" name="nama_dept" required="true" />
    <div class="form-group mt-4">
        <button class="btn btn-primary w-100" type="submit" style="background-color: #064e3b; border-color: #064e3b">
            <i class="ti ti-device-floppy me-2"></i>
            Simpan Data
        </button>
    </div>
</form>
<script src="{{ asset('assets/js/pages/departemen/create.js') }}"></script>
