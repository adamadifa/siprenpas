@extends('layouts.app')
@section('titlepage', 'Absensi')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-4">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e6f4ea; color: #064e3b">
                        <i class="ti ti-calendar-event fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-extrabold" style="color: #064e3b; letter-spacing: -0.5px;">Absensi Saya</h4>
                        <p class="text-muted mb-0 small">Histori kehadiran, shift kerja, dan waktu keterlambatan Anda</p>
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
                            <li class="breadcrumb-item active fw-medium" style="color: #064e3b">
                                <i class="ti ti-calendar-event me-1"></i> Absensi
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <!-- Profile & Stats Section -->
    <div class="col-lg-12">
        <!-- Employee Profile Summary Card -->
        @if(!empty($karyawan))
            <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden text-white" style="background: linear-gradient(135deg, #064e3b 0%, #043e2f 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center g-4">
                        <div class="col-auto">
                            <div class="avatar avatar-xl bg-white rounded-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                <i class="ti ti-user-check fs-2" style="color: #064e3b;"></i>
                            </div>
                        </div>
                        <div class="col-md">
                            <h4 class="fw-bold mb-1 text-white">{{ $karyawan->nama_lengkap }}</h4>
                            <p class="text-white-50 mb-0 small">NPP: <span class="fw-semibold text-white">{{ $karyawan->npp }}</span></p>
                        </div>
                        <div class="col-md-auto ms-md-auto">
                            <div class="d-flex flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-briefcase text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Jabatan</span>
                                        <span class="fw-bold text-white small">{{ strtoupper($karyawan->nama_jabatan) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-hierarchy-2 text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Departemen</span>
                                        <span class="fw-bold text-white small">{{ strtoupper($karyawan->nama_dept) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="background: rgba(255, 255, 255, 0.12) !important; border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <i class="ti ti-building text-white fs-4 flex-shrink-0"></i>
                                    <div style="line-height: 1.1;">
                                        <span class="text-white-50 text-uppercase d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.5px; font-weight: 500;">Unit Kerja</span>
                                        <span class="fw-bold text-white small">{{ strtoupper($karyawan->nama_unit) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Monthly Statistics Counter Card -->
    <div class="col-lg-12 mb-4">
        <div class="row g-3">
            <div class="col-6 col-md-2-4 col-lg">
                <div class="card border-0 shadow-sm rounded-3 p-3 text-center bg-white border-start border-5 border-success">
                    <span class="text-secondary small d-block mb-1">Hadir</span>
                    <h3 class="fw-extrabold text-success mb-0">{{ $stats['hadir'] }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-2-4 col-lg">
                <div class="card border-0 shadow-sm rounded-3 p-3 text-center bg-white border-start border-5 border-warning">
                    <span class="text-secondary small d-block mb-1">Terlambat</span>
                    <h3 class="fw-extrabold text-warning mb-0">{{ $stats['terlambat'] }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-2-4 col-lg">
                <div class="card border-0 shadow-sm rounded-3 p-3 text-center bg-white border-start border-5 border-info">
                    <span class="text-secondary small d-block mb-1">Sakit</span>
                    <h3 class="fw-extrabold text-info mb-0">{{ $stats['sakit'] }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-2-4 col-lg">
                <div class="card border-0 shadow-sm rounded-3 p-3 text-center bg-white border-start border-5 border-primary">
                    <span class="text-secondary small d-block mb-1">Izin</span>
                    <h3 class="fw-extrabold text-primary mb-0">{{ $stats['izin'] }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-2-4 col-lg">
                <div class="card border-0 shadow-sm rounded-3 p-3 text-center bg-white border-start border-5 border-danger">
                    <span class="text-secondary small d-block mb-1">Alfa</span>
                    <h3 class="fw-extrabold text-danger mb-0">{{ $stats['alfa'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="col-lg-12 mb-4">
        <div class="card shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ route('presensi.absensikaryawan') }}" method="GET" autocomplete="off">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ti ti-calendar text-muted"></i></span>
                                <select name="bulan" class="form-select" style="height: 38px;">
                                    @foreach ($list_bulan as $key => $val)
                                        <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ti ti-calendar-event text-muted"></i></span>
                                <select name="tahun" class="form-select" style="height: 38px;">
                                    @for ($y = date('Y'); $y >= 2020; $y--)
                                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn text-white px-4 d-flex align-items-center justify-content-center gap-2" 
                                    style="background-color: #064e3b; border-color: #064e3b; height: 38px; border-radius: 8px;">
                                <i class="ti ti-search fs-5"></i>
                                <span>Tampilkan</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Monthly Attendance Cards Grid -->
    <div class="col-lg-12">
        <div class="card border-0 shadow-none bg-transparent">
            <div class="card-body p-0">
            <div class="row g-3">
                @forelse ($presensi as $key => $d)
                    @php
                        $jam_masuk_kerja = $d->jam_masuk;
                        $jam_in_scan = $d->jam_in;
                        $terlambat = '';
                        if ($d->status == 'h' && $jam_masuk_kerja && $jam_in_scan) {
                            $in = strtotime($jam_in_scan);
                            $msk = strtotime($jam_masuk_kerja);
                            if ($in > $msk) {
                                $diff = $in - $msk;
                                $min = round($diff / 60);
                                $terlambat = $min . ' Menit';
                            }
                        }
                        
                        // Set border/header styles based on status
                        $border_color = '#eef2f6';
                        $header_bg = '#f8f9fa';
                        $status_label = '';
                        $status_badge_class = 'bg-secondary';
                        
                        if ($d->status == 'h') {
                            $border_color = '#d1f5e0';
                            $header_bg = '#e8fbf1';
                            $status_label = 'HADIR';
                            $status_badge_class = 'bg-success';
                        } elseif ($d->status == 'i') {
                            $border_color = '#d0ebff';
                            $header_bg = '#e7f5ff';
                            $status_label = 'IZIN';
                            $status_badge_class = 'bg-primary';
                        } elseif ($d->status == 's') {
                            $border_color = '#d3f9d8';
                            $header_bg = '#ebfbee';
                            $status_label = 'SAKIT';
                            $status_badge_class = 'bg-info';
                        } elseif ($d->status == 'a') {
                            $border_color = '#ffc9c9';
                            $header_bg = '#fff5f5';
                            $status_label = 'ALFA';
                            $status_badge_class = 'bg-danger';
                        }
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="card border shadow-none rounded-3 h-100" style="border-color: {{ $border_color }} !important; overflow: hidden; background-color: #ffffff;">
                            <!-- Card Header -->
                            <div class="p-3 d-flex align-items-center justify-content-between border-bottom" style="background-color: {{ $header_bg }}; border-bottom-color: {{ $border_color }} !important;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="badge bg-white text-dark border px-2 py-1 small fw-bold font-monospace">
                                        #{{ $key + 1 }}
                                    </div>
                                    <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ date('d M Y', strtotime($d->tanggal)) }}</span>
                                </div>
                                <span class="badge {{ $status_badge_class }} text-white font-weight-bold rounded-pill" style="font-size: 0.75rem;">
                                    {{ $status_label ?: '-' }}
                                </span>
                            </div>
                            
                            <!-- Card Body -->
                            <div class="p-3">
                                <div class="mb-3">
                                    <span class="text-secondary small d-block mb-1">Shift / Jam Kerja</span>
                                    @if ($d->nama_jam_kerja)
                                        <span class="fw-bold text-dark d-block" style="font-size: 0.9rem;">
                                            {{ $d->nama_jam_kerja }}
                                        </span>
                                        <span class="text-muted small" style="font-size: 0.8rem;">
                                            ({{ substr($d->jam_masuk, 0, 5) }} - {{ substr($d->jam_pulang, 0, 5) }})
                                        </span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </div>

                                <div class="row g-2 border-top pt-2">
                                    <!-- Jam Masuk -->
                                    <div class="col-6 border-end">
                                        <span class="text-secondary small d-block mb-1">Scan Masuk</span>
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($d->foto_in)
                                                @php
                                                    $foto_in_path = Storage::url('uploads/absensi/' . $d->foto_in);
                                                @endphp
                                                <a href="{{ $foto_in_path }}" target="_blank" class="flex-shrink-0">
                                                    <img src="{{ $foto_in_path }}" class="rounded-circle border" style="width: 32px; height: 32px; object-fit: cover;" alt="Foto Masuk">
                                                </a>
                                            @endif
                                            <span class="fw-bold text-dark font-monospace" style="font-size: 0.85rem;">
                                                {{ $d->jam_in ? substr($d->jam_in, 0, 5) : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Jam Pulang -->
                                    <div class="col-6">
                                        <span class="text-secondary small d-block mb-1">Scan Pulang</span>
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($d->foto_out)
                                                @php
                                                    $foto_out_path = Storage::url('uploads/absensi/' . $d->foto_out);
                                                @endphp
                                                <a href="{{ $foto_out_path }}" target="_blank" class="flex-shrink-0">
                                                    <img src="{{ $foto_out_path }}" class="rounded-circle border" style="width: 32px; height: 32px; object-fit: cover;" alt="Foto Pulang">
                                                </a>
                                            @endif
                                            <span class="fw-bold text-dark font-monospace" style="font-size: 0.85rem;">
                                                {{ $d->jam_out ? substr($d->jam_out, 0, 5) : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Late Warning / Status Note -->
                                @if ($terlambat || $d->status == 'h')
                                    <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                                        <span class="text-secondary small">Keterangan</span>
                                        @if ($terlambat)
                                            <span class="badge bg-danger bg-opacity-10 text-danger fw-bold font-monospace small" style="font-size: 0.75rem;">
                                                Terlambat {{ $terlambat }}
                                            </span>
                                        @else
                                            <span class="badge bg-success bg-opacity-10 text-success fw-bold small" style="font-size: 0.75rem;">Tepat Waktu</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 py-5 text-center text-muted">
                        <div class="avatar avatar-lg bg-light mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="ti ti-calendar-cancel fs-2 text-muted"></i>
                        </div>
                        <h6 class="fw-bold">Tidak Ada Data Absensi</h6>
                        <p class="text-muted mb-0 small">Belum ada catatan presensi/absensi Anda untuk bulan yang dipilih.</p>
                    </div>
                @endforelse
            </div>
            
        </div>
    </div>
</div>
@endsection
