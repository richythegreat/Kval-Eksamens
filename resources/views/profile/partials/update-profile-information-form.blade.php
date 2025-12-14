<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Profile Information</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-white/70">
            Update your account’s profile information and email address.
        </p>
    </header>

    <div class="rounded-2xl bg-white/5 ring-1 ring-gray-200 dark:ring-white/10 backdrop-blur-xl p-6">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('patch')

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-white/80">Name</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $user->name) }}"
                    required
                    autofocus
                    autocomplete="name"
                    class="w-full rounded-xl bg-white text-gray-900 placeholder-gray-400 ring-1 ring-gray-300
                           focus:outline-none focus:ring-2 focus:ring-blue-500 px-3 py-2
                           dark:bg-white/5 dark:text-white dark:placeholder-white/40 dark:ring-white/10 dark:focus:ring-white/40"
                >
                @error('name') <p class="mt-1 text-sm text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-white/80">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    autocomplete="username"
                    class="w-full rounded-xl bg-white text-gray-900 placeholder-gray-400 ring-1 ring-gray-300
                           focus:outline-none focus:ring-2 focus:ring-blue-500 px-3 py-2
                           dark:bg-white/5 dark:text-white dark:placeholder-white/40 dark:ring-white/10 dark:focus:ring-white/40"
                >
                @error('email') <p class="mt-1 text-sm text-rose-400">{{ $message }}</p> @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-3 text-sm">
                        <p class="text-gray-600 dark:text-white/70">
                            Your email address is unverified.
                            <button form="send-verification"
                                    class="underline underline-offset-2 text-gray-900 hover:text-black dark:text-white">
                                Click here to re-send the verification email.
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-green-600 dark:text-green-400">
                                A new verification link has been sent to your email address.
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-3">
                <button
                    class="px-4 py-2 rounded-full text-sm font-medium bg-gray-900 text-white ring-1 ring-gray-900 hover:bg-black
                           dark:bg-white dark:text-black dark:ring-white dark:hover:bg-white/90">
                    Save
                </button>

                @if (session('status') === 'profile-updated')
                    <p class="text-sm text-green-600 dark:text-green-400">Saved.</p>
                @endif
            </div>
        </form>
    </div>
</section>
