<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('past.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <livewire:dashboard.incidents.past :incidents="$incidents" :oldincidents="$old_incidents" :maintenances="$maintenances" :oldmaintenances="$old_maintenances" :upcomingmaintenances="$upcoming_maintenances" />
    </div>
</x-app-layout>
