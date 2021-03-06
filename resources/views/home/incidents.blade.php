<?php
use App\Models\Component;
use App\Models\Incident;
use App\Models\Status;
use Illuminate\Support\Facades\Cache;

$components = Cache::remember('home_components', config('cache.ttl'), function (){
    return Component::all();
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
