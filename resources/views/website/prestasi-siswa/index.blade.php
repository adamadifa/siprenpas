@extends('layouts.app')
@section('titlepage', 'Prestasi Siswa')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-trophy fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Prestasi Siswa</h4>
                        <p class="text-muted mb-0 small">Manajemen data prestasi dan penghargaan siswa</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-home-2 me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-trophy me-1"></i> Prestasi Siswa
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('prestasisiswa.create')
                <a href="{{ route('prestasisiswa.create') }}" class="btn d-flex align-items-center gap-2 shadow-sm text-white"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Tambah Prestasi Siswa</span>
                </a>
            @endcan
        </div>

        <!-- Filter Section -->
        <style>
            .form-filter .form-group {
                margin-bottom: 0 !important;
            }
        </style>
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('prestasisiswa.index') }}" class="form-filter">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-8 col-md-7">
                            <x-input-with-icon label="" value="{{ Request('nama_siswa') }}" name="nama_siswa"
                                placeholder="Cari Nama Siswa" icon="ti ti-user" />
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <select name="kode_unit" id="kode_unit_search" class="form-select border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Semua Unit</option>
                                    @foreach ($unit as $u)
                                        <option value="{{ $u->kode_unit }}" {{ Request('kode_unit') == $u->kode_unit ? 'selected' : '' }}>
                                            {{ $u->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-2">
                            <button type="submit" class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center"
                                style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search fs-5"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-trophy fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Prestasi Siswa</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" style="width: 1%;">NO.</th>
                                <th class="text-white py-3 text-center" style="width: 80px;">FOTO</th>
                                <th class="text-white py-3">NAMA SISWA</th>
                                <th class="text-white py-3">UNIT</th>
                                <th class="text-white py-3">PRESTASI</th>
                                <th class="text-white py-3 text-center">TINGKAT</th>
                                <th class="text-white py-3 text-center">STATUS</th>
                                <th class="text-white py-3 text-end" style="width: 80px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($prestasiSiswa as $d)
                                <tr>
                                    <td class="py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2 text-center">
                                        <div class="avatar avatar-lg rounded overflow-hidden border bg-white p-1 shadow-sm mx-auto" style="width: 50px; height: 50px;">
                                            @if ($d->foto && Storage::disk('public')->exists('prestasi-siswa/' . $d->foto))
                                                <img src="{{ asset('storage/prestasi-siswa/' . $d->foto) }}" alt="{{ $d->nama_siswa }}" style="object-fit: cover; width: 100%; height: 100%;">
                                            @else
                                                <div class="bg-label-success d-flex align-items-center justify-content-center h-100 w-100">
                                                    <i class="ti ti-user fs-3"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-2 fw-bold text-dark">{{ $d->nama_siswa }}</td>
                                    <td class="py-2">
                                        @if ($d->unit)
                                            <span class="badge bg-label-primary">{{ $d->unit->nama_unit }}</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="py-2">
                                        <div class="small text-muted text-wrap" style="max-width: 250px;">{{ $d->prestasi }}</div>
                                    </td>
                                    <td class="py-2 text-center">
                                        @if ($d->tingkat == 'nasional')
                                            <span class="badge bg-label-danger">{{ ucfirst($d->tingkat) }}</span>
                                        @elseif ($d->tingkat == 'kabupaten')
                                            <span class="badge bg-label-warning">{{ ucfirst($d->tingkat) }}</span>
                                        @else
                                            <span class="badge bg-label-info">{{ ucfirst($d->tingkat) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-center">
                                        @if ($d->status)
                                            <span class="badge bg-label-success">Aktif</span>
                                        @else
                                            <span class="badge bg-label-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('prestasisiswa.edit')
                                                <a href="{{ route('prestasisiswa.edit', $d->id) }}"
                                                    class="btn btn-icon btn-label-success border"
                                                    style="width: 28px; height: 28px;">
                                                    <i class="ti ti-edit fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('prestasisiswa.delete')
                                                <form method="POST" name="deleteform" class="deleteform"
                                                    action="{{ route('prestasisiswa.destroy', $d->id) }}">
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
                                    <td colspan="8" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-trophy fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Belum Ada Data Prestasi</h5>
                                        <p class="text-muted">Silahkan tambah data prestasi siswa baru.</p>
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
@endsection

@push('myscript')
<script>
    $(function() {
        $(".delete-confirm").click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
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
