@extends('layouts.app')
@section('titlepage', 'Data Tabungan Koperasi')

@section('content')
@section('navigasi')
    <span>Data Tabungan</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-primary" id="btncreateRekening"><i class="fa fa-plus me-2"></i> Buat Rekening</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ URL::current() }}">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Cari Nama Anggota Koperasi" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                        icon="ti ti-search" />
                                </div>
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <select name="kode_tabungan" id="kode_tabungan" class="form-select select2Kodetabungan">
                                            <option value="">Jenis Tabungan</option>
                                            @foreach ($jenis_tabungan as $item)
                                                <option {{ Request('kode_tabungan') == $item->kode_tabungan ? 'selected' : '' }}
                                                    value="{{ $item->kode_tabungan }}">{{ $item->kode_tabungan }} {{ $item->jenis_tabungan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-12 col-md-12">
                                    <button class="btn btn-primary">Cari</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mb-2">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Rekening</th>
                                        <th>No. Anggota</th>
                                        <th>Nama Lengkap</th>
                                        <th>Kode</th>
                                        <th>Jenis Tabungan</th>
                                        <th>Saldo</th>
                                        <th>RFID</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($tabungan) == 0)
                                        <tr>
                                            <td colspan="9" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    @endif
                                    @foreach ($tabungan as $d)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration + $tabungan->firstItem() - 1 }}</td>
                                            <td class="">{{ $d->no_rekening }}</td>
                                            <td class="">{{ $d->no_anggota }}</td>
                                            <td><a href="">{{ $d->nama_lengkap }}</a></td>
                                            <td>{{ $d->kode_tabungan }}</td>
                                            <td>{{ $d->jenis_tabungan }}</td>
                                            <td class="text-end">{{ formatAngka($d->saldo) }}</td>
                                            <td class="text-center">
                                                @if($d->rfid)
                                                    <span class="badge bg-success">{{ $d->rfid }}</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td class="table-report__action w-56">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    @can('tabungan.index')
                                                        <a href="{{ route('tabungan.show', Crypt::encrypt($d->no_rekening)) }}" class="me-1" title="Detail">
                                                            <i class="ti ti-book"></i>
                                                        </a>
                                                    @endcan
                                                    @can('tabungan.edit')
                                                        <a href="javascript:void(0)" class="me-1 btnEditRfid" 
                                                           data-no-rekening="{{ Crypt::encrypt($d->no_rekening) }}" title="Edit RFID">
                                                            <i class="ti ti-link text-info"></i>
                                                        </a>
                                                    @endcan
                                                    @can('tabungan.delete')
                                                        <form method="POST" class="deleteform"
                                                            action="{{ route('tabungan.deleterekening', Crypt::encrypt($d->no_rekening)) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a class="delete-confirm ml-1" title="Hapus">
                                                                <i class="ti ti-trash text-danger"></i>
                                                            </a>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="float: right;">
                            {{ $tabungan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="mdlRekening" size="" show="loadmodalRekening" title="" />
<div class="modal fade" id="mdlAnggota" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18">Data Anggota</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="tabelanggota">
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

<!-- Modal Edit RFID -->
<div class="modal fade" id="mdlEditRfid" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabelEditRfid">Edit RFID Tabungan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditRfid">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_no_rekening" name="no_rekening">
                    
                    <div class="mb-3">
                        <label for="edit_rfid" class="form-label">RFID</label>
                        <input type="text" class="form-control" id="edit_rfid" name="rfid" 
                               placeholder="Masukkan kode RFID" maxlength="20">
                        <div class="invalid-feedback" id="edit_rfid_error"></div>
                        <small class="form-text text-muted">
                            Kode RFID harus unik dan maksimal 20 karakter. Kosongkan jika tidak ada RFID.
                        </small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnUpdateRfid">
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

        $("#btncreateRekening").click(function() {
            $('#mdlRekening').modal("show");
            $("#loadmodalRekening").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
            $("#mdlRekening").find(".modal-title").text("Buat Rekening");
            $("#loadmodalRekening").load("{{ route('tabungan.createrekening') }}");
        });

        $(document).on('click', '#no_anggota_search', function() {
            $('#mdlAnggota').modal("show");
        })


        $('#tabelanggota').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}', // memanggil route yang menampilkan data json
            columns: [{ // mengambil & menampilkan kolom sesuai tabel database
                    data: 'no_anggota',
                    name: 'no_anggota'
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama_lengkap',
                    name: 'nama_lengkap'
                },
                {
                    data: 'no_hp',
                    name: 'no_hp'
                },
                {
                    data: 'action',
                    name: 'action'
                }
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
        $(document).on('click', '.btnEditRfid', function() {
            let no_rekening = $(this).data('no-rekening');
            
            // Reset form
            $('#formEditRfid')[0].reset();
            $('#edit_rfid').removeClass('is-invalid');
            $('#edit_rfid_error').text('');
            
            // Set no_rekening
            $('#edit_no_rekening').val(no_rekening);
            
            // Load data RFID saja
            $.ajax({
                url: `{{ url('tabungan') }}/${no_rekening}/edit`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#edit_rfid').val(data.rfid || '');
                        $('#mdlEditRfid').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat data tabungan'
                    });
                }
            });
        });

        // Handle Update RFID
        $('#btnUpdateRfid').click(function() {
            let form = $('#formEditRfid');
            let no_rekening = $('#edit_no_rekening').val();
            let rfid = $('#edit_rfid').val();
            
            // Reset validation
            $('#edit_rfid').removeClass('is-invalid');
            $('#edit_rfid_error').text('');
            
            // Validate
            if (rfid && rfid.length > 20) {
                $('#edit_rfid').addClass('is-invalid');
                $('#edit_rfid_error').text('RFID maksimal 20 karakter');
                return;
            }
            
            // Disable button
            $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');
            
            $.ajax({
                url: `{{ url('tabungan') }}/${no_rekening}/update`,
                type: 'PUT',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#mdlEditRfid').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors;
                    if (errors && errors.rfid) {
                        $('#edit_rfid').addClass('is-invalid');
                        $('#edit_rfid_error').text(errors.rfid[0]);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memperbarui data RFID'
                        });
                    }
                },
                complete: function() {
                    $('#btnUpdateRfid').prop('disabled', false).html('<i class="ti ti-save me-1"></i> Simpan Perubahan');
                }
            });
        });

        // Auto-format RFID input (uppercase)
        $('#edit_rfid').on('input', function() {
            this.value = this.value.toUpperCase();
        });

    });
</script>
@endpush
