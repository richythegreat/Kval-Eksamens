<x-guest-layout>
    <div class="min-h-screen grid place-items-center px-4">
        <div class="w-full max-w-md rounded-2xl bg-white/5 dark:bg-white/5 ring-1 ring-gray-200 dark:ring-white/10 backdrop-blur-xl p-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Sign in</h1>
            @if (session('status'))
                <div class="mt-3 text-sm text-green-600 dark:text-green-400">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white/80">Email</label>
                    <input name="email" type="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-xl bg-white text-gray-900 placeholder-gray-400 ring-1 ring-gray-300
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 px-3 py-2
                                  dark:bg-white/5 dark:text-white dark:placeholder-white/40 dark:ring-white/10 dark:focus:ring-white/40">
                    @error('email') <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white/80">Password</label>
                    <input name="password" type="password" required
                           class="w-full rounded-xl bg-white text-gray-900 placeholder-gray-400 ring-1 ring-gray-300
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 px-3 py-2
                                  dark:bg-white/5 dark:text-white dark:placeholder-white/40 dark:ring-white/10 dark:focus:ring-white/40">
                    @error('password') <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-white/80">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:bg-white/5 dark:border-white/10">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-gray-700 hover:underline dark:text-white/80">Forgot?</a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full px-4 py-2 rounded-full text-sm font-medium bg-gray-900 text-white ring-1 ring-gray-900 hover:bg-black
                               dark:bg-white dark:text-black dark:ring-white dark:hover:bg-white/90">
                    Sign in
                </button>
            </form>

            @if (Route::has('register'))
            <p class="mt-6 text-center text-sm text-gray-600 dark:text-white/70">
                New here?
                <a href="{{ route('register') }}" class="underline">Create an account</a>
            </p>
            @endif
        </div>
    </div>
</x-guest-layout>
