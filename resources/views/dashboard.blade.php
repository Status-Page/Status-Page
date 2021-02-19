<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Open Incidents
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900">
                            {{ $incidents->count() }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('dashboard.incidents') }}" class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Total Subscribers stats</span></a>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Open Maintenances
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900">
                            {{ $maintenances->count() }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('dashboard.incidents.maintenances') }}" class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Total Subscribers stats</span></a>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Upcoming Maintenances
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900">
                            {{ $upcoming_maintenances->count() }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('dashboard.incidents.maintenances') }}" class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Total Subscribers stats</span></a>
                        </div>
                    </div>
                </div>
            </dl>

            <div class="mt-4 bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
            <br>
        </div>
    </div>
</x-app-layout>
