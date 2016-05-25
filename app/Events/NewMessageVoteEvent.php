<?php

namespace App\Events;

use App\MessageVote;
use App\Message;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewMessageVoteEvent extends Event implements ShouldBroadcastNow
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public $message_vote;
     public $message;
    public function __construct(MessageVote $vote,Message $msg)
    {
        $this->message_vote = $vote;
        $this->message = $msg;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['msg1.vote.msg.'.$this->message->wall->id];
    }
}
