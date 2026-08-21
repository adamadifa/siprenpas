<form action="{{ route('programkerja.update', ['kode_program_kerja' => Crypt::encrypt($programkerja->kode_program_kerja)]) }}" id="formEditProgramKerja"
    method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <x-input-with-icon icon="ti ti-file" label="Program Kerja" name="program_kerja" :value="$programkerja->program_kerja" />
    <div class="form-group mb-3">
        <textarea name="target_pencapaian" id="target_pencapaian" class="form-control" rows="30">{{ $programkerja->target_pencapaian }}</textarea>
    </div>
    <div class="form-group mb-3">
        <textarea name="keterangan" id="keterangan" class="form-control" rows="30">{{ $programkerja->keterangan }}</textarea>
    </div>
    @if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris']))
        <div class="form-group mb-3">
            <select name="kode_unit" id="kode_unit" class="form-select select2Kodeunit">
                <option value="">Unit</option>
                @foreach ($unit as $u)
                    <option value="{{ $u->kode_unit }}" {{ ($programkerja->group->kode_unit ?? '') == $u->kode_unit ? 'selected' : '' }}>
                        {{ strtoupper($u->nama_unit) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <select name="kode_dept" id="kode_dept" class="form-select select2Kodedept">
                <option value="">Departemen</option>
                @foreach ($departemen as $d)
                    <option value="{{ $d->kode_dept }}" {{ ($programkerja->group->kode_dept ?? '') == $d->kode_dept ? 'selected' : '' }}>
                        {{ strtoupper($d->nama_dept) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <select name="kode_jabatan" id="kode_jabatan" class="form-select select2Kodejabatan">
                <option value="">Jabatan</option>
                @foreach ($jabatan as $d)
                    <option value="{{ $d->kode_jabatan }}" {{ ($programkerja->group->kode_jabatan ?? '') == $d->kode_jabatan ? 'selected' : '' }}>
                        {{ strtoUpper($d->nama_jabatan) }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <x-input-with-icon icon="ti ti-calendar" label="Tanggal Pelaksanaan" name="tanggal_pelaksanaan" datepicker="flatpickr-date" :value="$programkerja->tanggal_pelaksanaan" />


    <div class="form-group mb-3">
        <button class="btn btn-primary w-100" id="btnSimpan" type="submit">
            <ion-icon name="send-outline" class="me-1"></ion-icon>
            Simpan
        </button>
    </div>
</form>



<script></script>
<script>
    $(function() {

        $('#target_pencapaian').summernote({
            height: 100,
            placeholder: 'Target Pencapaian...' // Tinggi summernote diatur menjadi 300px
        });

        $('#keterangan').summernote({
            height: 100,
            placeholder: 'Keterangan...' // Tinggi summernote diatur menjadi 300px
        });

        $("#formEditProgramKerja").submit(function(e) {
            let tanggal_pelaksanaan = $(this).find('#tanggal_pelaksanaan').val();
            let kode_dept = $(this).find('#kode_dept').val();
            let kode_jabatan = $(this).find('#kode_jabatan').val();
            let program_kerja = $(this).find('#program_kerja').val();
            let target_pencapaian = $(this).find('#target_pencapaian').val();
            let keterangan = $(this).find('#keterangan').val();

            if (program_kerja == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Program Kerja tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#program_kerja").focus();
                    }
                });
                return false;
            } else if (target_pencapaian == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Target Pencapaian tidak boleh kosong!',
                    didClose: (e) => {
                        $(this).find("#kode_dept").focus();
                    }
                });
                return false;
            } else if (tanggal_pelaksanaan == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal Pelaksanaan tidak boleh kosong!',
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
            } else {
                $("#btnSimpan").attr("disabled", true);
                $("#btnSimpan").html(
                    `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...`
                );
            }
        });
        $("#tanggal_pelaksanaan").flatpickr();
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
            let kode_unit = $("#formEditProgramKerja").find('#kode_unit').val();
            let kode_dept = $("#formEditProgramKerja").find('#kode_dept').val();

            $.ajax({
                url: "{{ route('programkerja.get-karyawan-filter-options') }}",
                type: "GET",
                data: {
                    kode_unit: kode_unit,
                    kode_dept: kode_dept
                },
                success: function(response) {
                    // Update Departemen select options
                    let deptSelect = $("#formEditProgramKerja").find('#kode_dept');
                    let activeDept = deptSelect.val();
                    deptSelect.empty().append('<option value="">Departemen</option>');
                    response.departments.forEach(function(dept) {
                        let selected = activeDept === dept.kode_dept ? 'selected' : '';
                        deptSelect.append(`<option value="${dept.kode_dept}" ${selected}>${dept.nama_dept.toUpperCase()}</option>`);
                    });

                    // Update Jabatan select options
                    let jabSelect = $("#formEditProgramKerja").find('#kode_jabatan');
                    let activeJab = jabSelect.val();
                    jabSelect.empty().append('<option value="">Jabatan</option>');
                    response.jabatans.forEach(function(jab) {
                        let selected = activeJab === jab.kode_jabatan ? 'selected' : '';
                        jabSelect.append(`<option value="${jab.kode_jabatan}" ${selected}>${jab.nama_jabatan.toUpperCase()}</option>`);
                    });
                }
            });
        }

        $("#formEditProgramKerja").find('#kode_unit').change(function() {
            $("#formEditProgramKerja").find('#kode_dept').val('');
            $("#formEditProgramKerja").find('#kode_jabatan').val('');
            updateFilterOptions();
        });

        $("#formEditProgramKerja").find('#kode_dept').change(function() {
            $("#formEditProgramKerja").find('#kode_jabatan').val('');
            updateFilterOptions();
        });

        function getJobdesk() {
            let kode_jabatan = $("#formEditProgramKerja").find('#kode_jabatan').val();
            let kode_dept = $("#formEditProgramKerja").find('#kode_dept').val();

            $.ajax({
                url: "{{ route('jobdesk.getjobdesk') }}",
                type: "GET",
                data: {
                    kode_jabatan: kode_jabatan,
                    kode_dept: kode_dept
                },
                cache: false,
                success: function(response) {
                    for (let i = 0; i < response.length; i++) {
                        $("#formEditProgramKerja").find("#kode_jobdesk").append('<option value="' + response[i]
                            .kode_jobdesk + '">' + response[i].jobdesk + '</option>');
                    }
                }
            })
        }

        $("#formEditProgramKerja").find('#kode_jabatan, #kode_dept').on('change', function() {
            getJobdesk();
        });
    });
</script>
