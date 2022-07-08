<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('custom-styles.title') }}
        </h2>
    </x-slot>

    <div class="pt-6 max-w-7xl mx-auto sm:px-6 lg:px-8 flex-col space-y-4">
        <div class="flex justify-between">
            <div class="grid grid-cols-12 sm:grid-cols-4 w-full">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="enable_header" class="text-lg" value="{{ __('custom-styles.update.enable_header') }}" />
                    <x-input-dark id="enable_header" type="checkbox" class="mt-1 block" wire:model.defer="customStyle.enable_header" />
                    @error('customStyle.enable_header') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-12 sm:col-span-4 mb-4">
                    <x-jet-label for="header" class="text-lg" value="{{ __('custom-styles.update.header') }}" />
                    <x-input-textarea-dark id="header" class="mt-1 block w-full" wire:model.defer="customStyle.header" />
                    @error('customStyle.header') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>


                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="enable_footer" class="text-lg" value="{{ __('custom-styles.update.enable_footer') }}" />
                    <x-input-dark id="enable_footer" type="checkbox" class="mt-1 block" wire:model.defer="customStyle.enable_footer" />
                    @error('customStyle.enable_footer') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-12 sm:col-span-4 mb-4">
                    <x-jet-label for="footer" class="text-lg" value="{{ __('custom-styles.update.footer') }}" />
                    <x-input-textarea-dark id="footer" class="mt-1 block w-full" wire:model.defer="customStyle.footer" />
                    @error('customStyle.footer') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>


                <div class="col-span-12 sm:col-span-4 mb-4">
                    <x-jet-label for="custom_css" class="text-lg" value="{{ __('custom-styles.update.custom_css') }}" />
                    <x-input-textarea-dark id="custom_css" class="mt-1 block w-full" wire:model.defer="customStyle.custom_css" />
                    @error('customStyle.custom_css') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>


                <div class="col-span-12 sm:col-span-4 mb-4">
                    <x-jet-label for="active" class="text-lg" value="{{ __('custom-styles.update.active') }}" />
                    <x-input-dark id="active" type="checkbox" class="mt-1 block" wire:model.defer="customStyle.active" />
                    @error('customStyle.active') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <x-jet-button wire:click="saveCustomStyle">
                        {{ __('custom-styles.update.create') }}
                    </x-jet-button>
                </div>
            </div>
        </div>
    </div>
</div>
