<?php

namespace App\Livewire;

use App\Events\PrivateChatEvent;
use App\Events\UserTypingEvent;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MessageInputComponent extends Component
{
    public $messages = [];
    public $message = '';
    public $receiverId;


    public function updatedMessage($value): void
    {
        if (!empty($value)) {
            broadcast(new UserTypingEvent(Auth::id(), $this->receiverId, true));
        } else {
            broadcast(new UserTypingEvent(Auth::id(), $this->receiverId, false));
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
            $this->dispatch('scrollDown');
            $this->dispatch('clearMessageInput');
            broadcast(new UserTypingEvent(Auth::id(), $this->receiverId, false));
            broadcast(new PrivateChatEvent($message, $this->receiverId));

        } catch (\Exception $e) {
            Log::error('There was an error sending your message: ' . $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.message-input-component');
    }
}
