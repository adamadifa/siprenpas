@extends('layouts.app')
@section('titlepage', 'Input Presensi')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('presensi-mapel.create') }}" class="btn btn-icon btn-label-primary rounded-circle">
                        <i class="ti ti-arrow-left fs-4"></i>
                    </a>
                    <div>
                        <h4 class="mb-0 fw-bold">Input Presensi Siswa</h4>
                        <p class="text-muted mb-0 small">Mata Pelajaran: <b>{{ $jadwal->mapel->nama_matpel }}</b> | Kelas: <b>{{ $jadwal->kelas->nama_kelas }}</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-12">
        <form action="{{ route('presensi-mapel.store') }}" method="POST">
            @csrf
            <input type="hidden" name="jadwal_pelajaran_id" value="{{ $jadwal->id }}">
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">

            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-label-primary">
                    <h6 class="card-title mb-0">Informasi Pertemuan</h6>
                </div>
                <div class="card-body py-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="150">Guru</td>
                                    <td width="10">:</td>
                                    <th>{{ $jadwal->guru->karyawan->nama_lengkap }}</th>
                                </tr>
                                <tr>
                                    <td>Hari / Tanggal</td>
                                    <td>:</td>
                                    <th>{{ $jadwal->hari }}, {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</th>
                                </tr>
                                <tr>
                                    <td>Waktu</td>
                                    <td>:</td>
                                    <th>{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Materi / Pembahasan</label>
                            <textarea name="materi" class="form-control" rows="3" placeholder="Tuliskan materi yang disampaikan..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #064e3b">
                    <h6 class="card-title mb-0 text-white">Daftar Kehadiran Siswa</h6>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-success shadow-none border-white" id="btnHadirAll">
                            <i class="ti ti-check me-1"></i> Hadir Semua
                        </button>
                    </div>
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
                            @foreach ($students as $s)
                                <tr>
                                    <td class="py-2">{{ $loop->iteration }}</td>
                                    <td class="py-2">
                                        <div class="fw-bold text-dark">{{ $s->nama_lengkap }}</div>
                                        <div class="small text-muted">{{ $s->id_siswa }}</div>
                                    </td>
                                    <td class="text-center py-2">
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check status-h" name="status[{{ $s->id_siswa }}]" id="h_{{ $s->id_siswa }}" value="h" checked>
                                            <label class="btn btn-outline-success btn-sm waves-effect" for="h_{{ $s->id_siswa }}">H</label>

                                            <input type="radio" class="btn-check status-i" name="status[{{ $s->id_siswa }}]" id="i_{{ $s->id_siswa }}" value="i">
                                            <label class="btn btn-outline-info btn-sm waves-effect" for="i_{{ $s->id_siswa }}">I</label>

                                            <input type="radio" class="btn-check status-s" name="status[{{ $s->id_siswa }}]" id="s_{{ $s->id_siswa }}" value="s">
                                            <label class="btn btn-outline-warning btn-sm waves-effect" for="s_{{ $s->id_siswa }}">S</label>

                                            <input type="radio" class="btn-check status-a" name="status[{{ $s->id_siswa }}]" id="a_{{ $s->id_siswa }}" value="a">
                                            <label class="btn btn-outline-danger btn-sm waves-effect" for="a_{{ $s->id_siswa }}">A</label>
                                        </div>
                                    </td>
                                    <td class="py-2">
                                        <input type="text" name="keterangan[{{ $s->id_siswa }}]" class="form-control form-control-sm border-light" placeholder="Catatan...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-3 text-end bg-light">
                    <button type="submit" class="btn text-white px-5 shadow-sm" style="background-color: #064e3b">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Presensi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('myscript')
<script>
    $(function() {
        $('#btnHadirAll').click(function() {
            $('.status-h').prop('checked', true);
        });
    });
</script>
@endpush
@endsection
