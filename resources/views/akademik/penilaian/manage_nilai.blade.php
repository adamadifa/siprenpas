@extends('layouts.app')
@section('titlepage', 'Input Nilai ' . ucfirst(strtolower($kategori)))

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-notebook fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Input Nilai {{ ucfirst(strtolower($kategori)) }}</h4>
                        <p class="text-muted mb-0 small">Penginputan nilai {{ strtolower($kategori) }} per lingkup materi</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-school me-1"></i> Akademik
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('penilaian.index', \App\Models\JadwalPelajaran::where('kode_kelas', $bobot->kode_kelas)->where('mata_pelajaran_id', $bobot->mata_pelajaran_id)->first()->id ?? '#') }}" class="text-muted">
                                    Penilaian
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-edit me-1"></i> Input Nilai
                            </li>
                        </ol>
                    </nav>
                    <a href="{{ route('penilaian.index', \App\Models\JadwalPelajaran::where('kode_kelas', $bobot->kode_kelas)->where('mata_pelajaran_id', $bobot->mata_pelajaran_id)->first()->id ?? '#') }}" class="btn btn-label-secondary d-flex align-items-center gap-2 shadow-sm">
                        <i class="ti ti-arrow-left fs-5"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <!-- Main Content Area -->
    <div class="col-12 mb-3">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 8px;">
            <!-- Dark Green Header -->
            <div class="card-header p-3 d-flex justify-content-between align-items-center" style="background-color: #104e30; color: white;">
                <div class="d-flex align-items-center">
                    <i class="ti ti-notebook me-2"></i>
                    <div>
                        <h6 class="mb-0 fw-bold text-white small text-uppercase" style="letter-spacing: 1px;">Nilai {{ ucfirst(strtolower($kategori)) }} Lingkup Materi</h6>
                        <small class="text-white-50" style="font-size: 0.7rem;">{{ $bobot->mapel->nama_matpel ?? '-' }} | {{ $bobot->kelas->nama_kelas ?? '-' }}</small>
                    </div>
                </div>
                <div class="d-flex gap-1">
                     <button type="button" class="btn btn-primary btn-sm px-3" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#mdlAddColumn"><i class="ti ti-plus me-1"></i> Tambah</button>
                     <button type="button" class="btn btn-success btn-sm px-3" style="font-size: 0.75rem;" onclick="alert('Fitur Upload sedang dikembangkan')"><i class="ti ti-upload me-1"></i> Upload</button>
                     <button type="button" class="btn btn-warning btn-sm px-3 text-white" style="font-size: 0.75rem;" onclick="alert('Fitur Export sedang dikembangkan')"><i class="ti ti-download me-1"></i> Export</button>
                </div>
            </div>

            <div class="card-body p-0">
                <!-- Modern & Unified Search Bar Section -->
                <div class="p-3 d-flex justify-content-end" style="background-color: #104e30; border-top: 1px solid rgba(255,255,255,0.1);">
                     <div class="position-relative" style="width: 300px;">
                        <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                            <i class="ti ti-search fs-5"></i>
                        </span>
                        <input type="text" id="searchInput" 
                            class="form-control form-control-sm ps-5 border-0 shadow-sm transition-all rounded-pill" 
                            placeholder="Cari nama atau NIS..." 
                            style="background-color: rgba(255,255,255,0.95); height: 38px;">
                    </div>
                </div>

                <form action="{{ route('penilaian.store-multi-nilai') }}" method="POST">
                    @csrf
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0 align-middle" id="nilaiTable" style="font-size: 0.8rem;">
                            <thead style="background-color: #0b3d24; color: white;">
                                <tr>
                                    <th width="5%" class="text-center py-2 text-uppercase font-weight-bold text-white" style="font-size: 0.7rem; letter-spacing: 0.5px;" rowspan="2">No</th>
                                    <th width="12%" class="py-2 text-uppercase font-weight-bold text-white" style="font-size: 0.7rem; letter-spacing: 0.5px;" rowspan="2">NIS</th>
                                    <th class="py-2 text-uppercase font-weight-bold text-white" style="font-size: 0.7rem; letter-spacing: 0.5px;" rowspan="2">Nama Lengkap</th>
                                    <th width="5%" class="text-center py-2 text-uppercase font-weight-bold text-white" style="font-size: 0.7rem; letter-spacing: 0.5px;" rowspan="2">L/P</th>
                                    <th class="text-center py-2 text-uppercase font-weight-bold text-white border-bottom-0" style="font-size: 0.7rem; letter-spacing: 0.5px;" colspan="{{ $rencanaPenilaian->count() }}">Input Nilai</th>
                                </tr>
                                <tr>
                                    @foreach ($rencanaPenilaian as $rencana)
                                        <th class="text-center py-2 text-white" style="background-color: #0b3d24; min-width: 80px; font-size: 0.65rem;">
                                            <div class="d-flex flex-column text-uppercase fw-bold">
                                                <span>{{ $rencana->kode_penilaian }}</span>
                                                <small class="text-white-50" style="font-size: 8px;">{{ $rencana->nama_penilaian }}</small>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $index => $student)
                                    <tr class="text-secondary">
                                        <td class="text-center py-2">{{ $index + 1 }}</td>
                                        <td class="fw-bold text-dark py-2">{{ $student->nis }}</td>
                                        <td class="fw-bold text-dark py-2">{{ $student->nama_lengkap }}</td>
                                        <td class="text-center py-2">{{ $student->jenis_kelamin }}</td>
                                        @foreach ($rencanaPenilaian as $rencana)
                                            <td class="p-1">
                                                @php
                                                    $score = $mappedGrades[$student->id_siswa][$rencana->id] ?? '';
                                                @endphp
                                                <input type="number" step="0.01" min="0" max="100" 
                                                    name="nilai[{{ $student->id_siswa }}][{{ $rencana->id }}]" 
                                                    class="form-control form-control-sm border-0 text-center fw-bold {{ $score !== '' ? ($score < 75 ? 'text-danger' : 'text-success') : '' }}" 
                                                    value="{{ $score }}" placeholder="-">
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ 4 + $rencanaPenilaian->count() }}" class="text-center text-muted py-3">Tidak ada data siswa.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Save Button -->
                    <div class="p-3 border-top text-end bg-light sticky-bottom shadow-sm">
                         <small class="text-muted me-3 fst-italic">Pastikan menekan tombol simpan setelah mengubah nilai.</small>
                        <button type="submit" class="btn btn-success px-4"><i class="ti ti-device-floppy me-1"></i> Simpan Semua Nilai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Column (Rencana) -->
<div class="modal fade" id="mdlAddColumn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #104e30;">
                <h5 class="modal-title text-white">Tambah Penilaian {{ ucfirst(strtolower($kategori)) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
             <form action="{{ route('penilaian.store-rencana') }}" method="POST">
                @csrf
                <input type="hidden" name="bobot_penilaian_id" value="{{ $bobot->id }}">
                <input type="hidden" name="kategori_penilaian" value="{{ $kategori }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode (Singkatan)</label>
                        <input type="text" name="kode_penilaian" class="form-control" placeholder="{{ $kategori == 'SUMATIF' ? 'PH...' : 'SAS' }}" required>
                         <small class="text-muted">Contoh: PH1, PH2, UTS, UAS</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Materi / Keterangan</label>
                        <input type="text" name="nama_penilaian" class="form-control" placeholder="Contoh: Bab 1 Bilangan Bulat" required>
                    </div>
                     <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal_penilaian" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('myscript')
<script>
    $(document).ready(function(){
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#nilaiTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endpush
@endsection
