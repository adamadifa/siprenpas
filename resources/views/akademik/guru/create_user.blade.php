<form action="{{ route('guru.storeUser', Crypt::encrypt($guru->id)) }}" method="POST" id="formManagePasswordGuru">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info d-flex align-items-center mb-3" role="alert">
                <i class="ti ti-info-circle me-2"></i>
                <div>Kelola password login khusus untuk aplikasi Guru.</div>
            </div>

            <div class="form-group mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" class="form-control bg-light" value="{{ $guru->nama_lengkap }}" readonly disabled>
            </div>
            <div class="form-group mb-3">
                <label class="form-label fw-bold">Username (NPP)</label>
                <input type="text" class="form-control bg-light" value="{{ $guru->npp }}" readonly disabled>
            </div>
            <div class="form-group mb-3">
                <label class="form-label fw-bold">Password Baru</label>
                <div class="input-group input-group-merge">
                    <input type="password" name="password" id="password_guru" class="form-control" placeholder="Kosongkan untuk menggunakan NPP">
                    <span class="input-group-text cursor-pointer" id="togglePasswordGuru"><i class="ti ti-eye-off"></i></span>
                </div>
                <small class="text-muted">Jika dikosongkan, password akan otomatis diset ke NPP ({{ $guru->npp }}).</small>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 text-end">
            <button type="button" class="btn btn-label-secondary me-1" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary shadow-sm" style="background-color: #064e3b; border-color: #064e3b">
                <i class="ti ti-device-floppy me-1"></i> Simpan Password
            </button>
        </div>
    </div>
</form>

<script>
    $(function() {
        $("#togglePasswordGuru").click(function() {
            const type = $("#password_guru").attr("type") === "password" ? "text" : "password";
            $("#password_guru").attr("type", type);
            $(this).find("i").toggleClass("ti-eye ti-eye-off");
        });
    });
</script>
