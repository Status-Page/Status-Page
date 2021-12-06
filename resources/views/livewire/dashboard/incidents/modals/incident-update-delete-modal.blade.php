<div class="inline">
    <button wire:loading.attr="disabled" wire:click="start" class="text-indigo-600 hover:text-indigo-900">{{ __('incidents.delete_incident.button') }}</button>
    <x-jet-confirmation-modal wire:model="modal">
        <x-slot name="title">
            {{ __('incidents.incident_updates.delete.modal.title') }}
        </x-slot>

        <x-slot name="content">
            {{ __('incidents.incident_updates.delete.modal.text_r1', ['title' => $incident->title, 'number' => $incidentUpdate->id]) }}<br>
            {{ __('incidents.incident_updates.delete.modal.text_r2') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                {{ __('global.abort') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                {{ __('incidents.incident_updates.delete.modal.delete_button') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
