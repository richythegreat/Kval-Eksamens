<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold mb-4">{{ $item->title }}</h1>

        @if ($item->image)
            <img src="{{ asset('storage/' . $item->image) }}" class="w-full rounded mb-4">
        @endif

        <p><strong>Status:</strong> {{ ucfirst($item->status) }}</p>
        <p><strong>Category:</strong> {{ $item->category }}</p>
        <p><strong>City:</strong> {{ $item->city ?? 'Unknown' }}</p>

        <div class="mt-4">
            <p class="text-gray-700">{{ $item->description }}</p>
        </div>

        



        <div class="mt-6 flex justify-between">
            <a href="{{ route('items.index') }}" class="text-blue-600 hover:underline">← Back</a>

            @if ($item->user_id === auth()->id())
                <a href="{{ route('items.edit', $item->id) }}" class="text-yellow-600 hover:underline">Edit</a>

                <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                      onsubmit="return confirm('Delete this post?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
