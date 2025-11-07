<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        if ($search = $request->input('query')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $items = $query->latest()->paginate(10);

        return view('items.index', compact('items'));
    }

    public function create()
    {
        $cities = json_decode(file_get_contents(resource_path('data/latvian_cities.json')), true);

        if (!$cities) {
            $cities = ['Rīga', 'Daugavpils', 'Liepāja', 'Jelgava', 'Jūrmala'];
        }

        return view('items.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'status' => 'required|in:lost,found',
            'city' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $validated['user_id'] = Auth::id();

        Item::create($validated);

        return redirect()->route('items.index')->with('success', 'Post created successfully!');
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $cities = json_decode(file_get_contents(resource_path('data/latvian_cities.json')), true);

        // if (!$cities) {
        //     $cities = ['Rīga', 'Daugavpils', 'Liepāja', 'Jelgava', 'Jūrmala'];
        // }

        return view('items.edit', compact('item', 'cities'));
    }

    public function update(Request $request, Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'status' => 'required|in:lost,found',
            'city' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $item->update($validated);

        return redirect()->route('items.show', $item)->with('success', 'Post updated successfully!');
    }

    public function destroy(Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Post deleted successfully!');
    }
}