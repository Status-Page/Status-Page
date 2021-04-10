<div>
    <button wire:loading.attr="disabled" wire:click="start" class="text-indigo-600 hover:text-indigo-900">{{ __('uptimerobot.table.body.actions.update') }}</button>

    <div class="text-left">
        <x-jet-dialog-modal wire:model="modal">
            <x-slot name="title">
                {{ __('uptimerobot.modal_update.title') }}
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="component_id" class="text-lg" value="{{ __('uptimerobot.modal_update.component') }}" />
                    <select id="component_id" wire:model="monitor.component_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-discordDark dark:border-discordBlack dark:text-white">
                        <option>None</option>
                        @foreach(\App\Models\ComponentGroup::all() as $group)
                            <optgroup label="{{ $group->name }}{{ $group->visibility == 1 ? '' : ' (Not Visible)' }}">
                                @foreach($group->components() as $component)
                                    <option value="{{ $component->id }}">{{ $component->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <x-jet-input-error for="monitor.component_id" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="metric_id" class="text-lg" value="{{ __('uptimerobot.modal_update.metric') }}" />
                    <select id="metric_id" wire:model="monitor.metric_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-discordDark dark:border-discordBlack dark:text-white">
                        <option>None</option>
                        @foreach(\App\Models\Metric::all() as $metric)
                            <option value="{{ $metric->id }}">{{ $metric->title }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="monitor.metric_id" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modal')" wire:loading.attr="disabled">
                    {{ __('global.abort') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    {{ __('uptimerobot.modal_update.submit') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
