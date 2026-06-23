@extends('layouts.app')
@section('titlepage', 'Input Nilai Ekstrakurikuler')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('rapor-siswa.index') }}" class="btn btn-label-secondary btn-icon rounded-circle" style="color: #064e3b; background-color: rgba(6, 78, 59, 0.08);">
                        <i class="ti ti-arrow-left fs-4"></i>
                    </a>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Input Nilai - {{ $ekskul->nama_ekstrakurikuler }}</h4>
                        <p class="text-muted mb-0 small">Koordinator: {{ $ekskul->guru->nama_guru ?? '-' }} | Unit: {{ $ekskul->unit->nama_unit ?? '-' }} | TA: {{ $ekskul->tahunAjaran->tahun_ajaran ?? '-' }}</p>
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
                            <li class="breadcrumb-item active">Nilai Ekstrakurikuler</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-check me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <!-- Panel Tambah Anggota Ekskul (Pilih Kelas & Siswa) -->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-user-plus fs-5"></i>
                <h6 class="card-title mb-0 text-white">Pilih Kelas & Tambah Siswa</h6>
            </div>
            <div class="card-body pt-3">
                <form action="{{ route('rapor-siswa.ekskul.nilai', $ekskul->id) }}" method="GET" class="mb-4">
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Pilih Kelas</label>
                        <select name="kode_kelas" class="form-select border shadow-sm" style="border-color: #cbd5e1 !important;" onchange="this.form.submit()">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($classes as $c)
                                <option value="{{ $c->kode_kelas }}" {{ $selectedKodeKelas == $c->kode_kelas ? 'selected' : '' }}>
                                    Kelas {{ $c->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                @if($selectedKodeKelas)
                    <form action="{{ route('rapor-siswa.ekskul.add-siswa', $ekskul->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="nama_ekskul" value="{{ $ekskul->nama_ekstrakurikuler }}">
                        <div class="form-group mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold text-dark mb-0">Daftar Siswa Kelas</label>
                                <span class="badge" style="background-color: rgba(6, 78, 59, 0.08); color: #064e3b;">{{ $availableStudents->count() }} Belum Terdaftar</span>
                            </div>
                            <div class="checkbox-container-custom" style="max-height: 250px; overflow-y: auto; border: 1px solid #cbd5e1; padding: 10px; border-radius: 8px; background-color: #f8fafc;">
                                @forelse ($availableStudents as $student)
                                    <div class="p-2 rounded border mb-2 d-flex align-items-center gap-2 transition-all hover-bg-item bg-white" style="border-color: #e2e8f0 !important; cursor: pointer;">
                                        <input class="form-check-input ms-0 mt-0" type="checkbox" name="student_ids[]" value="{{ $student->id_siswa }}" id="checkSiswa{{ $student->id_siswa }}" style="width: 17px; height: 17px; accent-color: #064e3b; cursor: pointer;">
                                        <label class="form-check-label text-dark fw-semibold mb-0 small" for="checkSiswa{{ $student->id_siswa }}" style="cursor: pointer; flex: 1; user-select: none;">
                                            {{ $student->nama_lengkap }}
                                        </label>
                                    </div>
                                @empty
                                    <div class="text-center my-4 py-2">
                                        <i class="ti ti-users text-muted fs-2 mb-2 d-block"></i>
                                        <p class="text-muted small mb-0 px-2">Semua siswa kelas ini sudah terdaftar ke ekstrakurikuler ini.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        @if($availableStudents->count() > 0)
                            <button type="submit" class="btn btn-primary w-100 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-user-plus fs-5"></i> Tambahkan Siswa Terpilih
                            </button>
                        @endif
                    </form>
                @else
                    <div class="alert alert-info text-center py-4 my-2 border-0" style="background-color: rgba(6, 78, 59, 0.05); color: #064e3b; border-radius: 8px;">
                        <i class="ti ti-info-circle fs-3 d-block mb-2"></i>
                        <span class="small fw-semibold">Silahkan pilih kelas terlebih dahulu untuk memuat daftar siswa.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .hover-bg-item {
            transition: all 0.2s ease-in-out;
        }
        .hover-bg-item:hover {
            background-color: #ecfdf5 !important;
            border-color: #10b981 !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
    </style>

    <!-- Panel Input Nilai / Siswa yang Terdaftar -->
    <div class="col-lg-8 col-md-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-users fs-5"></i>
                <h6 class="card-title mb-0 text-white">Siswa Mengikuti Ekstrakurikuler & Penilaian</h6>
            </div>
            <div class="card-body p-0">
                <form action="{{ route('rapor-siswa.ekskul.save-nilai', $ekskul->id) }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead style="background-color: #064e3b">
                                <tr>
                                    <th class="text-white py-3" style="width: 50px;">NO</th>
                                    <th class="text-white py-3">NAMA SISWA</th>
                                    <th class="text-white py-3" style="width: 100px;">KELAS</th>
                                    <th class="text-white py-3" style="width: 220px;">NILAI (A-D)</th>
                                    <th class="text-white py-3 text-end" style="width: 60px;">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($enrolledStudents as $index => $enrolled)
                                    <tr>
                                        <td class="py-2">{{ $index + 1 }}</td>
                                        <td class="py-2 fw-bold text-dark">{{ $enrolled->siswa->nama_lengkap }}</td>
                                        <td class="py-2">{{ $enrolled->nama_kelas }}</td>
                                        <td class="py-2">
                                            <select name="nilai[{{ $enrolled->id_siswa }}]" class="form-select select-grade" data-student-id="{{ $enrolled->id_siswa }}">
                                                <option value="A" {{ $enrolled->nilai == 'A' ? 'selected' : '' }}>A (Sangat Baik)</option>
                                                <option value="B" {{ $enrolled->nilai == 'B' ? 'selected' : '' }}>B (Baik)</option>
                                                <option value="C" {{ $enrolled->nilai == 'C' ? 'selected' : '' }}>C (Cukup Baik)</option>
                                                <option value="D" {{ $enrolled->nilai == 'D' ? 'selected' : '' }}>D (Kurang Baik)</option>
                                            </select>
                                            <input type="hidden" name="keterangan[{{ $enrolled->id_siswa }}]" id="remark{{ $enrolled->id_siswa }}" value="{{ $enrolled->keterangan }}">
                                        </td>
                                        <td class="py-2 text-end">
                                            <button type="button" class="btn btn-icon btn-label-danger border btnRemove" data-nilai-id="{{ $enrolled->id }}" style="width: 28px; height: 28px;">
                                                <i class="ti ti-trash fs-6"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center p-5 text-muted">Belum ada siswa yang ditambahkan ke kegiatan ekstrakurikuler ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($enrolledStudents->count() > 0)
                        <div class="p-3 border-top d-flex justify-content-end">
                            <button type="submit" class="btn btn-success d-flex align-items-center gap-1" style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-device-floppy"></i> Simpan Semua Nilai
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Form hidden untuk delete siswa -->
<form id="deleteStudentForm" action="" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('myscript')
<script>
    $(function() {
        var ekskulName = "{{ $ekskul->nama_ekstrakurikuler }}";

        // Auto-change description based on grade selection
        $(document).on('change', '.select-grade', function() {
            var grade = $(this).val();
            var studentId = $(this).data('student-id');
            var desc = '';
            if (grade === 'A') {
                desc = 'Sangat Baik dalam mengikuti kegiatan ' + ekskulName;
            } else if (grade === 'B') {
                desc = 'Baik dalam mengikuti kegiatan ' + ekskulName;
            } else if (grade === 'C') {
                desc = 'Cukup Baik dalam mengikuti kegiatan ' + ekskulName;
            } else if (grade === 'D') {
                desc = 'Kurang Baik dalam mengikuti kegiatan ' + ekskulName;
            }
            $('#remark' + studentId).val(desc);
        });

        // Delete Confirm
        $(document).on('click', '.btnRemove', function(e) {
            e.preventDefault();
            var id = $(this).data('nilai-id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Siswa akan dikeluarkan dari kegiatan ekstrakurikuler ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, keluarkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var deleteForm = $('#deleteStudentForm');
                    deleteForm.attr('action', '/rapor-siswa/ekstrakurikuler/nilai/' + id);
                    deleteForm.submit();
                }
            });
        });
    });
</script>
@endpush
