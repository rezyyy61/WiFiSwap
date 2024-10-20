<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
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

    public function notification()
    {
        $this->currentView = 'notification';
    }

    public function render()
    {
        return view('livewire.main-layout-component', ['name'=> Auth::user()->name]);
    }
}
