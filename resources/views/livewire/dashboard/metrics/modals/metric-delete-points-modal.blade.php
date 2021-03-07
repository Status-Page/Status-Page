<div class="inline">
    <button wire:loading.attr="disabled" wire:click="start" class="text-indigo-600 hover:text-indigo-900">{{ __('Delete Points') }}</button>
    <x-jet-confirmation-modal wire:model="modal">
        <x-slot name="title">
            {{ __('Delete Metric Points') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure, you want to delete all Metric Points of the Metric ":name"?', ['name' => $metric->title]) }}<br>
            {{ __('This cannot be undone!') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                {{ __('global.abort') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
