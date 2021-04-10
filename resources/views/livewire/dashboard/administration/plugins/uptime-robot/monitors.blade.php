<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('uptimerobot.title_prefix') }} {{ __('uptimerobot.title') }}
        </h2>
        <p class="text-white dark:text-gray-400">Note: Data shown here is updated every minute.</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex-col space-y-4">
            <div class="flex justify-between">
                <div class="w-1/3 flex space-x-2">
                    <x-input-dark type="text" wire:model="search" placeholder="Search Monitors..." class="w-full dark:bg-discordDark"></x-input-dark>
                </div>

                <div class="space-x-2 flex items-center">
                    <x-input.group borderless paddingless for="perPage" label="Per Page">
                        <x-input.select wire:model="perPage" id="perPage" class="rounded-md">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </x-input.select>
                    </x-input.group>
                    <x-jet-button wire:click="reload">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6" wire:loading.class="animate-spin">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </x-jet-button>
                </div>
            </div>
            <x-table>
                <x-slot name="head">
                    <x-table.heading>{{ __('ID') }}</x-table.heading>
                    <x-table.heading>{{ __('Monitor ID') }}</x-table.heading>
                    <x-table.heading>{{ __('Name') }}</x-table.heading>
                    <x-table.heading>{{ __('Component') }}</x-table.heading>
                    <x-table.heading>{{ __('Metric') }}</x-table.heading>
                    <x-table.heading>{{ __('Data Import') }}</x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($monitors as $monitor)
                        <x-table.row wire:loading.class.delay="opacity-50">
                            <x-table.cell>{{ $monitor->id }}</x-table.cell>
                            <x-table.cell>{{ $monitor->monitor_id }}</x-table.cell>
                            <x-table.cell>{{ $monitor->friendly_name }}</x-table.cell>
                            <x-table.cell>{{ $monitor->component_id ? $monitor->component()->first()->name : 'None' }}</x-table.cell>
                            <x-table.cell>{{ $monitor->metric_id ? $monitor->metric()->first()->title : 'None' }}</x-table.cell>
                            <x-table.cell>
                                @can('edit_settings')
                                    <button wire:loading.attr="disabled" wire:click="changePause({{ $monitor->id }}, {{ $monitor->paused }})" data-title="{{ __('Click to Change') }}" data-placement="top" class="text-indigo-600 hover:text-indigo-900">{{ $monitor->paused ? 'Paused' : 'Active' }}</button>
                                @elsecan
                                    {{ $monitor->paused ? 'Paused' : 'Active' }}
                                @endcan
                            </x-table.cell>
                            <x-table.cell>
                                <div class="space-x-2 flex items-center">
                                    @can('edit_settings')
                                        <livewire:dashboard.administration.plugins.uptime-robot.modals.update-monitor :monitor="$monitor" :key="time().$monitor->id" />
                                    @endcan
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="7">
                                <div class="flex justify-center items-center">
                                    <span class="font-medium py-8 text-gray-400 text-xl">No results...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table>

            <div>
                {{ $monitors->links() }}
            </div>
        </div>
    </div>
</div>
