<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="" width="52">
            </span>
            <span class="app-brand-text demo menu-text fw-bold"><i><b></b></i>SIP 80</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->is(['dashboard', 'dashboard/*']) ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
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
            @if (auth()->user()->hasAnyPermission([
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
                    @can('jabatan.index')
                        <li class="menu-item {{ request()->is(['jabatan', 'jabatan/*']) ? 'active' : '' }}">
                            <a href="{{ route('jabatan.index') }}" class="menu-link">
                                <div>Jabatan</div>
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
        @if (auth()->user()->hasAnyPermission(['pendaftaran.index']))
            <li class="menu-item {{ request()->is(['pendaftaran']) ? 'active' : '' }}">
                <a href="{{ route('pendaftaran.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-file-description"></i>
                    <div>Pendaftaran</div>
                </a>
            </li>
        @endif
        @if (auth()->user()->hasAnyPermission(['presensi.index']))
            <li class="menu-item {{ request()->is(['presensi', 'presensi/*']) ? 'active' : '' }}">
                <a href="{{ route('presensi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-device-desktop"></i>
                    <div>Monitoring Presensi</div>
                </a>
            </li>
        @endif
        @if (auth()->user()->hasAnyPermission(['simpanan.index', 'pembiayaan.index', 'tabungan.index']))
            <li
                class="menu-item {{ request()->is(['simpanan', 'pembiayaan', 'tabungan', 'tabungan/*', 'simpanan/*', 'pembiayaan/*']) ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-moneybag"></i>
                    <div>Koperasi</div>
                </a>
                <ul class="menu-sub">
                    @if (auth()->user()->hasAnyPermission(['simpanan.index']))
                        <li class="menu-item {{ request()->is(['simpanan', 'simpanan/*']) ? 'active' : '' }}">
                            <a href="{{ route('simpanan.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Simpanan</div>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasAnyPermission(['tabungan.index']))
                        <li class="menu-item {{ request()->is(['tabungan', 'tabungan/*']) ? 'active' : '' }}">
                            <a href="{{ route('tabungan.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Tabungan</div>

                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasAnyPermission(['pembiayaan.index']))
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
        @if (auth()->user()->hasAnyPermission(['pembayaranpdd.index']))
            <li class="menu-item {{ request()->is(['pembayaranpendidikan']) ? 'open' : '' }}">

                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-moneybag"></i>
                    <div>Keuangan</div>
                </a>
                <ul class="menu-sub">
                    @if (auth()->user()->hasAnyPermission(['pembayaranpdd.index']))
                        <li class="menu-item {{ request()->is(['pembayaranpendidikan']) ? 'active' : '' }}">
                            <a href="{{ route('pembayaranpendidikan.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Pembayaran </div>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasAnyPermission(['ledgertransaksi.index']))
                        <li class="menu-item {{ request()->is(['ledgertransaksi']) ? 'active' : '' }}">
                            <a href="{{ route('ledgertransaksi.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Mutasi Ledger </div>
                            </a>
                        </li>
                    @endif
                </ul>

            </li>
        @endif
        @if (auth()->user()->hasAnyPermission(['realkegiatan.index', 'agendakegiatan.index', 'programkerja.index', 'jobdesk.index']))
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
                    @if (auth()->user()->hasAnyPermission(['programkerja.index']))
                        <li class="menu-item {{ request()->is(['programkerja']) ? 'active' : '' }}">
                            <a href="{{ route('programkerja.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Program Kerja </div>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasAnyPermission(['realkegiatan.index']))
                        <li class="menu-item {{ request()->is(['realisasikegiatan']) ? 'active' : '' }}">
                            <a href="{{ route('realisasikegiatan.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-file-description"></i>
                                <div>Realisasi Kegiatan </div>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasAnyPermission(['agendakegiatan.index']))
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
        <!-- KONFIGURASI-->
        <li class="menu-item {{ request()->is(['jamkerja', 'jamkerja/*', 'tahunajaran', 'biaya']) ? 'open' : '' }}">
            @if (auth()->user()->hasAnyPermission(['jamkerja.index']))
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
                class="menu-item {{ request()->is(['roles', 'roles/*', 'permissiongroups', 'permissiongroups/*', 'permissions', 'permissions/*', 'users', 'users/*']) ? 'open' : '' }} ">
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
                </ul>
            </li>
        @endhasrole

    </ul>
</aside>
<!-- / Menu -->
