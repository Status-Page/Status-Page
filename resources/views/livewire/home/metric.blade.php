<div>
    <!-- <div class="text-right">
        <label>
            <select wire:model="unit" wire:change="update" class="dark:bg-discordBlack mt-1 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="24">Last 24 Hours</option>
                <option value="48">Last 48 Hours</option>
            </select>
        </label>
    </div> -->
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
                }
            }
        });
    </script>
</div>
