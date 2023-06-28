<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function markAsRead(Request $request, $id)
    {
        $user = auth()->user();
        $notifications = $user->notifications()->where('read', false)->get();
        $notifications->markAsRead();
        return response()->json(['message' => 'Notification marked as read.']);
    }

    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->where('read', false)->get();
        
        return view('notifications.index', compact('notifications'));
    }
    
    public function accept(Request $request, $notification_id)
    {
        $notification = Notification::findOrFail($notification_id);
        $targetUser = $notification->user;
        $post = $notification->post;
        
        // Perform the exchange action
        
        // Mark the notification as read
        $notification->read = true;
        $notification->save();
        
        // Redirect the user to the exchange confirmation page or perform some other action
    }
}