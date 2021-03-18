<div>
    <x-jet-button wire:click="start">
        {{ __('Update') }}
    </x-jet-button>

    <div class="text-left">
        <x-jet-dialog-modal wire:model="modal">
            <x-slot name="title">
                Update Group
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="name" class="text-lg" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="group.name" />
                    @error('group.name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="description" class="text-lg" value="{{ __('Description') }}" />
                    <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model="group.description" />
                    @error('group.description') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="order" class="text-lg" value="{{ __('Order') }}" />
                    <x-jet-input id="order" type="number" class="mt-1 block w-full" wire:model="group.order" />
                    @error('group.order') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="collapse" class="text-lg" value="{{ __('Expand on') }}" />
                    <select id="collapse" wire:model="group.collapse" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-discordDark dark:border-discordBlack">
                        <option value="expand_always">Expand always</option>
                        <option value="expand_issue">Expand on Issue</option>
                    </select>
                    @error('group.collapse') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="visibility" class="text-lg" value="{{ __('Visible') }}" />
                    <x-jet-input id="visibility" type="checkbox" class="mt-1 block" wire:model="group.visibility" />
                    @error('group.visibility') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                    Abort
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    Update Group
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
