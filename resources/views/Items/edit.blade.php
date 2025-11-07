<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6 text-center">Edit Item</h1>

        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $item->title) }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Description</label>
                <textarea name="description"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    rows="4">{{ old('description', $item->description) }}</textarea>
                @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Category & City --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Category</label>
                    <input type="text" name="category" value="{{ old('category', $item->category) }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('category') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div x-data="{ open: false, search: '', selected: '{{ old('city', $item->city ?? '') }}', filteredCities: @js($cities) }"
                    class="relative">
                    <label class="block font-medium mb-1">City (Latvia)</label>

                    <!-- Searchable input -->
                    <input x-model="search" x-on:focus="open = true" x-on:click="open = true"
                        x-on:blur="setTimeout(() => open = false, 100)" type="text"
                        placeholder="Search and select city..." autocomplete="off"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <!-- Dropdown list -->
                    <div x-show="open"
                        class="absolute z-10 w-full bg-white border border-gray-300 rounded mt-1 max-h-48 overflow-y-auto shadow-lg">
                        <template
                            x-for="city in filteredCities.filter(c => c.toLowerCase().includes(search.toLowerCase()))"
                            :key="city">
                            <div x-text="city" x-on:click="selected = city; search = city; open = false"
                                class="px-3 py-1 hover:bg-blue-100 cursor-pointer"></div>
                        </template>
                    </div>

                    <!-- Hidden input to submit selected value -->
                    <input type="hidden" name="city" x-model="selected">

                    @error('city') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Status</label>
                <select name="status"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="lost" {{ old('status', $item->status) == 'lost' ? 'selected' : '' }}>Lost</option>
                    <option value="found" {{ old('status', $item->status) == 'found' ? 'selected' : '' }}>Found</option>
                </select>
                @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Image Upload --}}
            <div class="mb-6">
                <label class="block font-medium mb-1">Image (optional)</label>
                <input type="file" name="image"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('image') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                @if ($item->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="Current image" class="w-48 rounded">
                </div>
                @endif
            </div>

            {{-- Submit --}}
            <div class="text-center">
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 focus:ring-2 focus:ring-blue-400">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-app-layout>