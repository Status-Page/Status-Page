<div class="inline">
    <button wire:loading.attr="disabled" wire:click="start" class="text-indigo-600 hover:text-indigo-900 mr-2">{{ __('maintenances.update_maintenance.button') }}</button>

    <div class="text-left">
        <x-jet-dialog-modal wire:model="modal">
            <x-slot name="title">
                {{ __('maintenances.update_maintenance.modal.title') }}
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="title" class="text-lg" value="{{ __('maintenances.update_maintenance.modal.maintenance_title') }}" />
                    <x-jet-input id="title" type="text" class="mt-1 block w-full" wire:model="maintenance.title" />
                    @error('maintenance.title') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="status" class="text-lg" value="{{ __('maintenances.update_maintenance.modal.status') }}" />
                    <select id="status" wire:model="maintenance.status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="0">Planned</option>
                        <option value="1">In Progress</option>
                        <option value="2">Verifying</option>
                        <option value="3">Completed</option>
                    </select>
                    @error('maintenance.status') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="incidentComponents" class="text-lg" value="{{ __('maintenances.update_maintenance.modal.affected_components') }}" />
                    <select id="incidentComponents" multiple wire:model="incidentComponents" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach(\App\Models\ComponentGroup::all() as $group)
                            <optgroup label="{{ $group->name }}">
                                @foreach($group->components() as $component)
                                    <option value="{{ $component->id }}">{{ $component->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('incidentComponents') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="visibility" class="text-lg" value="{{ __('maintenances.update_maintenance.modal.visible') }}" />
                    <x-jet-input id="visibility" type="checkbox" class="mt-1 block" wire:model="maintenance.visibility" />
                    @error('maintenance.visibility') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                @if($maintenance->status == 0)
                    <div class="col-span-6 sm:col-span-4 mb-4">
                        <x-jet-label for="scheduled_at" class="text-lg" value="{{ __('maintenances.update_maintenance.modal.scheduled_at') }}" />
                        <x-jet-input id="scheduled_at" type="datetime-local" class="mt-1 w-full inline block" wire:model="maintenance.scheduled_at" />
                        @error('maintenance.scheduled_at') <span class="text-red-500">{{ $message }}</span> @enderror
                        <br>{{ __('maintenances.update_maintenance.modal.scheduled_hint') }}
                    </div>
                @endif

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="end_at" class="text-lg" value="{{ __('maintenances.update_maintenance.modal.end_at') }}" />
                    <x-jet-input id="end_at" type="datetime-local" class="mt-1 w-full inline block" wire:model="maintenance.end_at" />
                    @error('maintenance.end_at') <span class="text-red-500">{{ $message }}</span> @enderror
                    <br>{{ __('maintenances.update_maintenance.modal.end_hint') }}
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="text" class="text-lg" value="{{ __('maintenances.update_maintenance.modal.message') }}" />
                    <textarea id="text" wire:model="maintenanceUpdate.text" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"></textarea>
                    @error('maintenanceUpdate.text') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                    {{ __('global.abort') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    {{ __('maintenances.update_maintenance.modal.update_button') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
