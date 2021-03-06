<div>
    <canvas id="metric-{{ $metric->id }}" width="400" height="150"></canvas>
    <script>
        var ctx = document.getElementById('metric-{{ $metric->id }}').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $labels !!},
                datasets: [{
                    label: '{{ $metric->suffix }}',
                    data:  {!! $data !!},
                    backgroundColor: 'rgba(85, 153, 255, 0.2)',
                    borderColor: 'rgba(85, 153, 255, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    fontSize: 20,
                    text: '{{ $metric->title }}'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            stacked: true
                        }
                    }]
                }
            }
        });
    </script>
</div>
