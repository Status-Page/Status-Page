<div>
    <x-jet-button wire:loading.attr="disabled" wire:click="start">
        {{ __('linked_status.modal_create.button') }}
    </x-jet-button>

    <div class="text-left">
        <x-jet-dialog-modal wire:model="modal">
            <x-slot name="title">
                {{ __('linked_status.modal_create.title') }}
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="domain" class="text-lg" value="{{ __('linked_status.modal_create.domain') }}" />
                    <x-input-dark id="domain" type="text" class="mt-1 block w-full" wire:model="page.domain" />
                    <x-jet-input-error for="page.domain" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="provider" class="text-lg" value="{{ __('linked_status.modal_create.provider') }}" />
                    <select id="provider" wire:model="page.provider" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-discordDark dark:border-discordBlack dark:text-white">
                        <option value="statuspageio">Atlassian Statuspage</option>
                    </select>
                    <x-jet-input-error for="page.provider" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="create_linked_incidents" class="text-lg" value="{{ __('linked_status.modal_create.c_linked_incidents') }}" />
                    <x-input-dark disabled id="create_linked_incidents" type="checkbox" class="mt-1 block disabled:opacity-70" wire:model="page.create_linked_incidents" />
                    <x-jet-input-error for="page.create_linked_incidents" class="mt-2" />
                    <p>This feature is not usable yet.</p>
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="create_linked_maintenances" class="text-lg" value="{{ __('linked_status.modal_create.c_linked_maintenances') }}" />
                    <x-input-dark disabled id="create_linked_maintenances" type="checkbox" class="mt-1 block disabled:opacity-70" wire:model="page.create_linked_maintenances" />
                    <x-jet-input-error for="page.create_linked_maintenances" class="mt-2" />
                    <p>This feature is not usable yet.</p>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                    {{ __('global.abort') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    {{ __('linked_status.modal_create.submit') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
