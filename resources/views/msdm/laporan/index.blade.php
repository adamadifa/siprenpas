@extends('layouts.app')
@section('titlepage', 'Laporan MSDM')

@section('content')
@section('navigasi')
    <span>Laporan MSDM</span>
@endsection
<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="nav-align-left nav-tabs-shadow mb-4">
            <ul class="nav nav-tabs" role="tablist">
                @can('presensi.index')
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#presensi" aria-controls="presensi" aria-selected="false" tabindex="-1">
                            Presensi
                        </button>
                    </li>
                @endcan
                @can('presensi.index')
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#checklistibadah" aria-controls="checklistibadah" aria-selected="false"
                            tabindex="-1">
                            Checklist ibadah
                        </button>
                    </li>
                @endcan

            </ul>
            <div class="tab-content">
                <!-- Laporan Persediaan-->
                @can('presensi.index')
                    <div class="tab-pane fade active show" id="presensi" role="tabpanel">
                        @include('msdm.laporan.presensi')
                    </div>
                @endcan
                @can('presensi.index')
                    <div class="tab-pane fade" id="checklistibadah" role="tabpanel">
                        @include('msdm.laporan.checklistibadah')
                    </div>
                @endcan
            </div>
        </div>
    </div>
</div>


@endsection
@push('myscript')
{{-- <script src="{{ asset('assets/js/pages/roles/create.js') }}"></script> --}}
@endpush
