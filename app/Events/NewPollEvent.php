<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewPollEvent extends Event
{
    use SerializesModels;

    public $poll;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Poll $poll)
    {
        $this->poll = poll;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['messagewall1.wall.'.$this->poll->wall_id.'.polls'];
    }
}
