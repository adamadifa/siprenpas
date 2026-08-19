<form action="{{ route('jobdesk.update', ['kode_jobdesk' => Crypt::encrypt($jobdesk->kode_jobdesk)]) }}" id="formEditJobdesk" method="POST">
    @csrf
    @method('PUT')
    @hasanyrole('super admin')
        <div class="form-group mb-3">
            <select name="kode_jabatan" id="kode_jabatan" class="form-select select2Kodejabatan">
                <option value="">Jabatan</option>
                @foreach ($jabatan as $d)
                    <option value="{{ $d->kode_jabatan }}" {{ $jobdesk->kode_jabatan == $d->kode_jabatan ? 'selected' : '' }}>
                        {{ strtoUpper($d->nama_jabatan) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <select name="kode_dept" id="kode_dept" class="form-select select2Kodedept">
                <option value="">Departemen</option>
                @foreach ($departemen as $d)
                    <option value="{{ $d->kode_dept }}" {{ $jobdesk->kode_dept == $d->kode_dept ? 'selected' : '' }}>
                        {{ strtoupper($d->nama_dept) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <select name="kode_unit" id="kode_unit" class="form-select select2Kodeunit">
                <option value="">Pilih Unit (Opsional)</option>
                @foreach ($unit as $d)
                    <option value="{{ $d->kode_unit }}" {{ $jobdesk->kode_unit == $d->kode_unit ? 'selected' : '' }}>
                        {{ strtoupper($d->nama_unit) }}
                    </option>
                @endforeach
            </select>
        </div>
    @endhasanyrole

    <x-textarea label="Jobdesk" name="jobdesk" :value="$jobdesk->jobdesk" />
    <div class="form-group mb-3">
        <button class="btn btn-primary w-100" id="btnSimpan" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Simpan
        </button>
    </div>
</form>

<script>
    $(function() {
        const select2Kodedept = $('.select2Kodedept');
        if (select2Kodedept.length) {
            select2Kodedept.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih  Departemen',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }
        const select2Kodeunit = $('.select2Kodeunit');
        if (select2Kodeunit.length) {
            select2Kodeunit.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Unit (Opsional)',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }
        $("#jobdesk").summernote({
            height: 200,
            placeholder: 'Jobdesk...'
        });
        const select2Kodejabatan = $('.select2Kodejabatan');
        if (select2Kodejabatan.length) {
            select2Kodejabatan.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih  Jabatan',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        const form = $('#formEditJobdesk');
        form.submit(function(e) {
            let kode_jabatan = form.find('#kode_jabatan').val();
            let kode_dept = form.find('#kode_dept').val();
            let jobdesk = form.find('#jobdesk').val();
            if (kode_jabatan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jabatan tidak boleh kosong!',
                    didClose: (e) => {
                        form.find("#kode_jabatan").focus();
                    }
                });
                return false;
            } else if (kode_dept == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Departemen tidak boleh kosong!',
                    didClose: (e) => {
                        form.find("#kode_dept").focus();
                    }
                });
                return false;
            } else if (jobdesk == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jobdesk tidak boleh kosong!',
                    didClose: (e) => {
                        form.find("#jobdesk").focus();
                    }
                });
                return false;
            } else {
                $("#btnSimpan").attr("disabled", true);
                $("#btnSimpan").html(
                    `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...`
                );
            }
        })
    });
</script>
