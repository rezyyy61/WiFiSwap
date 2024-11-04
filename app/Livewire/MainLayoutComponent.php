<?php

namespace App\Livewire;

use App\Events\PrivateChatEvent;
use App\Models\Friendship;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MainLayoutComponent extends Component
{
    public $notifications = [];
    public $unreadCount;
    public $currentView= 'home';

    protected $listeners = [
        'unreadMessagesUpdated' => 'fetchUnreadMessagesCount',
    ];


    public function mount()
    {
        $this->fetchNotifications();
        $this->fetchUnreadMessagesCount();
    }

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

    public function fetchUnreadMessagesCount()
    {
        $this->unreadCount = Message::where('receiver_id', Auth::id())
            ->where('is_seen', false)
            ->count();
    }

    public function render()
    {

        return view('livewire.main-layout-component', [
            'name' => Auth::user()->name,
            'notifications' => $this->notifications,
            'unreadCount' => $this->unreadCount,
        ]);
    }
}
