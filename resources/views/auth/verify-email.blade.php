<x-guest-layout>
    <div class="min-h-screen grid place-items-center px-4">
        <div class="w-full max-w-md rounded-2xl bg-white/5 ring-1 ring-gray-200 dark:ring-white/10 backdrop-blur-xl p-6 text-center">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Apstipriniet epasta adresi</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-white/70">
                Mēs nosūtījām jums apstiprināšanas kodu.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mt-3 text-sm text-green-600 dark:text-green-400">
                   Jauns epasts tika nosūtīts.
                </div>
            @endif

            <div class="mt-6 flex flex-col gap-3">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button class="w-full px-4 py-2 rounded-full text-sm font-medium bg-gray-900 text-white ring-1 ring-gray-900 hover:bg-black
                                   dark:bg-white dark:text-black dark:ring-white dark:hover:bg-white/90">
                        Vēlreiz nosūtīt.
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full px-4 py-2 rounded-full text-sm ring-1 ring-gray-200 text-gray-800 hover:bg-gray-100
                                   dark:ring-white/10 dark:text-white dark:hover:bg-white/10">
                        Izrakstīties
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
