<form action="{{ route('perlombaan.update', Crypt::encrypt($perlombaan->id)) }}" id="formeditPerlombaan" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-file-description" label="Jenis Perlombaan" name="jenis_perlombaan"
        value="{{ $perlombaan->jenis_perlombaan }}" />
    <x-select-label label="Jenjang Pendidikan" name="id_jenjang" :data="$jenjangPendidikan"
        key="id" textShow="jenjang_pendidikan" selected="{{ $perlombaan->id_jenjang }}" />
    <div class="form-group mb-3">
        <label class="form-label">File Juknis & Juklak</label>
        <input type="file" class="form-control" name="juknis_juklak" id="juknis_juklak" accept=".pdf,.doc,.docx">
        <small class="text-muted">Format: PDF, DOC, DOCX (Max: 10MB)</small>
        @if ($perlombaan->juknis_juklak)
            <div class="mt-2">
                <small class="text-info">File saat ini: </small>
                <a href="{{ asset('storage/' . $perlombaan->juknis_juklak) }}" target="_blank" class="text-primary">
                    <i class="ti ti-file-text me-1"></i>Lihat File
                </a>
            </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Thumbnail</label>
        <input type="file" class="form-control" name="thumbnail" id="thumbnail" accept="image/*">
        <small class="text-muted">Format: JPEG, PNG, JPG, GIF, WEBP (Max: 2MB)</small>
        @if ($perlombaan->thumbnail)
            <div class="mt-2">
                <small class="text-info">Thumbnail saat ini: </small><br>
                <img src="{{ asset('storage/' . $perlombaan->thumbnail) }}" alt="Thumbnail" class="img-thumbnail mt-2" style="max-width: 200px; max-height: 200px;">
            </div>
        @endif
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
        $("#formeditPerlombaan").submit(function() {
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







