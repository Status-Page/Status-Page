<div>
    <div class="text-right">
        <x-jet-button wire:click="start">
            {{ __('maintenances.new_maintenance.button') }}
        </x-jet-button>
    </div>

    <div class="text-left">
        <x-jet-dialog-modal wire:model="modal">
            <x-slot name="title">
                {{ __('maintenances.new_maintenance.modal.title') }}
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="title" class="text-lg" value="{{ __('maintenances.new_maintenance.modal.maintenance_title') }}" />
                    <x-jet-input id="title" type="text" class="mt-1 block w-full" wire:model="incident.title" />
                    @error('incident.title') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="visibility" class="text-lg" value="{{ __('maintenances.new_maintenance.modal.visible') }}" />
                    <x-jet-input id="visibility" type="checkbox" class="mt-1 block" wire:model="incident.visibility" />
                    @error('incident.visibility') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="scheduled_at" class="text-lg" value="{{ __('maintenances.new_maintenance.modal.scheduled_at') }}" />
                    <x-jet-input id="scheduled_at" type="datetime-local" class="mt-1 w-full inline block" wire:model="incident.scheduled_at" />
                    @error('incident.scheduled_at') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="end_at" class="text-lg" value="{{ __('maintenances.new_maintenance.modal.end_at') }}" />
                    <x-jet-input id="end_at" type="datetime-local" class="mt-1 w-full inline block" wire:model="incident.end_at" />
                    @error('incident.end_at') <span class="text-red-500">{{ $message }}</span> @enderror
                    <br>{{ __('maintenances.new_maintenance.modal.end_hint') }}
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="incidentComponents" class="text-lg" value="{{ __('maintenances.new_maintenance.modal.affected_components') }}" />
                    <select id="incidentComponents" multiple wire:model="incidentComponents" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach(\App\Models\Component::all() as $component)
                            <option value="{{ $component->id }}">{{ $component->group()->name }} - {{ $component->name }}</option>
                        @endforeach
                    </select>
                    @error('incidentComponents') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="message" class="text-lg" value="{{ __('maintenances.new_maintenance.modal.message') }}" />
                    <textarea id="message" wire:model="incidentUpdate.text" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"></textarea>
                    @error('incidentUpdate.text') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                    {{ __('global.abort') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    {{ __('maintenances.new_maintenance.modal.schedule_button') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
