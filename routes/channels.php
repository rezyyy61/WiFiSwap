<?php

use App\Models\ChatRoom;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chatRoomSameIp.{chatRoom_id}', function ($user, $chatRoomId) {
    return ChatRoom::where('id', $chatRoomId)->where('ip', $user->ip)->exists();
});
