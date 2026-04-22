<style>
    .upload-zone {
        border: 2px dashed #064e3b;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        background-color: #f8faf9;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
    }

    .upload-zone:hover {
        background-color: #f0f4f2;
        border-color: #059669;
    }

    .upload-zone i {
        font-size: 3rem;
        color: #064e3b;
    }

    .upload-zone p {
        margin: 0;
        color: #064e3b;
        font-weight: 500;
    }

    .upload-zone .preview-container {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: white;
        z-index: 10;
        padding: 20px;
    }

    .upload-zone .preview-container img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .upload-zone .remove-preview {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 20;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .upload-zone .remove-preview:hover {
        transform: scale(1.1);
        background: #ef4444;
    }
</style>

<form action="{{ route('unit.store') }}" id="formcreateUnit" method="POST" enctype="multipart/form-data">
    @csrf
    <x-input-with-icon-label icon="ti ti-barcode" label="Kode Unit" name="kode_unit" required="true" />
    <x-input-with-icon-label icon="ti ti-file-description" label="Nama Unit" name="nama_unit" required="true" />

    <div class="form-group mb-3">
        <label class="form-label" style="font-weight: 600">Logo Unit</label>
        <label for="logo" class="upload-zone" id="upload-zone">
            <div class="preview-container" id="preview-container">
                <div class="remove-preview" id="remove-preview">
                    <i class="ti ti-x fs-5"></i>
                </div>
                <img src="" alt="Preview" id="preview-img">
            </div>
            <i class="ti ti-cloud-upload"></i>
            <div>
                <p>Klik untuk upload logo</p>
                <span class="text-muted small">Format: PNG, JPG, JPEG (Max. 2MB)</span>
            </div>
            <input type="file" name="logo" id="logo" class="d-none" accept="image/*"
                onchange="previewImage(this)">
        </label>
    </div>

    <x-textarea-label label="Keterangan" name="keterangan" />

    <div class="form-group mb-3">
        <label for="status" class="form-label" style="font-weight: 600">Status <span
                class="text-danger">*</span></label>
        <select name="status" id="status" class="form-select">
            <option value="1">Show</option>
            <option value="0">Hide</option>
        </select>
    </div>

    <div class="form-group">
        <button class="btn text-white w-100 py-2" type="submit" style="background-color: #064e3b">
            <i class="ti ti-send me-1"></i>
            Simpan Data
        </button>
    </div>
</form>

<script>
    function previewImage(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            const previewContainer = document.getElementById('preview-container');
            const previewImg = document.getElementById('preview-img');

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }

    document.getElementById('remove-preview')?.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const input = document.getElementById('logo');
        const previewContainer = document.getElementById('preview-container');

        input.value = '';
        previewContainer.style.display = 'none';
    });
</script>
<script src="{{ asset('assets/js/pages/unit/create.js') }}"></script>
