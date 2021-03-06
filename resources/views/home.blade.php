<?php
use App\Models\Component;
use App\Models\ComponentGroup;
use App\Models\Incident;
use App\Models\Status;
use Carbon\Carbon;
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

$upcoming_maintenances = Incident::getPublicUpcomingMaintenances();
?>
<x-guest-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10">
        <div class="max-w-3xl mx-auto">
            <div class="mt-12 text-4xl">
                <h1 class="inline">{{ config('app.name') }}</h1>
                @auth()
                    <div class="inline">
                        <a href="{{ route('dashboard') }}" target="_blank">
                            <x-jet-button class="text-right dark:bg-discordGrey">Open Dashboard</x-jet-button>
                        </a>
                    </div>
                @endauth
            </div>
            <div class="mt-6">
                @if($incidents->count() > 0)
                    @foreach($incidents as $incident)
                        <div class="bg-white text-black dark:bg-discordDark dark:text-white border-{{ $incident->getImpactColor() }} border-2 rounded-md shadow mb-2">
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
                    <div x-data="{ open{{ $group->id }}: {{ $group->shouldExpand() }} }" class="shadow sm:rounded-md bg-white text-black dark:bg-discordBlack dark:text-white">
                        <div class="px-4 py-5 sm:px-6 mt-2 border-b border-gray-200 dark:border-discordDark cursor-pointer" @click="open{{ $group->id }} = !open{{ $group->id }}">
                            <h3 class="text-lg leading-6 font-medium md:grid md:grid-cols-2 md:gap-">
                                <div>
                                    <button class="focus:outline-none">
                                        <svg class="h-4 w-4 text-white" x-show="!open{{ $group->id }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                        </svg>
                                        <svg class="h-4 w-4 text-white" x-show="open{{ $group->id }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                        {{ $group->getStatus()->name }}
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
                                                                        <button class="text-sm font-bold {{ $component->status()->color }} cursor-default" data-title="Last update: {{ $group->updated_at }}" data-placement="top">
                                                                            {{ $component->status()->name }}
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
            @if(\App\Models\Metric::query()->where('visibility', true)->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl">
                        Metrics
                    </h2>
                    @foreach(\App\Models\Metric::query()->where('visibility', true)->get() as $metric)
                        @livewire('home.metric', ['metric' => $metric], key($metric->id))
                    @endforeach
                </div>
            @endif
            @if($upcoming_maintenances->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl">
                        Scheduled Maintenance
                    </h2>
                    @foreach($upcoming_maintenances as $maintenance)
                        <div class="w-full">
                            <div class="mt-4 text-xl w-full">
                                <span class="font-bold text-{{ $maintenance->getImpactColor() }}">{{ $maintenance->title }}</span> <span class="float-right text-sm text-gray-400">Scheduled for: {{ $maintenance->scheduled_at }}</span>
                            </div>
                        </div>
                        <div class="my-2 w-full border-t border-gray-300"></div>
                        <div class="mb-12">
                            @foreach($maintenance->incidentUpdates()->orderBy('id', 'desc')->get() as $update)
                                <div class="mb-2">
                                    <span class="font-bold">{{ $update->getUpdateType() }}</span> - {{ $update->text }}<br>
                                    <span class="text-gray-400">{{ $update->updated_at }} by {{ $update->getReporter()->name }}</span>
                                </div>
                            @endforeach
                            <span class="text-sm text-gray-400">Affected Components: {{ $maintenance->components()->get()->map(function ($component){
                                                                                                    return $component->group()->name.' - '.$component->name;
                                                                                                })->implode('; ') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="mt-12">
                <h2 class="text-2xl">
                    Past Incidents
                </h2>
                @for($i = 0; $i <= config('app.mainpage_incident_days'); $i++)
                    <div class="mb-8">
                        <div class="w-full">
                            <div class="mt-4 text-xl w-full">
                                {{ \Carbon\Carbon::now()->subDays($i)->monthName }} {{ \Carbon\Carbon::now()->subDays($i)->day }}, {{ \Carbon\Carbon::now()->subDays($i)->year }}
                            </div>
                        </div>
                        <div class="my-2 w-full border-t border-gray-300 dark:border-discordGrey"></div>
                        @if(\App\Models\Incident::query()->where([['visibility', '=', true], ['status', '=', 3]])->whereDate('updated_at', \Carbon\Carbon::now()->subDays($i))->count() > 0)
                            @foreach(\App\Models\Incident::query()->where([['visibility', '=', true], ['status', '=', 3]])->whereDate('updated_at', \Carbon\Carbon::now()->subDays($i))->orderBy('id', 'desc')->get() as $incident)
                                <div class="mt-6">
                                    <h3 class="text-xl font-bold text-{{ $incident->getImpactColor() }}">
                                        {{ $incident->title }}
                                    </h3>

                                    @foreach($incident->incidentUpdates()->orderBy('id', 'desc')->get() as $update)
                                        <div class="mb-2">
                                            <span class="font-bold">{{ $update->getUpdateType() }}</span> - {{ $update->text }}<br>
                                            <span class="text-gray-400">{{ $update->updated_at }} by {{ $update->getReporter()->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @else
                            <div class="mb-2 text-gray-400">
                                No incidents reported.
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    </div>
</x-guest-layout>
