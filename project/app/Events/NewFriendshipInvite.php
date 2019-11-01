<?php

namespace App\Events;

use App\Model\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewFriendshipInvite implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $invited;

    /**
     * Create a new event instance.
     *
     * @param int $invited
     */
    public function __construct(int $invited)
    {
        $this->invited = $invited;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("user-notifications." . $this->invited);
    }
}
