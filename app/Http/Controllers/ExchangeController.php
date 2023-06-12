<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    public function exchange(Request $request, $post_id, $user_id)
    {
        // Perform some action to exchange the posts
        
        $user = $request->user();
        $post = Post::findOrFail($post_id);
        $targetUser =User::findOrFail($user_id);
        
        if ($user->isEligibleForExchange()) {
            // Perform the exchange action
            
            // Create a new notification for the sender
            $message = 'You have a new exchange request for your post: ' . $post->title;
            $notification = new Notification([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'sender_id' => $targetUser->id,
                'message' => $message,
            ]);
            $notification->save();
            
            // Redirect the user to the exchange page or perform some other action
        } else {
            $user->update(['suspended' => true]);
            return redirect()->route('suspended');
        }
    }
}