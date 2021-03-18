<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10">
        <div class="max-w-3xl mx-auto">
            <div class="mt-12 text-4xl flex justify-between">
                <div>
                    <h1 class="inline">{{ config('app.name') }}</h1>
                </div>
                @auth()
                    <div>
                        <a href="{{ route('dashboard') }}" target="_blank">
                            <x-jet-button class="text-right dark:bg-discordGrey">Open Dashboard</x-jet-button>
                        </a>
                    </div>
                @endauth
            </div>
            @include('home.incidents')
            @include('home.components')
            @include('home.metrics')
            @include('home.upcoming-maintenances')
            @include('home.past-incidents')
        </div>
    </div>
</div>
