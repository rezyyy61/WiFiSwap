<?php

namespace App\Livewire;

use App\Events\FriendRequestSent;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FriendSearch extends Component
{
    public $query = '';
    public $searchResults = [];
    public $statusMessage = '';
    public function updatedQuery()
    {
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
        return view('livewire.friend-search');
    }
}
