<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('users.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex-col space-y-4">
            <div class="flex justify-between">
                <div class="w-1/3 flex space-x-2">
                    <x-jet-input type="text" wire:model="search" placeholder="Search Users..." class="w-full"></x-jet-input>
                </div>

                <div class="space-x-2 flex items-center">
                    <x-input.group borderless paddingless for="perPage" label="Per Page">
                        <x-input.select wire:model="perPage" id="perPage" class="rounded-md">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </x-input.select>
                    </x-input.group>

                    @can('add_users')
                        @livewire('dashboard.administration.modals.user-add-modal')
                    @endcan
                </div>
            </div>
            <x-table>
                <x-slot name="head">
                    <x-table.heading></x-table.heading>
                    <x-table.heading>{{ __('users.table.head.name') }}</x-table.heading>
                    <x-table.heading>{{ __('users.table.head.email') }}</x-table.heading>
                    <x-table.heading>{{ __('users.table.head.deactivated') }}</x-table.heading>
                    <x-table.heading>{{ __('users.table.head.role') }}</x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @forelse($users as $user)
                        <x-table.row wire:loading.class.delay="opacity-50">
                            <x-table.cell>
                                <img class="rounded-full h-12 w-12" src="{{ $user->getProfilePhotoUrlAttribute() }}" />
                            </x-table.cell>
                            <x-table.cell class="font-medium text-gray-900">{{ $user->name }}</x-table.cell>
                            <x-table.cell class="text-gray-500">{{ $user->email }}</x-table.cell>
                            <x-table.cell class="text-gray-500">{{ $user->deactivated ? 'True' : 'False' }}</x-table.cell>
                            <x-table.cell class="text-gray-500">{{ $user->getRoleNames()->first() }}</x-table.cell>
                            <x-table.cell>
                                @if($user->id == Auth::id())
                                    <button data-title="{{ __('You can\'t edit yourself here!') }}" data-placement="top" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 focus:outline-none cursor-default">
                                        Yourself
                                    </button>
                                @elseif($user->system || $user->getRoleNames()->first() == 'super_admin')
                                    <button data-title="{{ __('This is the System  / Super Admin User. You can\'t edit it and never should!') }}" data-placement="top" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 focus:outline-none cursor-default">
                                        System / Super Admin User
                                    </button>
                                @else
                                    @can('edit_users')
                                        <livewire:dashboard.administration.modals.user-update-modal :user="$user" :key="time().$user->id" />
                                    @endcan
                                    @can('delete_users')
                                        <livewire:dashboard.administration.modals.user-delete-modal :user="$user" :key="time().time().$user->id" />
                                    @endcan
                                @endif
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="6">
                                <div class="flex justify-center items-center">
                                    <span class="font-medium py-8 text-gray-400 text-xl">No results...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table>

            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
