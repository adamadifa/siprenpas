<form action="{{ route('pendaftaran.update', Crypt::encrypt($pendaftaran->no_pendaftaran)) }}" aria-autocomplete="false"
    id="formPendaftaran" method="POST" enctype="multipart/form-data">
    {{-- <input type="text" id="id_siswa" name="id_siswa"> --}}
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="divider text-start">
                <div class="divider-text">
                    <i class="ti ti-user"></i> Data Pendaftaran
                </div>
            </div>
            <x-input-with-icon icon="ti ti-barcode" label="Auto" name="no_pendaftaran"
                value="{{ $pendaftaran->no_pendaftaran }}" disabled="true" />
            <x-input-with-icon icon="ti ti-calendar" label="Tanggal Pendaftaran" name="tanggal_pendaftaran"
                datepicker="flatpickr-date" value="{{ $pendaftaran->tanggal_pendaftaran }}" />
            <x-select label="Jenjang / Tingkat" name="kode_unit" :data="$unit" key="kode_unit" textShow="nama_unit"
                select2="select2Kodeunit" upperCase="true" selected="{{ $pendaftaran->kode_unit }}" />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="divider text-start">
                <div class="divider-text">
                    <i class="ti ti-user"></i> Data Siswa
                </div>
            </div>

            <!-- Upload Foto dengan Style Modern -->
            <div class="form-group mb-4">
                <label style="font-weight: 600" class="form-label">
                    <i class="ti ti-camera me-2"></i>Foto Siswa
                </label>
                <style>
                    .upload-area:hover {
                        border-color: #6366f1 !important;
                        background-color: #f0f9ff !important;
                        transform: translateY(-2px);
                        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
                    }

                    .photo-preview-container:hover .btn-danger {
                        opacity: 1;
                    }

                    .photo-preview-container .btn-danger {
                        opacity: 0;
                        transition: opacity 0.3s ease;
                    }

                    .photo-preview-container:hover {
                        transform: scale(1.02);
                        transition: transform 0.3s ease;
                    }
                </style>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <!-- Preview Foto -->
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body text-center p-3">
                                <div class="photo-preview-container"
                                    style="position: relative; width: 150px; height: 200px; margin: 0 auto; border: 2px dashed #d4d4d8; border-radius: 12px; overflow: hidden; background: #f8fafc;">


                                    @if ($pendaftaran->foto_pendaftaran)
                                        <img id="photoPreview"
                                            src="{{ asset('storage/photos/pendaftaran/' . $pendaftaran->foto_pendaftaran) }}"
                                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;"
                                            alt="Foto Siswa"
                                            onerror="this.style.display='none'; document.getElementById('photoPlaceholder').style.display='flex';">
                                        <div id="photoPlaceholder" style="display: none;">
                                            <i class="ti ti-camera" style="font-size: 2.5rem; margin-bottom: 8px;"></i>
                                            <span style="font-size: 0.875rem; text-align: center; padding: 0 10px;">Foto
                                                tidak ditemukan</span>
                                        </div>
                                    @else
                                        <div id="photoPlaceholder"
                                            style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%; color: #94a3b8;">
                                            <i class="ti ti-camera" style="font-size: 2.5rem; margin-bottom: 8px;"></i>
                                            <span
                                                style="font-size: 0.875rem; text-align: center; padding: 0 10px;">Belum
                                                ada foto</span>
                                        </div>
                                        <img id="photoPreview"
                                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px; display: none;"
                                            alt="Preview Foto">
                                    @endif
                                    <!-- Remove Photo Button -->
                                    <button type="button" id="removePhoto" class="btn btn-danger btn-sm"
                                        style="position: absolute; top: 5px; right: 5px; width: 30px; height: 30px; border-radius: 50%; padding: 0; display: {{ $pendaftaran->foto_pendaftaran ? 'flex' : 'none' }}; align-items: center; justify-content: center;">
                                        <i class="ti ti-x" style="font-size: 0.875rem;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 col-sm-12">
                        <!-- Upload Input -->
                        <div class="upload-area"
                            style="border: 2px dashed #e2e8f0; border-radius: 12px; padding: 2rem; text-align: center; background: #f8fafc; transition: all 0.3s ease; cursor: pointer;"
                            onclick="document.getElementById('photoInput').click()">
                            <i class="ti ti-cloud-upload"
                                style="font-size: 3rem; color: #6366f1; margin-bottom: 1rem;"></i>
                            <h6 style="color: #374151; margin-bottom: 0.5rem;">Klik untuk upload foto</h6>
                            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">atau drag & drop file
                                di sini</p>
                            <p style="color: #9ca3af; font-size: 0.75rem;">Format: JPG, JPEG, PNG (Max: 2MB)</p>
                        </div>
                        <input type="file" id="photoInput" name="foto" accept="image/jpeg,image/jpg,image/png"
                            style="display: none;">

                        <!-- Info Text -->
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="ti ti-info-circle me-1"></i>
                                Foto akan digunakan untuk identitas siswa. Pastikan foto jelas dan formal.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <x-input-with-icon-label icon="ti ti-barcode" label="NISN" name="nisn"
                value="{{ $pendaftaran->nisn }}" />
            <x-input-with-icon-label icon="ti ti-barcode" label="NIS" name="nis"
                value="{{ $pendaftaran->nis }}" />
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap" name="nama_lengkap"
                        value="{{ $pendaftaran->nama_lengkap }}" />
                </div>
                {{-- <div class="col-lg-2 col-sm-12 col-md-12">
                    <div class="form-group mb-3">
                        <a href="#" class="btn btn-primary w-100 mt-4" id="btnCarisiswa"><i class="ti ti-search"></i></a>
                    </div>
                </div> --}}
            </div>

            <div class="form-group mb-3">
                <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Jenis
                    Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                    <option value="">Jenis Kelamin</option>
                    <option value="L" @if ($pendaftaran->jenis_kelamin == 'L') selected @endif>Laki - Laki</option>
                    <option value="P" @if ($pendaftaran->jenis_kelamin == 'P') selected @endif>Perempuan</option>
                </select>
            </div>
            <x-input-with-icon-label icon="ti ti-map-pin" label="Tempat Lahir" name="tempat_lahir"
                value="{{ $pendaftaran->tempat_lahir }}" />
            <x-input-with-icon-label icon="ti ti-calendar" label="Tanggal Lahir" name="tanggal_lahir"
                datepicker="flatpickr-date" value="{{ $pendaftaran->tanggal_lahir }}" />
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <x-input-with-icon-label icon="ti ti-user" label="Anak Ke" name="anak_ke"
                        value="{{ $pendaftaran->anak_ke }}" />
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <x-input-with-icon-label icon="ti ti-users" label="Jumlah Saudara" name="jumlah_saudara"
                        value="{{ $pendaftaran->jumlah_saudara }}" />
                </div>
            </div>
            <x-textarea-label name="alamat" label="Alamat" value="{{ $pendaftaran->alamat }}" />
            <x-select-label label="Provinsi" name="id_province" :data="$provinsi" key="id" textShow="name"
                select2="select2Provinsi" upperCase="true" selected="{{ $pendaftaran->id_province }}" />
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
            <x-input-with-icon-label icon="ti ti-barcode" label="Kode Pos" name="kode_pos"
                value="{{ $pendaftaran->kode_pos }}" />
        </div>
        <div class="col-lg-1">
            <div class="divider divider-vertical">
                <div class="divider-text">
                    <i class="ti ti-crown"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-md-12 col-sm-12">
            <div class="divider text-start">
                <div class="divider-text">
                    <i class="ti ti-building-skyscraper"></i> Data Asal Sekolah
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 col-sm-12 col-md-12">
                    <div class="form-group mb-3">
                        <select name="kode_asal_sekolah" class="form-select select2Kodeasalsekolah"
                            id="kode_asal_sekolah">
                            <option value="">Asal Sekolah</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-12 col-md-12">
                    <div class="form-group mb-3">
                        <a href="#" class="btn btn-primary w-100" id="btnTambahsekolah"><i
                                class="ti ti-plus"></i></a>
                    </div>
                </div>
            </div>
            <x-input-with-icon-label icon="ti ti-barcode" label="No. KK" name="no_kk"
                value="{{ $pendaftaran->no_kk }}" />
            <x-input-with-icon-label icon="ti ti-credit-card" label="NIK. Ayah" name="nik_ayah"
                value="{{ $pendaftaran->nik_ayah }}" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap Ayah" name="nama_ayah"
                value="{{ $pendaftaran->nama_ayah }}" />
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
            <x-input-with-icon-label icon="ti ti-building-skyscraper" label="Pekerjaan Ayah" name="pekerjaan_ayah"
                value="{{ $pendaftaran->pekerjaan_ayah }}" />


            <x-input-with-icon-label icon="ti ti-credit-card" label="NIK. Ibu" name="nik_ibu"
                value="{{ $pendaftaran->nik_ibu }}" />
            <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap Ibu" name="nama_ibu"
                value="{{ $pendaftaran->nama_ibu }}" />
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
            <x-input-with-icon-label icon="ti ti-building-skyscraper" label="Pekerjaan Ibu" name="pekerjaan_ibu"
                value="{{ $pendaftaran->pekerjaan_ibu }}" />

            <x-input-with-icon-label icon="ti ti-phone" label="No. HP Orangtua" name="no_hp_orang_tua"
                value="{{ $pendaftaran->no_hp_orang_tua }}" />
            <x-select-label label="Penghasilan Orantua" name="kode_penghasilan_ortu" :data="$penghasilan_ortu"
                key="kode_penghasilan_ortu" textShow="penghasilan" select2="select2Kodepenghasilanortu"
                upperCase="true" selected="{{ $pendaftaran->kode_penghasilan_ortu }}" />
            <div class="form-group">
                <button class="btn btn-primary w-100" type="submit">
                    <ion-icon name="send-outline" class="me-1"></ion-icon>
                    Submit
                </button>
            </div>
        </div>
    </div>

</form>

<script src="{{ asset('assets/js/pages/pendaftaran.js') }}"></script>
<script>
    $(function() {
        const form = $("#formPendaftaran");
        const loading = `<div class="sk-wave sk-primary" style="margin:auto">
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            <div class="sk-wave-rect"></div>
            </div>`;
        $(".flatpickr-date").flatpickr();
        const select2Provinsi = $('.select2Provinsi');
        if (select2Provinsi.length) {
            select2Provinsi.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Provinsi',
                    dropdownParent: $this.parent(),
                    allowClear: true
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
                    allowClear: true
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
                    allowClear: true
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
                    allowClear: true
                });
            });
        }

        const select2Kodeasalsekolah = $('.select2Kodeasalsekolah');
        if (select2Kodeasalsekolah.length) {
            select2Kodeasalsekolah.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Asal Sekolah',
                    dropdownParent: $this.parent(),
                    allowClear: true
                });
            });
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

        // getRegency();
        // getDistrict();
        // getVillage();

        $("#id_province").change(function() {
            getRegency(id_province = $(this).val(), id_regency = "");
        });

        $("#id_regency").change(function() {
            getDistrict(id_regency = $(this).val(), id_district = "");
        });

        $("#id_district").change(function() {
            getVillage(id_district = $(this).val(), id_village = "");
        });

        $("#btnCarisiswa").click(function() {
            $("#modalSiswa").modal("show");
        });

        getRegency(id_province = "{{ $pendaftaran->id_province }}", id_regency =
            "{{ $pendaftaran->id_regency }}");
        getDistrict(id_regency = "{{ $pendaftaran->id_regency }}", id_district =
            "{{ $pendaftaran->id_district }}");
        getVillage(id_district = "{{ $pendaftaran->id_district }}", id_village =
            "{{ $pendaftaran->id_village }}");

        function getSiswa(id_siswa) {
            $.ajax({
                url: `/siswa/${id_siswa}/getsiswa`,
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log(response);
                    form.find("#id_siswa").val(response.id_siswa);
                    form.find("#nisn").val(response.nisn);
                    form.find("#nama_lengkap").val(response.nama_lengkap);
                    form.find("#jenis_kelamin").val(response.jenis_kelamin);
                    form.find("#tempat_lahir").val(response.tempat_lahir);
                    form.find("#tanggal_lahir").val(response.tanggal_lahir);
                    form.find("#anak_ke").val(response.anak_ke);
                    form.find("#jumlah_saudara").val(response.jumlah_saudara);
                    form.find("#alamat").val(response.alamat);
                    form.find("#id_province").val(response.id_province).trigger('change');
                    getRegency(id_province = response.id_province, id_regency = response
                        .id_regency);
                    getDistrict(id_regency = response.id_regency, id_district = response
                        .id_district);
                    getVillage(id_district = response.id_district, id_village = response
                        .id_village);
                    form.find("#kode_pos").val(response.kode_pos);
                    form.find("#no_kk").val(response.no_kk);
                    form.find("#nik_ayah").val(response.nik_ayah);
                    form.find("#nama_ayah").val(response.nama_ayah);
                    form.find("#pendidikan_ayah").val(response.pendidikan_ayah);
                    form.find("#pekerjaan_ayah").val(response.pekerjaan_ayah);
                    form.find("#nik_ibu").val(response.nik_ibu);
                    form.find("#nama_ibu").val(response.nama_ibu);
                    form.find("#pendidikan_ibu").val(response.pendidikan_ibu);
                    form.find("#pekerjaan_ibu").val(response.pekerjaan_ibu);
                    form.find("#no_hp_orang_tua").val(response.no_hp_orang_tua);
                    $("#modalSiswa").modal("hide");
                }
            });
        }

        $('#tabelsiswa tbody').on('click', '.pilihsiswa', function(e) {
            e.preventDefault();
            let id_siswa = $(this).attr('id_siswa');
            getSiswa(id_siswa);
            //getKaryawan(nik);
        });


        form.find("#btnTambahsekolah").click(function(e) {
            // /alert("test");
            e.preventDefault();
            const kode_unit = form.find("#kode_unit").val();
            if (kode_unit == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Unit Sekolah Belum Di Pilih!',
                    didClose: (e) => {
                        form.find("#kode_unit").focus();
                    }
                });
            } else {
                $("#modalSekolah").modal("show");
                $("#modalSekolah").find("#loadmodal").html(loading);
                $("#modalSekolah").find(".modal-title").text("Tambah Data Asal Sekolah");
                $("#modalSekolah").find("#loadmodal").load("/asalsekolah/create");
            }
        });


        function loadasalsekolah() {
            const kode_unit = form.find("#kode_unit").val();
            const kode_asal_sekolah = "{{ $pendaftaran->kode_asal_sekolah }}";
            $("#kode_asal_sekolah").load(`/asalsekolah/${kode_unit}/${kode_asal_sekolah}/getasalsekolahbyunit`);
        }

        loadasalsekolah();

        $("#kode_unit").change(function() {
            loadasalsekolah();
        });

        // Photo Upload Functionality
        const photoInput = document.getElementById('photoInput');
        const photoPreview = document.getElementById('photoPreview');
        const photoPlaceholder = document.getElementById('photoPlaceholder');
        const removePhotoBtn = document.getElementById('removePhoto');
        const uploadArea = document.querySelector('.upload-area');

        // Add loading state to upload area
        function setUploadLoading(isLoading) {
            if (isLoading) {
                uploadArea.innerHTML = `
                    <div class="d-flex justify-content-center align-items-center" style="height: 100px;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="ms-2">Memproses foto...</span>
                    </div>
                `;
            } else {
                uploadArea.innerHTML = `
                    <i class="ti ti-cloud-upload" style="font-size: 3rem; color: #6366f1; margin-bottom: 1rem;"></i>
                    <h6 style="color: #374151; margin-bottom: 0.5rem;">Klik untuk upload foto</h6>
                    <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">atau drag & drop file di sini</p>
                    <p style="color: #9ca3af; font-size: 0.75rem;">Format: JPG, JPEG, PNG (Max: 2MB)</p>
                `;
            }
        }

        // Handle file input change
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Show loading state
                setUploadLoading(true);

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    setUploadLoading(false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Format File Tidak Valid',
                        text: 'Hanya file JPG, JPEG, dan PNG yang diizinkan!'
                    });
                    photoInput.value = '';
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    setUploadLoading(false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran File Terlalu Besar',
                        text: 'Ukuran file maksimal 2MB!'
                    });
                    photoInput.value = '';
                    return;
                }

                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    setTimeout(() => {
                        photoPreview.src = e.target.result;
                        photoPreview.style.display = 'block';
                        if (photoPlaceholder) {
                            photoPlaceholder.style.display = 'none';
                        }
                        removePhotoBtn.style.display = 'flex';
                        setUploadLoading(false);

                        // Remove delete photo input if exists
                        const deleteInput = document.getElementById('deletePhoto');
                        if (deleteInput) {
                            deleteInput.remove();
                        }
                    }, 500); // Small delay for better UX
                };
                reader.readAsDataURL(file);
            } else {
                setUploadLoading(false);
            }
        });

        // Handle remove photo
        removePhotoBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            Swal.fire({
                title: 'Hapus Foto?',
                text: "Apakah Anda yakin ingin menghapus foto ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    photoInput.value = '';
                    photoPreview.style.display = 'none';
                    if (photoPlaceholder) {
                        photoPlaceholder.style.display = 'flex';
                    }
                    removePhotoBtn.style.display = 'none';

                    // Add hidden input to mark photo for deletion
                    if (!document.getElementById('deletePhoto')) {
                        const deleteInput = document.createElement('input');
                        deleteInput.type = 'hidden';
                        deleteInput.name = 'delete_photo';
                        deleteInput.id = 'deletePhoto';
                        deleteInput.value = '1';
                        form[0].appendChild(deleteInput);
                    }
                }
            });
        });

        // Handle drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.style.borderColor = '#6366f1';
            uploadArea.style.backgroundColor = '#f0f9ff';
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.style.borderColor = '#e2e8f0';
            uploadArea.style.backgroundColor = '#f8fafc';
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.style.borderColor = '#e2e8f0';
            uploadArea.style.backgroundColor = '#f8fafc';

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                photoInput.files = files;
                photoInput.dispatchEvent(new Event('change'));
            }
        });

        // Handle form submission with photo notification
        form.on('submit', function(e) {
            const hasPhoto = photoInput.files.length > 0 || (photoPreview.style.display === 'block' && !
                document.getElementById('deletePhoto'));

            if (hasPhoto) {
                // Show loading for photo processing
                const submitBtn = form.find('button[type="submit"]');
                const originalText = submitBtn.html();
                submitBtn.html(
                    '<i class="spinner-border spinner-border-sm me-2"></i>Menyimpan data dan foto...'
                );
                submitBtn.prop('disabled', true);

                // Re-enable after 3 seconds in case of issues
                setTimeout(() => {
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                }, 10000);
            }
        });

    });
</script>
