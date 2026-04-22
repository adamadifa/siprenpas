<form action="{{ route('pendaftaranonline.update') }}" method="POST" id="formPendaftaranOnline" aria-autocomplete="false">
    @csrf
    <input type="hidden" name="no_register" value="{{ Crypt::encrypt($pendaftaran->no_register) }}">

    {{-- BAGIAN 1: DATA PENDAFTARAN --}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="divider text-start">
                <div class="divider-text">
                    <i class="ti ti-user"></i> Data Pendaftaran
                </div>
            </div>
            <x-input-with-icon icon="ti ti-barcode" label="No. Register" name="no_register_display" value="{{ $pendaftaran->no_register }}"
                disabled="true" />
            <x-input-with-icon icon="ti ti-calendar" label="Tanggal Register" name="tanggal_register_display"
                value="{{ $pendaftaran->tanggal_register }}" disabled="true" />
            <x-select label="Jenjang / Tingkat" name="kode_unit" :data="$unit" key="kode_unit" textShow="nama_unit" select2="select2Kodeunit"
                upperCase="true" selected="{{ $pendaftaran->kode_unit }}" />
        </div>
    </div>

    {{-- BAGIAN 2: DATA SISWA --}}
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="divider text-start">
                <div class="divider-text">
                    <i class="ti ti-user"></i> Data Siswa
                </div>
            </div>

            <x-input-with-icon-label icon="ti ti-barcode" label="NISN" name="nisn" value="{{ $pendaftaran->nisn }}" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap" name="nama_lengkap" value="{{ $pendaftaran->nama_lengkap }}" />

            <div class="form-group mb-3">
                <label for="jenis_kelamin" style="font-weight: 600" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ $pendaftaran->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki - Laki</option>
                    <option value="P" {{ $pendaftaran->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <x-input-with-icon-label icon="ti ti-map-pin" label="Tempat Lahir" name="tempat_lahir" value="{{ $pendaftaran->tempat_lahir }}" />
            <x-input-with-icon-label icon="ti ti-calendar" label="Tanggal Lahir" name="tanggal_lahir" datepicker="flatpickr-date"
                value="{{ $pendaftaran->tanggal_lahir }}" />

            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <x-input-with-icon-label icon="ti ti-user" label="Anak Ke" name="anak_ke" value="{{ $pendaftaran->anak_ke }}" />
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <x-input-with-icon-label icon="ti ti-users" label="Jumlah Saudara" name="jumlah_saudara"
                        value="{{ $pendaftaran->jumlah_saudara }}" />
                </div>
            </div>

            <x-textarea-label name="alamat" label="Alamat" value="{{ $pendaftaran->alamat }}" />

            <x-select-label label="Provinsi" name="id_province" :data="$provinsi" key="id" textShow="name" select2="select2Provinsi"
                upperCase="true" selected="{{ $pendaftaran->id_province }}" />

            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Kabupaten / Kota</label>
                <select name="id_regency" id="id_regency" class="select2Regency form-select">
                </select>
            </div>

            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Kecamatan</label>
                <select name="id_district" id="id_district" class="select2District form-select">
                </select>
            </div>

            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Desa / Kelurahan</label>
                <select name="id_village" id="id_village" class="select2Village form-select">
                </select>
            </div>

            <x-input-with-icon-label icon="ti ti-barcode" label="Kode Pos" name="kode_pos" value="{{ $pendaftaran->kode_pos }}" />
            <x-input-with-icon-label icon="ti ti-barcode" label="No. KK" name="no_kk" value="{{ $pendaftaran->no_kk }}" />
            <x-input-with-icon-label icon="ti ti-school" label="Asal Sekolah" name="asal_sekolah" value="{{ $pendaftaran->asal_sekolah }}" />
            <x-input-with-icon-label icon="ti ti-phone" label="No. HP" name="no_hp" value="{{ $pendaftaran->no_hp }}" />
        </div>

        {{-- BAGIAN 4: DATA ORANG TUA --}}
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="divider text-start">
                <div class="divider-text">
                    <i class="ti ti-building-skyscraper"></i> Data Orang Tua
                </div>
            </div>

            <h6 class="mb-3">Data Ayah</h6>
            <x-input-with-icon-label icon="ti ti-barcode" label="NIK Ayah" name="nik_ayah" value="{{ $pendaftaran->nik_ayah }}" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Ayah" name="nama_ayah" value="{{ $pendaftaran->nama_ayah }}" />

            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Pendidikan Ayah</label>
                <select name="pendidikan_ayah" id="pendidikan_ayah" class="form-select">
                    <option value="">Pendidikan Ayah</option>
                    @foreach ($pendidikan as $p)
                        <option value="{{ $p }}" @if ($pendaftaran->pendidikan_ayah == $p) selected @endif>
                            {{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <x-input-with-icon-label icon="ti ti-briefcase" label="Pekerjaan Ayah" name="pekerjaan_ayah"
                value="{{ $pendaftaran->pekerjaan_ayah }}" />

            <h6 class="mb-3 mt-4">Data Ibu</h6>
            <x-input-with-icon-label icon="ti ti-barcode" label="NIK Ibu" name="nik_ibu" value="{{ $pendaftaran->nik_ibu }}" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Ibu" name="nama_ibu" value="{{ $pendaftaran->nama_ibu }}" />

            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Pendidikan Ibu</label>
                <select name="pendidikan_ibu" id="pendidikan_ibu" class="form-select">
                    <option value="">Pendidikan Ibu</option>
                    @foreach ($pendidikan as $p)
                        <option value="{{ $p }}" @if ($pendaftaran->pendidikan_ibu == $p) selected @endif>
                            {{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <x-input-with-icon-label icon="ti ti-briefcase" label="Pekerjaan Ibu" name="pekerjaan_ibu"
                value="{{ $pendaftaran->pekerjaan_ibu }}" />
        </div>
    </div>

    {{-- BAGIAN 5: TOMBOL SUBMIT --}}
    <div class="row">
        <div class="col-12 mt-3">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1 shadow-sm d-flex align-items-center justify-content-center gap-2" 
                    style="background-color: #064e3b; border-color: #064e3b">
                    <i class="ti ti-device-floppy fs-4"></i>
                    <span class="fw-bold">Update Pendaftaran Online</span>
                </button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
            </div>
        </div>
    </div>
</form>


<script>
    $(function() {
        const form = $("#formPendaftaranOnline");

        // Inisialisasi flatpickr untuk datepicker
        if (typeof flatpickr !== 'undefined') {
            $(".flatpickr-date").flatpickr();
        } else {
            // Jika flatpickr belum tersedia, tunggu sebentar
            setTimeout(function() {
                if (typeof flatpickr !== 'undefined') {
                    $(".flatpickr-date").flatpickr();
                }
            }, 100);
        }

        function getRegency(id_province = "", id_regency = "") {
            $.ajax({
                type: 'POST',
                url: '/regency/getregencybyprovince',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_province: id_province,
                    id_regency: id_regency
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    form.find("#id_regency").html(respond);
                }
            });
        }

        function getDistrict(id_regency = "", id_district = "") {
            $.ajax({
                type: 'POST',
                url: '/district/getdistrictbyregency',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_regency: id_regency,
                    id_district: id_district
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    form.find("#id_district").html(respond);
                }
            });
        }

        function getVillage(id_district = "", id_village = "") {
            $.ajax({
                type: 'POST',
                url: '/village/getvillagebydistrict',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_district: id_district,
                    id_village: id_village
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    form.find("#id_village").html(respond);
                }
            });
        }

        $("#id_province").change(function() {
            getRegency(id_province = $(this).val(), id_regency = "");
        });

        $("#id_regency").change(function() {
            getDistrict(id_regency = $(this).val(), id_district = "");
        });

        $("#id_district").change(function() {
            getVillage(id_district = $(this).val(), id_village = "");
        });

        // Load data saat halaman dimuat
        getRegency(id_province = "{{ $pendaftaran->id_province ?? '' }}", id_regency = "{{ $pendaftaran->id_regency ?? '' }}");
        getDistrict(id_regency = "{{ $pendaftaran->id_regency ?? '' }}", id_district = "{{ $pendaftaran->id_district ?? '' }}");
        getVillage(id_district = "{{ $pendaftaran->id_district ?? '' }}", id_village = "{{ $pendaftaran->id_village ?? '' }}");

        // Handle form submission dengan AJAX
        form.on('submit', function(e) {
            e.preventDefault();

            const submitBtn = form.find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="spinner-border spinner-border-sm me-1"></i> Menyimpan...');
            submitBtn.prop('disabled', true);

            const formData = new FormData(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data pendaftaran online berhasil diperbarui',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $("#modal").modal("hide");
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON?.errors || {};
                        let errorMessages = "";
                        $.each(errors, function(key, value) {
                            if (Array.isArray(value)) {
                                errorMessages += value[0] + "<br>";
                            } else {
                                errorMessages += value + "<br>";
                            }
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: errorMessages || 'Terjadi kesalahan validasi'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan data'
                        });
                    }
                }
            });
        });
    });
</script>
