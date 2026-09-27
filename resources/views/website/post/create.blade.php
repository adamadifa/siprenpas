<form action="{{ route('post.store') }}" id="formCreatePost" method="POST" enctype="multipart/form-data">
    @csrf
    <x-input-file name="image" />
    <x-input-with-icon-label icon="ti ti-file-text" label="Judul" name="title" />
    <div class="form-group mb-3">
        <label for="kode_unit" style="font-weight: 600" class="form-label">Unit</label>
        <select name="kode_unit" id="kode_unit" class="form-select" required>
            @foreach ($units as $u)
                <option value="{{ $u->kode_unit }}" {{ ($default_unit ?? '') == $u->kode_unit ? 'selected' : '' }}>
                    {{ $u->nama_unit }} ({{ $u->kode_unit }})
                </option>
            @endforeach
        </select>
    </div>
    <label for="category_id" style="font-weight: 600" class="form-label">Kategori</label>
    <div class="form-group mb-3">
        <select name="category_id" id="category_id" class="form-select" required>
            <option value="">Pilih Kategori</option>
            @foreach ($categories as $d)
                <option value="{{ $d->id }}">{{ $d->name }}</option>
            @endforeach
        </select>
    </div>
    <x-textarea name="content" label="Content" />
    <div class="form-group mb-3">
        <button class="btn btn-primary w-100" id="btnSimpan" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Submit
        </button>
    </div>
</form>

<script>
    $(function() {
        $("#content").summernote({
            height: 300, // Tinggi summernote diatur menjadi 300px
            placeholder: 'Content...'
        });
    });
</script>
