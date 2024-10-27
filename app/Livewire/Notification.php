<?php

namespace App\Livewire;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notification extends Component
{
    public $notifications = [];
    public $query = '';
    public $searchResults = [];
    public $statusMessage = '';

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
            $this->fetchNotifications();
        }
    }

    public function updatedQuery()
    {
        if (trim($this->query) === '') {
            $this->searchResults = [];
            return;
        }
        $this->searchResults = User::query()
            ->leftJoin('profile_users', 'users.id', '=', 'profile_users.user_id')
            ->where(function ($q) {
                $q->where('users.email', 'like', '%' . $this->query . '%')
                    ->orWhere('profile_users.accountId', 'like', '%' . $this->query . '%');
            })
            ->where('users.id', '!=', Auth::id())
            ->select('users.*', 'profile_users.accountId')
            ->get();

    }


    public function sendFriendRequest($userId)
    {
        // Check if the friend request already exists
        $existingFriendship = Friendship::where(function ($query) use ($userId) {
            $query->where('user_id', Auth::id())
                ->where('friend_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->where('friend_id', Auth::id());
        })->first();

        if ($existingFriendship) {
            $this->statusMessage = 'Friend request already sent or you are already friends.';
        } else {
            // Send a friend request
            Friendship::create([
                'user_id' => Auth::id(),
                'friend_id' => $userId,
                'status' => 'pending',
            ]);

            $this->statusMessage = 'Friend request sent successfully!';
        }
    }

    public function render()
    {
        return view('livewire.notification');
    }
}
