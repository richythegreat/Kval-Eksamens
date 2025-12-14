{{-- resources/views/Items/edit.blade.php --}}
<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight text-white">Edit Item</h1>
        </div>

        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data"
              class="rounded-2xl bg-white/5 ring-1 ring-white/10 backdrop-blur-xl p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium text-white/80 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $item->title) }}"
                       class="w-full rounded-xl bg-white/5 text-white placeholder-white/40 ring-1 ring-white/10
                              focus:ring-2 focus:ring-white/40 focus:outline-none px-3 py-2">
                @error('title') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-white/80 mb-1">Description</label>
                <textarea name="description" rows="4"
                          class="w-full rounded-xl bg-white/5 text-white placeholder-white/40 ring-1 ring-white/10
                                 focus:ring-2 focus:ring-white/40 focus:outline-none px-3 py-2">{{ old('description', $item->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
            </div>

            {{-- Category & City --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-white/80 mb-1">Category</label>
                    <input type="text" name="category" value="{{ old('category', $item->category) }}"
                           class="w-full rounded-xl bg-white/5 text-white placeholder-white/40 ring-1 ring-white/10
                                  focus:ring-2 focus:ring-white/40 focus:outline-none px-3 py-2">
                    @error('category') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>

                {{-- Searchable City --}}
                <div
                    x-data="{
                        open: false,
                        search: @js(old('city', $item->city ?? '')),
                        selected: @js(old('city', $item->city ?? '')),
                        cities: @js($cities)
                    }"
                    class="relative"
                >
                    <label class="block text-sm font-medium text-white/80 mb-1">City (Latvia)</label>

                    <input x-model="search" @focus="open = true" @input="open = true"
                           @blur="setTimeout(() => open = false, 120)" type="text"
                           placeholder="Search and select city..." autocomplete="off"
                           class="w-full rounded-xl bg-white/5 text-white placeholder-white/40 ring-1 ring-white/10
                                  focus:ring-2 focus:ring-white/40 focus:outline-none px-3 py-2">

                    <div x-show="open"
                         class="absolute z-10 w-full mt-1 max-h-48 overflow-y-auto rounded-xl bg-neutral-950 ring-1 ring-white/10 shadow-2xl">
                        <template x-for="city in cities.filter(c => c.toLowerCase().includes((search||'').toLowerCase()))" :key="city">
                            <div x-text="city"
                                 @mousedown.prevent="selected = city; search = city; open = false"
                                 class="px-3 py-2 text-sm text-white/90 hover:bg-white/10 cursor-pointer"></div>
                        </template>
                        <div class="px-3 py-2 text-xs text-white/50" x-show="cities.filter(c => c.toLowerCase().includes((search||'').toLowerCase())).length === 0">
                            No matches
                        </div>
                    </div>

                    <input type="hidden" name="city" x-model="selected">
                    @error('city') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-white/80 mb-1">Status</label>
                <select name="status"
                        class="w-full rounded-xl bg-white/5 text-white ring-1 ring-white/10
                               focus:ring-2 focus:ring-white/40 focus:outline-none px-3 py-2">
                    <option value="lost"  {{ old('status', $item->status) == 'lost'  ? 'selected' : '' }}>Lost</option>
                    <option value="found" {{ old('status', $item->status) == 'found' ? 'selected' : '' }}>Found</option>
                </select>
                @error('status') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
            </div>

            {{-- Image Upload --}}
            <div>
                <label class="block text-sm font-medium text-white/80 mb-1">Image (optional)</label>
                <input type="file" name="image"
                       class="w-full rounded-xl bg-white/5 text-white file:bg-white file:text-black file:border-0 file:rounded-lg
                              ring-1 ring-white/10 focus:ring-2 focus:ring-white/40 focus:outline-none px-3 py-2">
                @error('image') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror

                @if ($item->image)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="Current image"
                             class="w-48 rounded-xl ring-1 ring-white/10">
                    </div>
                @endif
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-center gap-3">
                <a href="{{ route('items.show', $item->id) }}"
                   class="px-4 py-2 rounded-full text-sm ring-1 ring-white/10 text-white/80 hover:bg-white/10 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="px-5 py-2 rounded-full text-sm font-medium bg-white text-black hover:bg-white/90 transition ring-1 ring-white/10">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
