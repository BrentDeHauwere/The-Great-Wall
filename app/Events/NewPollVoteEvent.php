<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\PollVote;
use App\PollChoice;
use App\Poll;

class NewPollVoteEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public $poll_vote;
     public $poll_choice;
     public $poll;
    public function __construct(PollVote $vote,PollChoice $choice,Poll $poll)
    {
      $this->poll_choice = $choice;
      $this->poll_vote = $vote;
      $this->poll = $poll;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['msg1.vote.polls.'.$this->poll->wall_id];
    }
}
