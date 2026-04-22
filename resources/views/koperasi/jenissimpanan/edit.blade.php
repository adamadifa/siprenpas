<form action="{{ route('jenissimpanan.update', ['kode_simpanan' => Crypt::encrypt($jenissimpanan->kode_simpanan)]) }}" id="formSimpanan" method="POST">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-barcode" label="Kode Jenis Simpanan" name="kode_simpanan" :value="$jenissimpanan->kode_simpanan" required="true" />
    <x-input-with-icon-label icon="ti ti-file-description" label="Nama Jenis Simpanan" name="jenis_simpanan" :value="$jenissimpanan->jenis_simpanan" required="true" />
    
    <div class="form-group mt-3">
        <button class="btn btn-primary w-100 shadow-sm d-flex align-items-center justify-content-center gap-2" type="submit" id="btnSimpan" style="background-color: #064e3b; border-color: #064e3b">
            <i class="ti ti-device-floppy fs-4"></i>
            <span class="fw-bold">Update Data Jenis Simpanan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $('#kode_simpanan').mask('A00');
        
        $('#formSimpanan').submit(function(e) {
            let kode = $('#kode_simpanan').val();
            let jenis = $('#jenis_simpanan').val();

            if (kode == '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kode Simpanan harus diisi!',
                    confirmButtonColor: '#064e3b'
                });
            } else if (kode.length != 3) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kode Simpanan harus terdiri dari 3 karakter (Contoh: S01)!',
                    confirmButtonColor: '#064e3b'
                });
            } else if (jenis == '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Jenis Simpanan harus diisi!',
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
