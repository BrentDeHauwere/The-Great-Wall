<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\PollVote;
use App\PollChoice;
use App\Poll;
use App\User;

class NewPollVoteEvent extends Event implements ShouldBroadcastNow
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public $poll_choice;
     public $count;
     public $voted;
    public function __construct(PollChoice $choice,$count,$voted)
    {
        $this->poll_choice = $choice;
        $this->count = $count;
        $this->voted = $voted;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['msg1.vote.polls.'.$this->poll_choice->poll->wall_id];
    }
}
