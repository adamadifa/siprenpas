<form action="{{ route('karyawan.update', Crypt::encrypt($karyawan->npp)) }}" id="formeditKaryawan" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <x-input-with-icon-label icon="ti ti-barcode" label="NPP" name="npp" value="{{ $karyawan->npp }}" required="true" />
    <x-input-with-icon-label icon="ti ti-credit-card" label="No. KK" name="no_kk" value="{{ $karyawan->no_kk }}" />
    <x-input-with-icon-label icon="ti ti-credit-card" label="No. KTP" name="no_ktp" value="{{ $karyawan->no_ktp }}" required="true" />
    <x-input-with-icon-label icon="ti ti-user" label="Nama Lengkap" name="nama_lengkap" value="{{ $karyawan->nama_lengkap }}" required="true" />

    <!-- Upload Foto -->
    <div class="form-group mb-4">
        <label style="font-weight: 600" class="form-label">
            <i class="ti ti-camera me-2"></i>Foto Karyawan
        </label>
        <style>
            .upload-area:hover {
                border-color: #064e3b !important;
                background-color: #f0fdf4 !important;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(6, 78, 59, 0.1);
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
                            @if ($karyawan->foto)
                                <img id="photoPreview" src="{{ getfotoKaryawan($karyawan->foto) }}"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;"
                                    alt="Foto Karyawan"
                                    onerror="this.style.display='none'; document.getElementById('photoPlaceholder').style.display='flex';">
                                <div id="photoPlaceholder" style="display: none;">
                                    <i class="ti ti-camera" style="font-size: 2.5rem; margin-bottom: 8px;"></i>
                                    <span style="font-size: 0.875rem; text-align: center; padding: 0 10px;">Foto tidak ditemukan</span>
                                </div>
                            @else
                                <div id="photoPlaceholder"
                                    style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%; color: #94a3b8;">
                                    <i class="ti ti-camera" style="font-size: 2.5rem; margin-bottom: 8px;"></i>
                                    <span style="font-size: 0.875rem; text-align: center; padding: 0 10px;">Belum ada foto</span>
                                </div>
                                <img id="photoPreview"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px; display: none;"
                                    alt="Preview Foto">
                            @endif
                            <!-- Remove Photo Button -->
                            <button type="button" id="removePhoto" class="btn btn-danger btn-sm"
                                style="position: absolute; top: 5px; right: 5px; width: 30px; height: 30px; border-radius: 50%; padding: 0; display: {{ $karyawan->foto ? 'flex' : 'none' }}; align-items: center; justify-content: center;">
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
                    <i class="ti ti-cloud-upload" style="font-size: 3rem; color: #064e3b; margin-bottom: 1rem;"></i>
                    <h6 style="color: #374151; margin-bottom: 0.5rem;">Klik untuk upload foto</h6>
                    <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">atau drag & drop file di sini</p>
                    <p style="color: #9ca3af; font-size: 0.75rem;">Format: JPG, JPEG, PNG (Max: 2MB)</p>
                </div>
                <input type="file" id="photoInput" name="foto" accept="image/jpeg,image/jpg,image/png"
                    style="display: none;">
                <input type="hidden" id="delete_photo" name="delete_photo" value="0">

                <!-- Info Text -->
                <div class="mt-2">
                    <small class="text-muted">
                        <i class="ti ti-info-circle me-1"></i>
                        Foto akan digunakan untuk identitas karyawan. Pastikan foto jelas dan formal.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
            <option value="">Jenis Kelamin</option>
            <option value="L" {{ $karyawan->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-Laki</option>
            <option value="P" {{ $karyawan->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <x-input-with-icon-label icon="ti ti-map-pin" label="Tempat Lahir" name="tempat_lahir" value="{{ $karyawan->tempat_lahir }}" required="true" />
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <x-input-with-icon-label icon="ti ti-calendar" label="Tanggal Lahir" name="tanggal_lahir" value="{{ $karyawan->tanggal_lahir }}" required="true" datepicker="flatpickr-date" />
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Golongan Darah</label>
        <select name="golongan_darah" id="golongan_darah" class="form-select">
            <option value="">Golongan Darah</option>
            <option {{ $karyawan->golongan_darah == 'A' ? 'selected' : '' }} value="A">A</option>
            <option {{ $karyawan->golongan_darah == 'B' ? 'selected' : '' }} value="B">B</option>
            <option {{ $karyawan->golongan_darah == 'AB' ? 'selected' : '' }} value="AB">AB</option>
            <option {{ $karyawan->golongan_darah == 'O' ? 'selected' : '' }} value="O">O</option>
        </select>
    </div>
    <x-input-with-icon-label icon="ti ti-phone" label="No. HP" name="no_hp" value="{{ $karyawan->no_hp }}" required="true" />
    <x-textarea-label name="alamat_ktp" label="Alamat KTP" value="{{ $karyawan->alamat_ktp }}" required="true" />
    <x-textarea-label name="alamat_tinggal" label="Alamat Tinggal" value="{{ $karyawan->alamat_tinggal }}" required="true" />
    <x-input-with-icon-label icon="ti ti-calendar" label="TMT" name="tmt" value="{{ $karyawan->tmt }}" required="true" datepicker="flatpickr-date" />
    <div class="form-group mb-3">
        <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Status Karyawan <span class="text-danger">*</span></label>
        <select name="status_karyawan" id="status_karyawan" class="form-select">
            <option value="">Status Karyawan</option>
            <option value="K" {{ $karyawan->status_karyawan == 'K' ? 'selected' : '' }}>Kontrak</option>
            <option value="T" {{ $karyawan->status_karyawan == 'T' ? 'selected' : '' }}>Tetap</option>
            <option value="O" {{ $karyawan->status_karyawan == 'O' ? 'selected' : '' }}>OJT</option>
        </select>
    </div>
    <div class="form-group mb-3">
        <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Pendidikan Terakhir <span class="text-danger">*</span></label>
        <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-select">
            <option value="">Pendidikan Terakhir</option>
            <option value="SD" {{ $karyawan->pendidikan_terakhir == 'SD' ? 'selected' : '' }}>SD</option>
            <option value="SMP" {{ $karyawan->pendidikan_terakhir == 'SMP' ? 'selected' : '' }}>SMP</option>
            <option value="SMA" {{ $karyawan->pendidikan_terakhir == 'SMA' ? 'selected' : '' }}>SMA</option>
            <option value="SMK" {{ $karyawan->pendidikan_terakhir == 'SMK' ? 'selected' : '' }}>SMK</option>
            <option value="D1" {{ $karyawan->pendidikan_terakhir == 'D1' ? 'selected' : '' }}>D1</option>
            <option value="D2" {{ $karyawan->pendidikan_terakhir == 'D2' ? 'selected' : '' }}>D2</option>
            <option value="D3" {{ $karyawan->pendidikan_terakhir == 'D3' ? 'selected' : '' }}>D3</option>
            <option value="D4" {{ $karyawan->pendidikan_terakhir == 'D4' ? 'selected' : '' }}>D4</option>
            <option value="S1" {{ $karyawan->pendidikan_terakhir == 'S1' ? 'selected' : '' }}>S1</option>
            <option value="S2" {{ $karyawan->pendidikan_terakhir == 'S2' ? 'selected' : '' }}>S2</option>
            <option value="S3" {{ $karyawan->pendidikan_terakhir == 'S3' ? 'selected' : '' }}>S3</option>
        </select>
    </div>

    <x-select-label label="Jabatan" name="kode_jabatan" selected="{{ $karyawan->kode_jabatan }}" :data="$jabatan"
        key="kode_jabatan" textShow="nama_jabatan" required="true" />
    <x-select-label label="Unit" name="kode_unit" selected="{{ $karyawan->kode_unit }}" :data="$unit"
        key="kode_unit" textShow="nama_unit" upperCase="true" required="true" />
    <x-select-label label="Departemen" name="kode_dept" selected="{{ $karyawan->kode_dept }}" :data="$departemen"
        key="kode_dept" textShow="nama_dept" upperCase="true" required="true" />
    <div class="form-group mb-3">
        <label for="exampleFormControlInput1" style="font-weight: 600" class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" id="status" class="form-select">
            <option value="">Status</option>
            <option value="1" {{ $karyawan->status == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $karyawan->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
    </div>
    <div class="form-group mt-4">
        <button class="btn btn-primary w-100" type="submit" style="background-color: #064e3b; border-color: #064e3b">
            <i class="ti ti-device-floppy me-2"></i>
            Update Data
        </button>
    </div>
</form>

<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/karyawan/edit.js') }}"></script>
<script>
    $(function() {
        $(".flatpickr-date").flatpickr();

        // Photo Upload Functionality
        const photoInput = document.getElementById('photoInput');
        const photoPreview = document.getElementById('photoPreview');
        const photoPlaceholder = document.getElementById('photoPlaceholder');
        const removePhotoBtn = document.getElementById('removePhoto');
        const uploadArea = document.querySelector('.upload-area');
        const form = document.getElementById('formeditKaryawan');

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
                    <i class="ti ti-cloud-upload" style="font-size: 3rem; color: #064e3b; margin-bottom: 1rem;"></i>
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

                        // Remove delete photo flag if uploading new photo
                        const deleteInput = document.getElementById('delete_photo');
                        if (deleteInput) {
                            deleteInput.value = '0';
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

                    // Set delete photo flag
                    const deleteInput = document.getElementById('delete_photo');
                    if (deleteInput) {
                        deleteInput.value = '1';
                    }
                }
            });
        });

        // Handle drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.style.borderColor = '#064e3b';
            uploadArea.style.backgroundColor = '#f0fdf4';
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
    });
</script>
