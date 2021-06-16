<div class="normal-case">
    <div class="text-right">
        <x-jet-button wire:click="start">
            {{ __('subscribers.create.button') }}
        </x-jet-button>
    </div>

    <div class="text-left">
        <x-jet-dialog-modal wire:model="modal">
            <x-slot name="title">
                {{ __('subscribers.create.modal.title') }}
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="email" class="text-lg" value="{{ __('subscribers.create.modal.email') }}" />
                    <x-input-dark id="email" type="text" class="mt-1 block w-full" wire:model="subscriber.email" />
                    <x-jet-input-error for="email" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                    {{ __('global.abort') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    {{ __('subscribers.create.modal.save_button') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
