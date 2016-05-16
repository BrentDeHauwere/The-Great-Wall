<?php

namespace App\Events;

use App\Message

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Poll;

class NewPollModeratorAcceptEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public $poll;
    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['msg1.moda.polls.'.$this->poll->wall_id];
    }
}
