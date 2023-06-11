<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
use Illuminate\Support\Facades\Storage;
class MessageController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'receiver' => 'required|exists:users,id',
            'message' => 'required|string',
            'photo' => 'image|max:2048', // Add validation for the uploaded photo
        ]);
    
        $message = new Message();
        $message->sender = Auth::id();
        $message->receiver = $request->input('receiver');
        $message->message = $request->input('message');
    
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->store('photos', 'public'); // Store the photo in the 'photos' directory of the 'public' disk
            $message->photo = $path;
        }
    
        $message->save();
    
        // Trigger a Pusher event to notify the receiver
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);
    
        $pusher->trigger('exchange', 'new-message', $message);
    
        return response()->json(['message' => 'Message sent successfully'], 201);
    }
    
    public function CountMsg()
    {
        $count = Message::count();
        return response()->json([
            'status' => 'success',
            'data' => $count,
        ]);
    }
    
}

