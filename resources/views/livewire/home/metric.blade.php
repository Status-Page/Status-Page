<div>
    <div class="bg-white text-black dark:bg-discordBlack dark:text-white px-4 py-5 sm:px-6 mt-2 shadow sm:rounded-md">
        <canvas id="metric-{{ $metric->id }}-{{ time() }}" width="400" height="150"></canvas>
    </div>
    <script>
        var event{{ $metric->id }} = new Event('refreshJavaScript-{{ $metric->id }}');

        var event{{ $metric->id }}Listener = document.addEventListener('refreshJavaScript-{{ $metric->id }}', () => {
            var ctx = document.getElementById('metric-{{ $metric->id }}-{{ time() }}').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($metricData->labels) !!},
                    datasets: [{
                        label: '{{ $metric->suffix }}',
                        data:  {!! json_encode($metricData->points) !!},
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
                        fontColor: '{{ session()->get('darkmode', config('statuspage.darkmode')) ? '#ffffff' : '#000000' }}',
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
        })

        document.dispatchEvent(event{{ $metric->id }});
    </script>
</div>
