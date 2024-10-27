<?php

namespace App\Livewire;

use Livewire\Component;

class ProfileLayouteComponent extends Component
{
    public $currentProfile = 'PublicProfile';

    public function showPubicProfile()
    {
        $this->currentProfile = 'PublicProfile';
    }

    public function showAccountSettings()
    {
        $this->currentProfile = 'AccountSettings';
    }
    public function render()
    {
        return view('livewire.profile-layoute-component');
    }
}
