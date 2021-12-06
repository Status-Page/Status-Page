<div class="inline">
    <button wire:loading.attr="disabled" wire:click="start" class="text-indigo-600 hover:text-indigo-900 mr-2">{{ __('maintenances.maintenance_updates.update.button') }}</button>

    <div class="text-left">
        <x-jet-dialog-modal wire:model="modal">
            <x-slot name="title">
                {{ __('maintenances.maintenance_updates.update.modal.title') }}
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="text" class="text-lg" value="{{ __('maintenances.maintenance_updates.update.modal.message') }}" />
                    <textarea id="text" wire:model="maintenanceUpdate.text" class="h-96 mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-discordDark dark:border-discordBlack"></textarea>
                    @error('maintenanceUpdate.text') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                    {{ __('global.abort') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    {{ __('maintenances.maintenance_updates.update.modal.update_button') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
