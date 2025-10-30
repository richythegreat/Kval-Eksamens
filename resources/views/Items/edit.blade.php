<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6 text-center">Edit Post</h1>

        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $item->title) }}" class="w-full border rounded px-3 py-2">
                @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $item->description) }}</textarea>
                @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Category</label>
                    <input type="text" name="category" value="{{ old('category', $item->category) }}" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block font-medium mb-1">City</label>
                    <input type="text" name="city" value="{{ old('city', $item->city) }}" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="lost" {{ $item->status == 'lost' ? 'selected' : '' }}>Lost</option>
                    <option value="found" {{ $item->status == 'found' ? 'selected' : '' }}>Found</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block font-medium mb-1">Replace Image (optional)</label>
                <input type="file" name="image" class="w-full border rounded px-3 py-2">
                @if ($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" class="w-32 h-32 object-cover mt-2 rounded">
                @endif
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
