<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OnlineUsersComponent extends Component
{
    public $users = [];

    public function mount()
    {
        $this->onlineUsersSameIp();
    }

    public function onlineUsersSameIp()
    {
        $currentUser = Auth::user();
        $users = User::where('ip', $currentUser->ip)
            ->where('id', '!=', Auth::id())
            ->where('online', 1)
            ->get();
        $this->users = $users;

    }

    public function render()
    {
        return view('livewire.online-users-component');
    }
}
