<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $conversationId,
        public string $senderName,
        public string $preview
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type'            => 'message',
            'message'         => "New message from {$this->senderName}",
            'conversation_id' => $this->conversationId,
            'preview'         => $this->preview,
            'url'             => route('conversations.show', $this->conversationId),
    }
}
