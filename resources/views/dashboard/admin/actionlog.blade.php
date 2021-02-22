<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Action Log') }}
        </h2>
        <p>Action Logs for the past {{ config('app.actionlog_backlog', '?') }} days. Older Logs are deleted daily.</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
</x-app-layout>
