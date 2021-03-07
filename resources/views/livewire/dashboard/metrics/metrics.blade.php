<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Metrics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-4 bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Title') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Suffix') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Visibility') }}
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                @can('add_metrics')
                                    @livewire('dashboard.metrics.modals.metric-add-modal')
                                @endcan
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($metrics as $metric)
                            <tr class="bg-white">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $metric->title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $metric->suffix }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $metric->visibility ? 'True' : 'False' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @can('edit_metrics')
                                        @livewire('dashboard.metrics.modals.metric-update-modal', ['metric' => $metric], key($metric->id))
                                    @endcan
                                    @can('delete_metrics')
                                        @livewire('dashboard.metrics.modals.metric-delete-modal', ['metric' => $metric], key($metric->id))
                                    @endcan
                                    @can('delete_metric_points')
                                        @livewire('dashboard.metrics.modals.metric-delete-points-modal', ['metric' => $metric], key($metric->id))
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
