<form action="{{ route('siswa.update', Crypt::encrypt($siswa->id_siswa)) }}" aria-autocomplete="false" id="formSiswa"
    method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="divider text-start">
                <div class="divider-text text-success fw-bold">
                    <i class="ti ti-user me-1"></i> Data Siswa
                </div>
            </div>

            <!-- Upload Foto Siswa -->
            <div class="form-group mb-4">
                <label style="font-weight: 600" class="form-label">
                    <i class="ti ti-camera me-1 text-primary"></i> Foto Santri / Siswa
                </label>
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <div class="photo-preview-container position-relative"
                            style="width: 100px; height: 120px; border: 2px dashed #cbd5e1; border-radius: 10px; overflow: hidden; background: #f8fafc;">
                            @php
                                $fotoPath = isset($pendaftaran) && !empty($pendaftaran->foto) ? $pendaftaran->foto : null;
                            @endphp
                            @if ($fotoPath)
                                <img id="photoPreview"
                                    src="{{ asset('storage/photos/pendaftaran/' . $fotoPath) }}"
                                    style="width: 100%; height: 100%; object-fit: cover;"
                                    alt="Foto Siswa"
                                    onerror="this.style.display='none'; document.getElementById('photoPlaceholder').style.display='flex';">
                                <div id="photoPlaceholder" style="display: none; height: 100%; flex-direction: column; justify-content: center; align-items: center; color: #94a3b8;">
                                    <i class="ti ti-camera fs-3"></i>
                                    <span style="font-size: 0.65rem;">Kosong</span>
                                </div>
                            @else
                                <div id="photoPlaceholder"
                                    style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%; color: #94a3b8;">
                                    <i class="ti ti-camera fs-3"></i>
                                    <span style="font-size: 0.65rem;">Belum ada</span>
                                </div>
                                <img id="photoPreview"
                                    style="width: 100%; height: 100%; object-fit: cover; display: none;"
                                    alt="Preview Foto">
                            @endif
                            <button type="button" id="removePhoto" class="btn btn-danger btn-xs"
                                style="position: absolute; top: 4px; right: 4px; width: 22px; height: 22px; border-radius: 50%; padding: 0; display: {{ $fotoPath ? 'flex' : 'none' }}; align-items: center; justify-content: center;">
                                <i class="ti ti-x" style="font-size: 0.75rem;"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="upload-area p-3 text-center rounded-3 border"
                            style="border: 2px dashed #cbd5e1 !important; background: #f8fafc; cursor: pointer; transition: all 0.2s;"
                            onclick="document.getElementById('photoInput').click()">
                            <i class="ti ti-cloud-upload fs-3 text-primary d-block mb-1"></i>
                            <div class="fw-semibold text-dark" style="font-size: 0.8rem;">Pilih / Drag Foto Baru</div>
                            <div class="text-muted" style="font-size: 0.7rem;">Format: JPG, PNG (Maks 2MB)</div>
                        </div>
                        <input type="file" id="photoInput" name="foto" accept="image/jpeg,image/jpg,image/png" style="display: none;">
                    </div>
                </div>
            </div>

            <x-input-with-icon-label icon="ti ti-barcode" label="NISN" name="nisn" value="{{ $siswa->nisn }}" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap" name="nama_lengkap"
                value="{{ $siswa->nama_lengkap }}" required="true" />
            <div class="form-group mb-3">
                <label for="jenis_kelamin" style="font-weight: 600" class="form-label">Jenis Kelamin <span
                        class="text-danger">*</span></label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki - Laki</option>
                    <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <x-input-with-icon-label icon="ti ti-map-pin" label="Tempat Lahir" name="tempat_lahir"
                value="{{ $siswa->tempat_lahir }}" required="true" />
            <x-input-with-icon-label icon="ti ti-calendar" label="Tanggal Lahir" name="tanggal_lahir"
                value="{{ $siswa->tanggal_lahir }}" required="true" />
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <x-input-with-icon-label icon="ti ti-user" label="Anak Ke" name="anak_ke"
                        value="{{ $siswa->anak_ke }}" required="true" />
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <x-input-with-icon-label icon="ti ti-users" label="Jumlah Saudara" name="jumlah_saudara"
                        value="{{ $siswa->jumlah_saudara }}" />
                </div>
            </div>
            <x-textarea-label name="alamat" label="Alamat" value="{{ $siswa->alamat }}" required="true" />
            <x-select-label label="Provinsi" name="id_province" :data="$provinsi" key="id" textShow="name"
                select2="select2Provinsi" upperCase="true" selected="{{ $siswa->id_province }}" required="true" />
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Kabupaten / Kota <span
                        class="text-danger">*</span></label>
                <select name="id_regency" id="id_regency" class="select2Regency form-select">
                </select>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                <select name="id_district" id="id_district" class="select2District form-select">
                </select>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Desa / Kelurahan <span
                        class="text-danger">*</span></label>
                <select name="id_village" id="id_village" class="select2Village form-select">
                </select>
            </div>
            <x-input-with-icon-label icon="ti ti-barcode" label="Kode Pos" name="kode_pos"
                value="{{ $siswa->kode_pos }}" required="true" />
        </div>
        <div class="col-lg-1 d-none d-lg-block">
            <div class="divider divider-vertical">
                <div class="divider-text">
                    <i class="ti ti-chevron-right text-muted"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-12 col-sm-12">
            <div class="divider text-start">
                <div class="divider-text text-success fw-bold">
                    <i class="ti ti-users me-1"></i> Data Orangtua
                </div>
            </div>
            <x-input-with-icon-label icon="ti ti-barcode" label="No. KK" name="no_kk"
                value="{{ $siswa->no_kk }}" required="true" />
            <x-input-with-icon-label icon="ti ti-credit-card" label="NIK. Ayah" name="nik_ayah"
                value="{{ $siswa->nik_ayah }}" required="true" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap Ayah" name="nama_ayah"
                value="{{ $siswa->nama_ayah }}" required="true" />
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Pendidikan Ayah <span
                        class="text-danger">*</span></label>
                <select name="pendidikan_ayah" id="pendidikan_ayah" class="form-select">
                    <option value="">Pilih Pendidikan Ayah</option>
                    @foreach ($pendidikan as $p)
                        <option value="{{ $p }}" {{ $siswa->pendidikan_ayah == $p ? 'selected' : '' }}>
                            {{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <x-input-with-icon-label icon="ti ti-building-skyscraper" label="Pekerjaan Ayah" name="pekerjaan_ayah"
                value="{{ $siswa->pekerjaan_ayah }}" required="true" />

            <div class="my-4"></div>

            <x-input-with-icon-label icon="ti ti-credit-card" label="NIK. Ibu" name="nik_ibu"
                value="{{ $siswa->nik_ibu }}" required="true" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap Ibu" name="nama_ibu"
                value="{{ $siswa->nama_ibu }}" required="true" />
            <div class="form-group mb-3">
                <label style="font-weight: 600" class="form-label">Pendidikan Ibu <span
                        class="text-danger">*</span></label>
                <select name="pendidikan_ibu" id="pendidikan_ibu" class="form-select">
                    <option value="">Pilih Pendidikan Ibu</option>
                    @foreach ($pendidikan as $p)
                        <option value="{{ $p }}" {{ $siswa->pendidikan_ibu == $p ? 'selected' : '' }}>
                            {{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <x-input-with-icon-label icon="ti ti-building-skyscraper" label="Pekerjaan Ibu" name="pekerjaan_ibu"
                value="{{ $siswa->pekerjaan_ibu }}" required="true" />

            <x-input-with-icon-label icon="ti ti-phone" label="No. HP Orangtua" name="no_hp_orang_tua"
                value="{{ $siswa->no_hp_orang_tua }}" required="true" />

            <div class="form-group mt-4">
                <button class="btn text-white w-100 py-2" type="submit" style="background-color: #064e3b">
                    <i class="ti ti-refresh me-1"></i>
                    Update Data
                </button>
            </div>
        </div>
    </div>

</form>
<script src="{{ asset('assets/js/pages/siswa.js') }}"></script>
<script>
    $(function(){
        const select2Provinsi = $('.select2Provinsi');
        if (select2Provinsi.length) {
            select2Provinsi.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Provinsi',
                    dropdownParent: $this.parent(),
                    allowClear:true
                });
            });
        }

        const select2Regency = $('.select2Regency');
        if (select2Regency.length) {
            select2Regency.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Kabupaten / Kota',
                    dropdownParent: $this.parent(),
                    allowClear:true
                });
            });
        }

        const select2District = $('.select2District');
        if (select2District.length) {
            select2District.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Kecamatan',
                    dropdownParent: $this.parent(),
                    allowClear:true
                });
            });
        }

        const select2Village = $('.select2Village');
        if (select2Village.length) {
            select2Village.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Desa / Kelurahan',
                    dropdownParent: $this.parent(),
                    allowClear:true
                });
            });
        }

        function getRegency() {
            var id_province = $("#formSiswa").find("#id_province").val();
            var id_regency = "{{ $siswa->id_regency }}"
            $.ajax({
                type: 'POST',
                url: '/regency/getregencybyprovince',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_province: id_province,
                    id_regency:id_regency
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    $("#formSiswa").find("#id_regency").html(respond);
                }
            });
        }

        function getDistrict() {
            var id_regency_siswa = "{{ $siswa->id_regency }}"
            var id_regency = $("#formSiswa").find("#id_regency").val();
            var id_regency = id_regency != null ? id_regency : id_regency_siswa;
            var id_district = "{{ $siswa->id_district }}";
            $.ajax({
                type: 'POST',
                url: '/district/getdistrictbyregency',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_regency:id_regency,
                    id_district: id_district,
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    $("#formSiswa").find("#id_district").html(respond);
                }
            });
        }

        function getVillage() {
            var id_district_siswa = "{{ $siswa->id_district }}";
            var id_district = $("#formSiswa").find("#id_district").val();
            var id_district = id_district != null ? id_district : id_district_siswa;
            var id_village = "{{ $siswa->id_village }}";
            $.ajax({
                type: 'POST',
                url: '/village/getvillagebydistrict',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_district: id_district,
                    id_village:id_village
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);
                    $("#formSiswa").find("#id_village").html(respond);
                }
            });
        }

        getRegency();
        getDistrict();
        getVillage();

        // Script Photo Upload Handling
        const photoInput = document.getElementById('photoInput');
        const photoPreview = document.getElementById('photoPreview');
        const photoPlaceholder = document.getElementById('photoPlaceholder');
        const removePhotoBtn = document.getElementById('removePhoto');

        if (photoInput) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ukuran File Terlalu Besar',
                            text: 'Ukuran file foto maksimal adalah 2MB',
                            confirmButtonColor: '#064e3b'
                        });
                        this.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                        photoPreview.style.display = 'block';
                        if (photoPlaceholder) {
                            photoPlaceholder.style.display = 'none';
                        }
                        if (removePhotoBtn) {
                            removePhotoBtn.style.display = 'flex';
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        if (removePhotoBtn) {
            removePhotoBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (photoInput) photoInput.value = '';
                if (photoPreview) photoPreview.style.display = 'none';
                if (photoPlaceholder) photoPlaceholder.style.display = 'flex';
                removePhotoBtn.style.display = 'none';

                if (!document.getElementById('deletePhoto')) {
                    const deleteInput = document.createElement('input');
                    deleteInput.type = 'hidden';
                    deleteInput.name = 'delete_photo';
                    deleteInput.id = 'deletePhoto';
                    deleteInput.value = '1';
                    document.getElementById('formSiswa').appendChild(deleteInput);
                }
            });
        }

        $("#id_province").change(function(){
            getRegency();
        });

        $("#id_regency").change(function(){
            getDistrict();
        });

        $("#id_district").change(function(){
            getVillage();
        });
    });
</script>
