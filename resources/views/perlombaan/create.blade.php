<form action="{{ route('perlombaan.store') }}" id="formcreatePerlombaan" method="POST">
    @csrf
    <x-input-with-icon icon="ti ti-file-description" label="Jenis Perlombaan" name="jenis_perlombaan" />
    <select name="id_jenjang" id="id_jenjang" class="form-select">
        <option value="">Jenjang Pendidikan</option>
        @foreach ($jenjangPendidikan as $d)
            <option value="{{ $d->id }}">{{ $d->jenjang_pendidikan }}</option>
        @endforeach
    </select>
    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Submit
        </button>
    </div>
</form>
<script>
    $(function() {
        $("#formcreatePerlombaan").submit(function() {
            var jenis_perlombaan = $("#jenis_perlombaan").val();
            var id_jenjang = $("#id_jenjang").val();
            if (jenis_perlombaan == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Jenis Perlombaan Harus Diisi !',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#jenis_perlombaan").focus();
                });
                return false;
            }
            if (id_jenjang == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Jenjang Pendidikan Harus Dipilih !',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#id_jenjang").focus();
                });
                return false;
            }
        });
    });
</script>
