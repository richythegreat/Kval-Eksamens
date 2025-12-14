{{-- resources/views/Items/show.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-6 flex items-center justify-between gap-4">
            <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-white">{{ $item->title }}</h1>
            <a href="{{ route('items.index') }}"
               class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-sm ring-1 ring-white/10 text-white/80 hover:bg-white/10 hover:text-white transition">
                ← Back
            </a>
        </div>

        <div class="grid gap-8 lg:grid-cols-12">
            {{-- Media --}}
            <div class="lg:col-span-7">
                @if ($item->image)
                    <div class="overflow-hidden rounded-2xl ring-1 ring-white/10 bg-white/5 backdrop-blur">
                        <img
                            src="{{ asset('storage/' . $item->image) }}"
                            alt="Image for {{ $item->title }}"
                            class="w-full h-[22rem] md:h-[26rem] object-cover"
                        >
                    </div>
                @else
                    <div class="h-[22rem] md:h-[26rem] rounded-2xl bg-white/5 ring-1 ring-white/10 grid place-items-center text-white/50">
                        No Image
                    </div>
                @endif>
            </div>

            {{-- Details card --}}
            <div class="lg:col-span-5">
                <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 backdrop-blur-xl p-6 space-y-5">
                    {{-- Meta badges --}}
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-2.5 py-1 rounded-full text-xs ring-1 ring-white/10 bg-white text-black">
                            {{ ucfirst($item->status) }}
                        </span>
                        <span class="px-2.5 py-1 rounded-full text-xs ring-1 ring-white/10 text-white/80">
                            {{ $item->category }}
                        </span>
                        <span class="px-2.5 py-1 rounded-full text-xs ring-1 ring-white/10 text-white/60">
                            {{ $item->city ?? 'Unknown' }}
                        </span>
                    </div>

                    {{-- Description --}}
                    <div class="prose prose-invert prose-sm max-w-none">
                        <p class="text-white/80 whitespace-pre-line">{{ $item->description }}</p>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-2 flex flex-wrap items-center justify-between gap-3">
                        <a href="{{ route('items.index') }}"
                           class="px-3 py-1.5 rounded-full text-sm ring-1 ring-white/10 text-white/80 hover:bg-white/10 hover:text-white transition">
                            ← Back to posts
                        </a>

                        <div class="flex items-center gap-3">
                            @if ($item->user_id !== auth()->id())
                                <form method="POST" action="{{ route('conversations.start', $item) }}">
                                    @csrf
                                    <button
                                        class="px-4 py-2 rounded-full text-sm font-medium bg-white text-black hover:bg-white/90 transition ring-1 ring-white/10">
                                        Message owner
                                    </button>
                                </form>
                            @endif

                            @if ($item->user_id === auth()->id())
                                <a href="{{ route('items.edit', $item->id) }}"
                                   class="px-3 py-1.5 rounded-full text-sm ring-1 ring-white/10 text-amber-300/90 hover:bg-white/10 transition">
                                    Edit
                                </a>

                                <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Delete this post?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 rounded-full text-sm ring-1 ring-white/10 text-rose-300/90 hover:bg-white/10 transition">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</x-app-layout>
