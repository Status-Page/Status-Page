<footer>
    @if(\App\Models\Setting::getBoolean('footer_show'))
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-gray-200 py-8 text-sm text-gray-500 text-center dark:border-aGrey">
                @if(\App\Models\CustomStyle::hasActiveStyles('enable_footer'))
                    @foreach(\App\Models\CustomStyle::getActiveStyles('enable_footer') as $style)
                        @if($style->enable_footer)
                            {!! $style->footer !!}
                        @endif
                    @endforeach
                @else
                    <span class="block sm:inline">&copy; 2021 - {{ date("Y") }} <a href="https://github.com/Status-Page/Status-Page" class="hover:text-blue-500 transition ease-in-out duration-500">Status-Page</a>.</span>
                    <span class="block sm:inline">All rights reserved.</span>
                    @if(\App\Models\Setting::getBoolean('footer_showDashboardLink'))
                        <span class="block sm:inline"><a href="{{ route('dashboard') }}" class="hover:text-blue-500 transition ease-in-out duration-500">Dashboard</a>.</span>
                    @endif
                    @if(\App\Models\Setting::getBoolean('subscriber_signup'))
                        <span class="block sm:inline ml-10">
                        <a
                            href="{{ route('subscribers.new') }}"
                            class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform ease-in-out duration-500"
                        >Manage Subscriptions</a>
                    </span>
                    @endif
                @endif
            </div>
        </div>
    @endif
</footer>
