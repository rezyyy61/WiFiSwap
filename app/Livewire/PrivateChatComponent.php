<?php

namespace App\Livewire;

use Livewire\Component;

class PrivateChatComponent extends Component
{
    public $receiverId = null;
    protected $listeners = ['userSelected' => 'loadUserChat'];

    public function loadUserChat($userData)
    {
        $this->receiverId = $userData['id'];
    }

    public function render()
    {
        return view('livewire.private-chat-component');
    }

}
