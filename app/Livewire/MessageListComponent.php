<?php

namespace App\Livewire;

use App\Models\mediaFile;
use App\Models\Message;
use App\Models\VoiceMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MessageListComponent extends Component
{
    public $receiverId;
    public $messages = [];
    public $isTyping = [];
    public $isRecording;
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
        return [
            "echo-private:chat." . Auth::id() . ",PrivateChatEvent" => 'listenForMessage',
            "echo-private:typing." . Auth::id() . ",UserTypingEvent" => 'handleTypingEvent',
            "echo-private:recording." . Auth::id() . ",UserRecordingVoiceEvent" => 'handleRecordingEvent',
        ];
    }
    public function loadMessages()
    {
        if (!$this->receiverId) {
            return;
        }

        // Helper function to retrieve and transform messages
        $getMessagesWithType = function ($model, $type) {
            return $model::where(function ($query) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $this->receiverId);
            })->orWhere(function ($query) {
                $query->where('sender_id', $this->receiverId)
                    ->where('receiver_id', Auth::id());
            })->get()->map(function ($message) use ($type) {
                $messageArray = $message->toArray();
                $messageArray['type'] = $type;
                return $messageArray;
            });
        };

        // Retrieve all messages by type
        $textMessages = $getMessagesWithType(Message::class, 'text');
        $voiceMessages = $getMessagesWithType(VoiceMessage::class, 'voice');
        $fileMessages = $getMessagesWithType(MediaFile::class, 'file');

        // Merge, sort, and assign to component property
        $this->messages = $textMessages
            ->concat($voiceMessages)
            ->concat($fileMessages)
            ->sortBy('created_at')
            ->values()
            ->all();
    }

    public function listenForMessage($event): void
    {
        $newMessageData = $event['message'];
        $messageType = $event['type'] ?? 'text';

        if (!$newMessageData) {
            Log::error('Message data is missing in event data.', $event);
            return;
        }

        $messageId = $newMessageData['id'] ?? null;

        if (!$messageId) {
            Log::error('Message ID is missing in event data.', $newMessageData);
            return;
        }

        // Fetch the message from the appropriate model
        if ($messageType === 'voice') {
            $messageInDb = VoiceMessage::find($messageId);
        } elseif ($messageType === 'file') {
            $messageInDb = mediaFile::find($messageId);
        }
        else {
            $messageInDb = Message::find($messageId);
        }

        if (!$messageInDb) {
            Log::error('Message not found in database.', ['message_id' => $messageId]);
            return;
        }

        // Convert message to array and add 'type'
        $messageArray = $messageInDb->toArray();
        $messageArray['type'] = $messageType;

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
        $this->messages = collect($this->messages)->sortBy('created_at')->values()->all();

        $this->dispatch('scrollDown');
    }

    public function handleTypingEvent($event): void
    {
        try {
            if ($event['senderId'] == $this->receiverId) {
                $this->dispatch('scrollDown');
                $this->isTyping[$event['senderId']] = $event['isTyping'];
            }
        } catch (\Exception $e) {
            Log::error('Error in handleTypingEvent: ' . $e->getMessage());
        }
    }

    public function handleRecordingEvent($event): void
    {
        if ($event['senderId'] == $this->receiverId) {
            $isRecording = $event['isRecording'];
            $this->isRecording[$event['senderId']] = $isRecording;
        }
    }

    public function render()
    {
        return view('livewire.message-list-component', [
            'isRecording' => $this->isRecording,
        ]);
    }
}
