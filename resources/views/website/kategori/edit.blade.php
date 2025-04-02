<form action="{{ route('kategori.update', Crypt::encrypt($kategori->id)) }}" method="POST" id="formKategori">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-file-description" label="Kategori" name="kategori" :value="$kategori->name" />
    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit" id="btnSimpan">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Update
        </button>
    </div>
</form>
<script>
    $(function() {
        $('#formKategori').submit(function(e) {
            let kategori = $(this).find("#kategori").val();
            if (kategori == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kategori tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#kategori").focus();
                    }
                });
                return false;
            } else {
                $(this).find("#btnSimpan").prop("disabled", true);
                $(this).find("#btnSimpan").html(
                    `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...`
                );
            }
        })
    })
</script>
