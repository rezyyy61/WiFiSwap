<?php

namespace App\Livewire;

use Livewire\Component;

class MainLayoutComponent extends Component
{
    public $currentView;

    public function showHome()
    {
        $this->currentView = 'home';
    }

    public function showChatRoom()
    {
        $this->currentView = 'chatRoom';
    }
    public function test()
    {
        $this->currentView = 'chatRoomSame';
    }

    public function render()
    {
        return view('livewire.main-layout-component');
    }
}
