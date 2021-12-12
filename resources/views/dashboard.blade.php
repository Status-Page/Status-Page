<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('dashboard.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="hidden">
            <div class="text-gray-500 bg-black border-black"></div>
            <div class="text-green-400 bg-green-100 border-green-500"></div>
            <div class="text-yellow-500 bg-yellow-200 border-yellow-400"></div>
            <div class="text-yellow-700 bg-yellow-200 border-yellow-700"></div>
            <div class="text-red-500 bg-red-100 border-red-500"></div>
            <div class="text-blue-500 bg-blue-100 border-blue-500"></div>
            <div class="bg-green-500 bg-blue-500 bg-red-500 bg-gray-500"></div>
            <div class="bg-black bg-yellow-400 bg-yellow-600 bg-red-500 bg-blue-500"></div>
        </div>
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
