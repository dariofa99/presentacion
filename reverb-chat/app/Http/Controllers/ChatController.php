<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function fetchMessages()
    {
        //Message::truncate();
        return Message::with('user')->latest()->take(50)->get()->reverse()->values();
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        $message = Message::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message->load('user')))->toOthers();
        Log::info('Message sent 2', ['message' => $message]);
        return response()->json(['success' => true, 'message' => $message]);
    }
}
