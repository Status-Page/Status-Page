<div>
    <div class="text-right">
        <x-jet-button wire:click="start">
            {{ __('incidents.new_incident.button') }}
        </x-jet-button>
    </div>

    <div class="text-left">
        <x-jet-dialog-modal wire:model="modal">
            <x-slot name="title">
                {{ __('incidents.new_incident.modal.title') }}
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="title" class="text-lg" value="{{ __('incidents.new_incident.modal.incident_title') }}" />
                    <x-jet-input id="title" type="text" class="mt-1 block w-full" wire:model="incident.title" />
                    @error('incident.title') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="status" class="text-lg" value="{{ __('incidents.new_incident.modal.status') }}" />
                    <select id="status" wire:model="incident.status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="0">Investigating</option>
                        <option value="1">Identified</option>
                        <option value="2">Monitoring</option>
                        <option value="3">Resolved</option>
                    </select>
                    @error('incident.status') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="impact" class="text-lg" value="{{ __('incidents.new_incident.modal.impact') }}" />
                    <select id="impact" wire:model="incident.impact" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="0">None</option>
                        <option value="1">Minor</option>
                        <option value="2">Major</option>
                        <option value="3">Critical</option>
                    </select>
                    @error('incident.impact') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="visibility" class="text-lg" value="{{ __('incidents.new_incident.modal.visible') }}" />
                    <x-jet-input id="visibility" type="checkbox" class="mt-1 block" wire:model="incident.visibility" />
                    @error('incident.visibility') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="incidentComponents" class="text-lg" value="{{ __('incidents.new_incident.modal.affected_components') }}" />
                    <select id="incidentComponents" multiple wire:model="incidentComponents" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach(\App\Models\ComponentGroup::all() as $group)
                            <optgroup label="{{ $group->name }}">
                                @foreach($group->components() as $component)
                                    <option value="{{ $component->id }}">{{ $component->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <span>{{ __('incidents.new_incident.modal.affected_components_hint') }}</span>
                    @error('incidentComponents') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="text" class="text-lg" value="{{ __('incidents.new_incident.modal.message') }}" />
                    <textarea id="text" wire:model="incidentUpdate.text" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"></textarea>
                    @error('incidentUpdate.text') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                    {{ __('global.abort') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    {{ __('incidents.new_incident.modal.open_button') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
