@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">{{ $questionnaire->title }}</h2>
        <div class="text-muted mb-2">{{ $questionnaire->description }}</div>
        @if(isset($totalRespondents))
        <span class="badge bg-primary mb-2">Total Responden: {{ $totalRespondents }}</span>
        @endif
        <hr>
    </div>
    <div class="row g-4">
        @foreach($reportData as $i => $q)
            <div class="col-lg-6 col-md-12">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Pertanyaan {{ $i+1 }}: <span class="fw-normal">{{ $q['question'] }}</span></h5>
                        <table class="table table-sm table-bordered align-middle mb-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Opsi Jawaban</th>
                                    <th class="text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($q['options'] as $opt)
                                <tr>
                                    <td>{{ $opt['option'] }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success fs-6">{{ $opt['count'] }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="bg-light rounded p-2 mb-2">
                            <div id="chart-{{ $i }}" style="height:120px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('myscript')
<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($reportData as $i => $q)
        var options{{ $i }} = {
            chart: {
                type: 'bar',
                height: 120,
                toolbar: { show: false },
                sparkline: { enabled: true }
            },
            series: [{
                name: 'Jumlah',
                data: {!! json_encode(collect($q['options'])->pluck('count')) !!}
            }],
            xaxis: {
                categories: {!! json_encode(collect($q['options'])->pluck('option')) !!},
                labels: { style: { fontSize: '13px' } }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '60%',
                    borderRadius: 4
                }
            },
            dataLabels: { enabled: true },
            colors: ['#36a2eb', '#ff6384', '#ffcd56', '#4bc0c0', '#9966ff', '#ff9f40', '#28a745'],
            plotOptions: { bar: { distributed: true, horizontal: false, columnWidth: '60%', borderRadius: 4 } },
            grid: { show: false },
            legend: { show: false },
            tooltip: { enabled: true }
        };
        var chart{{ $i }} = new ApexCharts(document.querySelector("#chart-{{ $i }}"), options{{ $i }});
        chart{{ $i }}.render();
        @endforeach
    });
</script>
@endpush
