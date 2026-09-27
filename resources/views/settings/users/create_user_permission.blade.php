@extends('layouts.app')
@section('titlepage', 'Set Permission User - ' . $user->name)

@section('content')
<style>
    .menu-group-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .menu-group-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .menu-group-title {
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .menu-group-badge {
        font-size: 0.72rem;
        font-weight: 600;
        color: #475569;
        background: #e2e8f0;
        padding: 0.15rem 0.55rem;
        border-radius: 6px;
    }

    .sub-group-card {
        background: #ffffff;
        border: 1px solid #eef2f6;
        border-radius: 10px;
        height: 100%;
        transition: all 0.2s ease;
    }

    .sub-group-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px -2px rgba(15, 23, 42, 0.05);
    }

    .sub-group-header {
        background: #fcfdfd;
        border-bottom: 1px solid #f1f5f9;
        padding: 0.65rem 0.9rem;
        border-top-left-radius: 9px;
        border-top-right-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sub-group-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .sub-group-body {
        padding: 0.85rem 0.9rem;
    }

    .permission-item-label {
        font-size: 0.8rem;
        color: #334155;
        cursor: pointer;
        padding: 0.15rem 0;
        transition: color 0.15s ease;
    }

    .permission-item-label:hover {
        color: #064e3b;
        font-weight: 500;
    }

    .sticky-actions-bar {
        position: sticky;
        top: 75px;
        z-index: 99;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(8px);
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 20px -4px rgba(15, 23, 42, 0.08);
        padding: 0.75rem 1.25rem;
        margin-bottom: 1.5rem;
    }
</style>

@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-shield-lock fs-3" style="color: #064e3b"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Set Hak Akses User: {{ $user->name }}</h4>
                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                            <span class="text-muted small">Username: <strong>{{ $user->username }}</strong></span>
                            <span class="text-muted small">•</span>
                            <span class="text-muted small">Role: </span>
                            @forelse ($user->roles as $role)
                                <span class="badge bg-label-primary font-weight-bold">{{ ucwords($role->name) }}</span>
                            @empty
                                <span class="badge bg-label-secondary">Tanpa Role</span>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('users.index') }}" class="text-muted">
                                    <i class="ti ti-settings me-1"></i> Pengaturan
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('users.index') }}" class="text-muted">Users</a>
                            </li>
                            <li class="breadcrumb-item active">Set Permission</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    // Mapping Structure Menu Utama -> Sub Menu Groups yang PERSIS sama dengan urutan Sidebar Super Admin
    $menuStructure = [
        'Data Master' => [
            'icon' => 'ti ti-database',
            'groups' => ['Karyawan', 'Jabatan', 'Siswa', 'Unit', 'Jenis Biaya', 'Departemen', 'Ledger', 'jenissimpanan', 'jenistabungan', 'jenispembiayaan', 'Kategori Ibadah', 'Kegiatan Ibadah'],
        ],
        'Pendaftaran' => [
            'icon' => 'ti ti-file-description',
            'groups' => ['Pendaftaran', 'Pendaftaran Online', 'Tahun Ajaran PPDB', 'Asal Sekolah'],
        ],
        'Akademik' => [
            'icon' => 'ti ti-school',
            'groups' => ['Guru', 'Akademik Siswa', 'Jabatan Akademik', 'Presensi Siswa', 'Mata Pelajaran', 'Kelas', 'Jadwal Pelajaran', 'akademik'],
        ],
        'Koperasi' => [
            'icon' => 'ti ti-moneybag',
            'groups' => ['anggota', 'simpanan', 'tabungan', 'Pembiayaan'],
        ],
        'Keuangan' => [
            'icon' => 'ti ti-wallet',
            'groups' => ['Pembayaran Pendidikan', 'Jenis Bayar', 'Rencana SPP', 'Ledger Transaksi', 'Kategori Pemasukan', 'Kategori Pengeluaran', 'Kategori Ledger', 'Saldo Awal Ledger', 'Laporan Keuangan', 'Sumber Dana'],
        ],
        'MSDM' => [
            'icon' => 'ti ti-users',
            'groups' => ['Presensi', 'Izin Absen', 'Izin Sakit', 'Jam Kerja'],
        ],
        'Kegiatan' => [
            'icon' => 'ti ti-activity',
            'groups' => ['Jobdesk', 'Program Kerja', 'Agenda Kegiatan', 'Realisasi Kegiatan', 'Agenda'],
        ],
        'Asrama' => [
            'icon' => 'ti ti-home-check',
            'groups' => ['Asrama Siswa'],
        ],
        'Al Amin Got Talent' => [
            'icon' => 'ti ti-award',
            'groups' => ['Perlombaan', 'Pendaftaran Got Talent', 'Jenjang Pendidikan'],
        ],
        'Website' => [
            'icon' => 'ti ti-globe',
            'groups' => ['Kategori', 'Post', 'Sebaran Alumni', 'Pages', 'Tentang Pesantren', 'Visi & Misi', 'PPDB Setting', 'Testimoni', 'Prestasi Siswa', 'Program Unggulan', 'Pilar Pendidikan', 'Gallery'],
        ],
        'Pengumuman' => [
            'icon' => 'ti ti-speakerphone',
            'groups' => ['Pengumuman', 'Kategori Pengumuman', 'Push Subscription'],
        ],
        'Konfigurasi' => [
            'icon' => 'ti ti-adjustments',
            'groups' => ['Tahun Ajaran', 'Biaya', 'Mesin Fingerprint', 'Migrasi Siswa'],
        ],
        'Kuisioner' => [
            'icon' => 'ti ti-clipboard-list',
            'groups' => ['Kuisioner'],
        ],
        'Settings' => [
            'icon' => 'ti ti-settings',
            'groups' => ['Pengaturan Umum'],
        ],
        'Lainnya / Modul Tambahan' => [
            'icon' => 'ti ti-box',
            'groups' => [], // Otomatis menampung grup yang belum terdaftar
        ],
    ];

    // Kelompokkan data $permissions ke dalam masing-masing Main Menu
    $groupedData = [];
    $assignedGroupIds = [];

    // Indeks data permissions berdasarkan name (case insensitive)
    $permissionsByGroupName = [];
    foreach ($permissions as $p) {
        $cleanName = trim($p->name);
        $permissionsByGroupName[strtolower($cleanName)] = $p;
    }

    foreach ($menuStructure as $mainMenu => $meta) {
        $groupedData[$mainMenu] = [
            'icon' => $meta['icon'],
            'items' => []
        ];
        foreach ($meta['groups'] as $gName) {
            $key = strtolower(trim($gName));
            if (isset($permissionsByGroupName[$key])) {
                $groupedData[$mainMenu]['items'][] = $permissionsByGroupName[$key];
                $assignedGroupIds[] = $permissionsByGroupName[$key]->id;
            }
        }
    }

    // Masukkan sisa permission group yang belum masuk ke menu di atas
    foreach ($permissions as $p) {
        if (!in_array($p->id, $assignedGroupIds)) {
            $groupedData['Lainnya / Modul Tambahan']['items'][] = $p;
        }
    }
@endphp

<div class="alert alert-info d-flex align-items-center mb-4" role="alert" style="border-radius: 10px;">
    <i class="ti ti-info-circle fs-4 me-2"></i>
    <div>
        <strong>Informasi:</strong> Permission bertanda <span class="badge bg-label-success"><i class="ti ti-lock me-1"></i>Role</span> sudah otomatis aktif dari role user dan <strong>terkunci</strong>. Anda dapat mencentang permission tambahan khusus untuk user ini.
    </div>
</div>

<!-- Action & Search Toolbar -->
<div class="sticky-actions-bar">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-2 flex-grow-1 flex-md-grow-0" style="min-width: 250px;">
            <div class="input-group input-group-merge">
                <span class="input-group-text bg-white"><i class="ti ti-search text-muted"></i></span>
                <input type="text" id="searchPermission" class="form-control" placeholder="Cari nama modul atau permission...">
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1.5 px-3">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
            <button type="button" class="btn btn-label-success d-flex align-items-center gap-1.5 px-3" id="selectAll">
                <i class="ti ti-checkbox"></i> Pilih Semua (Tambahan)
            </button>
            <button type="button" class="btn btn-label-danger d-flex align-items-center gap-1.5 px-3" id="deselectAll">
                <i class="ti ti-square-x"></i> Kosongkan Tambahan
            </button>
        </div>
    </div>
</div>

<form action="{{ route('users.storeuserpermission', Crypt::encrypt($user->id)) }}" method="POST">
    @csrf

    @foreach ($groupedData as $mainMenuTitle => $mainMenuData)
        @if (count($mainMenuData['items']) > 0)
            <div class="menu-group-card permission-main-section">
                <!-- Main Menu Header -->
                <div class="menu-group-header">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="avatar avatar-sm bg-label-success rounded d-flex align-items-center justify-content-center">
                            <i class="{{ $mainMenuData['icon'] }} fs-5"></i>
                        </div>
                        <div>
                            <h5 class="menu-group-title">{{ $mainMenuTitle }}</h5>
                        </div>
                        <span class="menu-group-badge">{{ count($mainMenuData['items']) }} Sub Menu</span>
                    </div>
                    <div class="form-check mb-0">
                        <input class="form-check-input select-all-main-menu" type="checkbox" id="mainMenuCheck_{{ Str::slug($mainMenuTitle) }}">
                        <label class="form-check-label fw-semibold text-dark small cursor-pointer" for="mainMenuCheck_{{ Str::slug($mainMenuTitle) }}">
                            Pilih Semua di {{ $mainMenuTitle }}
                        </label>
                    </div>
                </div>

                <!-- Sub Menus Grid -->
                <div class="p-3.5 p-md-4">
                    <div class="row g-3">
                        @foreach ($mainMenuData['items'] as $d)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-12 sub-group-wrapper">
                                <div class="sub-group-card">
                                    <div class="sub-group-header">
                                        <h6 class="sub-group-title text-truncate" title="{{ $d->name }}">
                                            <i class="ti ti-folder text-success fs-5"></i>
                                            <span>{{ $d->name }}</span>
                                        </h6>
                                        <div class="form-check mb-0">
                                            <input class="form-check-input select-all-group" type="checkbox" data-group="{{ $d->id }}" id="selectGroup{{ $d->id }}">
                                            <label class="form-check-label small text-muted cursor-pointer" for="selectGroup{{ $d->id }}" style="font-size: 0.72rem;">
                                                Semua
                                            </label>
                                        </div>
                                    </div>
                                    <div class="sub-group-body">
                                        @foreach ($d->permissions as $perm)
                                            @php
                                                $isFromRole = in_array($perm->name, $rolePermissions);
                                                $isDirect = in_array($perm->name, $directPermissions);
                                            @endphp
                                            <div class="form-check mb-1.5 permission-item">
                                                @if ($isFromRole)
                                                    {{-- Locked checkbox if inherited from Role --}}
                                                    <input class="form-check-input permission-checkbox" type="checkbox" 
                                                        value="{{ $perm->name }}" id="defaultCheck{{ $perm->id }}"
                                                        data-group="{{ $d->id }}"
                                                        checked disabled>
                                                    <label class="form-check-label text-muted py-1 d-flex align-items-center justify-content-between w-100" for="defaultCheck{{ $perm->id }}">
                                                        <span>{{ $perm->name }}</span>
                                                        <span class="badge bg-label-success ms-1 small" style="font-size: 0.68rem;" title="Hak akses bawaan role (permanen)"><i class="ti ti-lock me-1"></i>Role</span>
                                                    </label>
                                                @else
                                                    {{-- Editable checkbox for custom user permissions --}}
                                                    <input class="form-check-input permission-checkbox editable-permission" type="checkbox" name="permission[]"
                                                        value="{{ $perm->name }}" id="defaultCheck{{ $perm->id }}"
                                                        data-group="{{ $d->id }}"
                                                        {{ $isDirect ? 'checked' : '' }}>
                                                    <label class="form-check-label permission-item-label w-100" for="defaultCheck{{ $perm->id }}">
                                                        {{ $perm->name }}
                                                    </label>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <div class="row mt-4 mb-5">
        <div class="col-12">
            <button type="submit" class="btn text-white w-100 py-3 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; font-size: 1.05rem; font-weight: 700; border: none; border-radius: 10px;">
                <i class="ti ti-device-floppy fs-4"></i>
                Simpan Hak Akses User {{ $user->name }}
            </button>
        </div>
    </div>
</form>
@endsection

@push('myscript')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllBtn = document.getElementById('selectAll');
        const deselectAllBtn = document.getElementById('deselectAll');
        const editableCheckboxes = document.querySelectorAll('.editable-permission');
        const groupCheckboxes = document.querySelectorAll('.select-all-group');
        const mainMenuCheckboxes = document.querySelectorAll('.select-all-main-menu');
        const searchInput = document.getElementById('searchPermission');

        // Global Select All (only affects editable permissions)
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', function () {
                editableCheckboxes.forEach(cb => cb.checked = true);
                updateAllGroupAndMainStates();
            });
        }

        // Global Deselect All (only affects editable permissions)
        if (deselectAllBtn) {
            deselectAllBtn.addEventListener('click', function () {
                editableCheckboxes.forEach(cb => cb.checked = false);
                updateAllGroupAndMainStates();
            });
        }

        // Main Menu Bulk Select
        mainMenuCheckboxes.forEach(mainCb => {
            mainCb.addEventListener('change', function () {
                const section = this.closest('.permission-main-section');
                const isChecked = this.checked;
                const sectionEditableCheckboxes = section.querySelectorAll('.editable-permission');

                sectionEditableCheckboxes.forEach(cb => cb.checked = isChecked);
                section.querySelectorAll('.select-all-group').forEach(groupCb => {
                    const groupId = groupCb.getAttribute('data-group');
                    const groupAllCbs = section.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);
                    updateGroupHeaderCheckbox(groupCb, groupAllCbs);
                });
            });
        });

        // Group-level Select All toggle
        groupCheckboxes.forEach(groupCb => {
            const groupId = groupCb.getAttribute('data-group');
            const groupEditableCbs = document.querySelectorAll(`.editable-permission[data-group="${groupId}"]`);
            const groupAllCbs = document.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);

            // Initialize group check state
            updateGroupHeaderCheckbox(groupCb, groupAllCbs);

            groupCb.addEventListener('change', function () {
                const isChecked = this.checked;
                groupEditableCbs.forEach(cb => {
                    cb.checked = isChecked;
                });
                updateGroupHeaderCheckbox(this, groupAllCbs);
                updateMainMenuState(this.closest('.permission-main-section'));
            });
        });

        // Individual permission check listener to update group checkbox & main menu checkbox
        editableCheckboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const groupId = this.getAttribute('data-group');
                const groupCb = document.querySelector(`.select-all-group[data-group="${groupId}"]`);
                const groupAllCbs = document.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);
                if (groupCb) {
                    updateGroupHeaderCheckbox(groupCb, groupAllCbs);
                }
                updateMainMenuState(this.closest('.permission-main-section'));
            });
        });

        function updateAllGroupAndMainStates() {
            groupCheckboxes.forEach(groupCb => {
                const groupId = groupCb.getAttribute('data-group');
                const groupAllCbs = document.querySelectorAll(`.permission-checkbox[data-group="${groupId}"]`);
                updateGroupHeaderCheckbox(groupCb, groupAllCbs);
            });
            document.querySelectorAll('.permission-main-section').forEach(section => {
                updateMainMenuState(section);
            });
        }

        // Initialize all main menu checkboxes
        document.querySelectorAll('.permission-main-section').forEach(section => {
            updateMainMenuState(section);
        });

        function updateGroupHeaderCheckbox(groupHeaderCb, itemCbs) {
            const total = itemCbs.length;
            const checkedCount = Array.from(itemCbs).filter(cb => cb.checked).length;
            
            if (checkedCount === total && total > 0) {
                groupHeaderCb.checked = true;
                groupHeaderCb.indeterminate = false;
            } else if (checkedCount > 0 && checkedCount < total) {
                groupHeaderCb.checked = false;
                groupHeaderCb.indeterminate = true;
            } else {
                groupHeaderCb.checked = false;
                groupHeaderCb.indeterminate = false;
            }
        }

        function updateMainMenuState(section) {
            if (!section) return;
            const mainCb = section.querySelector('.select-all-main-menu');
            const sectionCheckboxes = section.querySelectorAll('.permission-checkbox');
            if (!mainCb || sectionCheckboxes.length === 0) return;

            const total = sectionCheckboxes.length;
            const checkedCount = Array.from(sectionCheckboxes).filter(cb => cb.checked).length;

            if (checkedCount === total && total > 0) {
                mainCb.checked = true;
                mainCb.indeterminate = false;
            } else if (checkedCount > 0 && checkedCount < total) {
                mainCb.checked = false;
                mainCb.indeterminate = true;
            } else {
                mainCb.checked = false;
                mainCb.indeterminate = false;
            }
        }

        // Live Search Filter
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();

                document.querySelectorAll('.permission-main-section').forEach(section => {
                    let sectionHasMatch = false;

                    section.querySelectorAll('.sub-group-wrapper').forEach(subGroup => {
                        const groupTitle = subGroup.querySelector('.sub-group-title').textContent.toLowerCase();
                        let subGroupHasMatch = groupTitle.includes(query);

                        subGroup.querySelectorAll('.permission-item').forEach(item => {
                            const labelText = item.textContent.toLowerCase();
                            if (query === '' || labelText.includes(query) || groupTitle.includes(query)) {
                                item.style.display = '';
                                subGroupHasMatch = true;
                            } else {
                                item.style.display = 'none';
                            }
                        });

                        if (query === '' || subGroupHasMatch) {
                            subGroup.style.display = '';
                            sectionHasMatch = true;
                        } else {
                            subGroup.style.display = 'none';
                        }
                    });

                    if (query === '' || sectionHasMatch) {
                        section.style.display = '';
                    } else {
                        section.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush
