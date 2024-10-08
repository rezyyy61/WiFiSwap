<?php
namespace App\Livewire;

use App\Events\ChatRoomSameIpEvent;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Reverb\Loggers\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatRoomSameIpComponent extends Component
{
    public string $message = '';
    public $messages = [];
    public int $chatRoomId;

    public function mount()
    {
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $userId = Auth::id();

        $userIp = Message::where('sender_id', $userId)->value('ip');

        // Fetch all messages sent by users with the same IP (excluding current user and current user’s messages)
        $messages = Message::where('ip', $userIp)
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', '!=', $userId)
                    ->orWhere('sender_id', $userId);
            })
            ->select('message', 'created_at', 'sender_id')
            ->orderBy('created_at', 'asc')
            ->get();

        $this->messages = $messages;
    }

    public function sendMessage()
    {
        $chatRoomSameIp = new Message();
        $chatRoomSameIp->sender_id = Auth::id();
        $chatRoomSameIp->message = $this->message;
        $chatRoomSameIp->ip = request()->ip();
        $chatRoomSameIp->useragent = request()->header('User-Agent');

        $chatRoomSameIp->save();

        broadcast(new ChatRoomSameIpEvent($chatRoomSameIp))->toOthers();

        // Clear the input field
        $this->message = '';

        $this->loadMessages();
    }

    #[On('echo-private:chatRoomSameIp.{senderId}, ChatRoomSameIpEvent')]
    public function handleChatEvent($event): void
    {
        \Illuminate\Support\Facades\Log::info('Event received: ', $event);

        $this->messages[] = [
            'message' => $event['message'],
            'created_at' => $event['created_at'],
            'sender_id' => $event['sender_id'],
        ];
    }

    public function render()
    {
        return view('livewire.chat-room-same-ip-component', ['messages' => $this->messages]);
    }
}
