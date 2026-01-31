<style>
    .form-select.is-invalid + .select2 .select2-selection {
        border-color: #dc3545 !important;
    }
</style>
<form action="{{ route('mata-pelajaran.update', Crypt::encrypt($matapelajaran->id)) }}" method="POST" id="formMatpelEdit">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            <div class="row mb-2">
                <div class="col-6">
                    <label class="form-label fw-bold">Unit <span class="text-danger">*</span></label>
                    <select name="kode_unit" class="form-select select2" id="kode_unit">
                        <option value="">Semua Unit</option>
                        @foreach ($units as $u)
                            <option value="{{ $u->kode_unit }}" {{ $matapelajaran->kode_unit == $u->kode_unit ? 'selected' : '' }}>{{ $u->nama_unit }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Silahkan Pilih Unit !</div>
                </div>
                 <div class="col-6">
                    <label class="form-label fw-bold">Kode Mapel</label>
                    <input type="text" class="form-control" name="kode_matpel" value="{{ $matapelajaran->kode_matpel }}" readonly>
                </div>
            </div>

            <div class="form-group mb-2">
                <label class="form-label fw-bold">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="nama_matpel" id="nama_matpel" value="{{ $matapelajaran->nama_matpel }}" placeholder="Nama Mata Pelajaran">
                <div class="invalid-feedback">Silahkan Isi Nama Mata Pelajaran !</div>
            </div>

            <div class="row mb-2">
                 <div class="col-6">
                    <label class="form-label fw-bold">Kelompok <span class="text-danger">*</span></label>
                    <select name="kelompok" class="form-select" id="kelompok">
                        <option value="A" {{ $matapelajaran->kelompok == 'A' ? 'selected' : '' }}>Kelompok A</option>
                        <option value="B" {{ $matapelajaran->kelompok == 'B' ? 'selected' : '' }}>Kelompok B</option>
                        <option value="C" {{ $matapelajaran->kelompok == 'C' ? 'selected' : '' }}>Kelompok C</option>
                    </select>
                    <div class="invalid-feedback">Silahkan Pilih Kelompok !</div>
                </div>
                <div class="col-6">
                    <label class="form-label fw-bold">Urutan <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="urutan" id="urutan" value="{{ $matapelajaran->urutan }}">
                    <div class="invalid-feedback">Silahkan Isi Urutan !</div>
                </div>
            </div>

            <div class="form-group mb-2">
                <label class="form-label fw-bold">Parent (Mapel Induk)</label>
                <select name="parent_id" class="form-select select2">
                    <option value="">-- Tidak Ada --</option>
                    @foreach ($parents as $p)
                        <option value="{{ $p->id }}" {{ $matapelajaran->parent_id == $p->id ? 'selected' : '' }}>{{ $p->nama_matpel }} (Kelompok {{ $p->kelompok }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-check mb-3 mt-3">
                <input class="form-check-input" type="checkbox" name="aktif" id="aktif" {{ $matapelajaran->aktif ? 'checked' : '' }}>
                <label class="form-check-label" for="aktif">
                    Aktif
                </label>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary w-100"><i class="ti ti-send me-1"></i> Update Data</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Initialize Select2 inside modal
        $('.select2').select2({
            dropdownParent: $('#modal'), 
            width: '100%',
            placeholder: 'Pilih Opsi'
        });

        // Event Listeners for validation
        $("#kode_unit, #nama_matpel, #kelompok, #urutan").change(function(){
            validateField($(this));
        });

        $("#nama_matpel, #urutan").keyup(function(){
            validateField($(this));
        });

        function validateField(field) {
            if(field.val() === "") {
                field.addClass("is-invalid");
            } else {
                field.removeClass("is-invalid");
            }
        }

        $("#formMatpelEdit").submit(function(e) {
            let isValid = true;
            
            $("#kode_unit, #nama_matpel, #kelompok, #urutan").each(function() {
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
    });
</script>
