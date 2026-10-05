<form action="{{ route('pendaftaran.store') }}" aria-autocomplete="false" id="formPendaftaran" method="POST" class="space-y-5" novalidate>
    <input type="hidden" id="id_siswa" name="id_siswa">
    @csrf

    <!-- ================= 1. INFORMASI PENDAFTARAN ================= -->
    <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5">
        <div class="flex items-center gap-2.5 mb-3.5 pb-2.5 border-b border-slate-200/80">
            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                <i class="ti ti-clipboard-list"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900 leading-tight">1. Informasi Pendaftaran</h3>
                <p class="text-[11px] text-slate-500">Nomor registrasi, tanggal, dan jenjang pendidikan santri</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
            <!-- No Pendaftaran -->
            <div class="space-y-1">
                <label for="no_pendaftaran" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-barcode text-sm text-slate-400"></i>
                    <span>No. Pendaftaran (Auto)</span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-barcode text-base"></i>
                    </div>
                    <input type="text" 
                           id="no_pendaftaran" 
                           name="no_pendaftaran" 
                           placeholder="Otomatis oleh sistem" 
                           class="w-full pl-9 pr-3.5 py-2 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                </div>
            </div>

            <!-- Tanggal Pendaftaran -->
            <div class="space-y-1">
                <label for="tanggal_pendaftaran" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-calendar text-sm text-slate-400"></i>
                    <span>Tanggal Pendaftaran <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-calendar text-base"></i>
                    </div>
                    <input type="text" 
                           id="tanggal_pendaftaran" 
                           name="tanggal_pendaftaran" 
                           value="{{ date('Y-m-d') }}"
                           autocomplete="off"
                           class="flatpickr-date w-full pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-calendar-event text-sm"></i>
                    </div>
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
                            <option value="{{ $u->kode_unit }}">{{ $u->nama_unit }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Jenis Pendaftaran -->
            <div class="space-y-1">
                <label for="jenis_pendaftaran" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-exchange text-sm text-slate-400"></i>
                    <span>Jenis Pendaftaran <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-exchange text-base"></i>
                    </div>
                    <select name="jenis_pendaftaran" 
                            id="jenis_pendaftaran" 
                            class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="Baru">Baru</option>
                        <option value="Pindahan">Pindahan</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conditional Pindahan Fields -->
        <div id="pindahan_fields" style="display: none" class="mt-3.5 pt-3.5 border-t border-slate-200">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div class="space-y-1">
                    <label for="tingkat_masuk" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-stairs text-sm text-slate-400"></i>
                        <span>Tingkat Masuk Pindahan <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-stairs text-base"></i>
                        </div>
                        <select name="tingkat_masuk" 
                                id="tingkat_masuk" 
                                class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                            <option value="">-- Pilih Tingkat --</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                            <i class="ti ti-chevron-down text-sm"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="kode_biaya_pindahan" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-receipt text-sm text-slate-400"></i>
                        <span>Paket Biaya Masuk Pindahan <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-receipt text-base"></i>
                        </div>
                        <select name="kode_biaya_pindahan" 
                                id="kode_biaya_pindahan" 
                                class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                            <option value="">-- Pilih Paket Biaya --</option>
                            @foreach ($biaya_pindahan as $bp)
                                <option value="{{ $bp->kode_biaya }}">{{ $bp->kode_biaya }} - {{ $bp->nama_unit }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                            <i class="ti ti-chevron-down text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= 2-COLUMN MAIN GRID ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <!-- ================= LEFT COLUMN: BIODATA & ALAMAT ================= -->
        <div class="space-y-5">

            <!-- 2. BIODATA SANTRI -->
            <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                        <i class="ti ti-user"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 leading-tight">2. Biodata Santri</h3>
                        <p class="text-[11px] text-slate-500">Identitas pribadi dan data kependudukan santri</p>
                    </div>
                </div>

                <!-- NISN -->
                <div class="space-y-1">
                    <label for="nisn" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-id text-sm text-slate-400"></i>
                        <span>NISN (Nomor Induk Siswa Nasional)</span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-id text-base"></i>
                        </div>
                        <input type="text" 
                               id="nisn" 
                               name="nisn" 
                               placeholder="Masukkan 10 digit NISN (opsional)..." 
                               class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    </div>
                </div>

                <!-- Nama Lengkap with Search Siswa Button -->
                <div class="space-y-1">
                    <label for="nama_lengkap" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-user text-sm text-slate-400"></i>
                        <span>Nama Lengkap Santri <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="flex items-stretch gap-2">
                        <div class="relative flex-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-user text-base"></i>
                            </div>
                            <input type="text" 
                                   id="nama_lengkap" 
                                   name="nama_lengkap" 
                                   placeholder="Nama lengkap sesuai akta / ijazah..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                        <button type="button" 
                                id="btnCarisiswa" 
                                class="px-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg flex items-center justify-center transition shadow-2xs cursor-pointer active:scale-95 shrink-0" 
                                title="Cari Siswa Terdaftar di Database">
                            <i class="ti ti-search text-base"></i>
                        </button>
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
                            <option value="L">Laki - Laki</option>
                            <option value="P">Perempuan</option>
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
                                   placeholder="Kota kelahiran..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

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
                        <p class="text-[11px] text-slate-500">Alamat tempat tinggal lengkap santri</p>
                    </div>
                </div>

                <!-- Alamat Textarea with Inside Icon -->
                <div class="space-y-1">
                    <label for="alamat" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-home text-sm text-slate-400"></i>
                        <span>Alamat Lengkap (Jalan, RT/RW, No. Rumah) <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute top-2.5 left-0 flex items-start pl-3 text-slate-400">
                            <i class="ti ti-home text-base"></i>
                        </div>
                        <textarea id="alamat" 
                                  name="alamat" 
                                  rows="2" 
                                  placeholder="Masukkan alamat lengkap santri..." 
                                  class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"></textarea>
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
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
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
                               placeholder="Contoh: 45123" 
                               class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= RIGHT COLUMN: ASAL SEKOLAH & ORANG TUA ================= -->
        <div class="space-y-5">

            <!-- 4. ASAL SEKOLAH -->
            <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                        <i class="ti ti-school"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 leading-tight">4. Asal Sekolah</h3>
                        <p class="text-[11px] text-slate-500">Sekolah atau madrasah jenjang sebelumnya</p>
                    </div>
                </div>

                <!-- Asal Sekolah with Plus Button -->
                <div class="space-y-1">
                    <label for="kode_asal_sekolah" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-building-skyscraper text-sm text-slate-400"></i>
                        <span>Asal Sekolah <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="flex items-stretch gap-2">
                        <div class="relative flex-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-building-skyscraper text-base"></i>
                            </div>
                            <select name="kode_asal_sekolah" 
                                    id="kode_asal_sekolah" 
                                    class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                <option value="">-- Pilih Asal Sekolah --</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-chevron-down text-sm"></i>
                            </div>
                        </div>
                        <button type="button" 
                                id="btnTambahsekolah" 
                                class="px-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg flex items-center justify-center transition shadow-2xs cursor-pointer active:scale-95 shrink-0" 
                                title="Tambah Data Asal Sekolah Baru">
                            <i class="ti ti-plus text-base"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- 5. DATA ORANG TUA / WALI -->
            <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                        <i class="ti ti-users"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 leading-tight">5. Data Orang Tua / Wali</h3>
                        <p class="text-[11px] text-slate-500">Data identitas, pendidikan, pekerjaan, dan kontak orang tua</p>
                    </div>
                </div>

                <!-- No KK -->
                <div class="space-y-1">
                    <label for="no_kk" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-id-badge-2 text-sm text-slate-400"></i>
                        <span>Nomor Kartu Keluarga (KK) <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-id-badge-2 text-base"></i>
                        </div>
                        <input type="text" 
                               id="no_kk" 
                               name="no_kk" 
                               maxlength="16"
                               placeholder="16 digit nomor KK..." 
                               class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    </div>
                </div>

                <!-- Ayah: NIK & Nama -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="nik_ayah" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-credit-card text-sm text-slate-400"></i>
                            <span>NIK Ayah <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-credit-card text-base"></i>
                            </div>
                            <input type="text" 
                                   id="nik_ayah" 
                                   name="nik_ayah" 
                                   maxlength="16"
                                   placeholder="16 digit NIK ayah..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="nama_ayah" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-user text-sm text-slate-400"></i>
                            <span>Nama Lengkap Ayah <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-user text-base"></i>
                            </div>
                            <input type="text" 
                                   id="nama_ayah" 
                                   name="nama_ayah" 
                                   placeholder="Nama ayah kandung..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Ayah: Pendidikan & Pekerjaan -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="pendidikan_ayah" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-certificate text-sm text-slate-400"></i>
                            <span>Pendidikan Ayah <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-certificate text-base"></i>
                            </div>
                            <select name="pendidikan_ayah" 
                                    id="pendidikan_ayah" 
                                    class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                <option value="">-- Pilih Pendidikan --</option>
                                @foreach ($pendidikan as $p)
                                    <option value="{{ $p }}">{{ $p }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="pekerjaan_ayah" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-briefcase text-sm text-slate-400"></i>
                            <span>Pekerjaan Ayah <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-briefcase text-base"></i>
                            </div>
                            <input type="text" 
                                   id="pekerjaan_ayah" 
                                   name="pekerjaan_ayah" 
                                   placeholder="Profesi / Pekerjaan ayah..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200/80 my-1"></div>

                <!-- Ibu: NIK & Nama -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="nik_ibu" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-credit-card text-sm text-slate-400"></i>
                            <span>NIK Ibu <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-credit-card text-base"></i>
                            </div>
                            <input type="text" 
                                   id="nik_ibu" 
                                   name="nik_ibu" 
                                   maxlength="16"
                                   placeholder="16 digit NIK ibu..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="nama_ibu" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-user text-sm text-slate-400"></i>
                            <span>Nama Lengkap Ibu <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-user text-base"></i>
                            </div>
                            <input type="text" 
                                   id="nama_ibu" 
                                   name="nama_ibu" 
                                   placeholder="Nama ibu kandung..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Ibu: Pendidikan & Pekerjaan -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="pendidikan_ibu" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-certificate text-sm text-slate-400"></i>
                            <span>Pendidikan Ibu <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-certificate text-base"></i>
                            </div>
                            <select name="pendidikan_ibu" 
                                    id="pendidikan_ibu" 
                                    class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                <option value="">-- Pilih Pendidikan --</option>
                                @foreach ($pendidikan as $p)
                                    <option value="{{ $p }}">{{ $p }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="pekerjaan_ibu" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-briefcase text-sm text-slate-400"></i>
                            <span>Pekerjaan Ibu <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-briefcase text-base"></i>
                            </div>
                            <input type="text" 
                                   id="pekerjaan_ibu" 
                                   name="pekerjaan_ibu" 
                                   placeholder="Profesi / Pekerjaan ibu..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200/80 my-1"></div>

                <!-- Kontak & Penghasilan Orang Tua -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="no_hp_orang_tua" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-brand-whatsapp text-sm text-slate-400"></i>
                            <span>No. WhatsApp / HP Orang Tua <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-brand-whatsapp text-base"></i>
                            </div>
                            <input type="text" 
                                   id="no_hp_orang_tua" 
                                   name="no_hp_orang_tua" 
                                   placeholder="Contoh: 08123456789" 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="kode_penghasilan_ortu" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-wallet text-sm text-slate-400"></i>
                            <span>Penghasilan Orang Tua</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-wallet text-base"></i>
                            </div>
                            <select name="kode_penghasilan_ortu" 
                                    id="kode_penghasilan_ortu" 
                                    class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                <option value="">-- Pilih Penghasilan --</option>
                                @foreach ($penghasilan_ortu as $po)
                                    <option value="{{ $po->kode_penghasilan_ortu }}">{{ $po->penghasilan }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- ================= SUBMIT ACTION BUTTON (CLEAN & NEAT FOOTER) ================= -->
    <div class="pt-4 mt-2 border-t border-slate-200/90 flex flex-col sm:flex-row items-center justify-between gap-3 bg-white">
        <div class="text-xs text-slate-400 font-medium hidden sm:flex items-center gap-1.5">
            <i class="ti ti-info-circle text-sm text-emerald-600"></i>
            <span>Kolom dengan tanda <strong class="text-rose-500 font-bold">*</strong> wajib diisi lengkap</span>
        </div>
        <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
            <button type="button" data-bs-dismiss="modal" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs sm:text-sm rounded-lg transition active:scale-95 cursor-pointer">
                Batal
            </button>
            <button type="submit" id="btnSimpan" class="w-full sm:w-auto px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-lg shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                <i class="ti ti-device-floppy text-base"></i>
                <span>Simpan Pendaftaran</span>
            </button>
        </div>
    </div>

</form>

<script>
    $(function() {
        const form = $("#formPendaftaran");
        const loading = `
            <div class="p-8 text-center">
                <div class="w-8 h-8 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                <div class="text-xs font-semibold text-slate-600">Memuat data...</div>
            </div>
        `;
        
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

        // ================= ERROR HANDLING & REALTIME VALIDATION =================
        const validationRules = {
            'tanggal_pendaftaran': { required: true, message: 'Tanggal pendaftaran wajib diisi' },
            'kode_unit': { required: true, message: 'Jenjang pendidikan wajib dipilih' },
            'jenis_pendaftaran': { required: true, message: 'Jenis pendaftaran wajib dipilih' },
            'nama_lengkap': { required: true, message: 'Nama lengkap santri wajib diisi' },
            'jenis_kelamin': { required: true, message: 'Jenis kelamin wajib dipilih' },
            'tempat_lahir': { required: true, message: 'Tempat lahir wajib diisi' },
            'tanggal_lahir': { required: true, message: 'Tanggal lahir wajib diisi' },
            'anak_ke': { required: true, message: 'Urutan anak ke wajib diisi' },
            'alamat': { required: true, message: 'Alamat domisili lengkap wajib diisi' },
            'id_province': { required: true, message: 'Provinsi wajib dipilih' },
            'id_regency': { required: true, message: 'Kabupaten / Kota wajib dipilih' },
            'id_district': { required: true, message: 'Kecamatan wajib dipilih' },
            'id_village': { required: true, message: 'Desa / Kelurahan wajib dipilih' },
            'kode_pos': { required: true, message: 'Kode pos wajib diisi' },
            'kode_asal_sekolah': { required: true, message: 'Asal sekolah wajib dipilih' },
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
            
            // Conditional pindahan rules
            if ($("#jenis_pendaftaran").val() === 'Pindahan') {
                if (name === 'tingkat_masuk' && !val) {
                    showError($el, 'Tingkat masuk pindahan wajib dipilih');
                    return false;
                }
                if (name === 'kode_biaya_pindahan' && !val) {
                    showError($el, 'Paket biaya masuk pindahan wajib dipilih');
                    return false;
                }
            }

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

        // ================= FORM SUBMISSION VALIDATION =================
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

            // If Pindahan, validate extra fields
            if ($("#jenis_pendaftaran").val() === 'Pindahan') {
                const $tm = form.find('#tingkat_masuk');
                const $bp = form.find('#kode_biaya_pindahan');
                if (!validateSingleField($tm)) {
                    isValid = false;
                    if (!firstInvalidEl) firstInvalidEl = $tm;
                }
                if (!validateSingleField($bp)) {
                    isValid = false;
                    if (!firstInvalidEl) firstInvalidEl = $bp;
                }
            }

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

            // If valid, disable submit button to avoid double submit
            const $btn = form.find('#btnSimpan');
            $btn.prop('disabled', true).html('<div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div><span>Menyimpan...</span>');
        });

        // ================= CASCADING AJAX WILAYAH =================
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

        // AUTOLOAD DATA USER (EDIT FORM)
        @if(isset($user))
            form.find('#id_province').val('{{ $user->id_province }}');
            getRegency('{{ $user->id_province }}', '{{ $user->id_regency }}');
            getDistrict('{{ $user->id_regency }}', '{{ $user->id_district }}');
            getVillage('{{ $user->id_district }}', '{{ $user->id_village }}');
            setTimeout(function() {
                form.find('#id_regency').val('{{ $user->id_regency }}');
                form.find('#id_district').val('{{ $user->id_district }}');
                form.find('#id_village').val('{{ $user->id_village }}');
            }, 1000);
        @endif

        $("#id_province").change(function() {
            getRegency($(this).val(), "");
        });

        $("#id_regency").change(function() {
            getDistrict($(this).val(), "");
        });

        $("#id_district").change(function() {
            getVillage($(this).val(), "");
        });

        $("#btnCarisiswa").click(function() {
            $("#modalSiswa").modal("show");
        });

        function getSiswa(id_siswa) {
            $.ajax({
                url: `/siswa/${id_siswa}/getsiswa`,
                type: "GET",
                cache: false,
                success: function(response) {
                    form.find("#id_siswa").val(response.id_siswa);
                    form.find("#nisn").val(response.nisn);
                    form.find("#nama_lengkap").val(response.nama_lengkap);
                    form.find("#jenis_kelamin").val(response.jenis_kelamin);
                    form.find("#tempat_lahir").val(response.tempat_lahir);
                    form.find("#tanggal_lahir").val(response.tanggal_lahir);
                    form.find("#anak_ke").val(response.anak_ke);
                    form.find("#jumlah_saudara").val(response.jumlah_saudara);
                    form.find("#alamat").val(response.alamat);
                    form.find("#id_province").val(response.id_province);
                    getRegency(response.id_province, response.id_regency);
                    getDistrict(response.id_regency, response.id_district);
                    getVillage(response.id_district, response.id_village);
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

                    // Clear any validation errors
                    form.find('input, select, textarea').each(function() {
                        clearError(this);
                    });

                    $("#modalSiswa").modal("hide");
                }
            });
        }

        $('#tabelsiswa tbody').on('click', '.pilihsiswa', function(e) {
            e.preventDefault();
            let id_siswa = $(this).attr('id_siswa');
            getSiswa(id_siswa);
        });

        form.find("#btnTambahsekolah").click(function(e) {
            e.preventDefault();
            const kode_unit = form.find("#kode_unit").val();
            if (!kode_unit) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih Jenjang Pendidikan terlebih dahulu!',
                    didClose: () => {
                        form.find("#kode_unit").focus();
                    }
                });
            } else {
                $("#modalSekolah").modal("show");
                $("#modalSekolah").find("#loadmodalSekolah").html(loading);
                $("#modalSekolah").find(".modal-title").text("Tambah Data Asal Sekolah");
                $("#modalSekolah").find("#loadmodalSekolah").load("/asalsekolah/create");
            }
        });

        function loadasalsekolah() {
            const kode_unit = form.find("#kode_unit").val();
            const kode_asal_sekolah = "0";
            $("#kode_asal_sekolah").load(`/asalsekolah/${kode_unit}/${kode_asal_sekolah}/getasalsekolahbyunit`);
        }

        $("#kode_unit").change(function() {
            loadasalsekolah();
            const kode_unit = $(this).val();
            $.ajax({
                type: 'POST',
                url: '/unit/gettingkatbyunit',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit
                },
                cache: false,
                success: function(respond) {
                    $("#tingkat_masuk").html(respond);
                }
            });
        });

        $("#jenis_pendaftaran").change(function() {
            if ($(this).val() == "Pindahan") {
                $("#pindahan_fields").slideDown(200);
            } else {
                $("#pindahan_fields").slideUp(200);
                clearError('#tingkat_masuk');
                clearError('#kode_biaya_pindahan');
            }
        });

    });
</script>
