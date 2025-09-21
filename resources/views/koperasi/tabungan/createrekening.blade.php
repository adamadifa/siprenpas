<form action="{{ route('tabungan.storerekening') }}" id="formTabungan" method="POST">
    @csrf
    <x-input-with-icon icon="ti ti-barcode" label="No. Rekening (Auto)" name="no_rekening" disabled="true" />
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="no_anggota" id="no_anggota" readonly="" placeholder="Cari Anggota" aria-label="Cari Anggota"
            aria-describedby="no_anggota">
        <a class="btn btn-primary waves-effect" id="no_anggota_search"><i class="ti ti-search text-white"></i></a>
    </div>
    <div class="row mb-2 mt-2">
        <table class="table">
            <tr>
                <th>No. Anggota</th>
                <td id="no_anggota_text"></td>
            </tr>
            <tr>
                <th>Nama Lengkap</th>
                <td id="nama_lengkap_text"></td>
            </tr>
        </table>
    </div>
    <div class="form-group">
        <select name="kode_tabungan" id="kode_tabungan" class="form-select select2Kodetabungan">
            <option value="">Jenis Tabungan</option>
            @foreach ($jenis_tabungan as $d)
                <option value="{{ $d->kode_tabungan }}">{{ $d->kode_tabungan }} - {{ textUpperCase($d->jenis_tabungan) }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group">
        <label for="rfid" class="form-label">RFID (Opsional)</label>
        <input type="text" class="form-control" name="rfid" id="rfid" 
               placeholder="Masukkan kode RFID" maxlength="20">
        <small class="form-text text-muted">
            Kode RFID harus unik dan maksimal 20 karakter. Kosongkan jika tidak ada RFID.
        </small>
    </div>


    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit" id="btnSimpan"><i class="ti ti-send me-1"></i>Submit</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        const formTabungan = $('#formTabungan');
        const select2Kodetabungan = $('.select2Kodetabungan');
        if (select2Kodetabungan.length) {
            select2Kodetabungan.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Jenis Tabungan',
                    dropdownParent: $this.parent(),
                    allowClear: true
                });
            });
        }

        formTabungan.submit(function(e) {
            let no_anggota = $(this).find('input[name="no_anggota"]').val();
            let kode_tabungan = $(this).find('select[name="kode_tabungan"]').val();

            if (!no_anggota) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'No Anggota tidak boleh kosong!',
                    didClose: () => {
                        $(this).find('input[name="no_anggota"]').focus();
                    }
                });
                return false;
            } else if (!kode_tabungan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jenis Tabungan tidak boleh kosong!',
                    didClose: () => {
                        $(this).find('select[name="kode_tabungan"]').focus();
                    }
                })
                return false;
            } else {
                $("#btnSimpan").attr("disabled", true);
                $("#btnSimpan").html(
                    `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...`
                );
            }
        });

        // Auto-format RFID input (uppercase)
        $('#rfid').on('input', function() {
            this.value = this.value.toUpperCase();
        });

    });
</script>
