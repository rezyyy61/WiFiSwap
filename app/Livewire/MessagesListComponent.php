<?php

namespace App\Livewire;

use App\Events\PrivateChatEvent;
use App\Events\UserTypingEvent;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MessagesListComponent extends Component
{
    public $messages = [];
    public $receiverId;
    public $isTyping = [];

    protected $listeners = [
        'userSelected' => 'loadUserChat',
    ];


    public function getListeners()
    {
        return array_merge(parent::getListeners(), [
            "echo-private:chat." . Auth::id() . ",PrivateChatEvent" => 'listenForMessage',
            "echo-private:typing." . Auth::id() . ",UserTypingEvent" => 'handleTypingEvent',
        ]);
    }

    public function loadUserChat($userId): void
    {
        $this->dispatch('scrollDown');
        $this->receiverId = $userId['id'];
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if ($this->receiverId) {
            // Load messages between authenticated user and selected user
            $this->messages = Message::where(function ($query) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $this->receiverId);
            })->orWhere(function ($query) {
                $query->where('sender_id', $this->receiverId)
                    ->where('receiver_id', Auth::id());
            })->orderBy('created_at', 'asc')->get();
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

        // Fetch the message from the database to ensure we are working with a model instance
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

            // Update or add the message in the local messages collection
            $existingMessageKey = collect($this->messages)->search(function ($message) use ($messageId) {
                return $message->id == $messageId;
            });

            if ($existingMessageKey !== false) {
                // Update existing message in the collection
                $this->messages[$existingMessageKey] = $messageInDb;
            } else {
                // Add the new message as an Eloquent model instance
                $this->messages->push($messageInDb);
            }

            // Reassign the messages collection to trigger reactivity
            $this->messages = $this->messages->values();

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
        return view('livewire.messages-list-component');
    }
}
