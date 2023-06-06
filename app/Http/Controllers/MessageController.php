<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'receiver' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = new Message();
        $message->sender= Auth::id(); // Assuming the sender is the authenticated user
        $message->receiver = $request->input('receiver');
        $message->message = $request->input('message');
        $message->save();

        // Trigger a Pusher event to notify the receiver
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);

        $pusher->trigger('exchange', 'new-message', $message);

        return response()->json(['message' => 'Message sent successfully'], 201);
    }
}

