<form action="{{ route('kegiatanibadah.update', ['id' => Crypt::encrypt($kegiatanibadah->id)]) }}" method="POST" id="formKegiatanIbadah">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-file-description" label="Nama Kegiatan Ibadah" name="nama_kegiatan" :value="$kegiatanibadah->nama_kegiatan" required="true" />
    
    <div class="form-group mb-3">
        <label class="form-label fw-bold small">Kategori Ibadah <span class="text-danger">*</span></label>
        <select name="id_kategori_ibadah" id="id_kategori_ibadah" class="form-select">
            <option value="">Pilih Kategori Ibadah</option>
            @foreach ($kategori_ibadah as $item)
                <option value="{{ $item->id }}" @selected($kegiatanibadah->id_kategori_ibadah == $item->id)>{{ $item->kategori_ibadah }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mt-3">
        <button class="btn btn-primary w-100 shadow-sm d-flex align-items-center justify-content-center gap-2" type="submit" id="btnSimpan" style="background-color: #064e3b; border-color: #064e3b">
            <i class="ti ti-device-floppy fs-4"></i>
            <span class="fw-bold">Update Data Kegiatan Ibadah</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $('#formKegiatanIbadah').submit(function(e) {
            let nama = $('#nama_kegiatan').val();
            let kategori = $('#id_kategori_ibadah').val();

            if (nama == '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Kegiatan Ibadah harus diisi!',
                    confirmButtonColor: '#064e3b'
                });
            } else if (kategori == '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kategori Ibadah harus dipilih!',
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
