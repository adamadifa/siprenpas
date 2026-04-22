@extends('layouts.app')
@section('titlepage', 'Data Pembiayaan Koperasi')

@section('content')
@section('navigasi')
    <div class="card shadow-none bg-transparent border-0 mb-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md bg-label-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-cash-banknote fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" style="color: #064e3b">Data Pembiayaan</h4>
                        <p class="text-muted mb-0 small">Manajemen pembiayaan dan cicilan anggota koperasi</p>
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
                                <i class="ti ti-cash-banknote me-1"></i> Pembiayaan
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
            @can('pembiayaan.create')
                <button class="btn d-flex align-items-center gap-2 shadow-sm text-white" id="btncreatePembiayaan"
                    style="background-color: #064e3b">
                    <i class="ti ti-plus fs-4"></i>
                    <span>Input Pembiayaan</span>
                </button>
            @endcan
        </div>

        <!-- Filter Form -->
        <div class="card mb-4 shadow-none border-0 bg-transparent">
            <div class="card-body p-0">
                <form action="{{ URL::current() }}">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-10 col-md-9">
                            <x-input-with-icon label="" value="{{ Request('nama_anggota') }}" name="nama_anggota"
                                placeholder="Cari Nama Anggota Koperasi" icon="ti ti-search" />
                        </div>
                        <div class="col-lg-2 col-md-3">
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
                <h6 class="card-title mb-0 text-white">Data Akad Pembiayaan</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-nowrap">
                        <thead style="background-color: #064e3b">
                            <tr>
                                <th class="text-white py-3">NO</th>
                                <th class="text-white py-3">NO. AKAD</th>
                                <th class="text-white py-3">TANGGAL</th>
                                <th class="text-white py-3">NO. ANGGOTA</th>
                                <th class="text-white py-3">NAMA ANGGOTA</th>
                                <th class="text-white py-3">JENIS PEMBIAYAAN</th>
                                <th class="text-white py-3 text-end">POKOK</th>
                                <th class="text-white py-3 text-end">PEMBIAYAAN</th>
                                <th class="text-white py-3 text-center">L/BL</th>
                                <th class="text-white py-3 text-center">STATUS</th>
                                <th class="text-white py-3 text-end" style="width: 80px;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pembiayaan as $d)
                                <tr>
                                    <td class="text-center py-2">{{ $loop->iteration + $pembiayaan->firstItem() - 1 }}</td>
                                    <td class="py-2 text-dark fw-bold">{{ $d->no_akad }}</td>
                                    <td class="py-2 small">{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                    <td class="py-2 small">{{ $d->no_anggota }}</td>
                                    <td class="py-2 fw-bold text-dark">{{ $d->nama_lengkap }}</td>
                                    <td class="py-2">
                                        <span class="badge bg-label-info">{{ $d->jenis_pembiayaan }}</span>
                                    </td>
                                    <td class="py-2 text-end text-dark fw-bold">{{ formatAngka($d->jumlah) }}</td>
                                    <td class="py-2 text-end text-primary fw-bold">
                                        @php
                                            $jumlah_pembiayaan = $d->jumlah + $d->jumlah * ($d->persentase / 100);
                                        @endphp
                                        {{ formatAngka($jumlah_pembiayaan) }}
                                    </td>
                                    <td class="py-2 text-center">
                                        @if ($d->total_bayar == $jumlah_pembiayaan)
                                            <span class="badge bg-label-success rounded-pill">L</span>
                                        @else
                                            <span class="badge bg-label-danger rounded-pill">BL</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-center">
                                        @if ($d->status == 1)
                                            <span class="badge bg-label-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-label-warning">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('tabungan.index')
                                                <a href="{{ route('pembiayaan.show', Crypt::encrypt($d->no_akad)) }}" 
                                                   class="btn btn-icon btn-label-success border"
                                                   style="width: 28px; height: 28px;" title="Detail Pembiayaan">
                                                    <i class="ti ti-book fs-6"></i>
                                                </a>
                                            @endcan
                                            @can('tabungan.delete')
                                                @if ($d->jmlbayar == 0)
                                                    <form method="POST" class="deleteform"
                                                        action="{{ route('pembiayaan.delete', Crypt::encrypt($d->no_akad)) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:void(0)" class="btn btn-icon btn-label-danger border delete-confirm"
                                                           style="width: 28px; height: 28px;" title="Hapus Akad">
                                                            <i class="ti ti-trash fs-6"></i>
                                                        </a>
                                                    </form>
                                                @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center p-5">
                                        <div class="mb-3">
                                            <i class="ti ti-history-off fs-1 opacity-25"></i>
                                        </div>
                                        <h5>Data tidak ditemukan</h5>
                                        <p class="text-muted small">Silahkan sesuaikan filter pencarian akad pembiayaan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-2">
                <div class="d-flex justify-content-end">
                    {{ $pembiayaan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal-form id="mdlPembiayaan" size="modal-lg" show="loadmodalPembiayaan" title="" />
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
@endsection

@push('myscript')
<script>
    $(function() {
        const loading = `<div class="d-flex justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>`;

        $("#btncreatePembiayaan").click(function(e) {
            e.preventDefault();
            $('#mdlPembiayaan').modal("show");
            $(".modal-title").text("Tambah Data Pembiayaan");
            $("#loadmodalPembiayaan").html(loading);
            $("#loadmodalPembiayaan").load("{{ route('pembiayaan.create') }}");
        })

        $(document).on('show.bs.modal', '.modal', function() {
            const zIndex = 1090 + 10 * $('.modal:visible').length;
            $(this).css('z-index', zIndex);
            setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1)
                .addClass('modal-stack'));
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
                    const form = $(document).find("#formPembiayaan");
                    form.find("#no_anggota").val(response.no_anggota);
                    form.find("#nik").val(response.nik);
                    form.find("#nama_lengkap").val(response.nama_lengkap);
                    form.find("#no_hp").val(response.no_hp);
                    form.find("#tempat_lahir").val(response.tempat_lahir);
                    form.find("#tanggal_lahir").val(response.tanggal_lahir);
                    form.find("#jenis_kelamin").val(response.jenis_kelamin);
                    form.find("#pendidikan_terakhir").val(response.pendidikan_terakhir);
                    form.find("#status_pernikahan").val(response.status_pernikahan);
                    form.find("#jml_tanggungan").val(response.jml_tanggungan);
                    form.find("#nama_pasangan").val(response.nama_pasangan);
                    form.find("#pekerjaan_pasangan").val(response.pekerjaan_pasangan);
                    form.find("#nama_ibu").val(response.nama_ibu);
                    form.find("#nama_saudara").val(response.nama_saudara);
                    form.find("#alamat").val(response.alamat);
                    form.find("#id_province").val(response.id_province).trigger('change');
                    getRegency(response.id_province, response.id_regency);
                    getDistrict(response.id_regency, response.id_district);
                    getVillage(response.id_district, response.id_village);
                    form.find("#kode_pos").val(response.kode_pos);
                    form.find("#status_tinggal").val(response.status_tinggal);
                    enableFields();
                    $("#mdlAnggota").modal("hide");
                }
            });
        }

        function getRegency(id_province, id_regency) {
            $.ajax({
                type: 'POST',
                url: '/regency/getregencybyprovince',
                data: { _token: "{{ csrf_token() }}", id_province: id_province, id_regency: id_regency },
                cache: false,
                success: function(respond) { $(document).find("#formPembiayaan").find("#id_regency").html(respond); }
            });
        }

        function getDistrict(id_regency, id_district) {
            $.ajax({
                type: 'POST',
                url: '/district/getdistrictbyregency',
                data: { _token: "{{ csrf_token() }}", id_regency: id_regency, id_district: id_district },
                cache: false,
                success: function(respond) { $(document).find("#formPembiayaan").find("#id_district").html(respond); }
            });
        }

        function getVillage(id_district, id_village) {
            $.ajax({
                type: 'POST',
                url: '/village/getvillagebydistrict',
                data: { _token: "{{ csrf_token() }}", id_district: id_district, id_village: id_village },
                cache: false,
                success: function(respond) { $(document).find("#formPembiayaan").find("#id_village").html(respond); }
            });
        }

        $(document).on('change', '#id_province', function() { getRegency($(this).val(), ""); })
        $(document).on('change', '#id_regency', function() { getDistrict($(this).val(), ""); })
        $(document).on('change', '#id_district', function() { getVillage($(this).val(), ""); })

        $('#tabelanggota tbody').on('click', '.pilihAnggota', function(e) {
            e.preventDefault();
            let no_anggota = $(this).attr('no_anggota');
            getAnggota(no_anggota);
        });

        $(document).on('change', '#kode_pembiayaan', function() {
            let persentase = $('option:selected', this).attr('persentase');
            const form = $(document).find("#formPembiayaan");
            form.find("#persentase").val(persentase);
            let jml = form.find("#formPembiayaan").find("#jumlah").val() || "0";
            let jumlah = jml.replace(/\./g, '');
            var jumlah_pengembalian = parseInt(jumlah) + (parseInt(jumlah) * (parseInt(persentase) / 100));
            form.find("#jumlah_pengembalian").val(convertToRupiah(jumlah_pengembalian || 0));
        });

        $(document).on('keyup keydown', '#jumlah', function() {
            const form = $(document).find("#formPembiayaan");
            let persentase = form.find("#persentase").val() || 0;
            let jml = $(this).val() || "0";
            let jumlah = jml.replace(/\./g, '');
            var jumlah_pengembalian = parseInt(jumlah) + (parseInt(jumlah) * (parseInt(persentase) / 100));
            form.find("#jumlah_pengembalian").val(convertToRupiah(jumlah_pengembalian || 0));
        })

        function convertToRupiah(number) {
            if (number) {
                var rupiah = "";
                var numberrev = number.toString().split("").reverse().join("");
                for (var i = 0; i < numberrev.length; i++)
                    if (i % 3 == 0) rupiah += numberrev.substr(i, 3) + ".";
                return rupiah.split("", rupiah.length - 1).reverse().join("");
            } else {
                return number;
            }
        }

        // Delete Confirm
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data akad pembiayaan akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064e3b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        });

        function enableFields() {
            const form = $(document).find("#formPembiayaan");
            form.find('input, select, textarea').removeAttr('disabled');
        }
    });
</script>
@endpush
