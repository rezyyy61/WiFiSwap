<?php

namespace App\Listeners;

use App\Models\ChatRoom;
use Carbon\Carbon;


class CreateChatRoomOnLoginOrRegister
{
    /**
     * Handle the event when user logs in or registers.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;

        // Check if a chat room already exists for the user today
        $existingChatRoom = ChatRoom::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if (!$existingChatRoom) {
            // Create new chat room
            $chatroom = new ChatRoom;
            $chatroom->user_id = $user->id;
            $chatroom->ip = request()->ip();
            $chatroom->name = 'ChatRoom for User ' . $user->id;
            $chatroom->logo = 'default-logo.png';
            $chatroom->save();
        }
    }
}
