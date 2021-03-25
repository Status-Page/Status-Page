<x-jet-form-section submit="updateInformation">
    <x-slot name="title">
        {{ __('General Settings') }}
    </x-slot>

    <x-slot name="description"></x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="app_name" value="{{ __('App Name') }}" />
            <x-jet-input id="app_name" type="text" class="mt-1 block w-full" wire:model.defer="app_name" autocomplete="app_name" />
            <x-jet-input-error for="app_name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="app_url" value="{{ __('App URL') }}" />
            <x-jet-input id="app_url" type="text" class="mt-1 block w-full" wire:model.defer="app_url" autocomplete="app_url" />
            <x-jet-input-error for="app_url" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="app_locale" value="{{ __('App Locale') }}" />
            <x-input.select id="app_locale" wire:model.defer="app_locale" autocomplete="app_locale" class="rounded-md mt-1 block w-full">
                <option value="de">German</option>
                <option value="en">English</option>
            </x-input.select>
            <x-jet-input-error for="app_locale" class="mt-2" />
        </div>
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
