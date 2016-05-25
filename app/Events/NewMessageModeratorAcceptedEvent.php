<?php

namespace App\Events;

use App\Message;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewMessageModeratorAcceptedEvent extends Event implements ShouldBroadcastNow
{
    use SerializesModels;
    /**
     * Create a new event instance.
     *
     * @return void
     */
     public $message;
     public $user;
     public $wall;
     public $question;
    public function __construct(Message $message)
    {
      $this->message = $message;
      $this->user = $message->user;
      $this->wall = $message->wall;
      $this->question = Message::find($message->question_id);
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['msg1.moda.msg.'.$this->message->wall_id];
    }
}
