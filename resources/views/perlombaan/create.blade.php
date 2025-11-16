<form action="{{ route('perlombaan.store') }}" id="formcreatePerlombaan" method="POST" enctype="multipart/form-data">
    @csrf
    <x-input-with-icon icon="ti ti-file-description" label="Jenis Perlombaan" name="jenis_perlombaan" />
    <select name="id_jenjang" id="id_jenjang" class="form-select mb-3">
        <option value="">Jenjang Pendidikan</option>
        @foreach ($jenjangPendidikan as $d)
            <option value="{{ $d->id }}">{{ $d->jenjang_pendidikan }}</option>
        @endforeach
    </select>
    <div class="form-group mb-3">
        <label class="form-label">File Juknis & Juklak</label>
        <input type="file" class="form-control" name="juknis_juklak" id="juknis_juklak" accept=".pdf,.doc,.docx">
        <small class="text-muted">Format: PDF, DOC, DOCX (Max: 10MB)</small>
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Thumbnail</label>
        <input type="file" class="form-control" name="thumbnail" id="thumbnail" accept="image/*">
        <small class="text-muted">Format: JPEG, PNG, JPG, GIF, WEBP (Max: 2MB)</small>
        <div id="thumbnail-preview" class="mt-2"></div>
    </div>
    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Submit
        </button>
    </div>
</form>
<script>
    $(function() {
        $("#formcreatePerlombaan").submit(function() {
            var jenis_perlombaan = $("#jenis_perlombaan").val();
            var id_jenjang = $("#id_jenjang").val();
            if (jenis_perlombaan == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Jenis Perlombaan Harus Diisi !',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#jenis_perlombaan").focus();
                });
                return false;
            }
            if (id_jenjang == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Jenjang Pendidikan Harus Dipilih !',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#id_jenjang").focus();
                });
                return false;
            }
        });

        // Preview thumbnail
        $("#thumbnail").change(function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#thumbnail-preview").html('<img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">');
                };
                reader.readAsDataURL(file);
            } else {
                $("#thumbnail-preview").html('');
            }
        });
    });
</script>
