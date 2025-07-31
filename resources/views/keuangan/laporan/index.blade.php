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
                            data-bs-target="#presensi" aria-controls="presensi" aria-selected="false" tabindex="-1">
                            Rekap Tagihan
                        </button>
                    </li>
                @endcan
                @can('lk.pembayaran')
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#checklistibadah" aria-controls="checklistibadah" aria-selected="false"
                            tabindex="-1">
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
        $('#kode_unit').on('change', function() {
            const kode_unit = $(this).val();
            getTingkatByUnit(kode_unit);
        });



        function getTingkatByUnit(kode_unit, selected = '') {
            selected = "{{ Request('tingkat') }}"
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
                    $(document).find("#tingkat").html(respond);
                }
            });

        }
    });
</script>
@endpush
