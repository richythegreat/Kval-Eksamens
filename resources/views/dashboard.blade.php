{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl sm:text-2xl text-white leading-tight">
            {{ __('Informācijas panelis') }}
        </h2>
    </x-slot>

    <div class="py-10 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Welcome card --}}
            <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 backdrop-blur-xl overflow-hidden">
                <div class="p-6 sm:p-8">
                    <p class="text-white/80 text-base">
                        {{ __("Jūs esat ierakstījies!") }}
                    </p>

                    {{-- Quick actions --}}
                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <a href="{{ route('items.index') }}"
                           class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                                  bg-white text-black hover:bg-white/90 transition ring-1 ring-white/10">
                            Pārlūkojiet sludinājumus
                        </a>

                        <a href="{{ route('items.create') }}"
                           class="inline-flex items-center px-4 py-2 rounded-full text-sm
                                  ring-1 ring-white/10 text-white/80 hover:bg-white/10 hover:text-white transition">
                            + pievienot sludinājumu
                        </a>

                        <a href="{{ route('conversations.index') }}"
                           class="inline-flex items-center px-4 py-2 rounded-full text-sm
                                  ring-1 ring-white/10 text-white/80 hover:bg-white/10 hover:text-white transition">
                            Īsziņas
                        </a>
                    </div>
                </div>

                <div class="h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

                {{-- Mini tips  --}}
                <div class="p-6 sm:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="rounded-xl bg-white/5 ring-1 ring-white/10 p-4">
                            <div class="text-sm font-medium text-white">Ātri publicējiet</div>
                            <div class="mt-1 text-xs text-white/60">Nosaukums, pilsēta, statuss, attēls.</div>
                        </div>
                        <div class="rounded-xl bg-white/5 ring-1 ring-white/10 p-4">
                            <div class="text-sm font-medium text-white">Meklēšana & filtri</div>
                            <div class="mt-1 text-xs text-white/60">Izmantojiet navigācijas joslas meklēšanu, lai ātri atrastu priekšmetus.</div>
                        </div>
                        <div class="rounded-xl bg-white/5 ring-1 ring-white/10 p-4">
                            <div class="text-sm font-medium text-white">Privātā saziņa</div>
                            <div class="mt-1 text-xs text-white/60">Droši sazinieties ar īpašniekiem, izmantojot saziņu.</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CTA block --}}
            <div class="mt-8">
                <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 backdrop-blur-xl p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-white text-lg font-semibold">Vai esat gatavs pievienot vai atrast priekšmetu?</h3>
                        <p class="mt-1 text-white/70 text-sm">Izveidojiet ierakstu vai pārlūkojiet jaunāko informāciju savā pilsētā.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('items.create') }}"
                           class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                                  bg-white text-black hover:bg-white/90 transition ring-1 ring-white/10">
                            Izveidot sludinājumu
                        </a>
                        <a href="{{ route('items.index') }}"
                           class="inline-flex items-center px-4 py-2 rounded-full text-sm
                                  ring-1 ring-white/10 text-white/80 hover:bg-white/10 hover:text-white transition">
                            apskatīt sludinājumu
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
