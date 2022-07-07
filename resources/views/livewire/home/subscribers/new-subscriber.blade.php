<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10">
        <div class="max-w-3xl mx-auto">
            <div class="mt-12 text-4xl flex justify-between">
                <div>
                    <h1 class="inline">{{ config('app.name') }}</h1>
                </div>
                <div class="space-x-2 flex items-center">
                    <div>
                        <a href="{{ route('home') }}">
                            <x-jet-button class="text-right dark:bg-discordGrey">{{ __('home.home') }}</x-jet-button>
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
        @if(!$submitted)
            <p class="inline text-3xl font-extrabold tracking-tight text-indigo-400 sm:block sm:text-4xl">Sign up to receive E-Mail Notifications</p>
            <form class="mt-8 sm:flex" method="post">
                @csrf
                <label for="email" class="sr-only">Email address</label>
                <input id="email" name="email" wire:model.lazy="email" type="email" autocomplete="email" required class="w-full px-5 py-3 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs border-gray-700 rounded-md bg-discordBlack" placeholder="Enter your email">
                <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3 sm:shrink-0">
                    <button type="submit" class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform ease-in-out duration-500">
                        Notify me
                    </button>
                </div>
            </form>
        @elseif($submitted && $success)
            <div class="rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="shrink-0">
                        <!-- Heroicon name: solid/check-circle -->
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">
                            Successfully subscribed
                        </h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>
                                Please check your Mail and click the provided Link in the Verification Info. This Link will expire after 24 Hours.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($submitted && !$success)
            <div class="rounded-md bg-red-50 p-4">
                <div class="flex">
                    <div class="shrink-0">
                        <!-- Heroicon name: solid/x-circle -->
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            There were {{ $validation_errors->count() }} errors with your subscription
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($validation_errors->getMessages() as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
