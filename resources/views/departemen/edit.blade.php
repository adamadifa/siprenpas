<form action="{{ route('departemen.update', ['kode_dept' => Crypt::encrypt($departemen->kode_dept)]) }}" id="formeditDepartemen" method="POST">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-barcode" label="Kode Departemen" name="kode_dept" :value="$departemen->kode_dept" required="true" />
    <x-input-with-icon-label icon="ti ti-file-description" label="Nama Departemen" name="nama_dept" :value="$departemen->nama_dept" required="true" />
    <div class="form-group mt-4">
        <button class="btn btn-primary w-100" type="submit" style="background-color: #064e3b; border-color: #064e3b">
            <i class="ti ti-device-floppy me-2"></i>
            Update Data
        </button>
    </div>
</form>
<script src="{{ asset('assets/js/pages/departemen/edit.js') }}"></script>
