<?php

namespace App\Events;

use App\Events\Event;
use App\PollChoice;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewPollChoiceModeratorDeclineEvent extends Event implements ShouldBroadcastNow
{
    use SerializesModels;
    public $pollchoice;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PollChoice $pc)
    {
        $this->pollchoice = $pc;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
