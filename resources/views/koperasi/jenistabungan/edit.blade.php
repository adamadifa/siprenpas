<form action="{{ route('jenistabungan.update', ['kode_tabungan' => Crypt::encrypt($jenistabungan->kode_tabungan)]) }}" id="formTabungan" method="POST">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-barcode" label="Kode Jenis Tabungan" name="kode_tabungan" :value="$jenistabungan->kode_tabungan" required="true" />
    <x-input-with-icon-label icon="ti ti-file-description" label="Nama Jenis Tabungan" name="jenis_tabungan" :value="$jenistabungan->jenis_tabungan" required="true" />
    
    <div class="form-group mt-3">
        <button class="btn btn-primary w-100 shadow-sm d-flex align-items-center justify-content-center gap-2" type="submit" id="btnSimpan" style="background-color: #064e3b; border-color: #064e3b">
            <i class="ti ti-device-floppy fs-4"></i>
            <span class="fw-bold">Update Data Jenis Tabungan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $('#kode_tabungan').mask('A00');
        
        $('#formTabungan').submit(function(e) {
            let kode = $('#kode_tabungan').val();
            let jenis = $('#jenis_tabungan').val();

            if (kode == '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kode Tabungan harus diisi!',
                    confirmButtonColor: '#064e3b'
                });
            } else if (kode.length != 3) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kode Tabungan harus terdiri dari 3 karakter (Contoh: T01)!',
                    confirmButtonColor: '#064e3b'
                });
            } else if (jenis == '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Jenis Tabungan harus diisi!',
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
