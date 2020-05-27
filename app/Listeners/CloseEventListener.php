<?php

namespace App\Listeners;

use App\Events\CloseEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CloseEventListener
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
     * @param  CloseEvent  $event
     * @return void
     */
    public function handle(CloseEvent $event)
    {
        //
    }
}
