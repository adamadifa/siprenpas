@extends('layouts.public')

@section('title', 'Statistik Pendaftaran')

@push('styles')
    <style>
        .lomba-stat-card {
            border-radius: 0.75rem;
            border: none;
            transition: all 0.3s ease;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .lomba-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
        }

        .lomba-stat-card.has-peserta {
            background: linear-gradient(135deg, #1B5E20 0%, #0A3D0A 100%);
            color: #fff;
        }

        .lomba-stat-card.no-peserta {
            background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
            color: #fff;
        }

        .lomba-stat-card .card-body {
            padding: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .lomba-stat-content {
            flex: 1;
        }

        .lomba-stat-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            opacity: 0.9;
        }

        .lomba-stat-number {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .lomba-stat-info {
            font-size: 0.75rem;
            opacity: 0.8;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }

        .lomba-stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            font-size: 1.75rem;
            color: #1B5E20;
        }

        .peserta-table {
            font-size: 0.875rem;
            margin-top: 1rem;
        }

        .peserta-table th {
            background: #1B5E20 !important;
            color: #fff !important;
            font-weight: 600;
            padding: 1rem;
            border: none;
        }

        .peserta-table td {
            padding: 0.875rem;
            vertical-align: middle;
        }

        .peserta-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .peserta-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge-lomba {
            font-size: 0.7rem;
            padding: 0.35rem 0.65rem;
            margin: 0.15rem;
            display: inline-block;
        }

        .total-card {
            background: #1B5E20;
            color: #fff;
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 12px rgba(27, 94, 32, 0.3);
            margin-bottom: 2rem;
        }

        .total-card h2 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #fff !important;
        }

        .total-card p {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 0;
            color: #fff !important;
        }

        .total-card i {
            color: #fff !important;
        }

        /* Filter Form Styling */
        .filter-form {
            background: #fff;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .filter-form .form-control,
        .filter-form .form-select {
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
            padding: 0.625rem 1rem;
        }

        .filter-form .form-control:focus,
        .filter-form .form-select:focus {
            border-color: #1B5E20;
            box-shadow: 0 0 0 0.2rem rgba(27, 94, 32, 0.15);
        }

        .filter-form .btn-search {
            background: #1B5E20;
            color: #fff;
            border: none;
            padding: 0.625rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
        }

        .filter-form .btn-search:hover {
            background: #0A3D0A;
        }

        .filter-form .btn-reset {
            background: #6c757d;
            color: #fff;
            border: none;
            padding: 0.625rem 1.5rem;
            border-radius: 0.5rem;
        }

        .filter-form .btn-reset:hover {
            background: #5a6268;
        }
    </style>
@endpush

@section('content')
    <!-- Total Pendaftar -->
    <div class="total-card">
        <h2>{{ $totalPendaftar }}</h2>
        <p><i class="ti ti-users me-2"></i>Total Pendaftar Got Talent</p>
    </div>

    <!-- Statistik per Lomba -->
    <div class="mb-4">
        <div class="section-title">
            <i class="ti ti-trophy"></i>
            <span>Statistik Peserta per Lomba</span>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3">
            @forelse ($statistikLomba as $stat)
                <div class="col">
                    <div class="card lomba-stat-card @if ($stat->jumlah_peserta == 0) no-peserta @else has-peserta @endif">
                        <div class="card-body">
                            <div class="lomba-stat-content">
                                <div class="lomba-stat-title">{{ $stat->jenis_perlombaan }}</div>
                                <div class="lomba-stat-number">{{ $stat->jumlah_peserta }}</div>
                                <div class="lomba-stat-info">
                                    <i class="ti ti-school"></i>
                                    <span>{{ $stat->jenjang_pendidikan }}</span>
                                </div>
                            </div>
                            <div class="lomba-stat-icon">
                                @if ($stat->jumlah_peserta == 0)
                                    <i class="ti ti-users-off"></i>
                                @else
                                    <i class="ti ti-trophy"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="ti ti-info-circle me-2"></i>Belum ada data lomba
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Daftar Peserta -->
    <div class="mt-5">
        <div class="section-title">
            <i class="ti ti-users"></i>
            <span>Daftar Peserta</span>
        </div>

        <!-- Filter Form -->
        <div class="filter-form">
            <form action="{{ route('got-talent.public') }}" method="GET">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label">Nomor Register</label>
                        <input type="text" name="nomor_register" class="form-control" placeholder="Cari nomor register..."
                            value="{{ request('nomor_register') }}">
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Cari nama..." value="{{ request('nama_lengkap') }}">
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12">
                        <label class="form-label">Jenjang</label>
                        <select name="id_jenjang" class="form-select">
                            <option value="">Semua Jenjang</option>
                            @foreach (\App\Models\JenjangPendidikan::orderBy('jenjang_pendidikan')->get() as $j)
                                <option value="{{ $j->id }}" {{ request('id_jenjang') == $j->id ? 'selected' : '' }}>
                                    {{ $j->jenjang_pendidikan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12">
                        <label class="form-label">Lomba</label>
                        <select name="id_lomba" class="form-select">
                            <option value="">Semua Lomba</option>
                            @foreach (\App\Models\Perlombaan::with('jenjangPendidikan')->orderBy('jenis_perlombaan')->get() as $l)
                                <option value="{{ $l->id }}" {{ request('id_lomba') == $l->id ? 'selected' : '' }}>
                                    {{ $l->jenis_perlombaan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-search flex-grow-1">
                                <i class="ti ti-search me-1"></i>Cari
                            </button>
                            <a href="{{ route('got-talent.public') }}" class="btn btn-reset">
                                <i class="ti ti-refresh"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if ($peserta->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-bordered peserta-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th style="width: 12%;">No. Register</th>
                            <th style="width: 20%;">Nama Lengkap</th>
                            <th style="width: 12%;">Jenjang</th>
                            <th style="width: 20%;">Asal Sekolah</th>
                            <th style="width: 31%;">Lomba yang Diikuti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peserta as $index => $p)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><strong>{{ $p->nomor_register }}</strong></td>
                                <td>{{ $p->nama_lengkap }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $p->jenjangPendidikan->jenjang_pendidikan ?? '-' }}
                                    </span>
                                </td>
                                <td>{{ $p->asal_sekolah }}</td>
                                <td>
                                    @forelse($p->perlombaan as $lomba)
                                        <span class="badge bg-success badge-lomba">
                                            {{ $lomba->jenis_perlombaan }}
                                        </span>
                                    @empty
                                        <span class="badge bg-secondary">Belum ada lomba</span>
                                    @endforelse
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-warning text-center">
                <i class="ti ti-alert-circle me-2"></i>Belum ada peserta yang terdaftar
            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Script untuk filter/pencarian akan ditambahkan di sini
        });
    </script>
@endpush
