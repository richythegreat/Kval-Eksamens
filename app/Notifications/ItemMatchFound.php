<?php

namespace App\Notifications;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ItemMatchFound extends Notification
{
    use Queueable;

    public function __construct(public Item $item) {}


    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type'    => 'item_match',
            'message' => 'Possible match found for your item!',
            'item_id' => $this->item->id,
            'title'   => $this->item->title,
            'url'     => route('items.show', $this->item),
        ];
    }
}
