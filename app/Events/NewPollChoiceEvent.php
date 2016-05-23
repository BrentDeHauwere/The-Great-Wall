<?php

namespace App\Events;

use App\PollChoice;
use App\Wall;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewPollChoiceEvent extends Event implements ShouldBroadcastNow
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public $poll_choice;
     public $poll;
     public $user;
     public $wall;

    public function __construct(PollChoice $choice)
    {
        $this->poll_choice = $choice;
        $this->poll = $choice->poll;
        $this->user = $choice->user;
        $this->wall = $choice->poll->wall;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['msg1.choice.polls.'.$this->poll_choice->poll->wall_id];
    }
}
