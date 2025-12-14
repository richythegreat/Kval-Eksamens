{{-- resources/views/welcome.blade.php --}}
<x-guest-layout>
    <div class="min-h-[70vh] grid place-items-center px-4">
        <div class="text-center space-y-4">
            <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                Lost &amp; Found
            </h1>
            <p class="text-sm text-gray-600 dark:text-white/70">
                Find what’s lost. Return what’s found.
            </p>

            <div class="flex items-center justify-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-5 py-2 rounded-full text-sm font-medium
                              bg-gray-900 text-white ring-1 ring-gray-900 hover:bg-black
                              dark:bg-white dark:text-black dark:ring-white dark:hover:bg-white/90">
                        Go to dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-5 py-2 rounded-full text-sm ring-1 ring-gray-200 text-gray-800 hover:bg-gray-100
                              dark:ring-white/10 dark:text-white dark:hover:bg-white/10">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-5 py-2 rounded-full text-sm font-medium
                                  bg-gray-900 text-white ring-1 ring-gray-900 hover:bg-black
                                  dark:bg-white dark:text-black dark:ring-white dark:hover:bg-white/90">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</x-guest-layout>
