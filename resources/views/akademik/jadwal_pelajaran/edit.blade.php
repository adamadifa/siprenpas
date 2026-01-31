<form action="{{ route('jadwal-pelajaran.update', Crypt::encrypt($jadwal->id)) }}" method="POST" id="formEdit">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            
            <div class="mb-2">
                <label class="form-label fw-bold small">Unit <span class="text-danger">*</span></label>
                <select name="kode_unit" id="edit_kode_unit" class="form-select select2 form-select-sm">
                    <option value="">Pilih Unit</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->kode_unit }}" {{ $jadwal->kode_unit == $unit->kode_unit ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                    @endforeach
                </select>
                 <div class="invalid-feedback">Silahkan Pilih Unit !</div>
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold small">Kelas <span class="text-danger">*</span></label>
                <select name="kode_kelas" id="edit_kode_kelas" class="form-select select2 form-select-sm">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->kode_kelas }}" {{ $jadwal->kode_kelas == $k->kode_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }} ({{ $k->unit->nama_unit ?? '-' }})</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Silahkan Pilih Kelas !</div>
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold small">Semester <span class="text-danger">*</span></label>
                <select name="semester" id="edit_semester" class="form-select select2 form-select-sm">
                    <option value="">Pilih Semester</option>
                    <option value="1" {{ $jadwal->semester == '1' ? 'selected' : '' }}>Ganjil</option>
                    <option value="2" {{ $jadwal->semester == '2' ? 'selected' : '' }}>Genap</option>
                </select>
                <div class="invalid-feedback">Silahkan Pilih Semester !</div>
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold small">Mata Pelajaran <span class="text-danger">*</span></label>
                <select name="mata_pelajaran_id" id="edit_mata_pelajaran_id" class="form-select select2 form-select-sm">
                    <option value="">Pilih Mapel</option>
                    @foreach ($mapels as $mapel)
                        <option value="{{ $mapel->id }}" {{ $jadwal->mata_pelajaran_id == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_matpel }} ({{ $mapel->kelompok }})</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Silahkan Pilih Mapel !</div>
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold small">Guru Pengampu <span class="text-danger">*</span></label>
                <select name="guru_id" id="edit_guru_id" class="form-select select2 form-select-sm">
                    <option value="">Pilih Guru</option>
                    @foreach ($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ $jadwal->guru_id == $guru->id ? 'selected' : '' }}>{{ $guru->nama_guru }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Silahkan Pilih Guru !</div>
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold small">Hari <span class="text-danger">*</span></label>
                <select name="hari" id="edit_hari" class="form-select select2 form-select-sm">
                    <option value="">Pilih Hari</option>
                    @php
                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'];
                    @endphp
                    @foreach ($days as $day)
                        <option value="{{ $day }}" {{ $jadwal->hari == $day ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Silahkan Pilih Hari !</div>
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold small">Jam Ke <span class="text-danger">*</span></label>
                <input type="number" class="form-control form-control-sm" name="jam_ke" id="edit_jam_ke" value="{{ $jadwal->jam_ke }}" placeholder="1">
                 <div class="invalid-feedback">Masukan Jam Ke !</div>
            </div>

             <div class="row">
                <div class="col-6 mb-2">
                    <label class="form-label fw-bold small">Jam Mulai <span class="text-danger">*</span></label>
                    <input type="time" class="form-control form-control-sm" name="jam_mulai" id="edit_jam_mulai" value="{{ $jadwal->jam_mulai }}">
                    <div class="invalid-feedback">Masukan Jam Mulai !</div>
                </div>
                 <div class="col-6 mb-2">
                    <label class="form-label fw-bold small">Jam Selesai <span class="text-danger">*</span></label>
                    <input type="time" class="form-control form-control-sm" name="jam_selesai" id="edit_jam_selesai" value="{{ $jadwal->jam_selesai }}">
                    <div class="invalid-feedback">Masukan Jam Selesai !</div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                     <button type="submit" class="btn btn-primary w-100 btn-sm"><i class="ti ti-device-floppy me-1"></i>Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    /* Style untuk select2 yang error - Sesuai Guru Page */
    .form-select.is-invalid + .select2 .select2-selection {
        border-color: #dc3545 !important;
    }
</style>

<script>
    $(document).ready(function() {
        // Scoped Select2 Init
        $("#formEdit .select2").select2({
            dropdownParent: $('#mdlEditJadwal')
        });

        // AJAX Dynamic Loading for Unit -> Kelas & Mapel & Guru (Edit Page)
        $("#edit_kode_unit").change(function() {
            var kode_unit = $(this).val();
            
            if(kode_unit) {
                // Show loading state
                $("#edit_kode_kelas").html('<option value="">Loading...</option>').prop('disabled', true);
                $("#edit_mata_pelajaran_id").html('<option value="">Loading...</option>').prop('disabled', true);
                $("#edit_guru_id").html('<option value="">Loading...</option>').prop('disabled', true);
                
                $.ajax({
                    url: "{{ route('jadwal-pelajaran.get-data-by-unit') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_unit: kode_unit
                    },
                    dataType: "json",
                    success: function(data) {
                        if(data.status == 'success') {
                            // Populate Kelas
                            var kelasOptions = '<option value="">Pilih Kelas</option>';
                            $.each(data.kelas, function(key, value) {
                                kelasOptions += '<option value="'+ value.kode_kelas +'">'+ value.nama_kelas +'</option>';
                            });
                            $("#edit_kode_kelas").html(kelasOptions).prop('disabled', false);
                            
                            // Populate Mapel
                            var mapelOptions = '<option value="">Pilih Mapel</option>';
                            $.each(data.mapel, function(key, value) {
                                mapelOptions += '<option value="'+ value.id +'">'+ value.nama_matpel +' ('+ value.kelompok +')</option>';
                            });
                            $("#edit_mata_pelajaran_id").html(mapelOptions).prop('disabled', false);

                            // Populate Guru
                            var guruOptions = '<option value="">Pilih Guru</option>';
                            $.each(data.guru, function(key, value) {
                                guruOptions += '<option value="'+ value.id +'">'+ value.nama_guru +'</option>';
                            });
                            $("#edit_guru_id").html(guruOptions).prop('disabled', false);

                            // Trigger Select2 update
                            $("#edit_kode_kelas, #edit_mata_pelajaran_id, #edit_guru_id").trigger('change');
                        } else {
                            alert("Error: " + data.message);
                        }
                    },
                    error: function() {
                        alert("Terjadi kesalahan saat mengambil data.");
                        $("#edit_kode_kelas").html('<option value="">Pilih Kelas</option>').prop('disabled', false);
                        $("#edit_mata_pelajaran_id").html('<option value="">Pilih Mapel</option>').prop('disabled', false);
                        $("#edit_guru_id").html('<option value="">Pilih Guru</option>').prop('disabled', false);
                    }
                });
            } else {
                $("#edit_kode_kelas").html('<option value="">Pilih Kelas</option>');
                $("#edit_mata_pelajaran_id").html('<option value="">Pilih Mapel</option>');
                $("#edit_guru_id").html('<option value="">Pilih Guru</option>');
            }
        });

        // Event Listener untuk Select2
        $("#edit_kode_unit, #edit_kode_kelas, #edit_mata_pelajaran_id, #edit_guru_id, #edit_hari, #edit_semester").change(function() {
            validateField($(this));
        });

        // Event Listener untuk Input biasa
        $("#edit_jam_ke, #edit_jam_mulai, #edit_jam_selesai").on("keyup change", function() {
            validateField($(this));
        });

        function validateField(field) {
            if (field.val() === '' || field.val() === null) {
                field.addClass('is-invalid');
            } else {
                field.removeClass('is-invalid');
            }
        }

        // Form Submission Validation
        $("#formEdit").submit(function(e) {
            let isValid = true;
            
            // Validate specific fields by ID
            const requiredFields = [
                '#edit_kode_unit', 
                '#edit_kode_kelas', 
                '#edit_mata_pelajaran_id', 
                '#edit_guru_id', 
                '#edit_hari', 
                '#edit_semester',
                '#edit_jam_ke',
                '#edit_jam_mulai',
                '#edit_jam_selesai'
            ];

            $(requiredFields.join(', ')).each(function() {
                if($(this).val() === "" || $(this).val() === null) {
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
