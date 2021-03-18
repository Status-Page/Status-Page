<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Action Log') }}
        </h2>
        <p>Action Logs for the past {{ config('app.actionlog_backlog', '?') }} days. Older Logs are deleted daily.</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex-col space-y-4">
            <div class="flex justify-between">
                <div class="w-1/3 flex space-x-2">
                    <x-jet-input type="text" wire:model="search" placeholder="Search Actions..." class="w-full"></x-jet-input>
                </div>

                <div class="space-x-2 flex items-center">
                    <x-input.group borderless paddingless for="perPage" label="Per Page">
                        <x-input.select wire:model="perPage" id="perPage" class="rounded-md">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </x-input.select>
                    </x-input.group>
                </div>
            </div>
            <div class="mt-4 bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($logs as $action)
                                <li>
                                    <div class="relative pb-8">
                                        @if($logs->last()->id != $action->id)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full {{ $action->getColor() }} flex items-center justify-center ring-8 ring-white">
                                                    {!! $action->getSVG() !!}
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">{{ $action->getTypeText() }} {{ $action->message }} by <a href="" class="font-medium text-gray-900">{{ $action->user()->name }}</a></p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $action->created_at }}">{{ $action->created_at }}</time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            <div class="mb-6">
                                {{ $logs->links() }}
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
