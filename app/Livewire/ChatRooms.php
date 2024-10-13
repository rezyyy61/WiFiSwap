<?php

namespace App\Livewire;

use App\Models\ChatRoom;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatRooms extends Component
{
    public $chatRooms = [];

    public function mount()
    {
        $currentUser = Auth::user();

        if ($currentUser) {
            $this->createChatRoom();

            $this->chatRooms = ChatRoom::where('user_id', $currentUser->id)->orderBy('created_at', 'asc')->get();
        } else {
            $this->chatRooms = [];
        }
    }

    public function createChatRoom()
    {
        $currentUser = Auth::user();

        if (!$currentUser) {
            return;
        }

        $existingChatRoom = ChatRoom::where('user_id', $currentUser->id)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if (!$existingChatRoom) {
            // Create new chat room if none exists
            $chatroom = new ChatRoom;
            $chatroom->user_id = $currentUser->id;
            $chatroom->ip = $currentUser->ip;
            $chatroom->name = $currentUser->ip;
            $chatroom->logo = 'test';
            $chatroom->save();
        }
    }

    public function render()
    {
        return view('livewire.chat-rooms');
    }
}
