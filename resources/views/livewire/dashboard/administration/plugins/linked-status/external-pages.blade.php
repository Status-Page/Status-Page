<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('linked_status.title_prefix') }} {{ __('linked_status.title') }}
        </h2>
        <p class="text-white dark:text-gray-400">{{ __('linked_status.subtitle') }}</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex-col space-y-4">
            <div class="flex justify-between">
                <div class="w-1/3 flex space-x-2">
                    <x-input-dark type="text" wire:model="search" placeholder="Search Domains..." class="w-full dark:bg-discordDark"></x-input-dark>
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

                    @can('add_users')
                        <livewire:dashboard.administration.plugins.linked-status.modals.create-external-page />
                    @endcan
                </div>
            </div>
            <x-table>
                <x-slot name="head">
                    <x-table.heading>{{ __('linked_status.table.head.id') }}</x-table.heading>
                    <x-table.heading>{{ __('linked_status.table.head.domain') }}</x-table.heading>
                    <x-table.heading>{{ __('linked_status.table.head.c_linked_incidents') }}</x-table.heading>
                    <x-table.heading>{{ __('linked_status.table.head.c_linked_maintenances') }}</x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($pages as $page)
                        <x-table.row wire:loading.class.delay="opacity-50">
                            <x-table.cell>{{ $page->id }}</x-table.cell>
                            <x-table.cell>{{ $page->domain }}</x-table.cell>
                            <x-table.cell>{{ $page->create_linked_incidents ? 'True' : 'False' }}</x-table.cell>
                            <x-table.cell>{{ $page->create_linked_maintenances ? 'True' : 'False' }}</x-table.cell>
                            <x-table.cell>
                                <div class="space-x-2 flex items-center">
                                    @can('edit_settings')
                                        <livewire:dashboard.administration.plugins.linked-status.modals.update-external-page :page="$page" :key="time().$page->id" />
                                    @endcan
                                    @can('edit_settings')
                                        <livewire:dashboard.administration.plugins.linked-status.modals.delete-external-page :page="$page" :key="time().time().$page->id" />
                                    @endcan
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="5">
                                <div class="flex justify-center items-center">
                                    <span class="font-medium py-8 text-gray-400 text-xl">No results...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table>

            <div>
                {{ $pages->links() }}
            </div>
        </div>
    </div>
</div>
