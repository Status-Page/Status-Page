<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ !session()->get('darkmode', \App\Models\Setting::getBoolean('darkmode_default')) ?: 'dark' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="https://unpkg.com/tippy.js@6"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.x/dist/alpine.min.js" defer></script>
    </head>
    <body class="font-sans antialiased dark:bg-bodyBG">
        <div class="flex flex-col min-h-screen">
            <div class="grow">
                <x-notification />
                @if(config('app.env') == 'local' || config('app.env') == 'staging')
                    <div class="bg-red-600">
                        <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
                            <div class="flex items-center justify-between flex-wrap">
                                <div class="w-0 flex-1 flex items-center">
                                    <p class="ml-3 font-medium text-white truncate">
                                <span class="md:hidden">
                                    Status-Page {{ config('app.env') }}
                                </span>
                                        <span class="hidden md:inline">
                                    This is a {{ config('app.env') }} version of the Statuspage.<br>
                                    Set APP_ENV in '.env' to 'production', if you want to suppress this message.<br>
                                    Run 'php artisan config:cache' after changing this variable.
                                </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(config('app.debug') == true)
                    <div class="bg-red-600">
                        <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
                            <div class="flex items-center justify-between flex-wrap">
                                <div class="w-0 flex-1 flex items-center">
                                    <p class="ml-3 font-medium text-white truncate">
                                <span class="md:hidden">
                                    Debugging is enabled!
                                </span>
                                        <span class="hidden md:inline">
                                    Debugging is enabled! You should deactivate debugging, as you could leak confidential information about your installation.<br>
                                    Set APP_DEBUG in '.env' to 'false', if you want to suppress this message.<br>
                                    Run 'php artisan config:cache' after changing this variable.
                                </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!\App\Statuspage\Version::getLatestVersion()->meta->on_latest)
                    <div class="bg-red-600">
                        <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
                            <div class="flex items-center justify-between flex-wrap">
                                <div class="w-0 flex-1 flex items-center">
                                    <p class="ml-3 font-medium text-white truncate">
                                <span class="md:hidden">
                                    Update available!
                                </span>
                                        <span class="hidden md:inline">
                                    There is an Update available!<br>
                                    New Version: {{ \App\Statuspage\Version::getLatestVersion()->meta->git->last_tag }}<br>
                                    Current Version: {{ \App\Statuspage\Version::getLatestVersion()->meta->git->tag }}
                                </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <x-jet-banner />

                <div class="min-h-screen bg-gray-100 dark:bg-bodyBG dark:text-white">
                @livewire('navigation-menu')

                <!-- Page Heading -->
                    @if (isset($header))
                        <header class="bg-white shadow dark:bg-discordDark dark:text-white">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                @endif

                <!-- Page Content -->
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>
            <div>
                @include('global.footer')
            </div>
        </div>

        @stack('modals')

        @livewireScripts
        <script src="{{ mix('js/misc.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
    </body>
</html>
