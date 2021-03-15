<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('maintenances.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex-col space-y-4">
            <div class="w-1/3">
                <x-jet-input type="text" wire:model="search" placeholder="Search maintenances..." class="w-full"></x-jet-input>
            </div>
            <x-table>
                <x-slot name="head">
                    <x-table.heading>{{ __('maintenances.table.head.id') }}</x-table.heading>
                    <x-table.heading>{{ __('maintenances.table.head.title') }}</x-table.heading>
                    <x-table.heading>{{ __('maintenances.table.head.status') }}</x-table.heading>
                    <x-table.heading>{{ __('maintenances.table.head.impact') }}</x-table.heading>
                    <x-table.heading>{{ __('maintenances.table.head.scheduled_at') }}</x-table.heading>
                    <x-table.heading>{{ __('maintenances.table.head.end_at') }}</x-table.heading>
                    <x-table.heading>{{ __('maintenances.table.head.reporter') }}</x-table.heading>
                    <x-table.heading>
                        @can('add_incidents')
                            @livewire('dashboard.maintenances.modals.maintenance-add-modal')
                        @endcan
                    </x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($maintenances as $maintenance)
                        <x-table.row wire:loading.class.delay="opacity-50">
                            <x-table.cell>{{ $maintenance->id }}</x-table.cell>
                            <x-table.cell>{{ $maintenance->title }}</x-table.cell>
                            <x-table.cell>{{ $maintenance->getType() }}</x-table.cell>
                            <x-table.cell>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $maintenance->getImpactColor() }} text-white">
                                    &nbsp;&nbsp;
                                </span>
                            </x-table.cell>
                            <x-table.cell>{{ $maintenance->scheduled_at }}</x-table.cell>
                            <x-table.cell>{{ $maintenance->end_at }}</x-table.cell>
                            <x-table.cell>{{ $maintenance->getReporter()->name }}</x-table.cell>
                            <x-table.cell>
                                @can('edit_incidents')
                                    <livewire:dashboard.maintenances.modals.maintenance-update-modal :maintenance="$maintenance" :key="time().$maintenance->id" />
                                @endcan
                                @can('delete_incidents')
                                    <livewire:dashboard.incidents.modals.incident-delete-modal :incident="$maintenance" :key="time().time().$maintenance->id" />
                                @endcan
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="6">
                                <div class="flex justify-center items-center">
                                    <span class="font-medium py-8 text-gray-400 text-xl">No results...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table>

            <div>
                {{ $maintenances->links() }}
            </div>
        </div>
    </div>
</div>
