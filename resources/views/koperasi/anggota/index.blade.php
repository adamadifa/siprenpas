@extends('layouts.app')
@section('titlepage', 'Anggota Koperasi')

@section('content')
@section('navigasi')
    <span>Anggota Koperasi</span>
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                @can('anggota.create')
                    <a href="#" class="btn btn-primary" id="btncreateAnggota"><i class="fa fa-plus me-2"></i> Tambah
                        Anggota Koperasi</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('anggota.index') }}">
                            <div class="row">
                                <div class="col-lg-10 col-sm-12 col-md-12">
                                    <x-input-with-icon label="Cari Nama Anggota Koperasi" value="{{ Request('nama_lengkap') }}" name="nama_lengkap"
                                        icon="ti ti-search" />
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
                                        <th>NO</th>
                                        <th>No. Anggota</th>
                                        <th>NIK</th>
                                        <th>NAMA LENGKAP</th>
                                        <th>TTL</th>
                                        <th>No. HP</th>
                                        <th>Siswa Terkait</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($anggota) == 0)
                                        <tr>
                                            <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    @endif
                                    @foreach ($anggota as $d)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration + $anggota->firstItem() - 1 }}</td>
                                            <td class="">{{ $d->no_anggota }}</td>
                                            <td class="">{{ $d->nik }}</td>
                                            <td><a href="">{{ $d->nama_lengkap }}</a></td>
                                            <td>{{ $d->tempat_lahir }}, {{ $d->tanggal_lahir }}</td>
                                            <td>{{ $d->no_hp }}</td>
                                            <td>
                                                @if ($d->siswa->count() > 0)
                                                    @foreach ($d->siswa as $siswa)
                                                        <span class="badge bg-success me-1">{{ $siswa->nama_lengkap }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Belum ada siswa</span>
                                                @endif
                                            </td>
                                            <td class="table-report__action w-56">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    @can('anggota.edit')
                                                        <a href="#" class="btnEditAnggota me-1"
                                                            no_anggota="{{ Crypt::encrypt($d->no_anggota) }}"><i class="ti ti-edit"></i>
                                                        </a>
                                                    @endcan

                                                    <a class="me-1" href="{{ route('anggota.show', Crypt::encrypt($d->no_anggota)) }}"><i
                                                            class="ti ti-file-description text-info"></i></a>

                                                    <a href="#" class="btnHubungkanSiswa me-1"
                                                        no_anggota="{{ Crypt::encrypt($d->no_anggota) }}" data-bs-toggle="tooltip"
                                                        title="Hubungkan dengan Siswa">
                                                        <i class="ti ti-user-plus text-warning"></i>
                                                    </a>

                                                    @can('anggota.delete')
                                                        <form method="POST" class="deleteform"
                                                            action="{{ route('anggota.delete', Crypt::encrypt($d->no_anggota)) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a class="delete-confirm ml-1">
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
                            {{ $anggota->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-form id="mdlAnggota" size="modal-lg" show="loadmodalAnggota" title="" />

<!-- Modal Hubungkan Siswa -->
<div class="modal fade" id="mdlHubungkanSiswa" tabindex="-1" aria-labelledby="mdlHubungkanSiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlHubungkanSiswaLabel">Hubungkan Siswa dengan Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formHubungkanSiswa">
                    <input type="hidden" id="no_anggota_hidden" name="no_anggota">

                    <div class="mb-3">
                        <label class="form-label">Pilih Siswa</label>
                        <select class="form-select" id="id_siswa" name="id_siswa" required>
                            <option value="">-- Pilih Siswa --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Siswa yang Sudah Terhubung</label>
                        <div id="siswa-terhubung">
                            <!-- Daftar siswa yang sudah terhubung akan dimuat di sini -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanHubungan">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
<script>
    $(function() {
        $("#btncreateAnggota").click(function(e) {
            e.preventDefault();
            $('#mdlAnggota').modal("show");
            $("#loadmodalAnggota").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
            $("#modalAnggota").find(".modal-title").text("Tambah Anggota Koperasi");
            $("#loadmodalAnggota").load('/anggota/create');
        });

        $(".btnEditAnggota").click(function(e) {
            var no_anggota = $(this).attr("no_anggota");
            e.preventDefault();
            $('#mdlAnggota').modal("show");
            $("#loadmodalAnggota").html(`<div class="sk-wave sk-primary" style="margin:auto">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                </div>`);
            $("#modalAnggota").find(".modal-title").text("Edit Anggota Koperasi");
            $("#loadmodalAnggota").load('/anggota/' + no_anggota + '/edit');
        });

        // Fitur Hubungkan Siswa
        $(".btnHubungkanSiswa").click(function(e) {
            e.preventDefault();
            var no_anggota = $(this).attr("no_anggota");
            $('#no_anggota_hidden').val(no_anggota);
            $('#mdlHubungkanSiswa').modal("show");

            // Load data siswa dan siswa yang sudah terhubung
            loadSiswaOptions();
            loadSiswaTerhubung(no_anggota);
        });

        // Load daftar siswa untuk dropdown
        function loadSiswaOptions() {
            $.get('/anggota/get-siswa-options', function(data) {
                $('#id_siswa').html('<option value="">-- Pilih Siswa --</option>');
                $.each(data, function(index, siswa) {
                    $('#id_siswa').append('<option value="' + siswa.id_siswa + '">' + siswa.nama_lengkap + ' (' + siswa
                        .id_siswa + ')</option>');
                });
            });
        }

        // Load siswa yang sudah terhubung
        function loadSiswaTerhubung(no_anggota) {
            $.get('/anggota/get-siswa-terhubung/' + no_anggota, function(data) {
                var html = '';
                if (data.length > 0) {
                    $.each(data, function(index, siswa) {
                        html += '<div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">';
                        html += '<span>' + siswa.nama_lengkap + ' (' + siswa.id_siswa + ')</span>';
                        html += '<button type="button" class="btn btn-sm btn-danger btnHapusHubungan" data-id-siswa="' + siswa
                            .id_siswa + '">';
                        html += '<i class="ti ti-trash"></i> Hapus';
                        html += '</button>';
                        html += '</div>';
                    });
                } else {
                    html = '<p class="text-muted">Belum ada siswa yang terhubung</p>';
                }
                $('#siswa-terhubung').html(html);
            });
        }

        // Simpan hubungan siswa dengan anggota
        $('#btnSimpanHubungan').click(function() {
            var no_anggota = $('#no_anggota_hidden').val();
            var id_siswa = $('#id_siswa').val();

            if (!id_siswa) {
                alert('Pilih siswa terlebih dahulu');
                return;
            }

            $.post('/anggota/hubungkan-siswa', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                no_anggota: no_anggota,
                id_siswa: id_siswa
            }, function(response) {
                if (response.success) {
                    alert('Siswa berhasil dihubungkan');
                    loadSiswaTerhubung(no_anggota);
                    $('#id_siswa').val('');
                    location.reload(); // Reload halaman untuk update tampilan
                } else {
                    alert('Error: ' + response.message);
                }
            });
        });

        // Hapus hubungan siswa
        $(document).on('click', '.btnHapusHubungan', function() {
            var id_siswa = $(this).data('id-siswa');
            var no_anggota = $('#no_anggota_hidden').val();

            if (confirm('Yakin ingin menghapus hubungan ini?')) {
                $.post('/anggota/hapus-hubungan-siswa', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    no_anggota: no_anggota,
                    id_siswa: id_siswa
                }, function(response) {
                    if (response.success) {
                        alert('Hubungan berhasil dihapus');
                        loadSiswaTerhubung(no_anggota);
                        location.reload(); // Reload halaman untuk update tampilan
                    } else {
                        alert('Error: ' + response.message);
                    }
                });
            }
        });

        // Konfirmasi delete anggota
        $(".delete-confirm").click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
