@if(\App\Models\Metric::query()->where('visibility', true)->count() > 0)
    <div class="mt-12">
        <div class="flex justify-between">
            <h2 class="text-2xl">
                Metrics
            </h2>
            <div class="space-x-2 flex items-center">
                <div wire:loading>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 animate-spin">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
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
                        <option value="5">5 Minutes</option>
                        <option value="15">15 Minutes</option>
                        <option value="30">30 Minutes</option>
                        <option value="60">1 Hour</option>
                    </x-input.select>
                </x-input.group>
            </div>
        </div>
        <div wire:init="loadData">
            @foreach($metrics as $metric)
                <div>
                    <livewire:home.metric :metric="$metric" :interval="$interval" :last-hours="$lastHours" :key="time().$metric->id"/>
                </div>
            @endforeach
        </div>
    </div>
@endif
