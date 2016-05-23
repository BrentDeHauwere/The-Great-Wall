<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\PollVote;
use App\PollChoice;
use App\Poll;

class NewPollVoteEvent extends Event implements ShouldBroadcastNow
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public $poll_vote;
    public function __construct(PollVote $vote)
    {
        $this->poll_vote = $vote;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['msg1.vote.polls.'.$this->poll_vote->choice->poll->wall_id];
    }
}
