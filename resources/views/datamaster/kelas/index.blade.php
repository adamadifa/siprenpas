@extends('layouts.app')
@section('titlepage', 'Data Kelas')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-layout-grid-add fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Kelas</h4>
                        <p class="text-muted mb-0 small">Manajemen data kelas dan siswa</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-database me-1"></i> Data Master
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-layout-grid-add me-1"></i> Kelas
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-12">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('kelas.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btnCreate"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Kelas</span>
                </button>
            @endcan
        </div>

        <!-- Filter Form -->
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('kelas.index') }}" method="get" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <x-input-with-icon label="" value="{{ Request('nama_kelas_search') }}" name="nama_kelas_search"
                                placeholder="Cari Nama Kelas" icon="ti ti-search" />
                        </div>
                        @if (auth()->user()->kode_unit == 'U06')
                            <div class="col-md-2 col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="ti ti-school text-muted"></i></span>
                                        <select name="kode_unit_search" id="kode_unit_search" class="form-select">
                                            <option value="">Semua Unit</option>
                                            @foreach ($unit as $d)
                                                <option value="{{ $d->kode_unit }}" {{ Request('kode_unit_search') == $d->kode_unit ? 'selected' : '' }}>
                                                    {{ $d->nama_unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-3 col-12">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-user text-muted"></i></span>
                                    <select name="guru_id_search" id="guru_id_search" class="form-select">
                                        <option value="">Semua Wali Kelas</option>
                                        @foreach ($wali_kelas_list as $wkl)
                                            <option value="{{ $wkl->id }}" {{ Request('guru_id_search') == $wkl->id ? 'selected' : '' }}>
                                                {{ $wkl->nama_guru }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ti ti-calendar-event text-muted"></i></span>
                                    <select name="kode_ta" id="kode_ta" class="form-select">
                                        <option value="">Tahun Ajaran</option>
                                        @foreach ($tahunajaran as $d)
                                            <option value="{{ $d->kode_ta }}"
                                                {{ (Request::get('kode_ta') == $d->kode_ta ? 'selected' : $kode_ta == $d->kode_ta) ? 'selected' : '' }}>
                                                {{ $d->tahun_ajaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b; height: 38px;">
                                    <i class="ti ti-search fs-5"></i>
                                    <span>Filter</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Kelas</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">KODE</th>
                                <th class="text-white py-3">KELAS</th>
                                <th class="text-white py-3">TINGKAT</th>
                                <th class="text-white py-3">UNIT</th>
                                <th class="text-white py-3">WALI KELAS</th>
                                <th class="text-white py-3">TAHUN AJARAN</th>
                                <th class="text-white py-3 text-end" style="width: 120px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kelas as $d)
                                <tr>
                                    <td class="py-2"><span class="fw-bold">{{ $d->kode_kelas }}</span></td>
                                    <td class="py-2">{{ $d->nama_kelas }}</td>
                                    <td class="py-2 text-center">
                                        <span class="badge bg-label-info">Tingkat {{ $d->tingkat }}</span>
                                    </td>
                                    <td class="py-2">{{ $d->nama_unit }}</td>
                                    <td class="py-2">
                                        @if ($d->waliKelas)
                                            <span class="fw-bold text-dark">{{ $d->waliKelas->nama_guru }}</span>
                                        @else
                                            <span class="text-muted small">Belum Ditentukan</span>
                                        @endif
                                    </td>
                                    <td class="py-2">{{ $d->tahun_ajaran }}</td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('kelas.edit')
                                                <a href="#" class="btn btn-icon btn-label-success border btnEdit"
                                                    style="width: 28px; height: 28px;"
                                                    kode_kelas="{{ Crypt::encrypt($d->kode_kelas) }}"
                                                    kode_unit="{{ $d->kode_unit }}"
                                                    tingkat="{{ $d->tingkat }}">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('kelas.edit')
                                                <a href="{{ route('kelas.setkelas', Crypt::encrypt($d->kode_kelas)) }}"
                                                    class="btn btn-icon btn-label-info border btnSetkelas"
                                                    style="width: 28px; height: 28px;">
                                                    <i class="ti ti-user-plus fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('kelas.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('kelas.delete', Crypt::encrypt($d->kode_kelas)) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="btn btn-icon btn-label-danger border delete-confirm"
                                                        style="width: 28px; height: 28px;">
                                                        <i class="ti ti-trash fs-6"></i>
                                                    </a>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-layout-grid fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Kelas</h5>
                                        <p class="text-muted small">Silahkan tambah data baru atau sesuaikan filter pencarian.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="modal" size="" show="loadmodal" title="" />
@endsection

@push('myscript')
<script>
    // Helper untuk validasi field
    function validateField(id, errorMsg) {
        const el = document.getElementById(id);
        const errorEl = document.getElementById('error-' + id);
        if (el) {
            if (!el.value.trim()) {
                el.classList.add('is-invalid');
                if (errorEl) {
                    errorEl.style.display = 'block';
                    errorEl.innerText = errorMsg;
                }
                return false;
            } else {
                el.classList.remove('is-invalid');
                if (errorEl) {
                    errorEl.style.display = 'none';
                    errorEl.innerText = '';
                }
                return true;
            }
        }
        return true;
    }

    // Ambil input dari komponen x-input-with-icon
    function getInputByName(name) {
        return document.querySelector('[name="' + name + '"]');
    }

    // Inisialisasi validasi form kelas (bisa dipanggil ulang setelah load modal)
    function initKelasFormValidation() {
        const kelasInput = getInputByName('nama_kelas');
        const kodeUnitInput = getInputByName('kode_unit');
        const tingkatInput = document.getElementById('tingkat');
        const formKelas = document.getElementById('formKelas');

        if (!formKelas) return;

        // Agar tidak double event, remove event listener sebelumnya
        formKelas.onsubmit = null;
        if (kelasInput) kelasInput.oninput = null;
        if (kodeUnitInput) kodeUnitInput.onchange = null;
        if (tingkatInput) tingkatInput.onchange = null;

        if (kelasInput) {
            kelasInput.addEventListener('input', function() {
                validateField('nama_kelas', 'Kelas wajib diisi');
            });
        }
        if (kodeUnitInput) {
            kodeUnitInput.addEventListener('change', function() {
                validateField('kode_unit', 'Unit wajib dipilih');
            });
        }
        if (tingkatInput) {
            tingkatInput.addEventListener('change', function() {
                validateField('tingkat', 'Tingkat wajib dipilih');
            });
        }
        formKelas.addEventListener('submit', function(e) {
            let valid = true;
            if (!validateField('nama_kelas', 'Kelas wajib diisi')) valid = false;
            if (!validateField('kode_unit', 'Unit wajib dipilih')) valid = false;
            if (!validateField('tingkat', 'Tingkat wajib dipilih')) valid = false;
            if (!valid) e.preventDefault();
        });
    }
</script>

<script>
    $(function() {
        function getTingkatByUnit(kode_unit, selected = '') {
            $.ajax({
                type: "POST",
                url: "{{ route('unit.gettingkatbyunit') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    selected: selected
                },
                success: function(respond) {
                    $(document).find("#tingkat").html(respond);
                }
            });
        }

        function getGuruByUnit(kode_unit, selected = '') {
            $.ajax({
                type: "POST",
                url: "{{ route('unit.getgurubyunit') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    selected: selected
                },
                success: function(respond) {
                    $(document).find("#guru_id").html(respond);
                }
            });
        }

        $(document).on('change', '#kode_unit', function() {
            const kode_unit = $(this).val();
            getTingkatByUnit(kode_unit);
            if (kode_unit) {
                $('#wali_kelas_group').slideDown();
                getGuruByUnit(kode_unit);
            } else {
                $('#wali_kelas_group').slideUp();
                $('#guru_id').html('<option value="">Pilih Wali Kelas</option>');
            }
        });

        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#modal').modal("show");
            $(".modal-title").text("Tambah Data Kelas " + "{{ $ta_aktif ?? '' }}");
            $("#loadmodal").load("{{ route('kelas.create') }}", function() {
                initKelasFormValidation();
            });
        });

        $(document).on('click', '.btnEdit', function(e) {
            e.preventDefault();
            const kode_kelas = $(this).attr('kode_kelas');
            const kode_unit = $(this).attr('kode_unit');
            const tingkat = $(this).attr('tingkat');

            $('#modal').modal("show");
            $(".modal-title").text("Edit Data Kelas");
            $("#loadmodal").load(`/kelas/${kode_kelas}/edit`, function() {
                initKelasFormValidation();
                getTingkatByUnit(kode_unit, tingkat);
            });
        });

        // Delete Confirm
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data kelas dan siswa di dalamnya akan terpengaruh!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
