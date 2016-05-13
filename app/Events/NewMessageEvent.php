<?php

namespace App\Events;

use App\Events\Event;
use App\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessageEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        //$string = 'wall.'.$this->message->wall_id.'.messages';
        //dd($string);
        //dd($this->message);
        return ['messagewall1.wall.'.$this->message->wall_id.'.messages'];
    }
}
