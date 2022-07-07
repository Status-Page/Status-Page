<x-jet-form-section submit="updateInformation">
    <x-slot name="title">
        {{ __('Statuses') }}
    </x-slot>

    <x-slot name="description"></x-slot>

    <x-slot name="form">
        @foreach($this->statuses as $key => $status)
            <div class="border-b border-b-zinc-700 last:border-b-none pb-2">
                <div class="flex flex-row space-x-4 items-center">
                    <div class="text-2xl">{{ __(\App\Models\Status::getDefaultNameStatic($status['order'])) }}</div>
                    <button data-title="{{ __('If you change these values, they are not going to be localized anymore! Reset to the Default to re-enable Localization.') }}" data-placement="top" class="h-6 items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 focus:outline-none cursor-default">
                        Note
                    </button>
                </div>
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-3 self-center">Name:</div>
                    <div class="col-span-8">
                        <x-jet-input
                            id="{{ $status['id'] }}_name"
                            type="text"
                            class="mt-1 block w-full"
                            wire:model.defer="statuses.{{ $key }}.name"
                            wire:loading.attr="disabled"
                        />
                        <x-jet-input-error for="{{ $status['id'] }}_name" class="mt-2" />
                    </div>
                    <div class="col-span-1 self-center">
                        <button
                            wire:click="resetNameToDefault({{ $status['id'] }})"
                            data-title="{{ __('Reset to Default') }}: {{ __(\App\Models\Status::getDefaultNameStatic($status['order'])) }}"
                            data-placement="top"
                            class="items-center px-2 py-1 rounded-lg font-medium bg-red-500 text-white focus:outline-none disabled:opacity-50"
                            wire:loading.attr="disabled"
                        >
                            Reset
                        </button>
                    </div>
                    <div class="col-span-3 self-center">Long Description:</div>
                    <div class="col-span-8">
                        <x-jet-input
                            id="{{ $status['id'] }}_long_description"
                            type="text"
                            class="mt-1 block w-full"
                            wire:model.defer="statuses.{{ $key }}.long_description"
                            wire:loading.attr="disabled"
                        />
                        <x-jet-input-error for="{{ $status['id'] }}_long_description" class="mt-2" />
                    </div>
                    <div class="col-span-1 self-center">
                        <button
                            wire:click="resetLongDescriptionToDefault({{ $status['id'] }})"
                            data-title="{{ __('Reset to Default') }}: {{ __(\App\Models\Status::getDefaultLongDescriptionStatic($status['order'])) }}"
                            data-placement="top"
                            class="items-center px-2 py-1 rounded-lg font-medium bg-red-500 text-white focus:outline-none disabled:opacity-50"
                            wire:loading.attr="disabled"
                        >
                            Reset
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
