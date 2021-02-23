<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <x-jet-section-title>
        <x-slot name="title">
            {{ __('past.incidents.title')  }}
        </x-slot>
        <x-slot name="description">
            {{ __('past.incidents.subtitle')  }}
        </x-slot>
    </x-jet-section-title>
    <div class="flex flex-col mt-4">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('past.tables.head.title')  }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('past.tables.head.status')  }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('past.tables.head.impact')  }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('past.tables.head.reporter')  }}
                                </th>
                                <th scope="col" class="relative px-6 py-3">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($oldincidents as $incident)
                                <tr class="bg-white">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $incident->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $incident->getType() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $incident->getImpactColor() }} text-white">
                                            &nbsp;&nbsp;
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $incident->getReporter()->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @can('delete_incidents')
                                            @livewire('dashboard.incidents.modals.incident-delete-modal', ['incident' => $incident], key($incident->id))
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-jet-section-border />
    <x-jet-section-title>
        <x-slot name="title">
            {{ __('past.maintenances.title')  }}
        </x-slot>
        <x-slot name="description">
            {{ __('past.maintenances.subtitle')  }}
        </x-slot>
    </x-jet-section-title>
    <div class="flex flex-col mt-4">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('past.tables.head.title')  }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('past.tables.head.status')  }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('past.tables.head.impact')  }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('past.tables.head.reporter')  }}
                            </th>
                            <th scope="col" class="relative px-6 py-3">

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($oldmaintenances as $incident)
                            <tr class="bg-white">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $incident->title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $incident->getType() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $incident->getImpactColor() }} text-white">
                                            &nbsp;&nbsp;
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $incident->getReporter()->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @can('delete_incidents')
                                        @livewire('dashboard.incidents.modals.incident-delete-modal', ['incident' => $incident], key($incident->id))
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
