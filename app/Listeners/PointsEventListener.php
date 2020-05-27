<?php

namespace App\Listeners;

use App\Events\PointsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PointsEventListener
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
     * @param  PointsEvent  $event
     * @return void
     */
    public function handle(PointsEvent $event)
    {
        //
    }
}
