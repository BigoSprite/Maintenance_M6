<?php

namespace App\Listeners;

use App\Events\RealEstateRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RealEstateRegisteredListener
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RealEstateRegistered  $event
     * @return void
     */
    public function handle(RealEstateRegistered $event)
    {

        var_dump('listener has been notified!');

        // 停止事件被传播到其它监听器
        // return false;
    }
}
