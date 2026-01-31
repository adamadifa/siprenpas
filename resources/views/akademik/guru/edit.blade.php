<style>
    .form-select.is-invalid + .select2 .select2-selection {
        border-color: #dc3545 !important;
    }
</style>
<form action="{{ route('guru.update', Crypt::encrypt($guru->id)) }}" method="POST" id="formeditGuru" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="ti ti-info-circle me-2"></i>
                <div>
                    <strong>{{ $guru->karyawan->nama_lengkap }}</strong><br>
                    NPP: {{ $guru->npp }}
                </div>
            </div>
            
            <div class="form-group mb-3">
                <label class="form-label fw-bold">Unit Homebase (RDM) <span class="text-danger">*</span></label>
                <select name="kode_unit" class="form-select" id="kode_unit_edit">
                    <option value="">Pilih Unit</option>
                    @foreach ($unit as $u)
                        <option value="{{ $u->kode_unit }}" {{ $guru->kode_unit == $u->kode_unit ? 'selected' : '' }}>{{ $u->nama_unit }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Silahkan Pilih Unit !</div>
            </div>
            <div class="form-group mb-3">
                <label class="form-label fw-bold">Jabatan Akademik <span class="text-danger">*</span></label>
                <select name="kode_jabatan" class="form-select" id="kode_jabatan_edit">
                    <option value="">Pilih Jabatan</option>
                    @foreach ($jabatan as $j)
                        <option value="{{ $j->kode_jabatan }}" {{ $guru->kode_jabatan == $j->kode_jabatan ? 'selected' : '' }}>{{ $j->nama_jabatan }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Silahkan Pilih Jabatan !</div>
            </div>
            <div class="form-group mb-3">
                 <x-input-with-icon label="NIP / NUPTK / PegID" value="{{ $guru->nomor_kemenag_dinas }}" name="nomor_kemenag_dinas" icon="ti ti-id" />
            </div>
            <div class="form-group mb-3">
                <label class="form-label fw-bold">Status Mengajar <span class="text-danger">*</span></label>
                <select name="status_aktif_ajar" class="form-select">
                    <option value="1" {{ $guru->status_aktif_ajar == 1 ? 'selected' : '' }}>Aktif Mengajar</option>
                    <option value="0" {{ $guru->status_aktif_ajar == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label class="form-label fw-bold">Upload Tanda Tangan (Isi jika ingin mengganti)</label>
                <input type="file" name="file_ttd" class="form-control" accept="image/png, image/jpeg, image/jpg">
                @if($guru->file_ttd)
                    <div class="mt-2">
                        <small>Current file:</small>
                        <a href="{{ asset('storage/uploads/ttd_guru/' . $guru->file_ttd) }}" target="_blank" class="badge bg-primary">Lihat TTD</a>
                    </div>
                @endif
                <small class="text-muted">Format: PNG/JPG, Max 2MB. Background transparan lebih baik.</small>
            </div>
            <div class="form-group mb-3">
                <button class="btn btn-primary w-100"><i class="ti ti-send me-1"></i> Update Data</button>
            </div>
        </div>
    </div>
</form>

<script>
    $("#kode_unit_edit, #kode_jabatan_edit").change(function(){
        validateFieldEdit($(this));
    });

    function validateFieldEdit(field) {
        if(field.val() === "") {
            field.addClass("is-invalid");
        } else {
            field.removeClass("is-invalid");
        }
    }

    $("#formeditGuru").submit(function(e) {
        let isValid = true;
        
        $("#kode_unit_edit, #kode_jabatan_edit").each(function() {
             if($(this).val() === "") {
                 $(this).addClass("is-invalid");
                 isValid = false;
             } else {
                 $(this).removeClass("is-invalid");
             }
        });

        if (!isValid) {
            e.preventDefault();
        }
    });
</script>
