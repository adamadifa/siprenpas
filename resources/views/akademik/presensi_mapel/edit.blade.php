@extends('layouts.app')
@section('titlepage', 'Edit Presensi')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('presensi-mapel.index') }}" class="btn btn-icon btn-label-primary rounded-circle">
                        <i class="ti ti-arrow-left fs-4"></i>
                    </a>
                    <div>
                        <h4 class="mb-0 fw-bold">Edit Presensi Siswa</h4>
                        <p class="text-muted mb-0 small">Mata Pelajaran: <b>{{ $presensi->mata_pelajaran->nama_matpel }}</b> | Kelas: <b>{{ $presensi->kelas->nama_kelas }}</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-12">
        <form action="{{ route('presensi-mapel.update', Crypt::encrypt($presensi->id)) }}" method="POST">
            @csrf
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-label-warning">
                    <h6 class="card-title mb-0">Informasi Pertemuan</h6>
                </div>
                <div class="card-body py-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="150">Guru</td>
                                    <td width="10">:</td>
                                    <th>{{ $presensi->guru->karyawan->nama_lengkap }}</th>
                                </tr>
                                <tr>
                                    <td>Hari / Tanggal</td>
                                    <td>:</td>
                                    <th>{{ \Carbon\Carbon::parse($presensi->tanggal)->translatedFormat('l, d/m/Y') }}</th>
                                </tr>
                                <tr>
                                    <td>Waktu</td>
                                    <td>:</td>
                                    <th>{{ substr($presensi->jam_mulai, 0, 5) }} - {{ substr($presensi->jam_selesai, 0, 5) }}</th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Materi / Pembahasan</label>
                            <textarea name="materi" class="form-control" rows="3" placeholder="Tuliskan materi yang disampaikan...">{{ $presensi->materi }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #064e3b">
                    <h6 class="card-title mb-0 text-white">Daftar Kehadiran Siswa</h6>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3" width="50">NO</th>
                                <th class="text-white py-3">SISWA</th>
                                <th class="text-white py-3 text-center" width="250">STATUS KEHADIRAN</th>
                                <th class="text-white py-3">KETERANGAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presensi->details as $d)
                                <tr>
                                    <td class="py-2">{{ $loop->iteration }}</td>
                                    <td class="py-2">
                                        <div class="fw-bold text-dark">{{ $d->siswa->nama_lengkap }}</div>
                                        <div class="small text-muted">{{ $d->siswa_id }}</div>
                                    </td>
                                    <td class="text-center py-2">
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check status-h" name="status[{{ $d->siswa_id }}]" id="h_{{ $d->siswa_id }}" value="h" {{ strtolower($d->status) == 'h' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success btn-sm waves-effect" for="h_{{ $d->siswa_id }}">H</label>

                                            <input type="radio" class="btn-check status-i" name="status[{{ $d->siswa_id }}]" id="i_{{ $d->siswa_id }}" value="i" {{ strtolower($d->status) == 'i' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-info btn-sm waves-effect" for="i_{{ $d->siswa_id }}">I</label>

                                            <input type="radio" class="btn-check status-s" name="status[{{ $d->siswa_id }}]" id="s_{{ $d->siswa_id }}" value="s" {{ strtolower($d->status) == 's' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning btn-sm waves-effect" for="s_{{ $d->siswa_id }}">S</label>

                                            <input type="radio" class="btn-check status-a" name="status[{{ $d->siswa_id }}]" id="a_{{ $d->siswa_id }}" value="a" {{ strtolower($d->status) == 'a' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger btn-sm waves-effect" for="a_{{ $d->siswa_id }}">A</label>
                                        </div>
                                    </td>
                                    <td class="py-2">
                                        <input type="text" name="keterangan[{{ $d->siswa_id }}]" value="{{ $d->keterangan }}" class="form-control form-control-sm border-light" placeholder="Catatan...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-3 text-end bg-light">
                    <button type="submit" class="btn btn-warning px-5 shadow-sm">
                        <i class="ti ti-device-floppy me-1"></i> Update Presensi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
