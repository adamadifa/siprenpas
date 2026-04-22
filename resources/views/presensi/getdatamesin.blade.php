<style>
    .table-unit-style {
        width: 100%;
        margin-bottom: 0;
    }
    .table-unit-style thead th {
        background-color: #064e3b !important;
        color: white !important;
        padding: 1rem !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="table-responsive border rounded">
            <table class="table table-hover align-middle table-unit-style">
                <thead>
                    <tr>
                        <th class="fw-bold">Waktu & Mesin</th>
                        <th class="fw-bold text-center">Tipe</th>
                        <th class="fw-bold">Status / Ket</th>
                        <th class="fw-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($filtered_array as $d)
                        @php
                            $is_in = in_array($d->status_scan, [0, 2, 4, 6, 8]);
                            $log_status = $d->status == 1 ? 'success' : 'danger';
                            $log_label = $d->status == 1 ? 'BERHASIL' : 'GAGAL';
                        @endphp
                        <tr>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-label-primary p-2 rounded-3 shadow-xs">
                                        <i class="ti ti-clock-check fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem">{{ date('H:i:s', strtotime($d->jam_absen)) }}</div>
                                        <div class="extra-small text-muted fw-semibold">
                                            <i class="ti ti-device-desktop fs-7 me-1"></i>{{ $d->nama_mesin ?? 'Unknown' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-center">
                                @if($is_in)
                                    <span class="badge bg-label-success rounded-pill px-3" style="font-size: 0.6rem">
                                        <i class="ti ti-login-2 me-1"></i>IN
                                    </span>
                                @else
                                    <span class="badge bg-label-danger rounded-pill px-3" style="font-size: 0.6rem">
                                        <i class="ti ti-logout-2 me-1"></i>OUT
                                    </span>
                                @endif
                            </td>
                            <td class="py-3">
                                <span class="d-block fw-bold text-{{ $log_status }} mb-1" style="font-size: 0.65rem">
                                    <i class="ti ti-{{ $d->status == 1 ? 'circle-check' : 'circle-x' }} fs-7 me-1"></i>{{ $log_label }}
                                </span>
                                <div class="text-muted extra-small" style="max-width: 150px; line-height: 1.1">
                                    {{ $d->keterangan ?? 'No remarks provided' }}
                                </div>
                            </td>
                            <td class="py-3 text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <form method="POST" class="updatemasuk" action="{{ route('presensi.updatefrommachine', [Crypt::encrypt($d->pin), 0]) }}">
                                        @csrf
                                        <input type="hidden" name="scan_date" value="{{ date('Y-m-d H:i:s', strtotime($d->jam_absen)) }}">
                                        <button type="submit" class="btn btn-sm btn-label-success p-1 px-2 border-0 shadow-none d-flex align-items-center gap-1" style="border-radius: 6px;" title="Tarik sebagai Masuk">
                                            <i class="ti ti-plus" style="font-size: 0.7rem"></i> <small>Masuk</small>
                                        </button>
                                    </form>
                                    <form method="POST" class="updatepulang" action="{{ route('presensi.updatefrommachine', [Crypt::encrypt($d->pin), 1]) }}">
                                        @csrf
                                        <input type="hidden" name="scan_date" value="{{ date('Y-m-d H:i:s', strtotime($d->jam_absen)) }}">
                                        <button type="submit" class="btn btn-sm btn-label-danger p-1 px-2 border-0 shadow-none d-flex align-items-center gap-1" style="border-radius: 6px;" title="Tarik sebagai Pulang">
                                            <i class="ti ti-minus" style="font-size: 0.7rem"></i> <small>Pulang</small>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="mb-3">
                                    <i class="ti ti-database-off fs-1 opacity-25"></i>
                                </div>
                                <h6 class="text-muted fw-bold">Tidak ada log mesin ditemukan</h6>
                                <p class="text-muted extra-small">Hubungkan finger ke cloud untuk sinkronisasi data.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
