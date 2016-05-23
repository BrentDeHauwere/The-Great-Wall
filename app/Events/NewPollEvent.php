<?php

namespace App\Events;

use App\Poll;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewPollEvent extends Event implements ShouldBroadcastNow
{
    use SerializesModels;

    public $poll;
    public $user;
    public $wall;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
        $this->user = $poll->user;
        $this->wall = $poll->wall;
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
