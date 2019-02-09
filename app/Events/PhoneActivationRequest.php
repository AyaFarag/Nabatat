<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PhoneActivationRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $phone;
    public $user;

    public function __construct($user, $phone)
    {
        $this -> phone = $phone;
        $this -> user  = $user;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
