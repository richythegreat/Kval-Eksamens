{{-- resources/views/conversations/index.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-white mb-6">Messages</h1>

        @if ($conversations->isEmpty())
            <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 backdrop-blur-xl p-10 text-center text-white/70">
                You have no conversations yet.
            </div>
        @else
            <div class="space-y-3">
                @foreach ($conversations as $conversation)
                    @php
                        $otherUser = $conversation->users->firstWhere('id', '!=', auth()->id());
                        $lastMessage = $conversation->messages->first();
                    @endphp

                    <a href="{{ route('conversations.show', $conversation) }}"
                       class="block rounded-2xl bg-white/5 ring-1 ring-white/10 backdrop-blur-xl p-4 hover:bg-white/10 transition">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-white text-black grid place-items-center text-sm font-semibold shrink-0">
                                    {{ strtoupper(substr($otherUser?->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-medium text-white truncate">
                                        {{ $otherUser?->name ?? 'Unknown user' }}
                                    </div>
                                    <div class="text-sm text-white/70 truncate">
                                        {{ $lastMessage?->body ?? 'No messages yet' }}
                                    </div>
                                </div>
                            </div>

                            <div class="text-xs text-white/50 whitespace-nowrap">
                                {{ optional($lastMessage?->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>