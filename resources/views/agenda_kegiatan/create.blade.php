<form action="{{ route('agendakegiatan.store') }}" id="formCreateAgendakegiatan" method="POST" enctype="multipart/form-data">
    @csrf
    <x-input-with-icon icon="ti ti-calendar" label="Tanggal" name="tanggal" datepicker="flatpickr-date" />
    <x-input-with-icon icon="ti ti-file-description" label="Nama Kegiatan" name="nama_kegiatan" />
    @if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris']))
        <div class="form-group mb-3">
            <select name="kode_unit" id="kode_unit" class="form-select select2Kodeunit">
                <option value="">Unit</option>
                @foreach ($unit as $u)
                    <option value="{{ $u->kode_unit }}">{{ strtoupper($u->nama_unit) }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <select name="kode_dept" id="kode_dept" class="form-select select2Kodedept">
                <option value="">Departemen</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <select name="kode_jabatan" id="kode_jabatan" class="form-select select2Kodejabatan">
                <option value="">Jabatan</option>
            </select>
        </div>
    @endif


    <div class="form-group mb-3">
        <textarea name="uraian_kegiatan" id="uraian_kegiatan" class="form-control" rows="30"></textarea>
    </div>

    <div class="form-group mb-3">
        <button class="btn btn-primary w-100" id="btnSimpan" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Submit
        </button>
    </div>
</form>



<script></script>
<script>
    $(function() {

        $('#uraian_kegiatan').summernote({
            height: 200 // Tinggi summernote diatur menjadi 300px
        });

        $("#formCreateAgendakegiatan").submit(function(e) {
            let tanggal = $(this).find('#tanggal').val();
            let kode_dept = $(this).find('#kode_dept').val();
            let kode_jabatan = $(this).find('#kode_jabatan').val();
            let nama_kegiatan = $(this).find('#nama_kegiatan').val();
            let uraian_kegiatan = $(this).find('#uraian_kegiatan').val();
            let kode_jobdesk = $(this).find('#kode_jobdesk').val();

            if (tanggal == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#tanggal").focus();
                    }
                });
                return false;
            } else if (kode_dept == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Departemen tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#kode_dept").focus();
                    }
                });
                return false;
            } else if (kode_jabatan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Jabatan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#kode_jabatan").focus();
                    }
                });
                return false;
            } else if (nama_kegiatan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nama kegiatan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#uraian_kegiatan").focus();
                    }
                });
                return false;
            } else if (uraian_kegiatan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Uraian kegiatan tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#uraian_kegiatan").focus();
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
        $("#tanggal").flatpickr();
        const select2Kodeunit = $('.select2Kodeunit');
        if (select2Kodeunit.length) {
            select2Kodeunit.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Unit',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

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

        const select2Kodejobdesk = $('.select2Kodejobdesk');
        if (select2Kodejobdesk.length) {
            select2Kodejobdesk.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih  Jobdesk',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        function updateFilterOptions() {
            let kode_unit = $("#formCreateAgendakegiatan").find('#kode_unit').val();
            let kode_dept = $("#formCreateAgendakegiatan").find('#kode_dept').val();

            if (kode_unit === "" || kode_unit === null) {
                let deptSelect = $("#formCreateAgendakegiatan").find('#kode_dept');
                deptSelect.empty().append('<option value="">Departemen</option>').trigger('change.select2');
                let jabSelect = $("#formCreateAgendakegiatan").find('#kode_jabatan');
                jabSelect.empty().append('<option value="">Jabatan</option>').trigger('change.select2');
                return;
            }

            if (kode_dept === "" || kode_dept === null) {
                let jabSelect = $("#formCreateAgendakegiatan").find('#kode_jabatan');
                jabSelect.empty().append('<option value="">Jabatan</option>').trigger('change.select2');
            }

            $.ajax({
                url: "{{ route('programkerja.get-karyawan-filter-options') }}",
                type: "GET",
                data: {
                    kode_unit: kode_unit,
                    kode_dept: kode_dept
                },
                success: function(response) {
                    // Update Departemen select options
                    let deptSelect = $("#formCreateAgendakegiatan").find('#kode_dept');
                    let activeDept = deptSelect.val();
                    deptSelect.empty().append('<option value="">Departemen</option>');
                    response.departments.forEach(function(dept) {
                        let selected = activeDept === dept.kode_dept ? 'selected' : '';
                        deptSelect.append(`<option value="${dept.kode_dept}" ${selected}>${dept.nama_dept.toUpperCase()}</option>`);
                    });
                    deptSelect.trigger('change.select2');

                    // Update Jabatan select options (only if Departemen is selected)
                    let jabSelect = $("#formCreateAgendakegiatan").find('#kode_jabatan');
                    let activeJab = jabSelect.val();
                    jabSelect.empty().append('<option value="">Jabatan</option>');
                    if (kode_dept !== "" && kode_dept !== null) {
                        response.jabatans.forEach(function(jab) {
                            let selected = activeJab === jab.kode_jabatan ? 'selected' : '';
                            jabSelect.append(`<option value="${jab.kode_jabatan}" ${selected}>${jab.nama_jabatan.toUpperCase()}</option>`);
                        });
                    }
                    jabSelect.trigger('change.select2');
                }
            });
        }

        $("#formCreateAgendakegiatan").find('#kode_unit').change(function() {
            $("#formCreateAgendakegiatan").find('#kode_dept').val('').trigger('change.select2');
            $("#formCreateAgendakegiatan").find('#kode_jabatan').val('').trigger('change.select2');
            updateFilterOptions();
        });

        $("#formCreateAgendakegiatan").find('#kode_dept').change(function() {
            $("#formCreateAgendakegiatan").find('#kode_jabatan').val('').trigger('change.select2');
            updateFilterOptions();
        });

    });
</script>
