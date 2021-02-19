<div>
    <button wire:loading.attr="disabled" wire:click="start" class="text-indigo-600 hover:text-indigo-900">Delete</button>
    <x-jet-confirmation-modal wire:model="modal">
        <x-slot name="title">
            Delete Component
        </x-slot>

        <x-slot name="content">
            Are you sure, you want to delete the Component "{{ $comp->name }}"?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                No
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                Delete
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
