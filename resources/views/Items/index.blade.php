{{-- resources/views/Items/index.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        {{-- Toolbar --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-white">
                Lost &amp; Found Posts
            </h1>

            <a href="{{ route('items.create') }}"
               class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-medium
                      bg-white text-black hover:bg-white/90 transition ring-1 ring-white/10">
                + Add New Post
            </a>
        </div>

        @if ($items->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($items as $item)
                    <div class="group rounded-2xl overflow-hidden bg-white/5 ring-1 ring-white/10 backdrop-blur-xl
                                transition transform hover:-translate-y-1 hover:shadow-2xl hover:shadow-black/30">
                        {{-- Media --}}
                        @if ($item->image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $item->image) }}"
                                     alt="Image"
                                     class="w-full h-48 object-cover">
                                <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-70"></div>
                            </div>
                        @else
                            <div class="w-full h-48 bg-white/5 ring-1 ring-inset ring-white/10 grid place-items-center text-white/50 text-sm">
                                No Image
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-white mb-2 line-clamp-1">{{ $item->title }}</h2>

                            {{-- Meta --}}
                            <div class="flex items-center gap-2 text-xs mb-3">
                                <span class="px-2 py-1 rounded-full ring-1 ring-white/10 bg-white/5 text-white/80">
                                    {{ ucfirst($item->status) }}
                                </span>
                                <span class="px-2 py-1 rounded-full ring-1 ring-white/10 text-white/60">
                                    {{ $item->city ?? 'Unknown city' }}
                                </span>
                            </div>

                            <p class="text-sm text-white/70 mb-4">
                                {{ Str::limit($item->description, 120) }}
                            </p>

                            {{-- Actions --}}
                            <div class="flex items-center justify-between text-sm">
                                <a href="{{ route('items.show', $item->id) }}"
                                   class="px-3 py-1.5 rounded-full bg-white text-black ring-1 ring-white/10 hover:bg-white/90 transition">
                                    View
                                </a>

                                @if ($item->user_id === auth()->id())
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('items.edit', $item->id) }}"
                                           class="px-3 py-1.5 rounded-full ring-1 ring-white/10 text-amber-300/90 hover:bg-white/10 transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Delete this post?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1.5 rounded-full ring-1 ring-white/10 text-rose-300/90 hover:bg-white/10 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8 flex justify-center">
                {{ $items->links() }}
            </div>
        @else
            <p class="text-white/60 text-center">No posts yet.</p>
        @endif
    </div>
</x-app-layout>
