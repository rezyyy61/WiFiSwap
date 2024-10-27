<?php

namespace App\Livewire;

use App\Events\UserOnlineEvent;
use App\Models\ChatRoom;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OnlineUsersComponent extends Component
{
    public array $chatRooms = [];
    public array $onlineUsers = [];

    protected $listeners = ['listenForUser', 'refreshOnlineUsers'];

    public function mount()
    {
        $this->createChatRoom();
        $this->loadChatRooms();
        $this->loadOnlineUsersWithSameIp();
    }

    public function loadOnlineUsersWithSameIp()
    {
        $currentUser = Auth::user();

        if ($currentUser) {
            // Fetch online users with the same IP
            $users = User::where('ip', $currentUser->ip)
                ->where('id', '!=', $currentUser->id)
                ->where('online', 1)
                ->with('profile')
                ->get();

            // Map users to required format
            $this->onlineUsers = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'profile' => $user->profile ? [
                        'profile_image' => $user->profile->profile_image,
                        'background_color' => $user->profile->background_color,
                        'accountId' => $user->profile->accountId,
                        'bio' => $user->profile->bio,
                        'phone' => $user->profile->phone,
                    ] : null,
                ];
            })->toArray();

        }
    }

    public function refreshOnlineUsers()
    {
        $this->loadOnlineUsersWithSameIp();
    }

    public function getListeners(): array
    {
        return [
            "echo:online-users,UserOnlineEvent" => "listenForUser"
        ];
    }

    public function createChatRoom(): void
    {
        $existingChatRoom = ChatRoom::where('ip', request()->ip())
            ->whereDate('created_at', Carbon::today())
            ->first();

        if (!$existingChatRoom) {
            // Create a new chat room
            ChatRoom::create([
                'ip' => request()->ip(),
                'name' => request()->ip(),
                'logo' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            ]);
        }
    }

    public function loadChatRooms()
    {
        $this->chatRooms = ChatRoom::orderBy('created_at', 'desc')->get()->map(function ($chatRoom) {
            return [
                'id' => $chatRoom->id,
                'name' => $chatRoom->name,
                'logo' => $chatRoom->logo,
                'created_at' => $chatRoom->created_at,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.online-users-component');
    }
}
