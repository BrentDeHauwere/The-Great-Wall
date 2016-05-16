<?php

namespace App\Events;

use App\Poll;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewPollEvent extends Event implements ShouldBroadcast
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
        $this->poll = $poll;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        $string = 'msg1.polls.'.$this->poll->wall_id;
        //dd($string);
        return ['msg1.polls.'.$this->poll->wall_id];
    }
}
