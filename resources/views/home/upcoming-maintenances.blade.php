<div>
    @if($upcoming_maintenances->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl">
                {{ __('home.upcoming_maintenances.title') }}
            </h2>
            @foreach($upcoming_maintenances as $maintenance)
                <div class="w-full">
                    <div class="mt-4 text-xl w-full">
                        <span class="font-bold text-{{ $maintenance->getImpactColor() }}">{{ $maintenance->title }}</span> <span class="float-right text-sm text-gray-400">{{ __('home.upcoming_maintenances.scheduled_for') }}: {{ $maintenance->scheduled_at }}</span>
                    </div>
                </div>
                <div class="my-2 w-full border-t border-gray-300"></div>
                <div class="mb-12">
                    @foreach($maintenance->incidentUpdates()->orderBy('id', 'desc')->get() as $update)
                        <div class="mb-2">
                            <span class="font-bold">{{ $update->getUpdateType() }}</span> - <span class="markdown-content">{!! \Illuminate\Support\Str::markdown($update->text) !!}<br>
                        <span class="text-gray-400">{{ $update->updated_at }} by {{ $update->getReporter()->name }}</span>
                        </div>
                    @endforeach
                    <span class="text-sm text-gray-400">{{ __('home.upcoming_maintenances.affected_components') }}: {{ $maintenance->components()->get()->map(function ($component){
                                                                                                    return $component->group()->name.' - '.$component->name;
                                                                                                })->implode('; ') }}
                            </span>
                </div>
            @endforeach
        </div>
    @endif
</div>
