<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('custom-styles.title') }}
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex-col space-y-4">
            <div class="flex justify-between">
                <div class="w-1/3 flex space-x-2">
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

                    @can('edit_settings')
                        <div class="text-right">
                            <x-jet-button wire:click="addCustomStyle">
                                {{ __('custom-styles.list.create') }}
                            </x-jet-button>
                        </div>
                    @endcan
                </div>
            </div>
            <x-table>
                <x-slot name="head">
                    <x-table.heading>{{ __('custom-styles.list.table.id') }}</x-table.heading>
                    <x-table.heading>{{ __('custom-styles.list.table.active') }}</x-table.heading>
                    <x-table.heading>{{ __('custom-styles.list.table.enable_header') }}</x-table.heading>
                    <x-table.heading>{{ __('custom-styles.list.table.enable_footer') }}</x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($custom_styles as $custom_style)
                        <x-table.row wire:loading.class.delay="opacity-50">
                            <x-table.cell>{{ $custom_style->id }}</x-table.cell>
                            <x-table.cell>{{ $custom_style->active ? 'Active' : 'Inactive' }}</x-table.cell>
                            <x-table.cell>{{ $custom_style->enable_header ? 'Enabled' : 'Disabled' }}</x-table.cell>
                            <x-table.cell>{{ $custom_style->enable_footer ? 'Enabled' : 'Disabled' }}</x-table.cell>
                            <x-table.cell>
                                <div class="space-x-2 flex items-center justify-end">
                                    <div class="inline">
                                        <button wire:loading.attr="disabled" wire:click="toggleCustomStyle({{ $custom_style->id }})" class="text-indigo-600 hover:text-indigo-900">{{ __('custom-styles.list.table.actions.toggle') }}</button>
                                        <button wire:loading.attr="disabled" wire:click="updateCustomStyle({{ $custom_style->id }})" class="text-indigo-600 hover:text-indigo-900">{{ __('custom-styles.list.table.actions.update') }}</button>
                                        <button wire:loading.attr="disabled" wire:click="deleteCustomStyle({{ $custom_style->id }})" class="text-indigo-600 hover:text-indigo-900">{{ __('custom-styles.list.table.actions.delete') }}</button>
                                    </div>
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
                {{ $custom_styles->links() }}
            </div>
        </div>
    </div>
</div>
