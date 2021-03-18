<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('past.title_incidents') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex-col space-y-4">
            <div class="flex justify-between">
                <div class="w-1/3 flex space-x-2">
                    <x-jet-input type="text" wire:model="search" placeholder="Search Past Incidents..." class="w-full"></x-jet-input>
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
                </div>
            </div>
            <x-table>
                <x-slot name="head">
                    <x-table.heading>{{ __('past.tables.head.id')  }}</x-table.heading>
                    <x-table.heading>{{ __('past.tables.head.title')  }}</x-table.heading>
                    <x-table.heading>{{ __('past.tables.head.status')  }}</x-table.heading>
                    <x-table.heading>{{ __('past.tables.head.impact')  }}</x-table.heading>
                    <x-table.heading>{{ __('past.tables.head.reporter')  }}</x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($old_incidents as $incident)
                        <x-table.row wire:loading.class.delay="opacity-50">
                            <x-table.cell>{{ $incident->id }}</x-table.cell>
                            <x-table.cell>{{ $incident->title }}</x-table.cell>
                            <x-table.cell>{{ $incident->getType() }}</x-table.cell>
                            <x-table.cell>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $incident->getImpactColor() }} text-white">
                                    &nbsp;&nbsp;
                                </span>
                            </x-table.cell>
                            <x-table.cell>{{ $incident->getReporter()->name }}</x-table.cell>
                            <x-table.cell>
                                @can('delete_incidents')
                                    <livewire:dashboard.incidents.modals.incident-delete-modal :incident="$incident" :key="time().$incident->id" />
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
                {{ $old_incidents->links() }}
            </div>
        </div>
    </div>
</div>


