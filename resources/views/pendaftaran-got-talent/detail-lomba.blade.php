<style>
    .peserta-table {
        font-size: 0.875rem;
    }

    .peserta-table th {
        background-color: #f8f9fa;
        font-weight: 600;
        padding: 0.75rem;
        border-bottom: 2px solid #dee2e6;
    }

    .peserta-table td {
        padding: 0.75rem;
        vertical-align: middle;
    }

    .badge-status {
        font-size: 0.75rem;
        padding: 0.35rem 0.65rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
</style>

<div class="modal-body">
    @if ($peserta->count() > 0)
        <div class="mb-3">
            <div class="alert alert-info d-flex align-items-center">
                <i class="ti ti-info-circle me-2"></i>
                <div>
                    <strong>{{ $peserta->count() }} Peserta</strong> terdaftar pada lomba ini
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered peserta-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 15%;">No. Register</th>
                        <th style="width: 25%;">Nama Lengkap</th>
                        <th style="width: 20%;">Jenjang</th>
                        <th style="width: 20%;">Asal Sekolah</th>
                        <th style="width: 15%;">No. HP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peserta as $index => $p)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $p->nomor_register }}</strong>
                            </td>
                            <td>{{ $p->nama_lengkap }}</td>
                            <td>
                                <span class="badge bg-primary badge-status">
                                    {{ $p->jenjangPendidikan->jenjang_pendidikan ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $p->asal_sekolah }}</td>
                            <td>{{ $p->no_hp }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <i class="ti ti-user-x"></i>
            <h5 class="mb-2">Belum Ada Peserta</h5>
            <p class="mb-0">Lomba ini belum memiliki peserta yang terdaftar</p>
        </div>
    @endif
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        <i class="ti ti-x me-1"></i>Tutup
    </button>
</div>
