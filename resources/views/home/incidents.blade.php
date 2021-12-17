<div class="mt-6">
    @if($incidents->count() > 0)
        @foreach($incidents as $incident)
            <div class="bg-white text-black dark:bg-bodyBG dark:text-white border-{{ $incident->getImpactColor() }} border-2 rounded-md shadow mb-2">
                <div class="bg-{{ $incident->getImpactColor() }} text-white px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium">
                        {{ $incident->title }}
                    </h3>
                </div>
                <div class="px-4 py-5 sm:px-6">
                    @foreach($incident->incidentUpdates()->orderBy('id', 'desc')->get() as $update)
                        <div>
                            <span class="font-bold">{{ $update->getUpdateType() }}</span> - <span class="markdown-content">{!! \Illuminate\Support\Str::markdown($update->text) !!}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-400">{{ $update->updated_at }} by {{ $update->getReporter()->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div class="{{ $globalStatus->bg_color }} border-l-4 {{ $globalStatus->border_color }} p-4">
            <div class="flex">
                <div class="shrink-0 h-5 w-5 {{ $globalStatus->color }}">
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
