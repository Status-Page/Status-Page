<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('dashboard.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div class="bg-white dark:bg-discordDark overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-white truncate">
                            {{ __('dashboard.quick_view.incidents') }}
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white ">
                            {{ $incidents->count() }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-discordBlack px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('dashboard.incidents') }}" class="font-medium text-indigo-600 hover:text-indigo-500"> {{ __('dashboard.view_all') }}</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-discordDark overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-white truncate">
                            {{ __('dashboard.quick_view.maintenances') }}
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                            {{ $maintenances->count() }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-discordBlack px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('dashboard.maintenances') }}" class="font-medium text-indigo-600 hover:text-indigo-500"> {{ __('dashboard.view_all') }}</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-discordDark overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-white truncate">
                            {{ __('dashboard.quick_view.upcoming_maintenances') }}
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                            {{ $upcoming_maintenances->count() }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-discordBlack px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('dashboard.maintenances') }}" class="font-medium text-indigo-600 hover:text-indigo-500"> {{ __('dashboard.view_all') }}</a>
                        </div>
                    </div>
                </div>
            </dl>

            <div class="mt-4 bg-white dark:bg-discordDark overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-discordDark">
                    {{ __('dashboard.logged_in') }}
                </div>
            </div>
            <br>
        </div>
    </div>
</x-app-layout>
