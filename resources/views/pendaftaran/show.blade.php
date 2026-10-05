@php
    $namaSekolah = optional($pengaturan)->nama_sekolah ?? 'PESANTREN PERSATUAN ISLAM 80 AL AMIN SINDANGKASIH';
    $alamatSekolah = optional($pengaturan)->alamat_sekolah ?? 'Jln. Raya Ancol No. 27 Ancol I Sindangkasih';
    $teleponSekolah = optional($pengaturan)->telepon ?? '(0265) 325285';
    $emailSekolah = optional($pengaturan)->email ?? 'peris.alamin80sinkas@gmail.com';
    $websiteSekolah = optional($pengaturan)->website ?? 'persisalamin.com';
@endphp

<div class="space-y-6">

    <!-- ================= ACTION TOOLBAR ================= -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-3.5 bg-slate-50 border border-slate-200/90 rounded-xl">
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                <i class="ti ti-certificate text-sm"></i>
                <span>LEMBAR DOKUMEN RESMI</span>
            </span>
            <span class="text-xs text-slate-500 font-medium">Tahun Ajaran {{ $pendaftaran->tahun_ajaran }}</span>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('pendaftaran.cetakpdf', Crypt::encrypt($pendaftaran->no_pendaftaran)) }}"
               target="_blank"
               class="px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold shadow-2xs transition inline-flex items-center gap-1.5 cursor-pointer active:scale-95">
                <i class="ti ti-printer text-base"></i>
                <span>Cetak PDF</span>
            </a>
            <a href="{{ route('pendaftaran.cetak-id-card', Crypt::encrypt($pendaftaran->no_pendaftaran)) }}"
               target="_blank"
               class="px-3.5 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-bold shadow-2xs transition inline-flex items-center gap-1.5 cursor-pointer active:scale-95">
                <i class="ti ti-id-badge text-base"></i>
                <span>Cetak ID Card</span>
            </a>
        </div>
    </div>

    <!-- ================= DIGITAL DOCUMENT SHEET ================= -->
    <div class="bg-white border border-slate-300/80 rounded-xl shadow-xs p-5 sm:p-7 space-y-6">

        <!-- KOP DOKUMEN RESMI -->
        <div class="text-center pb-4 border-b-2 border-slate-800 relative">
            <div class="inline-block px-3 py-0.5 rounded text-[11px] font-extrabold uppercase tracking-widest bg-slate-100 text-slate-700 border border-slate-200 mb-1.5">
                Panitia Penerimaan Santri Baru (PSB)
            </div>
            <h2 class="text-base sm:text-xl font-black text-slate-900 uppercase tracking-tight leading-tight">
                {{ $namaSekolah }}
            </h2>
            <p class="text-xs sm:text-sm font-bold text-emerald-800 mt-0.5">
                TINGKAT {{ strtoupper($pendaftaran->nama_unit) }} • TAHUN AJARAN {{ $pendaftaran->tahun_ajaran }}
            </p>
            <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                {{ $alamatSekolah }}
                @if($teleponSekolah) • Telp: {{ $teleponSekolah }} @endif
                @if($emailSekolah) • Email: {{ $emailSekolah }} @endif
                @if($websiteSekolah) • Web: {{ $websiteSekolah }} @endif
            </p>
        </div>

        <!-- REGISTRATION META SUMMARY TABLE -->
        <div class="border border-slate-200 rounded-lg overflow-hidden bg-slate-50/60">
            <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-slate-200 text-xs">
                <div class="p-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Nomor Pendaftaran</span>
                    <strong class="text-sm font-bold text-slate-900">{{ $pendaftaran->no_pendaftaran }}</strong>
                </div>
                <div class="p-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Tanggal Registrasi</span>
                    <strong class="text-xs sm:text-sm font-semibold text-slate-800">{{ DateToIndo($pendaftaran->tanggal_pendaftaran) }}</strong>
                </div>
                <div class="p-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Jenjang Unit</span>
                    <strong class="text-xs sm:text-sm font-bold text-emerald-800">{{ $pendaftaran->nama_unit }}</strong>
                </div>
                <div class="p-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Plot Kelas / RFID</span>
                    <strong class="text-xs sm:text-sm font-semibold text-slate-800">
                        {{ $pendaftaran->nama_kelas ?: 'Belum Diplot' }}
                        @if($pendaftaran->rfid_code)
                            <span class="text-[11px] text-slate-500 block font-normal">(RFID: {{ $pendaftaran->rfid_code }})</span>
                        @endif
                    </strong>
                </div>
            </div>
        </div>

        <!-- ================= A. DATA PRIBADI CALON SANTRI ================= -->
        <div class="space-y-3">
            <div class="bg-slate-100 border-l-4 border-emerald-700 px-3.5 py-1.5 rounded-r flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                    A. Data Pribadi Calon Santri
                </h3>
                <span class="text-[10px] font-semibold text-slate-500 uppercase">Biodata Resmi</span>
            </div>

            <div class="flex flex-col md:flex-row gap-5 items-start">
                <!-- Data Table Biodata -->
                <div class="flex-1 w-full border border-slate-200 rounded-lg overflow-hidden">
                    <table class="w-full text-xs border-collapse">
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-3 text-slate-400 font-bold w-7 text-center">1.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium w-40 sm:w-48">Nomor Pendaftaran</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold w-3 text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-bold">{{ $pendaftaran->no_pendaftaran }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">2.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">NISN (Nomor Induk Siswa Nasional)</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->nisn ?: '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">3.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">NIS (Nomor Induk Santri)</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->nis ?: '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">4.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">Nama Lengkap</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-bold text-sm">{{ ucwords(strtolower($pendaftaran->nama_lengkap)) }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">5.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">Jenis Kelamin</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-semibold">
                                    <span class="inline-flex items-center gap-1.5">
                                        <i class="ti {{ $pendaftaran->jenis_kelamin == 'L' ? 'ti-gender-male text-blue-600' : 'ti-gender-female text-rose-500' }} text-sm"></i>
                                        <span>{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">6.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">Tempat & Tanggal Lahir</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-semibold">
                                    {{ textCamelCase($pendaftaran->tempat_lahir) }}, {{ DateToIndo($pendaftaran->tanggal_lahir) }}
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">7.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">Urutan Anak</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-semibold">Anak ke-{{ $pendaftaran->anak_ke ?: '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">8.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">Jumlah Saudara</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->jumlah_saudara ? $pendaftaran->jumlah_saudara . ' Bersaudara' : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pas Foto Santri Formal (3x4) -->
                <div class="w-full md:w-36 shrink-0 flex flex-col items-center">
                    <div class="w-28 h-36 border-2 border-slate-300 rounded-lg overflow-hidden bg-slate-50 shadow-xs flex items-center justify-center relative">
                        @if ($pendaftaran->foto_pendaftaran && Storage::disk('public')->exists('photos/pendaftaran/' . $pendaftaran->foto_pendaftaran))
                            <img src="{{ asset('storage/photos/pendaftaran/' . $pendaftaran->foto_pendaftaran) }}"
                                 alt="{{ $pendaftaran->nama_lengkap }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="text-center p-2 text-slate-400">
                                <i class="ti ti-user text-3xl text-slate-300 block mb-1"></i>
                                <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400 block leading-tight">Pas Foto 3x4</span>
                            </div>
                        @endif
                    </div>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-1.5">Pas Foto Santri</span>
                </div>
            </div>
        </div>

        <!-- ================= B. ASAL SEKOLAH ================= -->
        <div class="space-y-3">
            <div class="bg-slate-100 border-l-4 border-emerald-700 px-3.5 py-1.5 rounded-r flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                    B. Asal Sekolah
                </h3>
                <span class="text-[10px] font-semibold text-slate-500 uppercase">Riwayat Pendidikan</span>
            </div>

            <div class="border border-slate-200 rounded-lg overflow-hidden">
                <table class="w-full text-xs border-collapse">
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-2.5 px-3 text-slate-400 font-bold w-7 text-center">1.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium w-40 sm:w-48">Nama Asal Sekolah / Madrasah</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold w-3 text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->nama_asal_sekolah ?: '-' }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">2.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">Kabupaten / Kota Asal Sekolah</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->kota_asal_sekolah ?: '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= C. ALAMAT DAN TEMPAT TINGGAL ================= -->
        <div class="space-y-3">
            <div class="bg-slate-100 border-l-4 border-emerald-700 px-3.5 py-1.5 rounded-r flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                    C. Alamat dan Domisili
                </h3>
                <span class="text-[10px] font-semibold text-slate-500 uppercase">Tempat Tinggal</span>
            </div>

            <div class="border border-slate-200 rounded-lg overflow-hidden">
                <table class="w-full text-xs border-collapse">
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-2.5 px-3 text-slate-400 font-bold w-7 text-center align-top">1.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium w-40 sm:w-48 align-top">Alamat Lengkap / Kp. / Jalan</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold w-3 text-center align-top">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold align-top leading-relaxed">{{ textCamelCase($pendaftaran->alamat ?: '-') }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">2.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">Desa / Kelurahan</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ textCamelCase($pendaftaran->desa ?: '-') }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">3.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">Kecamatan</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ textCamelCase($pendaftaran->kecamatan ?: '-') }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">4.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">Kabupaten / Kota</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ textCamelCase($pendaftaran->kota ?: '-') }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">5.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">Provinsi</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ textCamelCase($pendaftaran->provinsi ?: '-') }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">6.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">Kode Pos</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->kode_pos ?: '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= D. DATA ORANG TUA / WALI ================= -->
        <div class="space-y-3">
            <div class="bg-slate-100 border-l-4 border-emerald-700 px-3.5 py-1.5 rounded-r flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                    D. Data Orang Tua / Wali
                </h3>
                <span class="text-[10px] font-semibold text-slate-500 uppercase">Keluarga Santri</span>
            </div>

            <!-- Ringkasan KK & Kontak -->
            <div class="border border-slate-200 rounded-lg overflow-hidden bg-slate-50/50">
                <table class="w-full text-xs border-collapse">
                    <tbody class="divide-y divide-slate-200">
                        <tr class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-slate-200">
                            <td class="py-2.5 px-3">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">No. Kartu Keluarga (KK)</span>
                                <strong class="text-xs font-bold text-slate-900">{{ $pendaftaran->no_kk ?: '-' }}</strong>
                            </td>
                            <td class="py-2.5 px-3">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">No. WhatsApp / HP Orang Tua</span>
                                <strong class="text-xs font-bold text-emerald-800">{{ $pendaftaran->no_hp_orang_tua ?: '-' }}</strong>
                            </td>
                            <td class="py-2.5 px-3">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Penghasilan Orang Tua</span>
                                <strong class="text-xs font-bold text-slate-900">{{ $pendaftaran->penghasilan_ortu ?: '-' }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tabel Data Ayah & Ibu Berdampingan -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Tabel Data Ayah -->
                <div class="border border-slate-200 rounded-lg overflow-hidden">
                    <div class="bg-slate-50 px-3 py-2 border-b border-slate-200 flex items-center gap-1.5 font-bold text-slate-800 text-xs">
                        <i class="ti ti-user-check text-emerald-700 text-sm"></i>
                        <span>Data Ayah Kandung</span>
                    </div>
                    <table class="w-full text-xs border-collapse">
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2 px-3 text-slate-600 font-medium w-32">NIK Ayah</td>
                                <td class="py-2 px-1 text-slate-400 font-bold w-3 text-center">:</td>
                                <td class="py-2 px-3 text-slate-900 font-semibold">{{ $pendaftaran->nik_ayah ?: '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                <td class="py-2 px-3 text-slate-600 font-medium">Nama Lengkap</td>
                                <td class="py-2 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2 px-3 text-slate-900 font-bold">{{ textCamelCase($pendaftaran->nama_ayah ?: '-') }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2 px-3 text-slate-600 font-medium">Pendidikan Terakhir</td>
                                <td class="py-2 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2 px-3 text-slate-900 font-semibold">{{ textCamelCase($pendaftaran->pendidikan_ayah ?: '-') }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                <td class="py-2 px-3 text-slate-600 font-medium">Pekerjaan</td>
                                <td class="py-2 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2 px-3 text-slate-900 font-semibold">{{ textCamelCase($pendaftaran->pekerjaan_ayah ?: '-') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tabel Data Ibu -->
                <div class="border border-slate-200 rounded-lg overflow-hidden">
                    <div class="bg-slate-50 px-3 py-2 border-b border-slate-200 flex items-center gap-1.5 font-bold text-slate-800 text-xs">
                        <i class="ti ti-user-heart text-rose-600 text-sm"></i>
                        <span>Data Ibu Kandung</span>
                    </div>
                    <table class="w-full text-xs border-collapse">
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2 px-3 text-slate-600 font-medium w-32">NIK Ibu</td>
                                <td class="py-2 px-1 text-slate-400 font-bold w-3 text-center">:</td>
                                <td class="py-2 px-3 text-slate-900 font-semibold">{{ $pendaftaran->nik_ibu ?: '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                <td class="py-2 px-3 text-slate-600 font-medium">Nama Lengkap</td>
                                <td class="py-2 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2 px-3 text-slate-900 font-bold">{{ textCamelCase($pendaftaran->nama_ibu ?: '-') }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2 px-3 text-slate-600 font-medium">Pendidikan Terakhir</td>
                                <td class="py-2 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2 px-3 text-slate-900 font-semibold">{{ textCamelCase($pendaftaran->pendidikan_ibu ?: '-') }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                <td class="py-2 px-3 text-slate-600 font-medium">Pekerjaan</td>
                                <td class="py-2 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2 px-3 text-slate-900 font-semibold">{{ textCamelCase($pendaftaran->pekerjaan_ibu ?: '-') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ================= E. BERKAS PERSYARATAN & LAMPIRAN ================= -->
        <div class="space-y-3">
            <div class="bg-slate-100 border-l-4 border-emerald-700 px-3.5 py-1.5 rounded-r flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                    E. Berkas Persyaratan & Lampiran
                </h3>
                <span class="text-[10px] font-semibold text-slate-500 uppercase">Dokumen Unggahan</span>
            </div>

            <!-- Form Upload Berkas -->
            <form action="#" id="uploadDokumen" enctype="multipart/form-data" method="POST" class="bg-slate-50/80 border border-slate-200 rounded-lg p-3">
                @csrf
                <input type="hidden" name="no_pendaftaran" value="{{ $pendaftaran->no_pendaftaran }}">

                <div class="grid grid-cols-1 sm:grid-cols-12 gap-2.5 items-center">
                    <div class="sm:col-span-5">
                        <select name="kode_dokumen" id="kode_dokumen" class="w-full text-xs font-medium text-slate-800 bg-white border border-slate-300 rounded-lg px-3 py-2 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-700 cursor-pointer">
                            <option value="">-- Pilih Jenis Dokumen --</option>
                            @foreach ($jenisdokumenpendaftaran as $d)
                                <option value="{{ $d->kode_dokumen }}">{{ $d->jenis_dokumen }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-5">
                        <input type="file" name="file" id="file" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                    </div>

                    <div class="sm:col-span-2">
                        <button type="submit" id="btnUploadDok" class="w-full py-2 px-3 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-bold shadow-2xs transition flex items-center justify-center gap-1 cursor-pointer active:scale-95">
                            <i class="ti ti-upload text-sm"></i>
                            <span>Upload</span>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Tabel Daftar Berkas Persyaratan -->
            <div class="border border-slate-200 rounded-lg overflow-hidden">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-2.5 px-3.5">Jenis Dokumen Persyaratan</th>
                            <th class="py-2.5 px-3.5">Status & File Berkas</th>
                            <th class="py-2.5 px-3.5 text-center w-20">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="loaddokumen" class="divide-y divide-slate-100 bg-white">
                        <!-- Dokumen di-load via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ================= MODAL FOOTER ================= -->
    <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
        <div class="text-xs text-slate-400 font-medium">
            Dokumen Formulir Digital Sistem Informasi Pesantren (SIPREN)
        </div>
        <button type="button" data-bs-dismiss="modal" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs sm:text-sm rounded-xl transition cursor-pointer active:scale-95">
            Tutup
        </button>
    </div>

</div>

<script>
    $(function() {
        function loadDokumen() {
            const no_pendaftaran = '{{ Crypt::encrypt($pendaftaran->no_pendaftaran) }}';
            $("#loaddokumen").html(`
                <tr>
                    <td colspan="3" class="py-6 text-center text-slate-400 text-xs">
                        <div class="w-5 h-5 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-1"></div>
                        Memuat berkas...
                    </td>
                </tr>
            `);
            $("#loaddokumen").load(`/pendaftaran/${no_pendaftaran}/getdokumen`);
        }

        loadDokumen();

        $('#uploadDokumen').on('submit', function(event) {
            event.preventDefault();
            const kodeDok = $("#kode_dokumen").val();
            const file = $("#file").val();

            if (!kodeDok) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih Jenis Dokumen terlebih dahulu!'
                });
                return false;
            }

            if (!file) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih file berkas yang akan diupload!'
                });
                return false;
            }

            let formData = new FormData(this);
            $("#btnUploadDok").prop('disabled', true).html('<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>');

            $.ajax({
                url: "{{ url('/pendaftaran/uploaddokumen') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#btnUploadDok").prop('disabled', false).html('<i class="ti ti-upload text-sm"></i> <span>Upload</span>');
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Dokumen persyaratan berhasil diupload",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false,
                        didClose: () => {
                            $('#uploadDokumen')[0].reset();
                            loadDokumen();
                        },
                    });
                },
                error: function(xhr) {
                    $("#btnUploadDok").prop('disabled', false).html('<i class="ti ti-upload text-sm"></i> <span>Upload</span>');
                    let errMsg = xhr.responseJSON?.message || "Gagal mengupload dokumen.";
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        errMsg = Object.values(xhr.responseJSON.errors).flat().join("<br>");
                    }
                    Swal.fire({
                        title: "Gagal!",
                        html: errMsg,
                        icon: "error",
                        showConfirmButton: true,
                    });
                }
            });
        });

        $('body').on('click', '.deletedokumen', function(e) {
            e.preventDefault();
            var no_pendaftaran = $(this).attr('no_pendaftaran');
            var kode_dokumen = $(this).attr('kode_dokumen');

            Swal.fire({
                title: 'Hapus Dokumen?',
                text: "Dokumen yang dihapus tidak dapat dipulihkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl',
                    confirmButton: 'rounded-xl px-4 py-2 text-xs font-bold',
                    cancelButton: 'rounded-xl px-4 py-2 text-xs font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "/pendaftaran/deletedokumen",
                        data: {
                            _token: "{{ csrf_token() }}",
                            no_pendaftaran: no_pendaftaran,
                            kode_dokumen: kode_dokumen
                        },
                        cache: false,
                        success: function(response) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Dokumen berhasil dihapus",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false,
                                didClose: () => {
                                    loadDokumen();
                                },
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error!",
                                text: xhr.responseJSON?.message || "Gagal menghapus dokumen",
                                icon: "error",
                                showConfirmButton: true,
                            });
                        }
                    });
                }
            });
        });
    });
</script>
