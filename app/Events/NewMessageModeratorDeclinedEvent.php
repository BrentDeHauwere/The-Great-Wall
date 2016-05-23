<?php

namespace App\Events;

use App\Message;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewMessageModeratorDeclinedEvent extends Event implements ShouldBroadcastNow
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
        return ['msg1.modd.msg.'.$this->message->wall_id];
    }
}
