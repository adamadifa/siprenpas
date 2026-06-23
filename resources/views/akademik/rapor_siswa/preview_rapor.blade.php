@extends('layouts.app')
@section('titlepage', 'Preview & Cetak Rapor')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('rapor-siswa.show', $kelas->kode_kelas ?? '') }}" class="btn btn-label-secondary btn-icon rounded-circle" style="color: #064e3b; background-color: rgba(6, 78, 59, 0.08);">
                        <i class="ti ti-arrow-left fs-4"></i>
                    </a>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Cetak Rapor - {{ $siswa->nama_lengkap }}</h4>
                        <p class="text-muted mb-0 small">Halaman Cetak Rapor Siswa dalam Format PDF</p>
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
                                <a href="{{ route('rapor-siswa.index') }}" class="text-muted">Rapor Siswa</a>
                            </li>
                            <li class="breadcrumb-item active">Preview & Cetak</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<form action="{{ route('rapor-siswa.pdf', Crypt::encrypt($pendaftaran->no_pendaftaran)) }}" method="POST" target="_blank">
    @csrf
    <div class="row">
        <!-- Setup Form -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="m-0 fw-bold" style="color: #064e3b"><i class="ti ti-user me-1"></i> Informasi Siswa</h5>
                </div>
                <div class="card-body pt-3">
                    <table class="table table-borderless table-sm mb-4">
                        <tr>
                            <td class="fw-semibold text-muted" style="width: 120px;">Nama Lengkap</td>
                            <td style="width: 10px;">:</td>
                            <td class="fw-bold text-dark">{{ strtoupper($siswa->nama_lengkap) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">NIS / NISN</td>
                            <td>:</td>
                            <td>{{ $pendaftaran->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">Kelas</td>
                            <td>:</td>
                            <td>{{ $kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">Tahun Ajaran</td>
                            <td>:</td>
                            <td>{{ $activeTa->tahun_ajaran ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">Semester</td>
                            <td>:</td>
                            <td>{{ ($activeSemester->semester ?? 1) == 1 ? 'Ganjil (1)' : 'Genap (2)' }}</td>
                        </tr>
                    </table>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b">
                        <i class="ti ti-printer fs-4"></i>
                        <span>Cetak & Unduh Rapor PDF</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Grade Preview Panel (Read-Only) -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="m-0 fw-bold" style="color: #064e3b"><i class="ti ti-table me-1"></i> Preview Nilai Akademik (Read-Only)</h5>
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive" style="max-height: 550px; overflow-y: auto;">
                        <table class="table table-sm table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th class="text-center" style="width: 80px;">Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1; @endphp
                                @foreach ($subjects as $mapel)
                                    @if ($mapel->children->count() > 0)
                                        <tr class="table-secondary fw-semibold">
                                            <td colspan="2">{{ $index++ }}. {{ $mapel->nama_matpel }}</td>
                                        </tr>
                                        @foreach ($mapel->children as $child)
                                            <tr>
                                                <td class="ps-4">{{ $child->nama_matpel }}</td>
                                                <td class="text-center fw-bold">{{ $child->grade->nilai_rapor }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>{{ $index++ }}. {{ $mapel->nama_matpel }}</td>
                                            <td class="text-center fw-bold">{{ $mapel->grade->nilai_rapor }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
