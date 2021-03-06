<?php

namespace App\Events;

use App\Message;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\Poll;

class NewPollModeratorAcceptEvent extends Event implements ShouldBroadcastNow
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public $poll;
     public $user;
     public $wall;
    public function __construct(Poll $poll)
    {
      $this->poll = $poll;
      $this->user = $poll->user;
      $this->wall = $poll->wall;
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
