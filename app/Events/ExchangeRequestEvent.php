<?php

namespace App\Events;

use App\Models\ExchangeRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;




class ExchangeRequestEvent implements ShouldBroadcast
{
    public $exchangeRequest;

    public function __construct(ExchangeRequest $exchangeRequest)
    {
        $this->exchangeRequest = $exchangeRequest;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user-channel.' . $this->exchangeRequest->receiver_id);
    }

    public function broadcastWith()
    {
        return [
            'exchange_request' => $this->exchangeRequest,
        ];
    }
}

