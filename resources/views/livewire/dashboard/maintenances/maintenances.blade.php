<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Impact
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Scheduled at
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    End at
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reporter
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    @can('add_incidents')
                                        @livewire('dashboard.maintenances.modals.maintenance-add-modal')
                                    @endcan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenances as $maintenance)
                                <tr class="bg-white">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $maintenance->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $maintenance->getType() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $maintenance->getImpactColor() }} text-white">
                                            &nbsp;&nbsp;
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $maintenance->scheduled_at }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $maintenance->end_at }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $maintenance->getReporter()->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @can('edit_incidents')
                                            @livewire('dashboard.maintenances.modals.maintenance-update-modal', ['maintenance' => $maintenance], key($maintenance->id))
                                        @endcan

                                        @can('edit_incidents')
                                            <!-- <a href="{{ route('dashboard.incidents.show', ['id' => $maintenance->id]) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Details</a> -->
                                        @endcan

                                        @can('delete_incidents')
                                            @livewire('dashboard.incidents.modals.incident-delete-modal', ['incident' => $maintenance], key($maintenance->id))
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
