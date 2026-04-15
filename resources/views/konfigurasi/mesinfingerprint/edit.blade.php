<form action="{{ route('mesinfingerprint.update', Crypt::encrypt($mesin->id)) }}" id="formeditMesinFP"
    method="POST">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-device-desktop" label="Nama Mesin" name="nama_mesin"
        value="{{ $mesin->nama_mesin }}" />
    <x-input-with-icon-label icon="ti ti-barcode" label="Serial Number (SN)" name="sn"
        value="{{ $mesin->sn }}" />
    <x-input-with-icon-label icon="ti ti-map-pin" label="Titik Koordinat" name="titik_koordinat"
        value="{{ $mesin->titik_koordinat }}" />
    <div class="form-group mb-3">
        <label for="status" style="font-weight: 600" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="Aktif" {{ $mesin->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Nonaktif" {{ $mesin->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
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
        $("#formeditMesinFP").submit(function(e) {
            var form = $(this);
            var actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data Berhasil Di Update',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON;
                    if (errors && errors.errors) {
                        var errorMessages = Object.values(errors.errors).flat().join('\n');
                        Swal.fire({
                            title: 'Gagal!',
                            text: errorMessages,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi Kesalahan',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
            e.preventDefault();
        });
    });
</script>
