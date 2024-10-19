<?php

namespace App\Livewire;

use Livewire\Component;

class MainLayoutComponent extends Component
{
    public $currentView= 'home'; // Default tab

    public function showHome()
    {
        $this->currentView = 'home';
    }

    public function showChatRoom()
    {
        $this->currentView = 'chatRoom';
    }

    public function showChatRoomSame()
    {
        $this->currentView = 'settings';
    }

    public function render()
    {
        return view('livewire.main-layout-component');
    }
}
