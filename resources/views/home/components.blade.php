<div class="mt-12">
    @foreach($component_groups as $group)
        <div x-data="{ open{{ $group->id }}: {{ $group->shouldExpand() }} }" class="shadow sm:rounded-md bg-white text-black dark:bg-discordBlack dark:text-white">
            <div class="px-4 py-5 sm:px-6 mt-2 border-b border-gray-200 dark:border-discordDark cursor-pointer" @click="open{{ $group->id }} = !open{{ $group->id }}">
                <h3 class="text-lg leading-6 font-medium md:grid md:grid-cols-2 md:gap-">
                    <div>
                        <button class="focus:outline-none">
                            <svg class="h-4 w-4 text-black dark:text-white" x-show="!open{{ $group->id }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                            <svg class="h-4 w-4 text-black dark:text-white" x-show="open{{ $group->id }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                        {{ $group->name }}
                        @if($group->description != "")
                            <button data-title="{{ $group->description }}" data-placement="top" class="focus:outline-none cursor-default">
                                <svg class="h-4 w-4 inline visible" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        @endif
                    </div>
                    <div class="text-right">
                        <p x-show="!open{{ $group->id }}" class="text-sm font-bold {{ $group->getStatus()->color }}">
                            {{ __($group->getStatus()->name) }}
                        </p>
                    </div>
                </h3>
            </div>
            <div class="overflow-hidden">
                <ul x-show="open{{ $group->id }}" class="divide-y divide-gray-200 dark:divide-discordDark">
                    @foreach($group->getComponents() as $component)
                        <li>
                            @if($component->link)
                                <a href="{{ $component->link }}" target="_blank" class="block hover:bg-gray-50 dark:hover:bg-discordDark">
                            @else
                                <a class="block hover:bg-gray-50 dark:hover:bg-discordDark">
                            @endif
                                    <div class="flex items-center px-4 py-4 sm:px-6">
                                        <div class="min-w-0 flex-1 flex items-center">
                                            <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                                <div>
                                                    <p class="font-medium truncate relative">
                                                        {{ $component->name }}
                                                        @if($component->description != "")
                                                            <button data-title="{{ $component->description }}" data-placement="top" class="focus:outline-none cursor-default">
                                                                <svg class="h-4 w-4 inline visible" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </button>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    <button class="text-sm font-bold {{ $component->status()->color }} cursor-default" data-title="Last update: {{ $component->updated_at }}" data-placement="top">
                                                        {{ __($component->status()->name) }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
