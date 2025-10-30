<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6 text-center">Lost & Found Posts</h1>

        {{-- Flash message --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="text-right mb-4">
            <a href="{{ route('items.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
               + Add New Post
            </a>
        </div>

        @if ($items->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($items as $item)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-48 object-cover" alt="Image">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                No Image
                            </div>
                        @endif

                        <div class="p-4">
                            <h2 class="text-xl font-semibold mb-1">{{ $item->title }}</h2>
                            <p class="text-gray-600 text-sm mb-2">
                                {{ ucfirst($item->status) }} — {{ $item->city ?? 'Unknown city' }}
                            </p>
                            <p class="text-gray-700 mb-4">{{ Str::limit($item->description, 100) }}</p>

                            <div class="flex justify-between text-sm">
                                <a href="{{ route('items.show', $item->id) }}" class="text-blue-600 hover:underline">View</a>
                                @if ($item->user_id === auth()->id())
                                    <a href="{{ route('items.edit', $item->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this post?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $items->links() }}
            </div>
        @else
            <p class="text-gray-500 text-center">No posts yet.</p>
        @endif
    </div>
</x-app-layout>
