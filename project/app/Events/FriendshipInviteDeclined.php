<?php

namespace App\Events;

use App\Model\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendshipInviteDeclined implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $inviter;
    private $invitedName;

    /**
     * Create a new event instance.
     *
     * @param int $inviter
     * @param string $invitedName
     */
    public function __construct(int $inviter, string $invitedName)
    {
        $this->inviter = $inviter;
        $this->invitedName = $invitedName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("user-notifications." . $this->inviter);
    }

    public function broadcastWith()
    {
        return ['name' => $this->invitedName];
    }
}
