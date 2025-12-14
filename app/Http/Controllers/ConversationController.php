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
    // List all conversations for the logged-in user
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

    // Start (or reuse) a conversation between auth user and the item owner
    public function start(Item $item)
    {
        $user = Auth::user();

        // Prevent messaging yourself
        if ($item->user_id === $user->id) {
            return redirect()
                ->back()
                ->with('error', 'You cannot message yourself.');
        }

        $otherUserId = $item->user_id;

        // Find existing conversation that has BOTH users
        $existing = Conversation::whereHas('users', fn ($q) => $q->where('users.id', $user->id))
            ->whereHas('users', fn ($q) => $q->where('users.id', $otherUserId))
            ->first();

        if ($existing) {
            return redirect()->route('conversations.show', $existing);
        }

        // Create new conversation and attach both users
        $conversation = Conversation::create();
        $conversation->users()->attach([$user->id, $otherUserId]);

        // Optional: first message referencing item
        // Message::create([
        //     'conversation_id' => $conversation->id,
        //     'user_id' => $user->id,
        //     'body' => "Hi! I'm contacting you about: {$item->title}",
        // ]);

        return redirect()->route('conversations.show', $conversation);
    }

    // Show a single conversation (only if user is a participant)
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

        // Mark other user's messages as read (simple approach)
        Message::where('conversation_id', $conversation->id)
            ->whereNull('read_at')
            ->where('user_id', '!=', $userId)
            ->update(['read_at' => now()]);

        return view('conversations.show', compact('conversation'));
    }

    // Send a new message
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

    // Notify the other user (not sender)
    $otherUser = $conversation->users()->where('users.id', '!=', $userId)->first();
    if ($otherUser) {
        $preview = mb_substr($message->body, 0, 60);
        $otherUser->notify(new NewMessageNotification(
            conversationId: $conversation->id,
            senderName: Auth::user()->name,
            preview: $preview
        ));
    }

    // If you're using AJAX, return JSON:
    return response()->json([
        'id' => $message->id,
        'body' => $message->body,
        'user_id' => $message->user_id,
        'time' => $message->created_at->format('H:i'),
    ]);
}

}


