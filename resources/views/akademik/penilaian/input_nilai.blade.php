@extends('layouts.app')
@section('titlepage', 'Input Nilai')

@section('content')
@section('navigasi')
    <span>Input Nilai</span>
@endsection

<div class="row">
    <!-- Header Context similar to screenshot -->
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-body p-3 d-flex justify-content-between align-items-center">
                <div>
                     <h5 class="mb-0 fw-bold">Nilai {{ ucfirst(strtolower($rencana->kategori_penilaian)) }} - {{ $rencana->nama_penilaian }}</h5>
                     <small class="text-muted">{{ $bobot->mapel->nama_matpel ?? '-' }} | {{ $kelas->nama_kelas ?? '-' }}</small>
                </div>
                <div>
                     <a href="{{ route('penilaian.index', $bobot->id) }}" class="btn btn-danger btn-sm text-white"><i class="ti ti-arrow-left me-1"></i> Kembali</a>
                     <button type="button" class="btn btn-primary btn-sm"><i class="ti ti-plus me-1"></i> Tambah</button>
                     <button type="button" class="btn btn-success btn-sm"><i class="ti ti-upload me-1"></i> Upload</button>
                     <button type="button" class="btn btn-warning btn-sm text-white"><i class="ti ti-download me-1"></i> Export</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Search Bar Placeholder -->
    <div class="col-12 mb-2 text-end">
        <div class="d-inline-block" style="width: 250px;">
             <input type="text" class="form-control form-control-sm" placeholder="Search:">
        </div>
    </div>

    <!-- Form Input Nilai -->
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <form action="{{ route('penilaian.store-nilai') }}" method="POST">
                    @csrf
                    <input type="hidden" name="rencana_penilaian_id" value="{{ $rencana->id }}">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%" class="text-center align-middle" rowspan="2">No</th>
                                    <th width="15%" class="align-middle" rowspan="2">NISN</th> <!-- Labelled NISN as per screenshot, using NIS data -->
                                    <th class="align-middle" rowspan="2">Nama</th>
                                    <th width="5%" class="text-center align-middle" rowspan="2">L/P</th>
                                    <th width="15%" class="text-center">Nilai</th>
                                </tr>
                                <tr>
                                    <th class="text-center bg-white">{{ $rencana->kode_penilaian }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $index => $student)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $student->nis }}</td>
                                        <td>{{ $student->nama_lengkap }}</td>
                                        <td class="text-center">{{ $student->jenis_kelamin }}</td>
                                        <td class="p-1">
                                            @php
                                                $nilai = $grades[$student->id_siswa] ?? '';
                                            @endphp
                                            <input type="number" step="0.01" min="0" max="100" 
                                                name="nilai[{{ $student->id_siswa }}]" 
                                                class="form-control form-control-sm border-0 text-center fw-bold {{ $nilai !== '' ? ($nilai < 75 ? 'text-danger' : 'text-success') : '' }}" 
                                                value="{{ $nilai }}" placeholder="-">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">Tidak ada siswa di kelas ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Save Button Floating or Bottom -->
                    <div class="p-3 border-top text-end bg-light sticky-bottom">
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Simpan Nilai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
