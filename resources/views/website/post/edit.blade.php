<form action="{{ route('post.update', Crypt::encrypt($post->id)) }}" id="formUpdatePost" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <!-- Display current image if exists -->
    @if ($post->image)
        <div class="form-group mb-3">
            <label class="form-label">Gambar Saat Ini</label>
            <div>
                <img src="{{ $post->image }}" alt="Current Image" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
            </div>
        </div>
    @endif
    
    <x-input-file name="image" label="Gambar Baru (opsional)" />
    <x-input-with-icon-label icon="ti ti-file-text" label="Judul" name="title" value="{{ old('title', $post->title) }}" />
    <label for="category_id" style="font-weight: 600" class="form-label">Kategori</label>
    <div class="form-group">
        <select name="category_id" id="category_id" class="form-select">
            <option value="">Kategori</option>
            @foreach ($categories as $d)
                <option value="{{ $d->id }}" {{ old('category_id', $post->category_id) == $d->id ? 'selected' : '' }}>
                    {{ $d->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" id="content" name="content" rows="8" placeholder="Content...">{{ old('content', $post->content) }}</textarea>
    </div>
    <div class="form-group mb-3">
        <button class="btn btn-primary w-100" id="btnUpdate" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Update
        </button>
    </div>
</form>

<script>
    $(function() {
        $("#content").summernote({
            height: 300,
            placeholder: 'Content...'
        });
    });
</script>

