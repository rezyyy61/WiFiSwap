<?php

use App\Models\ChatRoom;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chatRoomSameIp.{chatRoom_id}', function ($user, $chatRoomId) {
    return ChatRoom::where('id', $chatRoomId)->where('ip', $user->ip)->exists();
});

// Private channel for chat
Broadcast::channel('chat.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('typing.{receiverId}', function ($user, $receiverId) {
    return (int) $user->id === (int) $receiverId || (int) $user->id !== null;
});

Broadcast::channel('recording.{receiverId}', function ($user, $receiverId) {
    return (int) $user->id === (int) $receiverId || (int) $user->id !== null;
});


