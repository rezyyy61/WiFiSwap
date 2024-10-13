<?php

namespace App\Livewire;

use App\Events\ChatRoomSameIpEvent;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ChatRoomSameIpComponent extends Component
{
    public string $message = '';
    public array $messages = [];
    public int $chatRoomId;

    protected $listeners = ['listenForMessage'];

    public function mount()
    {
        $userIp = Auth::user()->ip;

        // Fetch the latest chat room for the user's IP
        $chatRoom = ChatRoom::where('ip', $userIp)->latest()->first();

        if ($chatRoom) {
            $this->chatRoomId = $chatRoom->id;
            $this->loadMessages();
        } else {
            $this->chatRoomId = 0;
            $this->messages = [];
        }
    }

    public function loadMessages()
    {
        // Fetch messages for the user's IP
        $messages = Message::where('ip', Auth::user()->ip)
            ->select('id', 'message', 'created_at', 'sender_id')
            ->orderBy('created_at', 'asc')
            ->get();

        // Populate the user_name for each message
        foreach ($messages as $message) {
            $user = User::find($message->sender_id);
            $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $imageBackgroundColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $this->messages[] = [
                'id' => $message->id,
                'message' => $message->message,
                'created_at' => $message->created_at,
                'sender_id' => $message->sender_id,
                'user_name' => $user ? $user->name : 'Unknown User',
                'user_color' => $randomColor,
                'image_background_color' => $imageBackgroundColor,
            ];
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string',
        ]);

        try {
            $chatRoomSameIp = new Message();
            $chatRoomSameIp->sender_id = Auth::id();
            $chatRoomSameIp->message = $this->message;
            $chatRoomSameIp->ip = request()->ip();
            $chatRoomSameIp->useragent = request()->header('User-Agent');
            $chatRoomSameIp->save();

            $this->appendChatMessage($chatRoomSameIp);
            broadcast(new ChatRoomSameIpEvent($chatRoomSameIp, $this->chatRoomId))->toOthers();
            $this->message = '';
            $this->dispatch('scrollDown');
        } catch (\Exception $e) {
            Log::error('There was an error sending your message: '.$e);
        }
    }

    public function getListeners()
    {
        return [
            "echo-private:chatRoomSameIp.{$this->chatRoomId},ChatRoomSameIpEvent" => 'listenForMessage',
        ];
    }

    public function listenForMessage($event): void
    {
        $newMessage = $event['message'];
        $message = Message::find($newMessage['id']);

        if ($message) {
            $this->appendChatMessage($message);
            $this->dispatch('scrollDown');
        }
    }

    public function appendChatMessage($message)
    {
        $user = User::find($message->sender_id);


        $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        $imageBackgroundColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));

        $this->messages[] = [
            'id' => $message->id,
            'message' => $message->message,
            'created_at' => $message->created_at,
            'sender_id' => $message->sender_id,
            'user_name' => $user ? $user->name : 'Unknown User',
            'user_color' => $randomColor,  // Color for user name
            'image_background_color' => $imageBackgroundColor, // Random color for image background
        ];
    }



    public function render()
    {
        return view('livewire.chat-room-same-ip-component', [
            'messages' => $this->messages,
        ]);
    }
}
