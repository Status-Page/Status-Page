<div class="inline">
    <button wire:loading.attr="disabled" wire:click="start" class="text-indigo-600 hover:text-indigo-900 mr-2">Update</button>

    <div class="text-left">
        <x-jet-dialog-modal wire:model="modal">
            <x-slot name="title">
                Update Maintenance
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="title" class="text-lg" value="{{ __('Title') }}" />
                    <x-jet-input id="title" type="text" class="mt-1 block w-full" wire:model="maintenance.title" />
                    @error('maintenance.title') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="status" class="text-lg" value="{{ __('Status') }}" />
                    <select id="status" wire:model="maintenance.status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="0">Planned</option>
                        <option value="1">In Progress</option>
                        <option value="2">Verifying</option>
                        <option value="3">Completed</option>
                    </select>
                    @error('maintenance.status') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="visibility" class="text-lg" value="{{ __('Visible') }}" />
                    <x-jet-input id="visibility" type="checkbox" class="mt-1 block" wire:model="maintenance.visibility" />
                    @error('maintenance.visibility') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="text" class="text-lg" value="{{ __('Message') }}" />
                    <textarea id="text" wire:model="maintenanceUpdate.text" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"></textarea>
                    @error('maintenanceUpdate.text') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                    Abort
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    Post Update
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
