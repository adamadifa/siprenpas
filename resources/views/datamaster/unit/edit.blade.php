<form action="{{ route('unit.update', Crypt::encrypt($unit->kode_unit)) }}" id="formeditUnit" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-barcode" label="Kode Unit" name="kode_unit" value="{{ $unit->kode_unit }}"
        readonly="true" />
    <x-input-with-icon-label icon="ti ti-file-description" label="Nama Unit" name="nama_unit"
        value="{{ $unit->nama_unit }}" />
    <div class="form-group mb-3">
        <label for="logo" class="form-label" style="font-weight: 600">Logo Unit</label>
        @if ($unit->logo)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $unit->logo) }}" alt="Logo Unit" class="img-fluid rounded" style="max-height: 100px;">
                <p class="text-muted small mt-1">Logo saat ini</p>
            </div>
        @endif
        <input class="form-control" type="file" id="logo" name="logo" accept="image/*">
        <div class="form-text">Format: JPEG, PNG, JPG, GIF, SVG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</div>
    </div>
    <x-textarea-label label="Keterangan" name="keterangan" value="{{ $unit->keterangan }}" />
    <div class="form-group mb-3">
        <label for="status" class="form-label" style="font-weight: 600">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="1" {{ $unit->status == 1 ? 'selected' : '' }}>Show</option>
            <option value="0" {{ $unit->status == 0 ? 'selected' : '' }}>Hide</option>
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Submit
        </button>
    </div>
</form>
<script src="{{ asset('assets/js/pages/unit/edit.js') }}"></script>
