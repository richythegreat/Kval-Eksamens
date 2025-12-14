<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Update Password</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-white/70">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <div class="rounded-2xl bg-white/5 ring-1 ring-gray-200 dark:ring-white/10 backdrop-blur-xl p-6">
        <form method="post" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('put')

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-white/80">Current Password</label>
                <input
                    id="current_password"
                    name="current_password"
                    type="password"
                    autocomplete="current-password"
                    class="w-full rounded-xl bg-white text-gray-900 placeholder-gray-400 ring-1 ring-gray-300
                           focus:outline-none focus:ring-2 focus:ring-blue-500 px-3 py-2
                           dark:bg-white/5 dark:text-white dark:placeholder-white/40 dark:ring-white/10 dark:focus:ring-white/40"
                >
                @error('current_password') <p class="mt-1 text-sm text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-white/80">New Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    class="w-full rounded-xl bg-white text-gray-900 placeholder-gray-400 ring-1 ring-gray-300
                           focus:outline-none focus:ring-2 focus:ring-blue-500 px-3 py-2
                           dark:bg-white/5 dark:text-white dark:placeholder-white/40 dark:ring-white/10 dark:focus:ring-white/40"
                >
                @error('password') <p class="mt-1 text-sm text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-white/80">Confirm Password</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    class="w-full rounded-xl bg-white text-gray-900 placeholder-gray-400 ring-1 ring-gray-300
                           focus:outline-none focus:ring-2 focus:ring-blue-500 px-3 py-2
                           dark:bg-white/5 dark:text-white dark:placeholder-white/40 dark:ring-white/10 dark:focus:ring-white/40"
                >
            </div>

            <div class="flex items-center gap-3">
                <button
                    class="px-4 py-2 rounded-full text-sm font-medium bg-gray-900 text-white ring-1 ring-gray-900 hover:bg-black
                           dark:bg-white dark:text-black dark:ring-white dark:hover:bg-white/90">
                    Save
                </button>

                @if (session('status') === 'password-updated')
                    <p class="text-sm text-green-600 dark:text-green-400">Saved.</p>
                @endif
            </div>
        </form>
    </div>
</section>
