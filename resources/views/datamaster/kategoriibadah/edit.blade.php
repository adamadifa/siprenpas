<form action="{{ route('kategoriibadah.update', Crypt::encrypt($kategoriibadah->id)) }}" method="POST" id="formKategoriIbadah">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-file-description" label="Nama Kategori Ibadah" name="kategori_ibadah" :value="$kategoriibadah->kategori_ibadah" required="true" />
    
    <div class="form-group mt-3">
        <button class="btn btn-primary w-100 shadow-sm d-flex align-items-center justify-content-center gap-2" type="submit" id="btnSimpan" style="background-color: #064e3b; border-color: #064e3b">
            <i class="ti ti-device-floppy fs-4"></i>
            <span class="fw-bold">Update Data Kategori Ibadah</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $('#formKategoriIbadah').submit(function(e) {
            let kategori = $('#kategori_ibadah').val();

            if (kategori == '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Kategori Ibadah harus diisi!',
                    confirmButtonColor: '#064e3b'
                });
            } else {
                $('#btnSimpan').attr('disabled', 'disabled');
                $('#btnSimpan').html(
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Update...'
                );
            }
        });
    });
</script>
