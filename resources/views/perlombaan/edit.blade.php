<form action="{{ route('perlombaan.update', Crypt::encrypt($perlombaan->id)) }}" id="formeditPerlombaan" method="POST">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-file-description" label="Jenis Perlombaan" name="jenis_perlombaan"
        value="{{ $perlombaan->jenis_perlombaan }}" />
    <x-select-label label="Jenjang Pendidikan" name="id_jenjang" :data="$jenjangPendidikan"
        key="id" textShow="jenjang_pendidikan" selected="{{ $perlombaan->id_jenjang }}" />
    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Submit
        </button>
    </div>
</form>
<script>
    $(function() {
        $("#formeditPerlombaan").submit(function() {
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






