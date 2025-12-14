<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lost & Found') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-neutral-950 text-white antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')

        {{-- Hero / page header --}}
        <header class="relative overflow-hidden">
            {{-- soft top gradients for depth (no images) --}}
            <div aria-hidden="true" class="pointer-events-none absolute inset-0">
                <div class="absolute -top-40 -left-40 h-[34rem] w-[34rem] rounded-full bg-indigo-500/20 blur-3xl"></div>
                <div class="absolute -top-56 right-0 h-[34rem] w-[34rem] rounded-full bg-fuchsia-500/10 blur-3xl"></div>
            </div>

            <div class="relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                    <div class="flex flex-col gap-2">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-semibold tracking-tight text-white">
                            {{ $header ?? 'Lost & Found' }}
                        </h1>
                        <p class="text-white/70 text-sm sm:text-base max-w-2xl">
                            Post lost items, report found items, and connect privately.
                        </p>
                    </div>
                </div>
            </div>

            {{-- subtle divider line --}}
            <div class="h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </main>

        <footer class="border-t border-white/10 bg-neutral-950/80 backdrop-blur">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-sm text-white/60">
                © {{ date('Y') }} Lost &amp; Found — built with Laravel
            </div>
        </footer>
    </div>
</body>
</html>
