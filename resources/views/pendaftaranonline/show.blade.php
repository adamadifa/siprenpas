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
                <i class="ti ti-world text-sm"></i>
                <span>LEMBAR FORMULIR PENDAFTARAN ONLINE</span>
            </span>
            <span class="text-xs text-slate-500 font-medium">Tahun Ajaran {{ $pendaftaran->tahun_ajaran }}</span>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('pendaftaranonline.cetak', Crypt::encrypt($pendaftaran->no_register)) }}"
               target="_blank"
               class="px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold shadow-2xs transition inline-flex items-center gap-1.5 cursor-pointer active:scale-95">
                <i class="ti ti-printer text-base"></i>
                <span>Cetak PDF</span>
            </a>
            @if(!empty($pendaftaran->no_pendaftaran))
                <a href="{{ route('pendaftaran.cetak-id-card', Crypt::encrypt($pendaftaran->no_pendaftaran)) }}"
                   target="_blank"
                   class="px-3.5 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-bold shadow-2xs transition inline-flex items-center gap-1.5 cursor-pointer active:scale-95">
                    <i class="ti ti-id-badge text-base"></i>
                    <span>Cetak ID Card</span>
                </a>
            @endif
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
                PENDAFTARAN ONLINE • TINGKAT {{ strtoupper($pendaftaran->nama_unit) }} • TAHUN AJARAN {{ $pendaftaran->tahun_ajaran }}
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
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Nomor Register</span>
                    <strong class="text-sm font-bold text-slate-900">{{ $pendaftaran->no_register }}</strong>
                </div>
                <div class="p-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Tanggal Registrasi</span>
                    <strong class="text-xs sm:text-sm font-semibold text-slate-800">{{ DateToIndo($pendaftaran->tanggal_register) }}</strong>
                </div>
                <div class="p-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Jenjang Unit</span>
                    <strong class="text-xs sm:text-sm font-bold text-emerald-800">{{ $pendaftaran->nama_unit }}</strong>
                </div>
                <div class="p-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Status Verifikasi</span>
                    <strong class="text-xs sm:text-sm font-semibold text-slate-800">
                        @if (!empty($pendaftaran->no_pendaftaran))
                            <span class="text-emerald-700 font-bold flex items-center gap-1">
                                <i class="ti ti-circle-check"></i>
                                <span>No. Daftar: {{ $pendaftaran->no_pendaftaran }}</span>
                            </span>
                        @else
                            @if (!empty($pendaftaran->id_bayar) || $pendaftaran->status_bayar == 'approved' || $pendaftaran->status_bayar == '1')
                                <span class="text-amber-700 font-bold flex items-center gap-1">
                                    <i class="ti ti-clock"></i>
                                    <span>Menunggu Verifikasi</span>
                                </span>
                            @else
                                <span class="text-rose-600 font-bold flex items-center gap-1">
                                    <i class="ti ti-alert-circle"></i>
                                    <span>Belum Konfirmasi</span>
                                </span>
                            @endif
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
                <span class="text-[10px] font-semibold text-slate-500 uppercase">Biodata Calon Santri</span>
            </div>

            <div class="flex flex-col md:flex-row gap-5 items-start">
                <!-- Data Table Biodata -->
                <div class="flex-1 w-full border border-slate-200 rounded-lg overflow-hidden">
                    <table class="w-full text-xs border-collapse">
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-3 text-slate-400 font-bold w-7 text-center">1.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium w-40 sm:w-48">Nomor Register</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold w-3 text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-bold">{{ $pendaftaran->no_register }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">2.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">NISN (Nomor Induk Siswa Nasional)</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->nisn ?: '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">3.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">Nama Lengkap</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-bold text-sm">{{ ucwords(strtolower($pendaftaran->nama_lengkap)) }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">4.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">Jenis Kelamin</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-semibold">
                                    <span class="inline-flex items-center gap-1.5">
                                        <i class="ti {{ $pendaftaran->jenis_kelamin == 'L' ? 'ti-gender-male text-blue-600' : 'ti-gender-female text-rose-500' }} text-sm"></i>
                                        <span>{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">5.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">Tempat & Tanggal Lahir</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-semibold">
                                    {{ !empty($pendaftaran->tempat_lahir) ? textCamelCase($pendaftaran->tempat_lahir) : '-' }}, 
                                    {{ !empty($pendaftaran->tanggal_lahir) ? DateToIndo($pendaftaran->tanggal_lahir) : '-' }}
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">6.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">Urutan Anak</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->anak_ke ? 'Anak ke-' . $pendaftaran->anak_ke : '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">7.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">Jumlah Saudara</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->jumlah_saudara ? $pendaftaran->jumlah_saudara . ' Bersaudara' : '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">8.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">No. HP / WhatsApp</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->no_hp ?: '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-2.5 px-3 text-slate-400 font-bold text-center">9.</td>
                                <td class="py-2.5 px-2 text-slate-600 font-medium">Email</td>
                                <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->email ?: '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pas Foto Calon Santri (3x4) -->
                <div class="w-full md:w-36 shrink-0 flex flex-col items-center">
                    <div class="w-28 h-36 border-2 border-slate-300 rounded-lg overflow-hidden bg-slate-50 shadow-xs flex items-center justify-center relative">
                        @php
                            $fotoSantri = $pendaftaran->foto ?? $pendaftaran->foto_pendaftaran ?? null;
                        @endphp
                        @if ($fotoSantri && Storage::disk('public')->exists('photos/pendaftaran/' . $fotoSantri))
                            <img src="{{ asset('storage/photos/pendaftaran/' . $fotoSantri) }}"
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
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->asal_sekolah ?: '-' }}</td>
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
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ textCamelCase($pendaftaran->kabupaten ?: '-') }}</td>
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

        <!-- ================= D. INFORMASI ORANG TUA / WALI ================= -->
        <div class="space-y-3">
            <div class="bg-slate-100 border-l-4 border-emerald-700 px-3.5 py-1.5 rounded-r flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                    D. Informasi Orang Tua / Wali
                </h3>
                <span class="text-[10px] font-semibold text-slate-500 uppercase">Data Keluarga</span>
            </div>

            <div class="border border-slate-200 rounded-lg overflow-hidden">
                <table class="w-full text-xs border-collapse">
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                            <td class="py-2.5 px-3 text-slate-400 font-bold w-7 text-center">1.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium w-40 sm:w-48">Nomor Kartu Keluarga (KK)</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold w-3 text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->no_kk ?: '-' }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">2.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">NIK Ayah Kandung</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->nik_ayah ?: '-' }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">3.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">Nama Lengkap Ayah</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-bold">{{ textCamelCase($pendaftaran->nama_ayah ?: '-') }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">4.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">Pendidikan Terakhir Ayah</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->pendidikan_ayah ?: '-' }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">5.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">Pekerjaan Ayah</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ textCamelCase($pendaftaran->pekerjaan_ayah ?: '-') }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">6.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">NIK Ibu Kandung</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->nik_ibu ?: '-' }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">7.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">Nama Lengkap Ibu</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-bold">{{ textCamelCase($pendaftaran->nama_ibu ?: '-') }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">8.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">Pendidikan Terakhir Ibu</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->pendidikan_ibu ?: '-' }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">9.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">Pekerjaan Ibu</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ textCamelCase($pendaftaran->pekerjaan_ibu ?: '-') }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-2.5 px-3 text-slate-400 font-bold text-center">10.</td>
                            <td class="py-2.5 px-2 text-slate-600 font-medium">No. Telepon / WhatsApp Orang Tua</td>
                            <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $pendaftaran->no_hp ?: '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= E. INFORMASI PEMBAYARAN ONLINE ================= -->
        <div class="space-y-3">
            <div class="bg-slate-100 border-l-4 border-emerald-700 px-3.5 py-1.5 rounded-r flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                    E. Informasi Pembayaran Pendaftaran
                </h3>
                <span class="text-[10px] font-semibold text-slate-500 uppercase">Status & Bukti Transfer</span>
            </div>

            @if (!$pembayaran)
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-center gap-3 text-xs text-amber-800">
                    <i class="ti ti-alert-triangle text-amber-600 text-xl shrink-0"></i>
                    <div>
                        <strong class="font-bold">Belum Melakukan Konfirmasi Pembayaran</strong>
                        <p class="text-amber-700 mt-0.5">Calon santri belum mengunggah bukti pembayaran atau belum melakukan konfirmasi transfer.</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Tabel Rincian Pembayaran -->
                    <div class="md:col-span-2 border border-slate-200 rounded-lg overflow-hidden">
                        <table class="w-full text-xs border-collapse">
                            <tbody class="divide-y divide-slate-100">
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="py-2.5 px-3 text-slate-400 font-bold w-7 text-center">1.</td>
                                    <td class="py-2.5 px-2 text-slate-600 font-medium w-40 sm:w-48">Tanggal Pembayaran</td>
                                    <td class="py-2.5 px-1 text-slate-400 font-bold w-3 text-center">:</td>
                                    <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ !empty($pembayaran->tanggal_pembayaran) ? DateToIndo($pembayaran->tanggal_pembayaran) : '-' }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                    <td class="py-2.5 px-3 text-slate-400 font-bold text-center">2.</td>
                                    <td class="py-2.5 px-2 text-slate-600 font-medium">Jumlah Pembayaran</td>
                                    <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                    <td class="py-2.5 px-3 text-emerald-700 font-bold text-sm">Rp {{ formatRupiah($pembayaran->jumlah_pembayaran) }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="py-2.5 px-3 text-slate-400 font-bold text-center">3.</td>
                                    <td class="py-2.5 px-2 text-slate-600 font-medium">Metode Pembayaran</td>
                                    <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                    <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ ucfirst($pembayaran->metode_pembayaran ?? 'Transfer Bank') }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/60 transition bg-slate-50/30">
                                    <td class="py-2.5 px-3 text-slate-400 font-bold text-center">4.</td>
                                    <td class="py-2.5 px-2 text-slate-600 font-medium">Status Pembayaran</td>
                                    <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                    <td class="py-2.5 px-3 font-bold">
                                        @if (!empty($pendaftaran->no_pendaftaran))
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1">
                                                <i class="ti ti-checks"></i> Sudah Terverifikasi
                                            </span>
                                        @elseif($pembayaran->status == 'approved' || $pembayaran->status == '1')
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1">
                                                <i class="ti ti-check"></i> Disetujui
                                            </span>
                                        @elseif($pembayaran->status == 'rejected' || $pembayaran->status == '2')
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 inline-flex items-center gap-1">
                                                <i class="ti ti-x"></i> Ditolak
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 inline-flex items-center gap-1">
                                                <i class="ti ti-clock"></i> Menunggu Konfirmasi (Pending)
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="py-2.5 px-3 text-slate-400 font-bold text-center">5.</td>
                                    <td class="py-2.5 px-2 text-slate-600 font-medium">Keterangan Transfer</td>
                                    <td class="py-2.5 px-1 text-slate-400 font-bold text-center">:</td>
                                    <td class="py-2.5 px-3 text-slate-700 font-medium leading-relaxed">{{ $pembayaran->keterangan ?: '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Bukti Transfer Preview Frame -->
                    <div class="border border-slate-200 rounded-lg p-3 bg-slate-50/60 flex flex-col items-center justify-center text-center">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Bukti Pembayaran</span>
                        @if ($pembayaran->bukti_pembayaran)
                            @php
                                $buktiUrl = config('app.web_url') ? config('app.web_url') . '/storage/' . $pembayaran->bukti_pembayaran : asset('storage/' . $pembayaran->bukti_pembayaran);
                            @endphp
                            <a href="{{ $buktiUrl }}" target="_blank" class="block group relative overflow-hidden rounded-lg border border-slate-200 shadow-2xs hover:shadow-md transition">
                                <img src="{{ $buktiUrl }}" alt="Bukti Transfer" class="w-36 h-44 object-cover group-hover:scale-105 transition duration-200">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-bold gap-1">
                                    <i class="ti ti-zoom-in text-base"></i>
                                    <span>Lihat Foto</span>
                                </div>
                            </a>
                            <a href="{{ $buktiUrl }}" target="_blank" class="mt-2 text-[11px] font-bold text-emerald-700 hover:text-emerald-800 inline-flex items-center gap-1">
                                <i class="ti ti-external-link"></i>
                                <span>Buka Ukuran Penuh</span>
                            </a>
                        @else
                            <div class="w-36 h-44 border-2 border-dashed border-slate-300 rounded-lg flex flex-col items-center justify-center text-slate-400 text-xs p-3">
                                <i class="ti ti-file-off text-2xl text-slate-300 mb-1"></i>
                                <span>Tidak ada lampiran bukti</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- ================= VERIFIKASI & KONFIRMASI PEMBAYARAN ADMIN ================= -->
        @if (!empty($pendaftaran->id_bayar))
            <div class="pt-4 border-t border-slate-200">
                @if (empty($pendaftaran->no_pendaftaran))
                    <!-- Belum Terverifikasi ke Pendaftaran Utama -->
                    <div class="bg-emerald-50/60 border border-emerald-200/80 rounded-xl p-4 sm:p-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="text-sm font-bold text-emerald-950 flex items-center gap-2">
                                    <i class="ti ti-shield-check text-emerald-600 text-lg"></i>
                                    <span>Verifikasi Pendaftaran Santri</span>
                                </h4>
                                <p class="text-xs text-emerald-800 mt-1 leading-relaxed">
                                    Jika pembayaran valid, klik <strong>Terima & Verifikasi</strong> untuk menerbitkan Nomor Pendaftaran resmi, NIS, ID Siswa, serta menyinkronkan data santri ke database utama.
                                </p>
                            </div>

                            <form action="{{ route('pendaftaranonline.konfirmasi', Crypt::encrypt($pendaftaran->no_register)) }}"
                                  method="POST"
                                  id="formKonfirmasiPembayaran"
                                  class="flex items-center gap-2.5 shrink-0">
                                @csrf
                                <button type="button"
                                        onclick="confirmReject()"
                                        class="px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-xs font-bold transition active:scale-95 cursor-pointer inline-flex items-center gap-1.5">
                                    <i class="ti ti-x text-base"></i>
                                    <span>Tolak</span>
                                </button>
                                <button type="button"
                                        onclick="confirmAccept()"
                                        class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-xs transition active:scale-95 cursor-pointer inline-flex items-center gap-1.5">
                                    <i class="ti ti-check text-base"></i>
                                    <span>Terima & Verifikasi</span>
                                </button>
                                <input type="hidden" name="status" id="konfirmasiStatus" value="1">
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Sudah Terverifikasi ke Pendaftaran Utama -->
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 sm:p-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                    <h4 class="text-sm font-bold text-slate-900">Santri Telah Terverifikasi</h4>
                                </div>
                                <p class="text-xs text-slate-500 mt-1">
                                    Pendaftaran online telah terdaftar di database utama dengan Nomor Pendaftaran: <strong class="text-slate-800 font-bold">{{ $pendaftaran->no_pendaftaran }}</strong>.
                                </p>
                            </div>

                            <form action="{{ route('pendaftaranonline.cancel', Crypt::encrypt($pendaftaran->no_register)) }}"
                                  method="POST"
                                  id="formCancelVerifikasi"
                                  class="shrink-0">
                                @csrf
                                <button type="button"
                                        onclick="confirmCancelVerification()"
                                        class="px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-xs font-bold transition active:scale-95 cursor-pointer inline-flex items-center gap-1.5">
                                    <i class="ti ti-arrow-back-up text-base"></i>
                                    <span>Batalkan Verifikasi</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        @endif

    </div>

</div>

<script>
    function confirmAccept() {
        Swal.fire({
            title: 'Verifikasi Calon Santri?',
            html: `
                <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                    <p>Sistem akan memverifikasi pendaftaran online untuk:</p>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                        {{ $pendaftaran->nama_lengkap }} ({{ $pendaftaran->no_register }})
                    </div>
                    <p class="text-[11px] text-emerald-700 font-semibold">Nomor Pendaftaran, ID Siswa, NIS, dan Biaya Pendaftaran akan diterbitkan secara otomatis.</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="ti ti-check mr-1"></i> Ya, Terima & Verifikasi',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-2xl shadow-2xl p-5',
                title: 'text-base font-bold text-slate-900',
                confirmButton: 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer',
                cancelButton: 'px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $('#konfirmasiStatus').val('1');
                Swal.fire({
                    title: 'Memproses Verifikasi...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                $('#formKonfirmasiPembayaran').submit();
            }
        });
    }

    function confirmReject() {
        Swal.fire({
            title: 'Tolak Pembayaran?',
            html: `
                <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                    <p>Apakah Anda yakin ingin menolak konfirmasi pembayaran untuk calon santri ini?</p>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                        {{ $pendaftaran->nama_lengkap }}
                    </div>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="ti ti-x mr-1"></i> Ya, Tolak Pembayaran',
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
                $('#konfirmasiStatus').val('2');
                Swal.fire({
                    title: 'Menolak Pembayaran...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                $('#formKonfirmasiPembayaran').submit();
            }
        });
    }

    function confirmCancelVerification() {
        Swal.fire({
            title: 'Batalkan Verifikasi?',
            html: `
                <div class="text-xs sm:text-sm text-slate-600 mt-2 space-y-2 text-center">
                    <p>Apakah Anda yakin ingin membatalkan status verifikasi santri ini?</p>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-900">
                        {{ $pendaftaran->nama_lengkap }} ({{ $pendaftaran->no_pendaftaran }})
                    </div>
                    <p class="text-[11px] text-rose-500 font-semibold">Data pendaftaran offline dan akun santri di database utama akan dihapus.</p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="ti ti-arrow-back-up mr-1"></i> Ya, Batalkan Verifikasi',
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
                Swal.fire({
                    title: 'Membatalkan Verifikasi...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                $('#formCancelVerifikasi').submit();
            }
        });
    }
</script>
