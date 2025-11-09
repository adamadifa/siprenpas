<form action="{{ route('jenjang-pendidikan.update', Crypt::encrypt($jenjangPendidikan->id)) }}" id="formeditJenjangPendidikan" method="POST">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-file-description" label="Jenjang Pendidikan" name="jenjang_pendidikan"
        value="{{ $jenjangPendidikan->jenjang_pendidikan }}" />
    <div class="form-group">
        <button class="btn btn-primary w-100" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Submit
        </button>
    </div>
</form>
<script>
    $(function() {
        $("#formeditJenjangPendidikan").submit(function() {
            var jenjang_pendidikan = $("#jenjang_pendidikan").val();
            if (jenjang_pendidikan == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Jenjang Pendidikan Harus Diisi !',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#jenjang_pendidikan").focus();
                });
                return false;
            }
        });
    });
</script>


