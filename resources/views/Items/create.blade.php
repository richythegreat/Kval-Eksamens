<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6 text-center">Add New Lost or Found Item</h1>

        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('title')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Description</label>
                <textarea name="description" rows="4"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Category and City --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                {{-- Category --}}
                <div>
                    <label class="block font-medium mb-1">Category</label>
                    <input type="text" name="category" value="{{ old('category') }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('category')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Searchable City Dropdown --}}
                <div x-data="{ open: false, search: '', selected: '{{ old('city') }}', cities: @js($cities) }"
                    class="relative">
                    <label class="block font-medium mb-1">City (Latvia)</label>

                    <!-- Search box -->
                    <input x-model="search" x-on:focus="open = true" x-on:click="open = true"
                        x-on:blur="setTimeout(() => open = false, 100)" type="text"
                        placeholder="Search and select city..." autocomplete="off"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <!-- Dropdown -->
                    <div x-show="open"
                        class="absolute z-10 w-full bg-white border border-gray-300 rounded mt-1 max-h-48 overflow-y-auto shadow-lg">
                        <template x-for="city in cities.filter(c => c.toLowerCase().includes(search.toLowerCase()))"
                            :key="city">
                            <div x-text="city" x-on:click="selected = city; search = city; open = false"
                                class="px-3 py-1 hover:bg-blue-100 cursor-pointer"></div>
                        </template>
                    </div>

                    <!-- Hidden input -->
                    <input type="hidden" name="city" x-model="selected">

                    @error('city')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Status</label>
                <select name="status"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="lost" {{ old('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                    <option value="found" {{ old('status') == 'found' ? 'selected' : '' }}>Found</option>
                </select>
                @error('status')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Image --}}
            <div class="mb-6">
                <label class="block font-medium mb-1">Image (optional)</label>
                <input type="file" name="image"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('image')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="text-center">
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 focus:ring-2 focus:ring-blue-400">
                    Save
                </button>
            </div>
        </form>
    </div>
</x-app-layout>