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
                    <x-jet-input id="title" type="text" class="mt-1 block w-full" wire:model="newGroup.name" />
                    @error('newGroup.name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="description" class="text-lg" value="{{ __('Description') }}" />
                    <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model="newGroup.description" />
                    @error('newGroup.description') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="order" class="text-lg" value="{{ __('Order') }}" />
                    <x-jet-input id="order" type="number" class="mt-1 block w-full" wire:model="newGroup.order" />
                    @error('newGroup.order') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="visible" class="text-lg" value="{{ __('Visibility') }}" />
                    <x-jet-input id="visible" type="checkbox" class="mt-1 block" wire:model="newGroup.visibility" />
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
