<x-guest-layout>
    <div class="min-h-screen grid place-items-center px-4">
        <div class="w-full max-w-md rounded-2xl bg-white/5 ring-1 ring-gray-200 dark:ring-white/10 backdrop-blur-xl p-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Forgot password</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-white/70">Enter your email and we’ll send a reset link.</p>

            @if (session('status'))
                <div class="mt-3 text-sm text-green-600 dark:text-green-400">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white/80">Email</label>
                    <input name="email" type="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-xl bg-white text-gray-900 placeholder-gray-400 ring-1 ring-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 px-3 py-2 dark:bg-white/5 dark:text-white dark:placeholder-white/40 dark:ring-white/10 dark:focus:ring-white/40">
                    @error('email') <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>

                <button type="submit"
                        class="w-full px-4 py-2 rounded-full text-sm font-medium bg-gray-900 text-white ring-1 ring-gray-900 hover:bg-black
                               dark:bg-white dark:text-black dark:ring-white dark:hover:bg-white/90">
                    Email password reset link
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600 dark:text-white/70">
                <a href="{{ route('login') }}" class="underline">Back to sign in</a>
            </p>
        </div>
    </div>
</x-guest-layout>
