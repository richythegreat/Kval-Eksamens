<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Messages</h1>

        @if ($conversations->isEmpty())
            <div class="text-gray-500 text-center py-10">
                You have no conversations yet.
            </div>
        @else
            <div class="space-y-3">
                @foreach ($conversations as $conversation)
                    @php
                        $otherUser = $conversation->users->firstWhere('id', '!=', auth()->id());
                        $lastMessage = $conversation->messages->first();
                    @endphp

                    <a
                        href="{{ route('conversations.show', $conversation) }}"
                        class="block border rounded-lg p-4 hover:bg-gray-50 transition"
                    >
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="font-semibold">
                                    {{ $otherUser?->name ?? 'Unknown user' }}
                                </div>

                                <div class="text-sm text-gray-600">
                                    {{ $lastMessage?->body ?? 'No messages yet' }}
                                </div>
                            </div>

                            <div class="text-xs text-gray-400">
                                {{ optional($lastMessage?->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
