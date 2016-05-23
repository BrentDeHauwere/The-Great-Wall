<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\Poll;

class NewPollModeratorDeclineEvent extends Event implements ShouldBroadcastNow
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
        return ['msg1.modd.polls.'.$this->poll->wall_id];
    }
}
