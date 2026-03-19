<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Item;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewMessageNotification;


class ConversationController extends Controller
{
    public function index()
    {
        $conversations = Auth::user()
            ->conversations()
            ->with(['users', 'messages' => function ($q) {
                $q->latest();
            }])
            ->get()
            ->sortByDesc(function ($c) {
                return optional($c->messages->first())->created_at;
            });

        return view('conversations.index', compact('conversations'));
    }

    public function start(Item $item)
    {
        $user = Auth::user();

        if ($item->user_id === $user->id) {
            return redirect()
                ->back()
                ->with('error', 'You cannot message yourself.');
        }

        $otherUserId = $item->user_id;

        $existing = Conversation::whereHas('users', fn ($q) => $q->where('users.id', $user->id))
            ->whereHas('users', fn ($q) => $q->where('users.id', $otherUserId))
            ->first();

        if ($existing) {
            return redirect()->route('conversations.show', $existing);
        }

        $conversation = Conversation::create();
        $conversation->users()->attach([$user->id, $otherUserId]);

        

        return redirect()->route('conversations.show', $conversation);
    }

    public function show(Conversation $conversation)
    {
        $userId = Auth::id();

        if (!$conversation->users()->where('users.id', $userId)->exists()) {
            abort(403);
        }

        $conversation->load([
            'users',
            'messages.user'
        ]);

        Message::where('conversation_id', $conversation->id)
            ->whereNull('read_at')
            ->where('user_id', '!=', $userId)
            ->update(['read_at' => now()]);

        return view('conversations.show', compact('conversation'));
    }

    public function storeMessage(Request $request, Conversation $conversation)
{
    $userId = Auth::id();

    if (!$conversation->users()->where('users.id', $userId)->exists()) {
        abort(403);
    }

    $validated = $request->validate([
        'body' => 'required|string|max:2000',
    ]);

    $message = Message::create([
        'conversation_id' => $conversation->id,
        'user_id' => $userId,
        'body' => $validated['body'],
    ]);

    $otherUser = $conversation->users()->where('users.id', '!=', $userId)->first();
    if ($otherUser) {
        $preview = mb_substr($message->body, 0, 60);
        $otherUser->notify(new NewMessageNotification(
            conversationId: $conversation->id,
            senderName: Auth::user()->name,
            preview: $preview
        ));
    }

    return response()->json([
        'id' => $message->id,
        'body' => $message->body,
        'user_id' => $message->user_id,
        'time' => $message->created_at->format('H:i'),
    ]);
}

}


