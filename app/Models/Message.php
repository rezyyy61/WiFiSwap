<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'sender_id', 'receiver_id', 'ip', 'user_agent'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relationship to the receiver (user)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // If you have a ChatRoom model for the chat rooms
    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class, 'chat_room_id');
    }
}
