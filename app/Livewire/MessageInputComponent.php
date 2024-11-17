<?php

namespace App\Livewire;

use App\Events\PrivateChatEvent;
use App\Events\UserRecordingVoiceEvent;
use App\Events\UserTypingEvent;
use App\Models\Message;
use App\Models\VoiceMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use function Symfony\Component\Translation\t;

class MessageInputComponent extends Component
{
    public $messages = [];
    public $message = '';
    public $receiverId;
    public $audioData;
    public $audioDuration;
    public $isRecording;


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

        try {
            if ($this->audioData) {
                $this->sendVoiceMessage();
            } elseif (!empty($this->message)) {
                $this->sendTextMessage();
            }
        } catch (\Exception $e) {
            Log::error('There was an error sending your message: ' . $e->getMessage());
        }
    }

    protected function sendVoiceMessage()
    {
        // Decode the base64 data
        $data = base64_decode($this->audioData);

        // Generate a filename
        $filename = 'recording_' . time() . '.ogg';

        // Save the file to storage
        $filePath = 'voice_messages/' . $filename;
        Storage::disk('public')->put($filePath, $data);

        // Get additional file info
        $size = strlen($data);
        $mimeType = 'audio/ogg';

        // Save to voice_messages table
        $voiceMessage = new VoiceMessage();
        $voiceMessage->sender_id = Auth::id();
        $voiceMessage->receiver_id = $this->receiverId;
        $voiceMessage->file_path = $filePath;
        $voiceMessage->original_name = $filename;
        $voiceMessage->mime_type = $mimeType;
        $voiceMessage->size = $size;
        $voiceMessage->duration = $this->audioDuration; // Ensure this is set
        $voiceMessage->save();

        // Reset properties
        $this->audioData = null;
        $this->audioDuration = null;

        // Optionally, dispatch events or update UI
        $this->dispatch('voiceMessageSent');
        broadcast(new PrivateChatEvent($voiceMessage, $this->receiverId, 'voice'));
        broadcast(new UserRecordingVoiceEvent(Auth::id(), $this->receiverId, false));

    }

    protected function sendTextMessage()
    {
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
        broadcast(new PrivateChatEvent($message, $this->receiverId, 'text'));
    }

    public function toggleRecording(): void
    {
        if ($this->isRecording) {
            $this->stopRecording();
        } else {
            $this->startRecording();
        }

        $this->dispatch('toggleRecording', ['isRecording' => $this->isRecording]);

        $this->skipRender();
    }

    public function startRecording(): void
    {
        $this->isRecording = true;

        // Broadcast the recording started event
        broadcast(new UserRecordingVoiceEvent(Auth::id(), $this->receiverId, true))->toOthers();
        Log::info('Recording started. isRecording: ' . ($this->isRecording));
    }

    public function stopRecording(): void
    {
        $this->isRecording = false;

        // Broadcast the recording stopped event
        broadcast(new UserRecordingVoiceEvent(Auth::id(), $this->receiverId, false))->toOthers();
        Log::info('Recording stopped. isRecording: ' . ($this->isRecording));
    }

    public function render()
    {
        return view('livewire.message-input-component');
    }
}
