<?php

namespace App\Livewire;

use App\Events\PrivateChatEvent;
use App\Models\Friendship;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatHistoryComponent extends Component
{
    public $friends = [];
    public $selectedFriendId = null;
    public function mount()
    {
        $this->fetchFriends();
    }

    public function fetchFriends()
    {
        $friendships = Friendship::where(function ($query) {
            // Authenticated user can be either the 'user_id' or 'friend_id'
            $query->where('friend_id', Auth::id())
                ->orWhere('user_id', Auth::id());
        })
            ->where('status', 'accepted') // Only accepted friendships
            ->with([
                'user' => function ($query) {
                    $query->with('profile');
                },
                'friend' => function ($query) { // Ensure we load the 'friend' relationship as well
                    $query->with('profile');
                },
                'user.sentMessages' => function ($query) {
                    $query->latest();
                },
                'friend.sentMessages' => function ($query) {
                    $query->latest();
                }
            ])
            ->get();

        $this->friends = [];

        foreach ($friendships as $friendship) {
            if ($friendship->user_id == Auth::id()) {
                // If authenticated user is 'user', then the 'friend' is the friend
                $friend = $friendship->friend;
            } else {
                // If authenticated user is 'friend', then the 'user' is the friend
                $friend = $friendship->user;
            }

            // Fetch the latest message (from either user or friend)
            $latestMessage = $friend->sentMessages->first();

            // Add the friend to the list
            $this->friends[] = [
                'id' => $friend->id,
                'name' => $friend->name,
                'online' => $friend->online,
                'profile_image' => $friend->profile->profile_image ?? 'default.png',
                'bio' => $friend->profile->bio ?? '',
                'latest_message' => $latestMessage->message ?? 'No messages',
                'latest_message_time' => $latestMessage ? $latestMessage->created_at->diffForHumans() : null,
            ];
        }
    }

    public function selectUser($userId, $name)
    {
        $this->selectedUser = ['id' => $userId, 'name' => $name];
        $this->dispatch('userSelected', $this->selectedUser);
    }

    public function render()
    {
        return view('livewire.chat-history-component');
    }
}
