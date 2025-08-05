@extends('layouts.app')
@section('titlepage', 'Laporan Keuangan')

@section('content')
@section('navigasi')
    <span>Laporan Keuangan</span>
@endsection
<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="nav-align-left nav-tabs-shadow mb-4">
            <ul class="nav nav-tabs" role="tablist">
                @can('lk.rekaptagihan')
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#rekaptagihan" aria-controls="rekaptagihan" aria-selected="false"
                            tabindex="-1">
                            Rekap Tagihan
                        </button>
                    </li>
                @endcan
                @can('lk.pembayaran')
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#pembayaran" aria-controls="pembayaran" aria-selected="false" tabindex="-1">
                            Pembayaran
                        </button>
                    </li>
                @endcan

            </ul>
            <div class="tab-content">
                <!-- Laporan Persediaan-->
                @can('lk.rekaptagihan')
                    <div class="tab-pane fade active show" id="rekaptagihan" role="tabpanel">
                        @include('keuangan.laporan.rekaptagihan')
                    </div>
                @endcan
                @can('lk.pembayaran')
                    <div class="tab-pane fade" id="pembayaran" role="tabpanel">
                        @include('keuangan.laporan.pembayaran')
                    </div>
                @endcan
            </div>
        </div>
    </div>
</div>


@endsection
@push('myscript')
<script>
    $(function() {

        const formRekapTagihan = $('#formRekapTagihan');
        const formPembayaran = $('#formPembayaran');


        $("#formRekapTagihan").find("#kode_unit").on('change', function() {
            getTingkatByUnit($(this).val(), '', '#formRekapTagihan');
        });

        $("#formPembayaran").find("#kode_unit").on('change', function() {
            getTingkatByUnit($(this).val(), '', '#formPembayaran');
        });


        $("#formRekapTagihan").submit(function(e) {
            let unit = $(this).find("#kode_unit").val();
            let tingkat = $(this).find("#tingkat").val();
            let kode_ta = $(this).find("#kode_ta_search").val();

            if (unit == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Unit tidak boleh kosong!',
                    didClose: (e) => {
                        formRekapTagihan.find("#kode_unit").focus();
                    }
                });
                return false;
            }else if(tingkat == ""){
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tingkat tidak boleh kosong!',
                    didClose: (e) => {
                        formRekapTagihan.find("#tingkat").focus();
                    }
                });
                return false;
            }else if(kode_ta == ""){
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tahun Ajaran tidak boleh kosong!',
                    didClose: (e) => {
                        formRekapTagihan.find("#kode_ta_search").focus();
                    }
                });
                return false;
            }


        });


        function getTingkatByUnit(kode_unit, selected = '', formName = '') {

            $.ajax({
                type: "POST",
                url: "{{ route('unit.gettingkatbyunit') }}",
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_unit: kode_unit,
                    selected: selected
                },
                success: function(respond) {
                    $(formName).find("#tingkat").html(respond);
                }
            });

        }
    });
</script>
@endpush
