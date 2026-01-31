<style>
    .form-select.is-invalid + .select2 .select2-selection {
        border-color: #dc3545 !important;
    }
</style>
<form action="{{ route('guru.store') }}" method="POST" id="formcreateGuru" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="form-group mb-3">
                <label class="form-label fw-bold">Pilih Pegawai (Karyawan) <span class="text-danger">*</span></label>
                <select name="npp" class="form-select select2-karyawan" id="npp">
                    <option value="">Pilih Pegawai</option>
                    @foreach ($karyawan as $d)
                        <option value="{{ $d->npp }}" data-unit="{{ $d->kode_unit }}">{{ $d->nama_lengkap }} - {{ $d->npp }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Silahkan Pilih Pegawai !</div>
            </div>
            <div class="form-group mb-3">
                <label class="form-label fw-bold">Unit Homebase (RDM) <span class="text-danger">*</span></label>
                <select name="kode_unit" class="form-select" id="kode_unit">
                    <option value="">Pilih Unit</option>
                    @foreach ($unit as $u)
                        <option value="{{ $u->kode_unit }}">{{ $u->nama_unit }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Silahkan Pilih Unit !</div>
            </div>
            <div class="form-group mb-3">
                <label class="form-label fw-bold">Jabatan Akademik <span class="text-danger">*</span></label>
                <select name="kode_jabatan" class="form-select" id="kode_jabatan">
                    <option value="">Pilih Jabatan</option>
                    @foreach ($jabatan as $j)
                        <option value="{{ $j->kode_jabatan }}">{{ $j->nama_jabatan }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Silahkan Pilih Jabatan !</div>
            </div>
            <div class="form-group mb-3">
                 <x-input-with-icon label="NIP / NUPTK / PegID" value="" name="nomor_kemenag_dinas" icon="ti ti-id" />
            </div>
            <div class="form-group mb-3">
                <label class="form-label fw-bold">Upload Tanda Tangan (Scan)</label>
                <input type="file" name="file_ttd" class="form-control" accept="image/png, image/jpeg, image/jpg">
                <small class="text-muted">Format: PNG/JPG, Max 2MB. Background transparan lebih baik.</small>
            </div>
            <div class="form-group mb-3">
                <button class="btn btn-primary w-100"><i class="ti ti-send me-1"></i> Simpan Data</button>
            </div>
        </div>
    </div>
</form>

<script>
    $("#npp").change(function(){
        var unit = $(this).find(':selected').data('unit');
        if(unit){
            $("#kode_unit").val(unit);
        }
        validateField($(this));
    });

    $("#kode_unit, #kode_jabatan").change(function(){
        validateField($(this));
    });

    function validateField(field) {
        if(field.val() === "") {
            field.addClass("is-invalid");
        } else {
            field.removeClass("is-invalid");
        }
    }

    $("#formcreateGuru").submit(function(e) {
        let isValid = true;
        
        $("#npp, #kode_unit, #kode_jabatan").each(function() {
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

    // Initialize Select2 if available
    if($('.select2-karyawan').length > 0 && $.fn.select2){
        $('.select2-karyawan').select2({
            dropdownParent: $('#mdlCreateGuru') // Fix select2 inside modal
        });
    }
</script>
