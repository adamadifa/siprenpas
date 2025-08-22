<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold">Nama Kategori:</label>
            <p class="form-control-static">{{ $kategoriPengumuman->nama_kategori }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold">Jumlah Pengumuman:</label>
            <p class="form-control-static">
                <span class="badge bg-label-primary">{{ $kategoriPengumuman->pengumuman_count }}</span>
            </p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold">Tanggal Dibuat:</label>
            <p class="form-control-static">{{ $kategoriPengumuman->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold">Terakhir Diupdate:</label>
            <p class="form-control-static">{{ $kategoriPengumuman->updated_at->format('d M Y H:i') }}</p>
        </div>
    </div>
</div>

@if ($kategoriPengumuman->pengumuman_count > 0)
    <div class="mt-4">
        <h6 class="fw-bold">Daftar Pengumuman dalam Kategori Ini:</h6>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategoriPengumuman->pengumuman as $index => $pengumuman)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pengumuman->judul }}</td>
                            <td>{{ $pengumuman->tanggal }}</td>
                            <td>{{ $pengumuman->lokasi ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
