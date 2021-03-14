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
                                <span class="font-bold">{{ $update->getUpdateType() }}</span> - <span class="markdown-content">{!! \Illuminate\Support\Str::markdown($update->text) !!}<br>
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
