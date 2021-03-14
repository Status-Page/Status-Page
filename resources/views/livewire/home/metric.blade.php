<div>
    <div class="bg-white text-black dark:bg-discordBlack dark:text-white px-4 py-5 sm:px-6 mt-2 shadow sm:rounded-md">
        <h3 class="text-lg leading-6 font-medium">
            <canvas id="metric-{{ $metric->id }}" width="400" height="150"></canvas>
        </h3>
    </div>
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
                    fontColor: '{{ config('statuspage.darkmode') ? '#ffffff' : '#000000' }}',
                    text: '{{ $metric->title }}'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            stacked: true
                        }
                    }]
                },
                elements: {
                    point:{
                        radius: 0.75
                    }
                }
            }
        });
    </script>
</div>
