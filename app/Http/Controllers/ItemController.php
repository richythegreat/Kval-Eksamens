<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Services\LocationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ItemMatchFound;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function index(Request $request): View
    {
        $items = Item::query()
            ->when(method_exists(Item::class, 'scopeSearch'),
                fn ($q) => $q->search($request->string('query')),
                fn ($q) => $this->applyFallbackSearch($q, $request->string('query'))
            )
            ->latest()
            ->paginate(10);

        return view('items.index', compact('items'));
    }

    public function create(): View
    {
        $cities = LocationService::all();
        return view('items.create', compact('cities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $locations = LocationService::all();
        $data = $this->validateItem($request, $locations);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        $item = Item::create($data);

        return redirect()
            ->route('items.index')
            ->with('success', 'Post created successfully!');
    }

    public function show(Item $item): View
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item): View
    {
        abort_unless($item->user_id === Auth::id(), 403);
        $cities = LocationService::all();

        return view('items.edit', compact('item', 'cities'));
    }

    public function update(Request $request, Item $item): RedirectResponse
    {
        abort_unless($item->user_id === Auth::id(), 403);

        $locations = LocationService::all();
        $data = $this->validateItem($request, $locations);

        if ($request->hasFile('image')) {
            $new = $request->file('image')->store('items', 'public');
            $old = $item->image;
            $data['image'] = $new;

            $item->update($data);

            if ($old) {
                try { Storage::disk('public')->delete($old); } catch (\Throwable) {}
            }
        } else {
            $item->update($data);
        }

        return redirect()
            ->route('items.show', $item)
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Item $item): RedirectResponse
    {
        abort_unless($item->user_id === Auth::id(), 403);

        $old = $item->image;
        $item->delete();

        if ($old) {
            try { Storage::disk('public')->delete($old); } catch (\Throwable) {}
        }

        return redirect()
            ->route('items.index')
            ->with('success', 'Post deleted successfully!');
    }

    private function validateItem(Request $request, array $validLocations): array
    {
        return $request->validate([
            'title'       => ['required','string','max:255'],
            'description' => ['required','string'],
            'category'    => ['required','string','max:100'],
            'status'      => ['required', Rule::in(['lost','found'])],
            'city'        => ['required', Rule::in($validLocations)],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
        ]);
    }

    private function applyFallbackSearch($query, ?string $term)
    {
        $term = trim((string) $term);
        if ($term === '') return $query;

        $like = '%' . str_replace(['%','_'], ['\%','\_'], $term) . '%';

        return $query->where(function ($q) use ($like) {
            $q->where('title', 'like', $like)
              ->orWhere('description', 'like', $like)
              ->orWhere('city', 'like', $like);
        });
    }
}
