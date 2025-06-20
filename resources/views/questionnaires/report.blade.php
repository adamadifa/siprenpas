@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Report Hasil Kuisioner: {{ $questionnaire->title }}</h2>
    <p>{{ $questionnaire->description }}</p>
    <hr>
    @foreach($reportData as $i => $q)
        <div class="mb-4">
            <h5>Pertanyaan {{ $i+1 }}: {{ $q['question'] }}</h5>
            <table class="table table-bordered mb-2" style="max-width:400px">
                <thead>
                    <tr>
                        <th>Opsi Jawaban</th>
                        <th>Jumlah Orang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($q['options'] as $opt)
                        <tr>
                            <td>{{ $opt['option'] }}</td>
                            <td>{{ $opt['count'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <canvas id="chart-{{ $i }}" height="100"></canvas>
        </div>
    @endforeach
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
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, precision: 0 }
            }
        }
    });
    @endforeach
</script>
@endsection
