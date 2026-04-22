<form action="{{ route('anggota.store') }}" aria-autocomplete="false" id="formAnggota" method="POST">
    @csrf
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="divider text-start mb-3">
                <div class="divider-text fw-bold text-primary">
                    <i class="ti ti-user me-2"></i> Data Anggota
                </div>
            </div>
            
            <x-input-with-icon icon="ti ti-barcode" label="No. Anggota (Auto)" name="no_anggota" disabled />
            <x-input-with-icon-label icon="ti ti-credit-card" label="Nomor Identitas (NIK)" name="nik" required="true" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap" name="nama_lengkap" required="true" />
            
            <x-input-with-icon-label icon="ti ti-map-pin" label="Tempat Lahir" name="tempat_lahir" required="true" />
            <x-input-with-icon-label icon="ti ti-calendar" label="Tanggal Lahir" name="tanggal_lahir" datepicker="flatpickr-date" required="true" />

            <div class="form-group mb-3">
                <label class="form-label fw-bold small">Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L">Laki - Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label class="form-label fw-bold small">Pendidikan Terakhir <span class="text-danger">*</span></label>
                <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-select">
                    <option value="">Pilih Pendidikan</option>
                    @foreach ($pendidikan as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label class="form-label fw-bold small">Status Pernikahan <span class="text-danger">*</span></label>
                <select name="status_pernikahan" id="status_pernikahan" class="form-select">
                    <option value="">Pilih Status</option>
                    <option value="M">Menikah</option>
                    <option value="BM">Belum Menikah</option>
                    <option value="JD">Janda/Duda</option>
                </select>
            </div>
            <x-input-with-icon-label icon="ti ti-users" label="Jumlah Tanggungan" name="jml_tanggungan" />

            <x-input-with-icon-label icon="ti ti-user" label="Nama Pasangan" name="nama_pasangan" />
            <x-input-with-icon-label icon="ti ti-briefcase" label="Pekerjaan Pasangan" name="pekerjaan_pasangan" />

            <x-input-with-icon-label icon="ti ti-user-check" label="Nama Ibu Kandung" name="nama_ibu" />
            <x-input-with-icon-label icon="ti ti-users" label="Nama Saudara" name="nama_saudara" />
            
            <x-input-with-icon-label icon="ti ti-phone" label="Nomor HP / WhatsApp" name="no_hp" required="true" />
        </div>

        <div class="col-lg-6">
            <div class="divider text-start mb-3">
                <div class="divider-text fw-bold text-primary">
                    <i class="ti ti-map-pin me-2"></i> Data Alamat & Lokasi
                </div>
            </div>
            
            <x-textarea-label name="alamat" label="Alamat Lengkap" required="true" />
            
            <x-select-label label="Provinsi" name="id_province" :data="$provinsi" key="id" textShow="name" select2="select2Provinsi" upperCase="true" required="true" />
            <div class="form-group mb-3">
                <label class="form-label fw-bold small">Kabupaten / Kota <span class="text-danger">*</span></label>
                <select name="id_regency" id="id_regency" class="select2Regency form-select">
                </select>
            </div>

            <div class="form-group mb-3">
                <label class="form-label fw-bold small">Kecamatan <span class="text-danger">*</span></label>
                <select name="id_district" id="id_district" class="select2District form-select">
                </select>
            </div>
            <div class="form-group mb-3">
                <label class="form-label fw-bold small">Desa / Kelurahan <span class="text-danger">*</span></label>
                <select name="id_village" id="id_village" class="select2Village form-select">
                </select>
            </div>

            <x-input-with-icon-label icon="ti ti-barcode" label="Kode Pos" name="kode_pos" />
            <div class="form-group mb-3">
                <label class="form-label fw-bold small">Status Tinggal <span class="text-danger">*</span></label>
                <select name="status_tinggal" id="status_tinggal" class="form-select">
                    <option value="">Pilih Status Tinggal</option>
                    <option value="MS">Milik Sendiri</option>
                    <option value="MK">Milik Keluarga</option>
                    <option value="SK">Sewa / Kontrak</option>
                </select>
            </div>

            <div class="form-group mt-4 pt-2">
                <button class="btn btn-primary w-100 shadow-sm d-flex align-items-center justify-content-center gap-2" id="btnSimpan" type="submit" style="background-color: #064e3b; border-color: #064e3b">
                    <i class="ti ti-device-floppy fs-4"></i>
                    <span class="fw-bold">Simpan Data Anggota</span>
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function() {
        $('.flatpickr-date').flatpickr({
            dateFormat: "Y-m-d",
        });
        
        const formAnggota = $('#formAnggota');

        formAnggota.submit(function(e) {
            let fields = [
                { name: 'nama_lengkap', label: 'Nama Lengkap' },
                { name: 'nik', label: 'NIK' },
                { name: 'tempat_lahir', label: 'Tempat Lahir' },
                { name: 'tanggal_lahir', label: 'Tanggal Lahir' },
                { name: 'jenis_kelamin', label: 'Jenis Kelamin' },
                { name: 'pendidikan_terakhir', label: 'Pendidikan Terakhir' },
                { name: 'status_pernikahan', label: 'Status Pernikahan' },
                { name: 'no_hp', label: 'No. HP' },
                { name: 'alamat', label: 'Alamat' },
                { name: 'id_province', label: 'Provinsi' },
                { name: 'id_regency', label: 'Kabupaten/Kota' },
                { name: 'id_district', label: 'Kecamatan' },
                { name: 'id_village', label: 'Desa/Kelurahan' },
                { name: 'status_tinggal', label: 'Status Tinggal' }
            ];

            for (let field of fields) {
                let value = $(this).find(`[name="${field.name}"]`).val();
                if (value == "" || value == null) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: field.label + ' tidak boleh kosong!',
                        confirmButtonColor: '#064e3b'
                    });
                    return false;
                }
            }

            $(this).find('button[type="submit"]').attr('disabled', 'disabled');
            $(this).find('button[type="submit"]').html(
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...'
            );
        });

        // Initialize Select2 with cleaner style
        function initSelect2(element, placeholder) {
            if (element.length) {
                element.each(function() {
                    var $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: placeholder,
                        dropdownParent: $this.parent(),
                        allowClear: true
                    });
                });
            }
        }

        initSelect2($('.select2Provinsi'), 'Pilih Provinsi');
        initSelect2($('.select2Regency'), 'Pilih Kabupaten / Kota');
        initSelect2($('.select2District'), 'Pilih Kecamatan');
        initSelect2($('.select2Village'), 'Pilih Desa / Kelurahan');

        function getRegency() {
            var id_province = $("#id_province").val();
            if (!id_province) return;
            $.ajax({
                type: 'POST',
                url: '/regency/getregencybyprovince',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_province: id_province,
                },
                cache: false,
                success: function(respond) {
                    $("#id_regency").html(respond);
                    $("#id_district").html('<option value="">Pilih Kecamatan</option>');
                    $("#id_village").html('<option value="">Pilih Desa / Kelurahan</option>');
                }
            });
        }

        function getDistrict() {
            var id_regency = $("#id_regency").val();
            if (!id_regency) return;
            $.ajax({
                type: 'POST',
                url: '/district/getdistrictbyregency',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_regency: id_regency,
                },
                cache: false,
                success: function(respond) {
                    $("#id_district").html(respond);
                    $("#id_village").html('<option value="">Pilih Desa / Kelurahan</option>');
                }
            });
        }

        function getVillage() {
            var id_district = $("#id_district").val();
            if (!id_district) return;
            $.ajax({
                type: 'POST',
                url: '/village/getvillagebydistrict',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_district: id_district,
                },
                cache: false,
                success: function(respond) {
                    $("#id_village").html(respond);
                }
            });
        }

        $("#id_province").change(function() {
            getRegency();
        });

        $("#id_regency").change(function() {
            getDistrict();
        });

        $("#id_district").change(function() {
            getVillage();
        });
    });
</script>
