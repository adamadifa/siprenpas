<form action="{{ route('karyawan.store') }}" id="formcreateKaryawan" method="POST" class="space-y-5" novalidate>
    @csrf

    <!-- ================= 1. IDENTITAS & DATA PRIBADI ================= -->
    <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5 space-y-4">
        <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200/80">
            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold shadow-2xs">
                <i class="ti ti-user"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900 leading-tight">1. Identitas & Biodata Pegawai</h3>
                <p class="text-[11px] text-slate-500">Nomor pokok pegawai, identitas kependudukan, dan data pribadi</p>
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
                           placeholder="Nama lengkap beserta gelar (jika ada)..." 
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
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
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
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
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
                              class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"></textarea>
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
                              class="w-full pl-9 pr-3.5 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg placeholder-slate-400 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition"></textarea>
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
                <h3 class="text-sm font-bold text-slate-900 leading-tight">3. Status Kepegawaian & Penempatan</h3>
                <p class="text-[11px] text-slate-500">Tanggal masuk (TMT), unit penempatan, jabatan, dan departemen</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
            <!-- TMT -->
            <div class="space-y-1">
                <label for="tmt" class="block text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <i class="ti ti-calendar text-sm text-slate-400"></i>
                    <span>TMT (Terhitung Mulai Tanggal) <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-calendar text-base"></i>
                    </div>
                    <input type="text" 
                           id="tmt" 
                           name="tmt" 
                           value="{{ date('Y-m-d') }}"
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
                    <span>Status Ikatan Kerja <span class="text-rose-500 font-bold">*</span></span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="ti ti-user-star text-base"></i>
                    </div>
                    <select name="status_karyawan" 
                            id="status_karyawan" 
                            class="w-full appearance-none pl-9 pr-9 py-2 text-sm font-medium text-slate-800 bg-white border border-slate-300 rounded-lg shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition cursor-pointer">
                        <option value="">-- Pilih Status --</option>
                        <option value="T">Tetap</option>
                        <option value="K">Kontrak</option>
                        <option value="O">OJT (Magang)</option>
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
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA</option>
                        <option value="SMK">SMK</option>
                        <option value="D1">D1</option>
                        <option value="D2">D2</option>
                        <option value="D3">D3</option>
                        <option value="D4">D4</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
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
                            <option value="{{ $j->kode_jabatan }}">{{ $j->nama_jabatan }}</option>
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
                            <option value="{{ $u->kode_unit }}">{{ $u->nama_unit }}</option>
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
                            <option value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="ti ti-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Default Password Callout Hint -->
        <div class="p-3 bg-emerald-50/70 border border-emerald-200 rounded-xl flex items-start gap-2.5 text-xs text-emerald-900">
            <i class="ti ti-info-circle text-emerald-600 text-base shrink-0 mt-0.5"></i>
            <div class="leading-relaxed">
                <span>Setelah data disimpan, password awal akun login karyawan otomatis disetel ke <strong class="font-bold text-emerald-950">12345678</strong>. Karyawan dapat mengubah password setelah login.</span>
            </div>
        </div>
    </div>

    <!-- ================= MODAL ACTIONS FOOTER ================= -->
    <div class="pt-4 border-t border-slate-200/90 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnSubmitKaryawan" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-device-floppy text-base"></i>
            <span>Simpan Data Pegawai</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formcreateKaryawan");
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

        const form = $("#formcreateKaryawan");

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
            'tmt': { required: true, message: 'TMT mulai bertugas wajib diisi' }
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
            const submitBtn = form.find('#btnSubmitKaryawan');
            submitBtn.prop('disabled', true).html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>');
        });
    });
</script>
