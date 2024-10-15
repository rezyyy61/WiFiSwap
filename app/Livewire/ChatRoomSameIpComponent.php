<?php

namespace App\Livewire;

use App\Events\ChatRoomSameIpEvent;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ChatRoomSameIpComponent extends Component
{
    public string $message = '';
    public array $messages = [];
    public array $chatRooms = [];
    public int $chatRoomId;

    protected $listeners = ['listenForMessage'];

    public function mount()
    {
        $this->chatRoomId = 0; // Initialize chatRoomId
        $this->createChatRoom();
        $this->loadChatRooms(); // Load chat rooms on mount
        $this->setDefaultChatRoom(); // Load today's chat by default
    }

    public function createChatRoom(): void
    {
        $existingChatRoom = ChatRoom::where('ip', request()->ip())
            ->whereDate('created_at', Carbon::today())
            ->first();

        if (!$existingChatRoom) {
            $chatroom = new ChatRoom;
            $chatroom->ip = request()->ip();
            $chatroom->name = request()->ip();
            $chatroom->logo = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $chatroom->save();
        }
    }

    public function setDefaultChatRoom()
    {
        // Set the chat room to today's room by default
        $todayChatRoom = ChatRoom::whereDate('created_at', Carbon::today())->first();
        if ($todayChatRoom) {
            $this->chatRoomId = $todayChatRoom->id;
            $this->loadMessages();
        }
    }

    public function loadMessages()
    {
        // Fetch messages based on the selected chat room
        $messages = Message::where('chat_room_id', $this->chatRoomId)
            ->select('id', 'message', 'created_at', 'sender_id')
            ->orderBy('created_at', 'asc')
            ->get();

        $this->messages = []; // Reset messages

        foreach ($messages as $message) {
            $user = User::find($message->sender_id);
            $this->messages[] = [
                'id' => $message->id,
                'message' => $message->message,
                'created_at' => $message->created_at,
                'sender_id' => $message->sender_id,
                'user_name' => $user ? $user->name : 'Unknown User',
                'user_color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                'image_background_color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            ];
        }
    }

    public function loadChatRooms()
    {
        $chatRooms = ChatRoom::orderBy('created_at', 'desc')->get();

        foreach ($chatRooms as $chatRoom) {
            $this->chatRooms[] = [
                'id' => $chatRoom->id,
                'name' => $chatRoom->name,
                'logo' => $chatRoom->logo,
                'created_at' => $chatRoom->created_at,
            ];
        }
    }

    public function sendMessage()
    {
        // Only allow sending messages if the chat room is today
        if (ChatRoom::find($this->chatRoomId)->created_at->isToday()) {
            $this->validate([
                'message' => 'required|string',
            ]);

            try {
                $chatRoom = ChatRoom::find($this->chatRoomId); // Get the selected chat room

                if (!$chatRoom) {
                    return; // Handle no chat room case
                }

                $chatRoomSameIp = new Message();
                $chatRoomSameIp->sender_id = Auth::id();
                $chatRoomSameIp->chat_room_id = $this->chatRoomId; // Use the selected chat room ID
                $chatRoomSameIp->message = $this->message;
                $chatRoomSameIp->ip = request()->ip();
                $chatRoomSameIp->useragent = request()->header('User-Agent');
                $chatRoomSameIp->save();

                $this->appendChatMessage($chatRoomSameIp);
                broadcast(new ChatRoomSameIpEvent($chatRoomSameIp, $this->chatRoomId))->toOthers();
                $this->message = '';
                $this->dispatch('scrollDown');
            } catch (\Exception $e) {
                Log::error('There was an error sending your message: ' . $e);
                session()->flash('error', 'Failed to send the message. Please try again.');
            }
        } else {
            session()->flash('error', 'You cannot send messages in chat rooms from previous days.');
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

        $this->messages[] = [
            'id' => $message->id,
            'message' => $message->message,
            'created_at' => $message->created_at,
            'sender_id' => $message->sender_id,
            'user_name' => $user ? $user->name : 'Unknown User',
            'user_color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            'image_background_color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
        ];
    }

    public function selectChatRoom($chatRoomId)
    {
        $this->chatRoomId = $chatRoomId; // Set the selected chat room ID
        $this->loadMessages(); // Load messages for the selected chat room
    }

    public function render()
    {
        return view('livewire.chat-room-same-ip-component', [
            'messages' => $this->messages,
            'isToday' => ChatRoom::find($this->chatRoomId)->created_at->isToday(), // Check if the selected chat room is today
        ]);
    }
}
