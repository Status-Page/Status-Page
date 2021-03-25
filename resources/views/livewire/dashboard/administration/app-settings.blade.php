<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('App Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex-col space-y-4">
            <livewire:dashboard.administration.app-settings.general />
            <x-jet-section-border />
            <livewire:dashboard.administration.app-settings.database />
        </div>
    </div>
</div>
