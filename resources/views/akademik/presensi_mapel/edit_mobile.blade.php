@extends('layouts.mobile.app_sipren')

@section('title', 'Edit Presensi - Sipren')
@section('header-title', 'Edit Presensi')
@section('show-bottom-nav', true)

@push('styles')
    <style>
        .presensi-container {
            padding: 16px;
            padding-bottom: 80px;
        }

        /* Modern Meeting Details Card */
        .meeting-details-card {
            background: var(--primary); /* Solid green identical to dashboard */
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(6, 78, 59, 0.12);
            padding: 16px;
            position: relative;
            overflow: hidden;
            border: none;
        }

        .meeting-subject {
            margin-bottom: 14px;
            padding-left: 2px;
        }

        .subject-badge {
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

        .meeting-subject h3 {
            font-size: 1.15rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            letter-spacing: -0.01em;
            line-height: 1.3;
        }

        .meeting-meta-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 14px;
            border: none;
        }

        .meta-row-split {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 12px;
        }

        .meeting-meta-list > .meta-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 12px;
        }

        .meta-item {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .meta-icon-wrapper {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .meta-icon-wrapper ion-icon {
            font-size: 16px !important;
            color: #ffffff !important;
            margin-top: 0 !important;
            flex-shrink: 0;
        }

        .meta-label {
            display: block;
            font-size: 0.62rem;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 2px;
            letter-spacing: 0.01em;
            line-height: 1;
        }

        .meta-value {
            display: block;
            font-size: 0.82rem;
            color: #ffffff;
            font-weight: 700;
            word-break: break-word;
            line-height: 1.2;
        }

        /* Modern Textarea styling */
        .materi-textarea {
            border: 1.5px solid var(--border-color) !important;
            border-radius: 12px !important;
            font-size: 0.85rem !important;
            padding: 12px !important;
            width: 100%;
            transition: all 0.2s ease;
            outline: none;
            resize: none;
            color: var(--text-main) !important;
            font-weight: 500;
        }

        .materi-textarea:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 4px rgba(6, 78, 59, 0.08) !important;
            background: #ffffff !important;
        }

        /* Hadir Semua Button */
        .btn-hadir-all {
            background: rgba(16, 185, 129, 0.08);
            color: #10b981;
            border: 1.5px solid rgba(16, 185, 129, 0.15);
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.72rem;
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            height: auto;
            line-height: 1.2;
            cursor: pointer;
            transition: all 0.2s ease;
            outline: none;
        }

        .btn-hadir-all:active {
            transform: scale(0.95);
            opacity: 0.85;
        }

        /* Student Item Styling */
        .student-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: #ffffff;
            font-weight: 700;
            font-size: 0.82rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(6, 78, 59, 0.15);
        }

        .student-photo {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(6, 78, 59, 0.15);
        }

        .student-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
            line-height: 1.25;
        }

        .student-id {
            font-size: 0.7rem;
            color: var(--text-muted);
            font-weight: 500;
            display: block;
            margin-top: 1px;
        }

        .student-index {
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--text-muted);
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 6px;
            align-self: flex-start;
        }

        /* Presence Option Radio Group CSS */
        .presence-options {
            display: flex;
            background: #f1f5f9;
            border-radius: 12px;
            padding: 3px;
            gap: 4px;
            margin-bottom: 12px;
        }

        .presence-option {
            flex: 1;
            position: relative;
            text-align: center;
        }

        .presence-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .presence-label {
            display: block;
            padding: 8px 0;
            font-size: 0.78rem;
            font-weight: 700;
            border-radius: 9px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            color: #64748b;
            margin-bottom: 0;
        }

        .presence-option input[value="h"]:checked + .presence-label {
            background: #10b981;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);
        }

        .presence-option input[value="i"]:checked + .presence-label {
            background: #3b82f6;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.25);
        }

        .presence-option input[value="s"]:checked + .presence-label {
            background: #f59e0b;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.25);
        }

        .presence-option input[value="a"]:checked + .presence-label {
            background: #ef4444;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.25);
        }

        /* Modern Note Input styling */
        .note-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            padding: 2px 10px;
            transition: all 0.2s ease;
        }

        .note-input-wrapper:focus-within {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.06);
        }

        .note-input-wrapper ion-icon {
            font-size: 14px;
            color: var(--text-muted);
            margin-right: 6px;
        }

        .note-input {
            border: none !important;
            background: transparent !important;
            padding: 6px 0 !important;
            font-size: 0.78rem !important;
            color: var(--text-main) !important;
            font-weight: 500 !important;
            outline: none !important;
            width: 100% !important;
            box-shadow: none !important;
        }

        .note-input::placeholder {
            color: #94a3b8;
        }

        /* Button Action Effect */
        .btn-action {
            transition: all 0.2s ease;
        }
        .btn-action:active {
            transform: translateY(1px);
        }

        /* Update Button */
        .btn-update-presensi {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #ffffff !important;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 14px;
            border-radius: 14px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.25);
            transition: all 0.2s ease;
        }

        .btn-update-presensi:active {
            transform: translateY(1px);
            box-shadow: 0 2px 6px rgba(245, 158, 11, 0.2);
        }
    </style>
@endpush

@section('content')
    <div class="presensi-container">
        <form action="{{ route('presensi-mapel.update', Crypt::encrypt($presensi->id)) }}" method="POST">
            @csrf

            <!-- Section: Detail Pertemuan -->
            <div style="padding: 0 0 8px 0; margin-top: 4px;">
                <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em;">
                    Detail Pertemuan
                </span>
            </div>

            <!-- Modern Meeting Details Card -->
            <div class="meeting-details-card mb-3">
                <div class="meeting-info-body">
                    <div class="meeting-subject">
                        <span class="subject-badge">Mata Pelajaran</span>
                        <h3>{{ $presensi->mata_pelajaran->nama_matpel }}</h3>
                    </div>
                    <div class="meeting-meta-list">
                        <!-- Guru -->
                        <div class="meta-item">
                            <div class="meta-icon-wrapper">
                                <ion-icon name="person-outline"></ion-icon>
                            </div>
                            <div>
                                <span class="meta-label">Guru</span>
                                <span class="meta-value">{{ $presensi->guru->karyawan->nama_lengkap }}</span>
                            </div>
                        </div>
                        <!-- Hari, Tanggal -->
                        <div class="meta-item">
                            <div class="meta-icon-wrapper">
                                <ion-icon name="calendar-clear-outline"></ion-icon>
                            </div>
                            <div>
                                <span class="meta-label">Hari, Tanggal</span>
                                <span class="meta-value">{{ \Carbon\Carbon::parse($presensi->tanggal)->translatedFormat('l, d M Y') }}</span>
                            </div>
                        </div>
                        <!-- Kelas & Waktu Side-by-Side -->
                        <div class="meta-row-split">
                            <div class="meta-item">
                                <div class="meta-icon-wrapper">
                                    <ion-icon name="people-outline"></ion-icon>
                                </div>
                                <div>
                                    <span class="meta-label">Kelas</span>
                                    <span class="meta-value">{{ $presensi->kelas->nama_kelas }}</span>
                                </div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-icon-wrapper">
                                    <ion-icon name="time-outline"></ion-icon>
                                </div>
                                <div>
                                    <span class="meta-label">Waktu</span>
                                    <span class="meta-value">{{ substr($presensi->jam_mulai, 0, 5) }} - {{ substr($presensi->jam_selesai, 0, 5) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card: Materi Pembahasan -->
            <div style="margin-bottom: 20px;">
                <div class="card border-0" style="border-radius: 10px; background: var(--surface); box-shadow: var(--shadow-sm); overflow: hidden; border: none;">
                    <div class="card-body p-3">
                        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                            <ion-icon name="book-outline" style="font-size: 16px; color: var(--primary);"></ion-icon>
                            <label style="font-size: 0.82rem; font-weight: 700; color: var(--text-main); margin-bottom: 0; display: inline-block;">Materi / Pembahasan</label>
                        </div>
                        <textarea name="materi" class="materi-textarea" rows="3" placeholder="Tuliskan materi yang disampaikan pada pertemuan ini...">{{ $presensi->materi }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section: Daftar Kehadiran -->
            <div style="padding: 0 0 10px 0; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em;">
                    Daftar Kehadiran Siswa
                </span>
                <button type="button" id="btnHadirAll" class="btn-hadir-all">
                    <ion-icon name="checkmark-done-outline" style="font-size: 14px;"></ion-icon>
                    <span>Hadir Semua</span>
                </button>
            </div>

            <!-- Student List -->
            <div id="students-list-section">
                @foreach ($presensi->details as $d)
                    @php
                        $words = explode(" ", $d->siswa->nama_lengkap);
                        $initials = "";
                        if (count($words) > 0) {
                            $initials .= strtoupper(substr($words[0], 0, 1));
                        }
                        if (count($words) > 1) {
                            $initials .= strtoupper(substr($words[1], 0, 1));
                        }
                    @endphp
                    <div class="card mb-3 border-0" style="border-radius: 10px; background: var(--surface); box-shadow: 0 4px 16px rgba(6, 78, 59, 0.04); overflow: hidden; border: none;">
                        <div class="card-body p-3">
                            
                            <!-- Student Header -->
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    @if (!empty($d->siswa->pendaftaran->foto) && Storage::disk('public')->exists('photos/pendaftaran/' . $d->siswa->pendaftaran->foto))
                                        <img src="{{ asset('storage/photos/pendaftaran/' . $d->siswa->pendaftaran->foto) }}" class="student-photo" alt="{{ $d->siswa->nama_lengkap }}">
                                    @else
                                        <div class="student-avatar">
                                            {{ $initials }}
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="student-name">{{ $d->siswa->nama_lengkap }}</h4>
                                        <span class="student-id">{{ $d->siswa_id }}</span>
                                    </div>
                                </div>
                                <span class="student-index">#{{ $loop->iteration }}</span>
                            </div>

                            <!-- Radio Button Group -->
                            <div class="presence-options">
                                <div class="presence-option">
                                    <input type="radio" class="status-h" name="status[{{ $d->siswa_id }}]" id="h_{{ $d->siswa_id }}" value="h" {{ strtolower($d->status) == 'h' ? 'checked' : '' }}>
                                    <label class="presence-label" for="h_{{ $d->siswa_id }}">Hadir</label>
                                </div>
                                <div class="presence-option">
                                    <input type="radio" class="status-i" name="status[{{ $d->siswa_id }}]" id="i_{{ $d->siswa_id }}" value="i" {{ strtolower($d->status) == 'i' ? 'checked' : '' }}>
                                    <label class="presence-label" for="i_{{ $d->siswa_id }}">Izin</label>
                                </div>
                                <div class="presence-option">
                                    <input type="radio" class="status-s" name="status[{{ $d->siswa_id }}]" id="s_{{ $d->siswa_id }}" value="s" {{ strtolower($d->status) == 's' ? 'checked' : '' }}>
                                    <label class="presence-label" for="s_{{ $d->siswa_id }}">Sakit</label>
                                </div>
                                <div class="presence-option">
                                    <input type="radio" class="status-a" name="status[{{ $d->siswa_id }}]" id="a_{{ $d->siswa_id }}" value="a" {{ strtolower($d->status) == 'a' ? 'checked' : '' }}>
                                    <label class="presence-label" for="a_{{ $d->siswa_id }}">Alpha</label>
                                </div>
                            </div>

                            <!-- Note Input -->
                            <div class="note-input-wrapper">
                                <ion-icon name="create-outline"></ion-icon>
                                <input type="text" name="keterangan[{{ $d->siswa_id }}]" value="{{ $d->keterangan }}" class="note-input" placeholder="Tambah catatan keterangan...">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <div style="margin-top: 24px; margin-bottom: 40px;">
                <button type="submit" class="btn btn-update-presensi btn-action">
                    <ion-icon name="sync-outline" style="font-size: 18px;"></ion-icon>
                    <span>Update Presensi</span>
                </button>
            </div>
        </form>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $('#btnHadirAll').click(function() {
                $('.status-h').prop('checked', true);
            });
        });
    </script>
@endpush
