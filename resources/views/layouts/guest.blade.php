{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Lost & Found') }}</title>

    {{-- Prevent theme flash + provide toggle() --}}
    <script>
      (function () {
        try {
          const saved = localStorage.getItem('theme');
          const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
          const shouldDark = saved ? saved === 'dark' : prefersDark;
          document.documentElement.classList.toggle('dark', shouldDark);
          window.toggleTheme = () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
          };
        } catch {}
      })();
    </script>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 antialiased dark:bg-neutral-950 dark:text-white">
    {{-- Simple header with Login/Register links (optional) --}}
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-gray-200 dark:bg-neutral-950/70 dark:border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-500 via-blue-500 to-cyan-400"></div>
                <span class="font-semibold tracking-tight">Lost &amp; Found</span>
            </a>
            <div class="flex items-center gap-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-full text-sm ring-1 ring-gray-200 hover:bg-gray-100 dark:ring-white/10 dark:hover:bg-white/10">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-full text-sm ring-1 ring-gray-200 hover:bg-gray-100 dark:ring-white/10 dark:hover:bg-white/10">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-3 py-1.5 rounded-full text-sm bg-gray-900 text-white ring-1 ring-gray-900 hover:bg-black dark:bg-white dark:text-black dark:ring-white dark:hover:bg-white/90">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    {{-- Nice subtle hero band --}}
    <div class="relative overflow-hidden">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0">
            <div class="absolute -top-40 -left-40 h-[28rem] w-[28rem] rounded-full bg-indigo-500/15 blur-3xl"></div>
            <div class="absolute -top-56 right-0 h-[28rem] w-[28rem] rounded-full bg-fuchsia-500/10 blur-3xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight">Welcome</h1>
            <p class="text-sm text-gray-600 dark:text-white/70">Sign in or create an account to continue.</p>
        </div>
        <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent dark:via-white/10"></div>
    </div>

    {{-- Auth card slot --}}
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <footer class="border-t border-gray-200 bg-white/70 dark:border-white/10 dark:bg-neutral-950/70 backdrop-blur">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-sm text-gray-600 dark:text-white/60">
            © {{ date('Y') }} Lost &amp; Found
        </div>
    </footer>
</body>
</html>
