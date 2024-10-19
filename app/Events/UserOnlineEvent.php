<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserOnlineEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $onlineUsers;

    public function __construct($onlineUsers)
    {
        $this->onlineUsers = $onlineUsers;
    }

    public function broadcastOn()
    {
        return new Channel('online-users'); // This should match your listener
    }

    public function broadcastWith()
    {
        return ['onlineUsers' => $this->onlineUsers]; // Ensure to send it with a key
    }
}
