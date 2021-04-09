<div>
    <div class="text-right">
        <x-jet-button wire:click="startAddGroup">
            {{ __('New Component Group') }}
        </x-jet-button>
    </div>

    <div class="text-left">
        <x-jet-dialog-modal wire:model="groupCreationModal">
            <x-slot name="title">
                Create Component Group
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="title" class="text-lg" value="{{ __('Name') }}" />
                    <x-input-dark id="title" type="text" class="mt-1 block w-full" wire:model="newGroup.name" />
                    @error('newGroup.name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="description" class="text-lg" value="{{ __('Description') }}" />
                    <x-input-dark id="description" type="text" class="mt-1 block w-full" wire:model="newGroup.description" />
                    @error('newGroup.description') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="order" class="text-lg" value="{{ __('Order') }}" />
                    <x-input-dark id="order" type="number" class="mt-1 block w-full" wire:model="newGroup.order" />
                    @error('newGroup.order') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="collapse" class="text-lg" value="{{ __('Expand on') }}" />
                    <select id="collapse" wire:model="newGroup.collapse" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-discordDark dark:border-discordBlack">
                        <option value="expand_always">Expand always</option>
                        <option value="expand_issue">Expand on Issue</option>
                    </select>
                    @error('newGroup.collapse') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="visible" class="text-lg" value="{{ __('Visibility') }}" />
                    <x-input-dark id="visible" type="checkbox" class="mt-1 block" wire:model="newGroup.visibility" />
                    @error('newGroup.visibility') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('groupCreationModal')" wire:loading.attr="disabled">
                    Abort
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="addGroup" wire:loading.attr="disabled">
                    Create Group
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
