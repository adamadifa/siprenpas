<form action="{{ route('agenda.update', ['id' => Crypt::encrypt($agenda->id)]) }}" id="formEditAgenda" method="POST">
    @csrf
    @method('PUT')
    <x-input-with-icon icon="ti ti-bookmark" label="Nama Agenda" name="nama_agenda" :value="$agenda->nama_agenda" />
    <div class="row">
        <div class="col-md-6">
            <x-input-with-icon icon="ti ti-calendar" label="Tanggal Mulai" name="tanggal" datepicker="flatpickr-date" :value="$agenda->tanggal" />
        </div>
        <div class="col-md-6">
            <x-input-with-icon icon="ti ti-calendar" label="Tanggal Selesai" name="tanggal_selesai" datepicker="flatpickr-date" :value="$agenda->tanggal_selesai ?? $agenda->tanggal" />
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <x-input-with-icon icon="ti ti-clock" label="Jam Mulai" name="jam_mulai" placeholder="Contoh: 08:00" :value="$agenda->jam_mulai" />
        </div>
        <div class="col-md-6">
            <x-input-with-icon icon="ti ti-clock" label="Jam Selesai" name="jam_selesai" placeholder="Contoh: 10:00" :value="$agenda->jam_selesai" />
        </div>
    </div>

    <x-input-with-icon icon="ti ti-map-pin" label="Tempat" name="tempat" :value="$agenda->tempat" />

    <div class="form-group mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea name="keterangan" id="keterangan" class="form-control" rows="5">{{ $agenda->keterangan }}</textarea>
    </div>

    <div class="row mb-3">
        <div class="col-md-6 mb-2">
            <button class="btn btn-primary w-100" id="btnSimpan" type="submit">
                <i class="ti ti-device-floppy me-1"></i>
                Simpan
            </button>
        </div>
        @can('agenda.delete')
            <div class="col-md-6 mb-2">
                <button class="btn btn-danger w-100" id="btnHapus" type="button">
                    <i class="ti ti-trash me-1"></i>
                    Hapus
                </button>
            </div>
        @endcan
    </div>
</form>

@can('agenda.delete')
    <form id="formDeleteAgenda" action="{{ route('agenda.delete', ['id' => Crypt::encrypt($agenda->id)]) }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endcan

<script>
    $(function() {
        $(".flatpickr-date").flatpickr();

        @can('agenda.delete')
            $("#btnHapus").click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Agenda ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#formDeleteAgenda").submit();
                    }
                });
            });
        @endcan

        $("#formEditAgenda").submit(function(e) {
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
