<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);

        $message = Message::create([
            'message' => $request->message,
            'sender_id' => Auth::id(),
        ]);

        return redirect()->back();
    }

    public function show()
    {
        $userId = Auth::id();
        $userIp = User::where('id', $userId)->value('ip');

        // Get IDs of users with the same IP, excluding the current user
        $userIds = User::where('ip', $userIp)
            ->where('id', '!=', $userId)
            ->pluck('id');

        // Fetch messages for the current user
        $userMessages = Message::where('sender_id', $userId)
            ->select('message', 'created_at', 'sender_id')
            ->orderBy('created_at', 'asc')
            ->get();

        // Fetch messages for users with the same IP
        $otherMessages = Message::whereIn('sender_id', $userIds)
            ->select('message', 'created_at', 'sender_id')
            ->orderBy('created_at', 'asc')
            ->get();

        // Combine messages and sort them by created_at
        $messages = $userMessages->concat($otherMessages)->sortBy('created_at');

        return view('dashboard', ['messages' => $messages]);
    }

}
