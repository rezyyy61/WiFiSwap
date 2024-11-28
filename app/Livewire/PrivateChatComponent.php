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

    public function mount($receiverId)
    {
        $this->receiverId = $receiverId;
    }

    public function render()
    {
        return view('livewire.private-chat-component');
    }

}
