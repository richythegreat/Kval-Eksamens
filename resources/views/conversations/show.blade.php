{{-- resources/views/conversations/show.blade.php --}}
<x-app-layout>
    <div
        x-data="chatApp()"
        x-init="scrollToBottom()"
        class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 h-[80vh] flex flex-col"
    >
        @php
            $otherUser = $conversation->users->firstWhere('id', '!=', auth()->id());
        @endphp

        {{-- Header --}}
        <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 backdrop-blur-xl p-4 mb-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-white text-black grid place-items-center text-xs font-semibold">
                        {{ strtoupper(substr($otherUser?->name ?? 'U', 0, 1)) }}
                    </div>
                    <h1 class="text-lg sm:text-xl font-semibold text-white">
                        Chat with {{ $otherUser?->name ?? 'User' }}
                    </h1>
                </div>
                <a href="{{ route('conversations.index') }}"
                   class="px-3 py-1.5 rounded-full text-sm ring-1 ring-white/10 text-white/80 hover:bg-white/10 hover:text-white transition">
                    ← Back
                </a>
            </div>
        </div>

        {{-- Messages --}}
        <div x-ref="messages"
             class="flex-1 overflow-y-auto space-y-3 mb-4 rounded-2xl bg-white/5 ring-1 ring-white/10 backdrop-blur-xl p-4">
            @foreach ($conversation->messages as $message)
                @php $mine = $message->user_id === auth()->id(); @endphp
                <div class="flex {{ $mine ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[75%] px-4 py-2 rounded-2xl text-sm
                                {{ $mine ? 'bg-white text-black' : 'bg-white/10 text-white' }}">
                        <div class="whitespace-pre-wrap break-words">{{ $message->body }}</div>
                        <div class="text-[10px] opacity-70 mt-1 {{ $mine ? 'text-black/70' : 'text-white/70' }} text-right">
                            {{ $message->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Composer --}}
        <form @submit.prevent="sendMessage"
              class="rounded-2xl bg-white/5 ring-1 ring-white/10 backdrop-blur-xl p-3 flex items-center gap-2">
            <input
                x-model="newMessage"
                type="text"
                placeholder="Type a message…"
                class="flex-1 rounded-full bg-white/5 text-white placeholder-white/40 ring-1 ring-white/10
                       focus:ring-2 focus:ring-white/40 focus:outline-none px-4 py-2 text-sm"
                required
            >
            <button type="submit"
                    class="px-4 py-2 rounded-full text-sm font-medium bg-white text-black hover:bg-white/90 transition ring-1 ring-white/10">
                Send
            </button>
        </form>
    </div>

    {{-- Alpine Chat Logic --}}
    <script>
        function chatApp() {
            return {
                newMessage: '',
                async sendMessage() {
                    const body = (this.newMessage || '').trim();
                    if (!body) return;

                    try {
                        const response = await fetch("{{ route('conversations.messages.store', $conversation) }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: JSON.stringify({ body }),
                        });

                        if (!response.ok) throw new Error('Failed to send');

                        const data = await response.json();

                        this.$refs.messages.insertAdjacentHTML('beforeend', `
                            <div class="flex justify-end">
                                <div class="max-w-[75%] px-4 py-2 rounded-2xl text-sm bg-white text-black">
                                    <div class="whitespace-pre-wrap break-words">${escapeHtml(data.body)}</div>
                                    <div class="text-[10px] text-black/70 opacity-70 mt-1 text-right">${data.time}</div>
                                </div>
                            </div>
                        `);

                        this.newMessage = '';
                        this.scrollToBottom();
                    } catch (e) {
                        alert('Could not send message.');
                    }
                },
                scrollToBottom() {
                    this.$nextTick(() => {
                        const el = this.$refs.messages;
                        el.scrollTop = el.scrollHeight;
                    });
                }
            }
        }

        function escapeHtml(str) {
            return String(str)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }
    </script>
</x-app-layout>