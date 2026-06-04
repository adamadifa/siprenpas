@extends('layouts.app')
@section('titlepage', 'Penilaian Siswa')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-clipboard-text fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Penilaian Siswa</h4>
                        <p class="text-muted mb-0 small">Rekapitulasi dan manajemen nilai akademik siswa</p>
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
                            <li class="breadcrumb-item active">
                                <i class="ti ti-clipboard-text me-1"></i> Penilaian
                            </li>
                        </ol>
                    </nav>
                    <a href="{{ route('jadwal-pelajaran.index') }}" class="btn btn-label-secondary d-flex align-items-center gap-2 shadow-sm">
                        <i class="ti ti-arrow-left fs-5"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    {{-- Back button moved to navigasi --}}

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
                                <input type="number" name="bobot_sumatif" class="form-control" value="{{ $bobot->bobot_sumatif }}" min="0" max="100" required {{ ($bobot->status ?? 'draft') == 'terkirim' ? 'disabled' : '' }}>
                            </div>
                            <div class="col-md-5">
                                <label class="block text-sm font-bold mb-2">Bobot SAS (%)</label>
                                <input type="number" name="bobot_sas" class="form-control" value="{{ $bobot->bobot_sas }}" min="0" max="100" required {{ ($bobot->status ?? 'draft') == 'terkirim' ? 'disabled' : '' }}>
                            </div>
                            @if (($bobot->status ?? 'draft') != 'terkirim')
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                                </div>
                            @endif
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
                <div class="d-flex align-items-center gap-2">
                     <!-- Management Buttons -->
                    <a href="{{ route('penilaian.manage', ['bobot_id' => $bobot->id, 'kategori' => 'SUMATIF']) }}" class="btn btn-primary btn-sm px-3" style="font-size: 0.75rem;">
                        <i class="ti ti-notebook me-1"></i> Sumatif
                    </a>
                    <a href="{{ route('penilaian.manage', ['bobot_id' => $bobot->id, 'kategori' => 'SAS']) }}" class="btn btn-info btn-sm px-3" style="font-size: 0.75rem;">
                        <i class="ti ti-file-certificate me-1"></i> SAS
                    </a>
                    
                    @if (($bobot->status ?? 'draft') == 'terkirim')
                        <span class="badge bg-success px-3 py-2 text-uppercase fw-bold" style="font-size: 0.75rem; border-radius: 4px;">
                            <i class="ti ti-check me-1"></i> Terkirim
                        </span>
                    @else
                        <form action="{{ route('penilaian.kirim') }}" method="POST" id="formKirimPenilaian" class="d-inline">
                            @csrf
                            <input type="hidden" name="bobot_id" value="{{ $bobot->id }}">
                            <button type="button" class="btn btn-success btn-sm px-3" style="font-size: 0.75rem;" onclick="confirmKirim()">
                                <i class="ti ti-send me-1"></i> Kirim
                            </button>
                        </form>
                    @endif
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

@push('myscript')
<script>
    function confirmKirim() {
        Swal.fire({
            title: 'Kirim Nilai?',
            text: 'Apakah Anda yakin ingin mengirim dan mengunci nilai? Setelah dikirim, nilai untuk kelas dan mata pelajaran ini tidak dapat diubah kembali.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#064e3b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kirim!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formKirimPenilaian').submit();
            }
        });
    }
</script>
@endpush

@endsection
