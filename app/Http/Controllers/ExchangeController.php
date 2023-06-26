<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Notification;
use App\Notifications\RealTimeNotification;
use Auth;

class ExchangeController extends Controller
{
    public function exchange(Request $request)
    {
        // Perform some action to exchange the posts
        
        $user = User::findOrFail(1);
        $post = Post::findOrFail($request->post_id);
        $targetUser =User::findOrFail($request->user_id);
       // if ($user->isEligibleForExchange()) {
            // Perform the exchange action
            // Create a new notification for the sender
          /*  $message = 'You have a new exchange request for your post: ' . $post->title;
            $notification = new Notification([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'sender_id' => $targetUser->id,
                'message' => $message,
            ]);
            $notification->save();
            */
            Notification::send($user,new RealTimeNotification($user,$post,$targetUser));
            // Redirect the user to the exchange page or perform some other action
      //  } else {
        //    $user->update(['suspended' => true]);
         //   return redirect()->route('suspended');
       // }
    }
}