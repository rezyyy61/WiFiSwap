<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRecordingVoiceEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $senderId;
    public $receiverId;
    public $isRecording;
    public function __construct($senderId, $receiverId, $isRecording)
    {
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->isRecording = $isRecording;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('recording.' . $this->receiverId),
        ];
    }

    public function broadcastWith()
    {
        return [
            'senderId' => $this->senderId,
            'isRecording' => $this->isRecording,
        ];
    }
}
