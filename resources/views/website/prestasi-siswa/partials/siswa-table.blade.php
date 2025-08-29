<style>
    /* CSS khusus untuk modal pencarian siswa - tidak mempengaruhi card lain */
    #modalPilihSiswa .hover-shadow {
        transition: all 0.3s ease;
    }

    #modalPilihSiswa .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    #modalPilihSiswa .avatar-initial {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    #modalPilihSiswa .card {
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border-left: 4px solid #696cff !important;
        border-radius: 8px !important;
        position: relative;
        overflow: hidden;
    }

    #modalPilihSiswa .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(105, 108, 255, 0.1), transparent);
        transition: left 0.5s ease;
    }

    #modalPilihSiswa .card:hover {
        border-left-color: #696cff !important;
        border-color: #1e7e34 !important;
        box-shadow: 0 8px 25px rgba(30, 126, 52, 0.3);
        transform: translateY(-3px) scale(1.02);
    }

    #modalPilihSiswa .card:hover::before {
        left: 100%;
    }

    #modalPilihSiswa .clickable-card {
        cursor: pointer;
    }

    #modalPilihSiswa .clickable-card:hover {
        border-color: #1e7e34 !important;
        border-left-color: #696cff !important;
        background: linear-gradient(135deg, rgba(30, 126, 52, 0.05), rgba(105, 108, 255, 0.05));
    }

    #modalPilihSiswa .student-card {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.5s ease forwards;
    }

    #modalPilihSiswa .student-card:hover .avatar-initial {
        transform: scale(1.1);
        background: linear-gradient(135deg, #696cff, #1e7e34) !important;
    }

    #modalPilihSiswa .student-card:hover h6 {
        color: #1e7e34 !important;
        transform: translateX(5px);
        transition: all 0.3s ease;
    }

    #modalPilihSiswa .student-card:hover small {
        color: #696cff !important;
        transition: all 0.3s ease;
    }

    #modalPilihSiswa .student-card h6,
    #modalPilihSiswa .student-card small,
    #modalPilihSiswa .student-card .avatar-initial {
        transition: all 0.3s ease;
    }

    #modalPilihSiswa .gap-2 {
        gap: 0.5rem;
    }

    #modalPilihSiswa .btn-pilih-siswa {
        transition: all 0.2s ease;
    }

    #modalPilihSiswa .btn-pilih-siswa:hover {
        transform: scale(1.05);
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

@if ($siswa->count() > 0)
    <div class="row">
        @foreach ($siswa as $s)
            <div class="col-12 mb-3">
                <div class="card shadow-sm hover-shadow student-card border border-success border-1 clickable-card" data-id="{{ $s->id_siswa }}"
                    data-nama="{{ $s->nama_lengkap }}" data-nisn="{{ $s->nisn ?? '-' }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md me-3">
                                <div class="avatar-initial rounded-circle bg-primary">
                                    <i class="ti ti-user text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1 fw-semibold" title="{{ $s->nama_lengkap }}">
                                            {{ $s->nama_lengkap }}
                                        </h6>
                                        <small class="text-muted">
                                            <i class="ti ti-id me-1"></i>
                                            {{ $s->nisn ?? 'NISN: -' }}
                                        </small>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <small class="text-muted">
                                            <i class="ti ti-mouse-pointer me-1"></i>
                                            Klik untuk memilih
                                        </small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted d-block mb-1">
                                            <i class="ti ti-map-pin me-1"></i>
                                            <strong>Alamat:</strong>
                                        </small>
                                        <small class="text-dark">
                                            {{ $s->alamat ?? 'Alamat tidak tersedia' }}
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted d-block mb-1">
                                            <i class="ti ti-calendar me-1"></i>
                                            <strong>Tahun Masuk:</strong>
                                        </small>
                                        <small class="text-dark">
                                            {{ $s->tahun_masuk ?? 'Tidak tersedia' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <div class="text-muted">
            <i class="ti ti-search" style="font-size: 3rem; opacity: 0.5;"></i>
            <h5 class="mt-3 mb-2">Tidak ada data siswa ditemukan</h5>
            <p class="mb-0">Coba ubah kata kunci pencarian Anda</p>
        </div>
    </div>
@endif
