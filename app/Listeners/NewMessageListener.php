<?php

namespace App\Listeners;

use App\Events\NewMessageEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class NewMessageListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewMesageEvent  $event
     * @return void
     */
    public function handle(NewMessageEvent $event)
    {
        //$event
    }
}
