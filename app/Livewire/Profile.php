<?php

namespace App\Livewire;

use Livewire\Component;

class Profile extends Component
{
    public $user;

    public function mount()
    {
       $user =  $this->userDetails();
    }
    public function userDetails()
    {
        $this->user = auth()->user();
    }
    public function render()
    {
        return view('livewire.profile');
    }
}
