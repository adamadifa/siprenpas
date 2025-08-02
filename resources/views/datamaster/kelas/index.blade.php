@extends('layouts.app')
@section('titlepage', 'Kelas')

@section('content')
@section('navigasi')
    <span>Kelas</span>
@endsection
<div class="row">
    <div class="col-lg-8 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('kelas.create')
                    <a href="#" class="btn btn-primary" id="btnCreate"><i class="fa fa-plus me-2"></i>Tambah Kelas</a>
                @endcan
            </div>
            <div class="card-body">
                <form action="{{ route('kelas.index') }}" method="get">
                    <div class="row">
                        <div class="col-lg-5 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <select name="kode_unit_search" id="kode_unit_search" class="form-select">
                                    <option value="">Pilih Unit</option>
                                    @foreach ($unit as $d)
                                        <option value="{{ $d->kode_unit }}">{{ $d->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-5 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <select name="kode_ta" id="kode_ta" class="form-select">
                                    <option value="">Pilih Tahun Ajaran</option>
                                    @foreach ($tahunajaran as $d)
                                        <option value="{{ $d->kode_ta }}"
                                            {{ (Request::get('kode_ta') == $d->kode_ta ? 'selected' : $kode_ta == $d->kode_ta) ? 'selected' : '' }}>
                                            {{ $d->tahun_ajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-primary" id="btnFilter"><i class="ti ti-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Kelas</th>
                                        <th>Tingkat</th>
                                        <th>Unit</th>
                                        <th>Tahun Ajaran</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas as $d)
                                        <tr>
                                            <td>{{ $d->kode_kelas }}</td>
                                            <td>{{ $d->nama_kelas }}</td>
                                            <td>{{ $d->tingkat }}</td>
                                            <td>{{ $d->nama_unit }}</td>
                                            <td>{{ $d->tahun_ajaran }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @can('kelas.edit')
                                                        <div>
                                                            <a href="#" class="me-2 btnEdit"
                                                                kode_kelas="{{ Crypt::encrypt($d->kode_kelas) }}"
                                                                kode_unit="{{ $d->kode_unit }}"
                                                                tingkat="{{ $d->tingkat }}">
                                                                <i class="ti ti-edit text-success"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @can('kelas.edit')
                                                        <div>
                                                            <a href="{{ route('kelas.setkelas', Crypt::encrypt($d->kode_kelas)) }}"
                                                                class="me-2 btnSetkelas">
                                                                <i class="ti ti-user-plus text-info"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @can('kelas.delete')
                                                        <div>
                                                            <form method="POST" name="deleteform" class="deleteform"
                                                                action="{{ route('kelas.delete', Crypt::encrypt($d->kode_kelas)) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a href="#" class="delete-confirm ml-1">
                                                                    <i class="ti ti-trash text-danger"></i>
                                                                </a>
                                                            </form>
                                                        </div>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="modal" size="" show="loadmodal" title="" />
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}

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
        $(document).on('change', '#kode_unit', function() {
            const kode_unit = $(this).val();
            getTingkatByUnit(kode_unit);
        });



        $("#btnCreate").click(function(e) {
            e.preventDefault();
            $('#modal').modal("show");
            $(".modal-title").text("Tambah Data Kelas " + "{{ $ta_aktif }}");
            $("#loadmodal").load("{{ route('kelas.create') }}", function() {
                // Panggil validasi setelah form selesai dimuat
                initKelasFormValidation();

            });
        });

        $(document).on('click', '.btnEdit', function(e) {
            e.preventDefault();
            const kode_kelas = $(this).attr('kode_kelas');
            const kode_unit = $(this).attr('kode_unit');
            //alert(kode_unit);
            const tingkat = $(this).attr('tingkat');

            $('#modal').modal("show");
            $(".modal-title").text("Edit Data Kelas");
            $("#loadmodal").load(`/kelas/${kode_kelas}/edit`, function() {
                // Panggil validasi setelah form selesai dimuat
                initKelasFormValidation();
                getTingkatByUnit(kode_unit, tingkat);
            });
        });
    });
</script>
@endpush
