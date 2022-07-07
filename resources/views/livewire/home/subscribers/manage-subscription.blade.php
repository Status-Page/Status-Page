<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10">
        <div class="max-w-3xl mx-auto">
            <div class="mt-12 text-4xl flex justify-between">
                <div>
                    <h1 class="inline">{{ config('app.name') }}</h1>
                </div>
                <div class="space-x-2 flex items-center">
                    <div>
                        <a href="{{ route('home') }}">
                            <x-jet-button class="text-right dark:bg-discordGrey">{{ __('home.home') }}</x-jet-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
        <div class="flex flex-col">
            <div class="text-4xl mb-4">Manage Subscription</div>
            <div class="mb-6">
                <button
                    wire:click="toggleReceiveIncidentUpdates"
                    class="transition-all px-2 py-1 rounded-lg {{ $subscriber->incident_updates ? 'bg-green-800 hover:bg-green-900' : 'bg-red-800 hover:bg-red-900' }}"
                >
                    <span>{{ $subscriber->incident_updates ? __('✅') : __('❌') }}</span>
                    <span>Receive Incident Notifications</span>
                </button>
            </div>
            <div class="flex flex-col">
                <div class="text-2xl mb-2">Subscribed Components</div>
                <div class="flex flex-col space-y-2 divide-y-2 divide-discordDark">
                    @foreach($subscriber->components()->get() as $component)
                        <div class="pt-2 flex flex-row justify-between items-center" wire:key="r-{{ __($component->id)  }}">
                            <div>{{ __($component->group()->name) }} - <span class="font-bold">{{ __($component->name) }}</span></div>
                            <div>
                                <button class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded-lg transition-all cursor-pointer" wire:click="removeSubscription({{ $component->id }})">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex flex-col">
                <div class="mt-6 text-2xl mb-2">Add Subscription</div>
                <div class="flex flex-col space-y-2 divide-dotted divide-discordBlack">
                    @foreach($components as $component)
                        <div class="flex flex-row justify-between items-center" wire:key="a-{{ __($component->id)  }}">
                            <div>{{ __($component->group()->name) }} - <span class="font-bold">{{ __($component->name) }}</span></div>
                            <div>
                                <button class="bg-green-600 hover:bg-green-700 px-2 py-1 rounded-lg transition-all cursor-pointer" wire:click="addSubscription({{ $component->id }})">Add</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
