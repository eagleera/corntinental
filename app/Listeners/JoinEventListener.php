<?php

namespace App\Listeners;

use App\Events\JoinEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class JoinEventListener
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
     * @param  JoinEvent  $event
     * @return void
     */
    public function handle(JoinEvent $event)
    {
        //
    }
}
