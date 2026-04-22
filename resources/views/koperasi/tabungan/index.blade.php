@extends('layouts.app')
@section('titlepage', 'Data Tabungan Koperasi')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-piggy-bank fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Tabungan</h4>
                        <p class="text-muted mb-0 small">Manajemen simpanan sukarela dan tabungan anggota koperasi</p>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);" class="text-muted">
                                    <i class="ti ti-building-bank me-1"></i> Koperasi
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="ti ti-piggy-bank me-1"></i> Tabungan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12">
        <!-- Actions Section -->
        <div class="d-flex justify-content-start mb-3">
            @can('tabungan.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreateRekening"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Buat Rekening</span>
                </button>
            @endcan
        </div>

        <!-- Filter Form -->
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ URL::current() }}">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-7 col-md-6">
                            <x-input-with-icon label="" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                placeholder="Cari Nama Anggota Koperasi" icon="ti ti-search" />
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <select name="kode_tabungan" id="kode_tabungan" class="form-select select2Kodetabungan border-0 shadow-sm border" style="border-color: #e0e0e0 !important;">
                                    <option value="">Semua Jenis Tabungan</option>
                                    @foreach ($jenis_tabungan as $item)
                                        <option {{ Request('kode_tabungan') == $item->kode_tabungan ? 'selected' : '' }}
                                            value="{{ $item->kode_tabungan }}">{{ $item->kode_tabungan }} {{ $item->jenis_tabungan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <button type="submit" class="btn btn-primary w-100 p-2 d-flex align-items-center justify-content-center gap-2" 
                                style="background-color: #064e3b; border-color: #064e3b">
                                <i class="ti ti-search fs-5"></i>
                                <span>Cari</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center gap-2 text-white py-3" style="background-color: #064e3b">
                <i class="ti ti-layout-grid fs-5"></i>
                <h6 class="card-title mb-0 text-white">Data Anggota Tabungan</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">NO</th>
                                <th class="text-white py-3">NO. REKENING</th>
                                <th class="text-white py-3">NO. ANGGOTA</th>
                                <th class="text-white py-3">NAMA LENGKAP</th>
                                <th class="text-white py-3">KODE</th>
                                <th class="text-white py-3">JENIS TABUNGAN</th>
                                <th class="text-white py-3 text-end">SALDO</th>
                                <th class="text-white py-3 text-center">RFID</th>
                                <th class="text-white py-3 text-end" style="width: 120px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tabungan as $d)
                                <tr>
                                    <td class="text-center py-2">{{ $loop->iteration + $tabungan->firstItem() - 1 }}</td>
                                    <td class="py-2 text-dark fw-bold">{{ $d->no_rekening }}</td>
                                    <td class="py-2 small">{{ $d->no_anggota }}</td>
                                    <td class="py-2 fw-bold text-dark">{{ $d->nama_lengkap }}</td>
                                    <td class="py-2 text-center small"><span class="badge bg-label-info">{{ $d->kode_tabungan }}</span></td>
                                    <td class="py-2">{{ $d->jenis_tabungan }}</td>
                                    <td class="py-2 text-end text-success fw-bold">{{ formatAngka($d->saldo) }}</td>
                                    <td class="py-2 text-center text-nowrap">
                                        @if($d->rfid)
                                            <span class="badge bg-label-success rounded-pill small" style="font-size: 0.7rem;">{{ $d->rfid }}</span>
                                        @else
                                            <span class="badge bg-label-secondary rounded-pill small">-</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('tabungan.index')
                                                <a href="{{ route('tabungan.show', Crypt::encrypt($d->no_rekening)) }}" 
                                                   class="btn btn-icon btn-label-success border"
                                                   style="width: 28px; height: 28px;" title="Detail Tabungan">
                                                    <i class="ti ti-book fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('tabungan.edit')
                                                <a href="javascript:void(0)" class="btn btn-icon btn-label-info border btnEditRfid"
                                                   style="width: 28px; height: 28px;"
                                                   data-no-rekening="{{ Crypt::encrypt($d->no_rekening) }}" title="Edit RFID">
                                                    <i class="ti ti-link fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('tabungan.delete')
                                                <form method="POST" class="deleteform"
                                                    action="{{ route('tabungan.deleterekening', Crypt::encrypt($d->no_rekening)) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="javascript:void(0)" class="btn btn-icon btn-label-danger border delete-confirm"
                                                       style="width: 28px; height: 28px;" title="Hapus Rekening">
                                                        <i class="ti ti-trash fs-6"></i>
                                                    </a>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-package-off fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Data tidak ditemukan</h5>
                                        <p class="text-muted small">Silahkan sesuaikan filter pencarian atau jenis tabungan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-2">
                <div class="d-flex justify-content-end">
                    {{ $tabungan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlRekening" size="" show="loadmodalRekening" title="" />
<div class="modal fade" id="mdlAnggota" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Data Anggota</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0" id="tabelanggota">
                        <thead class="table-dark">
                            <tr>
                                <th>No. Anggota</th>
                                <th>NIK</th>
                                <th>NAMA LENGKAP</th>
                                <th>No. HP</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit RFID -->
<div class="modal fade" id="mdlEditRfid" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit RFID Tabungan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditRfid">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_no_rekening" name="no_rekening">
                    
                    <div class="mb-3">
                        <label for="edit_rfid" class="form-label fw-bold">Kode RFID</label>
                        <x-input-with-icon label="" placeholder="Masukkan kode RFID" icon="ti ti-link" name="rfid" id="edit_rfid" />
                        <div class="invalid-feedback" id="edit_rfid_error"></div>
                        <small class="form-text text-muted">
                            Kode RFID harus unik dan maksimal 20 karakter. Kosongkan jika tidak ada RFID.
                        </small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnUpdateRfid" style="background-color: #064e3b; border-color: #064e3b">
                    <i class="ti ti-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        $(document).on('show.bs.modal', '.modal', function() {
            const zIndex = 1090 + 10 * $('.modal:visible').length;
            $(this).css('z-index', zIndex);
            setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1)
                .addClass('modal-stack'));
        });

        const loading = `<div class="d-flex justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>`;

        $("#btncreateRekening").click(function(e) {
            e.preventDefault();
            $('#mdlRekening').modal("show");
            $("#loadmodalRekening").html(loading);
            $("#mdlRekening").find(".modal-title").text("Buat Rekening Baru");
            $("#loadmodalRekening").load("{{ route('tabungan.createrekening') }}");
        });

        $(document).on('click', '#no_anggota_search', function() {
            $('#mdlAnggota').modal("show");
        })

        $('#tabelanggota').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}',
            columns: [
                { data: 'no_anggota', name: 'no_anggota' },
                { data: 'nik', name: 'nik' },
                { data: 'nama_lengkap', name: 'nama_lengkap' },
                { data: 'no_hp', name: 'no_hp' },
                { data: 'action', name: 'action' }
            ],
        });

        function getAnggota(no_anggota) {
            $.ajax({
                url: `/anggota/${no_anggota}/getanggota`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $(document).find("#formTabungan").find("#no_anggota").val(response.no_anggota);
                    $(document).find("#formTabungan").find("#no_anggota_text").text(response.no_anggota);
                    $(document).find("#formTabungan").find("#nama_lengkap_text").text(response.nama_lengkap);
                    $("#mdlAnggota").modal("hide");
                }
            });
        }

        $('#tabelanggota tbody').on('click', '.pilihAnggota', function(e) {
            e.preventDefault();
            let no_anggota = $(this).attr('no_anggota');
            getAnggota(no_anggota);
        });

        // Handle Edit RFID Modal
        $(document).on('click', '.btnEditRfid', function(e) {
            e.preventDefault();
            let no_rekening = $(this).data('no-rekening');
            
            $('#formEditRfid')[0].reset();
            $('#edit_rfid').removeClass('is-invalid');
            $('#edit_rfid_error').text('');
            $('#edit_no_rekening').val(no_rekening);
            
            $.ajax({
                url: `{{ url('tabungan') }}/${no_rekening}/edit`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#edit_rfid').val(data.rfid || '');
                        $('#mdlEditRfid').modal('show');
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: response.message });
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data tabungan' });
                }
            });
        });

        // Handle Update RFID
        $('#btnUpdateRfid').click(function() {
            let form = $('#formEditRfid');
            let no_rekening = $('#edit_no_rekening').val();
            let rfid = $('#edit_rfid').val();
            
            $('#edit_rfid').removeClass('is-invalid');
            $('#edit_rfid_error').text('');
            
            if (rfid && rfid.length > 20) {
                $('#edit_rfid').addClass('is-invalid');
                $('#edit_rfid_error').text('RFID maksimal 20 karakter');
                return;
            }
            
            $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');
            
            $.ajax({
                url: `{{ url('tabungan') }}/${no_rekening}/update`,
                type: 'PUT',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#mdlEditRfid').modal('hide');
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000 }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: response.message });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors;
                    if (errors && errors.rfid) {
                        $('#edit_rfid').addClass('is-invalid');
                        $('#edit_rfid_error').text(errors.rfid[0]);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memperbarui data RFID' });
                    }
                },
                complete: function() {
                    $('#btnUpdateRfid').prop('disabled', false).html('<i class="ti ti-save me-1"></i> Simpan Perubahan');
                }
            });
        });

        // Delete Confirm
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data rekening akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        $('#edit_rfid').on('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
</script>
@endpush
