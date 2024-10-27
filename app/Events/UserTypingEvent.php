<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTypingEvent implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $senderId;
    public $receiverId;
    public $isTyping;

    public function __construct($senderId, $receiverId, $isTyping)
    {
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->isTyping = $isTyping;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('typing.' . $this->receiverId);
    }

    public function broadcastWith()
    {
        return [
            'senderId' => $this->senderId,
            'isTyping' => $this->isTyping,
        ];
    }
}
