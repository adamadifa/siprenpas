<form action="{{ route('anggota.store') }}" aria-autocomplete="false" id="formAnggota" method="POST" class="space-y-5" novalidate>
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        
        <!-- ================= LEFT COLUMN: DATA PRIBADI & KONTAK ================= -->
        <div class="space-y-5">
            <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                        <i class="ti ti-user"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 leading-tight">1. Data Pribadi & Kontak Anggota</h3>
                        <p class="text-[11px] text-slate-500">Informasi identitas kependudukan, biodata, dan kontak aktif</p>
                    </div>
                </div>

                <!-- No Anggota & NIK -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <!-- No. Anggota -->
                    <div class="space-y-1">
                        <label for="no_anggota" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-barcode text-sm text-slate-400"></i>
                            <span>No. Anggota</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-barcode text-base"></i>
                            </div>
                            <input type="text" 
                                   id="no_anggota" 
                                   name="no_anggota" 
                                   placeholder="(Otomatis dibuat sistem)" 
                                   disabled 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-bold text-slate-400 bg-slate-100/80 border border-slate-200 rounded-lg cursor-not-allowed">
                        </div>
                    </div>

                    <!-- NIK -->
                    <div class="space-y-1">
                        <label for="nik" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-id-badge-2 text-sm text-slate-400"></i>
                            <span>Nomor Identitas (NIK) <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-id-badge-2 text-base"></i>
                            </div>
                            <input type="text" 
                                   id="nik" 
                                   name="nik" 
                                   maxlength="16"
                                   placeholder="16 digit NIK KTP..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div class="space-y-1">
                    <label for="nama_lengkap" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-user text-sm text-slate-400"></i>
                        <span>Nama Lengkap Anggota <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-user text-base"></i>
                        </div>
                        <input type="text" 
                               id="nama_lengkap" 
                               name="nama_lengkap" 
                               placeholder="Nama lengkap sesuai KTP..." 
                               class="w-full pl-9 pr-3.5 py-2 text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
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
                                   placeholder="Pilih tanggal lahir..." 
                                   autocomplete="off"
                                   class="flatpickr-date w-full pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-calendar-event text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jenis Kelamin & Pendidikan Terakhir -->
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
                                <option value="L">Laki - Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="pendidikan_terakhir" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-certificate text-sm text-slate-400"></i>
                            <span>Pendidikan Terakhir <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-certificate text-base"></i>
                            </div>
                            <select name="pendidikan_terakhir" 
                                    id="pendidikan_terakhir" 
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
                </div>

                <!-- Status Pernikahan & Jumlah Tanggungan -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="status_pernikahan" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-heart-handshake text-sm text-slate-400"></i>
                            <span>Status Pernikahan <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-heart-handshake text-base"></i>
                            </div>
                            <select name="status_pernikahan" 
                                    id="status_pernikahan" 
                                    class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                <option value="">-- Pilih Status --</option>
                                <option value="M">Menikah</option>
                                <option value="BM">Belum Menikah</option>
                                <option value="JD">Janda / Duda</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="jml_tanggungan" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-users-group text-sm text-slate-400"></i>
                            <span>Jumlah Tanggungan</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-users-group text-base"></i>
                            </div>
                            <input type="number" 
                                   id="jml_tanggungan" 
                                   name="jml_tanggungan" 
                                   min="0"
                                   placeholder="0" 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Kontak HP/WhatsApp -->
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
                               placeholder="Contoh: 081234567890" 
                               class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    </div>
                </div>

                <!-- Pasangan & Pekerjaan Pasangan -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="nama_pasangan" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-heart text-sm text-slate-400"></i>
                            <span>Nama Pasangan</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-heart text-base"></i>
                            </div>
                            <input type="text" 
                                   id="nama_pasangan" 
                                   name="nama_pasangan" 
                                   placeholder="Nama suami / istri..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="pekerjaan_pasangan" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-briefcase text-sm text-slate-400"></i>
                            <span>Pekerjaan Pasangan</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-briefcase text-base"></i>
                            </div>
                            <input type="text" 
                                   id="pekerjaan_pasangan" 
                                   name="pekerjaan_pasangan" 
                                   placeholder="Pekerjaan pasangan..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Ibu Kandung & Nama Saudara -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="nama_ibu" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-user-check text-sm text-slate-400"></i>
                            <span>Nama Ibu Kandung</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-user-check text-base"></i>
                            </div>
                            <input type="text" 
                                   id="nama_ibu" 
                                   name="nama_ibu" 
                                   placeholder="Nama ibu kandung..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="nama_saudara" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-users text-sm text-slate-400"></i>
                            <span>Nama Saudara / Kerabat</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-users text-base"></i>
                            </div>
                            <input type="text" 
                                   id="nama_saudara" 
                                   name="nama_saudara" 
                                   placeholder="Kontak darurat kerabat..." 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- ================= RIGHT COLUMN: DATA ALAMAT & DOMISILI ================= -->
        <div class="space-y-5">
            <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-3.5">
                <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                        <i class="ti ti-map-pin"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 leading-tight">2. Data Alamat & Domisili</h3>
                        <p class="text-[11px] text-slate-500">Alamat tempat tinggal, wilayah administratif, dan status kepemilikan rumah</p>
                    </div>
                </div>

                <!-- Alamat Lengkap -->
                <div class="space-y-1">
                    <label for="alamat" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-home text-sm text-slate-400"></i>
                        <span>Alamat Lengkap <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute top-2.5 left-0 flex items-start pl-3 text-slate-400">
                            <i class="ti ti-home text-base"></i>
                        </div>
                        <textarea id="alamat" 
                                  name="alamat" 
                                  rows="3" 
                                  placeholder="Nama jalan, nomor rumah, RT/RW..." 
                                  class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"></textarea>
                    </div>
                </div>

                <!-- Provinsi -->
                <div class="space-y-1">
                    <label for="id_province" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-map-2 text-sm text-slate-400"></i>
                        <span>Provinsi <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-map-2 text-base"></i>
                        </div>
                        <select name="id_province" 
                                id="id_province" 
                                class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach ($provinsi as $prov)
                                <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                            <i class="ti ti-chevron-down text-sm"></i>
                        </div>
                    </div>
                </div>

                <!-- Kabupaten / Kota -->
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

                <!-- Kecamatan -->
                <div class="space-y-1">
                    <label for="id_district" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-building-community text-sm text-slate-400"></i>
                        <span>Kecamatan <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-building-community text-base"></i>
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

                <!-- Desa / Kelurahan -->
                <div class="space-y-1">
                    <label for="id_village" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                        <i class="ti ti-home-2 text-sm text-slate-400"></i>
                        <span>Desa / Kelurahan <span class="text-rose-500 font-bold">*</span></span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ti ti-home-2 text-base"></i>
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

                <!-- Kode Pos & Status Tempat Tinggal -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label for="kode_pos" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-mailbox text-sm text-slate-400"></i>
                            <span>Kode Pos</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-mailbox text-base"></i>
                            </div>
                            <input type="text" 
                                   id="kode_pos" 
                                   name="kode_pos" 
                                   placeholder="Contoh: 40123" 
                                   class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="status_tinggal" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                            <i class="ti ti-building-estate text-sm text-slate-400"></i>
                            <span>Status Tinggal <span class="text-rose-500 font-bold">*</span></span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ti ti-building-estate text-base"></i>
                            </div>
                            <select name="status_tinggal" 
                                    id="status_tinggal" 
                                    class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                                <option value="">-- Pilih Status --</option>
                                <option value="MS">Milik Sendiri</option>
                                <option value="MK">Milik Keluarga</option>
                                <option value="SK">Sewa / Kontrak</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                <i class="ti ti-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="p-3 bg-emerald-50/70 border border-emerald-200/80 rounded-xl flex items-start gap-2.5 text-xs text-emerald-900 mt-2">
                    <i class="ti ti-info-circle text-emerald-600 text-base shrink-0 mt-0.5"></i>
                    <div class="leading-relaxed">
                        <span>Pastikan Nomor NIK dan Nomor HP/WhatsApp aktif dan sesuai untuk kemudahan verifikasi simpanan dan pembiayaan koperasi.</span>
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
        <button type="submit" id="btnSubmitAnggota" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Data Anggota</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formAnggota");

        // Initialize Flatpickr for date inputs
        if (typeof flatpickr !== 'undefined') {
            form.find(".flatpickr-date").each(function() {
                $(this).attr('autocomplete', 'off');
                flatpickr(this, {
                    dateFormat: "Y-m-d",
                    allowInput: true,
                    disableMobile: "true"
                });
            });
        }

        // Validation Rules Map
        const validationRules = {
            'nik': { required: true, message: 'Nomor Identitas (NIK) wajib diisi', maxLength: 16, maxMessage: 'NIK maksimal 16 digit' },
            'nama_lengkap': { required: true, message: 'Nama lengkap anggota wajib diisi' },
            'tempat_lahir': { required: true, message: 'Tempat lahir wajib diisi' },
            'tanggal_lahir': { required: true, message: 'Tanggal lahir wajib diisi' },
            'jenis_kelamin': { required: true, message: 'Jenis kelamin wajib dipilih' },
            'pendidikan_terakhir': { required: true, message: 'Pendidikan terakhir wajib dipilih' },
            'status_pernikahan': { required: true, message: 'Status pernikahan wajib dipilih' },
            'no_hp': { required: true, message: 'Nomor HP / WhatsApp wajib diisi' },
            'alamat': { required: true, message: 'Alamat lengkap wajib diisi' },
            'id_province': { required: true, message: 'Provinsi wajib dipilih' },
            'id_regency': { required: true, message: 'Kabupaten / Kota wajib dipilih' },
            'id_district': { required: true, message: 'Kecamatan wajib dipilih' },
            'id_village': { required: true, message: 'Desa / Kelurahan wajib dipilih' },
            'status_tinggal': { required: true, message: 'Status tinggal wajib dipilih' }
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

        // Cascading AJAX Wilayah
        function getRegency(id_province = "") {
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
                    id_province: id_province
                },
                cache: false,
                success: function(respond) {
                    form.find("#id_regency").html(respond);
                    form.find("#id_district").html('<option value="">-- Pilih Kecamatan --</option>');
                    form.find("#id_village").html('<option value="">-- Pilih Desa / Kelurahan --</option>');
                    clearError(form.find('#id_regency'));
                }
            });
        }

        function getDistrict(id_regency = "") {
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
                    id_regency: id_regency
                },
                cache: false,
                success: function(respond) {
                    form.find("#id_district").html(respond);
                    form.find("#id_village").html('<option value="">-- Pilih Desa / Kelurahan --</option>');
                    clearError(form.find('#id_district'));
                }
            });
        }

        function getVillage(id_district = "") {
            if (!id_district) {
                form.find("#id_village").html('<option value="">-- Pilih Desa / Kelurahan --</option>');
                return;
            }
            $.ajax({
                type: 'POST',
                url: '/village/getvillagebydistrict',
                data: {
                    _token: "{{ csrf_token() }}",
                    id_district: id_district
                },
                cache: false,
                success: function(respond) {
                    form.find("#id_village").html(respond);
                    clearError(form.find('#id_village'));
                }
            });
        }

        form.find("#id_province").change(function() {
            getRegency($(this).val());
        });

        form.find("#id_regency").change(function() {
            getDistrict($(this).val());
        });

        form.find("#id_district").change(function() {
            getVillage($(this).val());
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
            const submitBtn = form.find('#btnSubmitAnggota');
            submitBtn.html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');
            setTimeout(function() {
                submitBtn.prop('disabled', true);
            }, 50);
        });
    });
</script>
