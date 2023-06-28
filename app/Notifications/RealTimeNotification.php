<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;


class RealTimeNotification extends Notification
{
    use Queueable;
    private $user;
    private $post;
    private $targetUser;



    /**
     * Create a new notification instance.
     */
    public function __construct($user,$post,$targetUser)
    {
        $this->user= $user;
        $this->post=$post;
        $this->targetUser=$targetUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toDatabase(object $notifiable)
    {
        return [
        'sender_id'=> $this->user->id,
        'target_user_id'=>$this->targetUser->id,
        'post_id'=>$this->post->id,
        'message'=>'asdfsdf'
        ];
    }
}