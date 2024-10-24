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
        'chatBoxVisible' => 'markMessagesAsSeen',
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
        $this->dispatch('scrollDown');

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

            // Mark unseen messages as seen if they are from the receiver
            $unseenMessages = $this->messages->where('sender_id', $this->receiverId)
                ->where('receiver_id', Auth::id())
                ->where('is_seen', false);

            foreach ($unseenMessages as $unseenMessage) {
                $unseenMessage->is_seen = true;
                $unseenMessage->save();

                // Optionally broadcast the message seen event back to the sender
                broadcast(new PrivateChatEvent($unseenMessage, $unseenMessage->sender_id))->toOthers();
            }
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

    public function markMessagesAsSeen()
    {
        if ($this->receiverId) {
            $unseenMessages = Message::where('sender_id', $this->receiverId)
                ->where('receiver_id', Auth::id())
                ->where('is_seen', false)
                ->get();

            foreach ($unseenMessages as $unseenMessage) {
                $unseenMessage->is_seen = true;
                $unseenMessage->save();

                // Optionally broadcast back to the sender that the message is seen
                broadcast(new PrivateChatEvent($unseenMessage, $unseenMessage->sender_id))->toOthers();
            }
        }
    }

    public function render()
    {
        return view('livewire.private-chat-component');
    }
}
