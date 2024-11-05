<?php

namespace App\Livewire;

use App\Events\PrivateChatEvent;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PrivateChatComponent extends Component
{
    public $receiverId;
    public $messages = [];
    public $isTyping = [];

    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    public function mount()
    {
        $this->loadMessages();
        $this->dispatch('scrollDown');
    }


    public function getListeners()
    {
        return array_merge(parent::getListeners(), [
            "echo-private:chat." . Auth::id() . ",PrivateChatEvent" => 'listenForMessage',
            "echo-private:typing." . Auth::id() . ",UserTypingEvent" => 'handleTypingEvent',
        ]);
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
            })->orderBy('created_at', 'asc')->get()->toArray();
        }
    }

    public function listenForMessage($event): void
    {
        $newMessageData = $event['message'];
        $messageId = $newMessageData['id'] ?? null;

        if (!$messageId) {
            Log::error('Message ID is missing in event data.', $newMessageData);
            return;
        }

        // Fetch the message from the database
        $messageInDb = Message::find($messageId);

        if (!$messageInDb) {
            Log::error('Message not found in database.', ['message_id' => $messageId]);
            return;
        }

        // Proceed if the message is between the current user and the selected user
        if (
            ($messageInDb->sender_id == $this->receiverId && $messageInDb->receiver_id == Auth::id()) ||
            ($messageInDb->sender_id == Auth::id() && $messageInDb->receiver_id == $this->receiverId)
        ) {
            // If the message is from the receiver, mark it as seen
            if ($messageInDb->sender_id == $this->receiverId && $messageInDb->receiver_id == Auth::id()) {
                if (!$messageInDb->is_seen) {
                    $messageInDb->is_seen = true;
                    $messageInDb->save();

                    // Broadcast the message seen event back to the sender
                    broadcast(new PrivateChatEvent($messageInDb, $messageInDb->sender_id))->toOthers();
                }
            }

            // Convert $messageInDb to array
            $messageArray = $messageInDb->toArray();

            // Update or add the message in the local messages array
            $existingMessageKey = array_search($messageId, array_column($this->messages, 'id'));

            if ($existingMessageKey !== false) {
                // Update existing message in the array
                $this->messages[$existingMessageKey] = $messageArray;
            } else {
                // Add the new message to the array
                $this->messages[] = $messageArray;
            }

            // Reassign the messages array to trigger reactivity
            $this->messages = array_values($this->messages);

            $this->dispatch('scrollDown');
        }
    }


    public function handleTypingEvent($event): void
    {
        try {
            if ($event['senderId'] == $this->receiverId) {
                $this->dispatch('scrollDown');
                $this->isTyping[$event['senderId']] = $event['isTyping'];
                $this->dispatchSelf('refreshComponent'); // Ensure Livewire reactivity for typing
            }
        } catch (\Exception $e) {
            Log::error('Error in handleTypingEvent: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.private-chat-component');
    }

}
