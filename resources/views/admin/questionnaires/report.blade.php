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
                            <canvas id="chart-{{ $i }}" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @foreach($reportData as $i => $q)
    const ctx{{ $i }} = document.getElementById('chart-{{ $i }}').getContext('2d');
    new Chart(ctx{{ $i }}, {
        type: 'bar',
        data: {
            labels: {!! json_encode(collect($q['options'])->pluck('option')) !!},
            datasets: [{
                label: 'Jumlah Jawaban',
                data: {!! json_encode(collect($q['options'])->pluck('count')) !!},
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(40, 167, 69, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(40, 167, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, precision: 0 }
            }
        }
    });
    @endforeach
</script>
@endsection
