<form action="{{ route('karyawan.update', Crypt::encrypt($karyawan->npp)) }}" id="formeditKaryawan" method="POST" enctype="multipart/form-data" class="space-y-5" novalidate>
    @csrf
    @method('PUT')

    <!-- ================= 1. IDENTITAS & FOTO PEGAWAI ================= -->
    <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-4">
        <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                <i class="ti ti-user"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900 leading-tight">1. Identitas & Foto Pegawai</h3>
                <p class="text-[11px] text-slate-500">Nomor pokok pegawai, identitas kependudukan, dan pas foto resmi</p>
            </div>
        </div>

        <!-- Upload & Preview Foto Profil Pegawai -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-4 bg-white border border-slate-200 rounded-xl">
            <!-- Photo Frame / Preview -->
            <div class="flex flex-col items-center justify-center text-center">
                <div class="relative w-32 h-40 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 flex items-center justify-center overflow-hidden shadow-2xs group">
                    @if ($karyawan->foto && Storage::disk('public')->exists('photos/karyawan/' . $karyawan->foto))
                        <img id="photoPreview" src="{{ getfotoKaryawan($karyawan->foto) }}" alt="{{ $karyawan->nama_lengkap }}" class="w-full h-full object-cover">
                        <div id="photoPlaceholder" style="display: none;" class="flex flex-col items-center justify-center text-slate-400 p-2">
                            <i class="ti ti-user text-3xl mb-1"></i>
                            <span class="text-[10px] font-bold">Belum Ada Foto</span>
                        </div>
                    @else
                        <img id="photoPreview" src="" alt="Preview" class="w-full h-full object-cover" style="display: none;">
                        <div id="photoPlaceholder" class="flex flex-col items-center justify-center text-slate-400 p-2">
                            <i class="ti ti-user text-3xl mb-1"></i>
                            <span class="text-[10px] font-bold">Belum Ada Foto</span>
                        </div>
                    @endif

                    <!-- Remove Photo Floating Button -->
                    <button type="button" 
                            id="removePhoto" 
                            class="absolute top-2 right-2 w-7 h-7 bg-rose-600 hover:bg-rose-700 text-white rounded-full flex items-center justify-center shadow-md transition cursor-pointer active:scale-95"
                            style="display: {{ $karyawan->foto ? 'flex' : 'none' }};"
                            title="Hapus Foto">
                        <i class="ti ti-x text-sm"></i>
                    </button>
                </div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-2">Pas Foto 3x4</span>
            </div>

            <!-- Upload Dropzone Box -->
            <div class="md:col-span-3 flex flex-col justify-center">
                <div id="uploadArea" 
                     class="border-2 border-dashed border-slate-300 hover:border-emerald-500 bg-slate-50/50 hover:bg-emerald-50/30 rounded-xl p-5 text-center transition cursor-pointer flex flex-col items-center justify-center group"
                     onclick="document.getElementById('photoInput').click()">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl mb-2 group-hover:scale-110 transition">
                        <i class="ti ti-cloud-upload"></i>
                    </div>
                    <h5 class="text-xs font-bold text-slate-800 mb-0.5">Pilih Foto atau Tarik File ke Sini</h5>
                    <p class="text-[11px] text-slate-500 mb-1">Format yang didukung: JPG, JPEG, PNG (Maks. 2MB)</p>
                    <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-100/70 px-2.5 py-0.5 rounded-full">Gunakan foto formal dan jelas</span>
                </div>
                <input type="file" id="photoInput" name="foto" accept="image/jpeg,image/jpg,image/png" class="hidden">
                <input type="hidden" id="delete_photo" name="delete_photo" value="0">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
            <!-- NPP -->
            <div class="space-y-1">
                <label for="npp" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-barcode text-sm text-slate-400"></i>
                    <span>NPP (Nomor Pokok Pegawai) <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-barcode text-base"></i>
                    </div>
                    <input type="text" 
                           id="npp" 
                           name="npp" 
                           value="{{ $karyawan->npp }}"
                           placeholder="Contoh: 80.2024.001" 
                           class="w-full pl-9 pr-3.5 py-2 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </div>
            </div>

            <!-- No KTP -->
            <div class="space-y-1">
                <label for="no_ktp" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-credit-card text-sm text-slate-400"></i>
                    <span>NIK / No. KTP <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-credit-card text-base"></i>
                    </div>
                    <input type="text" 
                           id="no_ktp" 
                           name="no_ktp" 
                           maxlength="16"
                           value="{{ $karyawan->no_ktp }}"
                           placeholder="16 digit nomor KTP..." 
                           class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </div>
            </div>

            <!-- No KK -->
            <div class="space-y-1">
                <label for="no_kk" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-id-badge-2 text-sm text-slate-400"></i>
                    <span>No. Kartu Keluarga (KK)</span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-id-badge-2 text-base"></i>
                    </div>
                    <input type="text" 
                           id="no_kk" 
                           name="no_kk" 
                           maxlength="16"
                           value="{{ $karyawan->no_kk }}"
                           placeholder="16 digit nomor KK (opsional)..." 
                           class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
            <!-- Nama Lengkap -->
            <div class="sm:col-span-2 space-y-1">
                <label for="nama_lengkap" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-user text-sm text-slate-400"></i>
                    <span>Nama Lengkap Pegawai <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-user text-base"></i>
                    </div>
                    <input type="text" 
                           id="nama_lengkap" 
                           name="nama_lengkap" 
                           value="{{ $karyawan->nama_lengkap }}"
                           placeholder="Nama lengkap beserta gelar..." 
                           class="w-full pl-9 pr-3.5 py-2 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </div>
            </div>

            <!-- Jenis Kelamin -->
            <div class="space-y-1">
                <label for="jenis_kelamin" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-gender-intergender text-sm text-slate-400"></i>
                    <span>Jenis Kelamin <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-gender-intergender text-base"></i>
                    </div>
                    <select name="jenis_kelamin" 
                            id="jenis_kelamin" 
                            class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="">-- Pilih Gender --</option>
                        <option value="L" {{ $karyawan->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="P" {{ $karyawan->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
            <!-- Tempat Lahir -->
            <div class="space-y-1">
                <label for="tempat_lahir" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-map-pin text-sm text-slate-400"></i>
                    <span>Tempat Lahir <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-map-pin text-base"></i>
                    </div>
                    <input type="text" 
                           id="tempat_lahir" 
                           name="tempat_lahir" 
                           value="{{ $karyawan->tempat_lahir }}"
                           placeholder="Kota kelahiran..." 
                           class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </div>
            </div>

            <!-- Tanggal Lahir -->
            <div class="space-y-1">
                <label for="tanggal_lahir" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-cake text-sm text-slate-400"></i>
                    <span>Tanggal Lahir <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-cake text-base"></i>
                    </div>
                    <input type="text" 
                           id="tanggal_lahir" 
                           name="tanggal_lahir" 
                           value="{{ $karyawan->tanggal_lahir }}"
                           placeholder="Pilih tanggal lahir..." 
                           autocomplete="off"
                           class="flatpickr-date w-full pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-calendar-event text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Golongan Darah -->
            <div class="space-y-1">
                <label for="golongan_darah" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-droplet text-sm text-slate-400"></i>
                    <span>Golongan Darah</span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-droplet text-base"></i>
                    </div>
                    <select name="golongan_darah" 
                            id="golongan_darah" 
                            class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="">-- Golongan Darah --</option>
                        <option value="A" {{ $karyawan->golongan_darah == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ $karyawan->golongan_darah == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ $karyawan->golongan_darah == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ $karyawan->golongan_darah == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= 2. KONTAK & ALAMAT ================= -->
    <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-4">
        <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                <i class="ti ti-phone-call"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900 leading-tight">2. Kontak & Alamat Domisili</h3>
                <p class="text-[11px] text-slate-500">Nomor telepon aktif dan alamat tempat tinggal</p>
            </div>
        </div>

        <!-- No HP -->
        <div class="space-y-1">
            <label for="no_hp" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                <i class="ti ti-phone text-sm text-slate-400"></i>
                <span>Nomor HP / WhatsApp <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-phone text-base"></i>
                </div>
                <input type="text" 
                       id="no_hp" 
                       name="no_hp" 
                       value="{{ $karyawan->no_hp }}"
                       placeholder="Contoh: 081234567890" 
                       class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
            <!-- Alamat KTP -->
            <div class="space-y-1">
                <label for="alamat_ktp" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-home text-sm text-slate-400"></i>
                    <span>Alamat Sesuai KTP <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute top-2.5 left-0 flex items-start pl-3 text-slate-400">
                        <i class="ti ti-home text-base"></i>
                    </div>
                    <textarea id="alamat_ktp" 
                              name="alamat_ktp" 
                              rows="2" 
                              placeholder="Alamat lengkap sesuai identitas KTP..." 
                              class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">{{ $karyawan->alamat_ktp }}</textarea>
                </div>
            </div>

            <!-- Alamat Tinggal -->
            <div class="space-y-1">
                <label for="alamat_tinggal" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-building-community text-sm text-slate-400"></i>
                    <span>Alamat Domisili / Tinggal Sekarang <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute top-2.5 left-0 flex items-start pl-3 text-slate-400">
                        <i class="ti ti-building-community text-base"></i>
                    </div>
                    <textarea id="alamat_tinggal" 
                              name="alamat_tinggal" 
                              rows="2" 
                              placeholder="Alamat tempat tinggal saat ini..." 
                              class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">{{ $karyawan->alamat_tinggal }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= 3. STATUS & PENEMPATAN KERJA ================= -->
    <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-4">
        <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                <i class="ti ti-briefcase"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900 leading-tight">3. Status Kepegawaian, Jabatan & Penempatan</h3>
                <p class="text-[11px] text-slate-500">Status ikatan kerja, jabatan, unit kerja, dan departemen</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
            <!-- TMT -->
            <div class="space-y-1">
                <label for="tmt" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-calendar text-sm text-slate-400"></i>
                    <span>TMT <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-calendar text-base"></i>
                    </div>
                    <input type="text" 
                           id="tmt" 
                           name="tmt" 
                           value="{{ $karyawan->tmt }}"
                           placeholder="Pilih tanggal TMT..." 
                           autocomplete="off"
                           class="flatpickr-date w-full pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-calendar-event text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Status Karyawan -->
            <div class="space-y-1">
                <label for="status_karyawan" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-user-star text-sm text-slate-400"></i>
                    <span>Status Ikatan <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-user-star text-base"></i>
                    </div>
                    <select name="status_karyawan" 
                            id="status_karyawan" 
                            class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="">-- Status --</option>
                        <option value="T" {{ $karyawan->status_karyawan == 'T' ? 'selected' : '' }}>Tetap</option>
                        <option value="K" {{ $karyawan->status_karyawan == 'K' ? 'selected' : '' }}>Kontrak</option>
                        <option value="O" {{ $karyawan->status_karyawan == 'O' ? 'selected' : '' }}>OJT (Magang)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Pendidikan Terakhir -->
            <div class="space-y-1">
                <label for="pendidikan_terakhir" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-certificate text-sm text-slate-400"></i>
                    <span>Pendidikan <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-certificate text-base"></i>
                    </div>
                    <select name="pendidikan_terakhir" 
                            id="pendidikan_terakhir" 
                            class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="">-- Pendidikan --</option>
                        @foreach(['SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'] as $p)
                            <option value="{{ $p }}" {{ $karyawan->pendidikan_terakhir == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Status Aktif / Nonaktif -->
            <div class="space-y-1">
                <label for="status" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-toggle-left text-sm text-slate-400"></i>
                    <span>Status Pegawai <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-toggle-left text-base"></i>
                    </div>
                    <select name="status" 
                            id="status" 
                            class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="1" {{ $karyawan->status == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ $karyawan->status == 0 ? 'selected' : '' }}>Tidak Aktif (Off)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
            <!-- Jabatan -->
            <div class="space-y-1">
                <label for="kode_jabatan" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-award text-sm text-slate-400"></i>
                    <span>Jabatan <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-award text-base"></i>
                    </div>
                    <select name="kode_jabatan" 
                            id="kode_jabatan" 
                            class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach ($jabatan as $j)
                            <option value="{{ $j->kode_jabatan }}" {{ $karyawan->kode_jabatan == $j->kode_jabatan ? 'selected' : '' }}>
                                {{ $j->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Unit -->
            <div class="space-y-1">
                <label for="kode_unit" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-building text-sm text-slate-400"></i>
                    <span>Unit Kerja <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-building text-base"></i>
                    </div>
                    <select name="kode_unit" 
                            id="kode_unit" 
                            class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="">-- Pilih Unit --</option>
                        @foreach ($unit as $u)
                            <option value="{{ $u->kode_unit }}" {{ $karyawan->kode_unit == $u->kode_unit ? 'selected' : '' }}>
                                {{ $u->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Departemen -->
            <div class="space-y-1">
                <label for="kode_dept" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-sitemap text-sm text-slate-400"></i>
                    <span>Departemen <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-sitemap text-base"></i>
                    </div>
                    <select name="kode_dept" 
                            id="kode_dept" 
                            class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="">-- Pilih Departemen --</option>
                        @foreach ($departemen as $d)
                            <option value="{{ $d->kode_dept }}" {{ $karyawan->kode_dept == $d->kode_dept ? 'selected' : '' }}>
                                {{ $d->nama_dept }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MODAL ACTIONS FOOTER ================= -->
    <div class="pt-4 border-t border-slate-200/90 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnUpdateKaryawan" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formEditKaryawan");
        if (typeof window.initFlatpickr === 'function') {
            window.initFlatpickr(form);
        } else if (typeof flatpickr !== 'undefined') {
            form.find(".flatpickr-date").each(function() {
                $(this).attr('autocomplete', 'off');
                flatpickr(this, {
                    dateFormat: "Y-m-d",
                    allowInput: true,
                    disableMobile: "true"
                });
            });
        }

        const photoInput = document.getElementById('photoInput');
        const photoPreview = document.getElementById('photoPreview');
        const photoPlaceholder = document.getElementById('photoPlaceholder');
        const removePhotoBtn = document.getElementById('removePhoto');
        const uploadArea = document.getElementById('uploadArea');
        const deletePhotoInput = document.getElementById('delete_photo');
        const form = $("#formeditKaryawan");

        if (photoInput) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format File Tidak Valid',
                            text: 'Hanya file format JPG, JPEG, dan PNG yang diperbolehkan!'
                        });
                        photoInput.value = '';
                        return;
                    }

                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ukuran Terlalu Besar',
                            text: 'Ukuran file pas foto maksimal 2MB!'
                        });
                        photoInput.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        photoPreview.src = evt.target.result;
                        photoPreview.style.display = 'block';
                        if (photoPlaceholder) photoPlaceholder.style.display = 'none';
                        if (removePhotoBtn) removePhotoBtn.style.display = 'flex';
                        if (deletePhotoInput) deletePhotoInput.value = '0';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        if (removePhotoBtn) {
            removePhotoBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                Swal.fire({
                    title: 'Hapus Pas Foto?',
                    text: "Foto profil pegawai ini akan dihapus saat form disimpan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus Foto',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl p-5',
                        title: 'text-base font-bold text-slate-900',
                        confirmButton: 'px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer',
                        cancelButton: 'px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (photoInput) photoInput.value = '';
                        if (photoPreview) {
                            photoPreview.src = '';
                            photoPreview.style.display = 'none';
                        }
                        if (photoPlaceholder) photoPlaceholder.style.display = 'flex';
                        removePhotoBtn.style.display = 'none';
                        if (deletePhotoInput) deletePhotoInput.value = '1';
                    }
                });
            });
        }

        // Drag & drop support
        if (uploadArea) {
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('border-emerald-500', 'bg-emerald-50/50');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-emerald-500', 'bg-emerald-50/50');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-emerald-500', 'bg-emerald-50/50');
                if (e.dataTransfer.files.length > 0 && photoInput) {
                    photoInput.files = e.dataTransfer.files;
                    photoInput.dispatchEvent(new Event('change'));
                }
            });
        }

        // Validation Rules Map
        const validationRules = {
            'npp': { required: true, message: 'NPP (Nomor Pokok Pegawai) wajib diisi' },
            'no_ktp': { required: true, message: 'NIK / No. KTP wajib diisi', maxLength: 16, maxMessage: 'No. KTP maksimal 16 digit' },
            'no_kk': { required: false, maxLength: 16, maxMessage: 'No. KK maksimal 16 digit' },
            'nama_lengkap': { required: true, message: 'Nama lengkap pegawai wajib diisi' },
            'jenis_kelamin': { required: true, message: 'Jenis kelamin wajib dipilih' },
            'tempat_lahir': { required: true, message: 'Tempat lahir wajib diisi' },
            'tanggal_lahir': { required: true, message: 'Tanggal lahir wajib diisi' },
            'no_hp': { required: true, message: 'Nomor WhatsApp / HP wajib diisi' },
            'pendidikan_terakhir': { required: true, message: 'Pendidikan terakhir wajib dipilih' },
            'alamat_ktp': { required: true, message: 'Alamat KTP wajib diisi' },
            'alamat_tinggal': { required: true, message: 'Alamat domisili / tempat tinggal wajib diisi' },
            'kode_unit': { required: true, message: 'Unit penempatan kerja wajib dipilih' },
            'kode_dept': { required: true, message: 'Departemen kerja wajib dipilih' },
            'kode_jabatan': { required: true, message: 'Jabatan pegawai wajib dipilih' },
            'status_karyawan': { required: true, message: 'Status kepegawaian wajib dipilih' },
            'tmt': { required: true, message: 'TMT mulai bertugas wajib diisi' },
            'status': { required: true, message: 'Status keaktifan pegawai wajib dipilih' }
        };

        function showError(element, message) {
            const $el = $(element);
            const $container = $el.closest('.space-y-1, .space-y-1.5, .space-y-2');
            
            $el.addClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20')
               .removeClass('border-slate-300 focus:ring-emerald-500/20 focus:border-emerald-600');
            
            // Left icon highlight
            $el.siblings('.pointer-events-none').find('i').addClass('text-rose-500').removeClass('text-slate-400');
            
            // Remove existing error msg
            $container.find('.error-msg').remove();
            
            // Append error message
            $container.append(`
                <p class="error-msg text-[11px] font-semibold text-rose-500 mt-1 flex items-center gap-1 animate-in fade-in duration-200">
                    <i class="ti ti-alert-circle text-xs shrink-0"></i>
                    <span>${message}</span>
                </p>
            `);
        }

        function clearError(element) {
            const $el = $(element);
            const $container = $el.closest('.space-y-1, .space-y-1.5, .space-y-2');
            
            $el.removeClass('border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/20')
               .addClass('border-slate-300 focus:ring-emerald-500/20 focus:border-emerald-600');
            
            $el.siblings('.pointer-events-none').find('i').removeClass('text-rose-500').addClass('text-slate-400');
            
            $container.find('.error-msg').remove();
        }

        function validateSingleField(el) {
            const $el = $(el);
            const name = $el.attr('name') || $el.attr('id');
            const val = ($el.val() || '').toString().trim();

            const rule = validationRules[name];
            if (!rule) {
                clearError($el);
                return true;
            }

            if (rule.required && !val) {
                showError($el, rule.message);
                return false;
            }

            if (rule.maxLength && val.length > rule.maxLength) {
                showError($el, rule.maxMessage || `Maksimal ${rule.maxLength} karakter`);
                return false;
            }

            clearError($el);
            return true;
        }

        // Realtime validation trigger on blur, change, and input
        form.on('input change blur', 'input, select, textarea', function(e) {
            const $this = $(this);
            const hasError = $this.hasClass('border-rose-500');
            const val = ($this.val() || '').toString().trim();
            
            if (e.type === 'blur' || val !== '' || hasError) {
                validateSingleField(this);
            }
        });

        // Form Submit Validation
        form.on('submit', function(e) {
            let isValid = true;
            let firstInvalidEl = null;

            // Validate all registered fields
            Object.keys(validationRules).forEach(function(fieldName) {
                const $el = form.find(`[name="${fieldName}"]`);
                if ($el.length > 0 && $el.is(':visible')) {
                    const valid = validateSingleField($el);
                    if (!valid) {
                        isValid = false;
                        if (!firstInvalidEl) {
                            firstInvalidEl = $el;
                        }
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
                if (firstInvalidEl) {
                    firstInvalidEl.focus();
                    if (firstInvalidEl[0].scrollIntoView) {
                        firstInvalidEl[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
                return false;
            }

            // If valid, disable submit button to prevent double submit
            const submitBtn = form.find('#btnUpdateKaryawan');
            submitBtn.prop('disabled', true).html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');
        });
    });
</script>
