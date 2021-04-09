<x-jet-form-section submit="updateInformation">
    <x-slot name="title">
        {{ __('App Settings') }}
    </x-slot>

    <x-slot name="description"></x-slot>

    <x-slot name="form">
        @foreach($settings as $setting)
            <div class="col-span-6 sm:col-span-4">
                <div class="flex flex-row space-x-4">
                    <x-jet-label for="{{ $setting['key'] }}" value="{{ __('settings.'.$setting['key']) }}" />
                    @if($setting['hint'])
                        <button data-title="{{ __($setting['hint']) }}" data-placement="top" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 focus:outline-none cursor-default">
                            Hint
                        </button>
                    @endif
                    @if($setting['encrypted'])
                        <button data-title="{{ __('You can only change this value, by setting a new one.') }}" data-placement="top" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 focus:outline-none cursor-default">
                            Encrypted
                        </button>
                    @endif
                </div>
                <x-jet-input id="{{ $setting['key'] }}" type="{{ $setting['type'] }}" class="mt-1 block w-full" wire:model.defer="settings.{{ $loop->index }}.{{ $setting['type'] == 'checkbox' ? 'boolval' : 'value' }}" autocomplete="{{ $setting['key'] }}" />
                <x-jet-input-error for="{{ $setting['key'] }}" class="mt-2" />
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
