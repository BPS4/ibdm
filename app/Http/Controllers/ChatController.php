<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;

class ChatController extends Controller
{
   public function send(Request $request)
{
    $message = $request->message;
    $user = 1; // or user ID
    // dd($user);

    event(new MessageSent($user, $message));

    return ['status' => 'Message Sent!'];
}


public function startConversation(Request $request)
{
    $userId = auth()->id();
    $receiverId = $request->receiver_id;

    // Check if already exists
    $conversation = Conversation::whereHas('users', fn($q) => $q->where('user_id', $userId))
        ->whereHas('users', fn($q) => $q->where('user_id', $receiverId))
        ->first();

    if (!$conversation) {
        $conversation = Conversation::create(['is_group' => false]);
        $conversation->users()->attach([$userId, $receiverId]);
    }

    return $conversation;
}


public function sendMessage(Request $request)
{
    $message = Message::create([
        'conversation_id' => $request->conversation_id,
        'sender_id'       => auth()->id(),
        'message'         => $request->message,
        'file'            => $request->file_url ?? null,
    ]);

    broadcast(new MessageSentEvent($message))->toOthers();

    return $message;
}



}




