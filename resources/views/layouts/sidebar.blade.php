<!-- Menu -->
<style>
    /* Responsive sidebar collapse fix: hilangkan bg active/hover di collapse */
    .layout-menu.layout-menu-collapsed .menu-inner .menu-link,
    .layout-menu.layout-menu-collapsed .menu-inner .menu-link:hover,
    .layout-menu.layout-menu-collapsed .menu-inner .menu-item.active>.menu-link {
        background: transparent !important;
        color: #fff !important;
        font-weight: normal !important;
        box-shadow: none !important;
        border-radius: 8px !important;
        transition: none !important;
    }

    .layout-menu.layout-menu-collapsed .menu-inner .menu-link .menu-icon {
        color: #fff !important;
    }

    .layout-menu.layout-menu-collapsed .menu-inner .menu-link:hover .menu-icon,
    .layout-menu.layout-menu-collapsed .menu-inner .menu-item.active>.menu-link .menu-icon {
        color: #ff8c00 !important;
    }

    /* Responsive sidebar collapse */
    .layout-menu.layout-menu-collapsed .app-brand {
        justify-content: center !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .layout-menu.layout-menu-collapsed .app-brand-logo img {
        width: 36px !important;
        height: 36px !important;
        object-fit: contain;
        margin: 0 auto;
    }

    .sidebar-user-info {
        padding: 1rem 1.5rem;
        margin: 0.5rem 0.75rem;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        border-radius: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .sidebar-user-info:hover {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.08) 100%);
        transform: translateY(-2px);
    }

    .sidebar-user-info-content {
        display: flex;
        align-items: center;
        gap: 0.875rem;
    }

    .sidebar-user-avatar {
        position: relative;
        flex-shrink: 0;
    }

    .sidebar-user-avatar img {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .sidebar-user-info:hover .sidebar-user-avatar img {
        transform: scale(1.05);
    }

    .sidebar-user-status {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background: #4caf50;
        border: 2px solid #fff;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .sidebar-user-details {
        flex: 1;
        min-width: 0;
    }

    .sidebar-user-name {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.3;
    }

    .sidebar-user-role {
        font-size: 0.8125rem;
        color: rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        gap: 0.375rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar-user-role i {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.6);
    }

    .layout-menu.layout-menu-collapsed .sidebar-user-info {
        padding: 0.75rem 0.5rem !important;
        margin: 0.5rem 0.25rem !important;
        justify-content: center !important;
    }

    .layout-menu.layout-menu-collapsed .sidebar-user-info-content {
        flex-direction: column !important;
        align-items: center !important;
        gap: 0.5rem !important;
    }

    .layout-menu.layout-menu-collapsed .sidebar-user-details {
        display: none !important;
    }

    .layout-menu.layout-menu-collapsed .sidebar-user-avatar img {
        width: 40px !important;
        height: 40px !important;
    }

    .layout-menu.layout-menu-collapsed .sidebar-user-status {
        width: 10px !important;
        height: 10px !important;
        border-width: 1.5px !important;
    }

    .layout-menu.layout-menu-collapsed .menu-inner .menu-link {
        justify-content: center !important;
        padding-left: 0.3rem !important;
        padding-right: 0.3rem !important;
    }

    .layout-menu.layout-menu-collapsed .menu-inner .menu-icon {
        margin: 0 auto !important;
        font-size: 1.3rem !important;
        display: block;
    }

    /* Menu utama (parent) */
    /* .menu-inner>.menu-item>.menu-link,
    .menu-inner>.menu-item.active>.menu-link,
    .menu-inner>.menu-item>.menu-link:hover {
        transition: none !important;
        margin: 0 !important;
        padding: 0.625rem 0.625rem !important;
        border-radius: 4px;
        font-size: 1rem !important;
        line-height: 1.5 !important;
        box-shadow: none !important;
    }
    .menu-inner>.menu-item>.menu-link:hover,
    .menu-inner>.menu-item.active>.menu-link {
        background: linear-gradient(135deg, #ff8c00 0%, #ff6b00 100%) !important;
        color: white !important;
        font-weight: 600;
    } */

    .menu-inner>.menu-item>.menu-link:hover i,
    .menu-inner>.menu-item.active>.menu-link i {
        color: white !important;
    }

    /* Tambahan: Parent menu (seperti Data Master) jadi orange saat open/active */
    .menu-item.open>.menu-link,
    .menu-item.active>.menu-link.menu-toggle {
        background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%) !important;
        color: #fff !important;
        font-weight: 600;
        border-radius: 4px;
        padding: 0.625rem 0.625rem !important;
        margin: 0.5rem 0.5rem 0.5rem 0.5rem !important;
        box-shadow: none !important;
        font-size: 1rem !important;
        line-height: 1.5 !important;
        transition: background 0.2s, color 0.2s;
    }

    .menu-item.open>.menu-link i,
    .menu-item.active>.menu-link.menu-toggle i {
        color: #fff !important;
    }

    /* Submenu (child) */
    .menu-sub .menu-item>.menu-link {
        background: transparent !important;
        color: inherit !important;
    }

    .menu-sub .menu-item>.menu-link:hover,
    .menu-sub .menu-item.active>.menu-link {
        background: rgba(255, 140, 0, 0.1) !important;
        color: #ff8c00 !important;
    }

    .menu-sub .menu-item>.menu-link:hover i,
    .menu-sub .menu-item.active>.menu-link i {
        color: #ff8c00 !important;
    }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard.index') }}" class="app-brand-link">
            <span class="app-brand-logo demo" style="width:auto !important; height: 46px !important;">
                @if ($pengaturan && $pengaturan->logo)
                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="" width="32">
                @else
                    <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="" width="32">
                @endif
            </span>
            <span
                class="app-brand-text demo menu-text fw-bold"><i><b></b></i>{{ $pengaturan && $pengaturan->nama_aplikasi ? $pengaturan->nama_aplikasi : 'SIP 80' }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <!-- User Info Section -->
    <div class="sidebar-user-info">
        <div class="sidebar-user-info-content">
            <div class="sidebar-user-avatar">
                <img src="{{ asset(auth()->user()->avatar ? 'storage/avatars/' . auth()->user()->avatar : 'assets/img/avatars/1.png') }}"
                    alt="{{ auth()->user()->name }}">
                <span class="sidebar-user-status"></span>
            </div>
            <div class="sidebar-user-details">
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-role">
                    <i class="ti ti-shield-check"></i>
                    <span>{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</span>
                </div>
            </div>
        </div>
    </div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->is(['dashboard', 'dashboard/*']) ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-home"></i>
                <div>Dashboard</div>
            </a>
        </li>
        <li
            class="menu-item {{ request()->is([
                'karyawan',
                'karyawan/*',
                'jabatan',
                'jabatan/*',
                'unit',
                'unit/*',
                'siswa',
                'siswa/*',
                'jenisbiaya',
                'departemen',
                'ledger',
                'anggota',
                'jenissimpanan',
                'jenistabungan',
                'jenispembiayaan',
                'kategoriibadah',
                'kegiatanibadah',
            ])
                ? 'open'
                : '' }}">
            @if (auth()->check() &&
                    auth()->user()->hasAnyPermission([
                            'karyawan.index',
                            'jabatan.index',
                            'unit.index',
                            'jenisbiaya.index',
                            'departemen.index',
                            'ledger.index',
                            'siswa.index',
                            'anggota.index',
                            'jenissimpanan.index',
                            'jenistabungan.index',
                            'jenispembiayaan.index',
                            'kategoriibadah.index',
                            'kegiatanibadah.index',
                        ]))
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-database"></i>
                    <div>Data Master</div>
                </a>
                <ul class="menu-sub">
                    @can('karyawan.index')
                        <li class="menu-item {{ request()->is(['karyawan', 'karyawan/*']) ? 'active' : '' }}">
                            <a href="{{ route('karyawan.index') }}" class="menu-link">
                                <div>Karyawan</div>
                            </a>
                        </li>
                    @endcan
                    @can('siswa.index')
                        <li class="menu-item {{ request()->is(['siswa', 'siswa/*']) ? 'active' : '' }}">
                            <a href="{{ route('siswa.index') }}" class="menu-link">
                                <div>Siswa</div>
                            </a>
                        </li>
                    @endcan

                    @can('unit.index')
                        <li class="menu-item {{ request()->is(['unit', 'unit/*']) ? 'active' : '' }}">
                            <a href="{{ route('unit.index') }}" class="menu-link">
                                <div>Unit</div>
                            </a>
                        </li>
                    @endcan
                    @can('biaya.index')
                        <li class="menu-item {{ request()->is(['jenisbiaya', 'jenisbiaya/*']) ? 'active' : '' }}">
                            <a href="{{ route('jenisbiaya.index') }}" class="menu-link">
                                <div>Jenis Biaya</div>
                            </a>
                        </li>
                    @endcan
                    @can('departemen.index')
                        <li class="menu-item {{ request()->is(['departemen', 'departemen/*']) ? 'active' : '' }}">
                            <a href="{{ route('departemen.index') }}" class="menu-link">
                                <div>Departemen</div>
                            </a>
                        </li>
                    @endcan

                    @can('ledger.index')
                        <li class="menu-item {{ request()->is(['ledger', 'ledger/*']) ? 'active' : '' }}">
                            <a href="{{ route('ledger.index') }}" class="menu-link">
                                <div>Ledger</div>
                            </a>
                        </li>
                    @endcan
                    @can('anggota.index')
                        <li class="menu-item {{ request()->is(['anggota', 'anggota/*']) ? 'active' : '' }}">
                            <a href="{{ route('anggota.index') }}" class="menu-link">
                                <div>Anggota</div>
                            </a>
                        </li>
                    @endcan
                    @can('jenissimpanan.index')
                        <li class="menu-item {{ request()->is(['jenissimpanan', 'jenissimpanan/*']) ? 'active' : '' }}">
                            <a href="{{ route('jenissimpanan.index') }}" class="menu-link">
                                <div>Jenis Simpanan</div>
                            </a>
                        </li>
                    @endcan
                    @can('jenistabungan.index')
                        <li class="menu-item {{ request()->is(['jenistabungan', 'jenistabungan/*']) ? 'active' : '' }}">
                            <a href="{{ route('jenistabungan.index') }}" class="menu-link">
                                <div>Jenis Tabungan</div>
                            </a>
                        </li>
                    @endcan
                    @can('jenispembiayaan.index')
                        <li class="menu-item {{ request()->is(['jenispembiayaan', 'jenispembiayaan/*']) ? 'active' : '' }}">
                            <a href="{{ route('jenispembiayaan.index') }}" class="menu-link">
                                <div>Jenis Pembiayaan</div>
                            </a>
                        </li>
                    @endcan
                    @can('kategoriibadah.index')
                        <li class="menu-item {{ request()->is(['kategoriibadah', 'kategoriibadah/*']) ? 'active' : '' }}">
                            <a href="{{ route('kategoriibadah.index') }}" class="menu-link">
                                <div>Kategori Ibadah</div>
                            </a>
                        </li>
                    @endcan
                    @can('kegiatanibadah.index')
                        <li class="menu-item {{ request()->is(['kegiatanibadah', 'kegiatanibadah/*']) ? 'active' : '' }}">
                            <a href="{{ route('kegiatanibadah.index') }}" class="menu-link">
                                <div>Kegiatan Ibadah</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            @endif
        </li>
        @if (auth()->check() &&
                auth()->user()->hasAnyPermission(['pendaftaran.index']))
            <li class="menu-item {{ request()->is(['pendaftaran', 'pendaftaran/*', 'pendaftaranonline', 'pendaftaranonline/*']) ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-file-description"></i>
                    <div>Pendaftaran</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is(['pendaftaran']) ? 'active' : '' }}">
                        <a href="{{ route('pendaftaran.index') }}" class="menu-link">
                            <div>Pendaftaran </div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is(['pendaftaranonline']) ? 'active' : '' }}">
                        <a href="{{ route('pendaftaranonline.index') }}" class="menu-link">
                            <div>Pendaftaran Online</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Menu Akademik -->
        @if (auth()->check() &&
                auth()->user()->hasAnyPermission(['presensisiswa.index', 'guru.index', 'jabatanakademik.index', 'matapelajaran.index', 'kelas.index', 'jadwalpelajaran.index']))
            <li class="menu-item {{ request()->is(['akademik', 'akademik/*', 'presensisiswa', 'presensisiswa/*', 'guru', 'guru/*', 'jabatan-akademik', 'jabatan-akademik/*', 'mata-pelajaran', 'mata-pelajaran/*', 'kelas', 'kelas/*', 'jadwal-pelajaran', 'jadwal-pelajaran/*']) ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-school"></i>
                    <div>Akademik</div>
                </a>
                <ul class="menu-sub">
                    @can('guru.index')
                        <li class="menu-item {{ request()->is(['guru', 'guru/*']) ? 'active' : '' }}">
                            <a href="{{ route('guru.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-users"></i>
                                <div>Data Guru</div>
                            </a>
                        </li>
                    @endcan
                    @can('jabatanakademik.index')
                        <li class="menu-item {{ request()->is(['jabatan-akademik', 'jabatan-akademik/*']) ? 'active' : '' }}">
                            <a href="{{ route('jabatan-akademik.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-badge"></i>
                                <div>Jabatan Akademik</div>
                            </a>
                        </li>
                    @endcan
                    @if (auth()->check() &&
                            auth()->user()->hasAnyPermission(['presensisiswa.index']))
                        <li class="menu-item {{ request()->is(['presensisiswa', 'presensisiswa/*']) ? 'active' : '' }}">
                            <a href="{{ route('presensisiswa.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-heart-rate-monitor"></i>
                                <div>Monitoring Presensi</div>
                            </a>
                        </li>
                    @endif
                    @can('matapelajaran.index')
                        <li class="menu-item {{ request()->is(['mata-pelajaran', 'mata-pelajaran/*']) ? 'active' : '' }}">
                            <a href="{{ route('mata-pelajaran.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-book"></i>
                                <div>Data Mata Pelajaran</div>
                            </a>
                        </li>
                    @endcan
                    @can('kelas.index')
                        <li class="menu-item {{ request()->is(['kelas', 'kelas/*']) ? 'active' : '' }}">
                            <a href="{{ route('kelas.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-chalkboard"></i>
                                <div>Kelas</div>
                            </a>
                        </li>
                    @endcan
                    @can('jadwalpelajaran.index')
                        <li class="menu-item {{ request()->is(['jadwal-pelajaran', 'jadwal-pelajaran/*']) ? 'active' : '' }}">
                            <a href="{{ route('jadwal-pelajaran.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-calendar"></i>
                                <div>Jadwal Pelajaran</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif

        @if (auth()->check() &&
                auth()->user()->hasAnyPermission(['simpanan.index', 'pembiayaan.index', 'tabungan.index']))
            <li
                class="menu-item {{ request()->is(['simpanan', 'pembiayaan', 'tabungan', 'tabungan/*', 'simpanan/*', 'pembiayaan/*']) ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-moneybag"></i>
                    <div>Koperasi</div>
                </a>
                <ul class="menu-sub">
                    @if (auth()->check() &&
                            auth()->user()->hasAnyPermission(['simpanan.index']))
                        <li class="menu-item {{ request()->is(['simpanan', 'simpanan/*']) ? 'active' : '' }}">
                            <a href="{{ route('simpanan.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Simpanan</div>
                            </a>
                        </li>
                    @endif
                    @if (auth()->check() &&
                            auth()->user()->hasAnyPermission(['tabungan.index']))
                        <li class="menu-item {{ request()->is(['tabungan', 'tabungan/*']) ? 'active' : '' }}">
                            <a href="{{ route('tabungan.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Tabungan</div>

                            </a>
                        </li>
                    @endif
                    @if (auth()->check() &&
                            auth()->user()->hasAnyPermission(['pembiayaan.index']))
                        <li class="menu-item {{ request()->is(['pembiayaan', 'pembiayaan/*']) ? 'active' : '' }}">
                            <a href="{{ route('pembiayaan.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Pembiayaan</div>
                            </a>
                        </li>
                    @endif
                    <li class="menu-item {{ request()->is(['laporankoperasi', 'laporankoperasi/*']) ? 'active' : '' }}">
                        <a href="{{ route('laporankoperasi.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-file-description"></i>
                            <div>Laporan</div>
                        </a>
                    </li>

                </ul>

            </li>
        @endif
        @if (auth()->check() &&
                auth()->user()->hasAnyPermission(['pembayaranpdd.index']))
            <li class="menu-item {{ request()->is(['pembayaranpendidikan']) ? 'open' : '' }}">

                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-moneybag"></i>
                    <div>Keuangan</div>
                </a>
                <ul class="menu-sub">
                    @if (auth()->check() &&
                            auth()->user()->hasAnyPermission(['pembayaranpdd.index']))
                        <li class="menu-item {{ request()->is(['pembayaranpendidikan']) ? 'active' : '' }}">
                            <a href="{{ route('pembayaranpendidikan.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Pembayaran </div>
                            </a>
                        </li>
                    @endif
                    @if (auth()->check() &&
                            auth()->user()->hasAnyPermission(['ledgertransaksi.index']))
                        <li class="menu-item {{ request()->is(['ledgertransaksi']) ? 'active' : '' }}">
                            <a href="{{ route('ledgertransaksi.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Mutasi Kas dan Bank </div>
                            </a>
                        </li>
                    @endif

                    @if (auth()->check() &&
                            auth()->user()->hasAnyPermission(['pembayaranpdd.index']))
                        <li class="menu-item {{ request()->is(['laporankeuangan']) ? 'active' : '' }}">
                            <a href="{{ route('lk.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Laporan </div>
                            </a>
                        </li>
                    @endif

                </ul>

            </li>
        @endif
        @if (auth()->check() &&
                auth()->user()->hasAnyPermission(['izinabsen.index', 'izinsakit.index', 'presensi.index']))
            <li class="menu-item {{ request()->is(['izinabsen', 'izinsakit', 'presensi', 'laporanmsdm']) ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-moneybag"></i>
                    <div>MSDM</div>
                </a>
                <ul class="menu-sub">
                    @if (auth()->check() &&
                            auth()->user()->hasAnyPermission(['presensi.index']))
                        <li class="menu-item {{ request()->is(['presensi']) ? 'active' : '' }}">
                            <a href="{{ route('presensi.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-heart-rate-monitor"></i>
                                <div>Monitoring Presensi </div>
                            </a>
                        </li>
                    @endif
                    @if (auth()->check() &&
                            auth()->user()->hasAnyPermission(['izinabsen.index']))
                        <li class="menu-item {{ request()->is(['izinabsen']) ? 'active' : '' }}">
                            <a href="{{ route('izinabsen.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Pengajuan Absen </div>
                            </a>
                        </li>
                    @endif
                    @if (auth()->check() &&
                            auth()->user()->hasAnyPermission(['presensi.index']))
                        <li class="menu-item {{ request()->is(['laporanmsdm']) ? 'active' : '' }}">
                            <a href="{{ route('laporanmsdm.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Laporan</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        @if (auth()->check() &&
                auth()->user()->hasAnyPermission(['realkegiatan.index', 'agendakegiatan.index', 'programkerja.index', 'jobdesk.index']))
            <li class="menu-item {{ request()->is(['realisasikegiatan', 'agendakegiatan', 'programkerja', 'jobdesk']) ? 'open' : '' }}">

                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-activity"></i>
                    <div>Kegiatan</div>
                </a>
                <ul class="menu-sub">
                    @can('jobdesk.index')
                        <li class="menu-item {{ request()->is(['jobdesk', 'jobdesk/*']) ? 'active' : '' }}">
                            <a href="{{ route('jobdesk.index') }}" class="menu-link">
                                <div>Jobdesk</div>
                            </a>
                        </li>
                    @endcan
                    @if (auth()->check() &&
                            auth()->user()->hasAnyPermission(['programkerja.index']))
                        <li class="menu-item {{ request()->is(['programkerja']) ? 'active' : '' }}">
                            <a href="{{ route('programkerja.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Program Kerja </div>
                            </a>
                        </li>
                    @endif
                    @if (auth()->check() &&
                            auth()->user()->hasAnyPermission(['realkegiatan.index']))
                        <li class="menu-item {{ request()->is(['realisasikegiatan']) ? 'active' : '' }}">
                            <a href="{{ route('realisasikegiatan.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Realisasi Kegiatan </div>
                            </a>
                        </li>
                    @endif
                    @if (auth()->check() &&
                            auth()->user()->hasAnyPermission(['agendakegiatan.index']))
                        <li class="menu-item {{ request()->is(['agendakegiatan']) ? 'active' : '' }}">
                            <a href="{{ route('agendakegiatan.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Agenda Kegiatan </div>
                            </a>
                        </li>
                    @endif
                </ul>

            </li>
        @endif

        <!-- Menu Al Amin Got Talent -->
        @if (auth()->check() &&
                auth()->user()->hasAnyPermission(['perlombaan.index', 'pendaftarangottalent.index', 'jenjangpendidikan.index']))
            <li
                class="menu-item {{ request()->is(['perlombaan', 'perlombaan/*', 'pendaftaran-got-talent', 'pendaftaran-got-talent/*', 'konfirmasi-pembayaran-got-talent', 'konfirmasi-pembayaran-got-talent/*', 'jenjang-pendidikan', 'jenjang-pendidikan/*']) ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-award"></i>
                    <div>Al Amin Got Talent</div>
                </a>
                <ul class="menu-sub">
                    @can('perlombaan.index')
                        <li class="menu-item {{ request()->is(['perlombaan', 'perlombaan/*']) ? 'active' : '' }}">
                            <a href="{{ route('perlombaan.index') }}" class="menu-link">
                                <div>Perlombaan</div>
                            </a>
                        </li>
                    @endcan
                    @can('pendaftarangottalent.index')
                        <li class="menu-item {{ request()->is(['pendaftaran-got-talent', 'pendaftaran-got-talent/*']) ? 'active' : '' }}">
                            <a href="{{ route('pendaftarangottalent.index') }}" class="menu-link">
                                <div>Pendaftaran Got Talent</div>
                            </a>
                        </li>
                    @endcan
                    @can('pendaftarangottalent.index')
                        <li
                            class="menu-item {{ request()->is(['konfirmasi-pembayaran-got-talent', 'konfirmasi-pembayaran-got-talent/*']) ? 'active' : '' }}">
                            <a href="{{ route('konfirmasi-pembayaran-got-talent.index') }}" class="menu-link">
                                <div>Konfirmasi Pembayaran</div>
                            </a>
                        </li>
                    @endcan
                    @can('jenjangpendidikan.index')
                        <li class="menu-item {{ request()->is(['jenjang-pendidikan', 'jenjang-pendidikan/*']) ? 'active' : '' }}">
                            <a href="{{ route('jenjang-pendidikan.index') }}" class="menu-link">
                                <div>Jenjang Pendidikan</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif

        @if (auth()->check() &&
                auth()->user()->hasAnyPermission([
                        'kategori.index',
                        'post.index',
                        'pages.index',
                        'testimonials.index',
                        'prestasisiswa.index',
                        'programunggulan.index',
                        'pilarpendidikan.index',
                    ]))
            <li
                class="menu-item {{ request()->is(['kategori', 'kategori/*', 'post', 'post/*', 'sebaran-alumni', 'sebaran-alumni/*', 'pages', 'pages/*', 'page/*', 'visimisi', 'testimonials', 'testimonials/*', 'prestasisiswa', 'prestasisiswa/*', 'program-unggulan', 'program-unggulan/*', 'pilar-pendidikan', 'pilar-pendidikan/*']) ? 'open' : '' }}">

                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-globe"></i>
                    <div>Website</div>
                </a>
                <ul class="menu-sub">
                    @can('kategori.index')
                        <li class="menu-item {{ request()->is(['kategori', 'kategori/*']) ? 'active' : '' }}">
                            <a href="{{ route('kategori.index') }}" class="menu-link">
                                <div>Kategori</div>
                            </a>
                        </li>
                    @endcan
                    @can('post.index')
                        <li class="menu-item {{ request()->is(['post', 'post/*']) ? 'active' : '' }}">
                            <a href="{{ route('post.index') }}" class="menu-link">
                                <div>Post</div>
                            </a>
                        </li>
                    @endcan
                    <li class="menu-item {{ request()->is(['sebaran-alumni', 'sebaran-alumni/*']) ? 'active' : '' }}">
                        <a href="{{ route('sebaran-alumni.index') }}" class="menu-link">
                            <div>Sebaran Alumni</div>
                        </a>
                    </li>
                    @can('pages.index')
                        <li class="menu-item {{ request()->is(['pages', 'pages/*']) ? 'active' : '' }}">
                            <a href="{{ route('pages.index') }}" class="menu-link">
                                <div>Pages</div>
                            </a>
                        </li>
                    @endcan
                    <li class="menu-item {{ request()->is(['tentang-pesantren']) || request()->routeIs('tentang-pesantren.*') ? 'active' : '' }}">
                        <a href="{{ route('tentang-pesantren.index') }}" class="menu-link">
                            <div>Tentang Pesantren</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is(['visimisi']) ? 'active' : '' }}">
                        <a href="{{ route('visimisi.index') }}" class="menu-link">
                            <div>Visi & Misi</div>
                        </a>
                    </li>
                    @can('testimonials.index')
                        <li class="menu-item {{ request()->is(['testimonials', 'testimonials/*']) ? 'active' : '' }}">
                            <a href="{{ route('testimonials.index') }}" class="menu-link">
                                <div>Testimoni</div>
                            </a>
                        </li>
                    @endcan
                    @can('prestasisiswa.index')
                        <li class="menu-item {{ request()->is(['prestasisiswa', 'prestasisiswa/*']) ? 'active' : '' }}">
                            <a href="{{ route('prestasisiswa.index') }}" class="menu-link">
                                <div>Prestasi Siswa</div>
                            </a>
                        </li>
                    @endcan
                    @can('programunggulan.index')
                        <li class="menu-item {{ request()->is(['program-unggulan', 'program-unggulan/*']) ? 'active' : '' }}">
                            <a href="{{ route('program-unggulan.index') }}" class="menu-link">
                                <div>Program Unggulan</div>
                            </a>
                        </li>
                    @endcan
                    @can('pilarpendidikan.index')
                        <li class="menu-item {{ request()->is(['pilar-pendidikan', 'pilar-pendidikan/*']) ? 'active' : '' }}">
                            <a href="{{ route('pilar-pendidikan.index') }}" class="menu-link">
                                <div>Pilar Pendidikan</div>
                            </a>
                        </li>
                    @endcan
                    <li class="menu-item {{ request()->is(['gallery', 'gallery/*']) ? 'active' : '' }}">
                        <a href="{{ route('gallery.index') }}" class="menu-link">
                            <div>Galeri Kegiatan</div>
                        </a>
                    </li>
                </ul>

            </li>
        @endif

        <!-- Menu Pengumuman -->
        @if (auth()->check())
            <li class="menu-item {{ request()->is(['pengumuman*', 'kategori-pengumuman*']) ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-speakerphone"></i>
                    <div>Pengumuman</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is(['pengumuman*']) ? 'active' : '' }}">
                        <a href="{{ route('pengumuman.index') }}" class="menu-link">
                            <div>Daftar Pengumuman</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is(['kategori-pengumuman*']) ? 'active' : '' }}">
                        <a href="{{ route('kategori-pengumuman.index') }}" class="menu-link">
                            <div>Kategori Pengumuman</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        <!-- KONFIGURASI-->
        <li
            class="menu-item {{ request()->is(['jamkerja', 'jamkerja/*', 'tahunajaran', 'biaya', 'tahunajaranppdb', 'tahunajaranppdb/*']) ? 'open' : '' }}">
            @if (auth()->check() &&
                    auth()->user()->hasAnyPermission(['jamkerja.index', 'biaya.index', 'tahunajaran.index', 'tahunajaranppdb.index']))
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-adjustments"></i>
                    <div>Konfigurasi</div>
                </a>
                <ul class="menu-sub">
                    @can('jamkerja.index')
                        <li class="menu-item {{ request()->is(['jamkerja', 'jamkerja/*']) ? 'active' : '' }}">
                            <a href="{{ route('jamkerja.index') }}" class="menu-link">
                                <div>Jam Kerja</div>
                            </a>
                        </li>
                    @endcan
                    @can('tahunajaran.index')
                        <li class="menu-item {{ request()->is(['tahunajaran', 'tahunajaran/*']) ? 'active' : '' }}">
                            <a href="{{ route('tahunajaran.index') }}" class="menu-link">
                                <div>Tahun Ajaran</div>
                            </a>
                        </li>
                    @endcan
                    @can('tahunajaranppdb.index')
                        <li class="menu-item {{ request()->is(['tahunajaranppdb', 'tahunajaranppdb/*']) ? 'active' : '' }}">
                            <a href="{{ route('tahunajaranppdb.index') }}" class="menu-link">
                                <div>Tahun Ajaran PPDB</div>
                            </a>
                        </li>
                    @endcan
                    @can('biaya.index')
                        <li class="menu-item {{ request()->is(['biaya', 'biaya/*']) ? 'active' : '' }}">
                            <a href="{{ route('biaya.index') }}" class="menu-link">
                                <div>Biaya</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            @endif
        </li>
        <!-- Setting -->
        @hasrole('super admin')
            <li
                class="menu-item {{ request()->is(['roles', 'roles/*', 'permissiongroups', 'permissiongroups/*', 'permissions', 'permissions/*', 'users', 'users/*', 'pengaturan-umum', 'pengaturan-umum/*']) ? 'open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-settings"></i>
                    <div>Settings</div>

                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is(['users', 'users/*']) ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="menu-link">
                            <div>User</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is(['roles', 'roles/*']) ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}" class="menu-link">
                            <div>Role</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is(['permissions', 'permissions/*']) ? 'active' : '' }}"">
                        <a href=" {{ route('permissions.index') }}" class="menu-link">
                            <div>Permission</div>
                        </a>
                    </li>
                    <li class="menu-item  {{ request()->is(['permissiongroups', 'permissiongroups/*']) ? 'active' : '' }}">
                        <a href="{{ route('permissiongroups.index') }}" class="menu-link">
                            <div>Group Permission</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is(['pengaturan-umum', 'pengaturan-umum/*']) ? 'active' : '' }}">
                        <a href="{{ route('pengaturan-umum.index') }}" class="menu-link">
                            <div>Pengaturan Umum</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endhasrole

        @if (auth()->check() &&
                auth()->user()->hasAnyPermission(['questionnaires.index', 'questionnaires.create']))
            <li class="menu-item {{ request()->is(['admin/questionnaires*']) ? 'open active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-clipboard-list"></i>
                    <div>Kuisioner</div>
                </a>
                <ul class="menu-sub">
                    @can('questionnaires.index')
                        <li class="menu-item {{ request()->is('admin/questionnaires') ? 'active' : '' }}">
                            <a href="{{ route('admin.questionnaires.index') }}" class="menu-link">
                                <div>Daftar Kuisioner</div>
                            </a>
                        </li>
                    @endcan
                    @can('questionnaires.create')
                        <li class="menu-item {{ request()->is('admin/questionnaires/create') ? 'active' : '' }}">
                            <a href="{{ route('admin.questionnaires.create') }}" class="menu-link">
                                <div>Tambah Kuisioner</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif
    </ul>
</aside>
<!-- / Menu -->
