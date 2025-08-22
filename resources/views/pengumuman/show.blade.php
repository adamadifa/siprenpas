<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Detail Pengumuman</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h4 class="text-primary">{{ $pengumuman->judul }}</h4>
                            <div class="d-flex align-items-center text-muted mb-2">
                                <i class="ti ti-calendar me-2"></i>
                                <span>{{ \Carbon\Carbon::parse($pengumuman->tanggal)->format('d F Y') }}</span>
                                <span class="mx-2">•</span>
                                <span class="badge bg-label-primary">{{ $pengumuman->kategori->nama_kategori }}</span>
                            </div>
                            @if ($pengumuman->lokasi)
                                <div class="d-flex align-items-center text-muted mb-3">
                                    <i class="ti ti-map-pin me-2"></i>
                                    <span>{{ $pengumuman->lokasi }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Isi Pengumuman:</h6>
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($pengumuman->isi)) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="mb-0">Informasi Pengumuman</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted">ID Pengumuman</small>
                                    <div class="fw-bold">{{ $pengumuman->id }}</div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Kategori</small>
                                    <div>
                                        <span
                                            class="badge bg-label-primary">{{ $pengumuman->kategori->nama_kategori }}</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Tanggal Dibuat</small>
                                    <div class="fw-bold">
                                        {{ \Carbon\Carbon::parse($pengumuman->created_at)->format('d M Y H:i') }}</div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Terakhir Diupdate</small>
                                    <div class="fw-bold">
                                        {{ \Carbon\Carbon::parse($pengumuman->updated_at)->format('d M Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
