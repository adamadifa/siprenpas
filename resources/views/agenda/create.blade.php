<form action="{{ route('agenda.store') }}" id="formCreateAgenda" method="POST">
    @csrf
    <x-input-with-icon icon="ti ti-bookmark" label="Nama Agenda" name="nama_agenda" />
    <div class="row">
        <div class="col-md-6">
            <x-input-with-icon icon="ti ti-calendar" label="Tanggal Mulai" name="tanggal" datepicker="flatpickr-date" />
        </div>
        <div class="col-md-6">
            <x-input-with-icon icon="ti ti-calendar" label="Tanggal Selesai" name="tanggal_selesai" datepicker="flatpickr-date" />
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <x-input-with-icon icon="ti ti-clock" label="Jam Mulai" name="jam_mulai" placeholder="Contoh: 08:00" />
        </div>
        <div class="col-md-6">
            <x-input-with-icon icon="ti ti-clock" label="Jam Selesai" name="jam_selesai" placeholder="Contoh: 10:00" />
        </div>
    </div>

    <x-input-with-icon icon="ti ti-map-pin" label="Tempat" name="tempat" />

    <div class="form-group mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea name="keterangan" id="keterangan" class="form-control" rows="5"></textarea>
    </div>

    <div class="form-group mb-3">
        <button class="btn btn-primary w-100" id="btnSimpan" type="submit">
            <i class="ti ti-send me-1"></i>
            Submit
        </button>
    </div>
</form>

<script>
    $(function() {
        $(".flatpickr-date").flatpickr();

        $("#formCreateAgenda").submit(function(e) {
            let nama_agenda = $(this).find('#nama_agenda').val();
            let tanggal = $(this).find('#tanggal').val();

            if (nama_agenda == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Agenda tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#nama_agenda").focus();
                    }
                });
                return false;
            } else if (tanggal == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#tanggal").focus();
                    }
                });
                return false;
            } else {
                $("#btnSimpan").attr("disabled", true);
                $("#btnSimpan").html(
                    `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...`
                );
            }
        });
    });
</script>
