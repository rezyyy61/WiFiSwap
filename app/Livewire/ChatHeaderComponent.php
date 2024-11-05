<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class ChatHeaderComponent extends Component
{
    public $receiverId;
    public $receiverName;

    public function mount($receiverId)
    {
        $this->receiverId = $receiverId;
        $this->loadReceiverDetails();
    }

    public function loadReceiverDetails()
    {
        $receiver = User::find($this->receiverId);
        $this->receiverName = $receiver ? $receiver->name : 'Unknown User';
    }

    public function render()
    {
        return view('livewire.chat-header-component');
    }
}
