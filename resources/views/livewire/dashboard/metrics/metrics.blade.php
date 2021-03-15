<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Metrics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex-col space-y-4">
            <div class="w-1/3">
                <x-jet-input type="text" wire:model="search" placeholder="Search metrics..." class="w-full"></x-jet-input>
            </div>
            <x-table>
                <x-slot name="head">
                    <x-table.heading>{{ __('ID') }}</x-table.heading>
                    <x-table.heading>{{ __('Title') }}</x-table.heading>
                    <x-table.heading>{{ __('Suffix') }}</x-table.heading>
                    <x-table.heading>{{ __('Order') }}</x-table.heading>
                    <x-table.heading>{{ __('Visibility') }}</x-table.heading>
                    <x-table.heading>
                        @can('add_metrics')
                            @livewire('dashboard.metrics.modals.metric-add-modal')
                        @endcan
                    </x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @foreach($metrics as $metric)
                        <x-table.row wire:loading.class.delay="opacity-50">
                            <x-table.cell>{{ $metric->id }}</x-table.cell>
                            <x-table.cell>{{ $metric->title }}</x-table.cell>
                            <x-table.cell>{{ $metric->suffix }}</x-table.cell>
                            <x-table.cell>{{ $metric->order }}</x-table.cell>
                            <x-table.cell>{{ $metric->visibility ? 'True' : 'False' }}</x-table.cell>
                            <x-table.cell>
                                @can('edit_metrics')
                                    <livewire:dashboard.metrics.modals.metric-update-modal :metric="$metric" :key="time().$metric->id" />
                                @endcan
                                @can('delete_metrics')
                                    <livewire:dashboard.metrics.modals.metric-delete-modal :metric="$metric" :key="time().time().$metric->id" />
                                @endcan
                                @can('delete_metric_points')
                                    <livewire:dashboard.metrics.modals.metric-delete-points-modal :metric="$metric" :key="time().time().time().$metric->id" />
                                @endcan
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-slot>
            </x-table>

            <div>
                {{ $metrics->links() }}
            </div>
        </div>
    </div>
</div>
