@extends('layouts.app')

@section('content')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <div class="statsContainer">
    <canvas id="views"></canvas>
    <canvas id="msgs"></canvas>
  </div>


  <script type="text/javascript">
  // ChartJS
  var ctx = document.getElementById('views').getContext('2d');
  var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
      labels: {!! json_encode($date) !!},
      datasets: [{
        label: 'Visualizzazioni settimana',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: {!! json_encode($lastWeekViews) !!}
      }]
    },

    // Configuration options go here
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    precision: 0
                }
            }]
        }
    }
  });

  var ctx = document.getElementById('msgs').getContext('2d');
  var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
      labels: {!! json_encode($date) !!},
      datasets: [{
        label: 'Messaggi settimana',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: {!! json_encode($lastWeekMsgs) !!}
      }]
    },

    // Configuration options go here
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    precision: 0
                }
            }]
        }
    }
  });
</script>
@endsection
