<form action="{{ route('pendaftaranonline.update') }}" method="POST" id="formPendaftaranOnline" aria-autocomplete="false" class="space-y-5" novalidate>
    @csrf
    <input type="hidden" name="no_register" value="{{ Crypt::encrypt($pendaftaran->no_register) }}">

    <!-- ================= 1. INFORMASI PENDAFTARAN ONLINE ================= -->
    <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5">
        <div class="flex items-center gap-2.5 mb-3.5 pb-2.5 border-b border-slate-200/80">
            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                <i class="ti ti-world"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900 leading-tight">1. Informasi Registrasi Online</h3>
                <p class="text-[11px] text-slate-500">Nomor registrasi, tanggal masuk, dan jenjang pendidikan santri</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
            <!-- No Register (Readonly) -->
            <div class="space-y-1">
                <label for="no_register_display" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-barcode text-sm text-slate-400"></i>
                    <span>No. Register</span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-barcode text-base"></i>
                    </div>
                    <input type="text" 
                           id="no_register_display" 
                           name="no_register_display" 
                           value="{{ $pendaftaran->no_register }}" 
                           readonly 
                           class="w-full pl-9 pr-3.5 py-2 text-sm font-bold text-slate-600 bg-slate-100 border border-slate-300 rounded-lg shadow-2xs cursor-not-allowed">
                </div>
            </div>

            <!-- Tanggal Register -->
            <div class="space-y-1">
                <label for="tanggal_register_display" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-calendar text-sm text-slate-400"></i>
                    <span>Tanggal Register</span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-calendar text-base"></i>
                    </div>
                    <input type="text" 
                           id="tanggal_register_display" 
                           name="tanggal_register_display" 
                           value="{{ !empty($pendaftaran->tanggal_register) ? date('d-m-Y', strtotime($pendaftaran->tanggal_register)) : '-' }}"
                           readonly
                           class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-600 bg-slate-100 border border-slate-300 rounded-lg shadow-2xs cursor-not-allowed">
                </div>
            </div>

            <!-- Jenjang Pendidikan (Kode Unit) -->
            <div class="space-y-1">
                <label for="kode_unit" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-school text-sm text-slate-400"></i>
                    <span>Jenjang Pendidikan <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-school text-base"></i>
                    </div>
                    <select name="kode_unit" 
                            id="kode_unit" 
                            class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="">-- Pilih Jenjang --</option>
                        @foreach ($unit as $u)
                            <option value="{{ $u->kode_unit }}" {{ $pendaftaran->kode_unit == $u->kode_unit ? 'selected' : '' }}>
                                {{ $u->nama_unit }}
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

    <!-- ================= 2-COLUMN MAIN GRID ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <!-- ================= LEFT COLUMN: BIODATA SANTRI ================= -->
        <div class="space-y-5">

            <!-- 2. BIODATA SANTRI -->
            <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                        <i class="ti ti-user"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 leading-tight">2. Biodata Calon Santri</h3>
                        <p class="text-[11px] text-slate-500">Identitas pribadi calon santri online</p>
                    </div>
                </div>

                <!-- NISN & No. HP -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="nisn" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-id text-sm text-slate-400"></i>
                            <span>NISN</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-id text-base"></i>
                            </div>
                            <input type="text" 
                                   id="nisn" 
                                   name="nisn" 
                                   value="{{ $pendaftaran->nisn }}"
                                   placeholder="10 digit NISN..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="no_hp" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-phone text-sm text-slate-400"></i>
                            <span>No. HP / WhatsApp <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-phone text-base"></i>
                            </div>
                            <input type="text" 
                                   id="no_hp" 
                                   name="no_hp" 
                                   value="{{ $pendaftaran->no_hp }}"
                                   placeholder="Contoh: 081234567890" 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Nama Lengkap Santri -->
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
                               value="{{ $pendaftaran->nama_lengkap }}"
                               placeholder="Nama lengkap calon santri..." 
                               class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    </div>
                </div>

                <!-- Jenis Kelamin & Asal Sekolah -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
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
                                <option value="L" {{ $pendaftaran->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki - Laki</option>
                                <option value="P" {{ $pendaftaran->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="asal_sekolah" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-school text-sm text-slate-400"></i>
                            <span>Asal Sekolah</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-school text-base"></i>
                            </div>
                            <input type="text" 
                                   id="asal_sekolah" 
                                   name="asal_sekolah" 
                                   value="{{ $pendaftaran->asal_sekolah }}"
                                   placeholder="Nama asal sekolah / madrasah..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Tempat & Tanggal Lahir -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="tempat_lahir" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-map-pin text-sm text-slate-400"></i>
                            <span>Tempat Lahir</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-map-pin text-base"></i>
                            </div>
                            <input type="text" 
                                   id="tempat_lahir" 
                                   name="tempat_lahir" 
                                   value="{{ $pendaftaran->tempat_lahir }}"
                                   placeholder="Kota kelahiran..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="tanggal_lahir" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-cake text-sm text-slate-400"></i>
                            <span>Tanggal Lahir</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-cake text-base"></i>
                            </div>
                            <input type="text" 
                                   id="tanggal_lahir" 
                                   name="tanggal_lahir" 
                                   value="{{ $pendaftaran->tanggal_lahir }}"
                                   placeholder="Pilih tanggal lahir..." 
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
                            <span>Anak Ke</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-user-check text-base"></i>
                            </div>
                            <input type="number" 
                                   id="anak_ke" 
                                   name="anak_ke" 
                                   value="{{ $pendaftaran->anak_ke }}"
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
                                   value="{{ $pendaftaran->jumlah_saudara }}"
                                   placeholder="Contoh: 3" 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. ALAMAT DOMISILI -->
            <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                        <i class="ti ti-map-pin"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 leading-tight">3. Alamat Domisili</h3>
                        <p class="text-[11px] text-slate-500">Alamat tempat tinggal lengkap calon santri</p>
                    </div>
                </div>

                <!-- Alamat Textarea with Inside Icon -->
                <div class="space-y-1">
                    <label for="alamat" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-home text-sm text-slate-400"></i>
                        <span>Alamat Lengkap (Jalan, Kp., RT/RW)</span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute top-2.5 left-0 flex items-start pl-3 text-slate-400">
                            <i class="ti ti-home text-base"></i>
                        </div>
                        <textarea id="alamat" 
                                  name="alamat" 
                                  rows="2" 
                                  placeholder="Masukkan alamat lengkap santri..." 
                                  class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">{{ $pendaftaran->alamat }}</textarea>
                    </div>
                </div>

                <!-- Provinsi & Kabupaten -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="id_province" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-map text-sm text-slate-400"></i>
                            <span>Provinsi</span>
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
                                    <option value="{{ $p->id }}" {{ $pendaftaran->id_province == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
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
                            <span>Kabupaten / Kota</span>
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
                            <span>Kecamatan</span>
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
                            <span>Desa / Kelurahan</span>
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

                <!-- Kode Pos & No. KK -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="kode_pos" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-mail text-sm text-slate-400"></i>
                            <span>Kode Pos</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-mail text-base"></i>
                            </div>
                            <input type="text" 
                                   id="kode_pos" 
                                   name="kode_pos" 
                                   value="{{ $pendaftaran->kode_pos }}"
                                   placeholder="5 digit kode pos..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="no_kk" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-address-book text-sm text-slate-400"></i>
                            <span>No. Kartu Keluarga (KK)</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-address-book text-base"></i>
                            </div>
                            <input type="text" 
                                   id="no_kk" 
                                   name="no_kk" 
                                   value="{{ $pendaftaran->no_kk }}"
                                   placeholder="16 digit No. KK..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= RIGHT COLUMN: DATA ORANG TUA ================= -->
        <div class="space-y-5">

            <!-- 4. DATA ORANG TUA / WALI -->
            <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-4">
                <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                        <i class="ti ti-users"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 leading-tight">4. Data Orang Tua / Wali</h3>
                        <p class="text-[11px] text-slate-500">Informasi ayah dan ibu kandung santri</p>
                    </div>
                </div>

                <!-- SUBSECTION: DATA AYAH -->
                <div class="space-y-3 p-3.5 bg-white border border-slate-200/80 rounded-lg">
                    <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5 pb-2 border-b border-slate-100">
                        <i class="ti ti-user text-emerald-600"></i>
                        <span>A. Data Ayah Kandung</span>
                    </span>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label for="nik_ayah" class="block text-xs font-semibold text-slate-600 flex items-center gap-1">
                                <i class="ti ti-id text-xs text-slate-400"></i>
                                <span>NIK Ayah</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                                    <i class="ti ti-id text-sm"></i>
                                </div>
                                <input type="text" 
                                       id="nik_ayah" 
                                       name="nik_ayah" 
                                       value="{{ $pendaftaran->nik_ayah }}"
                                       placeholder="16 digit NIK Ayah..." 
                                       class="w-full pl-8 pr-3 py-1.5 text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="nama_ayah" class="block text-xs font-semibold text-slate-600 flex items-center gap-1">
                                <i class="ti ti-user text-xs text-slate-400"></i>
                                <span>Nama Ayah</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                                    <i class="ti ti-user text-sm"></i>
                                </div>
                                <input type="text" 
                                       id="nama_ayah" 
                                       name="nama_ayah" 
                                       value="{{ $pendaftaran->nama_ayah }}"
                                       placeholder="Nama lengkap ayah..." 
                                       class="w-full pl-8 pr-3 py-1.5 text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label for="pendidikan_ayah" class="block text-xs font-semibold text-slate-600 flex items-center gap-1">
                                <i class="ti ti-certificate text-xs text-slate-400"></i>
                                <span>Pendidikan Ayah</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                                    <i class="ti ti-certificate text-sm"></i>
                                </div>
                                <select name="pendidikan_ayah" 
                                        id="pendidikan_ayah" 
                                        class="w-full appearance-none pl-8 pr-8 py-1.5 text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                    <option value="">-- Pendidikan Ayah --</option>
                                    @foreach ($pendidikan as $p)
                                        <option value="{{ $p }}" {{ $pendaftaran->pendidikan_ayah == $p ? 'selected' : '' }}>
                                            {{ $p }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2.5 text-slate-400">
                                    <i class="ti ti-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="pekerjaan_ayah" class="block text-xs font-semibold text-slate-600 flex items-center gap-1">
                                <i class="ti ti-briefcase text-xs text-slate-400"></i>
                                <span>Pekerjaan Ayah</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                                    <i class="ti ti-briefcase text-sm"></i>
                                </div>
                                <input type="text" 
                                       id="pekerjaan_ayah" 
                                       name="pekerjaan_ayah" 
                                       value="{{ $pendaftaran->pekerjaan_ayah }}"
                                       placeholder="Pekerjaan ayah..." 
                                       class="w-full pl-8 pr-3 py-1.5 text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SUBSECTION: DATA IBU -->
                <div class="space-y-3 p-3.5 bg-white border border-slate-200/80 rounded-lg">
                    <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5 pb-2 border-b border-slate-100">
                        <i class="ti ti-user text-rose-500"></i>
                        <span>B. Data Ibu Kandung</span>
                    </span>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label for="nik_ibu" class="block text-xs font-semibold text-slate-600 flex items-center gap-1">
                                <i class="ti ti-id text-xs text-slate-400"></i>
                                <span>NIK Ibu</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                                    <i class="ti ti-id text-sm"></i>
                                </div>
                                <input type="text" 
                                       id="nik_ibu" 
                                       name="nik_ibu" 
                                       value="{{ $pendaftaran->nik_ibu }}"
                                       placeholder="16 digit NIK Ibu..." 
                                       class="w-full pl-8 pr-3 py-1.5 text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="nama_ibu" class="block text-xs font-semibold text-slate-600 flex items-center gap-1">
                                <i class="ti ti-user text-xs text-slate-400"></i>
                                <span>Nama Ibu</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                                    <i class="ti ti-user text-sm"></i>
                                </div>
                                <input type="text" 
                                       id="nama_ibu" 
                                       name="nama_ibu" 
                                       value="{{ $pendaftaran->nama_ibu }}"
                                       placeholder="Nama lengkap ibu..." 
                                       class="w-full pl-8 pr-3 py-1.5 text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label for="pendidikan_ibu" class="block text-xs font-semibold text-slate-600 flex items-center gap-1">
                                <i class="ti ti-certificate text-xs text-slate-400"></i>
                                <span>Pendidikan Ibu</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                                    <i class="ti ti-certificate text-sm"></i>
                                </div>
                                <select name="pendidikan_ibu" 
                                        id="pendidikan_ibu" 
                                        class="w-full appearance-none pl-8 pr-8 py-1.5 text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                    <option value="">-- Pendidikan Ibu --</option>
                                    @foreach ($pendidikan as $p)
                                        <option value="{{ $p }}" {{ $pendaftaran->pendidikan_ibu == $p ? 'selected' : '' }}>
                                            {{ $p }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2.5 text-slate-400">
                                    <i class="ti ti-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="pekerjaan_ibu" class="block text-xs font-semibold text-slate-600 flex items-center gap-1">
                                <i class="ti ti-briefcase text-xs text-slate-400"></i>
                                <span>Pekerjaan Ibu</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                                    <i class="ti ti-briefcase text-sm"></i>
                                </div>
                                <input type="text" 
                                       id="pekerjaan_ibu" 
                                       name="pekerjaan_ibu" 
                                       value="{{ $pendaftaran->pekerjaan_ibu }}"
                                       placeholder="Pekerjaan ibu..." 
                                       class="w-full pl-8 pr-3 py-1.5 text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                            </div>
                        </div>
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
        <button type="submit" id="btnSubmitForm" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Update Pendaftaran Online</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formPendaftaranOnline");

        // Inisialisasi flatpickr datepicker
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

        // Helper cascading wilayah
        function getRegency(id_province = "", id_regency = "") {
            if (!id_province) {
                form.find("#id_regency").html('<option value="">-- Pilih Kabupaten / Kota --</option>');
                form.find("#id_district").html('<option value="">-- Pilih Kecamatan --</option>');
                form.find("#id_village").html('<option value="">-- Pilih Desa / Kelurahan --</option>');
                return;
            }
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
                    if (id_regency) {
                        getDistrict(id_regency, "{{ $pendaftaran->id_district ?? '' }}");
                    }
                }
            });
        }

        function getDistrict(id_regency = "", id_district = "") {
            if (!id_regency) {
                form.find("#id_district").html('<option value="">-- Pilih Kecamatan --</option>');
                form.find("#id_village").html('<option value="">-- Pilih Desa / Kelurahan --</option>');
                return;
            }
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
                    if (id_district) {
                        getVillage(id_district, "{{ $pendaftaran->id_village ?? '' }}");
                    }
                }
            });
        }

        function getVillage(id_district = "", id_village = "") {
            if (!id_district) {
                form.find("#id_village").html('<option value="">-- Pilih Desa / Kelurahan --</option>');
                return;
            }
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
                }
            });
        }

        $("#id_province").change(function() {
            getRegency($(this).val(), "");
        });

        $("#id_regency").change(function() {
            getDistrict($(this).val(), "");
        });

        $("#id_district").change(function() {
            getVillage($(this).val(), "");
        });

        // Load initial selected cascading address
        @if(!empty($pendaftaran->id_province))
            getRegency("{{ $pendaftaran->id_province }}", "{{ $pendaftaran->id_regency ?? '' }}");
        @endif

        // Realtime validation helper
        function validateField(input) {
            const val = $(input).val() ? $(input).val().trim() : '';
            const isRequired = $(input).attr('id') === 'nama_lengkap' || $(input).attr('id') === 'kode_unit' || $(input).attr('id') === 'jenis_kelamin';

            if (isRequired && !val) {
                $(input).addClass('border-rose-500 bg-rose-50/20').removeClass('border-slate-300');
            } else {
                $(input).removeClass('border-rose-500 bg-rose-50/20').addClass('border-slate-300');
            }
        }

        form.find('input, select, textarea').on('input change blur', function() {
            validateField(this);
        });

        // Handle AJAX form submission
        form.on('submit', function(e) {
            e.preventDefault();

            let isValid = true;
            if (!$("#nama_lengkap").val() || !$("#nama_lengkap").val().trim()) {
                $("#nama_lengkap").addClass('border-rose-500 bg-rose-50/20');
                isValid = false;
            }
            if (!$("#kode_unit").val()) {
                $("#kode_unit").addClass('border-rose-500 bg-rose-50/20');
                isValid = false;
            }
            if (!$("#jenis_kelamin").val()) {
                $("#jenis_kelamin").addClass('border-rose-500 bg-rose-50/20');
                isValid = false;
            }

            if (!isValid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Formulir Belum Lengkap',
                    text: 'Mohon lengkapi kolom bertanda bintang (*) sebelum menyimpan.',
                    confirmButtonColor: '#059669',
                    customClass: { popup: 'rounded-2xl shadow-2xl' }
                });
                return;
            }

            const submitBtn = form.find('#btnSubmitForm');
            const originalHtml = submitBtn.html();
            submitBtn.prop('disabled', true).html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');

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
                        text: 'Data pendaftaran online berhasil diperbarui.',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-2xl shadow-2xl' }
                    }).then(() => {
                        $("#modal").modal("hide");
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalHtml);

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON?.errors || {};
                        let errorMessages = "";
                        $.each(errors, function(key, value) {
                            if (Array.isArray(value)) {
                                errorMessages += `<p class="mb-1">${value[0]}</p>`;
                            } else {
                                errorMessages += `<p class="mb-1">${value}</p>`;
                            }
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: errorMessages || 'Terjadi kesalahan pada data yang diinput.',
                            confirmButtonColor: '#059669',
                            customClass: { popup: 'rounded-2xl shadow-2xl' }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menyimpan!',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan pada server saat memperbarui data.',
                            confirmButtonColor: '#059669',
                            customClass: { popup: 'rounded-2xl shadow-2xl' }
                        });
                    }
                }
            });
        });
    });
</script>
