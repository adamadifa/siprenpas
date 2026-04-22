<form action="{{ route('jenispembiayaan.update', ['kode_pembiayaan' => Crypt::encrypt($jenispembiayaan->kode_pembiayaan)]) }}" id="formPembiayaan" method="POST">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-barcode" label="Kode Jenis Pembiayaan" name="kode_pembiayaan" :value="$jenispembiayaan->kode_pembiayaan" required="true" />
    <x-input-with-icon-label icon="ti ti-file-description" label="Nama Jenis Pembiayaan" name="jenis_pembiayaan" :value="$jenispembiayaan->jenis_pembiayaan" required="true" />
    <x-input-with-icon-label icon="ti ti-calculator" label="Persentase (%)" name="persentase" :value="$jenispembiayaan->persentase" required="true" />
    
    <div class="form-group mt-3">
        <button class="btn btn-primary w-100 shadow-sm d-flex align-items-center justify-content-center gap-2" type="submit" id="btnSimpan" style="background-color: #064e3b; border-color: #064e3b">
            <i class="ti ti-device-floppy fs-4"></i>
            <span class="fw-bold">Update Data Jenis Pembiayaan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        $('#kode_pembiayaan').mask('A00');
        
        $('#formPembiayaan').submit(function(e) {
            let kode = $('#kode_pembiayaan').val();
            let jenis = $('#jenis_pembiayaan').val();
            let persentase = $('#persentase').val();

            if (kode == '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kode Jenis Pembiayaan harus diisi!',
                    confirmButtonColor: '#064e3b'
                });
            } else if (kode.length != 3) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kode Jenis Pembiayaan harus terdiri dari 3 karakter (Contoh: P01)!',
                    confirmButtonColor: '#064e3b'
                });
            } else if (jenis == '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Jenis Pembiayaan harus diisi!',
                    confirmButtonColor: '#064e3b'
                });
            } else if (persentase == '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Persentase harus diisi!',
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
