<div>
    <x-jet-danger-button wire:loading.attr="disabled" wire:click="startDeleteGroup">Delete</x-jet-danger-button>
    <x-jet-confirmation-modal wire:model="groupDeletionModal">
        <x-slot name="title">
            Delete Group
        </x-slot>

        <x-slot name="content">
            Are you sure, you want to Delete the Group "{{ $group->name }}"? This will Delete ALL your Components in this Group!
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('groupDeletionModal')" wire:loading.attr="disabled">
                No
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteGroup" wire:loading.attr="disabled">
                Delete Group
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
