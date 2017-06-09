<?php

namespace App\Events;

use App\Events\Contracts\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RealEstateInfoChanged extends Event
{
    use SerializesModels;

    public function __construct(array $data, int $type)
    {
        parent::__construct($data, $type);
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
