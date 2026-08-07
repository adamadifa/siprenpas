<form action="{{ route('jadwal-pelajaran.store') }}" method="POST" id="formCreate">
    @csrf
    <div class="row">
        <div class="col-12">
            
            <div class="mb-2">
                <label class="form-label fw-bold small">Unit <span class="text-danger">*</span></label>
                <select name="kode_unit" id="create_kode_unit" class="form-select select2 form-select-sm">
                    @if(count($units) > 1)
                        <option value="">Pilih Unit</option>
                    @endif
                    @foreach ($units as $unit)
                        <option value="{{ $unit->kode_unit }}" {{ count($units) == 1 ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                    @endforeach
                </select>
                 <div class="invalid-feedback">Silahkan Pilih Unit !</div>
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold small">Kelas <span class="text-danger">*</span></label>
                <select name="kode_kelas" id="create_kode_kelas" class="form-select select2 form-select-sm">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->kode_kelas }}">{{ $k->nama_kelas }} ({{ $k->unit->nama_unit ?? '-' }})</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Silahkan Pilih Kelas !</div>
            </div>

             <div class="mb-2">
                <label class="form-label fw-bold small">Semester <span class="text-danger">*</span></label>
                <select name="semester" id="create_semester" class="form-select select2 form-select-sm">
                    <option value="">Pilih Semester</option>
                    <option value="1">Ganjil</option>
                    <option value="2">Genap</option>
                </select>
                <div class="invalid-feedback">Silahkan Pilih Semester !</div>
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold small">Mata Pelajaran <span class="text-danger">*</span></label>
                <select name="mata_pelajaran_id" id="create_mata_pelajaran_id" class="form-select select2 form-select-sm">
                    <option value="">Pilih Mapel</option>
                    @foreach ($mapels as $mapel)
                        <option value="{{ $mapel->id }}" data-parent="{{ is_null($mapel->parent_id) ? 'true' : 'false' }}" style="{{ is_null($mapel->parent_id) ? 'font-weight: bold;' : '' }}">
                            {{ $mapel->nama_matpel }} ({{ $mapel->kelompok }})
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Silahkan Pilih Mapel !</div>
            </div>

             <div class="mb-2">
                <label class="form-label fw-bold small">Guru Pengampu <span class="text-danger">*</span></label>
                <select name="guru_id" id="create_guru_id" class="form-select select2 form-select-sm">
                    <option value="">Pilih Guru</option>
                    @foreach ($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Silahkan Pilih Guru !</div>
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold small">Hari <span class="text-danger">*</span></label>
                <select name="hari" id="create_hari" class="form-select select2 form-select-sm">
                    <option value="">Pilih Hari</option>
                    @php
                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'];
                    @endphp
                    @foreach ($days as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Silahkan Pilih Hari !</div>
            </div>

             <div class="mb-2">
                <label class="form-label fw-bold small">Jam Ke <span class="text-danger">*</span></label>
                <input type="number" class="form-control form-control-sm" name="jam_ke" id="create_jam_ke" placeholder="1">
                 <div class="invalid-feedback">Masukan Jam Ke !</div>
            </div>

             <div class="row">
                <div class="col-6 mb-2">
                    <label class="form-label fw-bold small">Jam Mulai <span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-clock text-muted"></i></span>
                        <input type="text" class="form-control form-control-sm" name="jam_mulai" id="create_jam_mulai" placeholder="07:30">
                    </div>
                    <div class="invalid-feedback">Masukan Jam Mulai !</div>
                </div>
                 <div class="col-6 mb-2">
                    <label class="form-label fw-bold small">Jam Selesai <span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ti ti-clock text-muted"></i></span>
                        <input type="text" class="form-control form-control-sm" name="jam_selesai" id="create_jam_selesai" placeholder="08:30">
                    </div>
                    <div class="invalid-feedback">Masukan Jam Selesai !</div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                     <button type="submit" class="btn btn-primary w-100 btn-sm"><i class="ti ti-send me-1"></i>Simpan</button>
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
        // Apply time masking
        $("#create_jam_mulai, #create_jam_selesai").mask('00:00');

        function formatMapelOption(state) {
            if (!state.id) {
                return state.text;
            }
            var element = $(state.element);
            if (element.data('parent') === true || element.data('parent') === "true") {
                return $('<strong>' + state.text + '</strong>');
            }
            return state.text;
        }

        // Scope select2 initialization to this form only
        $("#formCreate .select2").not("#create_mata_pelajaran_id").select2({
            dropdownParent: $('#mdlCreateJadwal')
        });

        $("#create_mata_pelajaran_id").select2({
            dropdownParent: $('#mdlCreateJadwal'),
            templateResult: formatMapelOption,
            templateSelection: formatMapelOption
        });

        // AJAX Dynamic Loading for Unit -> Kelas & Mapel & Guru
        $("#create_kode_unit").change(function() {
            var kode_unit = $(this).val();
            
            if(kode_unit) {
                // Show loading state
                $("#create_kode_kelas").html('<option value="">Loading...</option>').prop('disabled', true);
                $("#create_mata_pelajaran_id").html('<option value="">Loading...</option>').prop('disabled', true);
                $("#create_guru_id").html('<option value="">Loading...</option>').prop('disabled', true);
                
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
                            $("#create_kode_kelas").html(kelasOptions).prop('disabled', false);
                            
                            // Populate Mapel
                            var mapelOptions = '<option value="">Pilih Mapel</option>';
                            $.each(data.mapel, function(key, value) {
                                var isParent = value.parent_id === null;
                                var boldStyle = isParent ? 'style="font-weight: bold;"' : '';
                                var parentData = isParent ? 'data-parent="true"' : 'data-parent="false"';
                                mapelOptions += '<option value="'+ value.id +'" '+ boldStyle +' '+ parentData +'>'+ value.nama_matpel +' ('+ value.kelompok +')</option>';
                            });
                            $("#create_mata_pelajaran_id").html(mapelOptions).prop('disabled', false);

                            // Populate Guru
                            var guruOptions = '<option value="">Pilih Guru</option>';
                            $.each(data.guru, function(key, value) {
                                guruOptions += '<option value="'+ value.id +'">'+ value.nama_guru +'</option>';
                            });
                            $("#create_guru_id").html(guruOptions).prop('disabled', false);

                            // Trigger Select2 update
                            $("#create_kode_kelas, #create_mata_pelajaran_id, #create_guru_id").trigger('change');
                        } else {
                            alert("Error: " + data.message);
                        }
                    },
                    error: function() {
                        alert("Terjadi kesalahan saat mengambil data.");
                        $("#create_kode_kelas").html('<option value="">Pilih Kelas</option>').prop('disabled', false);
                        $("#create_mata_pelajaran_id").html('<option value="">Pilih Mapel</option>').prop('disabled', false);
                        $("#create_guru_id").html('<option value="">Pilih Guru</option>').prop('disabled', false);
                    }
                });
            } else {
                $("#create_kode_kelas").html('<option value="">Pilih Kelas</option>');
                $("#create_mata_pelajaran_id").html('<option value="">Pilih Mapel</option>');
                $("#create_guru_id").html('<option value="">Pilih Guru</option>');
            }
        });

        // Event Listener untuk Select2 (Scoped)
        $("#create_kode_unit, #create_kode_kelas, #create_mata_pelajaran_id, #create_guru_id, #create_hari, #create_semester").change(function() {
            validateField($(this));
        });

        // Event Listener untuk Input biasa (Scoped)
        $("#create_jam_ke, #create_jam_mulai, #create_jam_selesai").on("keyup change", function() {
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
        $("#formCreate").submit(function(e) {
            let isValid = true;
            
            // Validate specific fields by ID
            const requiredFields = [
                '#create_kode_unit', 
                '#create_kode_kelas', 
                '#create_mata_pelajaran_id', 
                '#create_guru_id', 
                '#create_hari', 
                '#create_semester',
                '#create_jam_ke',
                '#create_jam_mulai',
                '#create_jam_selesai'
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

        // Trigger change if unit is pre-selected
        if($("#create_kode_unit").val()) {
            $("#create_kode_unit").trigger('change');
        }
    });
</script>
