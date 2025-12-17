{{-- resources/views/layouts/navigation.blade.php --}}
<nav x-data="{ open: false }"
     class="sticky top-0 z-50 bg-white/80 backdrop-blur border-b border-gray-200 text-gray-800
            dark:bg-neutral-950/70 dark:border-white/10 dark:text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-16 flex items-center justify-between gap-4">

            {{-- Left --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('items.index') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-2xl bg-gradient-to-br from-indigo-500 via-blue-500 to-cyan-400 shadow-inner shadow-black/20"></div>
                    <div class="leading-tight">
                        <div class="font-semibold tracking-tight">Lost &amp; Found</div>
                        <div class="text-xs text-gray-500 dark:text-white/60 -mt-0.5">Latvia</div>
                    </div>
                </a>

                {{-- Primary nav (md+) --}}
                <div class="hidden md:flex items-center gap-1 ml-6">
                    @php
                        $linkBase = 'px-3 py-1.5 rounded-full text-sm ring-1 transition';
                        $inactive = 'ring-gray-200 text-gray-700 hover:bg-gray-50 dark:ring-white/10 dark:text-white/80 dark:hover:bg-white/10 dark:hover:text-white';
                        $active   = 'bg-gray-900 text-white ring-gray-900 dark:bg-white dark:text-black dark:ring-white';
                    @endphp

                    <a href="{{ route('items.index') }}"
                       class="{{ $linkBase }} {{ request()->routeIs('items.*') ? $active : $inactive }}">
                        Items
                    </a>
                    <a href="{{ route('items.create') }}"
                       class="{{ $linkBase }} {{ request()->routeIs('items.create') ? $active : $inactive }}">
                        Add
                    </a>
                    <a href="{{ route('conversations.index') }}"
                       class="{{ $linkBase }} {{ request()->routeIs('conversations.*') ? $active : $inactive }}">
                        Messages
                    </a>
                </div>
            </div>

            {{-- Right --}}
            <div class="flex items-center gap-2 sm:gap-3">

                {{-- Search --}}
                <form method="GET" action="{{ route('items.index') }}" class="hidden sm:block">
                    <div class="relative">
                        <input
                            type="text"
                            name="query"
                            value="{{ request('query') }}"
                            placeholder="Search items..."
                            class="w-64 rounded-full pl-4 pr-10 py-2 text-sm
                                   bg-white ring-1 ring-gray-300 placeholder-gray-400 text-gray-900
                                   focus:ring-2 focus:ring-blue-500 focus:outline-none
                                   dark:bg-white/5 dark:ring-white/10 dark:text-white dark:placeholder-white/40 dark:focus:ring-white/40"
                        >
                        <button type="submit" class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700 dark:text-white/60 dark:hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </button>
                    </div>
                </form>

                {{-- Notifications (dark-only, single badge + links) --}}
                @auth
                    @php
                        $unreadCount = Auth::user()->unreadNotifications()->count();
                        $latest = Auth::user()->notifications()->latest()->limit(8)->get();
                    @endphp

                    <x-dropdown align="right" width="80">
                        {{-- Trigger --}}
                        <x-slot name="trigger">
                            <button class="relative p-2 rounded-lg ring-1 ring-white/10 hover:bg-white/10 text-white"
                                    aria-label="Notifications">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>

                                @if($unreadCount > 0)
                                    <span class="absolute -top-0.5 -right-0.5 h-4 min-w-[1rem] px-1 rounded-full
                                                 bg-white text-black text-[10px] font-semibold grid place-items-center leading-none">
                                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                    </span>
                                @endif
                            </button>
                        </x-slot>

                        {{-- Panel (no white outline/ring) --}}
                        <x-slot name="content">
                            <div class="rounded-xl bg-neutral-900 text-white overflow-hidden shadow-2xl">
                                {{-- Header --}}
                                <div class="px-3 py-2 flex items-center justify-between border-b border-white/10">
                                    <div class="text-sm font-medium">Notifications</div>
                                    <div class="flex items-center gap-2">
                                        @if (Route::has('notifications.markAllRead') && $unreadCount > 0)
                                            <form method="POST" action="{{ route('notifications.markAllRead') }}">
                                                @csrf
                                                <button class="text-xs text-white/70 hover:text-white">
                                                    Mark all read
                                                </button>
                                            </form>
                                        @endif
                                        @if (Route::has('notifications.index'))
                                            <a href="{{ route('notifications.index') }}"
                                               class="text-xs text-white/70 hover:text-white">
                                                View all
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                {{-- List --}}
                                <div class="max-h-80 overflow-y-auto divide-y divide-white/10">
                                    @forelse($latest as $n)
                                        @php
                                            $isUnread = is_null($n->read_at);
                                            $url = data_get($n->data, 'url')
                                                ?? (data_get($n->data, 'item_id') ? route('items.show', data_get($n->data, 'item_id')) : null)
                                                ?? (data_get($n->data, 'post_id') ? route('items.show', data_get($n->data, 'post_id')) : null)
                                                ?? (data_get($n->data, 'conversation_id') ? route('conversations.show', data_get($n->data, 'conversation_id')) : null);
                                            $message = data_get($n->data, 'message') ?? \Illuminate\Support\Str::limit(json_encode($n->data), 80);
                                        @endphp

                                        <div class="{{ $isUnread ? 'bg-white/5' : 'bg-neutral-900' }}">
                                            <div class="px-3 py-2 flex items-start gap-3 group">
                                                <span class="mt-1.5 h-2.5 w-2.5 rounded-full {{ $isUnread ? 'bg-emerald-500' : 'bg-white/20' }}"></span>

                                                <div class="min-w-0 flex-1">
                                                    @if ($url)
                                                        <a href="{{ $url }}" class="block text-sm truncate hover:underline">
                                                            {{ $message }}
                                                        </a>
                                                    @else
                                                        <div class="text-sm truncate">
                                                            {{ $message }}
                                                        </div>
                                                    @endif

                                                    <div class="text-xs text-white/50">
                                                        {{ optional($n->created_at)->diffForHumans() }}
                                                    </div>
                                                </div>

                                                @if (Route::has('notifications.read') && $isUnread)
                                                    <form method="POST" action="{{ route('notifications.read', $n->id) }}" class="shrink-0">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="px-2 py-1 rounded-full text-[11px] ring-1 ring-white/10 text-white/80 hover:bg-white/10">
                                                            Mark read
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-6 text-center text-sm text-white/60">
                                            No notifications yet.
                                        </div>
                                    @endforelse
                                </div>

                                {{-- Footer --}}
                                @if (Route::has('notifications.clear') && $latest->count())
                                    <div class="px-3 py-2 border-t border-white/10 text-right">
                                        <form method="POST" action="{{ route('notifications.clear') }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-xs text-white/70 hover:text-white">
                                                Clear all
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </x-slot>
                    </x-dropdown>
                @endauth

                {{-- User menu --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 rounded-full ring-1 ring-gray-200 px-3 py-1.5 hover:bg-gray-100 text-gray-800 transition
                                       dark:ring-white/10 dark:hover:bg-white/10 dark:text-white">
                            <div class="w-7 h-7 rounded-full bg-gray-900 text-white grid place-items-center text-xs font-semibold dark:bg-white dark:text-black">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden sm:block text-sm font-medium">{{ Auth::user()->name }}</div>
                            <svg class="h-4 w-4 text-gray-500 dark:text-white/60" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    {{-- FORCE readable colors inside user dropdown too --}}
                    <x-slot name="content">
                        <div class="bg-white dark:bg-neutral-900
                                    text-gray-800 dark:text-white
                                    [&_*]:!text-gray-800 dark:[&_*]:!text-white">
                            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>

                {{-- Mobile menu button --}}
                <button @click="open = !open" class="md:hidden p-2 rounded-lg hover:bg-gray-100 text-gray-700 dark:hover:bg-white/10 dark:text-white" aria-label="Open menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak class="md:hidden border-t border-gray-200 bg-white text-gray-800
                                    dark:border-white/10 dark:bg-neutral-950/95 dark:text-white dark:backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col gap-2">
            <a href="{{ route('items.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-white/10">Items</a>
            <a href="{{ route('items.create') }}" class="px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-white/10">Add</a>
            <a href="{{ route('conversations.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-white/10">Messages</a>

            @auth
                @if (Route::has('notifications.index'))
                    <a href="{{ route('notifications.index') }}" class="px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-white/10">
                        Notifications
                    </a>
                @endif
            @endauth

            <form method="GET" action="{{ route('items.index') }}" class="pt-2">
                <input
                    type="text"
                    name="query"
                    value="{{ request('query') }}"
                    placeholder="Search items..."
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400
                           focus:ring-2 focus:ring-blue-500 focus:outline-none
                           dark:border-white/10 dark:bg-white/5 dark:text-white dark:placeholder-white/40 dark:focus:ring-white/40"
                >
            </form>
        </div>
    </div>
</nav>
