<?php

namespace App\Events;

use App\MessageVote;
use App\Message;
use App\User;

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
     public $message;
     public $user;
    public function __construct(User $user,Message $msg)
    {
        $this->message = $msg;
        $this->user = $user;
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
