<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ItemMatchFound extends Notification
{
    use Queueable;

    public $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Possible match found for your item!',
            'item_id' => $this->item->id,
            'title'   => $this->item->title,
        ];
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

}
