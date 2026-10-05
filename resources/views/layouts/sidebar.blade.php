@php
    $isGuru = false;
    $isWaliKelas = false;
    $isKoordinator = false;
    if (auth()->check()) {
        $user = auth()->user();
        $isGuru = $user->hasRole('guru') || \App\Models\Guru::where('npp', $user->npp)->exists();
        if ($isGuru) {
            $guruModel = \App\Models\Guru::where('npp', $user->npp)->first();
            if ($guruModel) {
                $activeTa = \App\Models\Tahunajaran::where('status', '1')->first();
                if ($activeTa) {
                    $isWaliKelas = \App\Models\Kelas::where('guru_id', $guruModel->id)
                        ->where('kode_ta', $activeTa->kode_ta)
                        ->exists();
                    $isKoordinator = \App\Models\Ekstrakurikuler::where('guru_id', $guruModel->id)
                        ->where('kode_ta', $activeTa->kode_ta)
                        ->exists();
                }
            }
        }
    }
@endphp

<!-- Sidebar Aside (Modern Emerald Green Sidebar with Fixed User Profile) -->
<aside id="main-sidebar"
       :class="{
           'translate-x-0 w-[260px]': mobileSidebarOpen,
           '-translate-x-full lg:translate-x-0': !mobileSidebarOpen,
           'lg:w-[260px]': sidebarOpen,
           'lg:w-0 lg:overflow-hidden': !sidebarOpen
       }" 
       class="fixed top-16 left-0 z-50 lg:z-30 h-[calc(100vh-4rem)] bg-emerald-900 border-r border-emerald-950/60 shadow-lg transition-all duration-300 ease-in-out flex flex-col justify-between overflow-hidden">
    
    <!-- Scrollable Menu Navigation Area -->
    <div id="sidebar-menu-scroll" class="flex-1 overflow-y-auto px-3 py-3 space-y-3.5 scrollbar-thin scrollbar-thumb-emerald-700/60 hover:scrollbar-thumb-emerald-600/80">

        <!-- ================= 1. MENU UTAMA ================= -->
        <div>
            <ul class="space-y-0.5">
                <!-- Dashboard -->
                <li>
                    @php
                        $isDashActive = request()->is(['dashboard', 'dashboard/*']) && !request()->is(['dashboard/guru']);
                    @endphp
                    <a href="{{ route('dashboard.index') }}" 
                       class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $isDashActive ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                        <i class="ti ti-layout-grid text-[17px] {{ $isDashActive ? 'text-white' : 'text-emerald-300' }}"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if ($isGuru)
                    <li>
                        @php
                            $isGuruDashActive = request()->is(['dashboard/guru']);
                        @endphp
                        <a href="{{ route('dashboard.guru') }}" 
                           class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $isGuruDashActive ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                            <i class="ti ti-presentation text-[17px] {{ $isGuruDashActive ? 'text-white' : 'text-emerald-300' }}"></i>
                            <span>Dashboard Guru</span>
                        </a>
                    </li>
                @endif
                @can('pendaftaran.index')
                    <li>
                        @php
                            $isPendaftaranActive = request()->is(['pendaftaran']);
                        @endphp
                        <a href="{{ route('pendaftaran.index') }}" 
                           class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $isPendaftaranActive ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                            <i class="ti ti-user-plus text-[17px] {{ $isPendaftaranActive ? 'text-white' : 'text-emerald-300' }}"></i>
                            <span>Pendaftaran</span>
                        </a>
                    </li>
                    <li>
                        @php
                            $isPendaftaranOnlineActive = request()->is(['pendaftaranonline']);
                        @endphp
                        <a href="{{ route('pendaftaranonline.index') }}" 
                           class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $isPendaftaranOnlineActive ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                            <i class="ti ti-device-laptop text-[17px] {{ $isPendaftaranOnlineActive ? 'text-white' : 'text-emerald-300' }}"></i>
                            <span>Pendaftaran Online</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>

        <!-- ================= 2. MASTER DATA ================= -->
        @if (auth()->check() && auth()->user()->hasAnyPermission([
            'karyawan.index', 'jabatan.index', 'unit.index', 'biaya.index', 
            'departemen.index', 'siswa.index', 'kategoriibadah.index', 'kegiatanibadah.index'
        ]))
            <div>
                <div class="px-3 pb-1 text-[10.5px] font-bold text-emerald-300/80 uppercase tracking-wider">Master Data</div>
                <ul class="space-y-0.5">
                    @can('karyawan.index')
                        @php $active = request()->is(['karyawan', 'karyawan/*']); @endphp
                        <li>
                            <a href="{{ route('karyawan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-id-badge text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Karyawan</span>
                            </a>
                        </li>
                    @endcan
                    @can('jabatan.index')
                        @php $active = request()->is(['jabatan', 'jabatan/*']); @endphp
                        <li>
                            <a href="{{ route('jabatan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-briefcase text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Jabatan</span>
                            </a>
                        </li>
                    @endcan
                    @can('siswa.index')
                        @php $active = request()->is(['siswa', 'siswa/*']); @endphp
                        <li>
                            <a href="{{ route('siswa.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-users-group text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Siswa</span>
                            </a>
                        </li>
                    @endcan
                    @can('unit.index')
                        @php $active = request()->is(['unit', 'unit/*']); @endphp
                        <li>
                            <a href="{{ route('unit.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-building-community text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Unit</span>
                            </a>
                        </li>
                    @endcan
                    @can('biaya.index')
                        @php $active = request()->is(['jenisbiaya', 'jenisbiaya/*']); @endphp
                        <li>
                            <a href="{{ route('jenisbiaya.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-receipt-2 text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Jenis Biaya</span>
                            </a>
                        </li>
                    @endcan
                    @can('departemen.index')
                        @php $active = request()->is(['departemen', 'departemen/*']); @endphp
                        <li>
                            <a href="{{ route('departemen.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-sitemap text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Departemen</span>
                            </a>
                        </li>
                    @endcan
                    @can('kategoriibadah.index')
                        @php $active = request()->is(['kategoriibadah', 'kategoriibadah/*']); @endphp
                        <li>
                            <a href="{{ route('kategoriibadah.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-tags text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Kategori Ibadah</span>
                            </a>
                        </li>
                    @endcan
                    @can('kegiatanibadah.index')
                        @php $active = request()->is(['kegiatanibadah', 'kegiatanibadah/*']); @endphp
                        <li>
                            <a href="{{ route('kegiatanibadah.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-sun-moon text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Kegiatan Ibadah</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        @endif

        <!-- ================= 3. AKADEMIK & PEMBELAJARAN ================= -->
        @if (auth()->check() && (auth()->user()->hasAnyPermission(['presensisiswa.index', 'guru.index', 'akademiksiswa.index', 'jabatanakademik.index', 'matapelajaran.index', 'kelas.index', 'jadwalpelajaran.index']) || $isWaliKelas || $isKoordinator || $isGuru))
            <div>
                <div class="px-3 pb-1 text-[10.5px] font-bold text-emerald-300/80 uppercase tracking-wider">Akademik & Siswa</div>
                <ul class="space-y-0.5">
                    @can('guru.index')
                        @php $active = request()->is(['guru', 'guru/*']); @endphp
                        <li>
                            <a href="{{ route('guru.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-users text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Data Guru</span>
                            </a>
                        </li>
                    @endcan
                    @can('akademiksiswa.index')
                        @php $active = request()->is(['akademik/siswa', 'akademik/siswa/*']); @endphp
                        <li>
                            <a href="{{ route('akademiksiswa.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-school text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Data Siswa Akademik</span>
                            </a>
                        </li>
                    @endcan
                    @can('jabatanakademik.index')
                        @php $active = request()->is(['jabatan-akademik', 'jabatan-akademik/*']); @endphp
                        <li>
                            <a href="{{ route('jabatan-akademik.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-award text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Jabatan Akademik</span>
                            </a>
                        </li>
                    @endcan
                    @if (auth()->check() && (auth()->user()->hasAnyPermission(['presensisiswa.index']) || $isGuru))
                        @php $active = request()->is(['presensisiswa', 'presensisiswa/*']); @endphp
                        <li>
                            <a href="{{ route('presensisiswa.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-activity-heartbeat text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Monitoring Presensi Siswa</span>
                            </a>
                        </li>
                    @endif
                    @can('matapelajaran.index')
                        @php $active = request()->is(['mata-pelajaran', 'mata-pelajaran/*']); @endphp
                        <li>
                            <a href="{{ route('mata-pelajaran.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-books text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Data Mata Pelajaran</span>
                            </a>
                        </li>
                    @endcan
                    @can('kelas.index')
                        @php $active = request()->is(['kelas', 'kelas/*']); @endphp
                        <li>
                            <a href="{{ route('kelas.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-chalkboard text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Kelas</span>
                            </a>
                        </li>
                    @endcan
                    @if (auth()->check() && (auth()->user()->can('jadwalpelajaran.index') || $isGuru))
                        @php $active = request()->is(['jadwal-pelajaran', 'jadwal-pelajaran/*']); @endphp
                        <li>
                            <a href="{{ route('jadwal-pelajaran.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-calendar-time text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Jadwal Pelajaran</span>
                            </a>
                        </li>
                    @endif
                    @if ($isWaliKelas)
                        @php $active = request()->is(['wali-kelas', 'wali-kelas/*']); @endphp
                        <li>
                            <a href="{{ route('wali-kelas.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-user-shield text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Wali Kelas</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->check() && (auth()->user()->can('jadwalpelajaran.index') || $isGuru))
                        @php $active = request()->is(['presensi-mapel', 'presensi-mapel/*']); @endphp
                        <li>
                            <a href="{{ route('presensi-mapel.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-clipboard-check text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Presensi Mata Pelajaran</span>
                            </a>
                        </li>
                        @php $active = request()->is(['rapor', 'rapor/*', 'penilaian', 'penilaian/*']); @endphp
                        <li>
                            <a href="{{ route('rapor.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-star text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Penilaian</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->check() && (auth()->user()->hasAnyRole(['super admin', 'admin']) || auth()->user()->can('jadwalpelajaran.index') || $isKoordinator || $isWaliKelas))
                        @php $active = request()->is(['rapor-siswa', 'rapor-siswa/*']); @endphp
                        <li>
                            <a href="{{ route('rapor-siswa.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-certificate text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>{{ $isKoordinator && !$isWaliKelas && !auth()->user()->hasAnyRole(['super admin', 'admin']) ? 'Ekstrakurikuler' : 'Rapor Siswa' }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        @endif

        <!-- ================= 4. KEUANGAN ================= -->
        @if (auth()->check() && (
            auth()->user()->hasAnyPermission(['pembayaranpdd.index', 'lk.index', 'lk.pembayaran', 'lk.rekaptagihan']) ||
            auth()->user()->hasRole('super admin')
        ))
            <div>
                <div class="px-3 pb-1 text-[10.5px] font-bold text-emerald-300/80 uppercase tracking-wider">Keuangan</div>
                <ul class="space-y-0.5">
                    @if (auth()->user()->can('pembayaranpdd.index') || auth()->user()->hasRole('super admin'))
                        @php $active = request()->is(['pembayaranpendidikan', 'pembayaranpendidikan/*']); @endphp
                        <li>
                            <a href="{{ route('pembayaranpendidikan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-wallet text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Pembayaran Pendidikan</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasAnyPermission(['pembayaranpdd.index', 'lk.index', 'lk.pembayaran', 'lk.rekaptagihan']) || auth()->user()->hasRole('super admin'))
                        @php $active = request()->is(['laporankeuangan', 'laporankeuangan/*', 'lk', 'lk/*']); @endphp
                        <li>
                            <a href="{{ route('lk.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-report-money text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Laporan Keuangan</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        @endif

        <!-- ================= 5. KOPERASI ================= -->
        @if (auth()->check() && (
            auth()->user()->hasAnyPermission([
                'anggota.index', 
                'jenissimpanan.index', 'simpanan.index', 
                'jenistabungan.index', 'tabungan.index', 
                'jenispembiayaan.index', 'pembiayaan.index', 
                'laporankoperasi.index'
            ]) ||
            auth()->user()->hasRole('super admin')
        ))
            <div>
                <div class="px-3 pb-1 text-[10.5px] font-bold text-emerald-300/80 uppercase tracking-wider">Koperasi</div>
                <ul class="space-y-0.5">
                    @can('anggota.index')
                        @php $active = request()->is(['anggota', 'anggota/*']); @endphp
                        <li>
                            <a href="{{ route('anggota.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-user-check text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Anggota Koperasi</span>
                            </a>
                        </li>
                    @endcan
                    @can('jenissimpanan.index')
                        @php $active = request()->is(['jenissimpanan', 'jenissimpanan/*']); @endphp
                        <li>
                            <a href="{{ route('jenissimpanan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-vault text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Jenis Simpanan</span>
                            </a>
                        </li>
                    @endcan
                    @can('simpanan.index')
                        @php $active = request()->is(['simpanan', 'simpanan/*']) && !request()->is(['simpanan/simpanansaya*']); @endphp
                        <li>
                            <a href="{{ route('simpanan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-building-bank text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Data Simpanan</span>
                            </a>
                        </li>
                    @endcan
                    @can('jenistabungan.index')
                        @php $active = request()->is(['jenistabungan', 'jenistabungan/*']); @endphp
                        <li>
                            <a href="{{ route('jenistabungan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-coin text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Jenis Tabungan</span>
                            </a>
                        </li>
                    @endcan
                    @can('tabungan.index')
                        @php $active = request()->is(['tabungan', 'tabungan/*']); @endphp
                        <li>
                            <a href="{{ route('tabungan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-wallet text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Data Tabungan</span>
                            </a>
                        </li>
                    @endcan
                    @can('jenispembiayaan.index')
                        @php $active = request()->is(['jenispembiayaan', 'jenispembiayaan/*']); @endphp
                        <li>
                            <a href="{{ route('jenispembiayaan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-cash text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Jenis Pembiayaan</span>
                            </a>
                        </li>
                    @endcan
                    @can('pembiayaan.index')
                        @php $active = request()->is(['pembiayaan', 'pembiayaan/*']) && !request()->is(['pembiayaan/pinjamansaya*']); @endphp
                        <li>
                            <a href="{{ route('pembiayaan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-cash-banknote text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Data Pembiayaan</span>
                            </a>
                        </li>
                    @endcan
                    @can('laporankoperasi.index')
                        @php $active = request()->is(['laporankoperasi', 'laporankoperasi/*']); @endphp
                        <li>
                            <a href="{{ route('laporankoperasi.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-file-analytics text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Laporan Koperasi</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        @endif

        <!-- ================= 6. MSDM & LAYANAN KARYAWAN ================= -->
        @if (auth()->check() && (
            auth()->user()->hasAnyPermission([
                'presensi.index', 'izinabsen.index', 'laporanmsdm.index',
                'jobdesk.index', 'programkerja.index', 'agendakegiatan.index', 
                'realkegiatan.index', 'realkegiatan.laporan'
            ]) ||
            auth()->user()->hasRole('karyawan')
        ))
            <div>
                <div class="px-3 pb-1 text-[10.5px] font-bold text-emerald-300/80 uppercase tracking-wider">MSDM & Layanan</div>
                <ul class="space-y-0.5">
                    @can('presensi.index')
                        @php $active = request()->is(['presensi']); @endphp
                        <li>
                            <a href="{{ route('presensi.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-fingerprint text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Monitoring Presensi</span>
                            </a>
                        </li>
                    @endcan
                    @can('izinabsen.index')
                        @php $active = request()->is(['izinabsen', 'izinabsen/*']); @endphp
                        <li>
                            <a href="{{ route('izinabsen.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-calendar-minus text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Pengajuan Absen & Izin</span>
                            </a>
                        </li>
                    @endcan
                    @if (auth()->user()->can('jobdesk.index') || auth()->user()->hasRole('karyawan'))
                        @php $active = request()->is(['jobdesk', 'jobdesk/*']); @endphp
                        <li>
                            <a href="{{ route('jobdesk.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-list-check text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Jobdesk</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('programkerja.index') || auth()->user()->hasRole('karyawan'))
                        @php $active = request()->is(['programkerja', 'programkerja/*']); @endphp
                        <li>
                            <a href="{{ route('programkerja.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-target-arrow text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Program Kerja</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('agendakegiatan.index') || auth()->user()->hasRole('karyawan'))
                        @php $active = request()->is(['agendakegiatan', 'agendakegiatan/*']); @endphp
                        <li>
                            <a href="{{ route('agendakegiatan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-calendar-month text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Agenda Kegiatan</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('realkegiatan.index') || auth()->user()->hasRole('karyawan'))
                        @php $active = request()->is(['realisasikegiatan', 'realisasikegiatan/*']); @endphp
                        <li>
                            <a href="{{ route('realisasikegiatan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-circle-check text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Realisasi Kegiatan</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('realkegiatan.laporan') || auth()->user()->hasRole('karyawan'))
                        @php $active = request()->is(['kegiatan/laporan', 'kegiatan/laporan/*']); @endphp
                        <li>
                            <a href="{{ route('kegiatan.laporan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-report text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Laporan Kegiatan</span>
                            </a>
                        </li>
                    @endif
                    @can('laporanmsdm.index')
                        @php $active = request()->is(['laporanmsdm', 'laporanmsdm/*']); @endphp
                        <li>
                            <a href="{{ route('laporanmsdm.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-file-text text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Laporan MSDM</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Khusus Karyawan -->
                    @if (auth()->check() && auth()->user()->hasRole('karyawan'))
                        @php $active = request()->is(['checklistibadah', 'checklistibadah/*']); @endphp
                        <li>
                            <a href="{{ route('checklistibadah.create') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-checkbox text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Checklist Ibadah</span>
                            </a>
                        </li>
                        @php $active = request()->is(['simpanansaya', 'simpanansaya/*']); @endphp
                        <li>
                            <a href="{{ route('simpanan.simpanansaya') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-vault text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Simpanan Saya</span>
                            </a>
                        </li>
                        @php $active = request()->is(['pinjamansaya', 'pinjamansaya/*']); @endphp
                        <li>
                            <a href="{{ route('pembiayaan.pinjamansaya') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-credit-card text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Pinjaman Saya</span>
                            </a>
                        </li>
                        @php $active = request()->is(['absensikaryawan', 'absensikaryawan/*']); @endphp
                        <li>
                            <a href="{{ route('presensi.absensikaryawan') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-device-watch-stats text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Presensi & Absensi</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        @endif

        <!-- ================= 7. KEGIATAN & PESANTREN ================= -->
        @if (auth()->check() && (
            auth()->user()->hasAnyPermission(['agenda.index', 'asramasiswa.index'])
        ))
            <div>
                <div class="px-3 pb-1 text-[10.5px] font-bold text-emerald-300/80 uppercase tracking-wider">Kegiatan & Pesantren</div>
                <ul class="space-y-0.5">
                    @can('agenda.index')
                        @php $active = request()->is(['agenda', 'agenda/*']); @endphp
                        <li>
                            <a href="{{ route('agenda.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-calendar-event text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Agenda Pesantren</span>
                            </a>
                        </li>
                    @endcan
                    @can('asramasiswa.index')
                        @php $active = request()->is(['asramasiswa', 'asramasiswa/*']); @endphp
                        <li>
                            <a href="{{ route('asramasiswa.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-home-check text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Data Siswa Asrama</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        @endif

        <!-- ================= AL AMIN GOT TALENT ================= -->
        @if (auth()->check() && (
            auth()->user()->hasAnyPermission(['perlombaan.index', 'pendaftarangottalent.index', 'jenjangpendidikan.index'])
        ))
            <div>
                <div class="px-3 pb-1 text-[10.5px] font-bold text-emerald-300/80 uppercase tracking-wider">Al Amin Got Talent</div>
                <ul class="space-y-0.5">
                    @can('perlombaan.index')
                        @php $active = request()->is(['perlombaan', 'perlombaan/*']); @endphp
                        <li>
                            <a href="{{ route('perlombaan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-trophy text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Perlombaan Got Talent</span>
                            </a>
                        </li>
                    @endcan
                    @can('pendaftarangottalent.index')
                        @php $active = request()->is(['pendaftaran-got-talent', 'pendaftaran-got-talent/*', 'pendaftarangottalent', 'pendaftarangottalent/*']); @endphp
                        <li>
                            <a href="{{ route('pendaftarangottalent.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-sparkles text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Pendaftaran Got Talent</span>
                            </a>
                        </li>
                        @php $active = request()->is(['konfirmasi-pembayaran-got-talent', 'konfirmasi-pembayaran-got-talent/*']); @endphp
                        <li>
                            <a href="{{ route('konfirmasi-pembayaran-got-talent.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-receipt-tax text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Konfirmasi Got Talent</span>
                            </a>
                        </li>
                    @endcan
                    @can('jenjangpendidikan.index')
                        @php $active = request()->is(['jenjang-pendidikan', 'jenjang-pendidikan/*']); @endphp
                        <li>
                            <a href="{{ route('jenjang-pendidikan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-stairs text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Jenjang Pendidikan</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        @endif

        <!-- ================= 8. WEBSITE & INFORMASI ================= -->
        @if (auth()->check() && (
            auth()->user()->hasAnyPermission(['kategori.index', 'post.index', 'sebaran-alumni.index', 'pages.index', 'tentang-pesantren.index', 'visimisi.index', 'ppdb-setting.index', 'testimonials.index', 'prestasisiswa.index', 'programunggulan.index', 'pilarpendidikan.index', 'gallery.index']) ||
            auth()->user()->hasAnyPermission(['pengumuman.index', 'kategori-pengumuman.index', 'push-subscriptions.index'])
        ))
            <div>
                <div class="px-3 pb-1 text-[10.5px] font-bold text-emerald-300/80 uppercase tracking-wider">Website & Informasi</div>
                <ul class="space-y-0.5">
                    @can('post.index')
                        @php $active = request()->is(['post', 'post/*']); @endphp
                        <li>
                            <a href="{{ route('post.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-news text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Post / Berita</span>
                            </a>
                        </li>
                    @endcan
                    @can('kategori.index')
                        @php $active = request()->is(['kategori', 'kategori/*']); @endphp
                        <li>
                            <a href="{{ route('kategori.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-category-2 text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Kategori Berita</span>
                            </a>
                        </li>
                    @endcan
                    @can('sebaran-alumni.index')
                        @php $active = request()->is(['sebaran-alumni', 'sebaran-alumni/*']); @endphp
                        <li>
                            <a href="{{ route('sebaran-alumni.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-map-pin text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Sebaran Alumni</span>
                            </a>
                        </li>
                    @endcan
                    @can('pages.index')
                        @php $active = request()->is(['pages', 'pages/*']); @endphp
                        <li>
                            <a href="{{ route('pages.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-file-text text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Halaman (Pages)</span>
                            </a>
                        </li>
                    @endcan
                    @can('tentang-pesantren.index')
                        @php $active = request()->is(['tentang-pesantren', 'tentang-pesantren/*']); @endphp
                        <li>
                            <a href="{{ route('tentang-pesantren.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-info-square-rounded text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Tentang Pesantren</span>
                            </a>
                        </li>
                    @endcan
                    @can('visimisi.index')
                        @php $active = request()->is(['visimisi', 'visimisi/*']); @endphp
                        <li>
                            <a href="{{ route('visimisi.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-flag-3 text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Visi & Misi</span>
                            </a>
                        </li>
                    @endcan
                    @can('ppdb-setting.index')
                        @php $active = request()->is(['ppdb-setting', 'ppdb-setting/*']); @endphp
                        <li>
                            <a href="{{ route('ppdb-setting.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-forms text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>PPDB Setting</span>
                            </a>
                        </li>
                    @endcan
                    @can('testimonials.index')
                        @php $active = request()->is(['testimonials', 'testimonials/*']); @endphp
                        <li>
                            <a href="{{ route('testimonials.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-message-2 text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Testimoni</span>
                            </a>
                        </li>
                    @endcan
                    @can('prestasisiswa.index')
                        @php $active = request()->is(['prestasisiswa', 'prestasisiswa/*']); @endphp
                        <li>
                            <a href="{{ route('prestasisiswa.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-medal text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Prestasi Siswa</span>
                            </a>
                        </li>
                    @endcan
                    @can('programunggulan.index')
                        @php $active = request()->is(['program-unggulan', 'program-unggulan/*']); @endphp
                        <li>
                            <a href="{{ route('program-unggulan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-flame text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Program Unggulan</span>
                            </a>
                        </li>
                    @endcan
                    @can('pilarpendidikan.index')
                        @php $active = request()->is(['pilar-pendidikan', 'pilar-pendidikan/*']); @endphp
                        <li>
                            <a href="{{ route('pilar-pendidikan.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-columns text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Pilar Pendidikan</span>
                            </a>
                        </li>
                    @endcan
                    @can('gallery.index')
                        @php $active = request()->is(['gallery', 'gallery/*']); @endphp
                        <li>
                            <a href="{{ route('gallery.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-photo text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Galeri Kegiatan</span>
                            </a>
                        </li>
                    @endcan
                    @can('pengumuman.index')
                        @php $active = request()->is(['pengumuman', 'pengumuman/*']); @endphp
                        <li>
                            <a href="{{ route('pengumuman.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-speakerphone text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Daftar Pengumuman</span>
                            </a>
                        </li>
                    @endcan
                    @can('kategori-pengumuman.index')
                        @php $active = request()->is(['kategori-pengumuman', 'kategori-pengumuman/*']); @endphp
                        <li>
                            <a href="{{ route('kategori-pengumuman.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-tag text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Kategori Pengumuman</span>
                            </a>
                        </li>
                    @endcan
                    @can('push-subscriptions.index')
                        @php $active = request()->is(['push-subscriptions', 'push-subscriptions/*']); @endphp
                        <li>
                            <a href="{{ route('push-subscriptions.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-bell-ringing text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Push Notification</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        @endif

        <!-- ================= 9. SISTEM & PENGATURAN ================= -->
        @if (auth()->check() && (
            auth()->user()->hasAnyPermission(['jamkerja.index', 'biaya.index', 'tahunajaran.index', 'tahunajaranppdb.index', 'migrasi-siswa.index']) ||
            auth()->user()->hasRole('super admin') ||
            auth()->user()->hasAnyPermission(['questionnaires.index', 'questionnaires.create'])
        ))
            <div>
                <div class="px-3 pb-1 text-[10.5px] font-bold text-emerald-300/80 uppercase tracking-wider">Sistem & Pengaturan</div>
                <ul class="space-y-0.5">
                    @can('jamkerja.index')
                        @php $active = request()->is(['jamkerja', 'jamkerja/*']); @endphp
                        <li>
                            <a href="{{ route('jamkerja.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-clock-cog text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Jam Kerja</span>
                            </a>
                        </li>
                    @endcan
                    @can('tahunajaran.index')
                        @php $active = request()->is(['tahunajaran', 'tahunajaran/*']); @endphp
                        <li>
                            <a href="{{ route('tahunajaran.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-calendar-stats text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Tahun Ajaran</span>
                            </a>
                        </li>
                    @endcan
                    @can('tahunajaranppdb.index')
                        @php $active = request()->is(['tahunajaranppdb', 'tahunajaranppdb/*']); @endphp
                        <li>
                            <a href="{{ route('tahunajaranppdb.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-calendar-plus text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Tahun Ajaran PPDB</span>
                            </a>
                        </li>
                    @endcan
                    @can('biaya.index')
                        @php $active = request()->is(['biaya', 'biaya/*']); @endphp
                        <li>
                            <a href="{{ route('biaya.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-coins text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Biaya Pendidikan</span>
                            </a>
                        </li>
                    @endcan
                    @php $active = request()->is(['mesinfingerprint', 'mesinfingerprint/*']); @endphp
                    <li>
                        <a href="{{ route('mesinfingerprint.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                            <i class="ti ti-device-desktop-analytics text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                            <span>Mesin Fingerprint</span>
                        </a>
                    </li>
                    @can('migrasi-siswa.index')
                        @php $active = request()->is(['migrasi-siswa', 'migrasi-siswa/*']); @endphp
                        <li>
                            <a href="{{ route('migrasi-siswa.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-arrows-transfer-down text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Migrasi Siswa</span>
                            </a>
                        </li>
                    @endcan

                    <!-- Khusus Super Admin -->
                    @hasrole('super admin')
                        @php $active = request()->is(['users', 'users/*']); @endphp
                        <li>
                            <a href="{{ route('users.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-users-group text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>User Management</span>
                            </a>
                        </li>
                        @php $active = request()->is(['roles', 'roles/*']); @endphp
                        <li>
                            <a href="{{ route('roles.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-shield-lock text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Role</span>
                            </a>
                        </li>
                        @php $active = request()->is(['permissions', 'permissions/*']); @endphp
                        <li>
                            <a href="{{ route('permissions.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-key text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Permission</span>
                            </a>
                        </li>
                        @php $active = request()->is(['permissiongroups', 'permissiongroups/*']); @endphp
                        <li>
                            <a href="{{ route('permissiongroups.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-folders text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Group Permission</span>
                            </a>
                        </li>
                        @php $active = request()->is(['pengaturan-umum', 'pengaturan-umum/*']); @endphp
                        <li>
                            <a href="{{ route('pengaturan-umum.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-settings-2 text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Pengaturan Umum</span>
                            </a>
                        </li>
                    @endhasrole

                    @can('questionnaires.index')
                        @php $active = request()->is(['admin/questionnaires*']); @endphp
                        <li>
                            <a href="{{ route('admin.questionnaires.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-[13px] transition-all duration-150 {{ $active ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-emerald-100/80 hover:text-white hover:bg-emerald-800/60 font-medium' }}">
                                <i class="ti ti-clipboard-list text-[17px] {{ $active ? 'text-white' : 'text-emerald-300' }}"></i>
                                <span>Kuisioner</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        @endif

    </div>

    <!-- Bottom User Info Card -->
    <div class="p-3 border-t border-emerald-950/80 bg-emerald-950/70 backdrop-blur-xs">
        <div class="flex items-center gap-3">
            <div class="relative w-9 h-9 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-bold text-xs shadow-xs overflow-hidden flex-shrink-0">
                @if (auth()->check() && auth()->user()->foto)
                    <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Avatar" class="w-full h-full object-cover">
                @else
                    <span>{{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'AD' }}</span>
                @endif
                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-emerald-950 rounded-full"></span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-emerald-50 truncate leading-tight">
                    {{ auth()->check() ? auth()->user()->name : 'Administrator' }}
                </p>
                <p class="text-[10px] text-emerald-300/80 truncate flex items-center gap-1">
                    <i class="ti ti-shield-check text-emerald-600"></i>
                    {{ auth()->check() ? (auth()->user()->getRoleNames()->first() ?? 'User') : 'Super Admin' }}
                </p>
            </div>
            @if (session()->has('impersonator_id'))
                <a href="{{ route('users.stop-impersonate') }}" 
                   class="w-7 h-7 flex items-center justify-center rounded-xl bg-amber-500/30 text-amber-300 hover:bg-amber-500 hover:text-white transition" 
                   title="Keluar Mode View As (Kembali ke Admin)">
                    <i class="ti ti-door-exit text-[16px]"></i>
                </a>
            @else
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="w-7 h-7 flex items-center justify-center rounded-xl text-emerald-300 hover:text-rose-400 hover:bg-emerald-900/80 transition" 
                            title="Logout">
                        <i class="ti ti-logout text-[16px]"></i>
                    </button>
                </form>
            @endif
        </div>
    </div>

</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar-menu-scroll');
        if (!sidebar) return;

        // 1. Restore scroll position from sessionStorage
        const savedPos = sessionStorage.getItem('sidebar_scroll_position');
        if (savedPos !== null) {
            sidebar.scrollTop = parseInt(savedPos, 10);
        }

        // 2. Ensure active menu item stays in view
        const activeLink = sidebar.querySelector('a.bg-emerald-600');
        if (activeLink) {
            const rect = activeLink.getBoundingClientRect();
            const sidebarRect = sidebar.getBoundingClientRect();
            if (rect.top < sidebarRect.top || rect.bottom > sidebarRect.bottom) {
                activeLink.scrollIntoView({ block: 'center', behavior: 'instant' });
            }
        }

        // 3. Save scroll position on scroll
        sidebar.addEventListener('scroll', function() {
            sessionStorage.setItem('sidebar_scroll_position', sidebar.scrollTop);
        }, { passive: true });

        // 4. Save scroll position immediately when any link is clicked
        sidebar.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                sessionStorage.setItem('sidebar_scroll_position', sidebar.scrollTop);
            });
        });
    });
</script>
