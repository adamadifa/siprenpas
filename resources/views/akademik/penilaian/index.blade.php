@extends('layouts.app')
@section('titlepage', 'Penilaian Siswa')

@section('content')
@section('navigasi')
    <span>Penilaian Siswa</span>
@endsection

<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('jadwal-pelajaran.index') }}" class="btn btn-secondary btn-sm"><i class="ti ti-arrow-left me-1"></i>Kembali</a>
    </div>

    <!-- Info Context -->
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 text-primary fw-bold">{{ $jadwal->mapel->nama_matpel ?? '-' }}</h5>
                        <p class="mb-0 text-muted">Kelas {{ $jadwal->kelas->nama_kelas ?? '-' }} | {{ $jadwal->guru->nama_guru ?? '-' }}</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-label-info">{{ $jadwal->tahunAjaran->tahun_ajaran ?? '-' }} (Sem. {{ $jadwal->semester??'-' }})</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bobot Penilaian (Collapsible or Small) -->
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-header text-white p-2" data-bs-toggle="collapse" data-bs-target="#collapseBobot" style="cursor: pointer; background-color: #104e30;">
                <h6 class="mb-0 text-white"><i class="ti ti-settings me-1"></i> Konfigurasi Bobot (Klik untuk Buka/Tutup) - Total: {{ $bobot->bobot_sumatif + $bobot->bobot_sas }}%</h6>
            </div>
            <div class="collapse" id="collapseBobot">
                <div class="card-body p-3">
                    <form action="{{ route('penilaian.store-bobot') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $bobot->id }}">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="block text-sm font-bold mb-2">Bobot Sumatif (%)</label>
                                <input type="number" name="bobot_sumatif" class="form-control" value="{{ $bobot->bobot_sumatif }}" min="0" max="100" required>
                            </div>
                            <div class="col-md-5">
                                <label class="block text-sm font-bold mb-2">Bobot SAS (%)</label>
                                <input type="number" name="bobot_sas" class="form-control" value="{{ $bobot->bobot_sas }}" min="0" max="100" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table (Compact Elegant Style) -->
    <div class="col-12 mb-3">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 8px;">
            <!-- Green Card Header -->
            <div class="card-header p-3 d-flex justify-content-between align-items-center" style="background-color: #104e30; color: white;">
                <div class="d-flex align-items-center">
                    <i class="ti ti-users me-2"></i>
                    <h6 class="mb-0 fw-bold text-white small text-uppercase" style="letter-spacing: 1px;">Rekap Nilai Siswa</h6>
                </div>
                <div>
                     <!-- Management Buttons -->
                    <a href="{{ route('penilaian.manage', ['bobot_id' => $bobot->id, 'kategori' => 'SUMATIF']) }}" class="btn btn-primary btn-sm px-3" style="font-size: 0.75rem;">
                        <i class="ti ti-notebook me-1"></i> Sumatif
                    </a>
                    <a href="{{ route('penilaian.manage', ['bobot_id' => $bobot->id, 'kategori' => 'SAS']) }}" class="btn btn-info btn-sm px-3" style="font-size: 0.75rem;">
                        <i class="ti ti-file-certificate me-1"></i> SAS
                    </a>
                    <!-- Kirim Button Placeholder -->
                     <button class="btn btn-success btn-sm px-3" style="font-size: 0.75rem;" onclick="alert('Fitur Kirim Nilai belum tersedia')">
                        <i class="ti ti-send me-1"></i> Kirim
                    </button>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0 align-middle" style="font-size: 0.8rem;">
                        <thead style="background-color: #0b3d24; color: white;">
                            <tr>
                                <th width="5%" class="text-center py-2 text-uppercase font-weight-bold text-white" style="font-size: 0.7rem; letter-spacing: 0.5px;">No</th>
                                <th width="10%" class="py-2 text-uppercase font-weight-bold text-white" style="font-size: 0.7rem; letter-spacing: 0.5px;">NIS</th>
                                <th width="25%" class="py-2 text-uppercase font-weight-bold text-white" style="font-size: 0.7rem; letter-spacing: 0.5px;">Nama Siswa</th>
                                <th width="10%" class="text-center py-2 text-uppercase font-weight-bold text-white" style="font-size: 0.7rem; letter-spacing: 0.5px;">Sumatif</th>
                                <th width="10%" class="text-center py-2 text-uppercase font-weight-bold text-white" style="font-size: 0.7rem; letter-spacing: 0.5px;">Nilai SAS</th>
                                <th width="10%" class="text-center py-2 text-uppercase font-weight-bold text-white" style="font-size: 0.7rem; letter-spacing: 0.5px;">Nilai Rapor</th>
                                <th class="py-2 text-uppercase font-weight-bold text-white" style="font-size: 0.7rem; letter-spacing: 0.5px;">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $index => $student)
                                <tr class="text-secondary">
                                    <td class="text-center py-2">{{ $index + 1 }}</td>
                                    <td class="fw-bold text-dark py-2">{{ $student->nis ?? '-' }}</td>
                                    <td class="fw-bold text-dark py-2">{{ $student->nama_lengkap }}</td>
                                    <td class="text-center text-dark py-2">{{ $student->rata_sumatif }}</td>
                                    <td class="text-center text-dark py-2">{{ $student->nilai_sas }}</td>
                                    <td class="text-center fw-bold py-2" style="color: #0f172a;">{{ $student->nilai_rapor }}</td>
                                    <td class="py-2 text-muted" style="font-size: 0.7rem;">
                                        {{ strip_tags($student->capaian_kompetensi) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">Belum ada data siswa.</td>
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
