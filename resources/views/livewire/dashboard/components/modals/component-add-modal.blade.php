<div>
    <div class="text-right">
        <x-jet-button wire:click="start">
            {{ __('New Component') }}
        </x-jet-button>
    </div>

    <div class="text-left">
        <x-jet-dialog-modal wire:model="modal">
            <x-slot name="title">
                Create Component
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="name" class="text-lg" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="comp.name" />
                    @error('comp.name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="link" class="text-lg" value="{{ __('Link URL') }}" />
                    <x-jet-input id="link" type="text" class="mt-1 block w-full" wire:model="comp.link" />
                    @error('comp.link') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="description" class="text-lg" value="{{ __('Description') }}" />
                    <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model="comp.description" />
                    @error('comp.description') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="status" class="text-lg" value="{{ __('Status') }}" />
                    <select id="status" wire:model="comp.status_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-discordDark dark:border-discordBlack">
                        @foreach(\App\Models\Status::all() as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                    @error('comp.status_id') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="order" class="text-lg" value="{{ __('Order') }}" />
                    <x-jet-input id="order" type="number" class="mt-1 block w-full" wire:model="comp.order" />
                    @error('comp.order') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="visible" class="text-lg" value="{{ __('Visible') }}" />
                    <x-jet-input id="visible" type="checkbox" class="mt-1 block" wire:model="comp.visibility" />
                    @error('comp.visibility') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                    Abort
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    Create Component
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
