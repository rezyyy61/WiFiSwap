<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chatRoomSameIp.{sender_id}', function ($user, $sender_id) {
    return (int) $user->id === (int) $sender_id;
});
