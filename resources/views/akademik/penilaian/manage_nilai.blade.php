@extends('layouts.app')
@section('titlepage', 'Input Nilai ' . ucfirst(strtolower($kategori)))

@section('content')
@section('navigasi')
    <span>Input Nilai {{ ucfirst(strtolower($kategori)) }}</span>
@endsection

<div class="row">
    <!-- Header Context -->
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-body p-3 d-flex justify-content-between align-items-center">
                <div>
                     <h5 class="mb-0 fw-bold">Nilai {{ ucfirst(strtolower($kategori)) }} Lingkup Materi</h5>
                     <small class="text-muted">{{ $bobot->mapel->nama_matpel ?? '-' }} | {{ $bobot->kelas->nama_kelas ?? '-' }}</small>
                </div>
                <div>
                     {{-- Back to Index --}}
                     <a href="{{ route('penilaian.index', \App\Models\JadwalPelajaran::where('kode_kelas', $bobot->kode_kelas)->where('mata_pelajaran_id', $bobot->mata_pelajaran_id)->first()->id ?? '#') }}" class="btn btn-danger btn-sm text-white"><i class="ti ti-arrow-left me-1"></i> Kembali</a>
                     
                     {{-- Tambah Column Button --}}
                     <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#mdlAddColumn"><i class="ti ti-plus me-1"></i> Tambah</button>
                     <button type="button" class="btn btn-success btn-sm"><i class="ti ti-upload me-1"></i> Upload</button>
                     <button type="button" class="btn btn-warning btn-sm text-white"><i class="ti ti-download me-1"></i> Export</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Search Bar -->
    <div class="col-12 mb-2 text-end">
        <div class="d-inline-block" style="width: 250px;">
             <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search data...">
        </div>
    </div>

    <!-- Form Input Nilai Multi-Column -->
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <form action="{{ route('penilaian.store-multi-nilai') }}" method="POST">
                    @csrf
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0" id="nilaiTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%" class="text-center align-middle" rowspan="2">No</th>
                                    <th width="15%" class="align-middle" rowspan="2">NISN</th>
                                    <th class="align-middle" rowspan="2">Nama</th>
                                    <th width="5%" class="text-center align-middle" rowspan="2">L/P</th>
                                    <th class="text-center" colspan="{{ $rencanaPenilaian->count() }}">Nilai</th>
                                </tr>
                                <tr>
                                    @foreach ($rencanaPenilaian as $rencana)
                                        <th class="text-center bg-white" style="min-width: 80px;">
                                            <div class="d-flex flex-column">
                                                <span>{{ $rencana->kode_penilaian }}</span>
                                                {{-- Optional: Edit/Delete Rencana trigger --}}
                                                <small style="font-size: 9px;" class="text-muted">{{ $rencana->nama_penilaian }}</small>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $index => $student)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $student->nis }}</td>
                                        <td>{{ $student->nama_lengkap }}</td>
                                        <td class="text-center">{{ $student->jenis_kelamin }}</td>
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
                    <div class="p-3 border-top text-end bg-light sticky-bottom">
                         <small class="text-muted me-3 fst-italic">Pastikan menekan tombol simpan setelah mengubah nilai.</small>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Simpan Semua Nilai</button>
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
            <div class="modal-header bg-primary text-white">
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
