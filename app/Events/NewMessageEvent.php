<?php

namespace App\Events;

use App\Events\Event;
use App\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewMessageEvent extends Event implements ShouldBroadcastNow
{
    use SerializesModels;

    public $message;
    public $user;
    public $wall;
    public $question;
    /**
     * Create a new event instance.
     *
     * @return void
     */
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
        //$string = 'msg1.msg.'.$this->message->wall_id;
        //dd($string);
        //dd($this->message);
        return ['msg1.msg.'.$this->message->wall_id];
    }
}
