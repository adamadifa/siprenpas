@extends('layouts.mobile.app_sipren')

@section('title', 'Input Nilai Ekskul - Sipren')
@section('header-title', 'Nilai Ekstrakurikuler')
@section('show-bottom-nav', true)

@push('styles')
    <style>
        .ekskul-container {
            padding: 16px;
            padding-bottom: 80px;
        }

        /* Info Card */
        .info-card {
            background: var(--primary);
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(6, 78, 59, 0.12);
            padding: 16px;
            color: #ffffff;
            border: none;
        }

        .info-badge {
            font-size: 0.65rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.16);
            padding: 4px 8px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 6px;
            letter-spacing: 0.02em;
        }

        .info-card h3 {
            font-size: 1.15rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            line-height: 1.3;
        }

        .info-meta-list {
            margin-top: 12px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 10px;
            padding: 12px;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.78rem;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 8px;
        }

        .meta-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .meta-label {
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
        }

        .meta-val {
            font-weight: 700;
            color: #ffffff;
        }

        /* Section Heading */
        .section-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: block;
            margin-top: 24px;
            margin-bottom: 10px;
        }

        /* Form Controls */
        .select-class-control {
            border: 1.5px solid var(--border-color) !important;
            border-radius: 10px !important;
            font-size: 0.85rem !important;
            padding: 10px !important;
            color: var(--text-main) !important;
            font-weight: 600;
            background-color: var(--surface) !important;
            width: 100% !important;
        }

        /* Student Selection List */
        .student-checkbox-list {
            max-height: 200px;
            overflow-y: auto;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            padding: 12px;
            background: var(--surface);
        }

        .student-check-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .student-check-item:last-child {
            margin-bottom: 0;
        }

        .student-check-item input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
        }

        .student-check-item label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 0;
            cursor: pointer;
        }

        /* Student Card */
        .student-card {
            background: var(--surface);
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(6, 78, 59, 0.04);
            padding: 14px;
            margin-bottom: 12px;
        }

        .student-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .student-name-text {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
        }

        .student-badge-class {
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--primary);
            background: rgba(6, 78, 59, 0.08);
            padding: 2px 8px;
            border-radius: 6px;
        }

        .select-grade-mobile {
            border: 1.5px solid var(--border-color) !important;
            border-radius: 8px !important;
            font-size: 0.8rem !important;
            padding: 8px !important;
            font-weight: 700 !important;
            color: var(--text-main) !important;
            background-color: #f8fafc !important;
            margin-bottom: 8px;
        }

        .input-remark-mobile {
            border: 1.5px solid var(--border-color) !important;
            border-radius: 8px !important;
            font-size: 0.78rem !important;
            padding: 8px 10px !important;
            font-weight: 500 !important;
            color: var(--text-main) !important;
            background-color: #f8fafc !important;
        }

        .btn-remove-student {
            background: rgba(239, 68, 68, 0.08);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.15);
            border-radius: 8px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.2s ease;
        }

        .btn-remove-student:active {
            transform: scale(0.9);
            background: rgba(239, 68, 68, 0.16);
        }

        /* Fixed Bottom Action Bar */
        .bottom-action-bar {
            position: fixed;
            bottom: max(60px, env(safe-area-inset-bottom));
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 480px;
            background: var(--surface);
            border-top: 1.5px solid var(--border-color);
            padding: 12px 16px;
            z-index: 999;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.03);
        }

        .btn-save-mobile {
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: #ffffff !important;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 12px;
            border-radius: 10px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2);
        }

        .btn-save-mobile:active {
            transform: translateY(1px);
        }
    </style>
@endpush

@section('content')
    <div class="ekskul-container">
        <!-- Panel 1: Info Ekskul -->
        <div class="info-card mb-3">
            <span class="info-badge">Ekstrakurikuler</span>
            <h3>{{ $ekskul->nama_ekstrakurikuler }}</h3>
            <div class="info-meta-list">
                <div class="meta-row">
                    <span class="meta-label">Koordinator</span>
                    <span class="meta-val">{{ $ekskul->guru->nama_guru ?? '-' }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Unit</span>
                    <span class="meta-val">{{ $ekskul->unit->nama_unit ?? '-' }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Tahun Ajaran</span>
                    <span class="meta-val">{{ $ekskul->tahunAjaran->tahun_ajaran ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Panel 2: Pilih Kelas & Tambah Siswa -->
        <span class="section-label">Pilih Kelas & Siswa</span>
        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; background: var(--surface);">
            <div class="card-body p-3">
                <form action="{{ route('rapor-siswa.ekskul.nilai', $ekskul->id) }}" method="GET" id="formSelectKelas">
                    <div class="form-group mb-3">
                        <select name="kode_kelas" class="form-select select-class-control" onchange="document.getElementById('formSelectKelas').submit();">
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
                            <label class="form-label fw-bold text-dark mb-2" style="font-size: 0.78rem;">Daftar Siswa Kelas</label>
                            <div class="student-checkbox-list">
                                @forelse ($availableStudents as $student)
                                    <div class="student-check-item">
                                        <input type="checkbox" name="student_ids[]" value="{{ $student->id_siswa }}" id="checkSiswa{{ $student->id_siswa }}">
                                        <label for="checkSiswa{{ $student->id_siswa }}">
                                            {{ $student->nama_lengkap }}
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-muted small text-center my-3">Semua siswa kelas ini sudah terdaftar.</p>
                                @endforelse
                            </div>
                        </div>

                        @if($availableStudents->count() > 0)
                            <button type="submit" class="btn btn-save-mobile" style="background: var(--primary);">
                                <ion-icon name="person-add-outline" style="font-size: 16px;"></ion-icon>
                                <span>Tambahkan Siswa</span>
                            </button>
                        @endif
                    </form>
                @else
                    <div class="alert alert-info text-center small my-1 py-2" style="border-radius: 8px;">
                        Silahkan pilih kelas untuk memuat daftar siswa.
                    </div>
                @endif
            </div>
        </div>

        <!-- Panel 3: Input Nilai -->
        <span class="section-label">Daftar Nilai Siswa</span>
        <form action="{{ route('rapor-siswa.ekskul.save-nilai', $ekskul->id) }}" method="POST">
            @csrf
            
            <div id="enrolled-students-list">
                @forelse ($enrolledStudents as $index => $enrolled)
                    <div class="student-card">
                        <!-- Top Info -->
                        <div class="student-card-header">
                            <div>
                                <h4 class="student-name-text">{{ $enrolled->siswa->nama_lengkap }}</h4>
                                <span class="student-id" style="font-size: 0.7rem; color: var(--text-muted);">ID: {{ $enrolled->id_siswa }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="student-badge-class">{{ $enrolled->nama_kelas }}</span>
                                <button type="button" class="btn-remove-student btnRemove" data-nilai-id="{{ $enrolled->id }}">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </button>
                            </div>
                        </div>

                        <!-- Grading Inputs -->
                        <div class="d-flex flex-column gap-2">
                            <select name="nilai[{{ $enrolled->id_siswa }}]" class="form-select select-grade-mobile" data-student-id="{{ $enrolled->id_siswa }}">
                                <option value="A" {{ $enrolled->nilai == 'A' ? 'selected' : '' }}>A (Sangat Baik)</option>
                                <option value="B" {{ $enrolled->nilai == 'B' ? 'selected' : '' }}>B (Baik)</option>
                                <option value="C" {{ $enrolled->nilai == 'C' ? 'selected' : '' }}>C (Cukup Baik)</option>
                                <option value="D" {{ $enrolled->nilai == 'D' ? 'selected' : '' }}>D (Kurang Baik)</option>
                            </select>

                            <input type="text" name="keterangan[{{ $enrolled->id_siswa }}]" id="remark{{ $enrolled->id_siswa }}" class="form-control input-remark-mobile" value="{{ $enrolled->keterangan }}" placeholder="Deskripsi Capaian" required>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <ion-icon name="people-outline"></ion-icon>
                        <h4>Belum ada siswa</h4>
                        <p>Daftarkan siswa untuk memulai penilaian</p>
                    </div>
                @endforelse
            </div>

            <!-- Floating Save Button -->
            @if($enrolledStudents->count() > 0)
                <div class="bottom-action-bar">
                    <button type="submit" class="btn-save-mobile">
                        <ion-icon name="save-outline" style="font-size: 18px;"></ion-icon>
                        <span>Simpan Semua Nilai</span>
                    </button>
                </div>
            @endif
        </form>
    </div>

    <!-- Delete Form -->
    <form id="deleteStudentForm" action="" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('myscript')
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            var ekskulName = "{{ $ekskul->nama_ekstrakurikuler }}";

            // Remark Autofill on Select Change
            $(document).on('change', '.select-grade-mobile', function() {
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

            // Delete Student Confirm
            $(document).on('click', '.btnRemove', function(e) {
                e.preventDefault();
                var id = $(this).data('nilai-id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Siswa akan dikeluarkan dari kegiatan ekstrakurikuler ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#064e3b',
                    cancelButtonColor: '#ef4444',
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
