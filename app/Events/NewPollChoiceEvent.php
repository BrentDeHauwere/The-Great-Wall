<?php

namespace App\Events;

use App\PollChoice;
use App\Wall;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewPollChoiceEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public $poll_choice;

    public function __construct(PollChoice $choice)
    {
        $this->poll_choice = $choice;
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
