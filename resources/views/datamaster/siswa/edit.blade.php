1<form action="{{ route('siswa.update', Crypt::encrypt($siswa->id_siswa)) }}" aria-autocomplete="false" id="formEditSiswa" method="POST" enctype="multipart/form-data" class="space-y-5" novalidate>
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        
        <!-- ================= LEFT COLUMN: BIODATA & ALAMAT ================= -->
        <div class="space-y-5">
            
            <!-- 1. BIODATA SANTRI & FOTO -->
            <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                        <i class="ti ti-user"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 leading-tight">1. Identitas Santri / Siswa</h3>
                        <p class="text-[11px] text-slate-500">Foto profil dan biodata lengkap santri</p>
                    </div>
                </div>

                <!-- Foto Profil Santri -->
                @php
                    $fotoPath = isset($pendaftaran) && !empty($pendaftaran->foto) ? $pendaftaran->foto : (!empty($siswa->foto) ? $siswa->foto : null);
                @endphp
                <div class="p-3.5 bg-white border border-slate-200 rounded-xl">
                    <label class="block text-xs font-semibold text-slate-700 mb-2.5 flex items-center gap-1.5">
                        <i class="ti ti-camera text-sm text-slate-400"></i>
                        <span>Foto Profil Santri</span>
                    </label>
                    <div class="flex items-center gap-4">
                        <!-- Photo Thumbnail Preview -->
                        <div class="relative shrink-0 w-20 h-24 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 overflow-hidden flex items-center justify-center group shadow-2xs">
                            @if ($fotoPath && (Storage::disk('public')->exists('photos/pendaftaran/' . $fotoPath) || Storage::disk('public')->exists('photos/siswa/' . $fotoPath)))
                                <img id="photoPreview"
                                     src="{{ Storage::disk('public')->exists('photos/pendaftaran/' . $fotoPath) ? asset('storage/photos/pendaftaran/' . $fotoPath) : asset('storage/photos/siswa/' . $fotoPath) }}"
                                     class="w-full h-full object-cover"
                                     alt="Foto Santri">
                                <div id="photoPlaceholder" style="display: none;" class="flex-col items-center justify-center text-slate-400 text-center">
                                    <i class="ti ti-user text-2xl"></i>
                                </div>
                            @else
                                <div id="photoPlaceholder" class="flex flex-col items-center justify-center text-slate-400 text-center">
                                    <i class="ti ti-user text-2xl"></i>
                                    <span class="text-[9px] font-semibold mt-0.5">Belum ada</span>
                                </div>
                                <img id="photoPreview" style="display: none;" class="w-full h-full object-cover" alt="Preview Foto">
                            @endif

                            <button type="button" 
                                    id="removePhoto" 
                                    class="absolute top-1 right-1 w-5 h-5 rounded-full bg-rose-600 text-white flex items-center justify-center text-xs shadow-xs hover:bg-rose-700 transition cursor-pointer"
                                    style="display: {{ $fotoPath ? 'flex' : 'none' }};"
                                    title="Hapus Foto">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>

                        <!-- Upload Trigger Area -->
                        <div class="flex-1 min-w-0">
                            <div class="p-3 border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-xl bg-slate-50/70 hover:bg-emerald-50/30 text-center cursor-pointer transition"
                                 onclick="document.getElementById('photoInput').click()">
                                <i class="ti ti-cloud-upload text-xl text-emerald-600 mb-1"></i>
                                <div class="text-xs font-bold text-slate-700">Pilih / Drag Foto Baru</div>
                                <div class="text-[10px] text-slate-400 mt-0.5">Format JPG / PNG, Maksimal 2MB</div>
                            </div>
                            <input type="file" id="photoInput" name="foto" accept="image/jpeg,image/jpg,image/png" style="display: none;">
                        </div>
                    </div>
                </div>

                <!-- ID Siswa & NISN -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="id_siswa" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-id text-sm text-slate-400"></i>
                            <span>ID Siswa (Readonly)</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-lock text-base"></i>
                            </div>
                            <input type="text" 
                                   id="id_siswa" 
                                   value="{{ $siswa->id_siswa }}" 
                                   readonly 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-mono font-bold text-slate-600 bg-slate-100 border border-slate-300 rounded-lg cursor-not-allowed shadow-2xs">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="nisn" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-barcode text-sm text-slate-400"></i>
                            <span>NISN (Nomor Induk Siswa)</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-barcode text-base"></i>
                            </div>
                            <input type="text" 
                                   id="nisn" 
                                   name="nisn" 
                                   value="{{ $siswa->nisn }}"
                                   placeholder="10 digit NISN..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div class="space-y-1">
                    <label for="nama_lengkap" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-user text-sm text-slate-400"></i>
                        <span>Nama Lengkap Santri <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-user text-base"></i>
                        </div>
                        <input type="text" 
                               id="nama_lengkap" 
                               name="nama_lengkap" 
                               value="{{ $siswa->nama_lengkap }}"
                               placeholder="Nama lengkap sesuai akta / ijazah..." 
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
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki - Laki</option>
                            <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                            <i class="ti ti-chevron-down text-sm"></i>
                        </div>
                    </div>
                </div>

                <!-- Tempat & Tanggal Lahir -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
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
                                   value="{{ $siswa->tempat_lahir }}"
                                   placeholder="Kota kelahiran..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="tanggal_lahir" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-calendar text-sm text-slate-400"></i>
                            <span>Tanggal Lahir <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-calendar text-base"></i>
                            </div>
                            <input type="text" 
                                   id="tanggal_lahir" 
                                   name="tanggal_lahir" 
                                   value="{{ $siswa->tanggal_lahir }}"
                                   placeholder="Pilih tanggal..." 
                                   autocomplete="off"
                                   class="flatpickr-date w-full pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-calendar-event text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Anak Ke & Jumlah Saudara -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="anak_ke" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-user-check text-sm text-slate-400"></i>
                            <span>Anak Ke <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-user-check text-base"></i>
                            </div>
                            <input type="number" 
                                   id="anak_ke" 
                                   name="anak_ke" 
                                   value="{{ $siswa->anak_ke }}"
                                   placeholder="Contoh: 1" 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="jumlah_saudara" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-users text-sm text-slate-400"></i>
                            <span>Dari Jumlah Saudara</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-users text-base"></i>
                            </div>
                            <input type="number" 
                                   id="jumlah_saudara" 
                                   name="jumlah_saudara" 
                                   value="{{ $siswa->jumlah_saudara }}"
                                   placeholder="Contoh: 3" 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. ALAMAT & WILAYAH -->
            <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                        <i class="ti ti-map-pins"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 leading-tight">2. Alamat & Wilayah Domisili</h3>
                        <p class="text-[11px] text-slate-500">Data tempat tinggal tempat domisili santri</p>
                    </div>
                </div>

                <!-- Alamat Lengkap -->
                <div class="space-y-1">
                    <label for="alamat" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-home text-sm text-slate-400"></i>
                        <span>Alamat Lengkap <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute top-2.5 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-home text-base"></i>
                        </div>
                        <textarea id="alamat" 
                                  name="alamat" 
                                  rows="2" 
                                  placeholder="Masukkan alamat lengkap santri..." 
                                  class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">{{ $siswa->alamat }}</textarea>
                    </div>
                </div>

                <!-- Provinsi & Kabupaten -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="id_province" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-map text-sm text-slate-400"></i>
                            <span>Provinsi <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-map text-base"></i>
                            </div>
                            <select name="id_province" 
                                    id="id_province" 
                                    class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                <option value="">-- Pilih Provinsi --</option>
                                @foreach ($provinsi as $p)
                                    <option value="{{ $p->id }}" {{ $siswa->id_province == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="id_regency" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-building text-sm text-slate-400"></i>
                            <span>Kabupaten / Kota <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-building text-base"></i>
                            </div>
                            <select name="id_regency" 
                                    id="id_regency" 
                                    class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                <option value="">-- Pilih Kabupaten / Kota --</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kecamatan & Desa -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="id_district" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-map-pins text-sm text-slate-400"></i>
                            <span>Kecamatan <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-map-pins text-base"></i>
                            </div>
                            <select name="id_district" 
                                    id="id_district" 
                                    class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                <option value="">-- Pilih Kecamatan --</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="id_village" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-map-pin text-sm text-slate-400"></i>
                            <span>Desa / Kelurahan <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-map-pin text-base"></i>
                            </div>
                            <select name="id_village" 
                                    id="id_village" 
                                    class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                <option value="">-- Pilih Desa / Kelurahan --</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kode Pos -->
                <div class="space-y-1">
                    <label for="kode_pos" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-mail text-sm text-slate-400"></i>
                        <span>Kode Pos <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-mail text-base"></i>
                        </div>
                        <input type="text" 
                               id="kode_pos" 
                               name="kode_pos" 
                               value="{{ $siswa->kode_pos }}"
                               placeholder="Contoh: 45123" 
                               class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= RIGHT COLUMN: DATA ORANG TUA ================= -->
        <div class="space-y-5">
            
            <!-- 3. DATA ORANG TUA / WALI -->
            <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                        <i class="ti ti-users-group"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 leading-tight">3. Data Orang Tua / Wali</h3>
                        <p class="text-[11px] text-slate-500">Nomor KK, identitas ayah, ibu, dan nomor kontak</p>
                    </div>
                </div>

                <!-- No KK -->
                <div class="space-y-1">
                    <label for="no_kk" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-id text-sm text-slate-400"></i>
                        <span>Nomor Kartu Keluarga (KK) <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-id text-base"></i>
                        </div>
                        <input type="text" 
                               id="no_kk" 
                               name="no_kk" 
                               value="{{ $siswa->no_kk }}"
                               maxlength="16"
                               placeholder="16 Digit Nomor KK..." 
                               class="w-full pl-9 pr-3.5 py-2 text-sm font-mono font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    </div>
                </div>

                <!-- Ayah Sub-Card -->
                <div class="p-3.5 bg-white border border-slate-200 rounded-xl space-y-3">
                    <div class="text-xs font-bold text-emerald-700 flex items-center gap-1.5">
                        <i class="ti ti-user-check"></i>
                        <span>Data Ayah Kandung</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label for="nik_ayah" class="block text-[11px] font-semibold text-slate-600">
                                NIK Ayah <span class="text-rose-500 font-bold">*</span>
                            </label>
                            <input type="text" 
                                   id="nik_ayah" 
                                   name="nik_ayah" 
                                   value="{{ $siswa->nik_ayah }}"
                                   maxlength="16"
                                   placeholder="16 digit NIK Ayah" 
                                   class="w-full px-3 py-1.5 text-xs font-mono font-medium text-slate-800 bg-slate-50 border border-slate-300 rounded-lg placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>

                        <div class="space-y-1">
                            <label for="nama_ayah" class="block text-[11px] font-semibold text-slate-600">
                                Nama Lengkap Ayah <span class="text-rose-500 font-bold">*</span>
                            </label>
                            <input type="text" 
                                   id="nama_ayah" 
                                   name="nama_ayah" 
                                   value="{{ $siswa->nama_ayah }}"
                                   placeholder="Nama lengkap ayah" 
                                   class="w-full px-3 py-1.5 text-xs font-bold text-slate-800 bg-slate-50 border border-slate-300 rounded-lg placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label for="pendidikan_ayah" class="block text-[11px] font-semibold text-slate-600">
                                Pendidikan Ayah <span class="text-rose-500 font-bold">*</span>
                            </label>
                            <div class="relative">
                                <select name="pendidikan_ayah" 
                                        id="pendidikan_ayah" 
                                        class="w-full appearance-none px-3 pr-7 py-1.5 text-xs font-medium text-slate-800 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    @foreach ($pendidikan as $p)
                                        <option value="{{ $p }}" {{ $siswa->pendidikan_ayah == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-slate-400">
                                    <i class="ti ti-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="pekerjaan_ayah" class="block text-[11px] font-semibold text-slate-600">
                                Pekerjaan Ayah <span class="text-rose-500 font-bold">*</span>
                            </label>
                            <input type="text" 
                                   id="pekerjaan_ayah" 
                                   name="pekerjaan_ayah" 
                                   value="{{ $siswa->pekerjaan_ayah }}"
                                   placeholder="Contoh: Wiraswasta / PNS" 
                                   class="w-full px-3 py-1.5 text-xs font-medium text-slate-800 bg-slate-50 border border-slate-300 rounded-lg placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Ibu Sub-Card -->
                <div class="p-3.5 bg-white border border-slate-200 rounded-xl space-y-3">
                    <div class="text-xs font-bold text-rose-700 flex items-center gap-1.5">
                        <i class="ti ti-user-heart"></i>
                        <span>Data Ibu Kandung</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label for="nik_ibu" class="block text-[11px] font-semibold text-slate-600">
                                NIK Ibu <span class="text-rose-500 font-bold">*</span>
                            </label>
                            <input type="text" 
                                   id="nik_ibu" 
                                   name="nik_ibu" 
                                   value="{{ $siswa->nik_ibu }}"
                                   maxlength="16"
                                   placeholder="16 digit NIK Ibu" 
                                   class="w-full px-3 py-1.5 text-xs font-mono font-medium text-slate-800 bg-slate-50 border border-slate-300 rounded-lg placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>

                        <div class="space-y-1">
                            <label for="nama_ibu" class="block text-[11px] font-semibold text-slate-600">
                                Nama Lengkap Ibu <span class="text-rose-500 font-bold">*</span>
                            </label>
                            <input type="text" 
                                   id="nama_ibu" 
                                   name="nama_ibu" 
                                   value="{{ $siswa->nama_ibu }}"
                                   placeholder="Nama lengkap ibu" 
                                   class="w-full px-3 py-1.5 text-xs font-bold text-slate-800 bg-slate-50 border border-slate-300 rounded-lg placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label for="pendidikan_ibu" class="block text-[11px] font-semibold text-slate-600">
                                Pendidikan Ibu <span class="text-rose-500 font-bold">*</span>
                            </label>
                            <div class="relative">
                                <select name="pendidikan_ibu" 
                                        id="pendidikan_ibu" 
                                        class="w-full appearance-none px-3 pr-7 py-1.5 text-xs font-medium text-slate-800 bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    @foreach ($pendidikan as $p)
                                        <option value="{{ $p }}" {{ $siswa->pendidikan_ibu == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-slate-400">
                                    <i class="ti ti-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="pekerjaan_ibu" class="block text-[11px] font-semibold text-slate-600">
                                Pekerjaan Ibu <span class="text-rose-500 font-bold">*</span>
                            </label>
                            <input type="text" 
                                   id="pekerjaan_ibu" 
                                   name="pekerjaan_ibu" 
                                   value="{{ $siswa->pekerjaan_ibu }}"
                                   placeholder="Contoh: Ibu Rumah Tangga / Guru" 
                                   class="w-full px-3 py-1.5 text-xs font-medium text-slate-800 bg-slate-50 border border-slate-300 rounded-lg placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Kontak Orang Tua -->
                <div class="space-y-1">
                    <label for="no_hp_orang_tua" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-brand-whatsapp text-sm text-emerald-600"></i>
                        <span>No. WhatsApp / HP Orang Tua <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-phone text-base"></i>
                        </div>
                        <input type="text" 
                               id="no_hp_orang_tua" 
                               name="no_hp_orang_tua" 
                               value="{{ $siswa->no_hp_orang_tua }}"
                               placeholder="Contoh: 08xxxxxxxxxx" 
                               class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
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
        <button type="submit" id="btnSubmitEditSiswa" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Perubahan Siswa</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formEditSiswa");

        // Initialize flatpickr
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

        // Validation Rules Map matching /pendaftaran exactly
        const validationRules = {
            'nama_lengkap': { required: true, message: 'Nama lengkap santri wajib diisi' },
            'jenis_kelamin': { required: true, message: 'Jenis kelamin wajib dipilih' },
            'tempat_lahir': { required: true, message: 'Tempat lahir wajib diisi' },
            'tanggal_lahir': { required: true, message: 'Tanggal lahir wajib diisi' },
            'anak_ke': { required: true, message: 'Anak ke berapa wajib diisi' },
            'alamat': { required: true, message: 'Alamat lengkap wajib diisi' },
            'id_province': { required: true, message: 'Provinsi wajib dipilih' },
            'id_regency': { required: true, message: 'Kabupaten / Kota wajib dipilih' },
            'id_district': { required: true, message: 'Kecamatan wajib dipilih' },
            'id_village': { required: true, message: 'Desa / Kelurahan wajib dipilih' },
            'kode_pos': { required: true, message: 'Kode pos wajib diisi' },
            'no_kk': { required: true, message: 'Nomor Kartu Keluarga (KK) wajib diisi', maxLength: 16, maxMessage: 'Nomor KK maksimal 16 digit' },
            'nik_ayah': { required: true, message: 'NIK Ayah wajib diisi', maxLength: 16, maxMessage: 'NIK Ayah maksimal 16 digit' },
            'nama_ayah': { required: true, message: 'Nama lengkap ayah wajib diisi' },
            'pendidikan_ayah': { required: true, message: 'Pendidikan ayah wajib dipilih' },
            'pekerjaan_ayah': { required: true, message: 'Pekerjaan ayah wajib diisi' },
            'nik_ibu': { required: true, message: 'NIK Ibu wajib diisi', maxLength: 16, maxMessage: 'NIK Ibu maksimal 16 digit' },
            'nama_ibu': { required: true, message: 'Nama lengkap ibu wajib diisi' },
            'pendidikan_ibu': { required: true, message: 'Pendidikan ibu wajib dipilih' },
            'pekerjaan_ibu': { required: true, message: 'Pekerjaan ibu wajib diisi' },
            'no_hp_orang_tua': { required: true, message: 'Nomor WhatsApp / HP orang tua wajib diisi' }
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

            // Disable submit button safely
            const submitBtn = form.find('#btnSubmitEditSiswa');
            submitBtn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan Perubahan...</span>');
            setTimeout(function() {
                submitBtn.prop('disabled', true);
            }, 50);
        });

        // Photo Upload Handling
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
                            confirmButtonColor: '#059669'
                        });
                        this.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                        photoPreview.style.display = 'block';
                        if (photoPlaceholder) photoPlaceholder.style.display = 'none';
                        if (removePhotoBtn) removePhotoBtn.style.display = 'flex';
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
                    document.getElementById('formEditSiswa').appendChild(deleteInput);
                }
            });
        }

        // Cascading AJAX Wilayah
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
                    form.find("#id_regency").html(respond);
                    clearError('#id_regency');
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
                    form.find("#id_district").html(respond);
                    clearError('#id_district');
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
                    form.find("#id_village").html(respond);
                    clearError('#id_village');
                }
            });
        }

        // Initial cascading preselection for edit mode
        const initialProvince = "{{ $siswa->id_province }}";
        const initialRegency = "{{ $siswa->id_regency }}";
        const initialDistrict = "{{ $siswa->id_district }}";
        const initialVillage = "{{ $siswa->id_village }}";

        if (initialProvince) {
            getRegency(initialProvince, initialRegency);
            getDistrict(initialRegency, initialDistrict);
            getVillage(initialDistrict, initialVillage);
            setTimeout(function() {
                form.find('#id_regency').val(initialRegency);
                form.find('#id_district').val(initialDistrict);
                form.find('#id_village').val(initialVillage);
            }, 600);
        }

        form.find("#id_province").change(function() {
            getRegency($(this).val(), "");
            form.find("#id_district").html('<option value="">-- Pilih Kecamatan --</option>');
            form.find("#id_village").html('<option value="">-- Pilih Desa / Kelurahan --</option>');
        });

        form.find("#id_regency").change(function() {
            getDistrict($(this).val(), "");
            form.find("#id_village").html('<option value="">-- Pilih Desa / Kelurahan --</option>');
        });

        form.find("#id_district").change(function() {
            getVillage($(this).val(), "");
        });
    });
</script>
