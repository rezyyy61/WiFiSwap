<?php

namespace App\Livewire;

use App\Events\PrivateChatEvent;
use App\Events\UserRecordingVoiceEvent;
use App\Events\UserTypingEvent;
use App\Models\mediaFile;
use App\Models\Message;
use App\Models\VoiceMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class MessageInputComponent extends Component
{
    use WithFileUploads;

    public $uploadedFile;

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
            // Handle voice messages
            if ($this->audioData) {
                try {
                    $this->sendVoiceMessage();
                } catch (\Exception $e) {
                    Log::error("Error sending voice message: {$e->getMessage()}");
                    $this->addError('audioData', 'Failed to send voice message.');
                }
            }

            // Handle text messages
            if (!empty($this->message)) {
                try {
                    $this->sendTextMessage();
                    $this->dispatch('scrollDown');
                } catch (\Exception $e) {
                    Log::error("Error sending text message: {$e->getMessage()}");
                    $this->addError('message', 'Failed to send text message.');
                }
            }

            // Handle file uploads
            if ($this->uploadedFile) {
                try {
                    $this->sendFileMessage($this->uploadedFile);
                } catch (\Exception $e) {
                    Log::error("Error sending file message: {$e->getMessage()}");
                    $this->addError('uploadedFile', 'Failed to send file message.');
                }
            }

            // Clear the inputs after sending
            $this->uploadedFile = null;
            $this->message = '';
        } catch (\Exception $e) {
            Log::error("Unexpected error in sendMessage: {$e->getMessage()}");
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

    protected function sendFileMessage($file)
    {
        try {
            $this->validate([
                'uploadedFile' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240', // Max: 10 MB
            ]);

            // Get the original file name
            $originalFileName = $file->getClientOriginalName();
            // Get the file extension
            $fileExtension = $file->getClientOriginalExtension();

            // Check if the file already exists in the database
            $fileName = mediaFile::where('file_name', $originalFileName)->first();

            if ($fileName) {
                // File exists, so start the counter
                $count = 1;
                // Keep incrementing the counter until a unique name is found
                while (mediaFile::where('file_name', $originalFileName)->exists()) {
                    // Append the counter to the file name
                    $newFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . $count . '.' . $fileExtension;
                    // Check again if the name already exists
                    $fileName = mediaFile::where('file_name', $newFileName)->first();
                    if (!$fileName) {
                        // If file with the new name does not exist, use it
                        break;
                    }
                    $count++;
                }
                // Set the unique file name
                $uniqueFileName = $newFileName;
            } else {
                // If the file does not exist, use the original file name
                $uniqueFileName = $originalFileName;
            }

            // Save file with the unique file name
            $filePath = $file->storeAs('media_files', $uniqueFileName, 'public');

            // Save the file details to the database
            $fileMessage = new mediaFile();
            $fileMessage->sender_id = Auth::id();
            $fileMessage->receiver_id = $this->receiverId;
            $fileMessage->file_name = $uniqueFileName;
            $fileMessage->file_path = $filePath;
            $fileMessage->file_type = $file->getClientOriginalExtension();
            $fileMessage->file_size = $file->getSize();
            $fileMessage->mime_type = $file->getClientMimeType();
            $fileMessage->description = 'Uploaded file message';
            $fileMessage->save();

            // Broadcast the file message event
            broadcast(new PrivateChatEvent($fileMessage, $this->receiverId, 'file'));

        } catch (\Exception $e) {
            Log::error("Failed to send file message: {$e->getMessage()}");
            throw $e;
        }
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
        broadcast(new UserRecordingVoiceEvent(Auth::id(), $this->receiverId, true))->toOthers();
        Log::info('Recording started. isRecording: ' . ($this->isRecording));
    }

    public function stopRecording(): void
    {
        $this->isRecording = false;
        broadcast(new UserRecordingVoiceEvent(Auth::id(), $this->receiverId, false))->toOthers();
        Log::info('Recording stopped. isRecording: ' . ($this->isRecording));
    }

    public function render()
    {
        return view('livewire.message-input-component');
    }
}
