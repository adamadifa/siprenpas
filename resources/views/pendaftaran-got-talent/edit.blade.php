<form action="{{ route('pendaftarangottalent.update', Crypt::encrypt($pendaftaranGotTalent->id)) }}"
    id="formeditPendaftaranGotTalent" method="POST">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap" name="nama_lengkap"
        value="{{ $pendaftaranGotTalent->nama_lengkap }}" />
    <x-select-label label="Jenjang Pendidikan" name="id_jenjang" :data="$jenjangPendidikan" key="id"
        textShow="jenjang_pendidikan" selected="{{ $pendaftaranGotTalent->id_jenjang }}" />
    <x-input-with-icon-label icon="ti ti-school" label="Asal Sekolah" name="asal_sekolah"
        value="{{ $pendaftaranGotTalent->asal_sekolah }}" />
    <x-textarea-label label="Alamat Sekolah" name="alamat_sekolah" value="{{ $pendaftaranGotTalent->alamat_sekolah }}" />
    <x-textarea-label label="Alamat Rumah" name="alamat_rumah" value="{{ $pendaftaranGotTalent->alamat_rumah }}" />
    <x-input-with-icon-label icon="ti ti-phone" label="No. HP" name="no_hp" value="{{ $pendaftaranGotTalent->no_hp ?? '' }}" />
    <x-input-with-icon-label icon="ti ti-mail" label="Email" name="email" type="email" value="{{ $pendaftaranGotTalent->email ?? '' }}" />
    
    <div class="form-group mb-3">
        <label class="form-label">Pilihan Lomba</label>
        @if ($perlombaan && $perlombaan->count() > 0)
            <div class="row">
                @foreach ($perlombaan as $lomba)
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="perlombaan[]" 
                                value="{{ $lomba->id }}" id="perlombaan_{{ $lomba->id }}"
                                {{ in_array($lomba->id, $selectedPerlombaan ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perlombaan_{{ $lomba->id }}">
                                {{ $lomba->jenis_perlombaan }} 
                                <small class="text-muted">({{ $lomba->jenjangPendidikan->jenjang_pendidikan ?? '-' }})</small>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Belum ada data perlombaan</p>
        @endif
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
        const formeditPendaftaranGotTalent = $("#formeditPendaftaranGotTalent");
        
        formeditPendaftaranGotTalent.submit(function(e) {
            e.preventDefault();
            var nama_lengkap = $(this).find('input[name="nama_lengkap"]').val().trim();
            var id_jenjang = $(this).find('select[name="id_jenjang"]').val();
            var asal_sekolah = $(this).find('input[name="asal_sekolah"]').val().trim();
            var alamat_sekolah = $(this).find('textarea[name="alamat_sekolah"]').val().trim();
            var alamat_rumah = $(this).find('textarea[name="alamat_rumah"]').val().trim();
            var no_hp = $(this).find('input[name="no_hp"]').val().trim();
            var email = $(this).find('input[name="email"]').val().trim();
            var perlombaan = $('input[name="perlombaan[]"]:checked').length;

            if (nama_lengkap == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama Lengkap tidak boleh kosong!',
                    didClose: () => {
                        $(this).find("#nama_lengkap").focus();
                    }
                });
                return false;
            } else if (id_jenjang == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jenjang Pendidikan tidak boleh kosong!',
                    didClose: () => {
                        $(this).find("#id_jenjang").focus();
                    }
                });
                return false;
            } else if (asal_sekolah == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Asal Sekolah tidak boleh kosong!',
                    didClose: () => {
                        $(this).find("#asal_sekolah").focus();
                    }
                });
                return false;
            } else if (alamat_sekolah == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Alamat Sekolah tidak boleh kosong!',
                    didClose: () => {
                        $(this).find("#alamat_sekolah").focus();
                    }
                });
                return false;
            } else if (alamat_rumah == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Alamat Rumah tidak boleh kosong!',
                    didClose: () => {
                        $(this).find("#alamat_rumah").focus();
                    }
                });
                return false;
            } else if (no_hp == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'No. HP tidak boleh kosong!',
                    didClose: () => {
                        $(this).find("#no_hp").focus();
                    }
                });
                return false;
            } else if (email == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Email tidak boleh kosong!',
                    didClose: () => {
                        $(this).find("#email").focus();
                    }
                });
                return false;
            } else if (perlombaan == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Pilihan Lomba harus dipilih minimal 1!'
                });
                return false;
            } else {
                $(this).find('button[type="submit"]').attr('disabled', 'disabled');
                $(this).find('button[type="submit"]').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                );
                this.submit();
            }
        });
    });
</script>

