<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex flex-col">
        @can('add_componentgroups')
            @livewire('dashboard.components.modals.component-group-add-modal')
        @endcan
        @foreach($groups as $group)
            <x-jet-section-title>
                <x-slot name="title">
                    Group: {{ $group->name }}
                    @can('edit_componentgroups')
                        @livewire('dashboard.components.modals.component-group-update-modal', ['group' => $group], key($group->id))
                    @endcan
                    @can('delete_componentgroups')
                        @livewire('dashboard.components.modals.component-group-delete-modal', ['group' => $group], key($group->id))
                    @endcan
                </x-slot>
                <x-slot name="description">
                    ID: {{ $group->id }} | Visibility: {{ $group->visibility == 0 ? 'False' : 'True' }}
                    @can('edit_componentgroups')
                        <button wire:loading.attr="disabled" wire:click="changeVisibility({{ $group->id }}, {{ $group->visibility }})" class="text-indigo-600 hover:text-indigo-900">Switch Visibility</button>
                    @endcan
                    | Creator: {{ $group->user()->name }} | Order: {{ $group->order }}
                </x-slot>
            </x-jet-section-title>
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 mt-2">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Visibility
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Order
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Creator
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        @can('add_components')
                                            @livewire('dashboard.components.modals.component-add-modal', ['group' => $group], key($group->id))
                                        @endcan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($group->components() as $comp)
                                    <tr class="bg-white">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $comp->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $comp->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $comp->visibility == 0 ? 'False' : 'True' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $comp->order }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ str_replace('text-', 'bg-', $comp->status()->color) }} text-white">
                                                    &nbsp;&nbsp;
                                                </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $comp->user()->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="inline">
                                                @can('edit_components')
                                                    @livewire('dashboard.components.modals.component-update-modal', ['comp' => $comp], key($comp->id))
                                                @endcan

                                                @can('edit_components')
                                                    <!-- <a href="{{ route('dashboard.incidents.show', ['id' => $comp->id]) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Details</a> -->
                                                @endcan

                                                @can('delete_components')
                                                    @livewire('dashboard.components.modals.component-delete-modal', ['comp' => $comp], key($comp->id))
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <x-jet-section-border></x-jet-section-border>
        @endforeach
    </div>
</div>

