<div class="inline">
    @if(!$subscriber->email_verified)
        <button wire:loading.attr="disabled" wire:click="start" class="text-indigo-600 hover:text-indigo-900">{{ __('subscribers.resend_verification.button') }}</button>
        <x-jet-confirmation-modal wire:model="modal">
            <x-slot name="title">
                {{ __('subscribers.resend_verification.modal.title') }}
            </x-slot>

            <x-slot name="content">
                {{ __('subscribers.resend_verification.modal.text_r1', ['email' => $subscriber->email]) }}<br>
                {{ __('subscribers.resend_verification.modal.text_r2') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                    {{ __('global.abort') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    {{ __('subscribers.resend_verification.modal.button') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
    @endif
</div>
