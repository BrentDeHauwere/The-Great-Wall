<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessageModeratorAcceptedEvent extends Event
{
    use SerializesModels;
    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['messagewall1.wall.'.$this->poll->wall_id.'.message.moderator.accepted'];
    }
}
