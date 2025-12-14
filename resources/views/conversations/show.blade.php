<x-app-layout>
    <div
        x-data="chatApp()"
        x-init="scrollToBottom()"
        class="max-w-4xl mx-auto py-8 px-4 flex flex-col h-[80vh]"
    >
        {{-- Header --}}
        @php
            $otherUser = $conversation->users->firstWhere('id', '!=', auth()->id());
        @endphp

        <div class="border-b pb-3 mb-4">
            <h1 class="text-xl font-bold">
                Chat with {{ $otherUser?->name ?? 'User' }}
            </h1>
        </div>

        {{-- Messages --}}
        <div x-ref="messages" class="flex-1 overflow-y-auto space-y-3 mb-4">
            @foreach ($conversation->messages as $message)
                <div class="flex {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div
                        class="max-w-xs px-4 py-2 rounded-lg text-sm
                        {{ $message->user_id === auth()->id()
                            ? 'bg-blue-600 text-white'
                            : 'bg-gray-200 text-gray-800' }}"
                    >
                        {{ $message->body }}
                        <div class="text-[10px] opacity-70 mt-1 text-right">
                            {{ $message->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Input --}}
        <form @submit.prevent="sendMessage" class="flex gap-2 border-t pt-4">
            <input
                x-model="newMessage"
                type="text"
                placeholder="Type a message..."
                class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >

            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
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
                    if (!this.newMessage.trim()) return;

                    const response = await fetch(
                        "{{ route('conversations.messages.store', $conversation) }}",
                        {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({ body: this.newMessage }),
                        }
                    );

                    const data = await response.json();

                    // Append message to chat
                    this.$refs.messages.insertAdjacentHTML('beforeend', `
                        <div class="flex justify-end">
                            <div class="max-w-xs px-4 py-2 rounded-lg text-sm bg-blue-600 text-white">
                                ${data.body}
                                <div class="text-[10px] opacity-70 mt-1 text-right">
                                    ${data.time}
                                </div>
                            </div>
                        </div>
                    `);

                    this.newMessage = '';
                    this.scrollToBottom();
                },
                scrollToBottom() {
                    this.$nextTick(() => {
                        this.$refs.messages.scrollTop = this.$refs.messages.scrollHeight;
                    });
                }
            }
        }
    </script>
</x-app-layout>
   
