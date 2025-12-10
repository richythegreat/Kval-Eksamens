<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ItemMatchFound;


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

    $item = Item::create($validated);


    if ($item->city && $item->category) {

        $oppositeStatus = $item->status === 'lost' ? 'found' : 'lost';

        $others = Item::where('status', $oppositeStatus)
            ->where('city', $item->city)
            ->where('category', $item->category)
            ->where('id', '!=', $item->id)
            ->get();

        foreach ($others as $other) {
            $text1 = $item->title . ' ' . $item->description;
            $text2 = $other->title . ' ' . $other->description;

            $score = $this->simpleTextSimilarity($text1, $text2);

            
            if ($score >= 0.35) {
                $other->user->notify(new ItemMatchFound($item));
            }
        }
    }

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
    private function simpleTextSimilarity(string $a, string $b): float
{
    $a = mb_strtolower($a);
    $b = mb_strtolower($b);

    $a = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $a);
    $b = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $b);

    $wordsA = preg_split('/\s+/', $a, -1, PREG_SPLIT_NO_EMPTY);
    $wordsB = preg_split('/\s+/', $b, -1, PREG_SPLIT_NO_EMPTY);

    $stop = ['un', 'vai', 'and', 'the', 'a', 'an', 'ir', 'kas', 'ar'];
    $filter = function ($w) use ($stop) {
        return mb_strlen($w) > 2 && !in_array($w, $stop);
    };

    $wordsA = array_values(array_filter($wordsA, $filter));
    $wordsB = array_values(array_filter($wordsB, $filter));

    if (empty($wordsA) || empty($wordsB)) {
        return 0;
    }

    $uniqueA = array_unique($wordsA);
    $uniqueB = array_unique($wordsB);

    $common = array_intersect($uniqueA, $uniqueB);

    $score = count($common) / max(count($uniqueA), count($uniqueB));

    return $score; 
}

}