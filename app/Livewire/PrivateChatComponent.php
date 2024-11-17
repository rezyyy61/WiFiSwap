<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\VoiceMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PrivateChatComponent extends Component
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
        if ($this->receiverId) {
            // Load text messages and add 'type' => 'text'
            $textMessages = Message::where(function ($query) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $this->receiverId);
            })->orWhere(function ($query) {
                $query->where('sender_id', $this->receiverId)
                    ->where('receiver_id', Auth::id());
            })->get()->map(function ($message) {
                $messageArray = $message->toArray();
                $messageArray['type'] = 'text';
                return $messageArray;
            });

            // Load voice messages and add 'type' => 'voice'
            $voiceMessages = VoiceMessage::where(function ($query) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $this->receiverId);
            })->orWhere(function ($query) {
                $query->where('sender_id', $this->receiverId)
                    ->where('receiver_id', Auth::id());
            })->get()->map(function ($voiceMessage) {
                $messageArray = $voiceMessage->toArray();
                $messageArray['type'] = 'voice';
                return $messageArray;
            });

            // Merge and sort messages
            $allMessages = $textMessages->concat($voiceMessages)->sortBy('created_at');

            // Convert to array
            $this->messages = $allMessages->values()->all();
        }
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
        } else {
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
                $this->dispatchSelf('refreshComponent'); // Ensure Livewire reactivity for typing
            }
        } catch (\Exception $e) {
            Log::error('Error in handleTypingEvent: ' . $e->getMessage());
        }
    }

    public function handleRecordingEvent($event): void
    {
        if ($event['senderId'] == $this->receiverId) {
            $isRecording = $event['isRecording'];

            // Update component state
            $this->isRecording[$event['senderId']] = $isRecording;

            // Optionally, trigger a UI update
            $this->dispatch('refreshComponent');
        }
    }
    public function render()
    {
        return view('livewire.private-chat-component', [
            'isRecording' => $this->isRecording,
        ]);
    }

}
