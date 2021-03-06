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
