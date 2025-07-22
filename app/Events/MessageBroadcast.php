<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class MessageBroadcast implements ShouldBroadcast
{
    use Dispatchable;
    use SerializesModels;
    /**
     * Экземпляр сообщения.
     *
     * @var \App\Models\Message
     */
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('channels.'.$this->message->channel_id);
    }

    public function broadcastAs(): string
    {
        return 'MessageBroadcast';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'content' => $this->message->content,
            'created_at' => $this->message->created_at,
            'author' => $this->message->user->name // Добавляем имя пользователя
        ];
    }
}