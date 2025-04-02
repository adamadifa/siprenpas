<form action="{{ route('kategori.store') }}" method="POST" id="formKategori">
    @csrf
    <x-input-with-icon-label icon="ti ti-file-description" label="Kategori" name="kategori" />
    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit" id="btnSimpan">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Submit
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
                    text: 'Kategori Ibadah tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#kategori_ibadah").focus();
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
