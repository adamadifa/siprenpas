<form action="{{ route('post.store') }}" id="formCreatePost" method="POST" enctype="multipart/form-data">
    @csrf
    <x-input-file name="image" />
    <x-input-with-icon-label icon="ti ti-file-text" label="Judul" name="title" />
    <label for="category_id" style="font-weight: 600" class="form-label">Kategori</label>
    <div class="form-group">
        <select name="category_id" id="category_id" class="form-select">
            <option value="">Kategori</option>
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
