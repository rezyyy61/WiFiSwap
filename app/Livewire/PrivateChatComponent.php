<?php

// App\Livewire\PrivateChatComponent.php

namespace App\Livewire;

use App\Events\PrivateChatEvent;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PrivateChatComponent extends Component
{
    public $receiverId = null;
    public $receiverName;
    public $messages = [];
    public $message = '';

    protected $listeners = [
        'userSelected' => 'loadUserChat',
        "echo-private:chat.{authUserId},PrivateChatEvent" => 'listenForMessage',
    ];

    // Add a computed property for authUserId
    public function getAuthUserIdProperty()
    {
        return Auth::id();
    }

    public function loadUserChat($userData)
    {
        $this->receiverId = $userData['id'];
        $this->receiverName = $userData['name'];

        $this->loadMessages();
    }

    public function loadMessages()
    {
        if ($this->receiverId) {
            $this->messages = Message::where(function ($query) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $this->receiverId);
            })->orWhere(function ($query) {
                $query->where('sender_id', $this->receiverId)
                    ->where('receiver_id', Auth::id());
            })->orderBy('created_at', 'asc')->get();
        }
    }

    public function sendMessage()
    {
        if (!$this->receiverId) {
            Log::error('Receiver ID is not set. Cannot send message.');
            return;
        }

        if (empty($this->message)) {
            return;
        }

        try {
            // Create new message
            $message = new Message();
            $message->sender_id = Auth::id();
            $message->receiver_id = $this->receiverId;
            $message->chat_room_id = null;
            $message->message = $this->message;
            $message->ip = request()->ip();
            $message->useragent = request()->header('User-Agent');
            $message->save();

            $this->message = '';

            broadcast(new PrivateChatEvent($message, $this->receiverId))->toOthers();

            $this->messages->push($message);
            $this->dispatch('scrollDown');
        } catch (\Exception $e) {
            Log::error('There was an error sending your message: ' . $e->getMessage());
        }
    }

    public function listenForMessage($event): void
    {
        $newMessage = $event['message'];

        if (
            ($newMessage['sender_id'] == $this->receiverId && $newMessage['receiver_id'] == Auth::id()) ||
            ($newMessage['sender_id'] == Auth::id() && $newMessage['receiver_id'] == $this->receiverId)
        ) {
            $this->messages[] = Message::find($newMessage['id']);
            $this->dispatch('scrollDown');
        }
    }

    public function render()
    {
        return view('livewire.private-chat-component');
    }
}

