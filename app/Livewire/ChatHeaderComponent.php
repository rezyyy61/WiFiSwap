<?php

namespace App\Livewire;

use Livewire\Component;

class ChatHeaderComponent extends Component
{
    public $receiverName = '';
    public $receiverId;

    protected $listeners = ['userSelected' => 'updateHeader'];

    public function updateHeader($userData)
    {
        $this->receiverName = $userData['name'];
        $this->receiverId = $userData['id'];
    }

    public function render()
    {
        return view('livewire.chat-header-component');
    }
}
