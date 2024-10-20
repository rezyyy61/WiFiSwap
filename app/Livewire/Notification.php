<?php

namespace App\Livewire;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notification extends Component
{
    public $notifications = [];

    public function mount()
    {
        $this->fetchNotifications();
    }

    public function fetchNotifications()
    {
        $friendshipRequests = Friendship::where('friend_id', Auth::id())
            ->where('status', 'pending')
            ->with('user')
            ->get();

        $this->notifications = [];
        foreach ($friendshipRequests as $request) {
            if ($request->user) {
                $this->notifications[] = [
                    'id' => $request->id,
                    'name' =>  $request->user->name,
                    'timestamp' => $request->created_at->diffForHumans(),
                ];
            }
        }
    }

    public function acceptRequest($id)
    {
        $friendship = Friendship::find($id);
        if ($friendship) {
            $friendship->update(['status' => 'accepted']);
            $this->fetchNotifications(); // Refresh notifications after accepting
        }
    }

    public function declineRequest($id)
    {
        $friendship = Friendship::find($id);
        if ($friendship) {
            $friendship->update(['status' => 'declined']);
            $this->fetchNotifications(); // Refresh notifications after declining
        }
    }

    public function render()
    {
        return view('livewire.notification');
    }
}
