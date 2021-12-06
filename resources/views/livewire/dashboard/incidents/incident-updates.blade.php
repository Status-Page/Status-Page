<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('incidents.incident_updates.title') }} "{{ $incident->title }}"
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex-col space-y-4">
            <div class="flex justify-between">
                <div class="w-1/3 flex space-x-2">
                    <!-- <x-input-dark type="text" wire:model="search" placeholder="Search Incidents..." class="w-full"></x-input-dark> -->
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
                    <x-table.heading>{{ __('incidents.incident_updates.table.head.id') }}</x-table.heading>
                    <x-table.heading>{{ __('incidents.incident_updates.table.head.update_type') }}</x-table.heading>
                    <x-table.heading>{{ __('incidents.incident_updates.table.head.status_update') }}</x-table.heading>
                    <x-table.heading>{{ __('incidents.incident_updates.table.head.text') }}</x-table.heading>
                    <x-table.heading>{{ __('incidents.incident_updates.table.head.reporter') }}</x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($incidentUpdates as $update)
                        <x-table.row wire:loading.class.delay="opacity-50">
                            <x-table.cell>{{ $update->id }}</x-table.cell>
                            <x-table.cell>{{ $update->getType() }}</x-table.cell>
                            <x-table.cell>{{ $update->getStatus() }}</x-table.cell>
                            <x-table.cell class="markdown-content">{!! \Illuminate\Support\Str::markdown($update->text) !!}</x-table.cell>
                            <x-table.cell>{{ $update->getReporter()->name }}</x-table.cell>
                            <x-table.cell>
                                <div class="space-x-2 flex items-center">
                                    @can('edit_incidents')
                                        <livewire:dashboard.incidents.modals.incident-update-update-modal :incident="$incident" :incident-update="$update" :key="time().$incident->id" />
                                    @endcan
                                    @if(count($incidentUpdates) != 1)
                                        @can('delete_incidents')
                                            <livewire:dashboard.incidents.modals.incident-update-delete-modal :incident="$incident" :incident-update="$update" :key="time().time().$incident->id" />
                                        @endcan
                                    @endif
                                </div>
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
                {{ $incidentUpdates->links() }}
            </div>
        </div>
    </div>
</div>

