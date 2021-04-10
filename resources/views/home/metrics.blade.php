@if($metric_count > 0)
    <div class="mt-12">
        <div class="flex justify-between">
            <h2 class="text-2xl">
                Metrics
            </h2>
            <div class="space-x-2 flex items-center">
                <x-input.group borderless paddingless for="lastHours" label="Last" inline="true">
                    <x-input.select wire:model="lastHours" id="lastHours" class="rounded-md">
                        <option value="24">1 Day</option>
                        <option value="48">2 Days</option>
                        <option value="72">3 Days</option>
                        <option value="168">7 Days</option>
                    </x-input.select>
                </x-input.group>
                <x-input.group borderless paddingless for="interval" label="Interval" inline="true">
                    <x-input.select wire:model="interval" id="interval" class="rounded-md">
                        <!-- <option value="5">5 Minutes</option>
                        <option value="15">15 Minutes</option> -->
                        <option value="30">30 Minutes</option>
                        <option value="60">1 Hour</option>
                    </x-input.select>
                </x-input.group>
            </div>
        </div>
        <div wire:init="loadData">
            @foreach($metrics as $metric)
                <div x-data="{ openMetric{{ $metric->id }}: {{ $metric->shouldExpand() }} }">
                    <div class="bg-white text-black dark:bg-discordBlack dark:text-white px-4 py-5 sm:px-6 mt-2 shadow sm:rounded-md text-center text-xl font-bold">
                        <div @click="openMetric{{ $metric->id }} = !openMetric{{ $metric->id }}" class="flex flex-row">
                            <div>
                                <button class="focus:outline-none">
                                    <svg class="h-4 w-4 text-black dark:text-white" x-show="!openMetric{{ $metric->id }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                    </svg>
                                    <svg class="h-4 w-4 text-black dark:text-white" x-show="openMetric{{ $metric->id }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex-grow">
                                {{ $metric->title }}
                            </div>
                        </div>
                        <div x-show="openMetric{{ $metric->id }}">
                            <livewire:home.metric :metric="$metric" :interval="$interval" :last-hours="$lastHours" :key="time().$metric->id"/>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
