<?php
use App\Models\Component;
use App\Models\ComponentGroup;
use App\Models\Incident;
use App\Models\Status;
use Illuminate\Support\Facades\Cache;

$components = Cache::remember('home_components', config('cache.ttl'), function (){
    return Component::all();
});

$component_groups = Cache::remember('home_componentgroups', config('cache.ttl'), function (){
    return ComponentGroup::getGroups();
});

$highestStatus = 1;
$globalStatus = Status::getByOrder($highestStatus)->first();
foreach ($components as $component){
    if($component->group()->visibility == 1){
        if($highestStatus < $component->status()->id){
            $highestStatus = $component->status()->id;
            $globalStatus = $component->status();
        }
    }
}

$incidents = Cache::remember('home_incidents', config('cache.ttl'), function (){
    return Incident::query()->where([['status', '!=', 3], ['type', '=', 0], ['visibility', '=', true]])->orWhere([['status', '!=', 3], ['type', '=', 1], ['status', '!=', 0], ['visibility', '=', true]])->orderBy('id', 'desc')->get();
});
?>
<x-guest-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="mt-12 text-4xl">
                <h1 class="inline">{{ config('app.name') }}</h1>
                @auth()
                    <div class="inline">
                        <a href="{{ route('dashboard') }}" target="_blank">
                            <x-jet-button class="text-right">Open Dashboard</x-jet-button>
                        </a>
                    </div>
                @endauth
            </div>
            <div class="mt-6">
                @if($incidents->count() > 0)
                    @foreach($incidents as $incident)
                        <div class="border-{{ $incident->getImpactColor() }} border-2 rounded-md shadow mb-2">
                            <div class="bg-{{ $incident->getImpactColor() }} text-white px-4 py-5 sm:px-6">
                                <h3 class="text-lg leading-6 font-medium">
                                    {{ $incident->title }}
                                </h3>
                            </div>
                            <div class="px-4 py-5 sm:px-6">
                                @foreach($incident->incidentUpdates()->orderBy('id', 'desc')->get() as $update)
                                    <div class="mb-2">
                                        <span class="font-bold">{{ $update->getUpdateType() }}</span> - {{ $update->text }}<br>
                                        <span class="text-gray-400">{{ $update->updated_at }} by {{ $update->getReporter()->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="{{ $globalStatus->bg_color }} border-l-4 {{ $globalStatus->border_color }} p-4">
                        <div class="flex">
                            <div class="flex-shrink-0 h-5 w-5 {{ $globalStatus->color }}">
                                {!! $globalStatus->heroicon_svg !!}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm {{ $globalStatus->color }}">
                                    {{ $globalStatus->long_description }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="mt-12">
                @foreach($component_groups as $group)
                    <div class="bg-white text-black px-4 py-5 sm:px-6 mt-2 shadow sm:rounded-t-md border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium">
                            {{ $group->name }}
                        </h3>
                    </div>
                    <div class="bg-white shadow overflow-hidden sm:rounded-b-md">
                        <ul class="divide-y divide-gray-200">
                            @foreach($group->getComponents() as $component)
                                <li>
                                    @if($component->link)
                                    <a href="{{ $component->link }}" target="_blank" class="block hover:bg-gray-50">
                                    @else
                                    <a class="block hover:bg-gray-50">
                                    @endif
                                        <div class="flex items-center px-4 py-4 sm:px-6">
                                            <div class="min-w-0 flex-1 flex items-center">
                                                <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                                    <div>
                                                        <p class="font-medium truncate relative">
                                                            {{ $component->name }}
                                                            @if($component->description == 'DISABLED')
                                                                <span class="has-tooltip">
                                                                    <svg class="h-4 w-4 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                    <span class="tooltip absolute mb-1 bg-gray-500 rounded-md px-2 py-1">{{ $component->description }}</span>
                                                                </span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="text-sm font-bold {{ $component->status()->color }}">
                                                            {{ $component->status()->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>
