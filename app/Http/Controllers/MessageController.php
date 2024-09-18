<?php

namespace App\Http\Controllers;

use App\Models\Message;
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
}
