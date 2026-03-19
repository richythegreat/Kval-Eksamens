<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Dzēst kontu</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-white/70">
           Jūsu konts tiks neatgriezeniski dzēsts.
        </p>
    </header>

    <div class="rounded-2xl bg-white/5 ring-1 ring-gray-200 dark:ring-white/10 backdrop-blur-xl p-6">
        <button
            x-data
            x-on:click.prevent="$dispatch('open-delete-modal')"
            class="px-4 py-2 rounded-full text-sm bg-rose-600 text-white hover:bg-rose-700">
            Dzēst kontu
        </button>

        {{-- Modal --}}
        <div x-data="{ open: false }"
             x-on:open-delete-modal.window="open = true"
             x-show="open"
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50" @click="open = false" aria-hidden="true"></div>

            <div class="relative w-full sm:max-w-md mx-auto">
                <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 backdrop-blur-xl p-6">
                    <h3 class="text-lg font-medium text-white">Vai esat pārliecināts?</h3>
                    <p class="mt-1 text-sm text-white/70">
                        Lūdzu ievadiet savu paroli lai dzēstu kontu.
                    </p>

                    <form method="post" action="{{ route('profile.destroy') }}" class="mt-4 space-y-4">
                        @csrf
                        @method('delete')

                        <div>
                            <label class="block text-sm font-medium text-white/80">Parole</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="w-full rounded-xl bg-white/5 text-white placeholder-white/40 ring-1 ring-white/10
                                       focus:outline-none focus:ring-2 focus:ring-white/40 px-3 py-2">
                            @error('password') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <button type="button"
                                    @click="open = false"
                                    class="px-4 py-2 rounded-full text-sm ring-1 ring-white/10 text-white/80 hover:bg-white/10">
                                Atcelt
                            </button>
                            <button
                                class="px-4 py-2 rounded-full text-sm bg-rose-600 text-white hover:bg-rose-700">
                                Dzēst
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
