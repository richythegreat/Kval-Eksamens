<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index()
    {
        $items = Item::latest()->paginate(10);
        return view('items.index', compact('items'));
    }


    public function create()
    {
        return view('items.create');
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
        // Ensure only the owner can edit
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('items.edit', compact('item'));
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
    public function search() {}
    public function filter() {}
}
