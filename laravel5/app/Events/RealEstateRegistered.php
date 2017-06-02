<?php

namespace App\Events;

use App\Events\Event;
use App\Http\Controllers\Handlers\NodeInfoHandler;
use App\Models\RealEstateInfoModel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Repositories\RealEstateInfoRepository as RealEstateMgr;

class RealEstateRegistered extends Event
{
    use SerializesModels;

    public $realEstateMgr;

    /**
     * Create a new event instance.
     * @param RealEstateMgr $realEstateMgr
     */
    public function __construct(/*RealEstateMgr $realEstateMgr*/)
    {
//        $this->realEstateMgr = $realEstateMgr;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
